
<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $course = trim($_POST["course"]);
    $year = (int) $_POST["year"];

    if ($name != "" && filter_var($email, FILTER_VALIDATE_EMAIL)
        && $course != "" && $year >= 1 && $year <= 4) {

        try {
            $sql = "INSERT INTO students (name, email, course, year)
                    VALUES (:name, :email, :course, :year)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':course' => $course,
                ':year' => $year
            ]);

            echo "<p>Student added successfully!</p>";
        } catch (PDOException $e) {
            echo "<p>Unable to add student. Check whether the email already exists.</p>";
        }
    } else {
        echo "<p>Please enter valid details.</p>";
    }
}

$sql = "SELECT * FROM students ORDER BY student_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            padding: 25px;
        }

        h1, h2 {
            color: #174a7e;
        }

        form, table {
            background: white;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        input, button {
            padding: 10px;
            margin: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #174a7e;
            color: white;
        }
    </style>
</head>
<body>

<h1>StudentHub</h1>
<h2>Add Student</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Student Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="course" placeholder="Course" required>

    <select name="year" required>
        <option value="">Select Year</option>
        <option value="1">First Year</option>
        <option value="2">Second Year</option>
        <option value="3">Third Year</option>
        <option value="4">Fourth Year</option>
    </select>

    <button type="submit">Add Student</button>
</form>

<h2>Student Records</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Year</th>
    </tr>

    <?php foreach ($students as $student) { ?>
    <tr>
        <td><?= htmlspecialchars($student['student_id']) ?></td>
        <td><?= htmlspecialchars($student['name']) ?></td>
        <td><?= htmlspecialchars($student['email']) ?></td>
        <td><?= htmlspecialchars($student['course']) ?></td>
        <td><?= htmlspecialchars($student['year'] ?? 'Not specified') ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
