    <?php
        include "includes/header.php";
        include "includes/koneksi.php";
        include "function-manage.php";

        $cookieUser = $_COOKIE["user"];
        if(!isset($cookieUser)){
            header('Location: login.php');
        }

        // timestamp
        date_default_timezone_set("Asia/Bangkok");
        $getUser = mysqli_fetch_assoc(call("t_user","c_user = '$cookieUser'"));
        $getTugasku = call("t_task", "c_type = 'self' AND c_author = '$cookieUser' AND c_stat = 0");
        $getTugasSelesai = call("t_task", "c_type = 'self' AND c_author = '$cookieUser' AND c_stat = 1");
        $getGrup = callAll("t_grup");

        $idead = 0;
        $iTugas = 0;
        $iTugasMin = 0;
        foreach($getTugasku as $cekDead){
            if(floor((strtotime($cekDead["c_selesaitugas"]) - strtotime(date("Y-m-d"))) / ((60 * 60) * 24)) <= 2 && floor((strtotime($cekDead["c_selesaitugas"]) - strtotime(date("Y-m-d"))) / ((60 * 60) * 24)) >= 0){
                $idead++;
            } elseif(floor((strtotime($cekDead["c_selesaitugas"]) - strtotime(date("Y-m-d"))) / ((60 * 60) * 24)) >= 3) {
                $iTugas++;
            } else {
                $iTugasMin++;
            }
        }

        
    ?>

        <title>Login - Tasking</title>
        <link rel="stylesheet" href="assets\css\manage.css">

    </head>
    <body>

        <div class="pattern w-100">
            <div class="container text-white ps-4">
                <div class="row pt-5">
                    <span class="mb-0">
                        Selamat Datang,
                    </span>
                    <h4>
                        <?= $getUser["c_nama"] ?>
                    </h4>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-light bg-light py-3 fixed-bottom shadow-lg">
            <div class="container justify-content-between me-3 ms-3">
                <a href="manage.php" class="btn badge-success rounded px-4 py-2  shadow-sm">
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
                <a href="profile.php" class="btn badge-secondary rounded px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>
                </a>
            </div>
        </nav>

        <div class="container mt-4 me-3 mb-5">

            <div class="container">

                <div class="btn-group mt-2 w-100" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn badge-success fw-bolder" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">Buat Tugas</button>
                    <button type="button" class="btn badge-primary fw-bolder" data-bs-toggle="modal" data-bs-target="#modalBuatGrup" onclick="kodeGenerate()">Buat Grup</button>
                    <button type="button" class="btn badge-warning fw-bolder" data-bs-toggle="modal" data-bs-target="#modalJoinGrup">Join Grup</button>
                </div>

                <?php if($idead > 0) : ?>
                    <!-- Tugas Deadline -->
                    <div class="accordion mt-4" id="Deadline">
                        <div class="accordion-item border-danger shadow-sm">
                            <h2 class="accordion-header" id="headingDeadline">
                                <button class="accordion-button text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeadline" aria-expanded="true" aria-controls="collapseDeadline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle me-2 text-danger" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                    </svg>
                                    <span class="text-danger fw-bold">
                                        Tugas Deadline
                                    </span>
                                    <div class="badge badge-danger ms-3"><?= $idead ?></div>
                                </button>
                            </h2>
                            <div id="collapseDeadline" class="accordion-collapse collapse show" aria-labelledby="headingDeadline" data-bs-parent="#Deadline">
                                <div class="accordion-body">
                                    <!-- List Tugas -->
                                    <div class="accordion accordion-flush" id="accordionItem1Dead">
                                        <?php foreach($getTugasku as $tugasDeadline) : ?>
                                            <?php if(floor((strtotime($tugasDeadline["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) *24)) <= 2 && floor((strtotime($tugasDeadline["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) *24)) >= 0) : ?>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingdead<?= $tugasDeadline["id"] ?>">
                                                        <div class="row align-items-baseline">
                                                            <div class="col-auto">
                                                                <a href="includes/koneksi.php?setDone=1&id=<?= $tugasDeadline["id"] ?>&author=<?= $cookieUser ?>" class="btn btn-sm badge-success">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                            <button class="accordion-button collapsed col-auto fw-bold" style="width: 80%;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsedead<?= $tugasDeadline["id"] ?>" aria-expanded="false" aria-controls="flush-collapsedead<?= $tugasDeadline["id"] ?>">
                                                                <?= $tugasDeadline["c_namatugas"] ?>
                                                            </button>
                                                        </div>
                                                    </h2>
                                                    <div id="flush-collapsedead<?= $tugasDeadline["id"] ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingdead<?= $tugasDeadline["id"] ?>" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body ms-4">
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="badge badge-secondary py-2 px-4">
                                                                        <?= floor((strtotime($tugasDeadline["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) *24)) ?>
                                                                        Hari Lagi
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <span class="text-secondary">
                                                                        <?= date("H:i", strtotime($tugasDeadline["c_deadline"])) ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="badge-warning rounded text-wrap py-3 fs-6 px-4 text-start">
                                                                        <?= nl2br(str_replace(" ", " ", htmlspecialchars($tugasDeadline["c_deskripsi"])));  ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <!-- Button ubah modal -->
                                                                                <button type="button" class="btn btn-sm badge-primary mb-3" data-bs-toggle="modal" data-bs-target="#ubahTugas<?= $tugasDeadline["id"] ?>">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                                    </svg>
                                                                                    <span class="ms-2">
                                                                                        Ubah
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <a href="includes/koneksi.php?th=1&it=<?= $tugasDeadline["id"] ?>&hu=<?= $cookieUser ?>" class="btn btn-sm btn-outline-danger" onclick="hapus(event)">Hapus</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </div>
                                    <!-- End List Tugas -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- Tidak Ditampilkan Accordion Deadline -->
                <?php endif ?>

                <!-- Tugas Ku -->
                <div class="accordion mt-4" id="start">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingstart">
                            <button class="accordion-button text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStart" aria-expanded="true" aria-controls="collapseStart">
                                Tugasku
                                <div class="badge badge-danger ms-3"><?= $iTugas ?></div>
                            </button>
                        </h2>
                        <div id="collapseStart" class="accordion-collapse collapse show" aria-labelledby="headingstart" data-bs-parent="#start">
                            <div class="accordion-body">
                                <!-- List Tugas -->
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php if($iTugas > 0) : ?>
                                        <?php foreach($getTugasku as $tugasku) : ?>
                                            <?php if(floor((strtotime($tugasku["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) * 24)) >= 3) : ?>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-heading<?= $tugasku["id"] ?>">
                                                        <div class="row d-flex align-items-baseline">
                                                            <div class="col-auto">
                                                                <!-- <input type="checkbox" class="form-check-input" name="selesai" id="selesai"> -->
                                                                <!-- ######### -->
                                                                <a href="includes/koneksi.php?setDone=1&id=<?= $tugasku["id"] ?>&author=<?= $cookieUser ?>" class="btn btn-sm badge-primary">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                            <button class="accordion-button collapsed col-auto fw-bold" style="width: 80%;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $tugasku["id"] ?>" aria-expanded="false" aria-controls="flush-collapse<?= $tugasku["id"] ?>">
                                                                <?= $tugasku["c_namatugas"] ?>
                                                            </button>
                                                        </div>
                                                    </h2>
                                                    <div id="flush-collapse<?= $tugasku["id"] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $tugasku["id"] ?>" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body ms-4">
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="badge badge-secondary py-2 px-4">
                                                                        <?= floor((strtotime($tugasku["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) *24)) ?>
                                                                        Hari Lagi
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <span class="text-secondary">
                                                                        <?= date("H:i", strtotime($tugasku["c_deadline"])) ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="badge-warning rounded text-wrap py-3 fs-6 px-4 text-start">
                                                                        <?= nl2br(str_replace(" ", " ", htmlspecialchars($tugasku["c_deskripsi"])));  ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <!-- Button ubah modal -->
                                                                                <button type="button" class="btn btn-sm badge-primary mb-3" data-bs-toggle="modal" data-bs-target="#ubahTugas<?= $tugasku["id"] ?>">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                                    </svg>
                                                                                    <span class="ms-2">
                                                                                        Ubah
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <a href="includes/koneksi.php?th=1&it=<?= $tugasku["id"] ?>&hu=<?= $cookieUser ?>" class="btn btn-sm btn-outline-danger" onclick="hapus(event)">Hapus</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <span class="text-secondary">Kamu belum memiliki tugas aktif. </span>
                                        <button type="button" class="btn badge-success fw-bolder" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">Buat Tugas Sekarang</button>
                                    <?php endif ?>
                                </div>
                                <!-- End List Tugas -->
                            </div>
                        </div>
                    </div>
                </div>

                <?php foreach($getGrup as $grup) : ?>
                    <?php $pecahMember = explode( ",", $grup["c_member"]) ?>
                    <?php foreach($pecahMember as $member) : ?>
                        <?php if($member == $cookieUser) : ?>
                            <!-- Tugas Group -->
                            <div class="accordion mt-4" id="start<?= $grup["kode"] ?>">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingstart<?= $grup["kode"] ?>">
                                        <button class="accordion-button collapsed text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStart<?= $grup["kode"] ?>" aria-expanded="true" aria-controls="collapseStart<?= $grup["kode"] ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people me-3" viewBox="0 0 16 16">
                                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                            </svg>
                                            <?= $grup["c_namagrup"] ?>
                                            <div class="badge badge-danger ms-3">2</div>
                                        </button>
                                    </h2>
                                    <div id="collapseStart<?= $grup["kode"] ?>" class="accordion-collapse collapse" aria-labelledby="headingstart<?= $grup["kode"] ?>" data-bs-parent="#start<?= $grup["kode"] ?>">
                                        <div class="accordion-body">
                                            <!-- Rincian Grup -->
                                            <div class="badge badge-secondary text-wrap text-start py-3 px-3 mb-2">
                                            <?= $grup["c_deskripsigrup"] ?>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="d-grid gap-2">
                                                        <a href="#" class="btn btn-sm badge-success">Tambah</a>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="d-grid gap-2">
                                                        <a href="#" class="btn btn-sm badge-primary">
                                                            Member
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="d-grid gap-2">
                                                        <a href="includes/koneksi.php?delGrup=1&kode=<?= $grup["kode"] ?>" class="btn btn-sm btn-outline-danger" onclick="return yakin(event)">Keluar</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- List Tugas -->
                                            <div class="accordion accordion-flush" id="accordionFlushExampleGroup11">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOneGroup11">
                                                        <div class="row align-items-baseline">
                                                            <div class="col-auto">
                                                                <input type="checkbox" class="form-check-input" name="selesai" id="selesai">
                                                            </div>
                                                            <button class="accordion-button collapsed col-auto fw-bold" style="width: 85%;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseGroup11One" aria-expanded="false" aria-controls="flush-collapseGroup11One">
                                                                Pemrograman Web 2
                                                            </button>
                                                        </div>
                                                    </h2>
                                                    <div id="flush-collapseGroup11One" class="accordion-collapse collapse" aria-labelledby="flush-headingOneGroup11" data-bs-parent="#accordionFlushExampleGroup11">
                                                        <div class="accordion-body ms-3">
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="badge badge-secondary py-2 px-4">
                                                                        5 Hari Lagi
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <span class="text-secondary">
                                                                        18.00 AM
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <div class="badge badge-secondary py-2 px-2">
                                                                        Author - M N Mahmud
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="badge-warning rounded text-wrap py-3 fs-6 px-4 text-start">
                                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, quidem? <br><br>
                                                                        Lorem, ipsum dolor.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <a href="#" class="btn btn-sm badge-primary mb-3">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                                    </svg>
                                                                                    <span class="ms-2">
                                                                                        Ubah
                                                                                    </span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <a href="#" class="btn btn-sm btn-outline-danger" onclick="return hapus()">Hapus</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingTwoGroup11">
                                                        <div class="row align-items-baseline">
                                                            <div class="col-auto">
                                                                <input type="checkbox" class="form-check-input" name="selesai" id="selesai">
                                                            </div>
                                                            <button class="accordion-button collapsed col-auto fw-bold" style="width: 85%;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwoGroup11" aria-expanded="false" aria-controls="flush-collapseTwoGroup11">
                                                                Bahasa Indonesia
                                                            </button>
                                                        </div>
                                                    </h2>
                                                    <div id="flush-collapseTwoGroup11" class="accordion-collapse collapse" aria-labelledby="flush-headingTwoGroup11" data-bs-parent="#flush-headingTwoGroup11">
                                                        <div class="accordion-body ms-3">
                                                        <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="badge badge-secondary py-2 px-4">
                                                                        Hari Ini
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <span class="text-secondary">
                                                                        19.00 PM
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <div class="badge badge-secondary py-2 px-2">
                                                                        Author - M N Mahmud
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="badge-warning rounded text-wrap py-3 fs-6 px-4 text-start">
                                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, quidem? <br><br>
                                                                        Lorem, ipsum dolor.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="d-grid gap-2">
                                                                        <a href="#" class="btn btn-outline-secondary text-start">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                                                                <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                                                                            </svg>
                                                                            Document.pdf
                                                                        </a>
                                                                    </div>
                                                                    <div class="d-grid gap-2 mt-2">
                                                                        <a href="#" class="btn btn-outline-secondary text-start">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                                                                <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                                                                            </svg>
                                                                            Mtaeri2.pdf
                                                                        </a>
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <a href="#" class="btn btn-sm badge-primary mb-3">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                                    </svg>
                                                                                    <span class="ms-2">
                                                                                        Ubah
                                                                                    </span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <a href="#" class="btn btn-sm btn-outline-danger" onclick="return hapus()">Hapus</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End List Tugas -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endforeach ?>

                <!-- End Container -->
            </div>

            <!-- Tugas Telat -->
            <?php if($iTugasMin > 0) : ?>
                <div class="container mt-4 border-top">
                    <div class="accordion mt-4" id="accordionTelat">
                        <div class="accordion-item border-secondary shadow-sm">
                            <h2 class="accordion-header" id="headingTelat">
                                <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTelat" aria-expanded="true" aria-controls="collapseTelat">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-bottom me-2" viewBox="0 0 16 16">
                                        <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5zm2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702s.18.149.5.149.5-.15.5-.15v-.7c0-.701.478-1.236 1.011-1.492A3.5 3.5 0 0 0 11.5 3V2h-7z"/>
                                    </svg>
                                    Tugas Telat
                                    <div class="badge badge-danger ms-3"><?= $iTugasMin ?></div>
                                </button>
                            </h2>
                            <div id="collapseTelat" class="accordion-collapse collapse" aria-labelledby="headingTelat" data-bs-parent="#accordionTelat">
                                <div class="accordion-body">
                                    <div class="accordion accordion-flush" id="accordionFlushExampleTelat">
                                        <!-- List Tugas -->
                                        <?php foreach($getTugasku as $tugasTelat) : ?>
                                            <?php if(floor((strtotime($tugasTelat["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) * 24)) < 0) : ?>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingdead<?= $tugasTelat["id"] ?>">
                                                        <div class="row align-items-baseline">
                                                            <div class="col-auto">
                                                                <a href="includes/koneksi.php?setDone=1&id=<?= $tugasTelat["id"] ?>&author=<?= $cookieUser ?>" class="btn btn-sm badge-success">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                            <button class="accordion-button collapsed col-auto fw-bold" style="width: 80%;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsedead<?= $tugasTelat["id"] ?>" aria-expanded="false" aria-controls="flush-collapsedead<?= $tugasTelat["id"] ?>">
                                                                <?= $tugasTelat["c_namatugas"] ?>
                                                            </button>
                                                        </div>
                                                    </h2>
                                                    <div id="flush-collapsedead<?= $tugasTelat["id"] ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingdead<?= $tugasTelat["id"] ?>" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body ms-4">
                                                            <div class="row">
                                                                <div class="col-auto">
                                                                    <div class="badge badge-secondary py-2 px-4">
                                                                        <?= floor((strtotime($tugasTelat["c_selesaitugas"])  - strtotime(date("Y-m-d"))) / ((60 * 60) *24)) * (-1) ?>
                                                                        Hari Terlewat
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <span class="text-secondary">
                                                                        <?= date("H:i", strtotime($tugasTelat["c_deadline"])) ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="badge-warning rounded text-wrap py-3 fs-6 px-4 text-start">
                                                                        <?= nl2br(str_replace(" ", " ", htmlspecialchars($tugasTelat["c_deskripsi"])));  ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <!-- Button ubah modal -->
                                                                                <button type="button" class="btn btn-sm badge-primary mb-3" data-bs-toggle="modal" data-bs-target="#ubahTugas<?= $tugasTelat["id"] ?>">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                                                    </svg>
                                                                                    <span class="ms-2">
                                                                                        Ubah
                                                                                    </span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="d-grid gap-2">
                                                                                <a href="includes/koneksi.php?th=1&it=<?= $tugasTelat["id"] ?>&hu=<?= $cookieUser ?>" class="btn btn-sm btn-outline-danger" onclick="hapus(event)">Hapus</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <!-- Tidak Tampil  -->
            <?php endif ?>


            <!-- Tugas Sudah Selesai -->
            <div class="container mt-4 border-top">

                <div class="accordion mt-4" id="accordionSelesai">
                    <div class="accordion-item border-success shadow-sm">
                        <h2 class="accordion-header" id="headingEnd">
                            <button class="accordion-button collapsed text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEnd" aria-expanded="true" aria-controls="collapseEnd">
                                Tugas Selesai
                                <div class="badge badge-success ms-3"><?= mysqli_num_rows($getTugasSelesai) ?></div>
                            </button>
                        </h2>
                        <div id="collapseEnd" class="accordion-collapse collapse" aria-labelledby="headingEnd" data-bs-parent="#accordionSelesai">
                            <div class="accordion-body">
                                
                                <!-- List Tugas -->
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php if(mysqli_num_rows($getTugasSelesai) > 0) : ?>
                                        <?php foreach($getTugasSelesai as $tugasku) : ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-heading<?= $tugasku["id"] ?>">
                                                    <div class="row d-flex align-items-baseline">
                                                        <div class="col-auto">
                                                            <!-- <input type="checkbox" class="form-check-input" name="selesai" id="selesai"> -->
                                                            <!-- ######### -->
                                                            <a href="includes/koneksi.php?setUnDone=1&id=<?= $tugasku["id"] ?>&author=<?= $cookieUser ?>" class="btn btn-sm badge-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <button class="accordion-button collapsed col-auto fw-bold" style="width: 80%;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $tugasku["id"] ?>" aria-expanded="false" aria-controls="flush-collapse<?= $tugasku["id"] ?>">
                                                            <?= $tugasku["c_namatugas"] ?>
                                                        </button>
                                                    </div>
                                                </h2>
                                                <div id="flush-collapse<?= $tugasku["id"] ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $tugasku["id"] ?>" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body ms-4">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="badge-warning rounded text-wrap py-3 fs-6 px-4 text-start">
                                                                    <?= nl2br(str_replace(" ", " ", htmlspecialchars($tugasku["c_deskripsi"])));  ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="d-grid gap-2">
                                                                            <a href="includes/koneksi.php?th=1&it=<?= $tugasku["id"] ?>&hu=<?= $cookieUser ?>" class="btn btn-sm btn-outline-danger" onclick="hapus(event)">Hapus</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <span class="text-secondary">Belum Ada Tugas Selesai </span>
                                    <?php endif ?>
                                </div>
                                <!-- End List Tugas -->
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <footer class="footer mt-auto py-3 bg-light">
            <div class="container text-center">
                <span class="text-muted">Design and Developed by Mahmud</span>
            </div>
        </footer>


        <!-- Modal Tambah Tugas -->
        <div class="modal fade" id="modalTambahTugas" tabindex="-1" aria-labelledby="modalTambahTugas" aria-hidden="true">
            <div class="container">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahTugas">Buat Tugas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <form action="includes/koneksi.php" method="POST">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="namaTugas" class="form-label">Nama Tugas</label>
                                        <input type="text" name="namaTugas" id="namaTugas" class="form-control" required maxlength="50">
                                        <!-- Author Hidden -->
                                        <input type="text" name="author" id="author" class="form-control" value="<?= $cookieUser ?>" hidden>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="timeS" class="form-label">Hari Mulai</label>
                                            <input type="date" name="timeS" id="timeS" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="timeE" class="form-label">Hari Selesai</label>
                                            <input type="date" name="timeE" id="timeE" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="deadline" class="form-label">Deadline
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch ms-2" viewBox="0 0 16 16">
                                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                                                <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                                            </svg>
                                        </label>
                                        <input type="time" name="deadline" id="deadline" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" style="height: 100px"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="referensi" class="form-label">Referensi
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                                <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                                            </svg>
                                        </label>
                                        <input type="file" name="referensi" id="referensi" class="form-control" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn badge-success" name="buatTugas">Buat</button> 
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Tambah Tugas -->

        <!-- Modal Join Grup -->
        <div class="modal fade" id="modalJoinGrup" tabindex="-1" aria-labelledby="modalJoinGrup" aria-hidden="true">
            <div class="container">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalJoinGrup">Join Grup</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="includes/koneksi.php" method="post">
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control text-uppercase" name="kodeGrup" id="floatingInput" placeholder="==" required autocomplete="off" maxlength="6">
                                    <label for="floatingInput">Kode Grup</label>
                                    <input type="text" class="form-control" name="userGrup" value="<?= $cookieUser ?>" hidden>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="joinGrup" class="btn btn-warning">Join</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Join Group -->


        <!-- Modal Buat Group -->
        <div class="modal fade" id="modalBuatGrup" tabindex="-1" aria-labelledby="modalBuatGrup" aria-hidden="true">
            <div class="container">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalBuatGrup">Buat Grup</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="includes/koneksi.php" method="post">
                            <div class="container">
                                <div class="mb-3">
                                    <label for="kode" class="form-label">Kode Grup</label>
                                    <div class="input-group">
                                        <input type="text" name="kode" id="kode" class="form-control text-secondary" disabled required>
                                        <button type="button" onclick="kodeGenerate()" class="btn badge-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="text" name="authorGrup" value="<?= $cookieUser ?>" hidden>
                                </div>
                                <div class="mb-3">
                                    <label for="namaGrup" class="form-label">Nama Grup</label>
                                    <input type="text" name="namaGrup" id="namaGrup" class="form-control" required maxlength="50">
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsiGrup" class="form-label">Deskripsi Grup</label>
                                    <textarea type="text" name="deskripsiGrup" id="deskripsiGrup" class="form-control" style="height: 100px;">Mari bersama kita tingkatkan produktifitas dalam pengerjaan tugas.</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn badge-primary" name="buatGrup">Buat</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Buat Group -->

        <!-- Modal Ubah Tugas -->
        <?php foreach($getTugasku as $ubah) : ?>
        <div class="modal fade" id="ubahTugas<?= $ubah["id"] ?>" tabindex="-1" aria-labelledby="ubahTugasLabel<?= $ubah["id"] ?>" aria-hidden="true">
            <div class="container">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ubahTugasLabel<?= $ubah["id"] ?>">Ubah Tugas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Ambil Data Berdasarkan ID -->
                            <?php
                                $idUbah = $ubah["id"];
                                $getUbah = mysqli_fetch_assoc(mysqli_query($conn, "SELECT c_namatugas, c_mulaitugas, c_selesaitugas, c_deadline, c_deskripsi FROM t_task WHERE id = $idUbah"));
                            ?>
                            <div class="container">
                                <form action="includes/koneksi.php" method="POST">
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="namaTugas" class="form-label">Nama Tugas</label>
                                        <input type="text" name="namaTugas" id="namaTugas" class="form-control" value="<?= $getUbah["c_namatugas"] ?>" required>
                                        <!-- Id Hidden untuk ubah -->
                                        <input type="text" name="idUbahTugas" value="<?= $idUbah ?>" hidden>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="timeS" class="form-label">Hari Mulai</label>
                                            <input type="date" name="timeS" id="timeS" class="form-control" value="<?= $getUbah["c_mulaitugas"] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="timeE" class="form-label">Hari Selesai</label>
                                            <input type="date" name="timeE" id="timeE" class="form-control" value="<?= $getUbah["c_selesaitugas"] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="deadline" class="form-label">Deadline
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stopwatch ms-2" viewBox="0 0 16 16">
                                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"/>
                                                <path d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z"/>
                                            </svg>
                                        </label>
                                        <input type="time" name="deadline" id="deadline" class="form-control" value="<?= $getUbah["c_deadline"] ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" class="form-control" style="height: 100px"><?= $getUbah["c_deskripsi"] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="referensi" class="form-label">Referensi
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                                                <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                                            </svg>
                                        </label>
                                        <input type="file" name="referensi" id="referensi" class="form-control" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn badge-primary" name="ubahTugas">Ubah</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach ?>


    <?php include "includes/footer.php" ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function yakin(ev){
            ev.preventDefault(); // prevent form submit
            var urlToRedirect = ev.currentTarget.getAttribute("href"); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            swal({
                title: "Apa Kamu Yakin?",
                text: "Riwayat tugasmu akan otomatis terhapus!",
                icon: "warning",
                buttons: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                swal("Berhasil", "Kamu berhasil keluar dari grup ini!", "success");
                window.location.href = urlToRedirect;
            } else {
                swal("Dibatalkan", "Kamu masih ada pada grup ini", "error");
            }
            });
        }

        function hapus(ev){
            ev.preventDefault(); // prevent form submit
            var urlToRedirect = ev.currentTarget.getAttribute("href"); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
            swal({
                title: "Apa Kamu Yakin?",
                text: "Riwayat tugasmu akan otomatis terhapus!",
                icon: "warning",
                buttons: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                swal("Berhasil", "Kamu berhasil menghapus tugas ini!", "success");
                window.location.href = urlToRedirect;
            } else {
                swal("Dibatalkan", "Tugasmu masih tersimpan :)", "error");
            }
            });
        }
    

        function kodeGenerate(){
            var result           = "";
            var characters       = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            var charactersLength = characters.length;
            for ( var i = 0; i < 6; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            document.cookie = "kode=" + result;
            return document.getElementById("kode").value = result;
        }
    </script>