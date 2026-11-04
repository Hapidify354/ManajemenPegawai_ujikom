@extends('layouts.app')

@section('title', 'Pusat Data Pegawai')

@section('content')

    {{-- ==================================================
         BAGIAN 1: JUDUL DAN TOMBOL TAMBAH
         ================================================== --}}

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h1 class="h3 fw-bold text-brand-dark mb-1">
                Pusat Data Pegawai
            </h1>

            <p class="text-secondary mb-0">
                Kelola dan perbarui data seluruh pegawai
            </p>
        </div>

        <a href="{{ route('pegawai.create') }}" class="btn btn-primary">
            + Tambah Pegawai
        </a>

    </div>

    {{-- ==================================================
         BAGIAN 2: PESAN STATUS
         ================================================== --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup">
            </button>

        </div>
    @endif

    {{-- ==================================================
         BAGIAN 3: TABEL DATA PEGAWAI
         ================================================== --}}

    <div class="content-card">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h2 class="h5 fw-semibold text-brand-dark mb-0">
                Daftar Pegawai
            </h2>

            <span class="badge text-bg-primary">
                {{ $pegawai->count() }} Pegawai
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                {{-- HEADER TABEL (DIBUAT RATA TENGAH UNTUK KOLOM TERTENTU) --}}
<thead class="table-light">
    <tr>
        <th scope="col" class="text-center" style="width: 60px;">No.</th>
        <th scope="col" class="text-start">Nama Pegawai</th>
        <th scope="col" class="text-center">Jenis Kelamin</th>
        <th scope="col" class="text-center">Pendidikan</th>
        <th scope="col" class="text-center">Tanggal Lahir</th>
        <th scope="col" class="text-center">Usia</th>
        <th scope="col" class="text-center" style="width: 170px;">Aksi</th>
    </tr>
</thead>

{{-- ISI TABEL --}}
<tbody>
    @forelse ($pegawai as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td class="text-start fw-semibold">{{ $item->nama_pegawai }}</td>
            <td class="text-center">{{ $item->jenis_kelamin }}</td>
            <td class="text-center">{{ $item->pendidikan_terakhir }}</td>
            <td class="text-center">{{ $item->tanggal_lahir->format('d-m-Y') }}</td>
            <td class="text-center">{{ $item->tanggal_lahir->age }} tahun</td>
            
            {{-- TOMBOL AKSI DENGAN IKON & RATA TENGAH --}}
            <td class="text-center">
                <div class="d-flex justify-content-center gap-1">
                    {{-- TOMBOL EDIT --}}
                    <a href="{{ route('pegawai.edit', $item->id) }}"
                       class="btn btn-sm btn-primary px-2 py-1 fs-7">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>

                    {{-- TOMBOL HAPUS --}}
                    <button type="button"
                            class="btn btn-sm btn-danger px-2 py-1 fs-7"
                            data-bs-toggle="modal"
                            data-bs-target="#modalHapus"
                            data-url="{{ route('pegawai.destroy', $item->id) }}"
                            data-nama="{{ $item->nama_pegawai }}">
                        <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-5">
                <h3 class="h6 fw-semibold text-brand-dark">Belum Ada Data Pegawai</h3>
                <p class="text-secondary mb-0">Belum ada informasi pegawai yang tersimpan.</p>
            </td>
        </tr>
    @endforelse
    
</tbody>

            </table>

        </div>

    </div>
    
    {{-- ==================================================
         BAGIAN 4: MODAL KONFIRMASI HAPUS
         ================================================== --}}

    <div class="modal fade" id="modalHapus" tabindex="-1"
         aria-labelledby="judulModalHapus" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow">

                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-brand-dark" id="judulModalHapus">
                        Konfirmasi Hapus
                    </h5>

                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup">
                    </button>
                </div>

                <div class="modal-body text-center py-4">

                    <div class="mb-3">
                        <span class="text-danger fs-1">
                            <i class="bi bi-exclamation-circle"></i>
                        </span>
                    </div>

                    <p class="mb-2">
                        APAKAH KAMU YAKIN INGIN MENGHAPUS PEGAWAI INI?
                    </p>

                    <h5 class="fw-bold text-brand-dark" id="namaPegawaiHapus">
                    </h5>

                    <p class="text-secondary small mb-0">
                        DATA YANG TELAH DIHAPUS TIDAK DAPAT DIKEMBALIKAN.
                    </p>

                </div>

                <div class="modal-footer border-0 justify-content-center">

                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <form id="formHapus" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Ya, Hapus Data
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection

{{-- ==================================================
     BAGIAN 5: JAVASCRIPT MODAL HAPUS
     ================================================== --}}

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalHapus = document.getElementById('modalHapus');
        
        if (modalHapus) {
            modalHapus.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const url = button.getAttribute('data-url');
                const nama = button.getAttribute('data-nama');

                const formHapus = modalHapus.querySelector('#formHapus');
                const namaPegawaiHapus = modalHapus.querySelector('#namaPegawaiHapus');

                formHapus.action = url;
                namaPegawaiHapus.textContent = nama;
            });
        }
    });
</script>
@endpush