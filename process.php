<?php
include('tasks.php');

if (isset($_POST['add_task'])) {
    // Menyimpan Tugas Baru
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    if (saveTask($title, $description, $deadline)) {
        header('Location: index.php');
    } else {
        echo "Gagal menambahkan tugas.";
    }
}

if (isset($_GET['delete_id'])) {
    // Menghapus Tugas
    $task_id = $_GET['delete_id'];

    if (deleteTask($task_id)) {
        header('Location: index.php');
    } else {
        echo "Gagal menghapus tugas.";
    }
}

if (isset($_POST['edit_task'])) {
    // Mengupdate Tugas
    $task_id = $_POST['task_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    if (updateTask($task_id, $title, $description, $deadline)) {
        header('Location: index.php');
    } else {
        echo "Gagal menyimpan perubahan tugas.";
    }
}

// Menandai tugas sebagai selesai
if (isset($_GET['complete_id'])) {
    $task_id = $_GET['complete_id'];

    if (completeTask($task_id)) {
        header('Location: index.php');
    } else {
        echo "Gagal menandai tugas sebagai selesai.";
    }
}

?>
