<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login (gantilah dengan halaman login yang sesuai)
header("Location: /sistem-persuratan-puskod/login.php");
exit();
