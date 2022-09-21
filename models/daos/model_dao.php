<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ModelDao {
    protected $actor = null;

    /* ********************************************************
		 * ********************************************************
		 * ********************************************************/
    function __construct(
      MysqlDatabaseBo $database_connection_bo,
      array $actor,
      array $actor_attributes
    ) {
      $this->database_connection_bo = $database_connection_bo;
      $this->actor                  = $actor;
      $this->actor_attributes       = $actor_attributes;
    }

    /* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function get(array $parameters = null) {
			$where_values    = [];
      $main_table_name = StringHelper::getSpacesReplacedWithUnderScores($this->actor['name_plural']);

			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				SELECT
					" . $main_table_name . ".*
      ";
      foreach ($this->actor_attributes as $key => $actor_attribute) {
        if ($actor_attribute['form_source'] === ActorAttributeBo::VALUE_FORM_SOURCE_ACTOR) {
          $side_table_name     = StringHelper::getActorTableNameFromIdActorAttributeName($actor_attribute['name']);
          $actor_singular_name = StringHelper::getActorNameFromIdActorAttributeName($actor_attribute['name']);
          $query_string .= ",
            " . $side_table_name . ".id   AS '" . $actor_singular_name . "_id',
            " . $side_table_name . ".name AS '" . $actor_singular_name . "_name'
          ";
        };
      };
      $query_string .= "
				FROM
			";
      $query_string .= $main_table_name;
      $i = 1;
      foreach ($this->actor_attributes as $key => $actor_attribute) {
        if ($i === 1) {
          $query_string .= ' ';
        };
				# TODO: Vacillating to use INNER or LEFT join here... [artidas]
        if ($actor_attribute['form_source'] === ActorAttributeBo::VALUE_FORM_SOURCE_ACTOR) {
          $side_table_name = StringHelper::getActorTableNameFromIdActorAttributeName($actor_attribute['name']);
          $query_string .= "
            LEFT JOIN " . $side_table_name . "
              ON " . $main_table_name . "." . $actor_attribute['name'] . " =
                " . $side_table_name . ".id
          ";
        };

        $i++;
      };
      $query_string .= "
				WHERE
					" . $main_table_name . ".is_active = 1
			";

			if (!is_null($parameters)) {
				foreach ($parameters['where'] as $key => $value) {
					$where_values[] = $value;
					$query_string .= "
						AND $key = ?
					";
				}
			}

			$query_string .=	" ORDER BY
					-- created_at DESC
          id ASC
			";

      LogHelper::Add('--- BEGIN QUERY:');
      LogHelper::Add($query_string);
      LogHelper::Add('--- END QUERY:');

			try {
				$handler = ($this->database_connection_bo)->getConnection();
				$statement = $handler->prepare($query_string);
				$statement->execute($where_values);

				return $statement->fetchAll();
			}
			catch(Exception $exception) {
				trigger_error('Error: ' . $exception->getMessage());

				return false;
			}
		}

    /* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function create(ModelDo $do) {
      LogHelper::add(__CLASS__ . ':' . 'Creating record in Dao...');
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				INSERT INTO
      ";
      $query_string .= StringHelper::getSpacesReplacedWithUnderScores($this->actor['name_plural']);
      $query_string .= "
				SET
			";

      LogHelper::add(__CLASS__ . ':' . 'Preparing parameters for set...');
      foreach ($this->actor_attributes as $actor_attribute) {
        LogHelper::add(__CLASS__ . ':' . 'Parameter: ' . $actor_attribute['name']);
        $query_string .= $actor_attribute['name'] . ' = ?, ';
      };
      LogHelper::add(__CLASS__ . ':' . 'Setting parameters...');

      $query_string .= "
				is_active   = 1,
				created_at  = NOW(),
				updated_at  = NOW()
			";

      try {
				$database_connection = ($this->database_connection_bo)->getConnection();
				$database_connection
					->prepare($query_string)
					->execute(
						(
							array_map(
								function($value) {
									return $value === '' ? NULL : $value;
								},
								$do->getCreateParameters()
							)
						)
					)
				;

				return(
					$database_connection->lastInsertId()
				);
			}
			catch(Exception $exception) {
				trigger_error('Error: ' . $exception->getMessage());

				return false;
			}
    }

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function delete($parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				UPDATE
      ";
      $query_string .= StringHelper::getSpacesReplacedWithUnderScores($this->actor['name_plural']);
      $query_string .= "
				SET
					is_active  = 0,
					updated_at = NOW()
				WHERE
					id = ?
			";

			try {
				return(
					($this->database_connection_bo)->getConnection()
						->prepare($query_string)
						->execute(
							(
								array_map(
									function($value) {
										return $value === '' ? NULL : $value;
									},
									$parameters
								)
							)
						)
				);
			}
			catch(Exception $exception) {
				trigger_error('Error: ' . $exception->getMessage());

				return false;
			}
		}
  }
?>
