<?php

namespace App\Models;

// ==================================================
// BAGIAN 1: IMPORT DAN DEPENDENSI
// ==================================================

use Illuminate\Database\Eloquent\Model;

// ==================================================
// BAGIAN 2: MODEL PEGAWAI
// ==================================================

class Pegawai extends Model
{
    // ==================================================
    // BAGIAN 3: KONFIGURASI TABEL
    // ==================================================

    protected $table = 'pegawai';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    // ==================================================
    // BAGIAN 4: ATRIBUT YANG DIIZINKAN
    // ==================================================

    protected $fillable = [
        'nama_pegawai',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'tanggal_lahir',
    ];

    // ==================================================
    // BAGIAN 5: KONVERSI TIPE DATA
    // ==================================================

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }
}
