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
$stok = '';

if ($result->num_rows > 0) {
    // Jika data ditemukan, ambil nilainya dan masukkan ke variabel
    $row = $result->fetch_assoc();
    $nama_barang = $row['nama_barang'];
    $note = $row['note'];
    $satuan_brg = $row['satuan_brg'];
    $h_satuan = $row['h_satuan'];
    $stok = $row['stok'];
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
    $newStok = $_POST['newStok'];

    // Update data di tabel tbl_toko berdasarkan id_barang
    $sql_edit = "UPDATE tbl_toko SET nama_barang = '$newNamaBarang', note = '$newNote', satuan_brg = '$newSatuan', h_satuan = '$newHargaJual', stok = '$newStok' WHERE id_barang = $id_barang";

    if ($conn->query($sql_edit) === TRUE) {
        echo "Data barang berhasil diubah.";
        echo "<meta http-equiv='refresh' content='1;url=../katalog.php'>";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/png" href="../favico.png">
    
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

    <label for="newStok">Stok:</label>
    <select id="newStok" name="newStok" required>
        <option value="ADA" <?php if ($stok === 'ADA') echo 'selected'; ?>>ADA</option>
        <option value="KOSONG" <?php if ($stok === 'KOSONG') echo 'selected'; ?>>KOSONG</option>
    </select>

    <label for="newHargaJual">Harga Jual:</label>
    <input type="text" id="newHargaJual" name="newHargaJual" value="<?php echo $h_satuan; ?>" required>

    <input type="submit" value="Simpan Perubahan">
</form>

</body>
<hr>
<footer class="reveal-text" style="color: white; font-family: Helvetica, sans-serif; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center; background-color: #f57aae;">
  <p>Author : <a href="mailto:adwisravi@gmail.com" style="color: yellow;">AdRavi</a> | v. 1.0.240219.06.09</p>
</footer>
</html>
