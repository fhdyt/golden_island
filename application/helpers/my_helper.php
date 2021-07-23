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
if (!function_exists('bulan')) {
  function bulan_id($bulan)
  {
    if (empty($bulan)) {
      $date = "-";
      return $date;
    }

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

    $date = $bulan_indonesia;
    return $date;
  }
}

if (!function_exists('jam')) {
  function jam($jam)
  {
    $jam_convert = date("G:i", strtotime($jam));
    return $jam_convert;
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
    $time = date("YmdGis");
    return random_string('sha1', 5) . $time;
  }
}

if (!function_exists('jenis_barang')) {
  function jenis_barang()
  {
    $jenis_barang = array(
      'gas' => 'Gas',
      //'tabung' => 'Tabung',
      'liquid' => 'Liquid',
      //'tangki' => 'Tangki',
      'sparepart' => 'Sparepart',
      'aset' => 'Aset',
      //'transporter' => 'Transporter',
    );
    return $jenis_barang;
  }
}
if (!function_exists('jenis_barang_pembelian')) {
  function jenis_barang_pembelian()
  {
    $jenis_barang_pembelian = array(
      'gas' => 'Gas',
      'tabung' => 'Tabung',
      'liquid' => 'Liquid',
      'tangki' => 'Tangki',
      'sparepart' => 'Sparepart',
      'aset' => 'Aset',
      'transporter' => 'Transporter',
    );
    return $jenis_barang_pembelian;
  }
}

if (!function_exists('jenis_barang_penjualan')) {
  function jenis_barang_penjualan()
  {
    $jenis_barang_penjualan = array(
      'gas' => 'Gas',
      'tabung' => 'Tabung',
      'liquid' => 'Liquid',
      'sparepart' => 'Sparepart',
    );
    return $jenis_barang_penjualan;
  }
}

if (!function_exists('satuan')) {
  function satuan()
  {
    $CI = &get_instance();
    $CI->load->model('konfigurasi/SatuanModel');
    return $CI->SatuanModel->list();
  }
}
if (!function_exists('premi')) {
  function premi()
  {
    $CI = &get_instance();
    $CI->load->model('konfigurasi/PremiModel');
    return $CI->PremiModel->list();
  }
}

if (!function_exists('konversi')) {
  function konversi()
  {
    $CI = &get_instance();
    $CI->load->model('konfigurasi/KonversiModel');
    return $CI->KonversiModel->list();
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
      '2020' => '2020',
      '2021' => '2021',
      '2022' => '2022',
      '2023' => '2023',
      '2024' => '2024',
    );
    return $tahun;
  }
}

if (!function_exists('menu_list')) {
  function menu_list()
  {
    $CI = &get_instance();
    $CI->load->model('LoginModel');
    return $CI->LoginModel->menu();
  }
}

if (!function_exists('jabatan')) {
  function jabatan()
  {
    $jabatan = array(
      'Driver' => 'Driver',
      'Distribusi' => 'Distribusi',
      'Produksi' => 'Produksi',
      'Cylinder Control' => 'Cylinder Control',
      'Marketing' => 'Marketing',
      'Akuntansi' => 'Akuntansi',
      'Direktur' => 'Direktur',
      'Manager' => 'Manager',
    );
    return $jabatan;
  }
}

if (!function_exists('keterangan_pembelian')) {
  function keterangan_pembelian()
  {
    $keterangan_pembelian = "1. 
2. 
3. 
4. 
5. 
6.";
    return $keterangan_pembelian;
  }
}

if (!function_exists('driver')) {
  function driver()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_KARYAWAN WHERE MASTER_KARYAWAN_JABATAN="Driver" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('karyawan_produksi')) {
  function karyawan_produksi()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_KARYAWAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}
if (!function_exists('kendaraan')) {
  function kendaraan()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_KENDARAAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('perusahaan')) {
  function perusahaan()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM PERUSAHAAN WHERE RECORD_STATUS="AKTIF"')->result();
    return $hasil;
  }
}
if (!function_exists('perusahaan_akses')) {
  function perusahaan_akses()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM USER_AKSES_PERUSAHAAN AS AKSES LEFT JOIN PERUSAHAAN AS P ON AKSES.PERUSAHAAN_KODE=P.PERUSAHAAN_KODE WHERE AKSES.USER_ID="' . $CI->session->userdata('USER_ID') . '" AND AKSES.RECORD_STATUS="AKTIF" AND P.RECORD_STATUS="AKTIF"')->result();
    return $hasil;
  }
}

if (!function_exists('detail_perusahaan')) {
  function detail_perusahaan()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM PERUSAHAAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}
if (!function_exists('detail_user')) {
  function detail_user()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM USER WHERE RECORD_STATUS="AKTIF" AND USER_ID="' . $CI->session->userdata('USER_ID') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('tabung')) {
  function tabung()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="gas" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_BARANG_PRIORITAS DESC, MASTER_BARANG_NAMA ASC')->result();
    return $hasil;
  }
}

