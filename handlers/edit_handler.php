<?php
include '../database/db_connection.php';
session_start();
require '../jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $date = $_POST['date'];
    $price = intval($_POST['price']);
    $type = $_POST['type'];

    $db = connectDatabase();

    $stmt = $db->prepare("UPDATE cameras SET name = :name, date = :date, price = :price, type = :type WHERE id = :id");
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':price', $price, SQLITE3_INTEGER);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();

    $db = null;

    header("Location: ../index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>