<?php
require 'db.php';

// URL orqali talabaning ID raqamini olamiz
$id = (int)($_GET['id'] ?? 0);

$result = mysqli_query(
    $conn,
    "SELECT * FROM students WHERE id = $id"
);

if (!$result) {
    exit("So‘rovda xatolik.");
}

$student = mysqli_fetch_assoc($result);

if (!$student) {
    exit("Talaba topilmadi.");
}
?>

<!doctype html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Talaba ma’lumotlari — Student’s CRUD</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/all.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container py-2">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo_tersu.png"
                     alt="TerDU"
                     width="38"
                     class="me-2">
                Student’s CRUD
            </a>
        </div>
    </nav>

    <main class="container page-wrap">
        <h2 class="mb-3">Talaba ma’lumotlari</h2>

        <div class="card p-4">
            <div class="row g-4">

                <div class="col-md-3 text-center">
                    <img src="img/<?php echo $student['photo'] ?: 'student.jpg'; ?>"
                         alt="Talabaning rasmi"
                         class="img-thumbnail"
                         style="width: 180px; height: 220px; object-fit: cover;">
                </div>

                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td><?php echo (int)$student['id']; ?></td>
                            </tr>

                            <tr>
                                <th>Familiyasi</th>
                                <td><?php echo $student['lname']; ?></td>
                            </tr>

                            <tr>
                                <th>Ismi</th>
                                <td><?php echo $student['fname']; ?></td>
                            </tr>

                            <tr>
                                <th>Sharifi</th>
                                <td><?php echo $student['patronymic']; ?></td>
                            </tr>

                            <tr>
                                <th>Tug‘ilgan sanasi</th>
                                <td>
                                    <?php
                                    echo date(
                                        'd.m.Y',
                                        strtotime($student['birthdate'])
                                    );
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>Orqaga
                        </a>

                        <a href="update.php?id=<?php echo (int)$student['id']; ?>"
                           class="btn btn-success">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Yangilash
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>

</html>