if (!function_exists('tabung_kontrol_tabung')) {
  function tabung_kontrol_tabung($id)
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM 
JURNAL_TABUNG AS J 
LEFT JOIN MASTER_BARANG AS B 
ON J.MASTER_BARANG_ID=B.MASTER_BARANG_ID 
WHERE B.MASTER_BARANG_JENIS="gas" 
AND J.MASTER_RELASI_ID="' . $id . '"
AND J.RECORD_STATUS="AKTIF" 
AND J.PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"
AND B.RECORD_STATUS="AKTIF" 
AND B.PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ')->result();
    return $hasil;
  }
}

if (!function_exists('tangki')) {
  function tangki()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="liquid" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('akun_list')) {
  function akun_list()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM AKUN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('pajak_list')) {
  function pajak_list()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM PAJAK WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('karyawan_list')) {
  function karyawan_list()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_KARYAWAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}
if (!function_exists('relasi_list')) {
  function relasi_list()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_RELASI WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('tangki_list')) {
  function tangki_list()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_TANGKI WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('tabung_list')) {
  function tabung_list()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_TABUNG WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('supplier_list')) {
  function supplier_list()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_SUPPLIER WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
    return $hasil;
  }
}

if (!function_exists('kategori_akun')) {
  function kategori_akun()
  {
    $kategori_akun = array(
      'Kas dan Bank' => 'Kas dan Bank',
    );
    return $kategori_akun;
  }
}


if (!function_exists('add_riwayat_tabung')) {
  function add_riwayat_tabung($id, $tanggal, $status, $supplier_id, $relasi_id)
  {
    $CI = &get_instance();
  }
}

if (!function_exists('nomor_surat_jalan')) {
  function nomor_surat_jalan($surat_jalan, $tanggal)
  {
    $CI = &get_instance();

    $bulan = date("m", strtotime($tanggal));
    $tahun = date("y", strtotime($tanggal));
    $nomor = "" . $surat_jalan . "/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM SURAT_JALAN WHERE SURAT_JALAN_NOMOR LIKE "%' . $nomor . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY SURAT_JALAN_NOMOR DESC ')->result();
    if (empty($hasil)) {
      return "0001/" . $surat_jalan . "/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    } else {
      $nomor = explode("/", $hasil[0]->SURAT_JALAN_NOMOR);
      $nomorbaru = $nomor[0] + 1;
      return sprintf("%04d", $nomorbaru) . "/" . $surat_jalan . "/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    }
  }
}
if (!function_exists('nomor_faktur')) {
  function nomor_faktur($tanggal)
  {
    $CI = &get_instance();

    $bulan = date("m", strtotime($tanggal));
    $tahun = date("y", strtotime($tanggal));
    $nomor = "INV/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM FAKTUR WHERE FAKTUR_NOMOR LIKE "%' . $nomor . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY FAKTUR_NOMOR DESC ')->result();
    if (empty($hasil)) {
      return "0001/INV/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    } else {
      $nomor = explode("/", $hasil[0]->FAKTUR_NOMOR);
      $nomorbaru = $nomor[0] + 1;
      return sprintf("%04d", $nomorbaru) . "/INV/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    }
  }
}

if (!function_exists('nomor_jaminan')) {
  function nomor_jaminan($tanggal)
  {
    $CI = &get_instance();

    $bulan = date("m", strtotime($tanggal));
    $tahun = date("y", strtotime($tanggal));
    $nomor = "JMN/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM FAKTUR_JAMINAN WHERE FAKTUR_JAMINAN_NOMOR LIKE "%' . $nomor . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY FAKTUR_JAMINAN_NOMOR DESC ')->result();
    if (empty($hasil)) {
      return "0001/JMN/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    } else {
      $nomor = explode("/", $hasil[0]->FAKTUR_JAMINAN_NOMOR);
      $nomorbaru = $nomor[0] + 1;
      return sprintf("%04d", $nomorbaru) . "/JMN/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    }
  }
}

if (!function_exists('nomor_produksi')) {
  function nomor_produksi($tanggal)
  {
    $CI = &get_instance();

    $bulan = date("m", strtotime($tanggal));
    $tahun = date("y", strtotime($tanggal));
    $nomor = "PRO/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM PRODUKSI WHERE PRODUKSI_NOMOR LIKE "%' . $nomor . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY PRODUKSI_NOMOR DESC ')->result();
    if (empty($hasil)) {
      return "0001/PRO/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    } else {
      $nomor = explode("/", $hasil[0]->PRODUKSI_NOMOR);
      $nomorbaru = $nomor[0] + 1;
      return sprintf("%04d", $nomorbaru) . "/PRO/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    }
  }
}

