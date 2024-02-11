<?php
include '../config.php';

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
    // Data berhasil diubah
    echo "<script>alert('Data barang berhasil diubah.'); window.location.href = '../katalog.php';</script>";
} else {
    // Terjadi error saat mengubah data
    echo "<script>alert('Error: " . $sql_edit . "\\n" . $conn->error . "');</script>";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
    
</head>
<body>

<h1 style="text-align: center; font-weight: bold; color: #f5d544; text-shadow: 2px 2px #FF0000;">Edit Data Produk</h1>
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
