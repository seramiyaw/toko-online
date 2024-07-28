<?php
session_start();
include 'koneksi.php';

// Ambil data produk dari database
$sql_produk = "SELECT * FROM produk";
$result_produk = $conn->query($sql_produk);

// Ambil data kategori dari database
$sql_kategori = "SELECT * FROM kategori";
$result_kategori = $conn->query($sql_kategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju Online</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: fantasy;
        }

        h1, h5, .card-text {
            font-family: monospace;
        }

        /* CSS untuk tampilan loading */
        #loader {
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        #loader img {
            width: 100px; /* Sesuaikan ukuran logo */
            height: 100px; /* Sesuaikan ukuran logo */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Menyembunyikan konten saat loading */
        #content {
            display: none;
        }
    </style>
</head>

<body onload="myFunction()">
    <div id="loader">
        <img src="uploads/logo1.png" alt="Loading..."> <!-- Ganti path/to/your/logo.png dengan path logo Anda -->
    </div>
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">GFH Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <h1 class="mt-5">Toko Baju Online</h1>
            
            <!-- Dropdown untuk memilih kategori -->
            <div class="form-group">
                <label for="kategori">Pilih Kategori:</label>
                <select id="kategori" class="form-control" onchange="filterProduk()">
                    <option value="all">Semua Kategori</option>
                    <?php while($kategori = $result_kategori->fetch_assoc()): ?>
                        <option value="<?php echo $kategori['id']; ?>"><?php echo htmlspecialchars($kategori['nama']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="uploads/Editorial Fashion Accessory Brand Banner for Shopify.jpg" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="uploads/1.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="uploads/dua.jpg" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="row mt-5" id="produk-list">
                <?php while($produk = $result_produk->fetch_assoc()): ?>
                    <div class="col-md-4 produk-item" data-kategori="<?php echo $produk['kategori_id']; ?>">
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
    </div>

    <script>
        function myFunction() {
            setTimeout(showPage, 3000); // Waktu loading 3 detik
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("content").style.display = "block";
        }

        function filterProduk() {
            var kategori = document.getElementById("kategori").value;
            var produkItems = document.getElementsByClassName("produk-item");

            for (var i = 0; i < produkItems.length; i++) {
                if (kategori === "all" || produkItems[i].getAttribute("data-kategori") === kategori) {
                    produkItems[i].style.display = "block";
                } else {
                    produkItems[i].style.display = "none";
                }
            }
        }
    </script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
