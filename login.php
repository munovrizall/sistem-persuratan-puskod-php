<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];

include $rootPath . "/sistem-persuratan-puskod/config/connection.php";

$queryPengguna = "SELECT * FROM pengguna";
$result = $conn->query($queryPengguna);

// Cek apakah hasil query kosong
if (empty($result)) {
    $result = "Tidak ada data";
}

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'namaPengguna' => $row['nama_pengguna'],
        'email' => $row['email'],
        'password' => $row['password'],
        'jabatan' => $row['jabatan'],
        'idDivisi' => $row['id_divisi'],
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryAccount = "SELECT * FROM pengguna WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($queryAccount);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $resultAccount = $stmt->get_result();
    $stmt->close();

    if ($resultAccount->num_rows > 0) {
        $accountData = $resultAccount->fetch_assoc();

        // Verify the hashed password using password_verify
        if ($password === $accountData['password'] && $email === $accountData['email']) {
            header("location: homepage.php");
            exit();
        } else {
            echo "Password salah";
            exit();
        }
    } else {
        echo "Akun tidak terdaftar";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/style.html";
    ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/sistem-persuratan-puskod/" class="h1"><b>
                        <img src="assets/image/logo-kemhan.png" class="brand-image img-circle elevation-3" style="opacity: .8; height: 80px; width: 80px;">
                        <br></b>Pusat Kodifikasi</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silahkan login terlebih dahulu</p>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" id="emailInput" name="email" onkeypress="checkEnter(event)">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="passwordInput" name="password" onkeypress="checkEnter(event)">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span id="togglePassword" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div>
                        <button type="button" id="buttonSubmit" class="btn btn-primary btn-block" onclick="performLogin()">Login</button>
                    </div>
                    <!-- /.col -->
            </div>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>

    <?php
    include $rootPath . "/sistem-persuratan-puskod/components/script.html"
    ?>

    <script>
        var accountData = <?php echo json_encode($data); ?>;

        function checkEnter(event) {
            if (event.key === "Enter") {
                performLogin();
            }
        }

        function performLogin() {
            var inputEmail = document.getElementById('emailInput').value;
            var inputPassword = document.getElementById('passwordInput').value;

            if (inputEmail.trim() !== "") {
                var isEmailValid = false;
                var isPasswordValid = false;

                // Melakukan iterasi pada array accountData untuk mencocokkan email dan password
                for (var i = 0; i < accountData.length; i++) {
                    if (accountData[i].email === inputEmail) {
                        isEmailValid = true;

                        // Jika email valid, lanjutkan untuk memeriksa password
                        if (accountData[i].password === inputPassword) {
                            isPasswordValid = true;
                            break; // Jika password valid, keluar dari loop
                        }
                    }
                }

                if (!isEmailValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email tidak ditemukan',
                        text: 'Masukkan email yang benar!',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK (enter)'
                    });
                } else {
                    if (!isPasswordValid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Password Salah',
                            text: 'Masukkan password yang benar!',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK (enter)'
                        });
                    } else {
                        localStorage.setItem("username", inputEmail);

                        $.ajax({
                            type: "POST",
                            url: "/sistem-persuratan-puskod/config/process-username.php",
                            data: {
                                username: inputEmail
                            },
                            success: function(response) {
                                // Parse the response as JSON
                                var responseData = JSON.parse(response);

                                window.location.href = "/sistem-persuratan-puskod/tata-usaha/homepage.php";
                            },
                            error: function(error) {
                                console.error("Error sending username to server: " + error);
                            }
                        });
                    }
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Kosong',
                    text: 'Mohon lengkapi form login!',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK (enter)'
                })
            }
        }


        // When user press enter on keyboard
        var passwordInput = document.getElementById('passwordInput');
        passwordInput.addEventListener('keyup', function(event) {
            if (event.keyCode === 13) {
                submitForm();
            }
        });

        function submitForm() {
            document.getElementById('submitButton').click();
        }

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('passwordInput');
            var togglePassword = document.getElementById('togglePassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>

</html>