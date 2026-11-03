
# 🎓 Student CRUD Application

PHP, MySQL va Bootstrap 5.3 yordamida ishlab chiqilgan talabalarni boshqarish web-ilovasi.

## 📌 Loyiha haqida

Student CRUD — talabalar ma'lumotlarini boshqarish uchun mo'ljallangan web-ilova.

Ushbu loyiha orqali talabalar haqidagi ma'lumotlarni qo'shish, ko'rish, tahrirlash va o'chirish mumkin.

Loyiha PHP dasturlash tilida, MySQL ma'lumotlar bazasi bilan bog'langan holda ishlab chiqilgan.

## 🚀 Texnologiyalar

- PHP 8.x
- MySQL
- HTML5
- CSS3
- Bootstrap 5.3
- JavaScript
- XAMPP

## ✨ Asosiy imkoniyatlar

- ➕ Yangi talaba qo'shish
- 📋 Barcha talabalar ro'yxatini ko'rish
- ✏️ Talaba ma'lumotlarini tahrirlash
- 🗑️ Talabani o'chirish
- 📷 Talaba rasmini saqlash
- 📅 Tug'ilgan sanani saqlash
- 📱 Responsive dizayn

## 📂 Loyiha strukturasi

```text
student-crud/
│
├── css/
│   └── bootstrap.css
│
├── images/
│   └── student.jpg
│
├── index.php
├── add.php
├── edit.php
├── delete.php
├── db.php
├── database.sql
└── README.md
```

## 🗄️ Database Setup

Loyihada MySQL ma'lumotlar bazasidan foydalaniladi.

Database nomi: `student`

Jadval nomi: `students`

### 1. Database yaratish

MySQL yoki phpMyAdmin orqali quyidagi SQL kodni bajaring.

```sql
CREATE DATABASE IF NOT EXISTS student
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE student;

CREATE TABLE IF NOT EXISTS students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lname VARCHAR(100) NOT NULL,
    fname VARCHAR(100) NOT NULL,
    patronymic VARCHAR(100) NOT NULL,
    birthdate DATE NOT NULL,
    photo VARCHAR(255) DEFAULT NULL
);
```

### 2. Boshlang'ich ma'lumotlarni kiritish

```sql
INSERT INTO students
    (lname, fname, patronymic, birthdate, photo)
VALUES
    ('Olimov', 'Olim', 'Olimovich', '1999-12-20', 'student.jpg'),
    ('Zolimov', 'Zolim', 'Zolimovich', '2000-05-15', 'student.jpg'),
    ('Aliyev', 'Ali', 'Aliyevich', '2001-03-10', 'student.jpg'),
    ('Valiyev', 'Vali', 'Valiyevich', '2000-08-22', 'student.jpg'),
    ('Karimov', 'Karim', 'Karimovich', '2002-01-12', 'student.jpg'),
    ('Salimov', 'Salim', 'Salimovich', '2001-07-18', 'student.jpg');
```

### 3. Ma'lumotlarni tekshirish

```sql
SELECT * FROM students;
```

## ⚙️ O'rnatish va ishga tushirish

### 1-qadam. Loyihani yuklab olish

Git orqali loyihani yuklab oling:

```bash
git clone https://github.com/USERNAME/student-crud.git
```

Yoki GitHub orqali ZIP formatida yuklab oling.

### 2-qadam. XAMPP sozlamalari

XAMPP dasturini oching va quyidagi xizmatlarni ishga tushiring:

- Apache
- MySQL

Loyihani XAMPP ning `htdocs` papkasiga joylashtiring.

Masalan:

```text
C:/xampp/htdocs/student-crud/
```

### 3-qadam. Database yaratish

Brauzerda phpMyAdmin sahifasini oching:

```text
http://localhost/phpmyadmin/
```

SQL bo'limiga o'ting va yuqoridagi SQL kodlarni bajaring.

### 4-qadam. Database bilan bog'lanish

`db.php` faylida quyidagi koddan foydalaning:

```php
<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "student"
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>
```

### 5-qadam. Loyihani ishga tushirish

Brauzerda quyidagi manzilni oching:

```text
http://localhost/student-crud/
```

## 📊 Database jadvali

`students` jadvali quyidagi ustunlardan tashkil topgan:

| Ustun | Ma'lumot turi | Tavsifi |
|---|---|---|
| id | INT | Talaba ID raqami |
| lname | VARCHAR(100) | Familiyasi |
| fname | VARCHAR(100) | Ismi |
| patronymic | VARCHAR(100) | Otasining ismi |
| birthdate | DATE | Tug'ilgan sanasi |
| photo | VARCHAR(255) | Rasm nomi |

## 🔄 CRUD operatsiyalari

CRUD — ma'lumotlar bazasi bilan ishlashning to'rtta asosiy amalidir.

| Amal | Inglizcha | Tavsifi |
|---|---|---|
| C | Create | Ma'lumot qo'shish |
| R | Read | Ma'lumotlarni o'qish |
| U | Update | Ma'lumotlarni yangilash |
| D | Delete | Ma'lumotlarni o'chirish |

## 👨‍💻 Muallif

**Developer:** Your Name

**GitHub:** https://github.com/USERNAME

## 📄 License

This project is licensed under the MIT License.
