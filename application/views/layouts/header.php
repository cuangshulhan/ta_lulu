<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <!-- BOOTSTRAP 4-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <title>Sistem Inventory Truk</title>
</head>

<body>
    <?php

    $menu = $this->session->userdata('menu');
    $submenu = $this->session->userdata('submenu');

    $beranda = '';

    $master = '';
    $satuan = '';
    $pemasok = '';
    $pengguna = '';
    $kendaraan = '';
    $barang = '';

    $transaksi = '';
    $laporan = '';

    if ($menu == 'beranda')
        $beranda = 'active';
    elseif ($menu == 'master') {
        $master = 'active';
        if ($submenu == 'satuan')
            $satuan = 'active';
        elseif ($submenu == 'pemasok')
            $pemasok = 'active';
        elseif ($submenu == 'pengguna')
            $pengguna = 'active';
        elseif ($submenu == 'kendaraan')
            $kendaraan = 'active';
        elseif ($submenu == 'barang')
            $barang = 'active';
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Sistem Inventory</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= $beranda ?>">
                    <a class="nav-link" href="<?= base_url('mainMenuController') ?>">Beranda <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown <?= $master ?>">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Master
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="<?= base_url('satuanController') ?>" class="dropdown-item <?= $satuan ?>">Satuan</a>
                        <a href="<?= base_url('pemasokController') ?>" class="dropdown-item <?= $pemasok ?>">Pemasok</a>
                        <a href="<?= base_url('penggunaController') ?>" class="dropdown-item <?= $pengguna ?>">Pengguna</a>
                        <a href="<?= base_url('kendaraanController') ?>" class="dropdown-item <?= $kendaraan ?>">Kendaraan</a>
                        <a href="<?= base_url('barangController') ?>" class="dropdown-item <?= $barang ?>">Barang</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Transaksi
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Pemesanan</a>
                        <a class="dropdown-item" href="#">Pembelian</a>
                        <a class="dropdown-item" href="#">Pemakaian</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Laporan
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Stok Barang</a>
                        <a class="dropdown-item" href="#">Pemesanan</a>
                        <a class="dropdown-item" href="#">Pembelian</a>
                        <a class="dropdown-item" href="#">Pemakaian</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a href="<?= base_url('authController/logout') ?>">
                    <button class="btn btn-outline-danger my-2 my-sm-0" type="button">Keluar</button>
                </a>
            </form>
        </div>
    </nav>


    <!-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script> -->
    <!-- DATATABLES BS 4-->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css" /> -->
    <!-- jQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-auto-replace-svg="nest"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>


</body>

</html>