<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Belanja</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/png" href="../favico.png">
</head>
<body>
<h1 style="text-align: center; font-weight: bold; color: #f5d544; text-shadow: 2px 2px #FF0000;">Edit Data Belanja</h1>

<?php
include '../config.php';

// Ambil ID belanja dari URL
$id_belanja = $_GET['id_belanja'];

// Query untuk mendapatkan data barang dari tbl_prod berdasarkan ID belanja
$sql = "SELECT p.*, t.nama_barang FROM tbl_prod p
        JOIN tbl_toko t ON p.id_barang = t.id_barang
        WHERE id_belanja = $id_belanja";
$result = $conn->query($sql);

// Inisialisasi variabel
$id_barang = "";
$nama_barang = "";
$tgl_belanja = "";
$nm_toko = "";
$h_toko = "";
$satuan_brg = "";
$isi = "";

// Periksa apakah ada hasil dari query
if ($result->num_rows > 0) {
    // Ambil baris data sebagai asosiatif array
    $row = $result->fetch_assoc();
    
    // Isi nilai-nilai dari database ke variabel yang sesuai
    $id_barang = $row['id_barang'];
    $nama_barang = $row['nama_barang'];
    $tgl_belanja = $row['tgl_belanja'];
    $nm_toko = $row['nm_toko'];
    $h_toko = $row['h_toko'];
    $satuan_brg = $row['satuan'];
    $isi = $row['isi'];
}

// Periksa apakah metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Periksa apakah kunci yang ingin diakses telah didefinisikan dalam array $_POST
    if(isset($_POST['tgl_belanja']) && isset($_POST['h_toko']) && isset($_POST['satuan']) && isset($_POST['isi'])) {
        $tgl_belanja = $_POST['tgl_belanja'];
        $h_toko = $_POST['h_toko'];
        $satuan_brg = $_POST['satuan'];
        $isi = $_POST['isi'];

        $sql_edit = "UPDATE tbl_prod SET tgl_belanja = '$tgl_belanja', h_toko = '$h_toko', satuan = '$satuan_brg', isi = '$isi' WHERE id_belanja = $id_belanja";

        if ($conn->query($sql_edit) === TRUE) {
            echo "Data berhasil diubah.";
            // Redirect setelah berhasil disimpan
            // echo "<meta http-equiv='refresh' content='1;url=katalog.php'>";
            sleep(2);
            // Redirect ke halaman edit_prod.php dengan menyertakan parameter id_barang
            header("Location: ../katalog.php");
        } else {
            echo "Error: " . $sql_edit . "<br>" . $conn->error;
        }
    } else {
        echo "";
    }
}

$conn->close();
?>


<form method="POST" action="">
    <label for="id_nama_barang">ID & Nama Barang:</label>
    <input type="text" id="id_nama_barang" name="id_nama_barang" value="[ ID : <?php echo $id_barang . ' ] - ' . $nama_barang; ?>" readonly>
    <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $id_barang; ?>">

    <label for="tgl_belanja">Tgl. Belanja:</label>
    <input type="date" id="tgl_belanja" name="tgl_belanja" value="<?php echo $tgl_belanja; ?>" required>

    <label for="nm_toko">Nama Toko:</label>
    <input type="text" id="nm_toko" name="nm_toko" value="<?php echo $nm_toko; ?>" required>

    <label for="h_toko">Harga Toko:</label>
    <input type="text" id="h_toko" name="h_toko" value="<?php echo $h_toko; ?>" required>

    <label for="satuan">Satuan:</label>
    <select id="satuan" name="satuan" required>
        <option value="Pcs" <?php if ($satuan_brg === 'Pcs') echo 'selected'; ?>>Pcs</option>
        <option value="Pack" <?php if ($satuan_brg === 'Pack') echo 'selected'; ?>>Pack</option>
        <option value="Bungkus" <?php if ($satuan_brg === 'Bungkus') echo 'selected'; ?>>Bungkus</option>
    </select>

    <label for="isi">Isi:</label>
    <input type="number" id="isi" name="isi" value="<?php echo $isi; ?>" required>

    <input type="submit" value="Submit">
</form>

</body>
<hr>
<footer class="reveal-text" style="color: white; font-family: Helvetica, sans-serif; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center; background-color: #f57aae;">
  <p>Author : <a href="mailto:adwisravi@gmail.com" style="color: yellow;">AdRavi</a> | v. 1.0.240219.06.09</p>
</footer>
</html>
