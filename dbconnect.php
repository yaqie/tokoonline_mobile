<?php 
ob_start();
// isi nama host, username mysql, dan password mysql anda
$conn = mysqli_connect("localhost","root","","tokopekita");

if(!$conn){
	echo "gagal konek database menn";
} else {
	
};

?>