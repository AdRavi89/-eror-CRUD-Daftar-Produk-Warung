<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST["nama_barang"];
    $note = $_POST["note"];
    $h_satuan = $_POST["h_satuan"];

    // Mengelola file gambar yang diunggah
    $img_prod = $_FILES["img_prod"];
    $img_name = $img_prod["name"];
    $img_tmp = $img_prod["tmp_name"];

    // Buat nama file baru berdasarkan nama barang
    $img_dest = 'image/' . $nama_barang . '.' . pathinfo($img_name, PATHINFO_EXTENSION);

    // Memindahkan file gambar ke direktori "uploads" dan melakukan resize
    if(move_uploaded_file($img_tmp, $img_dest)) {
        // Mendapatkan informasi ukuran gambar
        list($width, $height) = getimagesize($img_dest);
        
        // Mengatur ukuran gambar maksimal menjadi 300x300
        $max_size = 300;

        // Mengatur ukuran gambar yang akan diresize
        if ($width > $height) {
            $new_width = $max_size;
            $new_height = $height * ($max_size / $width);
        } else {
            $new_height = $max_size;
            $new_width = $width * ($max_size / $height);
        }

        // Membuat gambar baru dengan ukuran yang diinginkan
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($img_dest); // Ganti dengan imagecreatefrompng() jika file PNG

        // Menyesuaikan ukuran gambar baru
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // Menyimpan gambar baru dengan ukuran yang diinginkan
        imagejpeg($image_p, $img_dest); // Ganti dengan imagepng() jika ingin menyimpan dalam format PNG

        // Menyimpan data ke database
        $sql = "INSERT INTO tbl_toko (img_prod, nama_barang, note, h_satuan) VALUES ('$img_dest', '$nama_barang', '$note', '$h_satuan')";

        if ($conn->query($sql) === TRUE) {
            header("Location: katalog.php"); // Redirect kembali ke halaman utama setelah menambahkan data
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Gagal mengunggah gambar.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="favico.png">
    
</head>
<body>
<h1 style="text-align: center; font-weight: bold; color: #f5d544; text-shadow: 2px 2px #FF0000;"">FORM TAMBAH PRODUK</h1>
<form action="create.php" method="post" enctype="multipart/form-data">
    <label for="img_prod">Pilih Gambar:</label>
    <input type="file" id="img_prod" name="img_prod" accept="/img" onchange="previewImage()" required>
    <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; display: none;"><br><br>

    <label for="nama_barang">Nama Barang:</label>
    <input type="text" name="nama_barang" required><br>

    <label for="note">Deskripsi:</label>
    <textarea name="note" required></textarea><br>

    <label for="h_satuan">Harga:</label>
    <input type="text" name="h_satuan" required><br>

    <input type="submit" value="Simpan">
</form>    
</body>
<hr>
<footer class="reveal-text" style="color: white; font-family: Helvetica, sans-serif; text-shadow: 2px 2px #696969; font-weight: bold; text-align: center; background-color: #f57aae;">
  <p>Author : <a href="mailto:adwisravi@gmail.com" style="color: yellow;">AdRavi</a> | v. 1.0.240219.06.09</p>
</footer>
</html>
