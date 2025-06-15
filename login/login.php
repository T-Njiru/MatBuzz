<?php
session_start();
require_once 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($email) || empty($password) || empty($role)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    $table = $role === 'commuter' ? 'Passenger' : 'Owner';

    $stmt = $conn->prepare("SELECT * FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user[$role === 'commuter' ? 'passenger_id' : 'owner_id'];
            $_SESSION['role'] = $role;
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
