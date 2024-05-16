<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-auth-pusat.php";

if (isset($_GET['id'])) {
    $idPenggunaEdit = $_GET['id'];

    $query = "SELECT * FROM pengguna WHERE id_pengguna = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idPenggunaEdit);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
} else {
    $response['status'] = 'error';
    $response['message'] = 'ID tidak ada';

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPenggunaEdit = isset($_POST["idPengguna"]) ? $_POST["idPengguna"] : null;
    $namaPengguna = isset($_POST["namaPengguna"]) ? $_POST["namaPengguna"] : null;
    $bidang = isset($_POST["pilihBidang"]) ? $_POST["pilihBidang"] : null;
    $jabatan = isset($_POST["pilihJabatan"]) ? $_POST["pilihJabatan"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;

    $updateQuery = "UPDATE pengguna SET nama_pengguna = ?, id_bidang = ?, jabatan = ?, email = ?, password = ? WHERE id_pengguna = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sisssi", $namaPengguna, $bidang, $jabatan, $email, $password, $idPenggunaEdit);
    if ($updateStmt->execute()) {
        // Pembaruan berhasil
        $response['status'] = 'success';
        $response['message'] = 'Pengguna berhasil diubah!';
        header("Location: kelola.php");
    } else {
        // Pembaruan gagal
        $response['status'] = 'error';
        $response['message'] = 'Gagal mengubah pengguna: ' . $updateStmt->error;
    }
    $updateStmt->close();

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
    <title>Edit Pengguna</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>

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
                            <h1>Edit Pengguna</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/kepala-pusat/homepage">Home</a></li>
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/kepala-pusat/pengguna/kelola">Kelola Pengguna</a></li>
                                <li class="breadcrumb-item active">Edit Pengguna</li>
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
                                <h3 class="card-title">Mengubah Pengguna Sistem Persuratan</h3>
                            </div>
                            <form id="penggunaForm" method="post">
                                <input type="hidden" name="idPengguna" value="<?php echo $idPenggunaEdit; ?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div>
                                            <label for="namaPengguna">Nama Pengguna <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control form-control-border border-width-2" id="namaPengguna" name="namaPengguna" placeholder="Masukkan nama pengguna" value="<?php echo $row['nama_pengguna']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pilihBidang">Pilih Bidang <span style="color: red;">*</span></label>
                                        <select class="form-control select2" id="pilihBidang" name="pilihBidang">
                                            <option value="">--- Pilih Bidang ---</option>
                                            <?php
                                            // Ambil data bidang dari database
                                            $queryBidang = "SELECT * FROM bidang";
                                            $resultBidang = $conn->query($queryBidang);
                                            if ($resultBidang->num_rows > 0) {
                                                while ($rowBidang = $resultBidang->fetch_assoc()) {
                                                    $selected = ($rowBidang['id_bidang'] == $row['id_bidang']) ? 'selected' : '';
                                                    echo "<option value='" . $rowBidang['id_bidang'] . "' " . $selected . ">" . $rowBidang['nama_bidang'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="pilihJabatan">Pilih Jabatan <span style="color: red;">*</span></label>
                                        <select class="form-control select2" id="pilihJabatan" name="pilihJabatan">
                                            <option value="">--- Pilih Jabatan ---</option>
                                            <?php
                                            // Buat array yang berisi jabatan yang diperbolehkan
                                            $daftar_jabatan = array("Kepala Bidang", "Staff");

                                            // Iterasi melalui array jabatan yang diperbolehkan
                                            foreach ($daftar_jabatan as $jabatan) {
                                                // Cek apakah jabatan saat ini ada di array jabatan yang diperbolehkan
                                                $selected = ($row['jabatan'] == $jabatan) ? 'selected' : '';
                                                echo "<option value='" . $jabatan . "' " . $selected . ">" . $jabatan . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="email">Email <span style="color: red;">*</span></label>
                                            <input type="email" class="form-control form-control-border border-width-2" id="email" name="email" placeholder="Masukkan email pengguna" value="<?php echo $row['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div>
                                            <label for="password">Password <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control form-control-border border-width-2" id="password" name="password" placeholder="Masukkan password pengguna" value="<?php echo $row['password']; ?>">
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
            if (validateForm()) {
                document.getElementById("penggunaForm").submit();
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
                    confirmButtonText: 'OK'
                })
                return false;
            }
            return true;
        }
    </script>
</body>

</html>