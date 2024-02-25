<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_task');


function callAll($table){
    global $conn;
    return $callQuery = mysqli_query($conn, "SELECT * FROM $table");
}

function call($table, $where){
    global $conn;
    return $callQuery = mysqli_query($conn, "SELECT * FROM $table WHERE $where");
}

function callUnq($table, $what, $where){
    global $conn;
    return $callQuery = mysqli_query($conn, "SELECT $what FROM $table WHERE $where");
}

if(isset($_POST['buatAkun'])){
    $nama = htmlspecialchars($_POST['nama']);
    $telp = $_POST['telp'];
    $user = htmlspecialchars($_POST['user']);
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $cekUser = mysqli_query($conn, "SELECT c_user FROM t_user WHERE c_user = '$user'");

    if(mysqli_num_rows($cekUser) > 0){
        echo "<script>
                alert('Username sudah digunakan!, Gunakan Username Lain!');
                window.location.href = '../register.php';
                </script>";
    } else {
        mysqli_query($conn, "INSERT INTO t_user (c_nama, c_telp, c_status, c_deskripsi, c_user, c_pass) VALUES ('$nama', '$telp', 'Mahasiswa', 'Saya adalah seorang mahasiswa yang berkuliah disalah satu pendidikan tinggi di indonesia.', '$user', '$pass')");
    
        if(mysqli_affected_rows($conn) > 0){
            echo "<script>
                alert('Akun berhasil buat!');
                window.location.href = '../login.php';
                </script>";
        } else {
            echo "<script>
                alert('Akun Gagal buat!');
                window.location.href = '../register.php';
                </script>";
        }
    }   
}

if(isset($_POST["login"])){
    $user = htmlspecialchars($_POST['user']);
    $pass = $_POST['pass'];
    
    $cekLog = mysqli_query($conn, "SELECT c_user, c_pass FROM t_user WHERE c_user = '$user'");

    if(mysqli_num_rows($cekLog) == 1){
        $cekPass = mysqli_fetch_assoc($cekLog);
        if(password_verify($pass, $cekPass['c_pass'])){
            setcookie('user', $user, time() + (60 * 60 * 24 * 5), '/');
            echo "<script>
                window.location.href = '../manage.php';
                </script>";
        } else {
            echo "<script>
                alert('Username / Password Salah!');
                window.location.href = '../login.php';
                </script>";
        }
    } else {
        echo "<script>
                alert('Username / Password Salah!');
                window.location.href = '../login.php';
                </script>";
    }
}


//buat tugasku
if(isset($_POST['buatTugas'])){
    $namaTugas = htmlspecialchars($_POST['namaTugas']);
    $timeS = $_POST['timeS'];
    $timeE = $_POST['timeE'];
    $deadline = $_POST['deadline'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $author = $_POST['author'];
    // $referensi = $_POST['referensi'];

    if($timeS > $timeE){
        echo "<script>
            alert('Tanggal yang kamu terapkan tidak sesuai!');
            window.location.href = '../manage.php';
            </script>";
    } else {
        mysqli_query($conn, "INSERT INTO t_task (c_namatugas, c_mulaitugas, c_selesaitugas, c_deadline, c_deskripsi, c_type, c_author, c_stat) VALUES ('$namaTugas', '$timeS', '$timeE', '$deadline', '$deskripsi', 'self', '$author', 0) ");
    
        if(mysqli_affected_rows($conn) > 0){
            echo "<script>
                    alert('Pembuatan Tugas Berhasil!');
                    window.location.href = '../manage.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Pembuatan Tugas Gagal!');
                    window.location.href = '../manage.php';
                    </script>";
        }
    }

}

// hapus tugasku

// $statHapus = $_GET["hapus"] = 0;
// $statTaskHapus = $_GET["id"] = 0;
// $statUserHapus = $_GET["user"] = 0;

