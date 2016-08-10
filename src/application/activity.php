<?php
include('/models/dubiousactivities.php');

// Check if the timezone offset parameter is numeric and sane.
if (! isset($_GET['offset']) || ! is_numeric($_GET['offset']) || $_GET['offset'] > 100000) {
	// Send a HTTP 400: Bad Request status for non-numeric input.
	header('X-PHP-Response-Code: 400', true, 400);
	exit;
}

// Get an activity from the database
$activity = DubiousActivity::getDubiousActivity(intval($_GET['offset']));

// Encode as JSON and echo.
$result = array('activity' => $activity);
echo json_encode($result);