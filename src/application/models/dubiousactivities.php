<?php
include_once('/../db.php');

class DubiousActivity {
	/**
	 * Gets a time string from the database, taking into account the client's offset from UTC.
	 * @param int $utcOffset The offset from UTC, in minutes (i.e. UTC + X mins).
	 */
	public static function getDubiousActivity($utcOffset) {
		$time = time() + ($utcOffset * 60); // Get localised timestamp.
		$timeOfDay = $time % 86400; // Convert to secs since midnight by modding the number of seconds in a day.

		$db = DB::connect();
		$db_result = DB::query($db, 'SELECT * FROM activities WHERE start <= ? AND end >= ? ORDER BY RAND() LIMIT 1', 'ii', array(&$utcOffset, &$utcOffset));
		DB::close_connection($db);

		$result = $db_result->fetch_assoc();

		return $result['string'];
	}
}