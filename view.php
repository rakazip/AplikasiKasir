<?php

require 'ceklogin.php';


if(isset($_GET['idp'])){
    $idp = $_GET['idp'];

    $ambilnamapelanggan = mysqli_query($c,"select*from pesanan p, pelanggan pl where p.idpelanggan=pl.idpelanggan and p.idorder='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['namapelanggan'];
}else {
    header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Pesanan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">Aplikasi Kasir</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stock.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Input Barang Masuk
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="laporan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Laporan Transaksi
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pesanan: <?=$idp;?></h1>
                        <h4 class="mt-4">Nama Pelanggan: <?=$namapel;?></h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat Datang</li>
                        </ol>

                             <!-- Button to Open the Modal -->
                         <button type="button" class="btn btn-info mb-4" data-toggle="modal" data-target="#myModal">
                         Tambah Barang
                         </button>
                            
                 
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>sub-total</th>
                                            <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php  
                                    $get = mysqli_query($c,"select * from detailpesanan p, produk pr where p.idproduk=pr.idproduk and idpesanan='$idp'");
                                    $i = 1;
                                    $totalharga = 0; //Inisialisasi variabel total 
                                    $kembalian = 0; //Inisialisasi variabel kembalian

                                    while($p=mysqli_fetch_array($get)){
                                    $idpr = $p['idproduk'];
                                    $iddp = $p['iddetailpesanan'];
                                    $qty = $p['qty'];
                                    $harga = $p['harga'];
                                    $namaproduk = $p['namaproduk'];
                                    $deskripsi = $p['deskripsi'];
                                    

                                    $subtotal = $qty*$harga;

                                    //perbarui total harga
                                    $totalharga += $subtotal;
                                  
                                    ?>


                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?> (<?=$deskripsi;?>)</td>
                                            <td>Rp<?=number_format($harga);?></td>
                                            <td><?=number_format($qty);?></td>
                                            <td>Rp<?=number_format($subtotal);?></td>
                                            <td> 
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idpr;?>">
                                                Edit
                                            </button> 
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idpr;?>">
                                                Hapus
                                            </button>
                                            
                                        </td>
                                        </tr>
                                          <!-- Modal Edit -->
                                          <div class="modal fade" id="edit<?=$idpr;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Ubah Data Detail Pesanan</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                    <input type="text" name="namaproduk" class="form-control" placeholder="Nama produk" value="<?=$namaproduk;?>: <?=$deskripsi;?>" disabled>
                                                    <input type="number" name="qty" class="form-control mt-2" placeholder="Harga Produk" value="<?=$qty;?>">
                                                    <input type="hidden" name="iddp" value="<?=$iddp;?>">
                                                    <input type="hidden" name="idp" value="<?=$idp;?>">
                                                    <input type="hidden" name="idpr" value="<?=$idpr;?>">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="editdetailpesanan">Submit</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>

                                                    </form>
                                                    
                                                </div>
                                                </div>
                                            </div>
                                        <!-- The Modal -->
                                        <div class="modal fade" id="delete<?=$idpr;?>">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                            
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Apakah Anda yakin ingin menghapus barang ini?</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post">

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus barang ini?
                                                <input type="hidden" name="idp" value="<?=$iddp;?>">
                                                <input type="hidden" name="idpr" value="<?=$idpr;?>">
                                                <input type="hidden" name="idorder" value="<?=$idp;?>">
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Ya</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                
                                                </div>

                                                </form>
                                                
                                            </div>
                                            </div>
                                        </div>
                                        <!-- Modal Bayar -->
                                    <div class="modal fade" id="bayar<?= $idpr; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Transaksi Pembayaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <form method="post" action="">

                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <!-- Form pembayaran -->
                                                    <form method="post">
                                                        <div class="form-group">
                                                            <label for="jumlah_bayar">Jumlah Bayar:</label>
                                                            <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar" placeholder="Masukkan jumlah bayar">
                                                        </div>
                                                        <input type="hidden" name="idpr" value="<?= $idpr; ?>">
                                                        <input type="hidden" name="idp" value="<?= $idp; ?>">
                                                        <!-- Tombol submit -->
                                                        <button type="submit" class="btn btn-success" name="bayar">Bayar</button>
                                                    </form>
                                                    <!-- Menampilkan kembalian -->
                                                    <?php
                                                    if (isset($_POST['bayar'])) {
                                                        $jumlahBayar = $_POST['jumlah_bayar'];
                                                        $kembalian = $jumlahBayar - $totalharga;
                                                        ?>
                                                       
                                                        </div>
                                                    <?php } ?>
                                                    
                                                </div>
                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php 
                                    }; //end of while
                                    ?>
                                    <form method="post" action="laporan.php">
                                    <!-- Menampilkan total harga -->
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Total:</td>
                                        <td>Rp<?= number_format($totalharga); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bayar<?= $idpr; ?>">
                                            Bayar
                                            </button>
                                        </td>
                                        
                                            </button>
                                    </tr>
                                    <!-- Menampilkan kembalian -->
                                    <tr>
                                        <td colspan="3"></td>
                                        <td>Kembalian:</td>
                                        <td>Rp<?=number_format($kembalian);?></td>
                                        <td><input type="submit" name="laporantransaksi" value="Lapor"></td>
                                    </tr>
                                    </form>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>


        <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Barang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post">

            <!-- Modal body -->
            <div class="modal-body">
            Pilih Barang
            <select name="idproduk" class="form-control">
                                
            <?php
            $getproduk = mysqli_query($c,"select*from produk where idproduk not in (select idproduk from detailpesanan where idpesanan='$idp')");

            while($pl=mysqli_fetch_array($getproduk)){
                $namaproduk = $pl['namaproduk'];
                $stock = $pl['stock'];
                $deskripsi = $pl['deskripsi'];
                $idproduk = $pl['idproduk'];


            ?>

            <option value="<?=$idproduk;?>"><?=$namaproduk;?> - <?=$deskripsi;?> (Stock: <?=$stock;?>)</option>

            <?php
            }
            ?>
            
            </select>  
            
            <input type="number" name="qty" class="form-control mt-4" placeholder="jumlah" min="1" required>
            <input type="hidden" name="idp" value="<?=$idp;?>">
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="addproduk">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

            </form>
            
        </div>
        </div>
    </div>

    </html>
