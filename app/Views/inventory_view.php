<?= $this->extend('Navbar/main_layout') ?>

<?= $this->section('Navbar/content') ?>

<body id="page-top">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid mt-5">
            <h1>Adjustment Inventory</h1>


            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

            <!-- Trigger Modal Button -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#adjustmentModal">
                Add New Adjustment
            </button>

            <!-- Modal input -->
            <div class="modal fade" id="adjustmentModal" tabindex="-1" role="dialog"
                aria-labelledby="adjustmentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adjustmentModalLabel">New Adjustment Inventory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('/inventory/save') ?>" method="post" class="mb-5">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select id="department" name="department" class="form-control" required>
                                                <option value="">--- isi departement ---</option>
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
                                                <option value="">--- isi PIC ---</option>
                                                <option value="Alvin">Alvin</option>
                                                <option value="Irul">Irul</option>
                                                <option value="Channa">Channa</option>
                                                <option value="Supri">Supri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="part_number">Part Number</label>
                                            <input type="text" id="part_number" name="part_number"
                                                placeholder="Ketik atau Scan disini" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="qty">Quantity</label>
                                            <input type="text" id="qty" name="qty" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="lot_number">Lot Number</label>
                                            <input type="text" id="lot_number" name="lot_number" class="form-control"
                                                required>

                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="rn">RN</label>
                                            <input type="text" id="rn" name="rn" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="location">Warehouse</label>
                                            <select id="location" name="location" class="form-control" required>
                                                <option value="">--- Select Warehouse ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select id="status" name="status" class="form-control" required> </select>
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


            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Adjustment Inventory</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="post" action="<?= base_url('/inventory/update') ?>"
                                class="mb-5">
                                <input type="hidden" id="edit_id" name="id">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_department">Department</label>
                                            <select id="edit_department" name="department" class="form-control"
                                                required>
                                                <option value="">--- isi departement ---</option>
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
                                                <option value="">--- isi PIC ---</option>
                                                <option value="Alvin">Alvin</option>
                                                <option value="Irul">Irul</option>
                                                <option value="Channa">Channa</option>
                                                <option value="Supri">Supri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_part_number">Part Number</label>
                                            <input type="text" id="edit_part_number" name="part_number"
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
                                            <label for="edit_lot_number">Lot Number</label>
                                            <input type="text" id="edit_lot_number" name="lot_number"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_rn">RN</label>
                                            <input type="text" id="edit_rn" name="rn" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_location">Warehouse</label>
                                            <select id="edit_location" name="location" class="form-control" required>
                                                <option value="">--- Select Warehouse ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="edit_status">Status</label>
                                            <select id="edit_status" name="status" class="form-control" required>
                                            </select>
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
                    <h6 class="m-0 font-weight-bold text-primary">Record Riwayat Pengajuan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="approvedInventoryTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department</th>
                                    <th>PIC</th>
                                    <th>Part Number</th>
                                    <th>Tanggal</th>
                                    <th>Quantity</th>
                                    <th>Lot Number</th>
                                    <th>RN</th>
                                    <th>Warehouse</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Adjust</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($inventory)): ?>
                                    <?php foreach ($inventory as $key => $item): ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= esc($item['department']); ?></td>
                                            <td><?= esc($item['pic']); ?></td>
                                            <td><?= esc($item['part_number']); ?></td>
                                            <td><?= esc($item['tanggal']); ?></td>
                                            <td><?= esc($item['qty']); ?></td>
                                            <td><?= esc($item['lot_number']); ?></td>
                                            <td><?= esc($item['rn']); ?></td>
                                            <td><?= esc($item['location']); ?></td>
                                            <td><?= esc($item['status']); ?></td>
                                            <td><?= esc($item['remark']); ?></td>
                                            <td><?= esc($item['adjust_pic']); ?></td>
                                            <td>
                                                <?php if (empty($item['adjust_pic'])): ?>
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#editModal" data-id="<?= $item['id']; ?>"
                                                        data-department="<?= esc($item['department']); ?>"
                                                        data-pic="<?= esc($item['pic']); ?>"
                                                        data-part_number="<?= esc($item['part_number']); ?>"
                                                        data-qty="<?= esc($item['qty']); ?>"
                                                        data-lot_number="<?= esc($item['lot_number']); ?>"
                                                        data-rn="<?= esc($item['rn']); ?>"
                                                        data-location="<?= esc($item['location']); ?>"
                                                        data-status="<?= esc($item['status']); ?>"
                                                        data-remark="<?= esc($item['remark']); ?>">
                                                        <i class="fa fa-pencil"></i>
                                                    </button>
                                                    <a href="<?= base_url('inventory/delete/' . $item['id']); ?>"
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
                                        <td colspan="12">Tidak ada data tersedia</td> <!-- Update kolom span -->
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