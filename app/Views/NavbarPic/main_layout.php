<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Custom fonts for this template -->
    <link href="<?= base_url('sb2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('sb2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- CSS untuk DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- CSS untuk SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- CSS untuk Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS untuk Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS untuk sidebar fixed -->
    <style>
        /* CSS untuk membuat sidebar tetap di atas saat di-zoom */
        .sidebar {
            top: 0;
            bottom: 0;
            height: 100%;
            z-index: 1000;
            /* Pastikan sidebar berada di atas elemen lainnya */
        }

        .content-wrapper {
            margin-left: 0px;
            /* Sesuaikan dengan lebar sidebar Anda */
        }

        /* Gaya untuk tombol dengan teks putih */
        .btn-white-text {
            color: #ffffff;
            /* Warna teks putih */
            background-color: #ffc107;
            /* Warna latar belakang tombol, sesuaikan jika diperlukan */
            border-color: #ffc107;
            /* Warna border tombol, sesuaikan jika diperlukan */
        }

        /* Gaya untuk tombol saat hover */
        .btn-white-text:hover {
            color: #ffffff;
            /* Warna teks tetap putih saat hover */
            background-color: #e0a800;
            /* Sesuaikan warna latar belakang saat hover */
            border-color: #e0a800;
            /* Sesuaikan warna border saat hover */
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?= $this->include('NavbarPic/navigation') ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column content-wrapper">
            <!-- Main Content -->
            <div id="content">
                <?= $this->include('NavbarPic/topbar') ?>
                <?= $this->renderSection('NavbarPic/content') ?>
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="<?= base_url('/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url('sb2/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('sb2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript -->
    <script src="<?= base_url('sb2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages -->
    <script src="<?= base_url('sb2/js/sb-admin-2.min.js') ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('sb2/vendor/chart.js/Chart.min.js') ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('sb2/js/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('sb2/js/demo/chart-pie-demo.js') ?>"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom script to initialize DataTables -->
    <script>
        $(document).ready(function () {
            // Initialize DataTables for multiple tables
            var adjustmentTable = $('#adjustmentInventoryTable').DataTable({
                "ajax": {
                    "url": "<?= base_url('PIC/pic/get_adjustments') ?>",
                    "type": "POST",
                    "dataSrc": "", // Use empty string if the response is a plain array
                    "error": function (xhr, error, thrown) {
                        console.error("Ajax error:", error);
                        console.error("XHR:", xhr);
                        console.error("Thrown:", thrown);
                    }
                }
            });

            var transferStockTable = $('#transferStockTable').DataTable();
            var cancelLotTable = $('#cancelLotTable').DataTable();
            var transferStockTable = $('#adjustmentTable').DataTable();

            // Handle delete button click
            $('#deleteModal').on('show.bs.modal', function (e) {
                var button = $(e.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                var url = '/inventory/delete/' + id; // Build URL

                // Update modal's href attribute
                $('#confirmDelete').attr('href', url);
            });

            // Handle delete success
            <?php if (session()->getFlashdata('delete_success')): ?>
                $(document).ready(function () {
                    $('#successModal').modal('show');
                });
            <?php endif; ?>

        });

    </script>
</body>

</html>