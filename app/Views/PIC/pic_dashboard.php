<?= $this->extend('NavbarPic/main_layout') ?>

<?= $this->section('NavbarPic/content') ?>
<!-- Begin Page Content -->
<div class="container-fluid d-flex flex-column" style="min-height: 100vh;">
    <div class="row flex-grow-1 justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <!-- First Row -->
            <div class="card border-left-dark shadow-lg mb-3 pt-3">
                <div class="card-body">
                    <div class="row">
                        <!-- Card 1: Adjustment Inventory -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-primary shadow-lg h-100 w-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="row no-gutters align-items-center flex-grow-1">
                                        <div class="col mr-2">
                                            <div class="text-xl font-weight-bold text-primary text-uppercase mb-3">
                                                Adjustment Inventory
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-sliders-h fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="card border-primary mb-3 item-count-card">
                                            <div class="card-body">
                                                <div class="text-md text-primary font-weight-bold">
                                                    <?= $adjustmentInventoryCount ?> items
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('/pic') ?>" class="btn btn-primary mt-3">Lihat Sekarang
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Transfer Stock -->
                        <?php if (!in_array(session()->get('role'), ['LEADERMFG1', 'LEADERMFG2'])): ?>
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="card border-left-success shadow-lg h-100 w-100">
                                    <div class="card-body d-flex flex-column">
                                        <div class="row no-gutters align-items-center flex-grow-1">
                                            <div class="col mr-2">
                                                <div class="text-xl font-weight-bold text-success text-uppercase mb-3">
                                                    Transfer Stock
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-exchange-alt fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="card border-success mb-3 item-count-card">
                                                <div class="card-body">
                                                    <div class="text-md text-success font-weight-bold">
                                                        <?= $transferStockCount ?> items
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="<?= base_url('/pic/transferStock') ?>" class="btn btn-success mt-3">Lihat
                                            Sekarang
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Card 3: Cancel Lot -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-danger shadow-lg h-100 w-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="row no-gutters align-items-center flex-grow-1">
                                        <div class="col mr-2">
                                            <div class="text-xl font-weight-bold text-danger text-uppercase mb-3">
                                                Cancel Lot
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-ban fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="card border-danger mb-3 item-count-card">
                                            <div class="card-body">
                                                <div class="text-md text-danger font-weight-bold">
                                                    <?= $cancelLotCount ?> items
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('/pic/cancelLot') ?>" class="btn btn-danger mt-3">Lihat
                                        Sekarang
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Second Row -->
            <div class="card border-left-dark shadow-lg pt-3">
                <div class="card-body pt-1">
                    <div class="text-xl font-weight-bold text-dark text-uppercase mb-3">
                        Status
                    </div>
                    <div class="row">
                        <!-- Card 4: Waiting Approved -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-warning shadow-lg h-100 w-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="row no-gutters align-items-center flex-grow-1">
                                        <div class="col mr-2">
                                            <div class="text-xl font-weight-bold text-warning text-uppercase mb-3">
                                                Waiting Approved
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-hourglass-half fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="card border-warning mb-3 item-count-card">
                                            <div class="card-body">
                                                <div class="text-md text-warning font-weight-bold">
                                                    <?= $waitingApprovedCount ?> items
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('/dashboard/waiting_approved') ?>"
                                        class="btn btn-warning mt-3 btn-white-text">Lihat Sekarang
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 5: Approved -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-primary shadow-lg h-100 w-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="row no-gutters align-items-center flex-grow-1">
                                        <div class="col mr-2">
                                            <div class="text-xl font-weight-bold text-primary text-uppercase mb-3">
                                                Approved
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-check fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="card border-primary mb-3 item-count-card">
                                            <div class="card-body">
                                                <div class="text-md text-primary font-weight-bold">
                                                    <?= $approvedCount ?> items
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('/dashboard/approved') ?>" class="btn btn-primary mt-3">Lihat
                                        Sekarang
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card 6: Disapproved -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-danger shadow-lg h-100 w-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="row no-gutters align-items-center flex-grow-1">
                                        <div class="col mr-2">
                                            <div class="text-xl font-weight-bold text-danger text-uppercase mb-3">
                                                Disapproved
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-times fa-3x text-gray-300"></i>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="card border-danger mb-3 item-count-card">
                                            <div class="card-body">
                                                <div class="text-md text-danger font-weight-bold">
                                                    <?= $disapprovedCount ?> items
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('/dashboard/disapproved') ?>"
                                        class="btn btn-danger mt-3">Lihat Sekarang
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container-fluid my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; IT NSI 2024</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Custom CSS -->
<style>
    .item-count-card {
        border-radius: 8px;
        background-color: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.2);
        padding: 8px;
        height: 100%;
    }

    .item-count {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
    }

    .btn {
        display: block;
        text-align: center;
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        font-weight: 600;
        margin-top: 10px;
        /* Added margin-top to separate the button from the item card */
    }

    /* Additional styling for full width cards */
    .card {
        width: 100%;
    }

    .row>.col {
        margin-bottom: 10px;
        /* Padding between items */
    }
</style>

<!-- Script for hover effect -->
<script>
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('mouseover', function () {
            this.style.transform = 'scale(1.07)';
        });
        link.addEventListener('mouseout', function () {
            this.style.transform = 'scale(1)';
        });
    });
</script>

<?= $this->endSection() ?>