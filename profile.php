<?php
        include "includes/header.php";
        include "includes/koneksi.php";
        session_start();
        // include "function-manage.php";

        $cookieUser = $_COOKIE["user"];
        if(!isset($cookieUser)){
            header('Location: login.php');
        }

        $getUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM t_user WHERE c_user = '$cookieUser'"));
    ?>

        <title>Login - Tasking</title>
        <link rel="stylesheet" href="assets\css\profile.css">

    </head>
    <body>

        <div class="pattern w-100"></div>
        <div class="container">
            <div class="row">
                <div class="mx-auto text-center">
                    <?php if($getUser["c_foto"] == "") : ?>
                        <img src="assets/img/profile.jpg" class="rounded-circle border border-3 border-light shadow" style="height: 130px; width: 130px; margin-top: -65px;" alt="">
                    <?php else : ?>
                        <img src="assets/img/<?= $getUser["c_foto"] ?>" class="rounded-circle border border-3 border-light shadow" style="height: 130px; width: 130px; margin-top: -65px;" alt="">
                    <?php endif ?>
                </div>
            </div>
            <div class="row mt-4 text-center">
                <h4 class="mb-0">
                    <?= $getUser["c_nama"] ?>
                </h4>
                <span class="fs-6 text-secondary">
                    <?= $getUser["c_status"]  ?>
                </span>
                <span class="fs-6 text-secondary px-5 text-center mt-3 mb-2">
                <?= $getUser["c_deskripsi"]  ?>
                </span>
            </div>
            <div class="row mb-4 mt-2 border-bottom pb-4">
                <div class="btn-group px-5" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-sm badge-primary" data-bs-toggle="modal" data-bs-target="#modalUbahProfil">
                        Ubah Profil
                    </button>
                    <button type="button" class="btn btn-sm badge-secondary" data-bs-toggle="modal" data-bs-target="#modalUbahSandi">
                        Ubah Sandi
                    </button>
                    <a href="logout.php" class="btn btn-sm badge-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                            <path d="M7.5 1v7h1V1h-1z"/>
                            <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="row text-center px-5 mt-4 text-secondary">
                <div class="col">
                    <span>Tugas</span> <br>
                    <span class="fw-bold text-dark fs-5 mt-2">26</span>
                </div>
                <div class="col">
                    <span>Telat</span> <br>
                    <span class="fw-bold text-dark fs-5 mt-2">3</span>
                </div>
                <div class="col">
                    <span>Selesai</span> <br>
                    <span class="fw-bold text-dark fs-5 mt-2">15</span>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-light bg-light py-3 fixed-bottom shadow-lg">
            <div class="container justify-content-between me-3 ms-3">
                <a href="manage.php" class="btn badge-secondary rounded px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                    </svg>
                </a>
                <a href="#" class="btn badge-secondary rounded px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                </a>
                <a href="profile.php" class="btn badge-success rounded px-4 py-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>
                </a>
            </div>
        </nav>

        <!-- Content Body -->
        <div class="container">
        
        </div>




        <!-- <footer class="footer mt-5 py-3 bg-light">
            <div class="container text-center">
                <span class="text-muted">Design and Developed by Mahmud</span>
            </div>
        </footer> -->

        <!-- Modal Ubah Profil -->
        <div class="modal fade" id="modalUbahProfil" tabindex="-1" aria-labelledby="exampleModalUbahProfil" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalUbahProfil">Ubah Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="includes/koneksi.php" method="post">
                        <div class="container">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $getUser["c_nama"] ?>" required maxlength="50" autofocus>
                                    <input type="text" name="userProfil" id="userProfil" value="<?= $cookieUser ?>" hidden>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status
                                        <span class="text-muted fst-italic">(Opsional)</span>
                                    </label>
                                    <input type="text" name="status" id="status" class="form-control" value="<?= $getUser["c_status"] ?>" maxlength="20">
                                </div>
                                <div class="mb-3">
                                    <label for="telp" class="form-label">No. Handphone
                                        <span class="text-muted fst-italic">(Opsional)</span>
                                    </label>
                                    <input type="tel" class="form-control" name="telp" id="telp" value="<?= $getUser["c_telp"] ?>" maxlength="13">
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Diri
                                        <span class="text-muted fst-italic">(Opsional)</span>
                                    </label>
                                    <textarea type="text" name="deskripsi" id="deskripsi" class="form-control" style="height: 100px;"><?= $getUser["c_deskripsi"] ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="ubahProfil" class="btn badge-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal Ubah Sandi -->
        <div class="modal fade" id="modalUbahSandi" tabindex="-1" aria-labelledby="examplemodalUbahSandi" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="examplemodalUbahSandi">Ubah Sandi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="includes/koneksi.php" method="post">
                        <div class="container">
                            <div class="row">
                                    <input type="text" class="form-control" name="userSandi" id="userSandi" value="<?= $_SESSION["user"] ?>" hidden>
                                <div class="mb-3">
                                    <label for="passOld" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" name="passOld" id="passOld" required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="passNew" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" name="passNew" id="passNew" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn badge-danger" name="ubahSandi">Ubah</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <?php include "includes/footer.php" ?>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <!-- <script>
            function ubahSandi(){
                swal({
                    title: "Apa Kamu Yakin?",
                    text: "Kata Sandimu akan diubah!",
                    icon: "warning",
                    buttons: true,
                })
                .then((willChange) => {
                if (willChange) {
                    swal("Kata Sandi Berhasil Diubah!", {
                    icon: "success",
                    });
                }
                });
            }
        </script> -->