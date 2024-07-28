<?php
session_start();
include 'koneksi.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : array();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Selesaikan Pembelian Anda</h1>
        <ul class="list-group">
            <?php 
            foreach ($keranjang as $id_produk => $jumlah): 
                if (!empty($id_produk)) {
                    $sql = "SELECT * FROM produk WHERE id = $id_produk";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $produk = $result->fetch_assoc();
            ?>
                        <li class="list-group-item">
                            <h2><?php echo $produk['nama']; ?></h2>
                            <p>Harga: Rp. <?php echo number_format($produk['harga'], 2); ?></p>
                            <p>Jumlah: <?php echo $jumlah; ?></p>
                            <p>Subtotal: Rp. <?php echo number_format($produk['harga'] * $jumlah, 2); ?></p>
                        </li>
            <?php 
                    } else {
                        echo "<li class='list-group-item'>Produk tidak ditemukan</li>";
                    }
                }
            endforeach; 
            ?>
        </ul>
        <a href="checkout.php" class="btn btn-primary mt-3">Checkout</a>
    </div>
</body>
</html>
