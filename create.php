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
    $img_dest = 'image/' . $img_name;

    // Memindahkan file gambar ke direktori "uploads"
    if(move_uploaded_file($img_tmp, $img_dest)) {
        // Menyimpan data ke database
        $sql = "INSERT INTO tbl_toko (img_prod, nama_barang, note, h_satuan) VALUES ('$img_dest', '$nama_barang', '$note', '$h_satuan')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); // Redirect kembali ke halaman utama setelah menambahkan data
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
    <title>Document</title>
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

input[type="text"],
input[type="file"],
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

/* Styling untuk tampilan responsif (opsional) */
@media screen and (max-width: 600px) {
    form {
        margin: 10px;
    }
}

    </style>
</head>
<body>
<h1 style="text-align: center; font-weight: bold;">FORM TAMBAH PRODUK</h1>
<form action="create.php" method="post" enctype="multipart/form-data">
    <label for="img_prod">Pilih Gambar:</label>
    <input type="file" id="img_prod" name="img_prod" accept="/img" onchange="previewImage()" required>
    <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; display: none;"><br>

    <label for="nama_barang">Nama Barang:</label>
    <input type="text" name="nama_barang" required><br>

    <label for="note">Deskripsi:</label>
    <textarea name="note" required></textarea><br>

    <label for="h_satuan">Harga:</label>
    <input type="text" name="h_satuan" required><br>

    <input type="submit" value="Simpan">
</form>    
</body>
</html>
