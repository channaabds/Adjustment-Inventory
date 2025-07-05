<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar"
    style="min-height: 100vh; height: auto;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center mb-2">
        <div class="sidebar-brand-icon">
            <img class="img-profile rounded-circle pt-1" src="<?= base_url('templates/logo.png') ?>"
                style="width: 65px; height: 65px;">
        </div>
        <div class="sidebar-brand-text mx-3">
            <?php
            $username = session()->get('username') ?? 'Guest'; // Default ke 'Guest' jika tidak ada username
            ?>
            <span class="text-white" style="text-transform: lowercase;">Welcome,
                <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>!</span>

        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
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
    <hr class="sidebar-divider my-0">

    <!-- Heading -->
    <div class="sidebar-heading pt-3">
        Interface
    </div>

    <!-- Nav Item - Adjustment Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdjustment"
            aria-expanded="false" aria-controls="collapseAdjustment">
            <i class="fa fa-files-o" aria-hidden="true"></i>
            <span>Adjustment</span>
        </a>
        <div id="collapseAdjustment" class="collapse" aria-labelledby="headingAdjustment"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= base_url('/pic') ?>">Adjustment Inventory</a>
                <a class="collapse-item" href="<?= base_url('/pic/transferStock') ?>">Transfer Stock</a>
                <a class="collapse-item" href="<?= base_url('/pic/cancelLot') ?>">Cancel Lot</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - History Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHistory"
            aria-expanded="false" aria-controls="collapseHistory">
            <i class="fa fa-history" aria-hidden="true"></i>
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

<style>
    /* CSS for hover and active menu effects */
    .nav-item:hover .nav-link {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        transition: all 0.3s ease-in-out;
        border-radius: 0.5rem;
    }

    /* Optional: CSS for active link effect if needed */
    .nav-item.active>.nav-link {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        border-radius: 0.5rem;
    }

    /* Additional styling for submenu in collapse */
    .collapse-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #000000;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        transition: all 0.3s ease-in-out;
        border-radius: 0.5rem;
    }

    .sidebar .nav-link {
        color: #ffffff;
    }

    /* Adjust sidebar height based on content */
    .navbar-nav {
        height: auto;
    }

    .sidebar-brand {
        padding: 1.5rem 1rem;
        text-align: center;
    }
</style>