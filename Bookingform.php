<?php
include 'db_connect.php';

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $service = trim($_POST['service']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];

    if (empty($name) || empty($mobile) || empty($email) || empty($service) || empty($date) || empty($time) || empty($address1) || empty($address2)) {
        $error = "All fields are required!";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (name, mobile, email, service, date, time, address1, address2) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $mobile, $email, $service, $date, $time, $address1, $address2);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Your Service is Successfully Booked!');
                    window.location.href = 'Service.html';
                  </script>";
            exit(); // Stop further execution
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bookingform.css"/>
    <title>Book Service</title>

</head>
<body class="animated">

    <div class="container">
        <h2>Book a Service</h2>

        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <?php $service = isset($_GET['service']) ? htmlspecialchars($_GET['service']) : ''; ?>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Enter your name" required><br>
            <input type="text" name="mobile" placeholder="Enter your number" required><br>
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <input type="text" name="service" value="<?php echo $service; ?>" readonly><br>
            <input type="date" name="date" required><br>
            <input type="time" name="time" required><br>
            <input type="text" name="address1" placeholder="Address Line 1" required><br>
            <input type="text" name="address2" placeholder="Address Line 2"><br>
            <button type="submit">Book</button>
        </form>
    </div>

</body>
</html>
