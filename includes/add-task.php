<?php
$task = strip_tags($_POST['task']);
$date = date('Y-m-d');
$time = date('H:i:s');

require("connect.php");

// Membuat koneksi MySQLi
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menyisipkan data ke dalam tabel tasks
$stmt = $conn->prepare("INSERT INTO tasks (task, date, time) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $task, $date, $time);
$stmt->execute();

// Mendapatkan ID dan nama tugas yang baru saja dimasukkan
$task_id = $stmt->insert_id;
$stmt->close();

// Mengambil data tugas berdasarkan ID
$query = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
$query->bind_param("i", $task_id);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();
$task_name = $row['task'];

// Menutup koneksi
$conn->close();

// Mengembalikan data dalam format yang diinginkan
echo '<li><span>' . $task_name . '</span><img id="' . $task_id . '" class="delete-button" width="10px" src="images/close.svg" /></li>';
?>
