<?php
include '../database/db_connection.php';
session_start();
require '../jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $date = $_POST['date'] ?? '';
    $price = (int) ($_POST['price'] ?? 0);
    $type = $_POST['type'] ?? '';


    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO cameras (name, date, price, type) VALUES (:name, :date, :price, :type)");
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':price', $price, SQLITE3_INTEGER);
    $stmt->bindValue(':type', $type);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error adding camera: " . $db->errorCode();
    }
    $db = null;
} else {
    echo "Invalid request method.";
}
?>