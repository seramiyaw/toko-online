<?php
session_start();
include 'koneksi.php';

$id_produk = $_GET['id'];

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk]++;
} else {
    $_SESSION['keranjang'][$id_produk] = 1;
}

header("Location: keranjang.php");
?>
