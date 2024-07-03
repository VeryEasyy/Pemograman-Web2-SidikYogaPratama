<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$groups = $conn->query("SELECT * FROM groups");

$insert_status = ""; // Variable untuk menyimpan pesan sukses atau error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $conn->real_escape_string($_POST['groups_id']);
    $country_name = $conn->real_escape_string($_POST['nama_negara']);
    $wins = $conn->real_escape_string($_POST['menang']);
    $draws = $conn->real_escape_string($_POST['draw']);
    $losses = $conn->real_escape_string($_POST['kalah']);
    $points = $conn->real_escape_string($_POST['points']);

    $sql = "INSERT INTO negara (groups_id, nama_negara, menang, draw, kalah, points) VALUES ('$group_id', '$country_name', '$wins', '$draws', '$losses', '$points')";
    if ($conn->query($sql) === TRUE) {
        $insert_status = "New country added successfully.";
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 1500);
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
    <title>Add Country</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add Country</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="groups_id">Group:</label>
                <select class="form-control" id="groups_id" name="groups_id" required>
                    <?php while ($row = $groups->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['group_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_negara">Negara:</label>
                <input type="text" class="form-control" id="nama_negara" name="nama_negara" required>
            </div>
            <div class="form-group">
                <label for="menang">Menang:</label>
                <input type="number" class="form-control" id="menang" name="menang" required>
            </div>
            <div class="form-group">
                <label for="draw">Draw:</label>
                <input type="number" class="form-control" id="draw" name="draw" required>
            </div>
            <div class="form-group">
                <label for="kalah">Kalah:</label>
                <input type="number" class="form-control" id="kalah" name="kalah" required>
            </div>
            <div class="form-group">
                <label for="points">Points:</label>
                <input type="number" class="form-control" id="points" name="points" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Country</button>
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
