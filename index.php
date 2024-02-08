<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO AKU</title>
    <style>
        /* CSS styling */
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            background-color: #f4f4f4;
        }

        a {
            text-decoration: none;
        }

        #tambahButton {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            width: 100%;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            cursor: pointer;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        img {
            max-width: 250px;
            max-height: 250px;
            /* width: auto;
            height: auto; */
            display: block;
            margin: auto;
        }

        button {
            padding: 8px;
            margin-bottom: 20px;
            background-color: grey;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center; /* Center-align the button within the column */
            display: block; /* Ensure it takes the full width of the container */
            margin: auto; /* Center horizontally */
        }
        /* Other styles */
        /* ... (Define other CSS styles as needed) ... */
    </style>
</head>
<body>
<h1 style="text-align: center; font-weight: bold;">APLIKASI KATALOG PRODUK TOKOKU</h1>
<a href="create.php"><button id="tambahButton">Tambah</button></a>
<hr>
    <table id="myTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">No.</th>
                <th onclick="sortTable(1)">Barang</th>
                <th>Deskripsi</th>
                <!-- <th>EXE</th> -->
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
            window.location.href = "edit_prod.php?id_barang=" + id;
        }

        function deleteData(id) {
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                window.location.href = "c.delete.php?id_barang=" + id;
            }
        }

        function sortTable(col) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            dir = "asc";

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[col];
                    y = rows[i + 1].getElementsByTagName("TD")[col];

                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>
</html>
