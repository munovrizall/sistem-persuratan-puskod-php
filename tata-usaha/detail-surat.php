<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-with-auth.php";

$namaLengkap = $_SESSION['namaLengkap'];

if (isset($_GET['id'])) {
    $id_surat = $_GET['id'];

    $query = "SELECT surat.*, pengguna.nama_pengguna AS nama_pengirim, penerima_surat.*
    FROM surat
    INNER JOIN pengguna ON surat.id_pengirim = pengguna.id_pengguna
    INNER JOIN penerima_surat ON surat.id_surat = penerima_surat.id_surat
    WHERE surat.id_surat = ?
    ORDER BY surat.tanggal_dibuat DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_surat);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Surat tidak ditemukan.";
    }

    $updateQuery = "UPDATE penerima_surat SET status_baca = 'SUDAH' WHERE id_surat = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("i", $id_surat);
    $updateStmt->execute();
} else {
    echo "ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Surat</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>
</head>

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
                            <h1>Detail Surat</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/homepage.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/surat-masuk.php">Surat Masuk</a></li>
                                <li class="breadcrumb-item active">Detail Surat</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if (isset($_GET['id'])) {
                            $surat_id = $_GET['id'];
                            $tanggal = date('H:i d-m-Y', strtotime($row["tanggal_dibuat"]));
                        } ?>
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-body p-0">
                                    <div class="mailbox-read-info">
                                        <h5><?php echo $row["subjek_surat"] ?></h5>
                                        <h6>From: <?php echo $row["nama_pengirim"] ?>
                                            <span class="mailbox-read-time float-right"><?php echo $tanggal ?></span>
                                        </h6>
                                    </div>

                                    <div class="mailbox-read-message">
                                        <?php echo $row["isi_surat"] ?>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <!-- /.card-footer -->
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="button" onclick="window.history.back();" class="btn btn-primary"><i class="fas fa-arrow-left" style="margin-right: 8px"></i> Kembali</button>
                                    </div>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
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
</body>

</html>