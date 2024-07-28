<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}

include 'koneksi.php';

$sql_kategori = "SELECT * FROM kategori";
$result_kategori = $conn->query($sql_kategori);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori_id = $_POST['kategori_id'];
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO produk (nama, deskripsi, harga, stok, gambar, kategori_id) VALUES ('$nama', '$deskripsi', '$harga', '$stok', '$gambar', '$kategori_id')";
        if ($conn->query($sql) === TRUE) {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Tambah Produk</h1>
        <form method="post" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="text" name="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Stok:</label>
                <input type="text" name="stok" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategori_id" class="form-control" required>
                    <?php while($row = $result_kategori->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Gambar Produk:</label>
                <input type="file" name="gambar" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>
