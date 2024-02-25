    <?php
        include "includes/header.php";
        include "includes/koneksi.php";

        if(isset($_COOKIE["user"])){
            header('Location: manage.php');
        }
    ?>

        <title>Login - Tasking</title>
        <link rel="stylesheet" href="assets\css\login.css">

    </head>
    <body>

        <!-- As a link -->
        <nav class="navbar navbar-light bg-nav">
            <div class="container-fluid justify-content-center">
                <span class="navbar-text">
                    Yukkk atur tugasmu! 🤩
                </span>
            </div>
        </nav>
        
        <div class="container px-5 my-5">
            <div class="row mb-3">
                <h4 class="fw-bold">Daftar</h4>
            </div>
            <div class="row mb-4">
                <div class="col-sm">
                    <span class="text-muted">
                        Buat akun agar kamu menjadi lebih baik dalam mengatur tugasmu!
                    </span>
                </div>
            </div>
            <form action="includes/koneksi.php" method="post">
                <div class="row">
                    <div class="col-sm">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required autofocus maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label">No. Handphone <span class="fst-italic"> (opsional)</span></label>
                            <input type="tel" class="form-control" name="telp" id="telp" autocomplete="off" maxlength="13">
                        </div>
                        <div class="mb-3">
                            <label for="user" class="form-label">Username<span class="text-danger">*</span> </label>
                            <input type="text" class="form-control text-lowercase" name="user" id="user" autocomplete="off" required maxlength="30">
                        </div>
                        <div>
                            <label for="pass" class="form-label">Password<span class="text-danger">*</span> </label>
                            <input type="password" class="form-control" name="pass" id="pass" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm">
                        <div class="d-flex justify-content-between">
                            <a href="login.php" class="align-self-center" id="btn-reg">Sudah punya Akun?</a>
                            <button type="submit" name="buatAkun" class="btn" id="btn-log">Buat Akun</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
            
        <footer class="footer mt-auto py-3 bg-light">
            <div class="container text-center">
                <span class="text-muted">Design and Developed by Mahmud</span>
            </div>
        </footer>

    <?php include "includes/footer.php" ?>