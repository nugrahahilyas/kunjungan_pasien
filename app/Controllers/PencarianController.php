<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LapKunjunganModel;
use App\Models\Daerah;

class PencarianController extends BaseController
{
    public function index()
    {
        $namaKabupaten = '';
        $namaProvinsi = '';
        $tgl_awal = '';
        $tgl_akhir = '';
        if(isset($_POST['tgl_awal']) || isset($_POST['tgl_akhir'])){
            $tgl_awal = $this->request->getPost('tgl_awal');
            $tgl_akhir = $this->request->getPost('tgl_akhir');
        }

        if(isset($_POST['kategori'])){
            $kategori = $this->request->getPost('kategori');
            $inputdaerah = '';
            if(isset($_POST['inputdaerah'])){
                $inputdaerah = $this->request->getPost('inputdaerah');
                $nilaiArray = explode(", ", $inputdaerah);
                $namaKabupaten = $nilaiArray[0];
                $namaProvinsi = $nilaiArray[1];
            }
        }
        else {
            $kategori = 'provinsi';
        }

        $daerahdb = new Daerah();
        $kunjungan = new LapKunjunganModel();

            $summary = $kunjungan->getSummary($kategori, $namaProvinsi, $namaKabupaten, $tgl_awal, $tgl_akhir);
            $arrayperwilayah = $kunjungan->getDataArray($kategori, $namaKabupaten, $namaProvinsi, $tgl_awal, $tgl_akhir );

        // Ambil data daerah
        $daerah = $daerahdb->getKabProv();
        
        // Tampilkan data ke view
        return view('kunjungan3', ['summary' => $summary, 'daerah' => $daerah, 'arrayperwilayah' => $arrayperwilayah, 'kategori' => $kategori, 'namaKabupaten' => $namaKabupaten, 'namaProvinsi' => $namaProvinsi, 'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir]);
    }
}
