<?php
include 'config.php';

// Inisialisasi nilai default untuk $id_barang dan $id_belanja
$id_barang = '';
$id_belanja = '';

// Jika id_barang tersedia dalam URL, ambil nilainya
if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
}

// Pastikan id_belanja tersedia dalam URL
if (isset($_GET['id_belanja'])) {
    $id_belanja = $_GET['id_belanja'];

    // Query untuk menghapus data dari tbl_prod
    $sql_delete_prod = "DELETE FROM tbl_prod WHERE id_belanja = $id_belanja";

    if ($conn->query($sql_delete_prod) === TRUE) {
        // Jika penghapusan data berhasil, redirect kembali ke halaman edit_prod.php dengan menyertakan parameter id_barang sebelumnya
        sleep(2);
        header("Location: edit_prod.php?id_barang=$id_barang");
        exit();
    } else {
        echo "Error: " . $sql_delete_prod . "<br>" . $conn->error;
    }
} else {
    // Jika id_belanja tidak tersedia dalam URL, tampilkan pesan kesalahan
    echo "Data Waktu Belanja Tidak Ditemukan.";
}

$conn->close();
?>
