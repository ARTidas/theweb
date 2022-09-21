<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class ActorAttributeDao extends CommonDao {

    /* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function get(array $parameters = null) {
			$where_values = [];

			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				SELECT
					*
				FROM
					actor_attributes
          -- INNER JOIN actors
            -- ON actor_attributes.actor_id = actors.id
				WHERE
					actor_attributes.is_active = 1
			";

			if (!is_null($parameters)) {
				foreach ($parameters['where'] as $key => $value) {
					$where_values[] = $value;
					$query_string .= "
						AND $key = ?
					";
				}
			}


			$query_string .=	"	ORDER BY
					-- created_at DESC
          -- actor_attributes.name ASC
					actor_attributes.sort_order ASC
			";

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
		function create(AbstractDo $do) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				INSERT INTO
					actor_attributes
				SET
          actor_id    = ?,
					name        = ?,
          data_type   = ?,
					form_type   = ?,
					form_source = ?,
          description = ?,
					sort_order  = ?,
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
					actor_attributes
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
