<?php
include '../database/db_connection.php';
require '../jwt_helper.php';

session_start();
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../pages/auth/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db = connectDatabase();

    $stmt = $db->prepare("SELECT * FROM cameras WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();
    $camera = $stmt->fetch();

    $db = null;
} else {
    die("Invalid camera ID.");
}
?>

    <h1>Update Camera</h1>

<?php if ($camera): ?>
    <form action="../handlers/edit_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($camera['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($camera['name']); ?>" required>
        <br>
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($camera['date']); ?>" required>
        <br>
        <label for="amount">Price:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($camera['price']); ?>" required>
        <br>
        <label for="type">Camera type</label>
        <select name="type" id="type">
            <option <?php echo htmlspecialchars($camera['type']) === 'внатрешна' ? 'selected=true' : ''; ?> value="внатрешна">внатрешна</option>
            <option <?php echo htmlspecialchars($camera['type']) === 'надворешна' ? 'selected=true' : ''; ?> value="надворешна">надворешна</option>
        </select>
        <br/>
        <button type="submit">Update Camera</button>
    </form>
<?php else: ?>
    <p>Camera not found.</p>
<?php endif;
?>