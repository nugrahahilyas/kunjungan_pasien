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
  <script>
    // Fungsi untuk mendapatkan tanggal hari ini dalam format "YYYY-MM-DD"
    function getTodayDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena Januari dimulai dari 0
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Set nilai awal input date saat halaman pertama kali dibuka
    document.addEventListener('DOMContentLoaded', function () {
        const tgl_awal = document.getElementById('tgl_awal');
        const tgl_akhir = document.getElementById('tgl_akhir');
        if (tgl_awal) {
            tgl_akhir.value = getTodayDate();
            tgl_awal.value = '2023-01-01';
        }
    });
</script>

  <body>
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
    <div class="container d-flex justify-content-center mt-5 pt-5">

        <div class="card w-50 ">
            <div class="card-body">
                <h5 class="card-title text-center">Parameter Pencarian</h5>
                <div class="row mt-5">
                    <div class="col-md-2">
                    <label for="tipe" class="form-label">Tipe</label>
                    </div>   
                    <div class="col-md-10">
                        <select class="form-select" id="tipe" aria-label="Default select example">
                            <option selected>Pilih</option>
                            <option value="Harian">Harian</option>
                            <option value="Bulanan">Bulanan</option>
                            <option value="Tahunan">Tahunan</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    </div>   
                    <div class="col-md-5">
                        <input class="form-control" id="tgl_awal" type="date" name="tgl_awal">
                    </div>
                    <div class="col-md-5">
                        <input class="form-control" type="date" id="tgl_akhir" name="tgl_akhir">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                    <label for="kategori" class="form-label">Kategori</label>
                    </div>   
                    <div class="col-md-10">
                        <select class="form-select" id="kategori">
                            <option selected>Kategori</option>
                            <option value="Harian">Harian</option>
                            <option value="Bulanan">Bulanan</option>
                            <option value="Tahunan">Tahunan</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                    <label for="kabupaten" class="form-label">Kabupaten</label>
                    </div>   
                    <div class="col-md-10">
                        <select class="form-select" id="kabupaten">
                            <option selected>Kategori</option>
                            <option value="subang">Subang</option>
                            <option value="banjarnegara">Banjarnegara</option>
                            <option value="sleman">Sleman</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <a href="#" class="btn btn-primary px-5 py-2 float-end">Cari</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>