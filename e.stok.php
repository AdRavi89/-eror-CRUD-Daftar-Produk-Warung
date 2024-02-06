<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            background-color: #f4f4f4;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select,
        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Styling untuk tampilan responsif (opsional) */
        @media screen and (max-width: 600px) {
            form {
                margin: 10px;
            }
        }
    </style>
</head>
<body>

<?php
include 'config.php';

// Ambil ID barang dari URL
$id_barang = $_GET['id_barang'];

// Query untuk mendapatkan data barang dari tbl_prod berdasarkan ID
$sql = "SELECT * FROM tbl_prod WHERE id_barang = $id_barang";
$result = $conn->query($sql);

// Periksa apakah metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah kunci yang ingin diakses telah didefinisikan dalam array $_POST
    if(isset($_POST['tgl_belanja']) && isset($_POST['h_toko']) && isset($_POST['satuan']) && isset($_POST['isi'])) {
        $tgl_belanja = $_POST['tgl_belanja'];
        $h_toko = $_POST['h_toko'];
        $satuan = $_POST['satuan'];
        $isi = $_POST['isi'];

        $sql_edit = "UPDATE tbl_prod SET tgl_belanja = '$tgl_belanja', h_toko = '$h_toko', satuan = '$satuan', isi = '$isi' WHERE id_barang = $id_barang";

        if ($conn->query($sql_edit) === TRUE) {
            echo "Data berhasil diubah.";
        } else {
            echo "Error: " . $sql_edit . "<br>" . $conn->error;
        }
    } else {
        echo "Semua field harus diisi.";
    }
}

$conn->close();
?>


<form method="POST" action="">
    <label for="tgl_belanja">Tgl. Belanja:</label>
    <input type="date" id="tgl_belanja" name="tgl_belanja" required>

    <label for="h_toko">Harga Toko:</label>
    <input type="text" id="h_toko" name="h_toko" required>

    <label for="satuan">Satuan:</label>
    <select id="satuan" name="satuan" required>
        <option value="Pcs">Pcs</option>
        <option value="Pack">Pack</option>
        <option value="Bungkus">Bungkus</option>
    </select>

    <label for="isi">Isi:</label>
    <input type="number" id="isi" name="isi" required>

    <input type="submit" value="Submit">
</form>

</body>
</html>
