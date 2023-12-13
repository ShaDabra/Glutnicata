<?php

$servername = "localhost";
$username = "вашето_потребителско_име";
$password = "вашата_парола";
$dbname = "vacation_manager";  // Името на базата данни, която създадохте

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$currentUserRole = "CEO"; // По-реално тук бихте получавали ролята на текущия потребител от базата данни или друг механизъм за аутентикация
// Регистрация на потребител
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $group = $_POST['group'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Хеширане на паролата

    $sql = "INSERT INTO users (first_name, last_name, username, password, role, group_name)
            VALUES ('$firstName', '$lastName', '$username', '$hashedPassword', '$role', '$group')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Преглед на всички потребители
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
        }
    } else {
        echo "0 results";
    }
}

// Актуализация на потребител
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putData);
    $id = $putData['id'];
    $firstName = $putData['firstName'];
    $lastName = $putData['lastName'];
    $username = $putData['username'];
    $password = $putData['password'];
    $role = $putData['role'];
    $group = $putData['group'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET first_name='$firstName', last_name='$lastName', username='$username', password='$hashedPassword', role='$role', group_name='$group' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Изтриване на потребител
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteData);
    $id = $deleteData['id'];

    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
