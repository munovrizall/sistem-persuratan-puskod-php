<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-with-auth.php";

$query = "SELECT *
FROM pengguna
INNER JOIN bidang ON pengguna.id_bidang = bidang.id_bidang";
$result = $conn->query($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPengguna = $_POST["namaPengguna"];
    $bidang = $_POST["pilihBidang"];
    $jabatan = $_POST["pilihJabatan"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $insertQuery = "INSERT INTO pengguna (nama_pengguna, id_bidang, jabatan, email, password) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("sisss", $namaPengguna, $bidang, $jabatan, $email, $password);
    $insertStmt->execute();
    $insertStmt->close();

    $response['status'] = 'success';
    $response['message'] = 'Pengguna berhasil ditambah!';

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
    <title>Tambah Pengguna</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php
        include $rootPath . "/sistem-persuratan-puskod/components/navbar.php";
        include $rootPath . "/sistem-persuratan-puskod/components/sidebar-super.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Tambah Pengguna</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/homepage.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/pengguna/kelola.php">Kelola Pengguna</a></li>
                                <li class="breadcrumb-item active">Tambah Pengguna</li>
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
                            <div class="card-header">
                                <h3 class="card-title">Menambah Pengguna Sistem Persuratan</h3>
                            </div>
                            <form id="penggunaForm">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <label for="namaPengguna">Nama Pengguna <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control form-control-border border-width-2" id="namaPengguna" name="namaPengguna" placeholder="Masukkan nama pengguna">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pilihBidang">Pilih Bidang <span style="color: red;">*</span></label>
                                        <select class="form-control select2" id="pilihBidang" name="pilihBidang">
                                            <option value="">--- Pilih Bidang ---</option>
                                            <option value="1">Kepala Pusat</option>
                                            <option value="2">Tata Usaha</option>
                                            <option value="3">Perencanaan Administrasi Kodifikasi</option>
                                            <option value="4">Tata Kelola</option>
                                            <option value="5">Pengembangan Kodifikasi</option>
                                            <option value="6">Sistem Informasi Kodifikasi</option>
                                            <option value="7">Operasional Kodifikasi</option>
                                            <option value="8">Nomenlaktur dan Klasifikasi</option>
                                            <option value="9">Identifikasi dan Kodifikasi</option>
                                            <option value="10">Validasi Data Kodifikasi</option>
                                            <option value="11">Dukungan Teknis Kodifikasi</option>
                                            <option value="12">Kerjasama dan Pelatihan Kodifikasi</option>
                                            <option value="13">Publikasi Katalog Materiil</option>
                                            <option value="14">Fungsional Kataloger</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="pilihJabatan">Pilih Jabatan <span style="color: red;">*</span></label>
                                        <select class="form-control select2" id="pilihJabatan" name="pilihJabatan">
                                            <option value="">--- Pilih Jabatan ---</option>
                                            <option value="Kepala Bidang">Kepala Bidang</option>
                                            <option value="Staff">Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="email">Email <span style="color: red;">*</span></label>
                                            <input type="email" class="form-control form-control-border border-width-2" id="email" name="email" placeholder="Masukkan email pengguna">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="password">Password <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control form-control-border border-width-2" id="password" name="password" placeholder="Masukkan password pengguna">
                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                            </form>
                            <!-- /.card-body -->
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" id="submitButton" class="btn btn-primary" onclick="submitForm()">Submit</button>
                            </div>
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
    <script src="/sistem-persuratan-puskod/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <script>
        function submitForm() {
            event.preventDefault();
            if (validateForm()) {
                validateSuccess();
                Swal.fire({
                    icon: 'success',
                    title: 'Akun berhasil dibuat!',
                    showCancelButton: false,
                    confirmButtonColor: '#855b2f',
                    confirmButtonText: 'OK (enter)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'kelola.php';
                    }
                });
            }
        }
        
        function validateForm() {
            var namaPengguna = document.getElementById("namaPengguna").value;
            var pilihBidang = document.getElementById("pilihBidang").value;
            var pilihJabatan = document.getElementById("pilihJabatan").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            if (namaPengguna === "" || pilihBidang === "" || pilihJabatan === "" || email === "" || password === "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Harap lengkapi semua formulir!',
                    showCancelButton: false,
                    confirmButtonColor: '#855b2f',
                    confirmButtonText: 'OK (enter)'
                })
                return false;
            }
            return true;
        }

        function validateSuccess() {
            // Get the form data
            var formData = $("#penggunaForm").serialize();

            $.ajax({
                type: "POST",
                url: "tambah.php",
                data: formData,
                dataType: "json",
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pengguna berhasil ditambahkan!',
                        showCancelButton: false,
                        confirmButtonColor: '#855b2f',
                        confirmButtonText: 'OK (enter)'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'kelola.php';
                        }
                    });

                },
                error: function(error) {
                    alert("Gagal Menambahkan akun");
                }
            });
        }

    </script>
</body>

</html>