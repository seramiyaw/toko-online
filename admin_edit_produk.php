<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

include 'koneksi.php';

// Ambil produk berdasarkan id
$id = $_GET['id'];
$sql = "SELECT * FROM produk WHERE id=$id";
$result = $conn->query($sql);
$produk = $result->fetch_assoc();

// Ambil daftar kategori
$kategori_sql = "SELECT * FROM kategori";
$kategori_result = $conn->query($kategori_sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori_id = $_POST['kategori_id'];

    $gambar_lama = isset($produk['gambar']) ? $produk['gambar'] : '';

    if (!empty($_FILES['gambar']['name'])) {
        // Proses upload gambar baru
        $target_dir = "uploads/";
        $gambar_baru = basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $gambar_baru;
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Hapus gambar lama jika gambar baru berhasil diunggah
            if (!empty($gambar_lama) && file_exists($target_dir . $gambar_lama)) {
                unlink($target_dir . $gambar_lama);
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        $gambar_baru = $gambar_lama;
    }

    $sql = "UPDATE produk SET 
            nama='$nama', 
            deskripsi='$deskripsi', 
            harga='$harga', 
            stok='$stok', 
            kategori_id='$kategori_id',
            gambar='$gambar_baru' 
            WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Produk</h1>
        <form method="post" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($produk['nama']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" required><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="text" name="harga" value="<?php echo htmlspecialchars($produk['harga']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stok:</label>
                <input type="text" name="stok" value="<?php echo htmlspecialchars($produk['stok']); ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategori_id" class="form-control" required>
                    <?php while ($kategori = $kategori_result->fetch_assoc()): ?>
                        <option value="<?php echo $kategori['id']; ?>" <?php echo $kategori['id'] == $produk['kategori_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($kategori['nama']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Gambar Produk:</label><br>
                <?php if (!empty($produk['gambar'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($produk['gambar']); ?>" width="100"><br>
                <?php endif; ?>
                <input type="file" name="gambar" class="form-control-file mt-2">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
