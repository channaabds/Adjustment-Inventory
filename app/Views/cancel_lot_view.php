<?= $this->extend('Navbar/main_layout') ?>

<?= $this->section('Navbar/content') ?>

<body id="page-top">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid mt-5">
            <h1>Cancel Lot</h1>

            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

            <!-- Trigger Modal Button -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#cancelLotModal">
                Add New Cancel Lot
            </button>

            <!-- Modal input -->
            <div class="modal fade" id="cancelLotModal" tabindex="-1" role="dialog"
                aria-labelledby="cancelLotModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelLotModalLabel">New Cancel Lot</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('/inventory/saveCancelLot') ?>" method="post" class="mb-5">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select id="department" name="department" class="form-control" required>
                                                <option value="">--- Pilih Departement ---</option>
                                                <option value="MFG1">MFG1</option>
                                                <option value="MFG2">MFG2</option>
                                                <option value="QC">QC</option>
                                                <option value="DELIVERY">DELIVERY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="pic">PIC</label>
                                            <select id="pic" name="pic" class="form-control" required>
                                                <option value="">--- Pilih PIC ---</option>
                                                <option value="Alvin">Alvin</option>
                                                <option value="Irul">Irul</option>
                                                <option value="Channa">Channa</option>
                                                <option value="Supri">Supri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="part_number_from">Part Number From</label>
                                            <input type="text" id="part_number_from" name="part_number_from"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="part_number_to">Part Number To</label>
                                            <input type="text" id="part_number_to" name="part_number_to"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="qty">Quantity</label>
                                            <input type="number" id="qty" name="qty" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="lot_number">No. Lot/RN</label>
                                            <input type="text" id="lot_number" name="lot_number" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="warehouse_from">Warehouse From</label>
                                            <input type="text" id="warehouse_from" name="warehouse_from"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="warehouse_to">Warehouse To</label>
                                            <input type="text" id="warehouse_to" name="warehouse_to"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" id="remark" name="remark" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal edit -->
            <div class="modal fade" id="editModalCancel" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Cancel Lot</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" action="<?= base_url('inventory/updateCancelLot') ?>" method="post"
                                class="mb-5">
                                <!-- Form fields -->
                                <!-- Hidden field for ID -->
                                <input type="hidden" id="edit_id" name="id">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_department">Department</label>
                                            <select id="edit_department" name="department" class="form-control"
                                                required>
                                                <option value="">--- Pilih Departement ---</option>
                                                <option value="MFG1">MFG1</option>
                                                <option value="MFG2">MFG2</option>
                                                <option value="QC">QC</option>
                                                <option value="DELIVERY">DELIVERY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_pic">PIC</label>
                                            <select id="edit_pic" name="pic" class="form-control" required>
                                                <option value="">--- Pilih PIC ---</option>
                                                <option value="Alvin">Alvin</option>
                                                <option value="Irul">Irul</option>
                                                <option value="Channa">Channa</option>
                                                <option value="Supri">Supri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_part_number_from">Part Number From</label>
                                            <input type="text" id="edit_part_number_from" name="part_number_from"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_part_number_to">Part Number To</label>
                                            <input type="text" id="edit_part_number_to" name="part_number_to"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_qty">Quantity</label>
                                            <input type="number" id="edit_qty" name="qty" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_lot_number">No. Lot/RN</label>
                                            <input type="number" id="edit_lot_number" name="lot_number"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_warehouse_from">Warehouse From</label>
                                            <input type="text" id="edit_warehouse_from" name="warehouse_from"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_warehouse_to">Warehouse To</label>
                                            <input type="text" id="edit_warehouse_to" name="warehouse_to"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_remark">Remark</label>
                                            <input type="text" id="edit_remark" name="remark" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- tabel hasil inputan -->
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Record Riwayat Pengajuan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="approvedCancelLotTable" width="100%" cellspacing="0">
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
                                    <th>Remark</th>
                                    <th>Adjust</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($cancelLot)): ?>
                                    <?php foreach ($cancelLot as $key => $item): ?>
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
                                            <td><?= esc($item['remark']); ?></td>
                                            <td><?= esc($item['adjust_pic']); ?></td>
                                            <td>
                                                <?php if (empty($item['adjust_pic'])): ?>
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#editModalCancel" data-id="<?= $item['id']; ?>"
                                                        data-department="<?= esc($item['department']); ?>"
                                                        data-pic="<?= esc($item['pic']); ?>"
                                                        data-part_number_from="<?= esc($item['part_number_from']); ?>"
                                                        data-part_number_to="<?= esc($item['part_number_to']); ?>"
                                                        data-qty="<?= esc($item['qty']); ?>"
                                                        data-lot_number="<?= esc($item['lot_number']); ?>"
                                                        data-warehouse_from="<?= esc($item['warehouse_from']); ?>"
                                                        data-warehouse_to="<?= esc($item['warehouse_to']); ?>"
                                                        data-remark="<?= esc($item['remark']); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                    <a href="<?= base_url('inventory/cancel/delete/' . $item['id']); ?>"
                                                        class="btn btn-sm btn-danger btn-delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span>Review PIC</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="13">Tidak ada data tersedia</td> <!-- Update kolom span -->
                                    </tr>
                                <?php endif; ?>
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