if(isset($_GET['th'])){
    if(isset($_GET['it']) AND isset($_GET['hu'])){
        $idTaskHapus = $_GET['it'];
        $idUserHapus = $_GET['hu'];
        mysqli_query($conn, "DELETE FROM t_task WHERE id = $idTaskHapus AND c_author = '$idUserHapus' ");

        if(mysqli_affected_rows($conn)){
            echo "<script>
                window.location.href = '../manage.php';
                </script>";
        }
    }
}



//Ubah tugas All
if(isset($_POST['ubahTugas'])){
    $namaTugas = htmlspecialchars($_POST['namaTugas']);
    $timeS = $_POST['timeS'];
    $timeE = $_POST['timeE'];
    $deadline = $_POST['deadline'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $idUbahTugas = $_POST['idUbahTugas'];
    // $referensi = $_POST['referensi'];

    if($timeS > $timeE){
        echo "<script>
            alert('Tanggal yang kamu terapkan tidak sesuai!');
            window.location.href = '../manage.php';
            </script>";
    } else {
        mysqli_query($conn, "UPDATE t_task SET c_namatugas = '$namaTugas', c_mulaitugas = '$timeS', c_selesaitugas = '$timeE', c_deadline = '$deadline', c_deskripsi = '$deskripsi' WHERE id = $idUbahTugas");
    
        if(mysqli_affected_rows($conn) > 0){
            echo "<script>
                    alert('Tugasmu Berhasil Diubah!');
                    window.location.href = '../manage.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Tugasmu Gagal Diubah!');
                    window.location.href = '../manage.php';
                    </script>";
        }
    }
}

if(isset($_POST["buatGrup"])){
    $kode = $_COOKIE["kode"];
    $authorGrup = $_POST['authorGrup'];
    $namaGrup = $_POST['namaGrup'];
    $deskripsiGrup = $_POST['deskripsiGrup'];

    // Cek Kode Tersedia (Perbaiki!!)
    $cekKodeTersedia = mysqli_query($conn, "SELECT * FROM t_grup WHERE kode = '$kode'");
    if(mysqli_num_rows($cekKodeTersedia) > 0){
        echo "<script>
            alert('kode Grup sudah ada, silahkan generate kode ulang!');
            window.location.href = '../manage.php';
            </script>";
    } else {
        mysqli_query($conn, "INSERT INTO t_grup VALUES ('$kode', '$namaGrup', '$deskripsiGrup', '$authorGrup', '$authorGrup')");

        if(mysqli_affected_rows($conn)){
            echo "<script>
                alert('Grup Berhasil Dibuat!');
                window.location.href = '../manage.php';
                </script>";
        } else {
            echo "<script>
                alert('Grup Gagal Dibuat!');
                window.location.href = '../manage.php';
                </script>";
        }
    } 
}


if(isset($_POST["joinGrup"])){
    $kodeGrup = $_POST['kodeGrup'];
    $userGrup = $_POST['userGrup'];
    
    // kamu sudah di grup ini
    // grup tidak ada!
    
    $cekGrup = mysqli_query($conn, "SELECT kode, c_member FROM t_grup WHERE kode = '$kodeGrup'");
    // Cek Kesediaan Kode Grup
    if(mysqli_num_rows($cekGrup) > 0){
        // cek apakah user ini sudah ada di grup yang dimaksud
        foreach($cekGrup as $grup){
            $pecahMemberGrup = explode(",", $grup["c_member"]);
            foreach($pecahMemberGrup as $pecahMember){
                if($pecahMember == $userGrup){
                    echo "<script>
                        alert('Anda sudah ada di dalam grup ini!');
                        window.location.href = '../manage.php';
                        </script>";
                }
            }
            $gabungMember = $grup["c_member"] . "," . $userGrup;
            $updateMember = mysqli_query($conn, "UPDATE t_grup SET c_member = '$gabungMember' WHERE kode = '$kodeGrup' ");
            if(mysqli_affected_rows($conn) > 0){
                echo "<script>
                alert('Kamu berhasil masuk ke grup ini!');
                window.location.href = '../manage.php';
                </script>";
            } else {
                echo "<script>
                alert('Kamu gagal masuk ke grup ini!');
                window.location.href = '../manage.php';
                </script>";
            }
        }
    } else {
        echo "<script>
            alert('Tidak ada grup yang memiliki kode tersebut!');
            window.location.href = '../manage.php';
            </script>";
    }
}

