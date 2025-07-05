<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center">
        <!-- Replace with your logo or image -->
        <div class="sidebar-brand-icon">
            <img class="img-profile rounded-circle" src="<?= base_url('templates/logo.png') ?>"
                style="width: 50px; height: 50px;">
        </div>
        <div class="sidebar-brand-text mx-3">
            <?php
            $username = session()->get('username');
            error_log('Username from session: ' . $username); // Log ke file error log server
            ?>
            <span class="text-white" style="text-transform: lowercase;">Welcome,
                <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>!</span>

        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <?php
        // Mendapatkan peran pengguna dari sesi
        $session = session();
        $userRole = $session->get('role');
        // Tentukan URL berdasarkan peran pengguna
        $dashboardUrl = in_array($userRole, ['PIC', 'PIC2', 'LEADERMFG1', 'LEADERMFG2', 'LEADERQC', 'IT', 'CS'])
            ? base_url('/pic/dashboard')
            : base_url('/dashboard');
        ?>
        <a class="nav-link" href="<?= $dashboardUrl ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Adjustment Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdjustment"
            aria-expanded="false" aria-controls="collapseAdjustment">
            <i class="fas fa-cog"></i>
            <span>Adjustment</span>
        </a>
        <div id="collapseAdjustment" class="collapse" aria-labelledby="headingAdjustment"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('/inventory') ?>">Adjustment Inventory</a>
                <a class="collapse-item" href="<?= base_url('/inventory/transfer') ?>">Transfer Stock</a>
                <a class="collapse-item" href="<?= base_url('/inventory/cancelLot') ?>">Cancel Lot</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - History Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHistory"
            aria-expanded="false" aria-controls="collapseHistory">
            <i class="fas fa-wrench"></i>
            <span>History</span>
        </a>
        <div id="collapseHistory" class="collapse" aria-labelledby="headingHistory" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('/dashboard/waiting_approved') ?>">Waiting Approved</a>
                <a class="collapse-item" href="<?= base_url('/dashboard/approved') ?>">Approved</a>
                <a class="collapse-item" href="<?= base_url('/dashboard/disapproved') ?>">Disapproved</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/alldata') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>All Data</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->