<?php
session_start();
include "koneksi.php";

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

// Mengambil data dari database dengan JOIN dan urutkan berdasarkan poin
$countries = $conn->query("SELECT negara.*, groups.group_name FROM negara JOIN groups ON negara.groups_id = groups.id ORDER BY negara.points DESC");
if (!$countries) {
    die("Query Error: " . $conn->error);
}

// Menghapus data berdasarkan ID
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM negara WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thead-lightgreen {
            background-color: #d4edda; /* Hijau muda */
            color: #155724; /* Warna teks sesuai kontras */
        }
        .bold-text {
            font-weight: bold;
        }
        .table-bordered th,
        .table-bordered td {
            border: 1.5px solid black; /* Border tebal 2px dan solid */
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['nim']); ?></h1>
    <h5 class="text-center"><?php echo date('l, j F Y H:i:s'); ?></h5> <!-- Menampilkan hari, tanggal, bulan, tahun, dan waktu saat ini -->
    <h3 class="text-center">KLASEMEN EURO 2024 GROUP A</h3>
    <div class="text-left mt-5 mb-3">
        <a href="tambah_group.php" class="btn btn-primary">Tambah Group</a>
        <a href="tambah_negara.php" class="btn btn-primary">Tambah Negara</a>
        <a href="pdf.php" class="btn btn-secondary">Cetak PDF</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-lightgreen">
            <tr>
                <th class="bold-text text-center">Negara</th>
                <th class="bold-text text-center">Menang</th>
                <th class="bold-text text-center">Draw</th>
                <th class="bold-text text-center">Kalah</th>
                <th class="bold-text text-center">Points</th>
                <th class="bold-text text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $countries->fetch_assoc()): ?>
                <tr>
                    <td class="bold-text"><?php echo htmlspecialchars($row['nama_negara']); ?></td>
                    <td class="bold-text text-center"><?php echo htmlspecialchars($row['menang']); ?></td>
                    <td class="bold-text text-center"><?php echo htmlspecialchars($row['draw']); ?></td>
                    <td class="bold-text text-center"><?php echo htmlspecialchars($row['kalah']); ?></td>
                    <td class="bold-text text-center"><?php echo htmlspecialchars($row['points']); ?></td>
                    <td class="text-center">
                        <a href="edit.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-md">Edit</a>
                        <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-md" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="form-group text-right mt-3">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
