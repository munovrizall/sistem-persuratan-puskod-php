<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-auth-pusat.php";

$queryPengguna = "SELECT pengguna.*, bidang.*
FROM pengguna
INNER JOIN bidang ON pengguna.id_bidang = bidang.id_bidang
WHERE pengguna.id_bidang = '2'
ORDER BY bidang.id_bidang ASC";
$resultPengguna = $conn->query($queryPengguna);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPengirim = $_SESSION['id'];
    $pilihPenerima = $_POST["pilihPenerima"];
    $nomorSurat = $_POST["nomorSurat"];
    $subjekSurat = $_POST["subjekSurat"];
    $isiSurat = $_POST["isiSurat"];
    date_default_timezone_set('Asia/Jakarta');
    $tanggalDibuat = date('Y-m-d H:i:s');

    // Periksa apakah file telah diunggah dengan benar
    if (isset($_FILES['fileSurat']) && $_FILES['fileSurat']['error'] === UPLOAD_ERR_OK) {
        // Tangani unggahan file
        $fileSurat = $_FILES['fileSurat'];
        $uploadPath = $rootPath . "/sistem-persuratan-puskod/docs/" . basename($fileSurat['name']);

        if (!is_dir(dirname($uploadPath))) {
            mkdir(dirname($uploadPath), 0777, true);
        }

        if (move_uploaded_file($fileSurat['tmp_name'], $uploadPath)) {
            // Simpan data ke dalam database menggunakan koneksi yang telah disediakan sebelumnya
            $querySurat = "INSERT INTO surat (no_surat, subjek_surat, isi_surat, file_surat, nama_file_surat, tanggal_dibuat) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($querySurat);
            $stmt->bind_param("ssssss", $nomorSurat, $subjekSurat, $isiSurat, $uploadPath, $fileSurat['name'], $tanggalDibuat);
            $stmt->execute();
            $idSurat = $stmt->insert_id;
            $stmt->close();

            foreach ($pilihPenerima as $idPenerima) {
                $queryPenerima = "INSERT INTO penerima_surat (id_penerima, id_surat, id_pengirim) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($queryPenerima);
                $stmt->bind_param("iii", $idPenerima, $idSurat, $idPengirim);
                $stmt->execute();
                $stmt->close();
            }

            $response['status'] = 'success';
            $response['message'] = 'Surat berhasil terkirim!';

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menyimpan file!';

            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'File surat tidak diunggah dengan benar!';

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}


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
        include $rootPath . "/sistem-persuratan-puskod/components/sidebar-pusat.php";
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
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/kepala-pusat/homepage.php">Home</a></li>
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
                                <form id="suratForm" enctype="multipart/form-data" method="post" action="buat-surat.php">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <select class="select2" multiple="multiple" id="pilihPenerima" name="pilihPenerima[]" data-placeholder="Kepada: ">
                                                <?php
                                                while ($rowPengguna = $resultPengguna->fetch_assoc()) {
                                                    echo '<option value="' . $rowPengguna['id_pengguna'] . '">' . $rowPengguna['nama_bidang'] . ' - ' . $rowPengguna['nama_pengguna'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" id="nomorSurat" name="nomorSurat" placeholder="Nomor surat:">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" id="subjekSurat" name="subjekSurat" placeholder="Subjek surat:">
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="fileSurat" name="fileSurat">
                                                    <label class="custom-file-label" for="fileSurat">Pilih File Lampiran</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea id="isiSurat" name="isiSurat" class="form-control" style="min-height: 800px">

                    </textarea>
                                        </div>
                                    </div>

                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="float-right">
                                            <button type="submit" id="submitButton" class="btn btn-primary"><i class="fas fa-paper-plane" style="margin-right: 8px"></i> Kirim</button>
                                        </div>
                                    </div>
                                </form>
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

        $("#suratForm").submit(function(e) {
            event.preventDefault();
            if (validateForm()) {
                validateSuccess();
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "buat-surat.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Surat berhasil terkirim!',
                            showCancelButton: false,
                            confirmButtonColor: '#855b2f',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap lengkapi semua formulir!',
                    showCancelButton: false,
                    confirmButtonColor: '#855b2f',
                    confirmButtonText: 'OK'
                });
            }
        });

        function validateForm() {
            var pilihPenerima = document.getElementById("pilihPenerima").value;
            var nomorSurat = document.getElementById("nomorSurat").value;
            var subjekSurat = document.getElementById("subjekSurat").value;
            var isiSurat = document.getElementById("isiSurat").value;
            var fileSurat = document.getElementById("fileSurat").value;
            if (pilihPenerima === "" || nomorSurat === "" || subjekSurat === "" || isiSurat === "" || fileSurat === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap lengkapi semua formulir!',
                    showCancelButton: false,
                    confirmButtonColor: '#855b2f',
                    confirmButtonText: 'OK'
                })
                return false;
            }
            return true;
        }

        function validateSuccess() {
            // Get the form data
            var formData = $("#suratForm").serialize();
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "buat-surat.php",
                data: formData,
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Surat berhasil terkirim!',
                        showCancelButton: false,
                        confirmButtonColor: '#855b2f',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });

                },
                error: function(error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal mengirim surat!',
                        showCancelButton: false,
                        confirmButtonColor: '#855b2f',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    </script>
</body>

</html>