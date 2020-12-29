<?php

session_start();
include '../dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login');
};

if(isset($_GET["hapus"])){
	$orderidd = $_GET['orderidd'];
	$kode = $_GET['idproduknya'];
	$q2 = mysqli_query($conn, "delete from detailorder where idproduk='$kode' and orderid='$orderidd'");
	if($q2){
        echo json_encode(array('status' => 'success'));
	} else {
        echo json_encode(array('status' => 'error'));
	}
}

?>