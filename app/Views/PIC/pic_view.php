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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Token CSRF -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <style>
        /* General styles */
        body {
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-size: 16px;
        }

        #content {
            flex: 1;
        }

        .container-fluid {
            padding: 15px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            margin-top: 15px;
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
            padding: 15px;
        }

        /* Table styles */
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

        /* Date filter styles */
        .date-filter {
            margin: 5px 0;
            font-size: 0.75rem;
        }

        #exportExcel {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .card {
                font-size: 0.75rem;
            }

            table {
                font-size: 0.875rem;
            }

            .container-fluid {
                padding: 10px;
            }
        }
    </style>
</head>

<body id="page-top">

    <?= $this->extend('NavbarPic/main_layout') ?>

    <?= $this->section('NavbarPic/content') ?>

    <!-- Main Content -->
    <div id="content">

        <div class="container-fluid">

            <!-- Flash message -->
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('message'); ?>
                </div>
            <?php endif; ?>

            <!-- Filter Card -->
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Filter</h5>
                    <!-- Add an optional icon here -->
                    <i class="fa fa-filter"></i>
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="minDate">Tanggal Mulai:</label>
                                <input type="date" id="minDate" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="maxDate">Tanggal Selesai:</label>
                                <input type="date" id="maxDate" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="statusFilter">Status:</label>
                            <select id="statusFilter" class="form-control">
                                <option value="">Semua</option>
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                                <option value="MIN">MIN</option>
                                <option value="PLUS">PLUS</option>
                                <option value="PEND">PEND</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="applyFilter" class="btn btn-primary mr-2">
                                Terapkan Filter
                            </button>
                            <button type="button" id="resetFilter" class="btn btn-secondary">
                                Reset Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Bulk Action Buttons -->
            <div class="card-header d-flex justify-content-between align-items-center mt-2">
                <h5 class="mb-0">Adjustment Inventory</h5>
                <div>
                    <!-- Export to Excel Button -->
                    <button type="button" id="exportExcel" class="btn btn-success">
                        <i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i><br>Export Excel
                    </button>
                </div>
            </div>

            <?php $role = session()->get('role'); ?>

            <!-- Adjustment Inventory Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Bulk Action Buttons -->
                    <div class="mb-3">
                        <?php if ($role === 'LEADERQC' || $role === 'CS' || $role === 'LEADERQC' || $role === 'LEADERMFG1' || $role === 'LEADERMFG1'): ?>
                            <button type="button" id="bulkApproveLeader" class="btn btn-success">
                                <i class="fa fa-check-square" aria-hidden="true"></i> Bulk Approve Leader
                            </button>
                            <button type="button" id="bulkDisapproveLeader" class="btn btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i> Bulk Disapprove Leader
                            </button>
                        <?php endif; ?>
                        <?php if ($role === 'PIC'): ?>
                            <button type="button" id="bulkApprovePIC" class="btn btn-success">
                                <i class="fa fa-check" aria-hidden="true"></i> Bulk Approve PIC
                            </button>
                            <button type="button" id="bulkDisapprovePIC" class="btn btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i> Bulk Disapprove PIC
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="adjustmentTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Part Number</th>
                                    <th>Tanggal</th>
                                    <th>Quantity</th>
                                    <th>No. Lot/RN</th>
                                    <th>RN</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Adjust PIC</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($adjustment)): ?>
                                    <?php foreach ($adjustment as $key => $item): ?>
                                        <tr data-id="<?= $item['id']; ?>">
                                            <td><input type="checkbox" class="row-select" data-id="<?= $item['id']; ?>"></td>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= esc($item['department']); ?></td>
                                            <td><?= esc($item['pic']); ?></td>
                                            <td><?= esc($item['part_number']); ?></td>
                                            <td><?= esc($item['tanggal']); ?></td>
                                            <td><?= esc($item['qty']); ?></td>
                                            <td><?= esc($item['lot_number']); ?></td>
                                            <td><?= esc($item['rn']); ?></td>
                                            <td><?= esc($item['location']); ?></td>
                                            <td class="status"><?= esc($item['status']); ?></td>
                                            <td><?= esc($item['remark']); ?></td>
                                            <td><?= esc($item['adjust_pic']); ?></td>
                                            <td>
                                                <!-- Display buttons based on status -->
                                                <?php if (empty($item['adjust_pic'])): ?>
                                                    <button class="btn btn-sm btn-success approve-leader-btn"
                                                        data-id="<?= $item['id']; ?>">
                                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> Approve Leader
                                                    </button>
                                                    <button class="btn btn-sm btn-danger disapprove-leader-btn"
                                                        data-id="<?= $item['id']; ?>">
                                                        <i class="fa fa-times-circle-o" aria-hidden="true"></i> Disapprove Leader
                                                    </button>
                                                <?php elseif ($item['adjust_pic'] === 'Approved Leader'): ?>
                                                    <button class="btn btn-sm btn-success approve-pic-btn"
                                                        data-id="<?= $item['id']; ?>">
                                                        <i class="fa fa-check" aria-hidden="true"></i> Approve PIC
                                                    </button>
                                                    <button class="btn btn-sm btn-danger disapprove-pic-btn"
                                                        data-id="<?= $item['id']; ?>">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Disapprove PIC
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="14" class="text-center">Tidak ada data tersedia</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>

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
            var baseUrl = '<?= base_url() ?>';
            var table = $('#adjustmentTable').DataTable({
                responsive: true,
                autoWidth: false,
                scrollX: true,

            });

            // Pilih/Unselect semua checkbox
            $('#selectAll').click(function () {
                $('.row-select').prop('checked', this.checked);
            });

            // Bulk Approve Leader
            $('#bulkApproveLeader').click(function () {
                var ids = getSelectedIds();
                if (ids.length > 0) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dipilih akan disetujui oleh Leader!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, setujui!',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return $.ajax({
                                url: baseUrl + '/pic/adjustment/bulkApproveAdjustByLeader',
                                type: 'POST',
                                data: { ids: ids },
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            }).done(function (response) {
                                if (response.success) {
                                    Swal.fire('Disetujui!', response.message, 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            }).fail(function (xhr, status, error) {
                                console.error('AJAX Error: ', status, error);
                                Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                            });
                        }
                    });
                } else {
                    Swal.fire('Tidak ada pilihan!', 'Silakan pilih setidaknya satu item.', 'warning');
                }
            });

            // Bulk Disapprove Leader
            $('#bulkDisapproveLeader').click(function () {
                var ids = getSelectedIds();
                if (ids.length > 0) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dipilih akan ditolak oleh Leader!",
                        icon: 'warning',
                        input: 'textarea',
                        inputLabel: 'Alasan Penolakan',
                        inputPlaceholder: 'Masukkan alasan...',
                        inputAttributes: {
                            'aria-label': 'Masukkan alasan penolakan'
                        },
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tolak!',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: (reason) => {
                            if (!reason) {
                                Swal.showValidationMessage('Alasan penolakan diperlukan.');
                                return false;
                            }
                            return $.ajax({
                                url: baseUrl + '/pic/adjustment/bulkDisapproveAdjustByLeader',
                                type: 'POST',
                                data: { ids: ids, reason: reason },
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            }).done(function (response) {
                                if (response.success) {
                                    Swal.fire('Ditolak!', response.message, 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            }).fail(function (xhr, status, error) {
                                console.error('AJAX Error: ', status, error);
                                Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                            });
                        }
                    });
                } else {
                    Swal.fire('Tidak ada pilihan!', 'Silakan pilih setidaknya satu item.', 'warning');
                }
            });

            // Bulk Approve PIC
            $('#bulkApprovePIC').click(function () {
                var ids = getSelectedIds();
                if (ids.length > 0) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dipilih akan disetujui oleh PIC!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, setujui!',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return $.ajax({
                                url: baseUrl + '/pic/adjustment/bulkApproveAdjustByPIC',
                                type: 'POST',
                                data: { ids: ids },
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            }).done(function (response) {
                                if (response.success) {
                                    Swal.fire('Disetujui!', response.message, 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            }).fail(function (xhr, status, error) {
                                console.error('AJAX Error: ', status, error);
                                Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                            });
                        }
                    });
                } else {
                    Swal.fire('Tidak ada pilihan!', 'Silakan pilih setidaknya satu item.', 'warning');
                }
            });

            // Bulk Disapprove PIC
            $('#bulkDisapprovePIC').click(function () {
                var ids = getSelectedIds();
                if (ids.length > 0) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dipilih akan ditolak oleh PIC!",
                        icon: 'warning',
                        input: 'textarea',
                        inputLabel: 'Alasan Penolakan',
                        inputPlaceholder: 'Masukkan alasan...',
                        inputAttributes: {
                            'aria-label': 'Masukkan alasan penolakan'
                        },
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tolak!',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: (reason) => {
                            if (!reason) {
                                Swal.showValidationMessage('Alasan penolakan diperlukan.');
                                return false;
                            }
                            return $.ajax({
                                url: baseUrl + '/pic/adjustment/bulkDisapproveAdjustByPIC',
                                type: 'POST',
                                data: { ids: ids.join(','), reason: reason },
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            }).done(function (response) {
                                if (response.success) {
                                    Swal.fire('Ditolak!', response.message, 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            }).fail(function (xhr, status, error) {
                                console.error('AJAX Error: ', status, error);
                                Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                            });
                        }
                    });
                } else {
                    Swal.fire('Tidak ada pilihan!', 'Silakan pilih setidaknya satu item.', 'warning');
                }
            });

            // Fungsi untuk mendapatkan ID yang dipilih
            function getSelectedIds() {
                var ids = [];
                $('.row-select:checked').each(function () {
                    ids.push($(this).data('id'));
                });
                return ids;
            }

            // Date range filtering
            $('#minDate, #maxDate, #statusFilter').change(function () {
                table.draw();
            });

            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = new Date($('#minDate').val());
                    var max = new Date($('#maxDate').val());
                    var date = new Date(data[5]); // Assuming the date is in the 5th column (index 4)
                    var status = $('#statusFilter').val();
                    var rowStatus = data[10]; // Assuming the status is in the 9th column (index 8)

                    if (
                        (isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && date <= max) ||
                        (min <= date && isNaN(max)) ||
                        (min <= date && date <= max)
                    ) {
                        return status === "" || rowStatus === status;
                    }
                    return false;
                }
            );

            $('.approve-leader-btn').click(function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan disetujui oleh Leader!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, setujui!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: baseUrl + '/pic/adjustment/approveAdjustByLeader/' + id,
                            type: 'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Disetujui!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                        });
                    }
                });
            });


            $('.disapprove-leader-btn').click(function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan ditolak oleh Leader!",
                    icon: 'warning',
                    input: 'textarea',
                    inputLabel: 'Alasan Penolakan',
                    inputPlaceholder: 'Masukkan alasan penolakan...',
                    inputAttributes: {
                        'aria-label': 'Masukkan alasan penolakan'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Alasan penolakan tidak boleh kosong.');
                            return false;
                        }
                        return $.ajax({
                            url: baseUrl + '/pic/adjustment/disapproveAdjustByLeader/' + id,
                            type: 'POST',
                            data: { reason: reason },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Ditolak!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                        });
                    }
                });
            });

            $('.approve-pic-btn').click(function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan disetujui oleh PIC!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, setujui!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: baseUrl + '/pic/adjustment/approveAdjustByPIC/' + id,
                            type: 'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Disetujui!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                        });
                    }
                });
            });

            $('.disapprove-pic-btn').click(function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan ditolak oleh PIC!",
                    icon: 'warning',
                    input: 'textarea',
                    inputLabel: 'Alasan Penolakan',
                    inputPlaceholder: 'Masukkan alasan penolakan...',
                    inputAttributes: {
                        'aria-label': 'Masukkan alasan penolakan'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Alasan penolakan tidak boleh kosong.');
                            return false;
                        }
                        return $.ajax({
                            url: baseUrl + '/pic/adjustment/disapproveAdjustByPIC/' + id,
                            type: 'POST',
                            data: { reason: reason },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Ditolak!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                        });
                    }
                });
            });

            // Export to Excel
            $('#exportExcel').click(function () {
                var minDate = $('#minDate').val();
                var maxDate = $('#maxDate').val();
                var status = $('#statusFilter').val();

                // Default adjust_pic value
                var adjustPic = 'Approved Leader';

                // Construct the URL with parameters
                var exportUrl = baseUrl + '/export/inventory?minDate=' + encodeURIComponent(minDate) +
                    '&maxDate=' + encodeURIComponent(maxDate) +
                    '&status=' + encodeURIComponent(status) +
                    '&adjustPic=' + encodeURIComponent(adjustPic);

                // Redirect to the URL to trigger the export
                window.location.href = exportUrl;
            });


            // Apply filter button click event
            $('#applyFilter').click(function () {
                table.draw();
            });

            // Reset filter button click event
            $('#resetFilter').click(function () {
                $('#minDate').val('');
                $('#maxDate').val('');
                $('#statusFilter').val('');
                table.search('').columns().search('').draw();
            });
        });

    </script>

    <?= $this->endSection() ?>

</body>

</html>