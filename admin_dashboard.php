<?php
session_start();
include 'koneksi.php';

// Ambil data produk dari database
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Dashboard Admin</h1>
        <a href="admin_tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk Baru</a>
        <div class="row">
            <?php while($produk = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="uploads/<?php echo $produk['gambar']; ?>" class="card-img-top" alt="<?php echo $produk['nama']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                            <p class="card-text">Harga: Rp. <?php echo number_format($produk['harga'], 2); ?></p>
                            <p class="card-text">Deskripsi: <?php echo $produk['deskripsi']; ?></p>
                            <p class="card-text">Stok: <?php echo $produk['stok']; ?></p>
                            <a href="admin_edit_produk.php?id=<?php echo $produk['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="admin_hapus_produk.php?id=<?php echo $produk['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
