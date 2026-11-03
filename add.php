<?php
require 'db.php';

$error = "";

// Bazadagi xatolarni o‘zimiz tekshiramiz
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Formadan ma’lumotlarni olish
    $lname = trim($_POST['lname'] ?? '');
    $fname = trim($_POST['fname'] ?? '');
    $patronymic = trim($_POST['patronymic'] ?? '');
    $birthdate = $_POST['birthdate'] ?? '';

    // Rasm tanlanmasa ishlatiladigan nom
    $photo = "student.jpg";
    $uploadedPath = "";

    if (
        $lname === '' ||
        $fname === '' ||
        $patronymic === '' ||
        $birthdate === ''
    ) {
        $error = "Barcha matnli maydonlarni to‘ldiring.";
    }

    // Rasm tanlangan bo‘lsa, tekshiramiz va yuklaymiz
    if ($error === "" && isset($_FILES['photo'])) {

        $file = $_FILES['photo'];

        if ($file['error'] !== UPLOAD_ERR_NO_FILE) {

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $error = "Rasmni yuklashda xatolik yuz berdi.";
            }

            elseif ($file['size'] > 2 * 1024 * 1024) {
                $error = "Rasm hajmi 2 MB dan oshmasin.";
            }

            else {
                // Faylning haqiqiy turini aniqlash
                $info = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($info, $file['tmp_name']);
                finfo_close($info);

                $types = [
                    'image/jpeg' => 'jpg',
                    'image/png'  => 'png',
                    'image/webp' => 'webp'
                ];

                if (
                    !isset($types[$mime]) ||
                    @getimagesize($file['tmp_name']) === false
                ) {
                    $error = "Faqat JPG, PNG yoki WEBP rasm tanlang.";
                }

                else {
                    // Har bir rasmga noyob nom berish
                    $extension = $types[$mime];
                    $photo = bin2hex(random_bytes(16)) . "." . $extension;

                    $folder = __DIR__ . "/img/";
                    $uploadedPath = $folder . $photo;

                    if (!is_dir($folder)) {
                        $error = "Loyiha ichida img papkasini yarating.";
                    }

                    elseif (
                        !move_uploaded_file(
                            $file['tmp_name'],
                            $uploadedPath
                        )
                    ) {
                        $error = "Rasmni img papkasiga saqlab bo‘lmadi.";
                        $uploadedPath = "";
                    }
                }
            }
        }
    }

    // Xatolik bo‘lmasa, talabani bazaga yozamiz
    if ($error === "") {

        $sql = "INSERT INTO students
                (lname, fname, patronymic, birthdate, photo)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        $saved = false;

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssss",
                $lname,
                $fname,
                $patronymic,
                $birthdate,
                $photo
            );

            $saved = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        if ($saved) {
            header("Location: index.php");
            exit;
        }

        // Bazaga yozilmasa, yangi yuklangan rasmni olib tashlaymiz
        if ($uploadedPath !== "" && is_file($uploadedPath)) {
            unlink($uploadedPath);
        }

        $error = "Talabani bazaga saqlashda xatolik yuz berdi.";
    }
}
?>

<!doctype html>
<html lang="uz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Talaba qo‘shish — Student’s CRUD</title>

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
        <h2 class="mb-3">Talaba qo‘shish</h2>

        <div class="card p-4">

            <?php if ($error !== "") { ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <form action="add.php"
                  method="post"
                  enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="lname" class="form-label">
                        Familiyasi
                    </label>

                    <input type="text"
                           class="form-control"
                           id="lname"
                           name="lname"
                           maxlength="100"
                           placeholder="Familiyasini kiriting"
                           required>
                </div>

                <div class="mb-3">
                    <label for="fname" class="form-label">
                        Ismi
                    </label>

                    <input type="text"
                           class="form-control"
                           id="fname"
                           name="fname"
                           maxlength="100"
                           placeholder="Ismini kiriting"
                           required>
                </div>

                <div class="mb-3">
                    <label for="patronymic" class="form-label">
                        Sharifi
                    </label>

                    <input type="text"
                           class="form-control"
                           id="patronymic"
                           name="patronymic"
                           maxlength="100"
                           placeholder="Otasining ismini kiriting"
                           required>
                </div>

                <div class="mb-3">
                    <label for="birthdate" class="form-label">
                        Tug‘ilgan sanasi
                    </label>

                    <input type="date"
                           class="form-control"
                           id="birthdate"
                           name="birthdate"
                           min="1900-01-01"
                           max="<?php echo date('Y-m-d'); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">
                        Talabaning rasmi
                    </label>

                    <input type="file"
                           class="form-control"
                           id="photo"
                           name="photo"
                           accept="image/jpeg,image/png,image/webp">

                    <div class="form-text">
                        JPG, PNG yoki WEBP; 2 MB gacha.
                        Tanlanmasa, student.jpg ishlatiladi.
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Saqlash
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        <i class="fa-solid fa-xmark me-2"></i>Bekor qilish
                    </a>
                </div>

            </form>
        </div>
    </main>
</body>

</html>