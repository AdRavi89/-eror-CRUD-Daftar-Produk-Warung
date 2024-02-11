<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKO AKU</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Home<span></span></a>
        <a href="katalog.php">Katalog<span></span></a>
        <!-- <a href="#">About<span></span></a>
        <a href="#">Service<span></span></a>
        <a href="#">Contact<span></span></a>
        <a href="#">Help<span></span></a> -->
    </nav>
    <hr>
    <div class="content">
        <h1 style="text-align: center; font-weight: bold; color: #f5d544; text-shadow: 2px 2px #FF0000;">KATALOG PRODUK TOKOKU</h1>
        <a href="create.php"><button id="tambahButton">Tambah</button></a>
        <hr>
        <table id="myTable">
            <thead>
                <tr>
                    <!-- <th onclick="sortTable(0)">No.</th> -->
                    <!-- <td style='text-align: center;'>".$row["id_barang"]."</td> bagian PHPnya-->
                    <th onclick="sortTable(1)">Barang</th>
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
                                
                                <td style='text-align: center;'><img src='".$row["img_prod"]."' alt='nama_barang' style='max-width: 100%; height: auto;'><br><strong>".$row["nama_barang"]."</strong><br> Rp. ".number_format($row["h_satuan"], 2, ',', '.')."</td>
                                <td>".$row["note"]."</td>
                                <td>
                                    <button onclick='editData(".$row["id_barang"].")' class='btn btn-info btn-sm btn-block'><i class='fa fa-edit'></i></button>
                                    <button onclick='deleteData(".$row["id_barang"].")' class='btn btn-danger btn-sm btn-block'><i class='fa fa-trash'></i></button>
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
    </div>
    <script>
        function editData(id) {
            window.location.href = "edit_prod.php?id_barang=" + id;
        }

        function deleteData(id) {
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                window.location.href = "c/c.delete.php?id_barang=" + id;
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
