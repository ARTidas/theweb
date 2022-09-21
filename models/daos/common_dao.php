<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class CommonDao {
		protected $database_connection_bo;

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function __construct($database_connection_bo) {
			$this->database_connection_bo = $database_connection_bo;
		}

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function getEntities() {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				SELECT
					entities.id AS id,
					entities.type AS type,
					'Agency' AS sub_type,
					MAIN.name COLLATE utf8_general_ci AS name
				FROM
					agencies MAIN
					INNER JOIN entities
						ON MAIN.id = entities.table_id AND
							entities.type = 'agency'
				WHERE
					entities.is_active = 1

				UNION ALL

				SELECT
					entities.id AS id,
					entities.type AS type,
					'Customer' AS sub_type,
					MAIN.name COLLATE utf8_general_ci AS name
				FROM
					customers MAIN
					INNER JOIN entities
						ON MAIN.id = entities.table_id AND
							entities.type = 'customers'
				WHERE
					entities.is_active = 1

				UNION ALL

				SELECT
					entities.id AS id,
					entities.type AS type,
					'Property' AS sub_type,
					MAIN.name COLLATE utf8_general_ci AS name
				FROM
					properties MAIN
					INNER JOIN entities
						ON MAIN.id = entities.table_id AND
							entities.type = 'properties'
				WHERE
					entities.is_active = 1

				UNION ALL

				SELECT
					entities.id AS id,
					entities.type AS type,
					'Room' AS sub_type,
					MAIN.name COLLATE utf8_general_ci AS name
				FROM
					rooms MAIN
					INNER JOIN entities
						ON MAIN.id = entities.table_id AND
							entities.type = 'rooms'
				WHERE
					entities.is_active = 1

				UNION ALL

				SELECT
					entities.id AS id,
					entities.type AS type,
					MAIN.type AS sub_type,
					MAIN.name COLLATE utf8_general_ci AS name
				FROM
					partners MAIN
					INNER JOIN entities
						ON MAIN.id = entities.table_id AND
							entities.type = 'partners'
				WHERE
					entities.is_active = 1
			";

			try {
				$handler = ($this->database_connection_bo)->getConnection();
				$statement = $handler->prepare($query_string);
				$statement->execute();

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
		function createEntity($parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				INSERT INTO
					entities
				SET
					type       = ?,
					table_id   = ?,
					is_active  = 1,
					created_at = NOW(),
					updated_at = NOW()
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
								$parameters
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
		function deleteEntity($parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				UPDATE
					entities
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

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function createCustomer($parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				INSERT INTO
					customers
				SET
					name       = ?,
					phone      = ?,
					email      = ?,
					comment    = ?,
					is_active  = 1,
					created_at = NOW(),
					updated_at = NOW()
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
								$parameters
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
		function createPartner($parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				INSERT INTO
					partners
				SET
					name       = ?,
					type       = ?,
					phone      = ?,
					email      = ?,
					comment    = ?,
					is_active  = 1,
					created_at = NOW(),
					updated_at = NOW()
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
								$parameters
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
		function getContacts() {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				SELECT
					*
				FROM
					contacts
				WHERE
					is_active = 1
				ORDER BY
					created_at DESC
			";

			try {
				$handler = ($this->database_connection_bo)->getConnection();
				$statement = $handler->prepare($query_string);
				$statement->execute();

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
		function createContact($parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				INSERT INTO
					contacts
				SET
					name       = ?,
					phone      = ?,
					email      = ?,
					message    = ?,
					is_active  = 1,
					created_at = NOW(),
					updated_at = NOW()
			";

			try {
				return(
					($this->database_connection_bo)
						->getConnection()
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
					)
				;
			}
			catch(Exception $exception) {
				trigger_error('Error: ' . $exception->getMessage());

				return false;
			}
		}

		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function deleteContact($parameters) {
			$query_string = "/* __CLASS__ __FUNCTION__ __FILE__ __LINE__ */
				UPDATE
					contacts
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
