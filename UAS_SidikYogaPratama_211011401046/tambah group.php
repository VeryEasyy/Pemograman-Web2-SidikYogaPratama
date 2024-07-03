<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$insert_status = ""; // Variable untuk menyimpan pesan sukses atau error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_name = $conn->real_escape_string($_POST['group_name']);

    $sql = "INSERT INTO groups (group_name) VALUES ('$group_name')";
    if ($conn->query($sql) === TRUE) {
        $insert_status = "New group created successfully.";
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000); // Redirect setelah 3 detik
             </script>';
    } else {
        $insert_status = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Group</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Group</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="group_name">Group Name:</label>
                <input type="text" class="form-control" id="group_name" name="group_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Group</button>
        </form>
        <?php if (!empty($insert_status)): ?>
            <div class="alert alert-success mt-3" role="alert">
                <?php echo $insert_status; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
