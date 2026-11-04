<?php

namespace App\Models;

// ==================================================
// BAGIAN 1: IMPORT DAN DEPENDENSI
// ==================================================

use Illuminate\Foundation\Auth\User as Authenticatable;

// ==================================================
// BAGIAN 2: MODEL ADMIN
// ==================================================

class Admin extends Authenticatable
{
    // ==================================================
    // BAGIAN 3: KONFIGURASI TABEL
    // ==================================================

    protected $table = 'admin';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    // ==================================================
    // BAGIAN 4: KEAMANAN ATRIBUT
    // ==================================================

    protected $fillable = [
        'username',
    ];

    protected $hidden = [
        'password_hash',
    ];

    // ==================================================
    // BAGIAN 5: AUTENTIKASI
    // ==================================================

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }
}
