<?php

namespace App\Http\Controllers;

// ==================================================
// BAGIAN 1: IMPORT DAN DEPENDENSI
// ==================================================

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

// ==================================================
// BAGIAN 2: CONTROLLER PEGAWAI
// ==================================================

class PegawaiController extends Controller
{
    // ==================================================
    // BAGIAN 3: MENAMPILKAN DAFTAR PEGAWAI
    // ==================================================

    public function index(): View
    {
        $pegawai = Pegawai::orderBy('id', 'desc')->get();

        return view('pegawai.index', [
            'pegawai' => $pegawai,
        ]);
    }

    // ==================================================
    // BAGIAN 4: MENAMPILKAN FORM TAMBAH
    // ==================================================

    public function create(): View
    {
        return view('pegawai.create');
    }

    // ==================================================
    // BAGIAN 5: MENYIMPAN DATA PEGAWAI
    // ==================================================

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pegawai' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'pendidikan_terakhir' => [
                'required',
                'in:SD,SMP,SMA/SMK,D1,D2,D3,D4/S1,S2,S3',
            ],
            'tanggal_lahir' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
        ], [
            'nama_pegawai.required' => 'Nama pegawai wajib diisi.',
            'nama_pegawai.max' => 'Nama pegawai maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib dipilih.',
            'pendidikan_terakhir.in' => 'Pilihan pendidikan tidak valid.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
        ]);

        Pegawai::create($validated);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    // ==================================================
    // BAGIAN 6: MENAMPILKAN FORM EDIT
    // ==================================================

    public function edit(Pegawai $pegawai): View
    {
        return view('pegawai.edit', [
            'pegawai' => $pegawai,
        ]);
    }

    // ==================================================
    // BAGIAN 7: MEMPERBARUI DATA PEGAWAI
    // ==================================================

    public function update(Request $request, Pegawai $pegawai): RedirectResponse
    {
        // Validasi data yang dikirim dari formulir edit.
        $validated = $request->validate([
            'nama_pegawai' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'pendidikan_terakhir' => [
                'required',
                'in:SD,SMP,SMA/SMK,D1,D2,D3,D4/S1,S2,S3',
            ],
            'tanggal_lahir' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
        ], [
            'nama_pegawai.required' => 'Nama pegawai wajib diisi.',
            'nama_pegawai.max' => 'Nama pegawai maksimal 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib dipilih.',
            'pendidikan_terakhir.in' => 'Pilihan pendidikan tidak valid.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
        ]);

        // Memperbarui data pegawai yang dipilih.
        $pegawai->update($validated);

        return redirect()
            ->route('pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }
    // ==================================================
    // BAGIAN 8: MENGHAPUS DATA PEGAWAI
    // ==================================================

    public function destroy(Pegawai $pegawai): RedirectResponse
    {
    // Menghapus data pegawai berdasarkan ID.
    $pegawai->delete();
    
    return redirect()
        ->route('pegawai.index')
        ->with('success', 'Data pegawai berhasil dihapus.');
    }
}
