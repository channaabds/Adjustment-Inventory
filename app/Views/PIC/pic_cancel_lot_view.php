<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <!-- CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- CSS Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

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

            <!-- Filter Tanggal -->
            <div class="mb-3">
                <label for="startDate" class="form-label">Tanggal Mulai</label>
                <input type="date" id="startDate" class="form-control">
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">Tanggal Selesai</label>
                <input type="date" id="endDate" class="form-control">
            </div>
            <button id="filterBtn" class="btn btn-primary">Filter</button>
            <button id="exportBtn" class="btn btn-success">Export</button>

            <!-- Card untuk Tabel -->
            <div class="card">
                <div class="card-header">
                    Data Cancel Lot
                </div>
                <!-- Bulk Action Buttons for Leader -->
                <!-- Bulk Action Buttons -->
                <div class="btn-group mb-3">
                    <button id="approveLeaderSelected" class="btn btn-success">Approve Selected by Leader</button>
                    <button id="disapproveLeaderSelected" class="btn btn-danger">Disapprove Selected by Leader</button>
                    <button id="approvePICSelected" class="btn btn-success">Approve Selected by PIC</button>
                    <button id="disapprovePICSelected" class="btn btn-danger">Disapprove Selected by PIC</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="cancelLotTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th> <!-- Checkbox to select all -->
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>Tanggal</th>
                                    <th>Part Number From</th>
                                    <th>Part Number To</th>
                                    <th>Quantity</th>
                                    <th>Lot Number</th>
                                    <th>Warehouse From</th>
                                    <th>Remark</th>
                                    <th>Tanggal Adjust</th>
                                    <th>Adjust PIC</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($cancelLots)): ?>
                                    <?php foreach ($cancelLots as $key => $item): ?>
                                        <tr data-id="<?= $item['id']; ?>">
                                            <td><input type="checkbox" class="row-checkbox" data-id="<?= $item['id']; ?>"></td>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= esc($item['department']); ?></td>
                                            <td><?= esc($item['tanggal']); ?></td>
                                            <td><?= esc($item['part_number_from']); ?></td>
                                            <td><?= esc($item['part_number_to']); ?></td>
                                            <td><?= esc($item['qty']); ?></td>
                                            <td><?= esc($item['lot_number']); ?></td>
                                            <td><?= esc($item['warehouse_from']); ?></td>
                                            <td><?= esc($item['remark']); ?></td>
                                            <td><?= esc($item['pic_action_date']); ?></td>
                                            <td
                                                class="<?= $item['adjust_pic'] === 'Approved Leader' ? 'status-approved' : ($item['adjust_pic'] === 'Disapproved Leader' ? 'status-disapproved' : 'status-pending'); ?>">
                                                <?= esc($item['adjust_pic']); ?>
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
                                        <td colspan="13" class="text-center">No data available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
            var baseUrl = '<?= base_url() ?>';
            var table = $('#cancelLotTable').DataTable({
                responsive: true,
                autoWidth: false,
                showLoaderOnConfirm: true,
                scrollX: true
            });




            // Filter berdasarkan tanggal
            $('#filterBtn').on('click', function () {
                table.draw();
            });

            // Ekspor data yang difilter
            $('#exportBtn').on('click', function () {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if (!startDate || !endDate) {
                    Swal.fire('Error!', 'Anda harus menentukan rentang tanggal.', 'error');
                    return;
                }

                window.location.href = `<?= base_url('/pic/exportFilteredData') ?>?start_date=${startDate}&end_date=${endDate}`;
            });

            // DataTables custom filter
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var startDate = $('#startDate').val();
                    var endDate = $('#endDate').val();
                    var date = new Date(data[2]); // Kolom tanggal, sesuaikan dengan indeks kolom tanggal Anda

                    if (
                        (startDate === '' || date >= new Date(startDate)) &&
                        (endDate === '' || date <= new Date(endDate))
                    ) {
                        return true;
                    }
                    return false;
                }
            );
            $(document).on('click', '.approve-leader-btn', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan di-approve oleh Leader!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, approve!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: baseUrl + 'pic/approveByLeader/' + id,
                            type: 'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Approved!', response.message, 'success').then(() => {
                                    // Update the status of the row
                                    var row = $(`tr[data-id="${id}"]`);
                                    row.find('td').eq(8).removeClass('status-pending').addClass('status-approved').text('Approved Leader');

                                    // Optionally, you can also update action buttons or other elements if necessary
                                    row.find('.approve-leader-btn').hide();
                                    row.find('.disapprove-leader-btn').hide();
                                    row.find('.approve-pic-btn').show();
                                    row.find('.disapprove-pic-btn').show();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Terjadi kesalahan saat menyetujui data.', 'error');
                        });
                    }
                });
            });

            $(document).on('click', '.disapprove-leader-btn', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan di-disapproved!",
                    icon: 'warning',
                    input: 'text', // Tampilkan input text untuk alasan penolakan
                    inputPlaceholder: 'Masukkan alasan penolakan',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda harus memberikan alasan!';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, disapproved!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        return $.ajax({
                            url: baseUrl + '/pic/disapproveByLeader/' + id,
                            type: 'POST',
                            data: { reason: reason }, // Kirim alasan penolakan
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Disapproved!', response.message, 'success').then(() => {
                                    // Hapus baris dari DataTable
                                    table.row($(`tr[data-id="${id}"]`)).remove().draw();
                                    // Refresh halaman setelah 1 detik
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Terjadi kesalahan saat menolak data.', 'error');
                        });
                    }
                });
            });

            $(document).on('click', '.approve-pic-btn', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan di-approve oleh PIC!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, approve!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: baseUrl + 'pic/approveByPIC/' + id,
                            type: 'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Approved!', response.message, 'success').then(() => {
                                    table.row($(`tr[data-id="${id}"]`)).remove().draw();
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Ini bukan hak akses Leader.', 'error');
                        });
                    }
                });
            });

            $(document).on('click', '.disapprove-pic-btn', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan di-disapproved!",
                    icon: 'warning',
                    input: 'text', // Tampilkan input text untuk alasan penolakan
                    inputPlaceholder: 'Masukkan alasan penolakan',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda harus memberikan alasan!';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, disapproved!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        return $.ajax({
                            url: baseUrl + 'pic/disapproveByPIC/' + id,
                            type: 'POST',
                            data: { reason: reason }, // Kirim alasan penolakan
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Disapproved!', response.message, 'success').then(() => {
                                    // Hapus baris dari DataTable
                                    table.row($(`tr[data-id="${id}"]`)).remove().draw();
                                    // Refresh halaman setelah 1 detik
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        }).fail(function (xhr, status, error) {
                            console.error('AJAX Error: ', status, error);
                            Swal.fire('Error!', 'Terjadi kesalahan saat menolak data.', 'error');
                        });
                    }
                });
            });

            // Handle select all checkbox
            $('#selectAll').on('change', function () {
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Handle individual row checkbox change
            $('#cancelLotTable').on('change', '.row-checkbox', function () {
                $('#selectAll').prop('checked', $('.row-checkbox:checked').length === $('.row-checkbox').length);
            });

            // Helper function to get selected IDs
            function getSelectedIds() {
                return $('.row-checkbox:checked').map(function () {
                    return $(this).closest('tr').data('id');
                }).get();
            }


            // Event handler untuk tombol bulk approve oleh Leader
            $('#approveLeaderSelected').click(function () {
                var selectedIds = getSelectedIds();

                if (selectedIds.length === 0) {
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
                            url: baseUrl + '/pic/approveSelectedByLeader',
                            type: 'POST',
                            data: { ids: selectedIds },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Disetujui!', response.message, 'success').then(() => {
                                    table.ajax.reload();
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
            $('#disapproveLeaderSelected').click(function () {
                var selectedIds = getSelectedIds();

                if (selectedIds.length === 0) {
                    Swal.fire('Peringatan!', 'Tidak ada data yang dipilih.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Semua data yang dipilih akan di-disapproved oleh Leader!",
                    icon: 'warning',
                    input: 'text',
                    inputPlaceholder: 'Masukkan alasan penolakan',
                    inputValidator: (value) => !value && 'Anda harus memberikan alasan!',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, disapprove!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        return $.ajax({
                            url: baseUrl + '/pic/disapproveSelectedByLeader',
                            type: 'POST',
                            data: { ids: selectedIds, reason: reason },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Disapproved!', response.message, 'success').then(() => {
                                    table.ajax.reload();
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
            $('#approvePICSelected').click(function () {
                var selectedIds = getSelectedIds();

                if (selectedIds.length === 0) {
                    Swal.fire('Peringatan!', 'Tidak ada data yang dipilih.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Semua data yang dipilih akan di-approve oleh PIC!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, approve!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        return $.ajax({
                            url: baseUrl + '/pic/approveSelectedByPIC',
                            type: 'POST',
                            data: { ids: selectedIds },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Approved!', response.message, 'success').then(() => {
                                    table.ajax.reload();
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




            /// Event handler untuk tombol bulk disapprove oleh PIC
            $('#disapprovePICSelected').click(function () {
                var selectedIds = getSelectedIds();

                if (selectedIds.length === 0) {
                    Swal.fire('Peringatan!', 'Tidak ada data yang dipilih.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Semua data yang dipilih akan di-disapprove oleh PIC!",
                    icon: 'warning',
                    input: 'text',
                    inputPlaceholder: 'Masukkan alasan penolakan',
                    inputValidator: (value) => !value && 'Anda harus memberikan alasan!',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, disapprove!',
                    cancelButtonText: 'Batal',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        return $.ajax({
                            url: baseUrl + '/pic/disapproveSelectedByPIC',
                            type: 'POST',
                            data: { ids: selectedIds, reason: reason },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        }).done(function (response) {
                            if (response.success) {
                                Swal.fire('Disapproved!', response.message, 'success').then(() => {
                                    table.ajax.reload();
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

        });


    </script>

    </div>

    <?= $this->endSection() ?>

</body>

</html>