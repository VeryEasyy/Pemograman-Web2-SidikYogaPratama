<?php
session_start();
include 'koneksi.php';
require('fpdf186/fpdf.php');

if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

// Fetch user information
$userName = htmlspecialchars($_SESSION['nim']);
$currentDateTime = date('d F Y H:i:s'); // Menggunakan F untuk format nama bulan dalam bahasa Indonesia

$countries = $conn->query("SELECT negara.*, groups.group_name FROM negara JOIN groups ON negara.groups_id = groups.id");

// Create instance of FPDF class
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Title
$pdf->Cell(0, 10, 'DATA GROUP A', 0, 1, 'C');
$pdf->Ln(5); // Line break for spacing

// User info
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Per ' . strftime('%d %B %Y %H:%M:%S', strtotime($currentDateTime)), 0, 1, 'C'); // Menggunakan strftime untuk nama bulan
$pdf->Cell(0, 10, 'NIM: ' . $_SESSION['nim'], 0, 1, 'C'); // NIM
$pdf->Ln(10); // Additional spacing

// Column headers
$pdf->SetFont('Arial', 'B', 12);
$header = array('Negara', 'Menang', 'Draw', 'Kalah', 'Points');
$w = array(40, 40, 20, 20, 20); // column widths

// Center table headers
$pdf->SetX((210 - array_sum($w)) / 2); // Center the table

// Header
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($w[$i], 10, $header[$i], 1, 0, 'C');
}
$pdf->Ln();

// Data
$pdf->SetFont('Arial', '', 12);
while ($row = $countries->fetch_assoc()) {
    $pdf->SetX((210 - array_sum($w)) / 2); // Center the table rows
    $pdf->Cell($w[0], 10, $row['nama_negara'], 1, 0, 'C'); // Menggunakan 'C' untuk perataan data ke tengah
    $pdf->Cell($w[1], 10, $row['menang'], 1, 0, 'C');
    $pdf->Cell($w[2], 10, $row['draw'], 1, 0, 'C');
    $pdf->Cell($w[3], 10, $row['kalah'], 1, 0, 'C');
    $pdf->Cell($w[4], 10, $row['points'], 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
