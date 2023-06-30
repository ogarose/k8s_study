<?php

$uri = $_SERVER['REQUEST_URI'];

if (trim($uri, '/') === 'health') {
	$response = [
		'status' => 'OK'
	];

    header('Content-Type: application/json; charset=utf-8');
	echo json_encode($response);
	exit();
}

header("HTTP/1.0 404 Not Found");
exit();
