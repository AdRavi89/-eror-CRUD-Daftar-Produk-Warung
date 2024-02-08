<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Belanja</title>
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

// Inisialisasi nilai default untuk $id_barang
$id_barang = '';
$nama_barang ='';

// Jika id_barang tersedia dalam URL, ambil nilainya
if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    // Ambil nama barang dari database berdasarkan id_barang
    $sql_nama_barang = "SELECT nama_barang FROM tbl_toko WHERE id_barang = '$id_barang'";
    $result_nama_barang = $conn->query($sql_nama_barang);
    if ($result_nama_barang->num_rows > 0) {
        $row_nama_barang = $result_nama_barang->fetch_assoc();
        $nama_barang = $row_nama_barang['nama_barang'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Mengambil nilai id_barang dari formulir jika tersedia
    if(isset($_POST['id_barang'])) {
        $id_barang = $_POST['id_barang'];
    }
    // $id_barang = $_POST['id_barang'];
    $tgl_belanja = $_POST['tgl_belanja'];
    $nm_toko = $_POST['nm_toko'];
    $h_toko = $_POST['h_toko'];
    $satuan = $_POST['satuan'];
    $isi = $_POST['isi'];

    $sql = "INSERT INTO tbl_prod (id_barang, tgl_belanja, nm_toko, h_toko, satuan, isi)
            VALUES ('$id_barang', '$tgl_belanja','$nm_toko', '$h_toko', '$satuan', '$isi')";

    if ($conn->query($sql) === TRUE) {
        echo "Data Berhasil Disimpan.";
        // Tunda redirect selama 2 detik
        sleep(2);
        // Redirect ke halaman edit_prod.php dengan menyertakan parameter id_barang
        header("Location: edit_prod.php?id_barang=$id_barang");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<form method="POST" action="">
    <label for="id_nama_barang">ID & Nama Barang:</label>
    <input type="text" id="id_nama_barang" name="id_nama_barang" value="[ ID : <?php echo $id_barang . ' ] - ' . $nama_barang; ?>" readonly>
    <input type="hidden" id="id_barang" name="id_barang" value="<?php echo $id_barang; ?>">


    <!-- <select id="id_barang" name="id_barang" required> -->
        <!-- Isi dropdown dengan data dari tbl_toko -->
        <?php
        // include 'config.php';
        // $sql = "SELECT id_barang, nama_barang FROM tbl_toko";
        // $result = $conn->query($sql);

        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         echo "<option value='" . $row['id_barang'] . "'>" . $row['nama_barang'] . "</option>";
        //     }
        // }
        ?>
    <!-- </select> -->

    <label for="tgl_belanja">Tgl. Belanja:</label>
    <input type="date" id="tgl_belanja" name="tgl_belanja" required>

    <label for="nm_toko">Nama Toko:</label>
    <input type="text" id="nm_toko" name="nm_toko" required>

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
