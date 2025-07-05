<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Adjustment Menunggu Tindakan</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Token CSRF -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <style>
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
    <!-- Konten Utama -->
    <div id="content">
        <div class="container-fluid">
            <!-- Kartu Data Belum Di-Approve -->
            <div class="card">
                <div class="card-header">
                    <h5>Data Menunggu Tindakan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="pendingTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Part Number</th>
                                    <th>Tanggal</th>
                                    <th>Quantity</th>
                                    <th>No. Lot/RN</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Adjust PIC</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pendingAdjustments)): ?>
                                    <?php foreach ($pendingAdjustments as $key => $item): ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= esc($item['department']); ?></td>
                                            <td><?= esc($item['pic']); ?></td>
                                            <td><?= esc($item['part_number']); ?></td>
                                            <td><?= esc($item['tanggal']); ?></td>
                                            <td><?= esc($item['qty']); ?></td>
                                            <td><?= esc($item['lot_number']); ?></td>
                                            <td><?= esc($item['location']); ?></td>
                                            <td><?= esc($item['status']); ?></td>
                                            <td><?= esc($item['remark']); ?></td>
                                            <td><?= esc($item['adjust_pic']) ?: 'Menunggu Tindakan'; ?></td>
                                            <td>
                                                <!-- Tombol Action -->
                                                <button class="btn btn-sm btn-success approve-btn"
                                                    data-id="<?= $item['id']; ?>">
                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> Approve
                                                </button>
                                                <button class="btn btn-sm btn-danger disapprove-btn"
                                                    data-id="<?= $item['id']; ?>">
                                                    <i class="fa fa-times-circle-o" aria-hidden="true"></i> Disapprove
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" class="text-center">Tidak ada data tersedia</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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

            // Inisialisasi DataTables untuk tabel data menunggu tindakan
            var pendingTable = $('#pendingTable').DataTable({
                responsive: true,
                autoWidth: false,
                scrollX: true
            });

            // Fungsi untuk menyetujui data
            $(document).on('click', '.approve-btn', function () {
                var id = $(this).data('id'); // Ambil ID dari data-id pada tombol
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan di-approve!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, approve!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrl + 'pic/approve/' + id,
                            type: 'POST',
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Approved!',
                                        'Data telah disetujui.',
                                        'success'
                                    );
                                    pendingTable.ajax.reload(); // Reload tabel setelah approval
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat menyetujui data.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });

            // Fungsi untuk menolak data
            $(document).on('click', '.disapprove-btn', function () {
                var id = $(this).data('id'); // Ambil ID dari data-id pada tombol
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan di-disapprove!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, disapprove!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrl + 'pic/disapprove/' + id,
                            type: 'POST',
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Disapproved!',
                                        'Data telah ditolak.',
                                        'success'
                                    );
                                    pendingTable.ajax.reload(); // Reload tabel setelah disapproval
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat menolak data.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>