if(isset($_POST["ubahProfil"])){
    $nama = htmlspecialchars($_POST['nama']);
    $status = $_POST['status'];
    $telp = $_POST['telp'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $userProfil = $_POST['userProfil'];

    // $foto = $_FILES['foto']['tmp_name'];
    // $namaFoto = $_FILES['foto']['name'];
    // $target_foto = 'assets/img/' . $namaFoto;
    // move_uploaded_file($foto, $target_foto);
    
    // ERROR
    mysqli_query($conn, "UPDATE t_user SET c_nama = '$nama', c_status = '$status', c_telp = '$telp', c_deskripsi = '$deskripsi' WHERE c_user = '$userProfil' ");

    if(mysqli_affected_rows($conn) > 0){
        echo "<script>
            alert('Profil berhasil diubah!');
            window.location.href = '../profile.php';
            </script>";
    } else {
        echo "<script>
            alert('Profil gagal diubah!');
            window.location.href = '../profile.php';
            </script>";
    }
}

if(isset($_POST["ubahSandi"])){
    $userSandi = $_POST['userSandi'];
    $passOld = $_POST['passOld'];
    $passNew = $_POST['passNew'];

    $cekSandi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM t_user WHERE c_user = '$userSandi'"));
    
    if(password_verify($passOld, $cekSandi["c_pass"])){
        if($passOld == $passNew){
            echo "<script>
            alert('Password baru tidak boleh sama seperti password yang lama');
            window.location.href = '../profile.php';
            </script>";
        } else {
            $newPass = password_hash($passNew, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE t_user SET c_pass = '$newPass' WHERE c_user = '$userSandi'");

            if(mysqli_affected_rows($conn)){
                echo "<script>
                    alert('Password berhasil diubah!');
                    window.location.href = '../profile.php';
                    </script>";
            } else {
                echo "<script>
                    alert('Password berhasil diubah!');
                    window.location.href = '../profile.php';
                    </script>";
            }
        }
    } else {
        echo "<script>
        alert('Password lama kamu tidak sesuai!');
        window.location.href = '../profile.php';
        </script>";
    }
}

if(isset($_GET["setDone"])){
    $id = $_GET['id'];
    $author = $_GET['author'];

    mysqli_query($conn, "UPDATE t_task SET c_stat = 1 WHERE id = $id AND c_author = '$author'");
    header("Location: ../manage.php");
}

if(isset($_GET["setUnDone"])){
    $id = $_GET['id'];
    $author = $_GET['author'];

    mysqli_query($conn, "UPDATE t_task SET c_stat = 0 WHERE id = $id AND c_author = '$author'");
    header("Location: ../manage.php");
}

if(isset($_GET['delGrup'])){
    $kode = $_GET['kode'];
    $author = $_COOKIE['user'];

    $getDataGrup = call("t_grup", "kode = '$kode'");
    $getData = mysqli_fetch_assoc($getDataGrup);

    if($getData["c_authorgrup"] == $author){
        mysqli_query($conn, "DELETE FROM t_grup WHERE kode = '$kode' AND c_authorgrup = '$author'");
        mysqli_query($conn, "DELETE FROM t_task WHERE c_type = 'grup' AND c_grup = '$kode' ");
    } else {
        $upAuthor = "/," . $author . "/";
        $memberUpdate = preg_replace("$upAuthor", "", $getData["c_member"]);
        mysqli_query($conn, "UPDATE t_grup SET c_member = '$memberUpdate' WHERE kode = '$kode'");
    }
    
    header("Location: ../manage.php");
}