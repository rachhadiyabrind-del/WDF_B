<?php
$name = "";
$email = "";
$mobile = "";
$message = "";
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $mobile = trim($_POST["mobile"]);
    $message = trim($_POST["message"]);

    $name = htmlspecialchars($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $mobile = htmlspecialchars($mobile);
    $message = htmlspecialchars($message);

    if (empty($name) || empty($email) || empty($mobile) || empty($message)) {
        $error = "All fields are required.";
    }
    elseif (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $error = "Name can contain only letters and spaces.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    }
    elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $error = "Mobile number must contain 10 digits.";
    }
    else {

        $file = "records.csv";

        $fp = fopen($file, "a");

        if ($fp) {
            fputcsv($fp, [
                $name,
                $email,
                $mobile,
                $message,
                date("Y-m-d H:i:s")
            ]);

            fclose($fp);

            $success = "Registration submitted successfully.";

            $name = "";
            $email = "";
            $mobile = "";
            $message = "";
        }
        else {
            $error = "Unable to save data.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Registration Form</title>
</head>
<body>

<h2>Registration Form</h2>

<?php
if ($success != "") {
    echo "<p style='color:green;'>$success</p>";
}

if ($error != "") {
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST" action="">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $name; ?>"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?php echo $email; ?>"><br><br>

    <label>Mobile:</label><br>
    <input type="text" name="mobile" value="<?php echo $mobile; ?>"><br><br>

    <label>Message:</label><br>
    <textarea name="message"><?php echo $message; ?></textarea><br><br>

    <input type="submit" value="Submit">

</form>

</body>
</html>