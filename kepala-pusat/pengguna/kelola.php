<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-auth-pusat.php";

$query = "SELECT *
FROM pengguna
INNER JOIN bidang ON pengguna.id_bidang = bidang.id_bidang";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Pengguna</title>

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
                            <h1>Kelola Pengguna</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/sistem-persuratan-puskod/tata-usaha/homepage.php">Home</a></li>
                                <li class="breadcrumb-item active">Kelola Pengguna</li>
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
                            <div class="card-header align-center">
                                <a href="tambah">
                                    <button type="button" class="btn btn-primary btn-block" style="max-width: 200px;">
                                        <i class="fas fa-plus" style="margin-right: 8px;"></i>Tambah Pengguna
                                    </button>
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive card-padding">
                                    <table id="tabelPengguna" class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Pengguna</th>
                                                <th>Email</th>
                                                <th>Jabatan</th>
                                                <th>Bidang</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row["nama_pengguna"]; ?></td>
                                                        <td><?php echo $row["email"]; ?></td>
                                                        <td><?php echo $row["jabatan"]; ?></td>
                                                        <td><?php echo $row["nama_bidang"]; ?></td>
                                                        <td class="text-center">
                                                            <div style="display: inline-block;">
                                                                <a href='edit?id=<?php echo $row["id_pengguna"]; ?>' class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                            </div>
                                                            <a href='#' class='btn btn-danger delete-btn' data-id='<?php echo $row["id_pengguna"]; ?>'><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "Tidak ada pengguna";
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

            var table = $('#tabelPengguna').DataTable({
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

            $('#tabelPengguna').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var userId = $(this).data('id');

                // Tampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data pengguna ini akan dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, lakukan penghapusan
                        window.location.href = 'hapus.php?id=' + userId;
                    }
                });
            });

        })
    </script>
</body>

</html>