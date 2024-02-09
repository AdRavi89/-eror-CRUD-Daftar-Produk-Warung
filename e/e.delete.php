<?php
include '../config.php';

// Pastikan parameter ID belanja telah diterima
if(isset($_GET['id_belanja'])) {
    // Ambil ID belanja dari URL
    $id_belanja = $_GET['id_belanja'];

    // Lakukan query untuk menghapus data belanja
    $sql_delete = "DELETE FROM tbl_prod WHERE id_belanja = $id_belanja";

    if ($conn->query($sql_delete) === TRUE) {
        // Redirect kembali ke halaman sebelumnya setelah menghapus data
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
} else {
    echo "ID belanja tidak valid.";
}

$conn->close();
?>
