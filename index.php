    <?php
        include "includes/header.php";

        if(isset($_COOKIE["user"])){
            header('Location: manage.php');
        }
    ?>

    <title>Welcome - Tasking</title>
    <link rel="stylesheet" href="assets\css\index.css">
    </head>

    <body class="text-center">

        <div class="container ps-3 pe-3 mt-3 pt-5 mb-5" id="particles-js">
            <div class="row">
                <img id="i-svg" src="assets\img\login.svg" alt="login-images" srcset="">
            </div>
            <div class="row mt-1">
                <h2 id="i-judul" class="text-wrap fw-bold">Atur pengerjaan tugasmu dengan lebih baik!</h2>
            </div>
            <div class="row mb-5">
                <p class="text-muted text-wrap">Atur dan kontrol perkembangan pengerjaaan tugasmu untuk memperoleh hasil
                    maksimal!.</p>
            </div>
            <div class="row justify-content-center">
                <a href="register.php" class="btn me-4" id="btn-reg">Daftar Sekarang!</a>
                <a href="login.php" class="btn" id="btn-log">Masuk</a>
            </div>
        </div>

        <footer class="footer mt-auto py-3 bg-light fixed-bottom">
            <div class="container">
                <span class="text-muted text">Design and Developed by Mahmud</span>
            </div>
        </footer>


        <!-- scripts -->
        <script src="assets\js\particles.js"></script>
        <script src="assets\js\app.js"></script>
        <script>
        /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
        particlesJS.load('particles-js', 'assets/particles.json', function() {
            console.log('callback - particles.js config loaded');
        });
        </script>

        <?php include "includes/footer.php" ?>