<?php
include 'db_connect.php';

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $num = $_POST['num'];
    $email = $_POST['email'];
    $map = $_POST['map'];

    if (empty($name) || empty($num) || empty($email) || empty($map)) {
        $error = "All fields are required!";
    } else {
        $stmt = $conn->prepare("INSERT INTO calrequest (name, num, email, map) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $num, $email, $map);

        if ($stmt->execute()) {
            $success = "Your Call request Sended Successfully!!! ";
            // Clear form fields after successful submission
            $name = $num = $email = $map = "";
        } else {
            $error = "Error: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>CallBack Request</title>
    <link rel="stylesheet" href="callrequest.css"/>
  </head>
  <body class="animated">
    <section class="container">
      <header><h1><b>Emergency CallBack</b></h1></header>

      <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
      <?php if (!empty($success)) echo "<p class='success'>$success</p>"; ?>

      <form method="POST" action="" class="form">
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" name="name" placeholder="Enter full name" value="<?= htmlspecialchars($name ?? '') ?>" />
        </div>

        <div class="column">
          <div class="input-box">
            <label>Phone Number</label>
            <input type="number" name="num" placeholder="Enter phone number" value="<?= htmlspecialchars($num ?? '') ?>" />
          </div><br>

        <div class="input-box">
          <label>Email Address</label>
          <input type="text" name="email" placeholder="Enter email address" value="<?= htmlspecialchars($email ?? '') ?>" />
        </div><br>

        <div class="input-box">
          <label>Location Link</label>
          <input type="text" name="map" placeholder="Paste Live location from Map" value="<?= htmlspecialchars($map ?? '') ?>" />
        </div><br>

        <button type="submit">Send</button>
      </form>
    </section>
  </body>
</html>
