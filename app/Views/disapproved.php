<?= $this->extend('Navbar/main_layout') ?>

<?= $this->section('Navbar/content') ?>

<body id="page-top">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Navigation Buttons -->
            <div class="mb-3">
                <button id="showAdjustmentInventory" class="btn btn-primary">Adjustment Inventory</button>

                <?php if (!in_array(session()->get('role'), ['MFG1', 'MFG2'])): ?>
                    <button id="showTransferStock" class="btn btn-secondary">Transfer Stock</button>
                <?php endif; ?>

                <button id="showCancelLot" class="btn btn-danger">Cancel Lot</button>
            </div>

            <!-- Disapproved Inventory -->
            <div class="card shadow mb-3" id="adjustmentInventorySection">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Disapproved - Adjusment Inventory</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="disapprovedInventoryTable" width="100%" cellspacing="0">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($combinedDisapprovedItems as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $item['department'] ?? '' ?></td>
                                        <td><?= $item['pic'] ?? '' ?></td>
                                        <td><?= $item['part_number'] ?? '' ?></td>
                                        <td><?= $item['tanggal'] ?? '' ?></td>
                                        <td><?= $item['qty'] ?? '' ?></td>
                                        <td><?= $item['lot_number'] ?? '' ?></td>
                                        <td><?= $item['rn'] ?? '' ?></td>
                                        <td><?= $item['location'] ?? '' ?></td>
                                        <td><?= $item['status'] ?? '' ?></td>
                                        <td><?= $item['remark'] ?? '' ?></td>
                                        <td><?= $item['adjust_pic'] ?? '' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Disapproved Transfer Stock -->
            <div class="card shadow mb-3" id="transferStockSection">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Disapproved - Transfer Stock</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="disapprovedTransferStockTable" width="100%"
                            cellspacing="0">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($combinedDisapprovedItemsTransfer as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $item['department'] ?? '' ?></td>
                                        <td><?= $item['pic'] ?? '' ?></td>
                                        <td><?= $item['tanggal'] ?? '' ?></td>
                                        <td><?= $item['part_number_from'] ?? '' ?></td>
                                        <td><?= $item['part_number_to'] ?? '' ?></td>
                                        <td><?= $item['qty'] ?? '' ?></td>
                                        <td><?= $item['lot_number_from'] ?? '' ?></td>
                                        <td><?= $item['lot_number_to'] ?? '' ?></td>
                                        <td><?= $item['rn_from'] ?? '' ?></td>
                                        <td><?= $item['rn_to'] ?? '' ?></td>
                                        <td><?= $item['warehouse_from'] ?? '' ?></td>
                                        <td><?= $item['warehouse_to'] ?? '' ?></td>
                                        <td><?= $item['status'] ?? '' ?></td>
                                        <td><?= $item['remark'] ?? '' ?></td>
                                        <td><?= $item['adjust_pic'] ?? '' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Disapproved Cancel Lot -->
            <div class="card shadow mb-3" id="cancelLotSection">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Disapproved - Cancel Lot</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="disapprovedCancelLotTable" width="100%" cellspacing="0">
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($combinedDisapprovedItemsCancel as $key => $item): ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= $item['department'] ?? '' ?></td>
                                        <td><?= $item['pic'] ?? '' ?></td>
                                        <td><?= $item['tanggal'] ?? '' ?></td>
                                        <td><?= $item['part_number_from'] ?? '' ?></td>
                                        <td><?= $item['part_number_to'] ?? '' ?></td>
                                        <td><?= $item['qty'] ?? '' ?></td>
                                        <td><?= $item['lot_number'] ?? '' ?></td>
                                        <td><?= $item['warehouse_from'] ?? '' ?></td>
                                        <td><?= $item['warehouse_to'] ?? '' ?></td>
                                        <td><?= $item['remark'] ?? '' ?></td>
                                        <td><?= $item['adjust_pic'] ?? '' ?></td>
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