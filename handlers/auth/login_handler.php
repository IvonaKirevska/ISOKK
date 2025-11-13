<?php
session_start();

require '../../database/db_connection.php';
require '../../jwt_helper.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $db = connectDatabase();

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $token = createJWT($user['id'], $user['username']);

        session_regenerate_id(true);

        $_SESSION['jwt'] = $token;

        header('Location: ../../index.php');
        exit;
    } else {
        echo "Username or password invalid.<br>";
        echo "<a href='../../pages/auth/login.php'><button>Try again</button></a>";
        exit;
    }
}
?>