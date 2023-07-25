<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;
    protected $table = 'tb_mahasiswa';
    protected $fillable = [
        'id' , 'nama' , 'created_at' , 'updated_at'
    ];
}
