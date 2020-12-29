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
} else if(isset($_GET["hapus"])){
	$kode = $_GET['idproduknya'];
	$q2 = mysqli_query($conn, "delete from detailorder where idproduk='$kode' and orderid='$orderidd'");
	if($q2){
    echo json_encode(array('status' => 'success'));
		// echo "Berhasil Hapus";
	} else {
		// echo "Gagal Hapus";
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
          
        
          
          <?php
            if ($itungtrans3 > 0) {
          ?>

          <!-- Coupon Area-->
          <div class="card coupon-card mb-3">
            <div class="card-body">
              <div class="apply-coupon">
                <h6 class="mb-0">Dalam keranjangmu ada : <span><?php echo $itungtrans3 ?> barang</span></h6>
              </div>
            </div>
          </div>

          <script>
          $(document).ready(function(c) {

            $('.hapus').on('click', function(c){
              // alert('hai')
              let id_produk = $(this).attr('id')
              $.ajax({
                url: `action/hapus?idproduknya=${id_produk}&hapus=1&orderidd=<?= $orderidd ?>`,
                type: "GET",
                crossDomain: true,
                dataType: "JSON",
                success: function(data) {
                  if (data.status == 'success') {
                    window.location.reload();
                  }
                },
                error: function(e) {
                  // alert('gagal');
                  console.log(e);
                }
              });
            });
            	  
          });
          </script>
          
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
                    <th scope="row">
                      <!-- <input type="submit" name="hapus" class="form-control" value="Hapus" \> -->
                      <a class="remove-product hapus" href="#" id="<?php echo $b['idproduk'] ?>"><i class="lni lni-close"></i></a>
                    </th>
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
          

          <div class="card coupon-card mb-3">
            <div class="card-body">
              <div class="apply-coupon">
                <ul style="margin-left:0px;padding-left:0px;">
                  <?php 
                    $brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
                    $no=1;
                    $subtotal = 10000;
                    while($b=mysqli_fetch_array($brg)){
                    $hrg = $b['hargaafter'];
                    $qtyy = $b['qty'];
                    $totalharga = $hrg * $qtyy;
                    $subtotal += $totalharga
                  ?>
                  <li><?php echo $b['namaproduk']?><i> - </i> <span>Rp<?php echo number_format($totalharga) ?> </span></li>
                  <?php
                  }
                  ?>
                  <li>Inc. 10k Ongkir</li>
                </ul>
              </div>
            </div>
          </div>
          
          <!-- Cart Amount Area-->
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
              
              <h5 class="total-price mb-0">Rp<span class="counter"><?php echo number_format($subtotal) ?></span></h5><a class="btn btn-warning" href="checkout">Checkout</a>
            </div>
          </div>

          <?php } else { ?>
            <!-- Keranjang kosong -->
            <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center">
              <div class="offline-text text-center"><img class="mb-4 px-5" src="img/undraw_empty_xct9.svg" alt="">
                <h5>Keranjang belanjamu kosong</h5>
                <p>Segera isi keranjangmu dan dapatkan penawaran <br>menarik khusus hari ini.</p><a class="btn btn-primary" href="all">Belanja Sekarang!</a>
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