<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <nav>
    <a href="index.php">Home<span></span></a>
    <a href="katalog.php">Katalog<span></span></a>
    </nav>
    <hr>
    <br>
    <div class="gallery">
        <?php
        // Nama folder yang berisi gambar
        $folder = 'image';

        // Ambil daftar file dari folder
        $files = scandir($folder);

        // Loop melalui setiap file dalam folder
        foreach($files as $file) {
            // Hanya tampilkan file dengan ekstensi jpg, jpeg, png, atau gif
            $file_extension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($file_extension, array('jpg', 'jpeg', 'png', 'gif'))) {
                // Tampilkan gambar dalam tag img
                echo '<img src="' . $folder . '/' . $file . '" alt="' . $file . '">';
            }
        }
        ?>
    </div>
</body>
</html>
