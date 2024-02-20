<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Warungku</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="favico.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="fixed-header">
<h1 class="reveal-text" style="color: white; font-family: Helvetica, sans-serif; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center;">
	Selamat Datang di Warungku
</h1>
<h1 class="reveal-text" style="color: white; font-family: Helvetica, sans-serif; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center;">
-`♡´-`♡´-`♡´-`♡´-`♡´- 
</h1>
</div>
<hr>
    <!-- <nav>
        <a href="index.php">Home<span></span></a>
        <a href="katalog.php">Katalog<span></span></a>
    </nav> 
    <hr>-->
    <div class="gallery">
       <?php
// Koneksi ke database
include 'config.php';

// Query untuk mendapatkan data barang dari database
$sql = "SELECT img_prod, nama_barang, h_satuan, stok FROM tbl_toko";
$result = $conn->query($sql);

// Jika terdapat data dalam database, tampilkan gambarnya
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Potong nama_barang menjadi 25 karakter
        $nama_barang = strlen($row['nama_barang']) > 25 ? substr($row['nama_barang'], 0, 25) . '...' : $row['nama_barang'];
        
        // Tampilkan gambar, nama_barang, dan h_satuan dalam div dengan kelas gallery-item
        echo '<div class="gallery-item">';
        echo '<img src="' . $row['img_prod'] . '" alt="' . $nama_barang . '">';
        echo '<p style="color: white; font-family: Helvetica, sans-serif; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center;">' . $nama_barang . '</p>';
        
        // Tampilkan harga sesuai dengan stok
        if ($row['stok'] === 'ADA') {
            echo '<p style="color: white; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center;">Rp. ' . number_format($row["h_satuan"], 2, ',', '.') . '</p>';
        } else {
            echo '<p style="color: white; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center;">STOK KOSONG</p>';
        }
        
        echo '<br>';
        echo '</div>';
    }
} else {
    echo "Tidak ada data barang.";
}
?>

    </div>
</body>
<hr>
<footer class="reveal-text" style="color: white; font-family: Helvetica, sans-serif; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center; background-color: #f57aae;">
  <p>Author : <a href="mailto:adwisravi@gmail.com" style="color: yellow;">AdRavi</a> | v. 1.0.240219.06.09</p>
</footer>
</html>
