<?php

namespace App\Models;

use CodeIgniter\Model;

class KunjunganModel extends Model
{
    protected $table = 'lap_kunjungan';

    public function getFilter($kategori = 'kabupaten', $tgl_awal = null, $tgl_akhir = null, $namaKabupaten = null, $namaProvinsi = null)
    {
    
    $query = $this->db->table('lap_kunjungan')
        ->select($kategori . ', SUM(CASE WHEN jenis_pendaftaran = "Poliklinik" THEN 1 ELSE 0 END) AS total_poliklinik, 
                 SUM(CASE WHEN jenis_pendaftaran = "IGD" THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = "IGD" OR jenis_pendaftaran = "Poliklinik" THEN 1 ELSE 0 END) AS total_kunjungan, daftar')
        ->groupBy($kategori)
        ->having('total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0');

    if ($tgl_akhir != null) {
        $query->where('daftar', $tgl_akhir); 
    }
    
    if ($namaKabupaten) {
        // Jika $namaKabupaten tidak kosong, tambahkan kondisi where untuk $namaKabupaten
        $query->where('kabupaten', $namaKabupaten)->where('provinsi', $namaProvinsi);
    } 

    
    $result = $query->get()->getResultArray();

    $totalperwilayah = 0;
    $totalperigd = 0;
    $totalperpoli = 0;

    // menghitung total kunjungan 
    foreach ($result as $r) {
        $totalperwilayah += $r['total_kunjungan'];
        $totalperigd += $r['total_igd'];
        $totalperpoli += $r['total_poliklinik'];
    }
    
    $persen = [];
    foreach ($result as $row) {
        $persen[] = ($row['total_kunjungan'] / $totalperwilayah) * 100; 
    }

    $hasil = [];
    foreach($result as $key => $row) {
        $row['persen'] = $persen[$key];
        $hasil[] = $row;
    }

    $area = [];
    $persentase = [];
    if($kategori == 'provinsi') {
        $area[] = 'Indonesia';
        $persentase[] = ($totalperwilayah / $totalperwilayah) * 100; 
    } elseif($kategori == 'kabupaten') {
        $area = $this->db->table('lap_kunjungan')->select('provinsi, SUM(CASE WHEN jenis_pendaftaran = "Poliklinik" THEN 1 ELSE 0 END) AS total_poliklinik, SUM(CASE WHEN jenis_pendaftaran = "igd" THEN 1 ELSE 0 END) AS total_igd, SUM(CASE WHEN jenis_pendaftaran = "IGD" OR jenis_pendaftaran = "Poliklinik" THEN 1 ELSE 0 END) AS total_kunjungan, daftar')
        ->groupBy('provinsi')
        ->having('total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0')
        ->get()->getResultArray();
        foreach($area as $key => $a) {
            $persentase[$key] = $a['total_kunjungan'] / $totalperwilayah;
        }
        }
        $data = [
            'result' => $hasil, 
            'totalperwilayah' => $totalperwilayah,
            'totalperigd' => $totalperigd,
            'totalperpoli' => $totalperpoli,
            'area' => $area,
            'persentase_ind' => $persentase
        ];
    
        return $data;
    }
    
    // Fungsi untuk mengambil data berdasarkan kabupaten
    public function getDataByKabupaten($kabupaten)
    {
        // Query untuk mengambil data dari tabel view
        $query = $this->db->table('lap_kunjungan')
            ->select('kelurahan, SUM(CASE WHEN jenis_pendaftaran = "Poliklinik" THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = "IGD" THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = "IGD" OR jenis_pendaftaran = "Poliklinik" THEN 1 ELSE 0 END) AS total_kunjungan, kecamatan, kabupaten, provinsi, daftar')
            ->where('kabupaten', $kabupaten)
            ->groupBy('kelurahan')
            ->orderBy('kecamatan')
            ->get()
            ->getResultArray();
       
        // membuat data untuk summary
        $arraydatatotalkunjungan = [];
        foreach ($query as $item) {
            $kecamatan = $item['kecamatan'];
            $total_kunjungan = $item['total_kunjungan'];
            
            // Jika kecamatan belum ada dalam array, inisialisasikan jumlahnya dengan 0
            if (!isset($arraydatatotalkunjungan[$kecamatan])) {
                $arraydatatotalkunjungan[$kecamatan] = 0;
            }

            // Tambahkan jumlah pengunjung ke kecamatan yang sesuai
            $arraydatatotalkunjungan[$kecamatan] += $total_kunjungan;
        }
        // end data untuk summary


        $data = ['array' => $query, 'arraydatatotalkunjungan' => $arraydatatotalkunjungan];
        return $data;
    }
}
