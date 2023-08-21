<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$mysqli = new mysqli("localhost", "root", "", "app");

function saveMessage($username, $message) {
    global $mysqli;
    $query = "INSERT INTO chat (username, message) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $username, $message);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $message = $_POST['message'];

    if ($username && $message) {
        saveMessage($username, $message);
    }

    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM chat ORDER BY timestamp ASC";
$result = $mysqli->query($query);

$messages = array();

while ($row = $result->fetch_assoc()) {
    $timestamp = date('Y-m-d', strtotime($row['timestamp']));
    $time = date('H:i:s', strtotime($row['timestamp']));
    $username = htmlspecialchars($row['username']);
    $text = htmlspecialchars($row['message']);

    $messages[] = array('timestamp' => $timestamp, 'time' => $time, 'username' => $username, 'text' => $text);
}

header('Content-Type: application/json');
echo json_encode($messages);
