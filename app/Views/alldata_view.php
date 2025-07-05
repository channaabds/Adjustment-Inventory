<?= $this->extend('NavbarPic/main_layout') ?>

<?= $this->section('NavbarPic/content') ?>

<body id="page-top">

    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Row for Cards -->
            <div class="row">

                <!-- Card 1: Adjustment Inventory -->
                <div class="col-lg-4 mb-3">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Adjustment Inventory</h6>
                        </div>
                        <div class="card-body">
                            <p>Details about Adjustment Inventory.</p>
                            <a href="<?= base_url('/history'); ?>" class="btn btn-primary">Go to Adjustment Page</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Transfer Stock -->
                <div class="col-lg-4 mb-3">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Transfer Stock</h6>
                        </div>
                        <div class="card-body">
                            <p>Details about Transfer Stock.</p>
                            <a href="<?= base_url('transfer-stock-history'); ?>" class="btn btn-primary">Go to Transfer
                                Page</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Cancel Lot -->
                <div class="col-lg-4 mb-3">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cancel Lot</h6>
                        </div>
                        <div class="card-body">
                            <p>Details about Cancel Lot.</p>
                            <a href="<?= base_url('/cancels'); ?>" class="btn btn-primary">Go to Cancel Page</a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End of Row -->

        </div>
        <!-- End of Container Fluid -->

        <?= $this->endSection() ?>