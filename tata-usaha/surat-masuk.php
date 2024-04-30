<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-with-auth.php";

$namaLengkap = $_SESSION['namaLengkap'];
$query = "SELECT surat.*, pengguna.nama_pengguna AS nama_pengirim, penerima_surat.*
FROM surat
INNER JOIN pengguna ON surat.id_pengirim = pengguna.id_pengguna
INNER JOIN penerima_surat ON surat.id_surat = penerima_surat.id_surat
WHERE nama_pengguna = ?
ORDER BY surat.tanggal_dibuat DESC";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $namaLengkap);
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


<body class="hold-transition sidebar-mini">
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
                                                    <tr onclick="window.location='detail-surat.php?id=<?php echo $row["id_surat"]; ?>'" style="<?php echo $style; ?>">
                                                        <td><?php echo $row["nama_pengirim"]; ?></td>
                                                        <td><?php echo $row["subjek_surat"]; ?></td>
                                                        <td><?php echo $tanggal; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "Tidak ada surat masuk";
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

    <!-- jQuery -->
    <script src="../adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../adminlte/dist/js/adminlte.min.js"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-print-2.4.2/fh-3.4.0/r-2.5.0/rg-1.4.1/sb-1.6.0/sp-2.2.0/datatables.min.js"></script>
    <script src="https:////code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
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