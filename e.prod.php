<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<table id="myTable">
    <thead>
        <tr>
            <th>No.</th>
            <th>Barang</th>
            <th>Deskripsi</th>
            <th>EXE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'config.php';

        $sql = "SELECT * FROM tbl_toko";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["id_barang"]."</td>
                        <td style='text-align: center;'><img src='".$row["img_prod"]."' alt='nama_barang'><br><strong>".$row["nama_barang"]."</strong><br> Rp. ".number_format($row["h_satuan"], 2, ',', '.')."</td>
                        <td>".$row["note"]."</td>
                        <td>
                            <button onclick='editData(".$row["id_barang"].")'>Edit</button><br>
                            <button onclick='deleteData(".$row["id_barang"].")'>Hapus</button>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data.</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>

<script>
    function editData(id) {
        // Redirect to edit page with the ID as parameter
        window.location.href = 'edit_form.php?id=' + id;
    }

    function deleteData(id) {
        // You can implement delete functionality here
        // For example, you can use AJAX to send a request to delete.php with the ID
        // And then reload the page to reflect the changes
        alert('Delete function is not implemented yet.');
    }
</script>

</body>
</html>
