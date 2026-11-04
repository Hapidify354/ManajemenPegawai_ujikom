<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pegawai = Pegawai::all();

        $totalPegawai = $pegawai->count();

        // 1. DATA JENIS KELAMIN
        $jumlahLakiLaki = $pegawai->where('jenis_kelamin', 'Laki-laki')->count();
        $jumlahPerempuan = $pegawai->where('jenis_kelamin', 'Perempuan')->count();
        $dataJenisKelamin = [$jumlahLakiLaki, $jumlahPerempuan];

        // 2. DATA PENDIDIKAN
        $daftarPendidikan = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'];
        $dataPendidikan = [];
        foreach ($daftarPendidikan as $pendidikan) {
            $dataPendidikan[] = $pegawai->where('pendidikan_terakhir', $pendidikan)->count();
        }

        // 3. DATA KELOMPOK USIA
        $kelompokUsia = [
            'Di bawah 25 tahun' => 0,
            '25–34 tahun' => 0,
            '35–44 tahun' => 0,
            '45–54 tahun' => 0,
            '55 tahun ke atas' => 0,
        ];

        foreach ($pegawai as $item) {
            $usia = $item->tanggal_lahir->age;

            if ($usia < 25) {
                $kelompokUsia['Di bawah 25 tahun']++;
            } elseif ($usia <= 34) {
                $kelompokUsia['25–34 tahun']++;
            } elseif ($usia <= 44) {
                $kelompokUsia['35–44 tahun']++;
            } elseif ($usia <= 54) {
                $kelompokUsia['45–54 tahun']++;
            } else {
                $kelompokUsia['55 tahun ke atas']++;
            }
        }

        // 4. DATA MENTAH UNTUK INTERAKSI CROSS-FILTERING JAVASCRIPT
        $rawPegawai = $pegawai->map(function ($item) {
            return [
                'jenis_kelamin' => $item->jenis_kelamin,
                'pendidikan_terakhir' => $item->pendidikan_terakhir,
                'usia' => $item->tanggal_lahir->age,
            ];
        });

        return view('dashboard', [
            'totalPegawai' => $totalPegawai,
            'labelJenisKelamin' => ['Laki-laki', 'Perempuan'],
            'dataJenisKelamin' => $dataJenisKelamin,
            'labelPendidikan' => $daftarPendidikan,
            'dataPendidikan' => $dataPendidikan,
            'labelUsia' => array_keys($kelompokUsia),
            'dataUsia' => array_values($kelompokUsia),
            'rawPegawai' => $rawPegawai,
        ]);
    }
}