<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-auth-tu.php";

$queryPengguna = "SELECT pengguna.*, bidang.*
FROM pengguna
INNER JOIN bidang ON pengguna.id_bidang = bidang.id_bidang
ORDER BY bidang.id_bidang ASC";
$resultPengguna = $conn->query($queryPengguna);

$idSurat = isset($_GET['id_surat']) ? $_GET['id_surat'] : '';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idSurat = isset($_GET['id_surat']) ? $_GET['id_surat'] : '';

    if ($idSurat) {
        $query = "SELECT * FROM surat WHERE id_surat = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $idSurat);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
        } else {
            echo "Gagal melakukan persiapan statement SQL.";
            exit;
        }
    } else {
        echo "ID surat tidak ditemukan.";
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPengirim = $_SESSION['id'];
    $pilihPenerima = $_POST["pilihPenerima"];
    $nomorSurat = $_POST["nomorSurat"];
    $subjekSurat = $_POST["subjekSurat"];
    $isiSurat = $_POST["isiSurat"];
    $fileSurat = $_POST['fileSurat'];
    $namaFileSurat = $_POST['namaFileSurat'];
    date_default_timezone_set('Asia/Jakarta');
    $tanggalDibuat = date('Y-m-d H:i:s');

    // Simpan data ke dalam database menggunakan koneksi yang telah disediakan sebelumnya
    $querySurat = "INSERT INTO surat (no_surat, subjek_surat, isi_surat, file_surat, nama_file_surat, tanggal_dibuat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($querySurat);
    $stmt->bind_param("ssssss", $nomorSurat, $subjekSurat, $isiSurat, $fileSurat, $namaFileSurat, $tanggalDibuat);
    $stmt->execute();
    $idSurat = $stmt->insert_id;
    $stmt->close();

    foreach ($pilihPenerima as $idPenerima) {
        $queryPenerima = "INSERT INTO penerima_surat (id_penerima, id_surat, id_pengirim) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($queryPenerima);
        $stmt->bind_param("iii", $idPenerima, $idSurat, $idPengirim);
        $stmt->execute();
    }

    if ($stmt->close()) {
        // Pembaruan berhasil
        $response['status'] = 'success';
        $response['message'] = 'Pengguna berhasil diubah!';
        echo "<script>
            alert('Surat berhasil terkirim');
            window.location.href = 'surat-masuk.php';
          </script>";
    exit;
    } else {
        // Pembaruan gagal
        $response['status'] = 'error';
        $response['message'] = 'Gagal mengubah pengguna: ' . $stmt->error;
    }
    $response['status'] = 'success';
    $response['message'] = 'Surat berhasil terkirim!';

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teruskan Surat</title>

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
        include $rootPath . "/sistem-persuratan-puskod/components/sidebar-tu.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Teruskan Surat</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/homepage.php">Home</a></li>
                                <li class="breadcrumb-item active">Teruskan Surat</li>
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
                                    <h3 class="card-title">Meneruskan Surat</h3>
                                </div>
                                <!-- /.card-header -->
                                <form id="suratForm" enctype="multipart/form-data" method="post" action="teruskan-surat.php">
                                    <div class="card-body">
                                        <input type="hidden" name="id_surat" value="<?php echo $row['id_surat']; ?>">
                                        <div class="form-group">
                                            <select class="select2" multiple="multiple" id="pilihPenerima" name="pilihPenerima[]" data-placeholder="Kepada: ">
                                                <?php
                                                while ($rowPengguna = $resultPengguna->fetch_assoc()) {
                                                    echo '<option value="' . $rowPengguna['id_pengguna'] . '">' . $rowPengguna['nama_bidang'] . ' - ' . $rowPengguna['nama_pengguna'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <input type="hidden" id="nomorSurat" name="nomorSurat" value="<?php echo $row['no_surat']; ?>">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Nomor surat:" value="<?php echo $row['no_surat']; ?>" disabled>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" id="subjekSurat" name="subjekSurat" placeholder="Subjek surat:">
                                        </div>
                                        <input type="hidden" id="fileSurat" name="fileSurat" value="<?php echo $row['file_surat']; ?>">
                                        <input type="hidden" id="namaFileSurat" name="namaFileSurat" value="<?php echo $row['nama_file_surat']; ?>">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" disabled>
                                                    <label class="custom-file-label" for="fileSurat"><?php echo $row['nama_file_surat']; ?></label>
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
                                            <button type="submit" id="submitButton" class="btn btn-primary" onclick="submitForm()"><i class="fas fa-paper-plane" style="margin-right: 8px"></i> Kirim</button>
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

        function submitForm() {
            if (validateForm()) {
                document.getElementById("suratForm").submit();
            }
        }

        function validateForm() {
            var pilihPenerima = document.getElementById("pilihPenerima").value;
            var subjekSurat = document.getElementById("subjekSurat").value;
            var isiSurat = document.getElementById("isiSurat").value;
            if (pilihPenerima === "" || subjekSurat === "" || isiSurat === "") {
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
    </script>
</body>

</html>