<?php

namespace App\Models;

use CodeIgniter\Model;

class LapKunjunganModel extends Model
{
    protected $table            = 'lap_kunjungan';
    public function getSummary ($kategori = 'provinsi', $namaProvinsi = null, $namaKabupaten = null, $tgl_awal = null, $tgl_akhir = null) {
        $sisipan = '';
        if($tgl_awal != ''){
            $sisipan = "AND daftar >= '$tgl_awal' AND daftar <= '$tgl_akhir'";  
        }


        if($kategori == 'kelurahan') {
            
            $area = $this->db->query("
            SELECT Kelurahan, Kecamatan, Kabupaten,
                SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = NULL THEN 1 ELSE 0 END) AS total_null, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan, daftar
            FROM lap_kunjungan
            WHERE Kabupaten = '$namaKabupaten' 
                AND Provinsi = '$namaProvinsi' $sisipan
                 
            GROUP BY provinsi, kabupaten, kecamatan, kelurahan
            HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0
            ")->getResultArray();
            
            $total_kunjungan = 0;
            $total_igd = 0;
            $total_poliklinik = 0;
            $total_null = 0;
            foreach($area as $tot) {
                $total_kunjungan += $tot['total_kunjungan'];
                $total_poliklinik += $tot['total_poliklinik'];
                $total_igd += $tot['total_igd'];
                $total_null += $tot['total_null'];
            }

            $sub = [
                'total_kunjungan' => $total_kunjungan,
                'total_igd' => $total_igd,
                'total_poliklinik' => $total_poliklinik,
                'total_null' => $total_null,
            ];

            foreach($area as &$row){
                $row['persentase'] = number_format($row['total_kunjungan'] / $total_kunjungan, 4) * 100;
            }

            // KIRIM DATA 
            $hasil = [
                'area' => $area,
                'sub' => $sub
            ];
            return $hasil;
        } elseif ($kategori == 'kecamatan') {
            $area = $this->db->query("
            SELECT Kecamatan, Kabupaten,
                SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = NULL THEN 1 ELSE 0 END) AS total_null, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan
            FROM lap_kunjungan
            WHERE Kabupaten = '$namaKabupaten' 
                AND Provinsi = '$namaProvinsi' $sisipan
            GROUP BY provinsi, kabupaten, kecamatan
            HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0
            ")->getResultArray();
            
            $total_kunjungan = 0;
            $total_igd = 0;
            $total_poliklinik = 0;
            $total_null = 0;
            foreach($area as $tot) {
                $total_kunjungan += $tot['total_kunjungan'];
                $total_poliklinik += $tot['total_poliklinik'];
                $total_igd += $tot['total_igd'];
                $total_null += $tot['total_null'];
            }

            $sub = [
                'total_kunjungan' => $total_kunjungan,
                'total_igd' => $total_igd,
                'total_poliklinik' => $total_poliklinik,
                'total_null' => $total_null,
            ];

            foreach($area as &$row){
                $row['persentase'] = number_format($row['total_kunjungan'] / $total_kunjungan, 4) * 100;
            }

            // KIRIM DATA 
            $hasil = [
                'area' => $area,
                'sub' => $sub
            ];
            return $hasil;
        }  elseif($kategori == 'kabupaten'){

            if($tgl_awal != ''){
                $sisipan = "WHERE daftar >= '$tgl_awal' AND daftar <= '$tgl_akhir'";  
            }

            $area = $this->db->query("
            SELECT Kabupaten, Provinsi,
                SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = NULL THEN 1 ELSE 0 END) AS total_null, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan
            FROM lap_kunjungan $sisipan
            GROUP BY provinsi
            HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0
            ")->getResultArray();
            
            $total_kunjungan = 0;
            $total_igd = 0;
            $total_poliklinik = 0;
            $total_null = 0;
            foreach($area as $tot) {
                $total_kunjungan += $tot['total_kunjungan'];
                $total_poliklinik += $tot['total_poliklinik'];
                $total_igd += $tot['total_igd'];
                $total_null += $tot['total_null'];
            }

            $sub = [
                'total_kunjungan' => $total_kunjungan,
                'total_igd' => $total_igd,
                'total_poliklinik' => $total_poliklinik,
                'total_null' => $total_null,
            ];

            foreach($area as &$row){
                $row['persentase'] = number_format($row['total_kunjungan'] / $total_kunjungan, 4) * 100;
            }

            // KIRIM DATA 
            $hasil = [
                'area' => $area,
                'sub' => $sub
            ];
            return $hasil;
        } else {
            if($tgl_awal != ''){
                $sisipan = "WHERE daftar >= '$tgl_awal' AND daftar <= '$tgl_akhir'";  
            }
            $area = $this->db->query("
            SELECT Provinsi,
                SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran IS NULL THEN 1 ELSE 0 END) AS total_null, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan
            FROM lap_kunjungan $sisipan
            GROUP BY provinsi
            HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0")->getResultArray();

            $total_kunjungan = 0;
            $total_igd = 0;
            $total_poliklinik = 0;
            $total_null = 0;
            foreach($area as $tot) {
                $total_kunjungan += $tot['total_kunjungan'];
                $total_poliklinik += $tot['total_poliklinik'];
                $total_igd += $tot['total_igd'];
                $total_null += $tot['total_null'];
            }

            $sub = [
                'total_kunjungan' => $total_kunjungan,
                'total_igd' => $total_igd,
                'total_poliklinik' => $total_poliklinik,
                'total_null' => $total_null,
            ];

            $area = [
                'area' => 'Indonesia',
                'persentase' => 100
            ];

            // KIRIM DATA 
            $hasil = [
                'area' => $area,
                'sub' => $sub
            ];
            return $hasil;
        }
    }


