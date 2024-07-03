<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$country = $conn->query("SELECT * FROM negara WHERE id=$id")->fetch_assoc();

$update_status = ""; // Variable untuk menyimpan pesan sukses atau error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['groups_id'];
    $country_name = $_POST['nama_negara'];
    $wins = $_POST['menang'];
    $draws = $_POST['draw'];
    $losses = $_POST['kalah'];
    $points = $_POST['points'];

    $sql = "UPDATE negara SET groups_id='$group_id', nama_negara='$country_name', menang='$wins', draw='$draws', kalah='$losses', points='$points' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $update_status = "Updated Berhasil."; // Pesan sukses
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 1500);
             </script>';
    } else {
        $update_status = "Error updating record: " . $conn->error; // Pesan error
    }
}

$groups = $conn->query("SELECT * FROM groups");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Country</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Country</h2>
    <?php if (!empty($update_status)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $update_status; ?>
        </div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="groups_id">Group:</label>
            <select class="form-control" id="groups_id" name="groups_id" required>
                <?php while ($row = $groups->fetch_assoc()): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $country['groups_id']) ? 'selected' : ''; ?>><?php echo $row['group_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="nama_negara">Negara</label>
            <input type="text" class="form-control" id="nama_negara" name="nama_negara" value="<?php echo $country['nama_negara']; ?>" required>
        </div>
        <div class="form-group">
            <label for="menang">Menang:</label>
            <input type="number" class="form-control" id="menang" name="menang" value="<?php echo $country['menang']; ?>" required>
        </div>
        <div class="form-group">
            <label for="draw">Draw:</label>
            <input type="number" class="form-control" id="draw" name="draw" value="<?php echo $country['draw']; ?>" required>
        </div>
        <div class="form-group">
            <label for="kalah">Kalah:</label>
            <input type="number" class="form-control" id="kalah" name="kalah" value="<?php echo $country['kalah']; ?>" required>
        </div>
        <div class="form-group">
            <label for="points">Points:</label>
            <input type="number" class="form-control" id="points" name="points" value="<?php echo $country['points']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
