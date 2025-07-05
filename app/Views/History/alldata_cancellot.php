<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- XLSX JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- FileSaver JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            font-size: 16px;
        }

        #content {
            flex: 1;
        }

        .container-fluid {
            display: flex;
            flex-direction: column;
            padding: 1rem;
            max-width: 1200px;
            margin: 0 auto;
            min-width: 320px;
        }

        .card {
            margin-top: 1rem;
            font-size: 0.875rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            border-radius: 0.25rem;
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            font-size: 1.25rem;
            background-color: #007bff;
            color: #fff;
            padding: 0.75rem 1.25rem;
        }

        .card-body {
            padding: 1rem;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            font-size: 0.75rem;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        thead th {
            background-color: #dc3545;
            /* Warna latar belakang header tabel */
            color: #fff;
            /* Warna teks header tabel */
            border-bottom: 2px solid #dee2e6;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        .date-filter {
            margin: 0.5rem 0;
            font-size: 0.75rem;
        }

        footer {
            background-color: #f8f9fa;
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 0.875rem;
            color: #6c757d;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            .card {
                font-size: 0.75rem;
            }

            .table {
                font-size: 0.875rem;
            }

            .container-fluid {
                padding: 0.5rem;
            }
        }

        * {
            box-sizing: border-box;
        }

        .export-btn {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-align: center;
            text-decoration: none;
        }

        .export-btn:hover {
            background-color: #0056b3;
        }

        .export-btn img {
            width: 20px;
            /* Ukuran gambar sesuai kebutuhan */
            border: none;
            outline: none;
        }
    </style>
</head>

<body id="page-top">

    <?= $this->extend('NavbarPic/main_layout') ?>

    <?= $this->section('NavbarPic/content') ?>

    <!-- Konten Utama -->
    <div id="content">

        <!-- Awal Konten Halaman -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    All Data Cancel Lot
                    <span>
                        <?php if (!in_array(session()->get('role'), ['MFG1', 'MFG2', 'USER'])): ?>
                            <div class="card-header">
                                All Data Cancel Lot
                                <span>
                                    <button id="exportExcel" class="export-btn">
                                        <img src="<?= base_url('templates/excel.png') ?>" alt="Export to Excel">
                                        Export to Excel
                                    </button>
                                </span>
                            </div>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="cancelTable" class="table table-striped table-bordered table-hover">
                            <thead style="background-color: #dc3545; color: #fff;">
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Tanggal</th>
                                    <th>Part Number From</th>
                                    <th>Part Number To</th>
                                    <th>Quantity</th>
                                    <th>Lot Number</th>
                                    <th>Warehouse From</th>
                                    <th>Warehouse To</th>
                                    <th>Remark</th>
                                    <th>Tanggal Adjust</th>
                                    <th>Adjust PIC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <!-- Footer -->
        <footer class="sticky-footer">
            <div class="container-fluid my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; IT NSI 2024</span>
                </div>
            </div>
        </footer>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#cancelTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    ajax: {
                        url: '<?= base_url('cancels/ajax_list') ?>',
                        dataSrc: ''
                    },
                    columns: [
                        {
                            data: null,
                            render: function (data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { data: 'department' },
                        { data: 'pic' },
                        { data: 'tanggal' },
                        { data: 'part_number_from' },
                        { data: 'part_number_to' },
                        { data: 'qty' },
                        { data: 'lot_number' },
                        { data: 'warehouse_from' },
                        { data: 'warehouse_to' },
                        { data: 'remark' },
                        { data: 'pic_action_date' },
                        { data: 'adjust_pic' }
                    ],
                    language: {
                        emptyTable: "Tidak ada data tersedia",
                        loadingRecords: "Memuat...",
                        processing: "Memproses...",
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ entri",
                        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                        infoEmpty: "Menampilkan 0 hingga 0 dari 0 entri",
                        infoFiltered: "(disaring dari _MAX_ total entri)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            });

            $('#exportExcel').on('click', function () {
                window.location.href = '<?= base_url('cancels/export') ?>'; // URL ke controller PHP
            });
        </script>
        <?= $this->endSection() ?>

</body>

</html>