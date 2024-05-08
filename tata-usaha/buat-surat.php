<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-with-auth.php";

$queryPengguna = "SELECT pengguna.*, bidang.*
FROM pengguna
INNER JOIN bidang ON pengguna.id_bidang = bidang.id_bidang
ORDER BY bidang.id_bidang ASC";
$resultPengguna = $conn->query($queryPengguna);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Surat</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>

    <style>
        .select2-container--bootstrap4 .select2-selection {
            padding-left: 8px;
        }
    </style>
</head>

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
                            <h1>Buat Surat</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/homepage.php">Home</a></li>
                                <li class="breadcrumb-item active">Buat Surat</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Membuat Surat Baru</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <select class="select2" multiple="multiple" data-placeholder="Kepada: ">
                                            <?php
                                            while ($rowPengguna = $resultPengguna->fetch_assoc()) {
                                                echo '<option value="' . $rowPengguna['id_bidang'] . '">' . $rowPengguna['nama_bidang'] . ' - ' . $rowPengguna['nama_pengguna'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Nomor surat:">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Subjek surat:">
                                    </div>
                                    <div class="form-group">
                                        <textarea id="isiSurat" class="form-control" style="min-height: 800px">

                    </textarea>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="fileSurat" name="fileSurat">
                                                <label class="custom-file-label" for="fileSurat">Pilih File Lampiran</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <div class="float-right">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane" style="margin-right: 8px"></i> Kirim</button>
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

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/script.html";
    ?>
    <!-- Select2  -->
    <script src="/sistem-persuratan-puskod/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/sistem-persuratan-puskod/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            $('#fileSurat').on('change', handleFileChange);
        });

        function handleFileChange() {
            // Menampilkan nama file yang dipilih di label custom-file-label
            var fileName = $('#fileSurat')[0].files[0].name;
            $('.custom-file-label').html(fileName);
        }

        $(function() {
            //Add text editor
            $('#isiSurat').summernote({
                minHeight: 200,
            })
        })
    </script>
</body>

</html>