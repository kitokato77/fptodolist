<?php
include('tasks.php');

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    $task = getTaskById($task_id);

    if ($task) {
        echo "<p><strong>Judul:</strong> {$task['title']}</p>";
        echo "<p><strong>Deskripsi:</strong> {$task['description']}</p>";
        echo "<p><strong>Deadline:</strong> {$task['deadline']}</p>";
    } else {
        echo "Tugas tidak ditemukan.";
    }
} else {
    echo "Parameter task_id tidak ditemukan.";
}
?>
