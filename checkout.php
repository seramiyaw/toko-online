<?php
session_start();
include 'koneksi.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
$total = 0;

foreach ($keranjang as $id_produk => $jumlah) {
    if (!empty($id_produk)) {
        $sql = "SELECT * FROM produk WHERE id = $id_produk";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $produk = $result->fetch_assoc();
            $total += $produk['harga'] * $jumlah;
        } else {
            echo "<div class='alert alert-danger'>Produk dengan ID $id_produk tidak ditemukan.</div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];

    // Simpan data pembelian
    $sql = "INSERT INTO pembelian (nama, email, total) VALUES ('$nama', '$email', '$total')";
    if ($conn->query($sql) === TRUE) {
        // Kosongkan keranjang
        unset($_SESSION['keranjang']);
        header("Location: selesai.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Checkout</h1>
        <form method="post" class="mt-4">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Total: Rp. <?php echo number_format($total, 2); ?></label>
            </div>
            <button type="submit" class="btn btn-primary">Selesaikan Pembelian</button>
        </form>
    </div>
</body>
</html>
