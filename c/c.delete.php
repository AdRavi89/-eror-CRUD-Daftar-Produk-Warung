<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Ensure the 'id_barang' parameter is set in the URL
    if (isset($_GET['id_barang']) && !empty($_GET['id_barang'])) {
        $id_barang = $_GET['id_barang'];

        // Query to select image path before deletion
        $sql_select_image = "SELECT img_prod FROM tbl_toko WHERE id_barang = $id_barang";
        $result_image = $conn->query($sql_select_image);

        if ($result_image->num_rows > 0) {
            $row_image = $result_image->fetch_assoc();
            $image_path = $row_image['img_prod'];
        }

        // Perform deletion
        $sql_delete = "DELETE FROM tbl_toko WHERE id_barang = $id_barang";

        if ($conn->query($sql_delete) === TRUE) {
            // If deletion is successful, delete the associated image file from server
            if (isset($image_path) && !empty($image_path)) {
                unlink($image_path); // Delete the image file from server
            }
            // Redirect back to the katalog.php after successful deletion
            header("Location: ../katalog.php");
            exit();
        } else {
            echo "Error: " . $sql_delete . "<br>" . $conn->error;
        }
    } else {
        echo "Invalid parameters";
    }
}

$conn->close();
?>
