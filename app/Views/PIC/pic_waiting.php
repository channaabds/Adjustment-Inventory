<?= $this->extend('NavbarPic/main_layout') ?>

<?= $this->section('NavbarPic/content') ?>

<body id="page-top">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Filter Tanggal -->
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter Tanggal</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="dateFilter">Pilih tanggal:</label>
                        <input type="date" id="dateFilter" name="dateFilter" class="form-control">
                    </div>
                    <button id="resetFilterBtn" class="btn btn-dark">Reset Filter</button>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="card shadow mb-3 p-3">
                <div class="card-body text-center">
                    <button id="showAdjustmentInventory" class="btn btn-primary btn-lg">Adjustment Inventory</button>
                    <?php if ($userRole !== 'MFG1' && $userRole !== 'MFG2' && $userRole !== 'LEADERMFG1' && $userRole !== 'LEADERMFG2'): ?>
                        <button id="showTransferStock" class="btn btn-secondary btn-lg">Transfer Stock</button>
                    <?php endif; ?>
                    <button id="showCancelLot" class="btn btn-success btn-lg">Cancel Lot</button>
                </div>
            </div>

            <!-- Adjustment Inventory -->
            <div id="adjustmentInventorySection" class="card shadow mb-3" style="display: none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Waiting Approved - Adjustment Inventory</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="adjustmentInventoryTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Tanggal</th>
                                    <th>Part Number</th>
                                    <th>Quantity</th>
                                    <th>No. Lot/RN</th>
                                    <th>Warehouse</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($waitingApprovedItems as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($item['department']); ?></td>
                                        <td><?= esc($item['pic']); ?></td>
                                        <td><?= esc($item['tanggal']); ?></td>
                                        <td><?= esc($item['part_number']); ?></td>
                                        <td><?= esc($item['qty']); ?></td>
                                        <td><?= esc($item['lot_number']); ?></td>
                                        <td><?= esc($item['location']); ?></td>
                                        <td><?= esc($item['status']); ?></td>
                                        <td><?= esc($item['remark']); ?></td>
                                        <td>
                                            <?php if (empty($item['adjust_pic'])): ?>
                                                <a href="<?= base_url('/inventory/edit/' . $item['id']); ?>"
                                                    class="btn btn-sm btn-primary"
                                                    style="margin-right: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: box-shadow 0.3s ease;">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('/inventory/delete/' . $item['id']); ?>"
                                                    class="btn btn-sm btn-danger delete-btn" data-id="<?= $item['id']; ?>"
                                                    style="margin-right: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: box-shadow 0.3s ease;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <span>Data ini sudah di review PIC tidak bisa diubah atau dihapus lagi</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Transfer Stock -->
            <?php if ($userRole !== 'MFG1' && $userRole !== 'MFG2' && $userRole !== 'LEADERMFG1' && $userRole !== 'LEADERMFG2'): ?>
                <div id="transferStockSection" class="card shadow mb-3" style="display: none;">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Waiting Approved - Transfer Stock</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="transferStockTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Department</th>
                                        <th>PIC</th>
                                        <th>Tanggal</th>
                                        <th>Part Number From</th>
                                        <th>Part Number To</th>
                                        <th>Quantity</th>
                                        <th>No. Lot/RN</th>
                                        <th>Warehouse From</th>
                                        <th>Warehouse To</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($waitingApprovedItemsTransfer as $key => $item): ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= esc($item['department']); ?></td>
                                            <td><?= esc($item['pic']); ?></td>
                                            <td><?= esc($item['tanggal']); ?></td>
                                            <td><?= esc($item['part_number_from']); ?></td>
                                            <td><?= esc($item['part_number_to']); ?></td>
                                            <td><?= esc($item['qty']); ?></td>
                                            <td><?= esc($item['lot_number']); ?></td>
                                            <td><?= esc($item['warehouse_from']); ?></td>
                                            <td><?= esc($item['warehouse_to']); ?></td>
                                            <td><?= esc($item['status']); ?></td>
                                            <td><?= esc($item['remark']); ?></td>
                                            <td>
                                                <?php if (empty($item['adjust_pic'])): ?>
                                                    <a href="<?= base_url('/inventory/edit/' . $item['id']); ?>"
                                                        class="btn btn-sm btn-primary"
                                                        style="margin-right: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: box-shadow 0.3s ease;">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="<?= base_url('/inventory/delete/' . $item['id']); ?>"
                                                        class="btn btn-sm btn-danger delete-btn" data-id="<?= $item['id']; ?>"
                                                        style="margin-right: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: box-shadow 0.3s ease;">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span>Data ini sudah di review PIC tidak bisa diubah atau dihapus lagi</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Cancel Lot -->
            <div id="cancelLotSection" class="card shadow mb-3" style="display: none;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Waiting Approved - Cancel Lot</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cancelLotTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Tanggal</th>
                                    <th>Part Number From</th>
                                    <th>Part Number To</th>
                                    <th>Quantity</th>
                                    <th>No. Lot/RN</th>
                                    <th>Warehouse From</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($waitingApprovedItemsCancelLot as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($item['department']); ?></td>
                                        <td><?= esc($item['pic']); ?></td>
                                        <td><?= esc($item['tanggal']); ?></td>
                                        <td><?= esc($item['part_number_from']); ?></td>
                                        <td><?= esc($item['part_number_to']); ?></td>
                                        <td><?= esc($item['qty']); ?></td>
                                        <td><?= esc($item['lot_number']); ?></td>
                                        <td><?= esc($item['warehouse_from']); ?></td>
                                        <td><?= esc($item['remark']); ?></td>
                                        <td>
                                            <?php if (empty($item['adjust_pic'])): ?>
                                                <a href="<?= base_url('/inventory/edit/' . $item['id']); ?>"
                                                    class="btn btn-sm btn-primary"
                                                    style="margin-right: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: box-shadow 0.3s ease;">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="<?= base_url('/inventory/delete/' . $item['id']); ?>"
                                                    class="btn btn-sm btn-danger delete-btn" data-id="<?= $item['id']; ?>"
                                                    style="margin-right: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: box-shadow 0.3s ease;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            <?php else: ?>
                                                <span>Data ini sudah di review PIC tidak bisa diubah atau dihapus lagi</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?= $this->endSection() ?>

    <!-- Load jQuery, DataTables, SweetAlert libraries -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTables
            var adjustmentTable = $('#adjustmentInventoryTable').DataTable();
            var transferStockTable = $('#transferStockTable').DataTable();
            var cancelLotTable = $('#cancelLotTable').DataTable();

            // Show only one table at a time
            $('#showAdjustmentInventory').on('click', function () {
                $('#adjustmentInventorySection').show();
                $('#transferStockSection').hide();
                $('#cancelLotSection').hide();
            });

            $('#showTransferStock').on('click', function () {
                $('#adjustmentInventorySection').hide();
                $('#transferStockSection').show();
                $('#cancelLotSection').hide();
            });

            $('#showCancelLot').on('click', function () {
                $('#adjustmentInventorySection').hide();
                $('#transferStockSection').hide();
                $('#cancelLotSection').show();
            });

            // Date filter
            var dateFilter = $('#dateFilter');
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterDate = dateFilter.val();
                var rowDate = data[3]; // Index of the Tanggal column (adjust according to your table)

                if (!filterDate || rowDate.includes(filterDate)) {
                    return true;
                }
                return false;
            });

            // Filter event
            dateFilter.on('change', function () {
                adjustmentTable.draw();
                transferStockTable.draw();
                cancelLotTable.draw();
            });

            // Reset filter
            $('#resetFilterBtn').on('click', function () {
                dateFilter.val('');
                adjustmentTable.draw();
                transferStockTable.draw();
                cancelLotTable.draw();
            });

            // SweetAlert for delete confirmation
            $(document).on('click', '.delete-btn', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this data!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

</body>