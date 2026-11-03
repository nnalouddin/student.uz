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

$error = "";

// Yangilash tugmasi bosilganda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lname = trim($_POST['lname'] ?? '');
    $fname = trim($_POST['fname'] ?? '');
    $patronymic = trim($_POST['patronymic'] ?? '');
    $birthdate = $_POST['birthdate'] ?? '';

    $photo = $student['photo'];
    $newPath = "";

    // Yangi rasm tanlangan bo‘lsa
    if (
        isset($_FILES['photo']) &&
        $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE
    ) {
        $file = $_FILES['photo'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = "Rasm yuklanmadi.";
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $error = "Rasm 2 MB dan oshmasin.";
        } else {
            $image = @getimagesize($file['tmp_name']);

            $types = [
                IMAGETYPE_JPEG => 'jpg',
                IMAGETYPE_PNG  => 'png',
                IMAGETYPE_WEBP => 'webp'
            ];

            if (!$image || !isset($types[$image[2]])) {
                $error = "JPG, PNG yoki WEBP rasm tanlang.";
            } else {
                $photo = bin2hex(random_bytes(16))
                       . "." . $types[$image[2]];

                $newPath = __DIR__ . "/img/" . $photo;

                if (!move_uploaded_file($file['tmp_name'], $newPath)) {
                    $error = "Rasmni saqlab bo‘lmadi.";
                    $newPath = "";
                }
            }
        }
    }

    // Ma’lumotlarni yangilash
    if ($error === "") {
        $sql = "UPDATE students
                SET lname=?, fname=?, patronymic=?, birthdate=?, photo=?
                WHERE id=?";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            exit("So‘rov tayyorlanmadi.");
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sssssi",
            $lname,
            $fname,
            $patronymic,
            $birthdate,
            $photo,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit;
        }

        if ($newPath !== "") {
            unlink($newPath);
        }

        $error = "Yangilashda xatolik.";
    }
}
?>

<!doctype html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Talabani yangilash</title>

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
        <h2>Talabani yangilash</h2>

        <div class="card p-4">
            <p class="text-danger"><?php echo $error; ?></p>

            <form method="post" enctype="multipart/form-data">

                <label class="form-label">Familiyasi</label>
                <input class="form-control mb-3"
                       name="lname"
                       value="<?php echo $student['lname']; ?>"
                       maxlength="100"
                       required>

                <label class="form-label">Ismi</label>
                <input class="form-control mb-3"
                       name="fname"
                       value="<?php echo $student['fname']; ?>"
                       maxlength="100"
                       required>

                <label class="form-label">Sharifi</label>
                <input class="form-control mb-3"
                       name="patronymic"
                       value="<?php echo $student['patronymic']; ?>"
                       maxlength="100"
                       required>

                <label class="form-label">Tug‘ilgan sanasi</label>
                <input type="date"
                       class="form-control mb-3"
                       name="birthdate"
                       value="<?php echo $student['birthdate']; ?>"
                       required>

                <p>Hozirgi rasm:</p>
                <img src="img/<?php echo $student['photo'] ?: 'student.jpg'; ?>"
                     alt="Talaba rasmi"
                     width="60"
                     height="70"
                     class="mb-3"
                     style="object-fit: cover;">

                <div class="mb-3">
                    <label class="form-label">Yangi rasm</label>
                    <input type="file"
                           class="form-control"
                           name="photo"
                           accept="image/jpeg,image/png,image/webp">
                </div>

                <button class="btn btn-success" type="submit">
                    Yangilash
                </button>

                <a class="btn btn-secondary" href="index.php">
                    Bekor qilish
                </a>
            </form>
        </div>
    </main>
</body>

</html>