if (!function_exists('nomor_titipan')) {
  function nomor_titipan($tanggal)
  {
    $CI = &get_instance();

    $bulan = date("m", strtotime($tanggal));
    $tahun = date("y", strtotime($tanggal));
    $nomor = "TTP/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM JURNAL_TABUNG WHERE JURNAL_TABUNG_NOMOR LIKE "%' . $nomor . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY JURNAL_TABUNG_NOMOR DESC ')->result();
    if (empty($hasil)) {
      return "0001/TTP/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    } else {
      $nomor = explode("/", $hasil[0]->JURNAL_TABUNG_NOMOR);
      $nomorbaru = $nomor[0] + 1;
      return sprintf("%04d", $nomorbaru) . "/TTP/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    }
  }
}

if (!function_exists('nomor_pembelian')) {
  function nomor_pembelian($pembelian, $tanggal)
  {
    $CI = &get_instance();

    $bulan = date("m", strtotime($tanggal));
    $tahun = date("y", strtotime($tanggal));
    $nomor = "" . $pembelian . "/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM PEMBELIAN WHERE PEMBELIAN_NOMOR LIKE "%' . $nomor . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY PEMBELIAN_NOMOR DESC ')->result();
    if (empty($hasil)) {
      return "0001/" . $pembelian . "/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    } else {
      $nomor = explode("/", $hasil[0]->PEMBELIAN_NOMOR);
      $nomorbaru = $nomor[0] + 1;
      return sprintf("%04d", $nomorbaru) . "/" . $pembelian . "/" . $CI->session->userdata('PERUSAHAAN_KODE') . "/" . $bulan . "-" . $tahun . "";
    }
  }
}

if (!function_exists('kode_tabung')) {
  function kode_tabung()
  {
    $CI = &get_instance();

    $kode = $CI->session->userdata('PERUSAHAAN_KODE');

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_TABUNG WHERE MASTER_TABUNG_KODE LIKE "%' . $kode . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_TABUNG_KODE DESC')->result();
    if (empty($hasil)) {
      return $kode . "-0001";
    } else {
      $nomor = explode("-", $hasil[0]->MASTER_TABUNG_KODE);
      $nomorbaru = $nomor[1] + 1;
      return $kode . "-" . sprintf("%04d", $nomorbaru);
    }
  }
}

if (!function_exists('kode_tangki')) {
  function kode_tangki()
  {
    $CI = &get_instance();

    $kode = "T-" . $CI->session->userdata('PERUSAHAAN_KODE');

    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_TANGKI WHERE MASTER_TANGKI_KODE LIKE "%' . $kode . '%" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_TANGKI_KODE DESC')->result();
    if (empty($hasil)) {
      return $kode . "-0001";
    } else {
      $nomor = explode("-", $hasil[0]->MASTER_TANGKI_KODE);
      $nomorbaru = $nomor[1] + 1;
      return $kode . "-" . sprintf("%04d", $nomorbaru);
    }
  }
}

if (!function_exists('notifikasi')) {
  function notifikasi()
  {
    // require APPPATH . '../vendor/autoload.php';

    // $options = array(
    //   'cluster' => 'ap1',
    //   'useTLS' => true
    // );
    // $pusher = new Pusher\Pusher(
    //   '1b15b42882162825307f',
    //   '7d1aa65ac06a11eabb87',
    //   '1191698',
    //   $options
    // );

    // $data['message'] = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam rerum ipsum numquam natus, tenetur molestiae iste sequi cupiditate minima in minus laudantium exercitationem magni magnam unde vero quidem placeat! In!';
    // $pusher->trigger('my-channel', 'my-event', $data);
  }
}

if (!function_exists('penyebut')) {
  function penyebut($nilai)
  {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
      $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
  }
}

if (!function_exists('terbilang')) {
  function terbilang($nilai)
  {
    if ($nilai < 0) {
      $hasil = "minus " . trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    }
    return $hasil;
  }
}

if (!function_exists('qrcode')) {
  function qrcode($nomor)
  {
    $CI = &get_instance();
    $CI->load->library('ciqrcode');

    $config['cacheable']    = true; //boolean, the default is true
    $config['imagedir']     = 'uploads/qr/'; //direktori penyimpanan qr code
    $config['quality']      = true; //boolean, the default is true
    $config['size']         = '1024'; //interger, the default is 1024
    $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
    $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
    $CI->ciqrcode->initialize($config);

    $image_name = str_replace("/", "-", $nomor) . '.png'; //buat name dari qr code sesuai dengan nomor

    $params['data'] = $nomor; //data yang akan di jadikan QR CODE
    $params['level'] = 'H'; //H=High
    $params['size'] = 10;
    $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
    $CI->ciqrcode->generate($params); // fungsi untuk generate QR CODE
  }
}

if (!function_exists('send_telegram')) {
  function send_telegram($pesan)
  {
    $API = "https://api.telegram.org/bot1696034827:AAGfDO9eyQspEKhnJIfm1Dwv2weP73VF1Kg/sendmessage?chat_id=744164478&text=" . urlencode($pesan) . "";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL, $API);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }
}
