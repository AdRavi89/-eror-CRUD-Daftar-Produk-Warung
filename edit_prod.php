<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <!-- Tambahkan stylesheet atau styling CSS sesuai kebutuhan -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            background-color: #f4f4f4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: static;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 300px;
            max-height: 300px;
            width: auto;
            height: auto;
            display: block;
            margin: auto;
        }

        #editButton, #deleteButton {
            padding: 8px;
            margin-bottom: 20px;
            background-color: grey;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center; /* Center-align the button within the column */
            display: block; /* Ensure it takes the full width of the container */
            margin: auto; /* Center horizontally */
        }

        #tambahButton {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            /* display: block; */
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

<a href="c.stok.php"><button id="tambahButton">Tambah</button></a><hr>


<?php
include 'config.php';

// Ambil ID barang dari URL
$id_barang = $_GET['id_barang'];

// Query untuk mendapatkan data barang dari tbl_toko berdasarkan ID
$sql_toko = "SELECT * FROM tbl_toko WHERE id_barang = $id_barang";
$result_toko = $conn->query($sql_toko);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editButton'])) {
    // Lakukan aksi edit sesuai kebutuhan
    $newNamaBarang = $_POST['newNamaBarang'];
    $newSatuan = $_POST['newSatuan'];
    $newHargaJual = $_POST['newHargaJual'];

    $sql_edit = "UPDATE tbl_toko SET nama_barang = '$newNamaBarang', satuan_brg = '$newSatuan', h_satuan = '$newHargaJual' WHERE id_barang = $id_barang";

    if ($conn->query($sql_edit) === TRUE) {
        echo "Data barang berhasil diubah.";
    } else {
        echo "Error: " . $sql_edit . "<br>" . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteButton'])) {
    // Lakukan aksi delete sesuai kebutuhan
    $sql_delete = "DELETE FROM tbl_toko WHERE id_barang = $id_barang";

    if ($conn->query($sql_delete) === TRUE) {
        echo "Data barang berhasil dihapus.";
        exit(); // Optional: untuk menghentikan eksekusi kode setelah penghapusan
    } else {
        echo "Error: " . $sql_delete . "<br>" . $conn->error;
    }
}

if ($result_toko->num_rows > 0) {
    $row_toko = $result_toko->fetch_assoc();
    ?>
    <table>
        <tr>
            <td rowspan="5"><img src="<?php echo $row_toko['img_prod']; ?>" alt="Foto Barang"></td>
            <td>NAMA BARANG</td>
            <td><?php echo $row_toko['nama_barang']; ?></td>
        </tr>
        <tr>
            <td>DISKRIPSI</td>
            <td><?php echo isset($row_toko['note']) ? $row_toko['note'] : ''; ?></td>
        </tr>
        <tr>
            <td>SATUAN PRODUK</td>
            <td><?php echo isset($row_toko['satuan_brg']) ? $row_toko['satuan_brg'] : ''; ?></td>
        </tr>
        <tr>
            <td>HARGA JUAL</td>
            <td>Rp. <?php echo number_format($row_toko['h_satuan'], 2, ',', '.'); ?></td>
        </tr>
    </table>
    <hr>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tgl. Belanja</th>
                <th>Nama Toko</th>
                <th>Satuan</th>
                <th>Harga Toko</th>
                <th>Isi</th>
                <th>Harga Jual</th>
                <th>Exe</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mendapatkan data dari tbl_prod dan tbl_toko
            $sql_prod = "SELECT p.id_barang, p.tgl_belanja,p.nm_toko, p.satuan, p.h_toko, p.isi, (p.h_toko / p.isi) AS harga_jual
                        FROM tbl_prod p
                        JOIN tbl_toko t ON p.id_barang = t.id_barang
                        WHERE p.id_barang = $id_barang";
            $result_prod = $conn->query($sql_prod);

            if ($result_prod->num_rows > 0) {
                $no = 1;
                while ($row_prod = $result_prod->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $no . "</td>
                            <td>" . $row_prod["tgl_belanja"] . "</td>
                            <td>" . $row_prod["nm_toko"] . "</td>
                            <td>" . $row_prod["satuan"] . "</td>
                            <td>Rp. " . number_format($row_prod["h_toko"], 2, ',', '.') . "</td>
                            <td>" . $row_prod["isi"] . "</td>
                            <td>Rp. " . number_format($row_prod["harga_jual"], 2, ',', '.') . "</td>
                            <td>
                                <form method='post' action='e_stok.php?id_barang=" . $row_prod['id_barang'] . "' style='display:inline-block;'>
                                    <button type='submit' name='editButton'>Edit</button>
                                </form>
                                <form method='post' action='delete.php?id_barang=" . $row_prod['id_barang'] . "' style='display:inline-block;'>
                                    <button type='submit' name='deleteButton'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
} else {
    echo "Data barang tidak ditemukan.";
}

$conn->close();
?>

</body>
</html>
