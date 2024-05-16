<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-auth-kabid.php";
$idPengguna = $_SESSION['id'];

$querySuratTerkirim = "SELECT COUNT(*) AS jumlah_terkirim
FROM penerima_surat
WHERE id_pengirim = ?";
if ($stmt = $conn->prepare($querySuratTerkirim)) {
    $stmt->bind_param("s", $idPengguna);
    $stmt->execute();
    $resultSuratTerkirim = $stmt->get_result();
    $stmt->close();
    $rowSuratTerkirim = $resultSuratTerkirim->fetch_assoc();
    $jumlahSuratTerkirim = $rowSuratTerkirim['jumlah_terkirim'];
} else {
    echo "Gagal melakukan persiapan statement SQL.";
}

$querySuratTerima = "SELECT COUNT(*) AS jumlah_terima
FROM penerima_surat
WHERE id_penerima = ?";
if ($stmt = $conn->prepare($querySuratTerima)) {
    $stmt->bind_param("s", $idPengguna);
    $stmt->execute();
    $resultSuratTerima = $stmt->get_result();
    $stmt->close();
    $rowSuratTerima = $resultSuratTerima->fetch_assoc();
    $jumlahSuratTerima = $rowSuratTerima['jumlah_terima'];
} else {
    echo "Gagal melakukan persiapan statement SQL.";
}

$queryBelumBaca = "SELECT COUNT(*) AS jumlah
FROM penerima_surat
WHERE id_penerima = ? AND status_baca = 'BELUM'";

if ($stmt = $conn->prepare($queryBelumBaca)) {
    $stmt->bind_param("s", $idPengguna);
    $stmt->execute();
    $resultBelumBaca = $stmt->get_result();
    $stmt->close();
    $rowBelumBaca = mysqli_fetch_assoc($resultBelumBaca);
    $jumlahBelumBaca = $rowBelumBaca['jumlah'];
} else {
    echo "Gagal melakukan persiapan statement SQL.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>
    <style>
    .carousel-item img {
        max-height: 500px; 
        object-fit: cover;
    }
</style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <?php
        include $rootPath . "/sistem-persuratan-puskod/components/navbar.php";
        include $rootPath . "/sistem-persuratan-puskod/components/sidebar-kabid.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Homepage</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Homepage</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php echo $jumlahSuratTerkirim ?></h3>

                                    <p>Surat Terkirim</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php echo $jumlahSuratTerima ?></h3>

                                    <p>Surat Diterima</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php echo $jumlahBelumBaca ?></h3>

                                    <p>Surat Belum Dibaca</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->
                    <div class="card-body">
                        <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators3" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="2"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="3"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="4"></li>
                                <li data-target="#carouselExampleIndicators3" data-slide-to="5"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="/sistem-persuratan-puskod/assets/image/1.jpeg" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="/sistem-persuratan-puskod/assets/image/2.jpeg" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="/sistem-persuratan-puskod/assets/image/3.jpeg" alt="Third slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="/sistem-persuratan-puskod/assets/image/4.jpeg" alt="Fourth slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="/sistem-persuratan-puskod/assets/image/5.jpeg" alt="Fifth slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <!-- /.row (main row) -->
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

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/script.html";
    ?>
</body>

</html>