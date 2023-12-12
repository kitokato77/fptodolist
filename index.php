<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">To-Do List</h1>

         <!-- Form Tambah Tugas -->
            <form action="process.php" method="post">
            <label for="title">Judul:</label>
            <input type="text" name="title" required>

            <label for="description">Deskripsi:</label>
            <textarea name="description"></textarea>

            <label for="deadline">Deadline:</label>
            <input type="date" name="deadline">

            <button type="submit" name="add_task">Tambah Tugas</button>
        </form>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="filter">Filter Tugas:</label>
                <select id="filter" class="form-control" onchange="filterTasks()">
                    <option value="all">Semua Tugas</option>
                    <option value="incomplete">Belum Selesai</option>
                    <option value="completed">Selesai</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="sort">Sortir Tugas:</label>
                <select id="sort" class="form-control" onchange="sortTasks()">
                    <option value="name">Nama</option>
                    <option value="deadline">Tanggal Deadline</option>
                </select>
            </div>
        </div>

<!-- Daftar Tugas Belum Selesai -->
<ul id="incompleteTasks" class="list-group mb-4">
<h2>Belum Selesai</h2>
    <?php
    include('tasks.php');
    // Menampilkan daftar tugas yang belum selesai
    $incompleteTasks = getTasks(0);

    foreach ($incompleteTasks as $task) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center' onclick=\"showTaskDetails('{$task['title']}', '{$task['description']}', '{$task['deadline']}')\">";
        echo "<span class='task-title'>{$task['title']}</span>";
        echo "<span class='task-deadline'>Deadline: {$task['deadline']}</span>";
        echo "<div>";
        echo "<a href='edit.php?task_id={$task['task_id']}' class='btn btn-sm btn-info mr-2'>Edit</a>";
        echo "<a href='process.php?delete_id={$task['task_id']}' class='btn btn-sm btn-danger'>Hapus</a>";
        echo "<a href='process.php?complete_id={$task['task_id']}' class='btn btn-sm btn-success ml-2'>Selesai</a>";
        echo "</div>";
        echo "</li>";
    }
    ?>
</ul>

<!-- Daftar Tugas Selesai -->
<ul id="completedTasks" class="list-group">
<h2>Selesai</h2>
    <?php
    // Menampilkan daftar tugas yang sudah selesai
    $completedTasks = getTasks(1);

    foreach ($completedTasks as $task) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center' onclick=\"showTaskDetails('{$task['title']}', '{$task['description']}', '{$task['deadline']}')\">";
        echo "<span class='task-title'>{$task['title']}</span>";
        echo "<span class='task-deadline'>Deadline: {$task['deadline']}</span>";
        echo "</li>";
    }
    ?>
</ul>

<!-- Modal untuk menampilkan detail tugas -->
<div class="modal fade" id="taskDetailsModal" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskDetailsModalLabel">Detail Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten modal akan diisi melalui JavaScript -->
            </div>
        </div>
    </div>
</div>

    </div>

    <!-- Script JavaScript untuk filter dan sortir tugas -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function filterTasks() {
            var filterValue = document.getElementById('filter').value;

            if (filterValue === 'all') {
                document.getElementById('incompleteTasks').style.display = 'block';
                document.getElementById('completedTasks').style.display = 'block';
            } else if (filterValue === 'incomplete') {
                document.getElementById('incompleteTasks').style.display = 'block';
                document.getElementById('completedTasks').style.display = 'none';
            } else if (filterValue === 'completed') {
                document.getElementById('incompleteTasks').style.display = 'none';
                document.getElementById('completedTasks').style.display = 'block';
            }
        }

        function sortTasks() {
            var sortValue = document.getElementById('sort').value;

            var incompleteTasksList = document.getElementById('incompleteTasks');
            var completedTasksList = document.getElementById('completedTasks');

            var incompleteTasks = Array.from(incompleteTasksList.children);
            var completedTasks = Array.from(completedTasksList.children);

            if (sortValue === 'name') {
                incompleteTasks.sort((a, b) => {
                    var titleA = a.querySelector('.task-title').textContent.toLowerCase();
                    var titleB = b.querySelector('.task-title').textContent.toLowerCase();
                    return titleA.localeCompare(titleB);
                });

                completedTasks.sort((a, b) => {
                    var titleA = a.querySelector('.task-title').textContent.toLowerCase();
                    var titleB = b.querySelector('.task-title').textContent.toLowerCase();
                    return titleA.localeCompare(titleB);
                });
            } else if (sortValue === 'deadline') {
                incompleteTasks.sort((a, b) => {
                    var deadlineA = new Date(a.querySelector('.task-deadline').textContent);
                    var deadlineB = new Date(b.querySelector('.task-deadline').textContent);
                    return deadlineA - deadlineB;
                });

                completedTasks.sort((a, b) => {
                    var deadlineA = new Date(a.querySelector('.task-deadline').textContent);
                    var deadlineB = new Date(b.querySelector('.task-deadline').textContent);
                    return deadlineA - deadlineB;
                });
            }

            incompleteTasks.forEach(task => incompleteTasksList.appendChild(task));
            completedTasks.forEach(task => completedTasksList.appendChild(task));
        }

        function showTaskDetails(title, description, deadline) {
        var modal = document.getElementById('taskDetailsModal');
        var modalTitle = modal.querySelector('.modal-title');
        var modalBody = modal.querySelector('.modal-body');

        modalTitle.textContent = title;
        modalBody.innerHTML = `<p><strong>Deskripsi:</strong> ${description}</p><p><strong>Deadline:</strong> ${deadline}</p>`;

        $('#taskDetailsModal').modal('show');
        }
    </script>
</body>
</html>

