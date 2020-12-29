<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login');
} else {
	
};
	
$uid = $_SESSION['id'];
$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
$fetc = mysqli_fetch_array($caricart);
$orderidd = $fetc['orderid'];
$itungtrans = mysqli_query($conn,"select count(orderid) as jumlahtrans from cart where userid='$uid' and status!='Cart'");
$itungtrans2 = mysqli_fetch_assoc($itungtrans);
$itungtrans3 = $itungtrans2['jumlahtrans'];

if(isset($_POST["update"])){
  $kode = $_POST['idproduknya'];
  $jumlah = $_POST['jumlah'];
  $q1 = mysqli_query($conn, "update detailorder set qty='$jumlah' where idproduk='$kode' and orderid='$orderidd'");
  if($q1){
    echo "Berhasil Update Cart
    <meta http-equiv='refresh' content='1; url= cart.php'/>";
  } else {
    echo "Gagal update cart
    <meta http-equiv='refresh' content='1; url= cart.php'/>";
  }
} else if(isset($_POST["hapus"])){
  $kode = $_POST['idproduknya'];
  $q2 = mysqli_query($conn, "delete from detailorder where idproduk='$kode' and orderid='$orderidd'");
  if($q2){
    echo "Berhasil Hapus";
  } else {
    echo "Gagal Hapus";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from designing-world.com/suha-v2.1.0/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Dec 2020 09:38:24 GMT -->
  <head>
    <?php include 'components/head.php'; ?>
  </head>
  <body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="javascript:history.go(-1)"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Daftar Belanja</h6>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex flex-wrap">
          <?php
          if(isset($_SESSION['log'])){
            echo '<a href="logout"><i class="lni lni-power-switch"></i></a>';
          } else {
            echo '<a href="login"><i class="lni lni-user"></i></a>';
          };
          ?>
        </div>
      </div>
    </div>
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    
    <?php include 'components/sidebar.php'; ?>
    
    <div class="page-content-wrapper">
      <div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
          
        
          <!-- Coupon Area-->
          <div class="card coupon-card mb-3">
            <div class="card-body">
              <div class="apply-coupon">
                <h6 class="mb-0">Kamu memiliki <span><?php echo $itungtrans3 ?> transaksi</span></h6>
              </div>
            </div>
          </div>

          <?php
            if ($itungtrans3 > 0) {
          ?>
          
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
                <?php 
                  $brg=mysqli_query($conn,"SELECT DISTINCT(idcart), c.orderid, tglorder, status from cart c, detailorder d where c.userid='$uid' and d.orderid=c.orderid and status!='Cart' order by tglorder DESC");
                  $no=1;
                  while($b=mysqli_fetch_array($brg)){
                ?>
                  <tr>
                    <!-- <td><img src="<?php echo $p['logo'] ?>" alt=""></td> -->
                    <td>
                      <b><?php echo $b['orderid'] ?></b><br><?php echo $b['tglorder'] ?><br>
                      Rp
                      <?php
                        $ongkir = 10000;
												$ordid = $b['orderid'];
												$result1 = mysqli_query($conn,"SELECT SUM(qty*hargaafter)+$ongkir AS count FROM detailorder d, produk p where d.orderid='$ordid' and p.idproduk=d.idproduk order by d.idproduk ASC");
												$cekrow = mysqli_num_rows($result1);
												$row1 = mysqli_fetch_assoc($result1);
												$count = $row1['count'];
												if($cekrow > 0){
                        echo number_format($count);
                        } else {
                          echo 'No data';
                        }
                      ?>
                    <td>
                    <?php
                    if($b['status']=='Payment'){
                    echo '
                    <a class="btn btn-primary text-white" href="konfirmasi.php?id='.$b['orderid'].'">Konfirmasi Pembayaran</a>
                    ';}
                    else if($b['status']=='Diproses'){
                    echo 'Pesanan Diproses (Pembayaran Diterima)';
                    }
                    else if($b['status']=='Dikirim'){
                      echo 'Pesanan Dikirim';
                    } else if($b['status']=='Selesai'){
                      echo 'Pesanan Selesai';
                    } else if($b['status']=='Dibatalkan'){
                      echo 'Pesanan Dibatalkan';
                    } else {
                      echo 'Konfirmasi diterima';
                    }
                    
                    ?>
                      
                    </td>
                    </td>
                  </tr>
                <?php
                  }
                ?>
                  
                  
                </tbody>
              </table>
            </div>
          </div>
          
          <?php } ?>


        </div>
      </div>
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    
    <?php include 'components/footer_nav.php'; ?>
    
    <!-- All JavaScript Files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/default/jquery.passwordstrength.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jarallax.min.js"></script>
    <script src="js/jarallax-video.min.js"></script>
    <script src="js/default/dark-mode-switch.js"></script>
    <script src="js/default/no-internet.js"></script>
    <script src="js/default/active.js"></script>
    <script src="js/pwa.js"></script>
  </body>

<!-- Mirrored from designing-world.com/suha-v2.1.0/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Dec 2020 09:38:24 GMT -->
</html>