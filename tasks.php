<?php
include('koneksi.php');

// Menyimpan Tugas Baru
function saveTask($title, $description, $deadline) {
    global $conn;

    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);
    $deadline = mysqli_real_escape_string($conn, $deadline);

    $query = "INSERT INTO Tasks (title, description, deadline) VALUES ('$title', '$description', '$deadline')";

    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Mengupdate Tugas
function updateTask($task_id, $title, $description, $deadline) {
    global $conn;

    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);
    $deadline = mysqli_real_escape_string($conn, $deadline);

    $query = "UPDATE Tasks SET title='$title', description='$description', deadline='$deadline' WHERE task_id=$task_id";

    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Menghapus Tugas
function deleteTask($task_id) {
    global $conn;

    $query = "DELETE FROM Tasks WHERE task_id=$task_id";

    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Mengambil Daftar Tugas
function getTasks($status = null, $deadline = null) {
    global $conn;

    $whereClause = '';

    if ($status !== null) {
        $whereClause .= "completed=$status AND ";
    }

    if ($deadline !== null) {
        $whereClause .= "deadline='$deadline' AND ";
    }

    $whereClause = rtrim($whereClause, " AND ");

    $query = "SELECT * FROM Tasks";

    if (!empty($whereClause)) {
        $query .= " WHERE $whereClause";
    }

    $result = $conn->query($query);

    $tasks = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }

    return $tasks;
}

// Menangani Akses Database
function closeConnection() {
    global $conn;
    $conn->close();
}

// Mendapatkan Tugas berdasarkan task_id
function getTaskById($task_id) {
    global $conn;

    $task_id = mysqli_real_escape_string($conn, $task_id);

    $query = "SELECT * FROM Tasks WHERE task_id=$task_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Menyelesaikan Tugas
function completeTask($task_id) {
    global $conn;

    $task_id = mysqli_real_escape_string($conn, $task_id);

    $query = "UPDATE Tasks SET completed=1 WHERE task_id=$task_id";

    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}

?>
