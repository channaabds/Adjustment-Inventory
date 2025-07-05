<?= $this->extend('Navbar/main_layout') ?>

<?= $this->section('Navbar/content') ?>

<body id="page-top">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid mt-5">
            <h1>Transfer Stock</h1>

            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

            <!-- Trigger Modal Button -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#transferModal">
                Add New Transfer
            </button>

            <!-- Modal input -->
            <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="transferModalLabel">New Transfer Stock</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('/inventory/saveTransferStock') ?>" method="post" class="mb-5">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select id="department" name="department" class="form-control" required>
                                                <option value="">--- Pilih Departement ---</option>
                                                <option value="MFG1">MFG1</option>
                                                <option value="MFG2">MFG2</option>
                                                <option value="QC">QC</option>
                                                <option value="PPIC">PPIC</option>
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
                                            <label for="part_number_from_transfer">Part Number From</label>
                                            <input type="text" id="part_number_from_transfer" name="part_number_from"
                                                placeholder="Ketik atau Scan disini" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="part_number_to_transfer">Part Number To</label>
                                            <input type="text" id="part_number_to_transfer" name="part_number_to"
                                                placeholder="Ketik atau Scan disini" class="form-control" required>
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
                                            <label for="lot_number_from_transfer">Lot Number From</label>
                                            <input type="text" id="lot_number_from_transfer" name="lot_number_from"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="lot_number_to_transfer">Lot Number To</label>
                                            <input type="text" id="lot_number_to_transfer" name="lot_number_to"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="rn_from_transfer">RN From</label>
                                            <input type="text" id="rn_from_transfer" name="rn_from" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="rn_to_transfer">RN To</label>
                                            <input type="text" id="rn_to_transfer" name="rn_to" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="warehouse_from">Warehouse From</label>
                                            <select id="warehouse_from" name="warehouse_from" class="form-control"
                                                required>
                                                <option value="">--- Select Warehouse ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="warehouse_to">Warehouse To</label>
                                            <select id="warehouse_to" name="warehouse_to" class="form-control" required>
                                                <option value="">--- Select Warehouse ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select id="status" name="status" class="form-control" required>
                                                <option value="">--- Pilih Status ---</option>
                                                <option value="PEND">PEND</option>
                                                <option value="NG">NG</option>
                                                <option value="OK">OK</option>
                                                <option value="MIN">MIN</option>
                                                <option value="PLUS">PLUS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="remark">Remark</label>
                                            <input type="text" id="remark" name="remark" class="form-control">
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

            <!-- Modal Edit Transfer Stock -->
            <div class="modal fade" id="editTransferStockModal" tabindex="-1" role="dialog"
                aria-labelledby="editTransferStockModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTransferStockModalLabel">Edit Transfer Stock</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('/inventory/updateTransferStock') ?>" method="post" class="mb-5">
                                <input type="hidden" id="edit_transfer_id" name="id">
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
                                                <option value="PPIC">PPIC</option>
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
                                            <label for="edit_part_number_from_transfer">Part Number From</label>
                                            <input type="text" id="edit_part_number_from" name="part_number_from"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_part_number_to_transfer">Part Number To</label>
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
                                            <label for="edit_lot_number_from_transfer">Lot Number From</label>
                                            <input type="text" id="edit_lot_number_from" name="lot_number_from"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_lot_number_to_transfer">Lot Number To</label>
                                            <input type="text" id="edit_lot_number_to" name="lot_number_to"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_rn_from_transfer">RN From</label>
                                            <input type="text" id="edit_rn_from" name="rn_from" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_rn_to_transfer">RN To</label>
                                            <input type="text" id="edit_rn_to" name="rn_to" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_warehouse_from">Warehouse From</label>
                                            <select id="edit_warehouse_from" name="warehouse_from" class="form-control"
                                                required>
                                                <option value="">--- Select Warehouse ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_warehouse_to">Warehouse To</label>
                                            <select id="edit_warehouse_to" name="warehouse_to" class="form-control"
                                                required>
                                                <option value="">--- Select Warehouse ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_status">Status</label>
                                            <select id="edit_status" name="status" class="form-control" required>
                                                <option value="">--- Pilih Status ---</option>
                                                <option value="PEND">PEND</option>
                                                <option value="NG">NG</option>
                                                <option value="OK">OK</option>
                                                <option value="MIN">MIN</option>
                                                <option value="PLUS">PLUS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_remark">Remark</label>
                                            <input type="text" id="edit_remark" name="remark" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Update</button>
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
                    <h6 class="m-0 font-weight-bold text-primary">Record Riwayat Pengajuan Transfer Stock</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="approvedInventoryTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Tanggal</th>
                                    <th>Part Number From</th>
                                    <th>Part Number To</th>
                                    <th>Quantity</th>
                                    <th>Lot Number From</th>
                                    <th>Lot Number To</th>
                                    <th>RN From</th>
                                    <th>RN To</th>
                                    <th>Warehouse From</th>
                                    <th>Warehouse To</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Adjust</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transferStock)): ?>
                                    <?php foreach ($transferStock as $key => $item): ?>
                                        <tr>
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
                                            <td><?= esc($item['adjust_pic']); ?></td>
                                            <td>
                                                <?php if (empty($item['adjust_pic'])): ?>
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#editTransferStockModal" data-id="<?= $item['id']; ?>"
                                                        data-department="<?= esc($item['department']); ?>"
                                                        data-pic="<?= esc($item['pic']); ?>"
                                                        data-part_number_from="<?= esc($item['part_number_from']); ?>"
                                                        data-part_number_to="<?= esc($item['part_number_to']); ?>"
                                                        data-qty="<?= esc($item['qty']); ?>"
                                                        data-lot_number_from="<?= esc($item['lot_number_from']); ?>"
                                                        data-lot_number_to="<?= esc($item['lot_number_to']); ?>"
                                                        data-rn_from="<?= esc($item['rn_from']); ?>"
                                                        data-rn_to="<?= esc($item['rn_to']); ?>"
                                                        data-warehouse_from="<?= esc($item['warehouse_from']); ?>"
                                                        data-warehouse_to="<?= esc($item['warehouse_to']); ?>"
                                                        data-status="<?= esc($item['status']); ?>"
                                                        data-remark="<?= esc($item['remark']); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                    <a href="<?= base_url('inventory/transfer/delete/' . $item['id']); ?>"
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

    </div>


    <?= $this->endSection() ?>

