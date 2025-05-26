        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="<?php echo base_url().INDEX_URL?>dashboard">
                <div class="sidebar-brand-icon">
                    <img src="<?php echo base_url('assets/img/perpus') ?>/logo-perpus.png" style="height:60px">
                </div>
                <div class="sidebar-brand-text mx-3">TANDON</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url().INDEX_URL ?>dashboard">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Dashboard</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Transaksi Buku
            </div>

            <!-- Nav Item - transaksi peminjaman Buku -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url().INDEX_URL ?>dashboard/peminjaman">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Peminjaman</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url().INDEX_URL ?>dashboard/pengembalian">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pengembalian</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url().INDEX_URL ?>dashboard/list_transaction">
                    <i class="fas fa-fw fa-book"></i>
                    <span>List Transaksi</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Pengawasan Buku
            </div>

            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url().INDEX_URL ?>dashboard/monitoring">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Monitoring</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url().INDEX_URL ?>dashboard/tanggungan">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Tanggungan</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->