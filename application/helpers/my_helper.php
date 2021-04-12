<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('tanggal')) {
  function tanggal($tanggal)
  {
    if (empty($tanggal)) {
      $date = "-";
      return $date;
    }
    $hari = date("d", strtotime($tanggal));
    $bulan = date("m", strtotime($tanggal));
    $tahun = date("Y", strtotime($tanggal));

    if ($bulan == "01") {
      $bulan_indonesia = "Januari";
    } else if ($bulan == "02") {
      $bulan_indonesia = "Februari";
    } else if ($bulan == "03") {
      $bulan_indonesia = "Maret";
    } else if ($bulan == "04") {
      $bulan_indonesia = "April";
    } else if ($bulan == "05") {
      $bulan_indonesia = "Mei";
    } else if ($bulan == "06") {
      $bulan_indonesia = "Juni";
    } else if ($bulan == "07") {
      $bulan_indonesia = "Juli";
    } else if ($bulan == "08") {
      $bulan_indonesia = "Agustus";
    } else if ($bulan == "09") {
      $bulan_indonesia = "September";
    } else if ($bulan == "10") {
      $bulan_indonesia = "Oktober";
    } else if ($bulan == "11") {
      $bulan_indonesia = "November";
    } else if ($bulan == "12") {
      $bulan_indonesia = "Desember";
    }

    $date = $hari . " " . $bulan_indonesia . " " . $tahun;
    return $date;
  }
}

if (!function_exists('hari')) {
  function hari($tanggal)
  {
    if (empty($tanggal)) {
      $day = "-";
      return $day;
    }
    $hari = date("D", strtotime($tanggal));

    if ($hari == "Mon") {
      $hari_indonesia = "Senin";
    } else if ($hari == "Tue") {
      $hari_indonesia = "Selasa";
    } else if ($hari == "Wed") {
      $hari_indonesia = "Rabu";
    } else if ($hari == "Thu") {
      $hari_indonesia = "Kamis";
    } else if ($hari == "Fri") {
      $hari_indonesia = "Jumat";
    } else if ($hari == "Sat") {
      $hari_indonesia = "Sabtu";
    } else if ($hari == "Sun") {
      $hari_indonesia = "Minggu";
    }

    return $hari_indonesia;
  }
}

if (!function_exists('jam')) {
  function jam($jam)
  {
    if (empty($jam)) {
      $time = "-";
      return $time;
    }
    $h = date("h", strtotime($jam));
    $i = date("i", strtotime($jam));
    $sa = date("sa", strtotime($jam));

    $time = $h . "." . $i;
    return $time;
  }
}

if (!function_exists('create_id')) {
  function create_id()
  {
    $time = date("Ymdhi");
    return random_string('sha1', 5) . $time;
  }
}

if (!function_exists('jenis_barang')) {
  function jenis_barang()
  {
    $jenis_barang = array(
      'gas' => 'Gas',
      'tabung' => 'Tabung',
      'liquid' => 'Liquid',
      'tangki' => 'Tangki',
      'sparepart' => 'Sparepart',
      'aset' => 'Aset',
      'transporter' => 'Transporter',
    );
    return $jenis_barang;
  }
}

if (!function_exists('satuan')) {
  function satuan()
  {
    $satuan = array(
      'M3' => 'M3',
      'Kg' => 'Kg',
      'Cyl' => 'Cyl',
      'Pcs' => 'Pcs',
      'Inc' => 'Inc',
      'Btg' => 'Btg',
    );
    return $satuan;
  }
}

if (!function_exists('bulan')) {
  function bulan()
  {
    $bulan = array(
      '01' => 'Januari',
      '02' => 'Februari',
      '03' => 'Maret',
      '04' => 'April',
      '05' => 'Mei',
      '06' => 'Juni',
      '07' => 'Juli',
      '08' => 'Agustus',
      '09' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember',
    );
    return $bulan;
  }
}

if (!function_exists('tahun')) {
  function tahun()
  {
    $tahun = array(
      '2018' => '2018',
      '2019' => '2019',
      '2020' => '2020',
      '2021' => '2021',
      '2022' => '2022',
      '2023' => '2023',
      '2024' => '2024',
    );
    return $tahun;
  }
}
