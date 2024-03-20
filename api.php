<?php

require __DIR__.'/vendor/autoload.php'; // Include the Composer autoloader

use Firebase\JWT\JWT;

// Secret key for JWT
$secret_key = "YOUR_SECRET_KEY";

// Sample user data (this could be fetched from a database)
$users = array(
    array('id' => 1, 'username' => 'user1', 'email' => 'user1@example.com'),
    array('id' => 2, 'username' => 'user2', 'email' => 'user2@example.com'),
    array('id' => 3, 'username' => 'user3', 'email' => 'user3@example.com')
);

// Get the authorization header
$token = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '';

// Check if token is present
if ($token) {
    // Verify JWT token
    try {
        $decoded = JWT::decode($token, $secret_key, array('HS256'));

        // Return list of users if token is valid
        echo json_encode($users);
    } catch (Exception $e) {
        // Return error message if token is invalid
        http_response_code(401);
        echo json_encode(array(
            "message" => "Unauthorized access.",
            "error" => $e->getMessage()
        ));
    }
} else {
    // Return error message if token is missing
    http_response_code(401);
    echo json_encode(array("message" => "Token is missing."));
}
?>
