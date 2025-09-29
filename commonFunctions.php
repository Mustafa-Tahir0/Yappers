<?php
// CORS headers to allow frontend requests
$allowed_origins = [
    "http://localhost:3456",
    "http://ec2-54-161-19-75.compute-1.amazonaws.com:3456",
    "http://127.0.0.1:3456"
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
// Include required module for database functions
require 'module6.php';
session_set_cookie_params(0, "/", "", false, true);
session_start(); // Start the session to track user data
header("Content-Type: application/json"); // Set the response type to JSON

// Get the raw POST data as a JSON string and decode it into an associative array
$json_str = file_get_contents('php://input');
$arr = json_decode($json_str, true);

if(isset($arr['checkLogin'])) {
    checkLogin();
}

if(isset($arr['create'])) {
    createUser($mysql, (string) $arr['createUser'], (string) $arr['createPass']);
}

if(isset($arr['login'])) {
    login($mysql, (string) $arr['username'], (string) $arr['password']);
}

if(isset($arr['logout'])) {
    logout();
}

if(isset($arr['push'])) {
    push($mysql, (string) $arr['username'], (string) $arr['room'], (string) $arr['message']);
}

if(isset($arr['get'])) {
    get($mysql, (string) $arr['room']);
}

if(isset($arr['makeRoom'])) {
    makeRoom($mysql, (string) $arr['username'], (string) $arr['password'], (string) $arr['room']);
}

if(isset($arr['rooms'])) {
    getRooms($mysql, (string) $arr['username']);
}

if(isset($arr['hasPassword'])) {
    hasPassword($mysql, (string) $arr['room']);
}

if(isset($arr['checkPassword'])) {
    checkPassword($mysql, (string) $arr['password'], (string) $arr['room']);
}

if(isset($arr['admin'])) {
    isAdmin($mysql, (string) $arr['username'], (string) $arr['room']);
}

if(isset($arr['ban'])) {
    ban($mysql, (string) $arr['username'], (string) $arr['room']);
}

function ban($mysql, $username, $room) {
    $stmt = $mysql->prepare("insert into bans (username, name) values (?, ?)");
    if (!$stmt) {
        // If the query preparation fails, display an error and exit
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }
    $stmt->bind_param('ss', $username, $room);
    $stmt->execute();
    $stmt->close();
    echo json_encode(array(
        "success" => true
    ));
    exit;
}

function isAdmin($mysql, $username, $room) {
    $stmt = $mysql ->prepare("select * from rooms where username = ? and name = ?");
    if (!$stmt) {
        // If query preparation fails, display an error and stop the script
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }
    // Bind the username to the query and execute it
    $stmt->bind_param('ss', $username, $room);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if($result->num_rows > 0) {
        echo json_encode(array(
            "success" => true
        ));
        exit;
    } else {
        echo json_encode(array(
            "success" => false
        ));
        exit;
    }
}

function checkPassword($mysql, $password, $room) {
    // Prepare SQL query to get the hashed password for the provided username
    $stmt = $mysql->prepare("select password from rooms where name = ?");
    if (!$stmt) {
        // If query preparation fails, display an error and stop the script
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }

    // Bind the username to the query and execute it
    $stmt->bind_param('s', $room);
    $stmt->execute();
    
    // Initialize variable to hold the fetched hashed password
    $realPass = "";
    $stmt->bind_result($realPass);
    
    // Verify the password: if the username exists and the password matches
    if ($stmt->fetch() && password_verify($password, $realPass)) {
        // If login is successful, set session variables
        $stmt->close();
        
        echo json_encode(array(
            "success" => true
        ));
        exit;
    } else {
        // If username or password is incorrect, close the statement and return an error message
        $stmt->close();
        echo json_encode(array(
            "success" => false
        ));
        exit;
    }
}

function hasPassword($mysql, $room) {
    $stmt = $mysql->prepare("select password from rooms where name = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }
    $stmt->bind_param('s', $room);
    $stmt->execute();
    $result = $stmt->get_result();
    $password = $result->fetch_assoc();
    $stmt->close();
    echo json_encode(array(
        "success" => $password['password'] != null ? true : false
    ));
    exit;
}
#
function getRooms($mysql, $username) {
    $stmt = $mysql->prepare("select name from rooms where name not in (select name from bans where username = ?)");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    $stmt->close();
    echo json_encode(array(
        "success" => true,
        "rooms" => $rooms
    ));
    exit;
}

function makeRoom($mysql, $username, $password, $room) {
    if($password == "") {
        $stmt = $mysql->prepare("insert into rooms (username, name) values (?, ?)");
        if (!$stmt) {
            // If the query preparation fails, display an error and exit
            printf("Query Prep Failed: %s\n", $mysql->error);
            exit;
        }
        $stmt->bind_param('ss', $username, $room);
        $stmt->execute();
        $stmt->close();
        echo json_encode(array(
            "success" => true
        ));
        exit;
    } else {
        $stmt = $mysql->prepare("insert into rooms (username, name, password) values (?, ?, ?)");
        if (!$stmt) {
            // If the query preparation fails, display an error and exit
            printf("Query Prep Failed: %s\n", $mysql->error);
            exit;
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param('sss', $username, $room, $hashedPassword);
        $stmt->execute();
        $stmt->close();
        echo json_encode(array(
            "success" => true
        ));
        exit;
    }
}

function get($mysql, $room) {
    $stmt = $mysql->prepare("select message from messages where room = ?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }
    $stmt->bind_param('s', $room);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    $stmt->close();
    echo json_encode(array(
        "success" => true,
        "messages" => $messages
    ));
    exit;
}

function push($mysql, $username, $room, $message) {
    $stmt = $mysql->prepare("insert into messages (username, message, room) values (?, ?, ?)");
    if (!$stmt) {
        // If the query preparation fails, display an error and exit
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }
    $stmt->bind_param('sss', $username, $message, $room);
    $stmt->execute();
    $stmt->close();
    echo json_encode(array(
        "success" => true
    ));
    exit;
}

function login($mysql, $username, $password) {
    // Prepare SQL query to get the hashed password for the provided username
    $stmt = $mysql->prepare("select password_hash from users where username = ?");
    if (!$stmt) {
        // If query preparation fails, display an error and stop the script
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }

    // Bind the username to the query and execute it
    $stmt->bind_param('s', $username);
    $stmt->execute();
    
    // Initialize variable to hold the fetched hashed password
    $realPass = "";
    $stmt->bind_result($realPass);
    
    // Verify the password: if the username exists and the password matches
    if ($stmt->fetch() && password_verify($password, $realPass)) {
        // If login is successful, set session variables
        $stmt->close();
        $_SESSION['username'] = $username; // Store username in session
        
        // Return a success response with the CSRF token
        echo json_encode(array(
            "success" => true
        ));
        exit;
    } else {
        // If username or password is incorrect, close the statement and return an error message
        $stmt->close();
        echo json_encode(array(
            "success" => false,
            "message" => "Incorrect Username or Password"
        ));
        exit;
    }
}

function createUser($mysql, $username, $password) {
    // Initialize variable to check if username is already in use
    $inUse = "";

    // Prepare the SQL query to check if the username already exists
    $stmt = $mysql->prepare("select username from users where username = ?");
    if (!$stmt) {
        // If the query preparation fails, display an error and exit
        printf("Query Prep Failed: %s\n", $mysql->error);
        exit;
    }

    // Bind the username parameter and execute the query
    $stmt->bind_param('s', $username);
    $stmt->execute();

    // Bind the result of the query to $inUse
    $stmt->bind_result($inUse);
    
    // Check if a result was returned, meaning the username is already taken
    if ($stmt->fetch()) {
        $stmt->close();
        // Respond with a JSON message indicating the username is taken
        echo json_encode(array(
            "success" => false,
            "message" => "Username taken"
        ));
        exit;
    } else {
        // If username is not taken, proceed to create the new user

        // Prepare the SQL query to insert the new user into the database
        $stmt = $mysql->prepare("insert into users (username, password_hash) values (?, ?)");
        if (!$stmt) {
            // If the query preparation fails, display an error and exit
            printf("Query Prep Failed: %s\n", $mysql->error);
            exit;
        }

        // Hash the password using bcrypt for secure storage
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Bind the username and hashed password to the query and execute it
        $stmt->bind_param('ss', $username, $hashedPassword);
        $stmt->execute();
        $stmt->close();

        // Call the login function to log the user in after account creation
        login($mysql, $username, $password);
        exit;
    }
}

function logout() {
    // Destroy the current session, effectively logging the user out
    session_destroy();
    
    // Return a JSON response indicating the logout was successful
    echo json_encode(array(
        "success" => true // Indicate that the logout was successful
    ));
    
    exit; // End the script execution after sending the response
}

function checkLogin() {
    // Check if the 'username' session variable is set
    if(isset($_SESSION['username'])) {
        // If session exists, return a success response with the username and token
        echo json_encode(array(
            "success" => true, // Indicate the login was successful
            "username" => htmlentities($_SESSION['username']) // Sanitize username
        ));
    } else {
        // If no session exists, return a failure response
        echo json_encode(array(
            "success" => false // Indicate login failure
        ));
    }
    exit; // End the script execution after sending the response
}
?>
