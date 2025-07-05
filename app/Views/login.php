<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('sb2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url('sb2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('<?= base_url('templates/bglogin.jpg') ?>');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.75);
            border-radius: 4rem;
            width: 100%;
            max-width: 500px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-group {
            position: relative;
        }

        .form-control {
            padding-left: 40px;
            /* Add space for the icon */
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #6c757d;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-0">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                    </div>
                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('message') ?></div>
                    <?php endif; ?>
                    <form class="user" action="<?= base_url('/login/authenticate') ?>" method="post" autocomplete="off">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control form-control-user"
                                placeholder="Enter Username..." required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="position-relative">
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-user" placeholder="Password" required>
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-user w-100" type="submit">Login</button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="#" id="forgotPasswordLink">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('sb2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('sb2/js/sb-admin-2.min.js') ?>"></script>

    <!-- Custom Script for Toggle Password Visibility -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('togglePassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');

                // Hide the password field after 3 seconds
                setTimeout(() => {
                    passwordInput.type = 'password';
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                }, 3000);
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('forgotPasswordLink').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default action of the link
            Swal.fire({
                title: 'Forgot Password',
                text: 'Mohon hubungi departemen IT untuk bantuan lebih lanjut.',
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        });

    </script>
</body>

</html>