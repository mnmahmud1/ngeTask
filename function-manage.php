<?php

function hari($hari){
    if($hari == "Sunday"){
        return "Minggu";
    } elseif ($hari == "Monday"){
        return "Senin";
    } elseif ($hari == "Tuesday"){
        return "Selasa";
    } elseif ($hari == "Wednesday"){
        return "Rabu";
    } elseif ($hari == "Thursday"){
        return "Kamis";
    } elseif ($hari == "Friday"){
        return "Jumat";
    } elseif ($hari == "Saturday"){
        return "Sabtu";
    }
}

function bulan($bulan){
    if($bulan == "January"){
        return "Januari";
    } elseif ($bulan == "February"){
        return "Februari";
    } elseif ($bulan == "March"){
        return "Maret";
    } elseif ($bulan == "April"){
        return "April";
    } elseif ($bulan == "May"){
        return "Mei";
    } elseif ($bulan == "June"){
        return "Juni";
    } elseif ($bulan == "July"){
        return "Juli";
    } elseif ($bulan == "August"){
        return "Agustus";
    } elseif ($bulan == "September"){
        return "September";
    } elseif ($bulan == "October"){
        return "Oktober";
    } elseif ($bulan == "November"){
        return "November";
    } elseif ($bulan == "December"){
        return "Desember";
    }
}