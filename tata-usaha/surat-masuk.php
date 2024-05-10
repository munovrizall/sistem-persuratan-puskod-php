<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-with-auth.php";

$namaLengkap = $_SESSION['namaLengkap'];
$idPengguna = $_SESSION['id'];

$query = "SELECT surat.*, pengguna.nama_pengguna AS nama_pengirim, penerima_surat.*
FROM surat
INNER JOIN penerima_surat ON surat.id_surat = penerima_surat.id_surat
INNER JOIN pengguna ON penerima_surat.id_pengirim = pengguna.id_pengguna
WHERE penerima_surat.id_penerima = ?
ORDER BY surat.tanggal_dibuat DESC";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $idPengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    echo "Gagal melakukan persiapan statement SQL.";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Masuk</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>
    <style>
        #tabelSurat tbody tr:hover {
            cursor: pointer;
        }
    </style>


<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <?php
        include $rootPath . "/sistem-persuratan-puskod/components/navbar.php";
        include $rootPath . "/sistem-persuratan-puskod/components/sidebar.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Surat Masuk</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/homepage.php">Home</a></li>
                                <li class="breadcrumb-item active">Surat Masuk</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">

                            <div class="card-body p-0">
                                <div class="table-responsive card-padding">
                                    <table id="tabelSurat" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Pengirim</th>
                                                <th>Subjek Surat</th>
                                                <th>Tanggal Diterima</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $tanggal = date('H:i d-m-Y', strtotime($row["tanggal_dibuat"]));
                                                    $style = ($row["status_baca"] == 'BELUM') ? 'font-weight:bold;' : '';
                                            ?>
                                                    <tr onclick="window.location='detail-surat.php?id=<?php echo $row["id_penerima_surat"]; ?>'" style="<?php echo $style; ?>">
                                                        <td><?php echo $row["nama_pengirim"]; ?></td>
                                                        <td><?php echo $row["subjek_surat"]; ?></td>
                                                        <td><?php echo $tanggal; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } 
                                            ?>
                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php
        include $rootPath . "/sistem-persuratan-puskod/components/footer.html";
        ?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/script.html";
    ?>
    <!-- Page specific script -->
    <script>
        $(document).ready(function() {

            var table = $('#tabelSurat').DataTable({
                fixedHeader: true,
                responsive: true,
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data per halaman',
                    zeroRecords: 'Data tidak ditemukan',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                },
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 data', '25 data', '50 data', 'Semua data']
                ],
                buttons: [
                    'pageLength', 'copy',
                    {
                        extend: 'spacer',
                        style: 'bar',
                        text: 'Export files:'
                    },
                    'csv', 'excel', 'pdf', 'print',
                ],
                order: [],
            });
        })
    </script>
</body>

</html>