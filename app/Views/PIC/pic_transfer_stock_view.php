<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Stock</title>
    <!-- CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <!-- CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- CSS Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Token CSRF -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    <style>
        body {
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #content {
            flex: 1;
        }

        .container-fluid {
            padding: 15px;
        }

        .card {
            margin-top: 15px;
            font-size: 0.875rem;
        }

        .card-header {
            font-size: 1rem;
        }

        .card-body {
            padding: 15px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            margin-top: 10px;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        th,
        td {
            white-space: nowrap;
            overflow: hidden;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .status-pending {
            color: #FFC107;
            font-weight: bold;
        }

        .status-approved {
            color: #28A745;
            font-weight: bold;
        }

        .status-disapproved {
            color: #DC3545;
            font-weight: bold;
        }
    </style>
</head>

<body id="page-top">

    <?= $this->extend('NavbarPic/main_layout') ?>

    <?= $this->section('NavbarPic/content') ?>

    <!-- Konten Utama -->
    <div id="content">

        <!-- Mulai Konten Halaman -->
        <div class="container-fluid">

            <?php if (session()->getFlashdata('message')): ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '<?= session()->getFlashdata('message'); ?>'
                    });
                </script>
            <?php endif; ?>

            <a href="<?= base_url('/pic/dashboard') ?>" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

            <!-- Form Filter -->
            <div class="card mb-3">
                <div class="card-body">
                    <form id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="startDate">Tanggal Mulai</label>
                                <input type="date" id="startDate" name="startDate" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="endDate">Tanggal Akhir</label>
                                <input type="date" id="endDate" name="endDate" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="OK">OK</option>
                                    <option value="MIN">MIN</option>
                                    <option value="PLUS">PLUS</option>
                                    <option value="NG">NG</option>
                                    <option value="PEND">PEND</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterButton">&nbsp;</label>
                                <button type="submit" id="filterButton"
                                    class="btn btn-primary form-control">Filter</button>
                            </div>
                            <div class="col-md-3">
                                <label for="exportButton">&nbsp;</label>
                                <button type="button" id="exportButton"
                                    class="btn btn-success form-control">Ekspor</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php $role = session()->get('role'); ?>

            <!-- Card untuk Tabel Transfer Stock -->
            <div class="card">
                <div class="card-header">
                    Transfer Stock
                </div>
                <div class="card-body">
                    <!-- Bulk Action Buttons -->
                    <div class="mb-3">
                        <?php if ($role === 'LEADERQC' || $role === 'CS'): ?>
                            <button id="bulk-approve-leader-btn" class="btn btn-sm btn-success">
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> Bulk Approve Leader
                            </button>
                            <button id="bulk-disapprove-leader-btn" class="btn btn-sm btn-danger">
                                <i class="fa fa-times-circle-o" aria-hidden="true"></i> Bulk Disapprove Leader
                            </button>
                        <?php endif; ?>
                        <?php if ($role === 'PIC'): ?>
                            <button id="bulk-approve-pic-btn" class="btn btn-sm btn-success">
                                <i class="fa fa-check" aria-hidden="true"></i> Bulk Approve PIC
                            </button>
                            <button id="bulk-disapprove-pic-btn" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i> Bulk Disapprove PIC
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="table-responsive">
                        <table id="transferStockTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all" title="Select All">Select All</th>
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
                                    <th>Whs From</th>
                                    <th>Whs To</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Tanggal Adjust</th>
                                    <th>Adjust PIC</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transferStocks)): ?>
                                    <?php foreach ($transferStocks as $key => $item): ?>
                                        <tr>
                                            <td><input type="checkbox" name="select_item" value="<?= $item['id']; ?>"></td>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= esc($item['department']); ?></td>
                                            <td><?= esc($item['pic']); ?></td>
                                            <td><?= esc($item['tanggal']); ?></td>
                                            <td><?= esc($item['part_number_from']); ?></td>
                                            <td><?= esc($item['part_number_to']); ?></td>
                                            <td><?= esc($item['qty']); ?></td>
                                            <td><?= esc($item['lot_number_from']); ?></td>
                                            <td><?= esc($item['lot_number_to']); ?></td>
                                            <td><?= esc($item['rn_from']); ?></td>
                                            <td><?= esc($item['rn_to']); ?></td>
                                            <td><?= esc($item['warehouse_from']); ?></td>
                                            <td><?= esc($item['warehouse_to']); ?></td>
                                            <td><?= esc($item['status']); ?></td>
                                            <td><?= esc($item['remark']); ?></td>
                                            <td><?= esc($item['pic_action_date']); ?></td>
                                            <td> <?php if (empty($item['adjust_pic'])): ?>
                                                    <span class="badge badge-secondary">Belum Disetujui</span>
                                                <?php elseif ($item['adjust_pic'] === 'Approved Leader'): ?>
                                                    <span class="badge badge-success">Approved Leader</span>
                                                <?php elseif ($item['adjust_pic'] === 'Approved PIC'): ?>
                                                    <span class="badge badge-primary">Approved PIC</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Status Tidak Diketahui</span>
                                                <?php endif; ?>
                                            </td>
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
                                        <td colspan="19">Tidak ada data tersedia</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- JavaScript DataTables -->
            <script type="text/javascript" charset="utf8"
                src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
            <!-- JavaScript SweetAlert2 -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
            <!-- JavaScript Bootstrap -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                $(document).ready(function () {
                    var baseUrl = '<?= base_url() ?>';
                    var table = $('#transferStockTable').DataTable({
                        responsive: true,
                        autoWidth: false,
                        scrollX: true
                    });

                    // Toggle check/uncheck all checkboxes
                    $('#select-all').on('click', function () {
                        var isChecked = $(this).prop('checked');
                        $('input[name="select_item"]').prop('checked', isChecked);
                    });

                    // Function to get selected IDs
                    function getSelectedIds() {
                        var ids = [];
                        $('input[name="select_item"]:checked').each(function () {
                            ids.push($(this).val());
                        });
                        return ids;
                    }

                    // Event handler untuk tombol bulk approve oleh Leader
                    $('#bulk-approve-leader-btn').click(function () {
                        var ids = getSelectedIds();
                        if (ids.length === 0) {
                            Swal.fire('Peringatan!', 'Tidak ada data yang dipilih.', 'warning');
                            return;
                        }
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Semua data yang dipilih akan disetujui oleh Leader!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, setujui!',
                            cancelButtonText: 'Batal',
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                return $.ajax({
                                    url: baseUrl + '/pic/transferStock/approveTransferByLeaderBulk',
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
                    });

                    // Event handler untuk tombol bulk disapprove oleh Leader
                    $('#bulk-disapprove-leader-btn').click(function () {
                        var ids = getSelectedIds();
                        if (ids.length === 0) {
                            Swal.fire('Peringatan!', 'Tidak ada data yang dipilih.', 'warning');
                            return;
                        }
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Semua data yang dipilih akan ditolak oleh Leader!",
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
                                    url: baseUrl + '/pic/transferStock/disapproveTransferByLeaderBulk',
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
                    });

                    // Event handler untuk tombol bulk approve oleh PIC
                    $('#bulk-approve-pic-btn').click(function () {
                        var ids = getSelectedIds();
                        if (ids.length === 0) {
                            Swal.fire('Peringatan!', 'Tidak ada data yang dipilih.', 'warning');
                            return;
                        }
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Semua data yang dipilih akan disetujui oleh PIC!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, setujui!',
                            cancelButtonText: 'Batal',
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                return $.ajax({
                                    url: baseUrl + '/pic/transferStock/approveTransferByPICBulk',
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
                    });

                    // Event handler untuk tombol bulk disapprove oleh PIC
                    $('#bulk-disapprove-pic-btn').click(function () {
                        var ids = getSelectedIds();
                        if (ids.length === 0) {
                            Swal.fire('Peringatan!', 'Tidak ada data yang dipilih.', 'warning');
                            return;
                        }
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Semua data yang dipilih akan ditolak oleh PIC!",
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
                                    url: baseUrl + '/pic/transferStock/disapproveTransferByPICBulk',
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
                    });

                    // Event handler untuk tombol setujui transfer stock oleh Leader
                    $(document).on('click', '.approve-leader-btn', function () {
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
                                    url: baseUrl + '/pic/transferStock/approveTransferByLeader/' + id,
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

                    // Event handler untuk tombol tolak transfer stock oleh Leader
                    $(document).on('click', '.disapprove-leader-btn', function () {
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
                                    url: baseUrl + '/pic/transferStock/disapproveTransferByLeader/' + id,
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

                    // Event handler untuk tombol setujui transfer stock oleh PIC
                    $(document).on('click', '.approve-pic-btn', function () {
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
                                    url: baseUrl + '/pic/transferStock/approveTransferByPIC/' + id,
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

                    // Event handler untuk tombol tolak transfer stock oleh PIC
                    $(document).on('click', '.disapprove-pic-btn', function () {
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
                                    url: baseUrl + '/pic/transferStock/disapproveTransferByPIC/' + id,
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

                    // Custom filter function for date range and status
                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var startDate = $('#startDate').val();
                            var endDate = $('#endDate').val();
                            var status = $('#status').val();

                            var date = data[4]; // Sesuaikan dengan indeks kolom tanggal Anda
                            var statusColumn = data[14]; // Sesuaikan dengan indeks kolom status Anda

                            var dateParsed = new Date(date);
                            var startDateParsed = new Date(startDate);
                            var endDateParsed = new Date(endDate);

                            // Check date range
                            var dateInRange = (!startDate && !endDate) ||
                                (!startDate && dateParsed <= endDateParsed) ||
                                (!endDate && dateParsed >= startDateParsed) ||
                                (dateParsed >= startDateParsed && dateParsed <= endDateParsed);

                            // Check status filter
                            var statusMatches = !status || status === statusColumn;

                            return dateInRange && statusMatches;
                        }
                    );

                    // Event handler untuk filter form
                    $('#filterForm').submit(function (e) {
                        e.preventDefault();
                        table.draw();
                    });

                    // Event handler untuk tombol ekspor
                    $('#exportButton').click(function () {
                        var startDate = $('#startDate').val();
                        var endDate = $('#endDate').val();
                        var status = $('#status').val();

                        // Menggunakan DataTables API untuk mendapatkan data yang difilter
                        var filteredData = table.rows({ filter: 'applied' }).data().toArray();

                        // Convert filteredData ke format URL parameter atau kirimkan secara langsung ke server jika perlu
                        window.location.href = baseUrl + '/pic/transferStock/export?' +
                            $.param({ startDate: startDate, endDate: endDate, status: status });
                    });

                });

            </script>

            <?= $this->endSection() ?>

</body>

</html>