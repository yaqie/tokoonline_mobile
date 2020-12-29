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
$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
$itungtrans2 = mysqli_fetch_assoc($itungtrans);
$itungtrans3 = $itungtrans2['jumlahtrans'];

if(isset($_POST["checkout"])){
  $q3 = mysqli_query($conn, "update cart set status='Payment' where orderid='$orderidd'");
  if($q3){
    header('location:order');
  } else {
    ?>
    <script>alert('Terjadi kesalahan')</script>
    <?php
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
          <h6 class="mb-0">Keranjang Saya</h6>
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
                <h6 class="mb-0">Terima kasih, <?=$_SESSION['name']?> telah membeli <?php echo $itungtrans3 ?> barang di toko online</span></h6>
              </div>
            </div>
          </div>

          <?php
            if ($itungtrans3 > 0) {
          ?>

          <div class="card coupon-card discount-coupon-card mb-3">
            <div class="card-body">
              <div class="apply-coupon">
                <h6 class="mb-0 text-white">Kode Order Anda:</h6>
                <h6 class="mb-0 text-white"><?php echo $orderidd ?></h6>
              </div>
            </div>
          </div>

          <!-- Cart Amount Area-->
          <div class="card cart-amount-area mb-3">
            <div class="card-body d-flex align-items-center justify-content-between">
              <?php 
              $brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
              $no=1;
              $subtotal = 10000;
              while($b=mysqli_fetch_array($brg)){
              $hrg = $b['hargaafter'];
              $qtyy = $b['qty'];
              $totalharga = $hrg * $qtyy;
              $subtotal += $totalharga;
              }
              ?>
              <h5 class="total-price mb-0">Rp<span class="counter"><?php echo number_format($subtotal) ?></span></h5>
              <form method="post">
                <input type="submit" class="btn btn-warning" name="checkout" value="Checkout" \>
              </form>
              <!-- <a class="" href="checkout.html">Checkout</a> -->
            </div>
          </div>
          
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
                <?php 
                  $brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
                  $no=1;
                  while($b=mysqli_fetch_array($brg)){
                ?>
                  <tr>
                    <td><img src="<?php echo $b['gambar'] ?>" alt=""></td>
                    <td><a href="product?idproduk=<?php echo $b['idproduk'] ?>"><?php echo $b['namaproduk'] ?><span>Rp<?php echo number_format($b['hargaafter']) ?> × <?php echo $b['qty'] ?></span></a></td>
                    <td>
                      <div class="quantity">
                        <input class="qty-text" type="text" value="<?php echo $b['qty'] ?>">
                      </div>
                    </td>
                  </tr>
                <?php
                  }
                ?>
                </tbody>
              </table>
            </div>
          </div>
          

          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <td>Total harga yang tertera di atas sudah termasuk ongkos kirim sebesar Rp10.000</td>
                  </tr>
                  <tr>
                    <td>Bila telah melakukan pembayaran, harap konfirmasikan pembayaran Anda.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
                <?php 
                  $metode = mysqli_query($conn,"select * from pembayaran");
                  while($p=mysqli_fetch_array($metode)){
                ?>
                  <tr>
                    <td><img src="<?php echo $p['logo'] ?>" alt=""></td>
                    <td><?php echo $p['metode'] ?> - <?php echo $p['norek'] ?><br>a/n. <?php echo $p['an'] ?></td>
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