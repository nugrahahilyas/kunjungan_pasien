<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Halaman Bisnis Intelegence</title>
    <script src="https://kit.fontawesome.com/d73b9b9954.js" crossorigin="anonymous"></script>
  </head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
    function getTodayDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    $('#daerahSelect').selectpicker();
    $('#optionheh').hide();

        // Menangani peristiwa input dari elemen pencarian
        $('#inputCari').on('input', function() {
            var searchText = $(this).val();
            $('#daerahSelect').selectpicker('refresh'); // Refresh Bootstrap Select
            $('#daerahSelect').selectpicker('val', ''); // Reset nilai select
            $('#daerahSelect option').each(function() {
                if ($(this).text().toLowerCase().includes(searchText.toLowerCase())) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#daerahSelect').selectpicker('refresh');
        });

    function setTanggalPerPilihan() {
        var tipe = $("#tipe").val();

        if (tipe === "Harian") {
            $("#tgl_awal").val("");
            $("#tgl_akhir").show();
            $('#panah').show();
            $("#tgl_akhir").val(getTodayDate());
            $("#tgl_awal").replaceWith('<input class="form-control" id="tgl_awal" type="date" name="tgl_awal">');
        } else if (tipe === "Bulanan") {
            $("#tgl_akhir").val("");
            $("#panah").hide();
            $("#tgl_akhir").hide();
            $("#tgl_awal").replaceWith('<input class="form-control" id="tgl_awal" type="month" name="tgl_awal">');
        } else if (tipe === "Tahunan") {
            var currentYear = new Date().getFullYear();
            var yearOptions = '';
            for (var i = currentYear; i >= currentYear - 10; i--) {
                yearOptions += `<option value="${i}">${i}</option>`;
            }
            $("#tgl_awal").replaceWith(`<select class="form-select" id="tgl_awal" name="tgl_awal">${yearOptions}</select>`);
            $("#tgl_akhir").val("");
            $("#panah").hide();
            $("#tgl_akhir").hide();
        } else {
            $("#tgl_akhir").show();
        }
    }

    function tampilKab() {
        var kategori = $("#kategori").val();

        if (kategori === "provinsi" || kategori === "kabupaten") {
            $("#kolomkab").hide();
        } else if (kategori === "kecamatan" || kategori === "kelurahan") {
            $("#kolomkab").show();
        }
    }

    $("#tipe").change(function() {
        setTanggalPerPilihan();
    });

    $("#kategori").change(function() {
        tampilKab();
    });

    $('#optionheh').hide();
    $("#kolomkab").hide();
    setTanggalPerPilihan();
    $('#tgl_akhir').val(getTodayDate());
});
</script>
  <body>

    <!-- NAVBAR  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand text-center" href="#">RS Bhayangkara Banjarnegara</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Pasien</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pencarian</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>  

    <!-- BUTTON CARI  -->
    <div class="container mt-5">
        <button type="button" class="btn btn-primary ps-4 pe-4" data-bs-toggle="modal" data-bs-target="#modalcari"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i>  Cari Data</button>
    </div>
    <!-- MODAL CARI  -->
    <div class="modal fade" id="modalcari" tabindex="-1" aria-labelledby="modalcariLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalcariLabel"><i class="fa-solid fa-magnifying-glass" style="color: #000;"></i> Cari Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="http://localhost:8080/" method="post">
                    <div class="row">
                        <div class="col-md-2">
                        <label for="tipe" class="form-label">Tipe</label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-select" id="tipe" name="tipe" aria-label="Default select example">
                                <option selected>Pilih</option>
                                <option value="Harian">Harian</option>
                                <option value="Bulanan">Bulanan</option>
                                <option value="Tahunan">Tahunan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-2">
                        <label for="tipe" class="form-label">Tanggal</label>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" id="tgl_awal" type="date" name="tgl_awal">
                        </div>
                        <div class="col-md-1" id="panah">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" id="tgl_akhir" type="date" name="tgl_akhir">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-2">
                        <label for="kategori" class="form-label">Kategori</label>
                        </div>
                        <div class="col-md-9">
                        <select class="form-select" id="kategori" name="kategori" aria-label="Default select example">
                                <option selected>Pilih</option>
                                <option value="provinsi">Provinsi</option>
                                <option value="kabupaten">Kabupaten</option>
                                <option value="kecamatan">Kecamatan</option>
                                <option value="kelurahan">Kelurahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4" id="kolomkab">
                        <div class="col-md-2">
                        <label for="tipe" class="form-label">Kabupaten</label>
                        </div>
                        <div class="col-md-9">
                            <select id="daerahSelect" class="selectpicker form-control" data-live-search="true" data-style="btn-secondary" name="inputdaerah">
                                <!-- <option id="optionheh" selected>Pilih</option> -->
                                <?php foreach($daerah as $d) : ?>
                                    <option class="form-control" value="<?= $d->nama_kabupaten; ?>, <?= $d->nama_provinsi; ?>">
                                        <?= $d->nama_kabupaten; ?>, <?= $d->nama_provinsi; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-ban"></i> Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i> Cari Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- JUDUL HALAMAN -->
    <div class="container">
        <p class="text-center">
            <strong>
                Laporan Kunjungan Rawat Jalan per Provinsi
            </strong>
        </p>
