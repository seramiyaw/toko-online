<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$cart = $_SESSION['cart'];

if(empty($cart)) {
    $products = array();
} else {
    $ids = implode(',', array_keys($cart));
    $sql = "SELECT * FROM produk WHERE id IN ($ids)";
    $result = $conn->query($sql);
    $products = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Toko Baju Online</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h1 class="mt-5">Shopping Cart</h1>
        <?php if(empty($products)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                        <tr>
                            <td><?php echo $product['nama']; ?></td>
                            <td>Rp. <?php echo number_format($product['harga'], 2); ?></td>
                            <td><?php echo $cart[$product['id']]; ?></td>
                            <td>Rp. <?php echo number_format($product['harga'] * $cart[$product['id']], 2); ?></td>
                            <td><a href="hapus_dari_keranjang.php?id=<?php echo $product['id']; ?>" class="btn btn-danger">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
