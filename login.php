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
                    Yukkk atur tugasmu!.🤩
                </span>
            </div>
        </nav>
        
        <div class="container px-5 my-5">
            <div class="row mb-3">
                <h4 class="fw-bold">Masuk</h4>
            </div>
            <div class="row mb-5">
                <div class="col-sm">
                    <span class="text-muted">
                        Kamu harus masuk sebelum kamu mengatur tugasmu, jika kamu belum memiliki akun silahkan klik 
                        <a id="a-b" href="register.php">Buat Akun.</a> 
                    </span>
                </div>
            </div>
            <form action="includes/koneksi.php" method="post">
                <div class="row">
                    <div class="mb-4">
                        <label for="user" class="form-label">Username</label>
                        <input type="text" class="form-control" name="user" id="user" required maxlength="50" autofocus>
                    </div>
                    <div>
                        <label for="pass" class="form-label">Password</label>
                        <input type="password" class="form-control" name="pass" id="pass" required>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm">
                        <div class="d-flex justify-content-between">
                            <a href="register.php" class="align-self-center"id="btn-reg">Buat Akun?</a>
                            <button type="submit" name="login" class="btn" id="btn-log">Masuk</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <footer class="footer mt-auto py-3 bg-light fixed-bottom">
            <div class="container text-center">
                <span class="text-muted">Design and Developed by Mahmud</span>
            </div>
        </footer>





        <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
        <?php include "includes/footer.php" ?>