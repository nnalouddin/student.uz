<?php
require 'db.php';

// Talabani topish
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

// O‘chirish tugmasi bosilganda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "DELETE FROM students WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit;
    }

    exit("O‘chirishda xatolik.");
}
?>

<!doctype html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Talabani o‘chirish</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/all.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                Student’s CRUD
            </a>
        </div>
    </nav>

    <main class="container page-wrap">
        <h2 class="mb-3">Talabani o‘chirish</h2>

        <div class="card p-4 text-center">
            <h4>Ushbu talabani o‘chirmoqchimisiz?</h4>

            <div class="my-3">
                <img src="img/<?php echo $student['photo'] ?: 'student.jpg'; ?>"
                     alt="Talaba rasmi"
                     width="60"
                     height="70"
                     style="object-fit: cover;">
            </div>

            <p>
                <?php echo $student['lname']; ?>
                <?php echo $student['fname']; ?>
                <?php echo $student['patronymic']; ?>
            </p>

            <form method="post">
                <button type="submit" class="btn btn-danger">
                    O‘chirish
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Bekor qilish
                </a>
            </form>
        </div>
    </main>
</body>

</html>