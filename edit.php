<?php
include('tasks.php');

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    $task = getTaskById($task_id);

    if (!$task) {
        echo "Tugas tidak ditemukan.";
        exit();
    }
} else {
    echo "Parameter task_id tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Tugas</h1>

        <form action="process.php" method="post">
            <input type="hidden" name="task_id" value="<?php echo $task['task_id']; ?>">

            <div class="form-group">
                <label for="title">Judul:</label>
                <input type="text" name="title" value="<?php echo $task['title']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea name="description" class="form-control"><?php echo $task['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline:</label>
                <input type="date" name="deadline" value="<?php echo $task['deadline']; ?>" class="form-control">
            </div>

            <button type="submit" name="edit_task" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
