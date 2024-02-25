<?php
include "includes/koneksi.php";
// session_start();

// echo $_SESSION["user"];

// echo "<br>";
// echo "<br>";

// // timestamp
// date_default_timezone_set("Asia/Bangkok");

// $call = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM t_task WHERE id = 10"));

// echo floor((strtotime($call["c_selesaitugas"])  - strtotime($call["c_mulaitugas"])) / ((60 * 60) *24));

// echo "<br>";
// echo date("H:i", strtotime($call["c_deadline"]));

// echo "<br>";
// echo "<br>";

// $callKu = mysqli_query($conn, "SELECT * FROM t_task");
// $i = 0;
// foreach($callKu as $ku){
//     if(floor((strtotime($ku["c_selesaitugas"])  - strtotime($ku["c_mulaitugas"])) / ((60 * 60) *24)) <= 2 ){
//         $i++;
//     }
// }

// echo $i;

// echo "<br>";
// echo "<br>";

// echo date("Y-m-d");
// echo "<br>";
// echo date("Y-m-d", strtotime($call["c_selesaitugas"]));
// echo "<br>";
// echo floor((strtotime($call["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) *24));
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// $kode = "fdfsdf";
// $cekKodeTersedia = mysqli_query($conn, "SELECT * FROM t_grup WHERE kode = '$kode'");
// echo mysqli_num_rows($cekKodeTersedia);

// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";

// echo $userku = "ganteng" . ",";
// echo "<br>";
// echo "<br>";
// echo "<br>";

// $cekKodeku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT c_member FROM t_grup WHERE kode = 'SXZ2PW'"));
// $gabung = $cekKodeku["c_member"] . $userku;
// echo $gabung;

// echo "<br>";
// echo "<br>";

// $pecah = explode( ",", $gabung);

// foreach($pecah as $pec){
//     var_dump($pec);
// }



// $cekSandi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM t_user WHERE c_user = 'selly' "));
    
// echo $cekSandi["c_pass"];


echo "========";
$getDataGrup = call("t_grup", "kode = 'OSOUAA'");
// $getDataGrup = mysqli_query($conn, "SELECT * FROM t_grup WHERE kode = 'OSOUAA'");
echo "<br>";

$getData = mysqli_fetch_assoc($getDataGrup);
$admin = "admin";
$tes = "/," . $admin . "/";
echo $getData["c_member"];
echo "<br>";
echo $memberUpdate = preg_replace("$tes", "", $getData["c_member"]);
