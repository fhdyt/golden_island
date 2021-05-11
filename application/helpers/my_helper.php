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
if (!function_exists('kendaraan')) {
  function kendaraan()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_KENDARAAN WHERE RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '"')->result();
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

if (!function_exists('tabung')) {
  function tabung()
  {
    $CI = &get_instance();
    $CI->load->database();
    $hasil = $CI->db->query('SELECT * FROM MASTER_BARANG WHERE MASTER_BARANG_JENIS="gas" AND RECORD_STATUS="AKTIF" AND PERUSAHAAN_KODE="' . $CI->session->userdata('PERUSAHAAN_KODE') . '" ORDER BY MASTER_BARANG_NAMA ASC')->result();
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
    require APPPATH . '../vendor/autoload.php';

    $options = array(
      'cluster' => 'ap1',
      'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
      '1b15b42882162825307f',
      '7d1aa65ac06a11eabb87',
      '1191698',
      $options
    );

    $data['message'] = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam rerum ipsum numquam natus, tenetur molestiae iste sequi cupiditate minima in minus laudantium exercitationem magni magnam unde vero quidem placeat! In!';
    $pusher->trigger('my-channel', 'my-event', $data);
  }
}
