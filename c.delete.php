<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ensure the 'id_barang' parameter is set in the URL
    if (isset($_GET['id_barang']) && !empty($_GET['id_barang'])) {
        $id_barang = $_GET['id_barang'];

        // Perform deletion
        $sql = "DELETE FROM tbl_toko WHERE id_barang = $id_barang";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to the index.php after successful deletion
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid parameters";
    }
}

$conn->close();
?>
