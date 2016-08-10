<?php
class DB {
	/**
	 * Connects to the MySQL database for this project.
	 */
	public static function connect() {
		return new mysqli('${db.hostname}', '${db.username}', '${db.password}', '${db.database}');
	}

	/**
	 * Executes a query, using prepared statements.
	 * @param unknown $connection An open database connection.
	 * @param unknown $query The query to execute, with placeholder ? characters for parameters.
	 * @param unknown $params
	 */
	public static function query($connection, $query, $param_types, $params) {
		// Create a prepared statement with bound parameters.
		$statement = $connection->prepare($query);

		// Bind parameters.
		// Workaround for not being able to call bind_param with an array - see http://no2.php.net/manual/en/mysqli-stmt.bind-param.php#89171
		call_user_func_array('mysqli_stmt_bind_param', array_merge(array($statement, $param_types), $params));

		// Execute the statement and return the result.
		$statement->execute();
		return $statement->get_result();
	}

	/**
	 * Closes the given database connection.
	 * @param unknown $connection
	 */
	public static function close_connection($connection) {
		return mysqli_close($connection);
	}
}