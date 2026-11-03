<?php
require 'db.php';

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

if (!$result) {
    exit("Talabalarni olishda xatolik yuz berdi.");
}
?>

<!doctype html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student’s CRUD</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/all.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container py-2">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo_tersu.png" alt="TerDU" width="38" class="me-2">
                Student’s CRUD
            </a>
        </div>
    </nav>

    <main class="container page-wrap">
        <h2 class="mb-3">Talabalar ro‘yxati</h2>

        <a href="add.php" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add
        </a>

        <div class="card p-3 mt-3">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>TR</th>
                            <th>Rasmi</th>
                            <th>Familiyasi</th>
                            <th>Ismi</th>
                            <th>Sharifi</th>
                            <th>Tug‘ilgan sanasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $tr = 1;

                        while ($student = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $tr++; ?></td>

                            <td>
                                <img src="img/<?php echo $student['photo'] ?: 'student.jpg'; ?>" alt="Talaba rasmi"
                                    class="photo">
                            </td>

                            <td><?php echo $student['lname']; ?></td>
                            <td><?php echo $student['fname']; ?></td>
                            <td><?php echo $student['patronymic']; ?></td>

                            <td>
                                <?php
                                    echo date(
                                        'd.m.Y',
                                        strtotime($student['birthdate'])
                                    );
                                    ?>
                            </td>

                            <td class="actions">
                                <a href="update.php?id=<?php echo (int)$student['id']; ?>"
                                    class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-arrows-rotate me-2"></i>Update
                                </a>

                                <a href="view.php?id=<?php echo (int)$student['id']; ?>" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye me-2"></i>View
                                </a>

                                <a href="delete.php?id=<?php echo (int)$student['id']; ?>"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash me-2"></i>Delete
                                </a>
                            </td>
                        </tr>
                        <?php } ?>

                        <?php if (mysqli_num_rows($result) === 0) { ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                Hozircha talabalar yo‘q.
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>