<?php //dd($data); ?>
        <!-- BUNGKUS KONTENT  -->
        <div class="row row-cols-2 d-flex flex-fill justify-content-around">
            <!-- CARD SUMMARY  -->
            <?php $kecamatanTerakhir = ''; ?>
            <?php 
            $total_poliklinik = 0;
            $total_igd = 0;
            $total_kunjungan = 0;
            ?>
            <div class="col d-flex">
                <div class="card m-2 float-end" style="width: 40rem;">
                    <div class="card-header alert-warning" role="alert">
                        <i class="fa-solid fa-sheet-plastic" style="color: #665e00;"></i>  Summary
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-2 d-flex justify-content-around">
                            <div class="col-md-5">
                                <table class="table">
                                    <thead class="table-secondary">
                                        <th>Area</th>
                                        <th>Persentase</th>
                                    </thead>
                                        <tr>
                                            <?php foreach(data['area'] as $area) ?>
                                            <td><?= $area; ?></td>
                                            <td><?= $data['persentase_ind']; ?></td>
                                        </tr>
                                        <?php die; ?>
                                    <?php foreach($data['result'] as $wilayah => $jumlah) : ?>
                                    <tr>
                                        <?php if(isset($jumlah['kabupaten'])) : ?>
                                        <td><?= $jumlah['kabupaten']; ?></td>
                                        <?php elseif(isset($jumlah['kecamatan'])) : ?>
                                        <td><?= $jumlah['kecamatan']; ?></td>
                                        <?php elseif(isset($jumlah['provinsi'])) : ?>
                                        <?php endif; ?>
                                        <td><?= $jumlah['total_kunjungan']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <table class="table">
                                    <thead class="table-secondary">
                                        <th>Area</th>
                                        <th>Persentase</th>
                                    </thead>
                                    <?php  ?>
                                    <?php foreach($data['result'] as $wilayah => $jumlah) : ?>
                                    <tr>
                                        <?php if(isset($jumlah['kabupaten'])) : ?>
                                        <td><?= $jumlah['kabupaten']; ?></td>
                                        <?php elseif(isset($jumlah['kecamatan'])) : ?>
                                        <td><?= $jumlah['kecamatan']; ?></td>
                                        <?php elseif(isset($jumlah['provinsi'])) : ?>
                                        <td><?= $jumlah['provinsi']; ?></td>
                                        <?php endif; ?>
                                        <td><?= $jumlah['total_kunjungan']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <div class="col-md-5">
                            </div>
                        </div>
                        <?php die; ?>
                        <!-- PENUTUP CARD BODI  -->
                    </div>
                    <!-- PENUTUP CARD -->
                </div>
                <!-- PENUTUP COL  -->
            </div>
            <!-- CARD DATA ARRAY PERWILAYAH -->
            <?php $i = 0; ?>
            <?php foreach($data as $wilayah => $value) : ?>
            <div class="col d-flex">
                <div class="card col d-flex flex-fill m-2" style="width: 40rem;">
                    <div class="card-header alert-success" role="alert">
                        <i class="fa-solid fa-location-dot" style="color: #1d5101;"></i> 
                         <?php if(isset($value['kecamatan'])) {
                            echo $value['kecamatan'];
                        } elseif (isset($value['kabupaten'])){
                             echo $value['kabupaten'];
                            } elseif (isset($value['provinsi'])){
                             echo $value['provinsi'];
                         } ?>
                    </div>
                    <div class="card-body">
                        <table class="table m-2">
                            <thead class="table-secondary">
                                <th>No</th>
                                <th><?php if(isset($value['provinsi'])) { echo "Provinsi";} elseif (isset($value['kabupaten'])) {echo "Kab / Kota";} elseif (isset($value['provinsi'])) {echo "Provinsi";} ?></th>
                                <th>Poliklinik</th>
                                <th>IGD</th>
                                <th>Total Kunjungan</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $i + 1; ?></td>
                                    <td><?php if(isset($value['provinsi'])) { echo $value["provinsi"];} elseif (isset($value['kabupaten'])) {echo $value['kabupaten'];} elseif (isset($value['kecamatan'])) {echo $value['kecamatan'];} ?></td>
                                    <td><?= $value['total_poliklinik']; ?></td>
                                    <td><?= $value['total_igd']; ?></td>
                                    <td><?= $value['total_kunjungan']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <!-- PENUTUP CARD BODI -->
                    </div>
                <!-- PENUTUP CARD -->
                </div>
            <!-- PENUTUP COL -->
            </div>
            <?php endforeach; ?>
        <!-- PENUTUP ROW -->
        </div> 
    <!-- PENUTUP KONTAINER -->
    </div> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
</body>
</html>
