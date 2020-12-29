<?php
session_start();
include 'dbconnect.php';
$idkategori = $_GET['idkategori'];
$kategori=mysqli_fetch_array(mysqli_query($conn,"SELECT * from kategori WHERE idkategori = '$idkategori'"));
?>

<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from designing-world.com/suha-v2.1.0/home by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Dec 2020 09:37:48 GMT -->
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
        <!-- Logo Wrapper-->
        <div class="logo-wrapper"><a href="home"><img src="img/core-img/logo-small.png" alt=""></a></div>
        <!-- Search Form-->
        <div class="top-search-form">
          <form action="all" method="get">
            <?php
            if(isset($s)){
            ?>
              <input class="form-control" type="search" name="search" placeholder="Cari produk" value="<?= $s ?>">
            <?php
            } else {
            ?>
              <input class="form-control" type="search" name="search" placeholder="Cari produk">
            <?php
            };
            ?>
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
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
      
      <!-- Featured Products Wrapper-->
      <div class="featured-products-wrapper py-3">
        <div class="container">
          <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="pl-1"><?= ucwords($kategori['namakategori']) ?></h6>
          </div>
          <div class="row g-3">

            <?php
              $brgs=mysqli_query($conn,"SELECT * from produk WHERE idkategori = '$idkategori' order by idproduk ASC");
              $hitung = mysqli_num_rows($brgs);
              if ($hitung < 1) {
            ?>
              <!-- Kategori kosong -->
              <div class="offline-area-wrapper py-3 d-flex align-items-center justify-content-center" style="margin-top:-40px;">
                <div class="offline-text text-center"><img class="mb-4 px-5" src="img/undraw_File_searching_re_3evy (1).svg" alt="">
                  <h5>Produk tidak ditemukan</h5>
                  <p>Maaf, produk dengan kategori <?= ucwords($kategori['namakategori']) ?> masih kosong</p><a class="btn btn-primary" href="category">Kembali ke kategori!</a>
                </div>
              </div>
            <?php
              }
              $no=1;
              while($p=mysqli_fetch_array($brgs)){
            ?>

            <div class="col-6 col-md-4 col-lg-3">
              <div class="card top-product-card">
                <div class="card-body"><a class="product-thumbnail d-block" href="product?idproduk=<?= $p['idproduk'] ?>"><img class="mb-2" src="<?= $p['gambar']?>" style="height:150px;object-fit:cover;" alt=""></a><a class="product-title d-block" href="single-product.html"><?= $p['namaproduk'] ?></a>
                  <p class="sale-price">
                    Rp<?php echo number_format($p['hargaafter']) ?>
                    <span>Rp<?php echo number_format($p['hargabefore']) ?></span>
                  </p>
                  <div class="product-rating">
                    <?php
                    $rate = $p['rate'];
                    for($n=1;$n<=$rate;$n++){
                      echo '<i class="lni lni-star-filled"></i>';
                    };
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <?php } ?>

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

<!-- Mirrored from designing-world.com/suha-v2.1.0/home by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Dec 2020 09:38:10 GMT -->
</html>