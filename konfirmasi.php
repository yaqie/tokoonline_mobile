<?php
session_start();
if(!isset($_SESSION['log'])){
	header('location:login');
} else {
	
};

$idorder = $_GET['id'];

include 'dbconnect.php';
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
        <div class="back-button"><a href="order"><i class="lni lni-arrow-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0">Konfirmasi Pembayaran</h6>
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
          

          <?php
          if(isset($_POST['confirm']))
          {
            
            $userid = $_SESSION['id'];
            $veriforderid = mysqli_query($conn,"select * from cart where orderid='$idorder'");
            $fetch = mysqli_fetch_array($veriforderid);
            $liat = mysqli_num_rows($veriforderid);
            
            if($fetch>0){
            $nama = $_POST['nama'];
            $metode = $_POST['metode'];
            $tanggal = $_POST['tanggal'];
                
            $kon = mysqli_query($conn,"insert into konfirmasi (orderid, userid, payment, namarekening, tglbayar) 
            values('$idorder','$userid','$metode','$nama','$tanggal')");
            if ($kon){
            
            $up = mysqli_query($conn,"update cart set status='Confirmed' where orderid='$idorder'");
            
            echo " <div class='alert alert-success'>
              Terima kasih telah melakukan konfirmasi, team kami akan melakukan verifikasi.
              Informasi selanjutnya akan dikirim via Email
              </div>
            <meta http-equiv='refresh' content='7; url= order'/>  ";
            } else { echo "<div class='alert alert-warning'>
              Gagal Submit, silakan ulangi lagi.
              </div>
              <meta http-equiv='refresh' content='3; url= konfirmasi.php'/> ";
            }
            } else {
              echo "<div class='alert alert-danger'>
              Kode Order tidak ditemukan, harap masukkan kembali dengan benar
              </div>
              <meta http-equiv='refresh' content='4; url= konfirmasi.php'/> ";
            }
            
            
          };
          ?>
        
          
          <!-- Coupon Area-->
          <div class="card coupon-card mb-3">
            <div class="card-body">
              <div class="apply-coupon">
                <h4 class="mb-3">Konfirmasi <?php echo $idorder ?></h4>
                <div class="coupon-form">
                  <form method="post">
                    <div class="form-group mb-3">
                      <label class="mb-2"><small>Kode Order</small></label>
                      <input class="form-control" type="text" name="orderid" value="<?php echo $idorder ?>" disabled>
                    </div>
                    <div class="form-group mb-3">
                      <label class="mb-2"><small>informasi Pembayaran</small></label>
                      <input class="form-control" type="text" name="nama" placeholder="Nama pemilik rekening/ sumber dana" required>
                    </div>
                    <div class="form-group mb-3">
                      <label class="mb-2"><small>Rekening Tujuan</small></label>
                      <select name="metode" class="form-control" required>
                        <?php
                        $metode = mysqli_query($conn,"select * from pembayaran");
                        while($a=mysqli_fetch_array($metode)){
                        ?>
                          <option value="<?php echo $a['metode'] ?>"><?php echo $a['metode'] ?> | <?php echo $a['norek'] ?></option>
                        <?php
                        };
                        ?>
                      </select>
                    </div>
                    <div class="form-group mb-4">
                      <label class="mb-2"><small>Tanggal Bayar</small></label>
                      <input class="form-control" type="date" name="tanggal" required>
                    </div>
                    <div class="form-group mb-3">
                      <input class="btn btn-primary" type="submit" name="confirm" value="Kirim">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


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