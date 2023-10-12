<?php

namespace App\Models;

use CodeIgniter\Model;

class Daerah extends Model
{
    protected $table            = 'daerah';
    public function getKabProv() {
        $query = $this->db->query("SELECT DISTINCT nama_kabupaten, nama_provinsi FROM daerah");
        
        return $query->getResult(); 
    }
    
    
}
