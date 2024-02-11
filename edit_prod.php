<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Data Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home<span></span></a>
        <a href="katalog.php">Katalog<span></span></a>
        <!-- <a href="#">About<span></span></a>
        <a href="#">Service<span></span></a>
        <a href="#">Contact<span></span></a>
        <a href="#">Help<span></span></a> -->
    </nav>
    <hr>

    <?php
    include 'config.php';
    $id_barang = $_GET['id_barang'];
    ?>

    <div class="content">
        <h1 style="text-align: center; font-weight: bold; color: #f5d544; text-shadow: 2px 2px #FF0000;">HISTORY BELANJA PRODUK</h1>

        <script>
            function tambahButton(id_barang) {
                window.location.href = "./c/c.stok.php?id_barang=" + id_barang;
            }
        </script>

        <?php
        $id_barang = $_GET['id_barang'];
        if (!empty($id_barang)) {
            // Jalankan query SQL di sini
        } else {
            echo "ID barang tidak valid.";
        }

        $sql_toko = "SELECT * FROM tbl_toko WHERE id_barang = $id_barang";
        $result_toko = $conn->query($sql_toko);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editButton'])) {
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
                    <td rowspan="5">
                        <a href="e/e.prod.php?id_barang=<?php echo $id_barang; ?>">
                            <img src="<?php echo $row_toko['img_prod']; ?>" alt="Foto Barang">
                        </a>
                    </td>
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
            <a href="c/c.stok.php?id_barang=<?php echo $id_barang; ?>"><button id="tambahButton">Tambah</button></a>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Belanja</th>
                        <th>Keterangan</th>
                        <th style="width: 1%;">EXE</th>   
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_prod = "SELECT p.id_barang, p.id_belanja,p.tgl_belanja,p.nm_toko, p.satuan, p.h_toko, p.isi, (p.h_toko / p.isi) AS harga_jual
                                FROM tbl_prod p
                                JOIN tbl_toko t ON p.id_barang = t.id_barang
                                WHERE p.id_barang = $id_barang";
                    $result_prod = $conn->query($sql_prod);

                    if ($result_prod->num_rows > 0) {
                        $no = 1;
                        while ($row_prod = $result_prod->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $no . "</td>
                                <td>Tgl. " . $row_prod["tgl_belanja"] . "
                                <br>Lokasi : " . $row_prod["nm_toko"] . "
                                </td>
                                <td>Harga Toko : Rp. " . number_format($row_prod["h_toko"], 2, ',', '.') . "
                                <br>isi : " . $row_prod["isi"] . " " . $row_prod["satuan"] . "
                                <br>Harga Satuan : Rp. " . number_format($row_prod["harga_jual"], 2, ',', '.') . " / " . $row_prod["satuan"] . "</td>
                                <td>
                                    <button onclick='editData(" . $row_prod["id_belanja"] . ")' class='btn btn-info btn-sm btn-block'><i class='fa fa-edit'></i></button>
                                    <button onclick='deleteData(" . $row_prod["id_belanja"] . ")' class='btn btn-danger btn-sm btn-block'><i class='fa fa-trash'></i></button>
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
        </div>

        <script>
            function editData(id) {
                window.location.href = 'e/e.stok.php?id_belanja=' + id;
            }

            function deleteData(id) {
                var confirmation = confirm('Apakah Anda yakin ingin menghapus data ini?');

                if (confirmation) {
                    window.location.href = 'e/e.delete.php?id_belanja=' + id;
                }
            }
        </script>

        <?php
        } else {
            echo "Data barang tidak ditemukan.";
        }

        $conn->close();
        ?>

    </body>
    </html>
