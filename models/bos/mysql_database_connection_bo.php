<?php
	/* ********************************************************
	 * ********************************************************
	 * ********************************************************/
	class MysqlDatabaseBo {
		/* ********************************************************
		 * ********************************************************
		 * ********************************************************/
		function getConnection() {
			$host          = 'localhost';
			$database_name = 'theweb';
			$user_name     = 'theweb';
			$user_password = '54oZZhSK+i!pKV!!5%%sQ5ORFUpLVQ6ef(Orlxf!Fw7UgqSd0jTIow@PseI*y#2n';

			try {
				$connection = new PDO(
					'mysql:host=' . $host . ';dbname=' . $database_name,
					$user_name,
					$user_password
				);
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $exception) {
				throw new Exception('Connection failed: ' . $exception->getMessage());
			}

			return $connection;
		}
	}
?>
