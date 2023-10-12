<?php

namespace App\Controllers;
use App\Models\KunjunganModel;
use App\Models\Daerah;

class Home extends BaseController
{
    public function index(){
         return view('pasien');
    }
    
    public function pencarian()
    {
        // Inisialisasi variabel
        $kategori = $this->request->getPost('kategori');
        $tgl_awal = $this->request->getPost('tgl_awal');
        $tgl_akhir = $this->request->getPost('tgl_akhir');
        $inputdaerah = $this->request->getPost('inputdaerah');

        if (!empty($inputdaerah)) {
            // Parsing nilai menjadi array
            $nilaiArray = explode(", ", $dataDaerah);

            $namaKabupaten = $nilaiArray[0];
            $namaProvinsi = $nilaiArray[1];
        }
        // Inisialisasi model
        $kunjungan = new KunjunganModel();
        $daerahdb = new Daerah();

        // Cek apakah ada filter pencarian yang diterapkan
        if ($kategori || $tgl_awal || $tgl_akhir || $inputdaerah) {
            $result = $kunjungan->getFilter($kategori, $tgl_awal, $tgl_akhir, $namaKabupaten, $namaProvinsi);
        } else {
            $result = $kunjungan->getFilter();
        }

        // Ambil data daerah
        $daerah = $daerahdb->getKabProv();

        // Tampilkan data ke view
        return view('kunjungan1', ['data' => $result, 'daerah' => $daerah]);
    }
    }

    // public function pencarian($tgl_awal = '', $tgl_akhir='', $kategori ='provinsi', $inputdaerah = null)
    // {
    //     if($this->request->getPost('kategori')) {
    //         $kategori = $this->request->getPost('kategori');
    //         $tgl_awal = $this->request->getPost('tgl_awal');
    //         $tgl_akhir = $this->request->getPost('$tgl_akhir');
    //         $inputdaerah = $this->request->getPost('inputdaerah');
    //         dd($kategori);
    //     }

    //     $kunjungan = new KunjunganModel();
    //     $daerahdb = new Daerah();
    //     $result = $kunjungan->getDataByKabupaten('Banjarnegara');
    //     $daerah = $daerahdb->getKabProv();
    //     return view('kunjungan', ['data' => $result, 'daerah' => $daerah]  );
    // }
