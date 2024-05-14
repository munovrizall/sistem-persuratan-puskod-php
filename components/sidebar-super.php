<?php
$current_page = basename($_SERVER['PHP_SELF']);
$namaLengkap = $_SESSION['namaLengkap'];
$idPengguna = $_SESSION['id'];

$queryBelumBaca = "SELECT COUNT(*) AS jumlah
FROM penerima_surat
WHERE id_penerima = ? AND status_baca = 'BELUM'";

if ($stmt = $conn->prepare($queryBelumBaca)) {
    $stmt->bind_param("s", $idPengguna);
    $stmt->execute();
    $resultBelumBaca = $stmt->get_result();
    $stmt->close();
    $rowBelumBaca = mysqli_fetch_assoc($resultBelumBaca);
} else {
    echo "Gagal melakukan persiapan statement SQL.";
}

?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/sistem-persuratan-puskod/tata-usaha/homepage" class="brand-link">
        <img src="/sistem-persuratan-puskod/assets/image/logo-kemhan.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">Pusat Kodifikasi</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/sistem-persuratan-puskod/assets/image/user.png" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $namaLengkap ?></a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                <li>
                    <button onclick="window.location.href='/sistem-persuratan-puskod/tata-usaha/buat-surat'" class="btn btn-block btn-primary" style="margin-bottom: 24px">
                        <i class="nav-icon fas fa-plus"></i> Buat Surat
                    </button>
                </li>
                <li class="nav-item">
                    <a href="/sistem-persuratan-puskod/tata-usaha/homepage" class="nav-link 
                    <?php
                    echo (
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/homepage')
                    )
                        ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Homepage
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/sistem-persuratan-puskod/tata-usaha/surat-masuk" class="nav-link 
                    <?php
                    echo (
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/surat-masuk')  ||
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/surat-masuk-detail')
                    )
                        ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-inbox"></i>
                        <?php if ($rowBelumBaca["jumlah"] > 0) : ?>
                            <span class="badge badge-danger right"><?php echo $rowBelumBaca["jumlah"] ?></span>
                        <?php endif; ?>
                        <p>
                            Surat Masuk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/sistem-persuratan-puskod/tata-usaha/surat-keluar" class="nav-link 
                    <?php
                    echo (
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/surat-keluar') ||
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/surat-keluar-detail')
                    )
                        ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-paper-plane"></i>
                        <p>
                            Surat Keluar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/sistem-persuratan-puskod/tata-usaha/pengguna/kelola" class="nav-link 
                    <?php
                    echo (
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/pengguna/kelola') ||
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/pengguna/tambah') ||
                        strpos($_SERVER['REQUEST_URI'], 'sistem-persuratan-puskod/tata-usaha/pengguna/edit')
                    )
                        ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Kelola Pengguna
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>