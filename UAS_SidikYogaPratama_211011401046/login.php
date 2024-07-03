<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id();
            $_SESSION['nim'] = $nim;
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Password Salah.";
        }
    } else {
        $error_message = "NIM Salah.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center" style="margin-top: 200px;">
        <div class="col-md-4">
            <div class="card mt-5">
                <div class="card-body">
                    <h2 class="card-title text-center">Login</h2>
                    <?php
                    if (!empty($error_message)) {
                        echo '<div class="alert alert-danger">' . $error_message . '</div>';
                    }
                    ?>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