    public function getDataArray ($kategori = 'provinsi', $namaKabupaten = null, $namaProvinsi = null, $tgl_awal = null, $tgl_akhir = null) {
        $sisipan = '';
        if($tgl_awal != ''){
            $sisipan = "AND daftar >= '$tgl_awal' AND daftar <= '$tgl_akhir'";  
        }
        if($kategori == 'provinsi'){
            if($tgl_awal != ''){
                $sisipan = "WHERE daftar >= '$tgl_awal' AND daftar <= '$tgl_akhir'";  
            }
            $query = $this->db->query("SELECT provinsi, 
                 SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik,
                 SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd,
                 SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan 
                FROM lap_kunjungan $sisipan
                GROUP BY provinsi
                HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0")->getResultArray();

                    $total_kunjungan = 0;
                    $total_igd = 0;
                    $total_poliklinik = 0;
                    foreach($query as $tot) {
                        $total_kunjungan += $tot['total_kunjungan'];
                        $total_poliklinik += $tot['total_poliklinik'];
                        $total_igd += $tot['total_igd'];
                    }
        
                    $sub = [
                        'total_kunjungan' => $total_kunjungan,
                        'total_igd' => $total_igd,
                        'total_poliklinik' => $total_poliklinik,
                    ];
                    $hasil = [
                'array' => $query,
                'sub' => $sub
            ];
            return $hasil;
        } elseif ($kategori == 'kabupaten'){
            if($tgl_awal != ''){
                $sisipan = "WHERE daftar >= '$tgl_awal' AND daftar <= '$tgl_akhir'";  
            }
            $query = $this->db->query("SELECT provinsi, kabupaten, 
                SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan 
                FROM lap_kunjungan $sisipan
                GROUP BY provinsi, kabupaten
                HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0")->getResultArray();

                $total_kunjungan = 0;
                $total_igd = 0;
                $total_poliklinik = 0;
                foreach($query as $tot) {
                    $total_kunjungan += $tot['total_kunjungan'];
                    $total_poliklinik += $tot['total_poliklinik'];
                    $total_igd += $tot['total_igd'];
                }
    
                $sub = [
                    'total_kunjungan' => $total_kunjungan,
                    'total_igd' => $total_igd,
                    'total_poliklinik' => $total_poliklinik,
                ];
                $hasil = [
            'array' => $query,
            'sub' => $sub
        ];
        return $hasil;
        } elseif ($kategori == 'kecamatan'){
            $query = $this->db->query("
            SELECT Kelurahan, Kecamatan, Kabupaten,
                SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan
            FROM lap_kunjungan
            WHERE Kabupaten = '$namaKabupaten' 
                AND Provinsi = '$namaProvinsi' $sisipan
            GROUP BY provinsi, kabupaten, kecamatan, kelurahan
            HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0
                    ")->getResultArray();
                $total_kunjungan = 0;
                $total_igd = 0;
                $total_poliklinik = 0;
                foreach($query as $tot) {
                    $total_kunjungan += $tot['total_kunjungan'];
                    $total_poliklinik += $tot['total_poliklinik'];
                    $total_igd += $tot['total_igd'];
                }
    
                $sub = [
                    'total_kunjungan' => $total_kunjungan,
                    'total_igd' => $total_igd,
                    'total_poliklinik' => $total_poliklinik,
                ];
                $hasil = [
            'array' => $query,
            'sub' => $sub
        ];
        return $hasil;
    } elseif ($kategori == 'kelurahan'){
            $query = $this->db->query("
            SELECT Kelurahan, Kecamatan, Kabupaten,
                SUM(CASE WHEN jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_poliklinik, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' THEN 1 ELSE 0 END) AS total_igd, 
                SUM(CASE WHEN jenis_pendaftaran = 'IGD' OR jenis_pendaftaran = 'Poliklinik' THEN 1 ELSE 0 END) AS total_kunjungan
            FROM lap_kunjungan
            WHERE Kabupaten = '$namaKabupaten' 
                AND Provinsi = '$namaProvinsi' $sisipan
            GROUP BY provinsi, kabupaten, kecamatan, kelurahan
            HAVING total_poliklinik > 0 OR total_igd > 0 OR total_kunjungan > 0
                    ")->getResultArray();
                    $total_kunjungan = 0;
                    $total_igd = 0;
                    $total_poliklinik = 0;
                    foreach($query as $tot) {
                        $total_kunjungan += $tot['total_kunjungan'];
                        $total_poliklinik += $tot['total_poliklinik'];
                        $total_igd += $tot['total_igd'];
                    }

                    $sub = [
                        'total_kunjungan' => $total_kunjungan,
                        'total_igd' => $total_igd,
                        'total_poliklinik' => $total_poliklinik
                    ];
                    $hasil = [
                'array' => $query,
                'sub' => $sub
            ];
            return $hasil;
    }
}
}
