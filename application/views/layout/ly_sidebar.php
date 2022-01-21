<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light fixed" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading text-black">Dashboard</div>
                    <!-- Absen -->
                    <a class="nav-link mynav text-black collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#ListAbsen" aria-expanded="false" aria-controls="ListAbsen">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-black"></i></div>
                        Absen
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down text-black"></i></div>
                    </a>
                    <div class="collapse" id="ListAbsen" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link mynav text-black" href="<?php echo base_url('menu/home'); ?>">Tabel Absensi</a>
                            <a class="nav-link mynav text-black" href="<?php echo base_url('menu/home/update'); ?>">Ubah Data Absensi</a>
                            <a class="nav-link mynav text-black" href="<?php echo base_url('menu/libur'); ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar text-black"></i></div>
                                Tambah Hari Libur
                                <div class="sb-sidenav-collapse-arrow"></div>
                            </a>
                        </nav>
                    </div>

                    <!-- Absen -->
                    <a class="nav-link mynav text-black collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#ListPengguna" aria-expanded="false" aria-controls="ListPengguna">
                        <div class="sb-nav-link-icon"><i class="fas fa-user text-black"></i></div>
                        Pengguna
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down text-black"></i></div>
                    </a>
                    <div class="collapse" id="ListPengguna" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link mynav text-black" href="<?php echo base_url('menu/pengguna/add'); ?>">Tambah Pengguna</a>
                            <a class="nav-link mynav text-black" href="<?php echo base_url('menu/pengguna/get'); ?>">Tampil Pengguna</a>
                        </nav>
                    </div>

                    <!-- Absen -->
                    <a class="nav-link mynav text-black collapsed" href="<?php echo base_url('menu/arsip'); ?>">
                        <div class="sb-nav-link-icon"><i class="fas fas fa-book-open text-black"></i></div>
                        File
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer bg-secondary text-white">
                <div class="small">Logged in as:</div>
                Start Bootstrap
            </div>
        </nav>
    </div>