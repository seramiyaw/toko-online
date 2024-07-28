<?php
session_start();
include 'koneksi.php';

// Inisialisasi filter
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$harga_min = isset($_GET['harga_min']) ? $_GET['harga_min'] : '';
$harga_max = isset($_GET['harga_max']) ? $_GET['harga_max'] : '';

// Buat query filter
$sql = "SELECT * FROM produk WHERE 1=1";
if ($kategori) {
    $sql .= " AND kategori='$kategori'";
}
if ($harga_min) {
    $sql .= " AND harga >= $harga_min";
}
if ($harga_max) {
    $sql .= " AND harga <= $harga_max";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Toko Baju Online</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1 class="mt-5">All Products</h1>

        <!-- Form Filter -->
        <form method="GET" class="mb-5">
            <div class="form-row">
                <div class="col">
                    <input type="text" name="kategori" class="form-control" placeholder="Kategori" value="<?php echo $kategori; ?>">
                </div>
                <div class="col">
                    <input type="number" name="harga_min" class="form-control" placeholder="Harga Minimum" value="<?php echo $harga_min; ?>">
                </div>
                <div class="col">
                    <input type="number" name="harga_max" class="form-control" placeholder="Harga Maksimum" value="<?php echo $harga_max; ?>">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <div class="row mt-5">
            <?php while($produk = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="uploads/<?php echo $produk['gambar']; ?>" class="card-img-top" alt="<?php echo $produk['nama']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                            <p class="card-text">Harga: Rp. <?php echo number_format($produk['harga'], 2); ?></p>
                            <p class="card-text">Deskripsi: <?php echo $produk['deskripsi']; ?></p>
                            <p class="card-text">Stok: <?php echo $produk['stok']; ?></p>
                            <a href="tambah_ke_keranjang.php?id=<?php echo $produk['id']; ?>" class="btn btn-primary">Beli Sekarang</a>
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
