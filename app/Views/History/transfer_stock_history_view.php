<?= $this->extend('NavbarPic/main_layout') ?>

<?= $this->section('NavbarPic/content') ?>

<body class="page-top">
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid mt-3">

            <!-- Card for Transfer Stock History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Transfer Stock History</h6>
                </div>
                <div class="card-body">
                    <!-- Include DataTables CSS -->
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
                    <link rel="stylesheet"
                        href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

                    <!-- DataTables JavaScript -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

                    <!-- Include xlsx library for exporting -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

                    <!-- Custom CSS for the table -->
                    <style>
                        #tableContainer {
                            overflow-x: auto;
                            /* Enable horizontal scrolling */
                        }

                        #transferStockTable {
                            border-collapse: collapse;
                            width: 100%;
                            table-layout: auto;
                            /* Ensure that the table does not exceed the width of its container */
                        }

                        #transferStockTable thead th {
                            background-color: #007bff;
                            color: white;
                            padding: 12px;
                            text-align: left;
                        }

                        #transferStockTable tbody tr:nth-child(even) {
                            background-color: #f2f2f2;
                        }

                        #transferStockTable tbody tr:hover {
                            background-color: #ddd;
                        }

                        #transferStockTable td {
                            padding: 12px;
                            border: 1px solid #ddd;
                        }

                        #dateFilterFrom,
                        #dateFilterTo,
                        #statusFilter {
                            max-width: 150px;
                            margin-bottom: 10px;
                        }

                        @media (max-width: 768px) {
                            #transferStockTable thead {
                                display: none;
                                /* Hide header for mobile */
                            }

                            #transferStockTable,
                            #transferStockTable tbody,
                            #transferStockTable tr,
                            #transferStockTable td {
                                display: block;
                                /* Display each cell as block for smaller screens */
                                width: 100%;
                            }

                            #transferStockTable tr {
                                margin-bottom: 10px;
                                /* Space between rows */
                            }

                            #transferStockTable td {
                                text-align: right;
                                position: relative;
                                padding-left: 50%;
                                border: 1px solid #ddd;
                            }

                            #transferStockTable td::before {
                                content: attr(data-label);
                                /* Show label for each cell */
                                position: absolute;
                                left: 0;
                                width: 50%;
                                padding-left: 10px;
                                font-weight: bold;
                                white-space: nowrap;
                            }
                        }
                    </style>

                    <!-- Filter Tanggal dan Status -->
                    <div class="mb-3">
                        <label for="dateFilterFrom" class="form-label">Tanggal Dari:</label>
                        <input type="date" id="dateFilterFrom" class="form-control" />
                        <label for="dateFilterTo" class="form-label">Tanggal Sampai:</label>
                        <input type="date" id="dateFilterTo" class="form-control" />

                        <!-- Filter Status -->
                        <label for="statusFilter" class="form-label">Status:</label>
                        <select id="statusFilter" class="form-control">
                            <option value="">Semua</option>
                            <option value="OK">OK</option>
                            <option value="NG">NG</option>
                            <option value="MIN">MIN</option>
                            <option value="PLUS">PLUS</option>
                            <option value="PEND">PEND</option>
                        </select>

                        <button id="applyFilters" class="btn btn-primary mt-2">Terapkan Filter</button>
                        <?php if (!in_array(session()->get('role'), ['MFG1', 'MFG2', 'USER'])): ?>
                            <button id="exportExcel" class="btn btn-success mt-2">Ekspor ke Excel</button>
                            <button id="deleteFilteredData" class="btn btn-danger mt-2">Hapus Data yang Difilter</button>
                        <?php endif; ?>
                    </div>

                    <div id="tableContainer">
                        <table id="transferStockTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Tanggal</th>
                                    <th>Part Number From</th>
                                    <th>Part Number To</th>
                                    <th>Qty</th>
                                    <th>Lot Number From</th>
                                    <th>Lot Number To</th>
                                    <th>RN From</th>
                                    <th>RN To</th>
                                    <th>Warehouse From</th>
                                    <th>Warehouse To</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Tanggal Adjust</th>
                                    <th>Adjust PIC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transferStockHistory)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($transferStockHistory as $item): ?>
                                        <tr>
                                            <td data-label="No"><?= $no++ ?></td>
                                            <td data-label="Department"><?= esc($item['department']) ?></td>
                                            <td data-label="PIC"><?= esc($item['pic']) ?></td>
                                            <td data-label="Tanggal"><?= esc($item['tanggal']) ?></td>
                                            <td data-label="Part Number From"><?= esc($item['part_number_from']) ?></td>
                                            <td data-label="Part Number To"><?= esc($item['part_number_to']) ?></td>
                                            <td data-label="Qty"><?= esc($item['qty']) ?></td>
                                            <td data-label="Lot Number From"><?= esc($item['lot_number_from']) ?></td>
                                            <td data-label="Lot Number To"><?= esc($item['lot_number_to']) ?></td>
                                            <td data-label="RN From"><?= esc($item['rn_from']) ?></td>
                                            <td data-label="RN To"><?= esc($item['rn_to']) ?></td>
                                            <td data-label="Warehouse From"><?= esc($item['warehouse_from']) ?></td>
                                            <td data-label="Warehouse To"><?= esc($item['warehouse_to']) ?></td>
                                            <td data-label="Status"><?= esc($item['status']) ?></td>
                                            <td data-label="Remark"><?= esc($item['remark']) ?></td>
                                            <td data-label="Tanggal Adjust"><?= esc($item['pic_action_date']) ?></td>
                                            <td data-label="Adjust PIC"><?= esc($item['adjust_pic']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="16">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <script>
                        $(document).ready(function () {
                            var table = $('#transferStockTable').DataTable({
                                "paging": true,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": true,
                                "info": true,
                                "autoWidth": false,
                                "responsive": true
                            });

                            // Fungsi untuk filter tanggal dan status
                            function filterByDateAndStatus() {
                                var dateFrom = $('#dateFilterFrom').val();
                                var dateTo = $('#dateFilterTo').val();
                                var status = $('#statusFilter').val();

                                // Clear previous date range filter
                                $.fn.dataTable.ext.search.pop();

                                // Filter berdasarkan tanggal
                                if (dateFrom || dateTo) {
                                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                                        var rowDate = data[3]; // Kolom ke-4 adalah tanggal, pastikan ini sesuai dengan kolom tanggal di tabel
                                        if (!rowDate) return false;
                                        var date = new Date(rowDate);
                                        var from = new Date(dateFrom);
                                        var to = new Date(dateTo);

                                        if (dateFrom && !dateTo) {
                                            return date >= from;
                                        }
                                        if (!dateFrom && dateTo) {
                                            return date <= to;
                                        }
                                        if (dateFrom && dateTo) {
                                            return date >= from && date <= to;
                                        }
                                        return true;
                                    });
                                }

                                // Filter berdasarkan status
                                table.column(13).search(status).draw(); // Kolom ke-14 adalah status

                                table.draw();
                            }
                            // Handler untuk tombol hapus data yang difilter
                            $('#deleteFilteredData').on('click', function () {
                                var filteredData = table.rows({ filter: 'applied' }).data();
                                var idsToDelete = [];

                                filteredData.each(function (value, index) {
                                    var id = value[0]; // Asumsikan ID ada di kolom pertama
                                    idsToDelete.push(id);
                                });

                                if (idsToDelete.length === 0) {
                                    alert('Tidak ada data yang difilter untuk dihapus.');
                                    return;
                                }

                                // Kirim permintaan ke server untuk menghapus data yang difilter
                                $.ajax({
                                    url: '/api/delete-filtered-data', // Ganti dengan URL API Anda
                                    method: 'POST',
                                    data: JSON.stringify({ ids: idsToDelete }),
                                    contentType: 'application/json',
                                    success: function (response) {
                                        alert('Data yang difilter berhasil dihapus.');
                                        table.ajax.reload(); // Muat ulang data tabel
                                    },
                                    error: function (error) {
                                        alert('Terjadi kesalahan saat menghapus data.');
                                    }
                                });
                            });

                            // Handler untuk tombol filter
                            $('#applyFilters').on('click', function () {
                                filterByDateAndStatus();
                            });

                            // Handler untuk ekspor ke Excel
                            $('#exportExcel').on('click', function () {
                                var wb = XLSX.utils.book_new();
                                var ws = XLSX.utils.table_to_sheet(document.querySelector("#transferStockTable"));
                                XLSX.utils.book_append_sheet(wb, ws, "Transfer Stock History");
                                XLSX.writeFile(wb, "Transfer_Stock_History.xlsx");
                            });
                        });
                    </script>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?= $this->endSection() ?>