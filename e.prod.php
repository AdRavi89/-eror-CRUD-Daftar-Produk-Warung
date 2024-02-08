<?php
include 'config.php';

// Ambil ID barang dari URL
$id_barang = $_GET['id_barang'];

// Ambil data barang berdasarkan ID dari tabel tbl_toko
$sql = "SELECT * FROM tbl_toko WHERE id_barang = $id_barang";
$result = $conn->query($sql);

// Inisialisasi variabel dengan nilai default
$nama_barang = '';
$note = '';
$satuan_brg = '';
$h_satuan = '';

if ($result->num_rows > 0) {
    // Jika data ditemukan, ambil nilainya dan masukkan ke variabel
    $row = $result->fetch_assoc();
    $nama_barang = $row['nama_barang'];
    $note = $row['note'];
    $satuan_brg = $row['satuan_brg'];
    $h_satuan = $row['h_satuan'];
} else {
    // Jika data tidak ditemukan, tampilkan pesan
    echo "Data barang tidak ditemukan.";
}

// Proses edit data jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai baru dari form
    $newNamaBarang = $_POST['newNamaBarang'];
    $newNote = $_POST['newNote'];
    $newSatuan = $_POST['newSatuan'];
    $newHargaJual = $_POST['newHargaJual'];

    // Update data di tabel tbl_toko berdasarkan id_barang
    $sql_edit = "UPDATE tbl_toko SET nama_barang = '$newNamaBarang', note = '$newNote', satuan_brg = '$newSatuan', h_satuan = '$newHargaJual' WHERE id_barang = $id_barang";

    if ($conn->query($sql_edit) === TRUE) {
        echo "Data barang berhasil diubah.";
        echo "<meta http-equiv='refresh' content='1;url=index.php'>";
    } else {
        echo "Error: " . $sql_edit . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang</title>
    <style>
        /* Sesuaikan dengan kebutuhan styling Anda */
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

        h1 {
            text-align: center;
            font-weight: bold;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        select,
        textarea {
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

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-top: 10px;
        }

        /* Styling untuk tampilan responsif */
        @media screen and (max-width: 600px) {
            form {
                margin: 10px;
            }
        }
    </style>
</head>
<body>

<h1>Edit Data Barang</h1>
<form method="POST" action="">
    <label for="newNamaBarang">Nama Barang:</label>
    <input type="text" id="newNamaBarang" name="newNamaBarang" value="<?php echo $nama_barang; ?>" required>

    <label for="newNote">Deskripsi:</label>
    <textarea id="newNote" name="newNote" required><?php echo $note; ?></textarea><br>


    <label for="newSatuan">Satuan:</label>
    <select id="newSatuan" name="newSatuan" required>
        <option value="Pcs" <?php if ($satuan_brg === 'Pcs') echo 'selected'; ?>>Pcs</option>
        <option value="Pack" <?php if ($satuan_brg === 'Pack') echo 'selected'; ?>>Pack</option>
        <option value="Bungkus" <?php if ($satuan_brg === 'Bungkus') echo 'selected'; ?>>Bungkus</option>
    </select>

    <label for="newHargaJual">Harga Jual:</label>
    <input type="text" id="newHargaJual" name="newHargaJual" value="<?php echo $h_satuan; ?>" required>

    <input type="submit" value="Simpan Perubahan">
</form>

</body>
</html>
