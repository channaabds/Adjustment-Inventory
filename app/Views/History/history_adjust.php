<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <!-- jsPDF JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- jsPDF autoTable JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

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
            font-size: 1rem;
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
            background-color: #f8f9fa;
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

        .export-buttons {
            text-align: center;
            margin-bottom: 1rem;
        }

        .export-buttons button {
            margin: 0 0.5rem;
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
    </style>
</head>

<body id="page-top">

    <?= $this->extend('NavbarPic/main_layout') ?>

    <?= $this->section('NavbarPic/content') ?>

    <!-- Konten Utama -->
    <div id="content">

        <!-- Awal Konten Halaman -->
        <div class="container-fluid">

            <!-- Menampilkan pesan flash jika ada -->
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('message'); ?>
                </div>
            <?php endif; ?>

            <!-- Kartu Filter -->
            <div class="card">
                <div class="card-header">
                    <h5>Filter History Adjust</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="minDate">Tanggal Mulai:</label>
                        <input type="date" id="minDate" class="form-control date-filter">
                    </div>
                    <div class="form-group">
                        <label for="maxDate">Tanggal Selesai:</label>
                        <input type="date" id="maxDate" class="form-control date-filter">
                    </div>
                    <div class="form-group">
                        <label for="statusFilter">Status:</label>
                        <select id="statusFilter" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="OK">OK</option>
                            <option value="NG">NG</option>
                            <option value="PEND">PEND</option>
                            <option value="PLUS">PLUS</option>
                            <option value="MIN">MIN</option>
                            <!-- Tambahkan opsi lain sesuai kebutuhan -->
                        </select>
                    </div>
                </div>
            </div>

            <!-- Kartu History Adjust -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">History Adjust Inventory</h5>
                </div>
                <div class="card-body">
                    <?php if (!in_array(session()->get('role'), ['MFG1', 'MFG2', 'USER'])): ?>
                        <div class="export-buttons">
                            <!-- Tombol Ekspor -->
                            <button id="exportExcel" class="btn btn-primary">Export to Excel</button>
                            <button id="exportPdf" class="btn btn-danger">Export to PDF</button>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="historyTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pic</th>
                                    <th>Department</th>
                                    <th>Part Number</th>
                                    <th>Tanggal</th>
                                    <th>Quantity</th>
                                    <th>No. Lot/RN</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Tanggal Adjust</th>
                                    <th>Adjust PIC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data history akan dimasukkan di sini secara dinamis -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
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
            var table = $('#historyTable').DataTable({
                "ajax": {
                    "url": "<?= base_url('api/history') ?>",
                    "dataSrc": function (json) {
                        console.log(json); // Debugging: melihat data yang diterima
                        return json;
                    }
                },
                "columns": [
                    {
                        "data": null,
                        "defaultContent": "",
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { "data": "pic" },
                    { "data": "department" },
                    { "data": "part_number" },
                    { "data": "tanggal" },
                    { "data": "qty" },
                    { "data": "lot_number" },
                    { "data": "location" },
                    { "data": "status" },
                    { "data": "remark" },
                    { "data": "pic_action_date" },

                    { "data": "adjust_pic" }
                ]
            });

            $('#minDate, #maxDate').change(function () {
                table.draw();
            });

            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = new Date($('#minDate').val());
                    var max = new Date($('#maxDate').val());
                    var date = new Date(data[4]);

                    if (
                        (isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && date <= max) ||
                        (min <= date && isNaN(max)) ||
                        (min <= date && date <= max)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            // Export to Excel
            $('#exportExcel').on('click', function () {
                var wb = XLSX.utils.table_to_book(document.getElementById('historyTable'), { sheet: "Sheet1" });
                XLSX.writeFile(wb, 'History_Adjust.xlsx');
            });

            // // Export to PDF
            // $('#exportPdf').on('click', function () {
            //     const { jsPDF } = window.jspdf;
            //     const doc = new jsPDF();
            //     doc.autoTable({
            //         html: '#historyTable',
            //         styles: {
            //             overflow: 'linebreak',
            //             fontSize: 8
            //         },
            //         headStyles: {
            //             fillColor: [22, 160, 133]  // Contoh warna header
            //         },
            //         margin: { top: 10 },
            //     });
            //     doc.save('History_Adjust.pdf');
            // });
        });
    </script>

    <?= $this->endSection() ?>

</body>

</html>