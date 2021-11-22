<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

// web
$cfg_webname = "Dimas SMM Panel Indonesia"; // Judul / nama web
$cfg_baseurl = "http://".$_SERVER['HTTP_HOST']."/"; // Domain index / url utama web
$cfg_desc = "Menyediakan berbagai kebutuhan Social Media"; // Deskripsi website
$cfg_author = "Dimas Arya Pamungkas"; // Nama author
$cfg_logo_txt = "Dimas-SMM"; // Logo teks pada header
$cfg_about = "Dimas SMM Panel adalah sebuah website penyedia layanan sosial media terlengkap, termurah, dan berkualitas.						
                                    <ul>
										<li>Instant & Auto processing.</li>
										<li>Harga Murah.</li>
										<li>Transaksi Bersifat Privasi.</li>										
										<li>Layanan Lengkap.</li>
										<li>24 Hours Support.</li>
										<li>Automatic System.</li>
									</ul>";
$cfg_oid_code = "Dims#"; // Kode sebelum angka order id

// database
$db_server = "localhost";//biasanya pake localhost atau root
$db_user ="root";
$db_password = "";
$db_name = "smmpanel_db";

// date & time
$date = date("Y-m-d");
$time = date("H:i:s");

// require
require("lib/database.php");
require("lib/function.php");