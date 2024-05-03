<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
include $rootPath . "/sistem-persuratan-puskod/config/connection-with-auth.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $userId = $_GET["id"];

    // Periksa apakah pengguna dengan ID tertentu ada di database
    $checkUserQuery = "SELECT * FROM pengguna WHERE id_pengguna = ?";
    $stmtCheckUser = $conn->prepare($checkUserQuery);
    $stmtCheckUser->bind_param("i", $userId);
    $stmtCheckUser->execute();
    $resultCheckUser = $stmtCheckUser->get_result();

    if ($resultCheckUser->num_rows > 0) {
        // Data pengguna ditemukan, lakukan penghapusan
        $deleteUserQuery = "DELETE FROM pengguna WHERE id_pengguna = ?";
        $stmtDeleteUser = $conn->prepare($deleteUserQuery);
        $stmtDeleteUser->bind_param("i", $userId);
        $stmtDeleteUser->execute();
        $stmtDeleteUser->close();

        // Redirect ke halaman list setelah penghapusan
        header("Location: kelola.php");
        exit();
    } else {
        // Data pengguna tidak ditemukan, mungkin ID tidak valid
        echo "Data pengguna tidak ditemukan.";
    }

    $stmtCheckUser->close();
} else {
    // Jika tidak ada ID yang diterima atau request bukan GET, tampilkan pesan kesalahan
    echo "ID pengguna tidak valid atau request tidak sesuai.";
}
