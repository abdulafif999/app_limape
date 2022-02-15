<?php
namespace App\Repository;

use App\Models\Penilaian;

class Penilaians{

        const CACHE_KEY = 'Penilaians';
        public function all($orderBy){
            return Penilaian::orderBy($orderBy)->get();
        }
        public function get($id){

        }
        public function getCacheKey($key){
            $key = strtoupper($key);
            return self::CACHE_KEY.".$key.";
        }
    }
?>