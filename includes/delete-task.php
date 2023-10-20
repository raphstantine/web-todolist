<?php
$task_id = strip_tags($_POST['task_id']);

require("connect.php");

// Membuat koneksi MySQLi
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));


// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menghapus tugas dari tabel tasks
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->bind_param("i", $task_id);
$stmt->execute();
$stmt->close();

// Menutup koneksi
$conn->close();
?>