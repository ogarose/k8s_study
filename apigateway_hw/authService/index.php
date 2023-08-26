<?php

$db = new PDO('sqlite:/tmp/auth.db');

// Set PDO attributes for error handling
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

createTable($db);

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'] ?? '/';



// Handle create user request
if ($method === 'POST' && $path === '/register-user') {
    $inputStream = file_get_contents('php://input');
    $requestBody = json_decode($inputStream, true);
    $username = $requestBody['username'];
    $password = $requestBody['password'];

    if (empty($username) || empty($password)) {
        throw new RuntimeException('Username and password are required. ' + $inputStream);
    }

    $stmt = $db->prepare("INSERT INTO users (username, password)
                           VALUES (?, ?)");

    // Bind the parameter values
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $password);
    $stmt->execute();

    // Prepare the SQL statement
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? limit 1");

    // Bind the parameter value
    $stmt->bindParam(1, $username);

    // Execute the SQL statement
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Execute the SQL statement
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode($user);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to register user']);
    }
} elseif ($method === 'POST' && $path === '/login') {
    $inputStream = file_get_contents('php://input');
    $requestBody = json_decode($inputStream, true);
    $username = $requestBody['username'];
    $password = $requestBody['password'];

    if (empty($username) || empty($password)) {
        throw new RuntimeException('Username and password are required. ' + $inputStream);
    }

    // Prepare the SQL statement
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ? limit 1");

    // Bind the parameter value
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $password);

    // Execute the SQL statement
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Execute the SQL statement
    if ($stmt->execute()) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        http_response_code(200);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Failed to login user']);
    }
}elseif ($method === 'GET' && $path === '/users') {
    // Prepare the SQL statement
    $stmt = $db->prepare("SELECT * FROM users");

    // Execute the SQL statement
    $stmt->execute();

    // Fetch the user data
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo json_encode($users);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'no users']);
    }
} elseif ($path === '/auth') {
    session_start();
    if (isset($_SESSION['user_id'])) {
        http_response_code(200);
        header("x-user-id: " . $_SESSION['user_id']);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'User is not logged in']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found', 'method' => $method, 'path' => $path]);
}

function createTable(PDO $pdo) {

    // Create the users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            username VARCHAR(256) NOT NULL,
            password VARCHAR(256) NOT NULL
        )
    ");
}