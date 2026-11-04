@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')

    {{-- ==================================================
         BAGIAN 1: JUDUL HALAMAN
         ================================================== --}}

    <div class="mb-4">
        <h1 class="h3 fw-bold text-brand-dark">
            Edit Data Pegawai
        </h1>

        <p class="text-secondary mb-0">
            Perbarui informasi pegawai yang dipilih.
        </p>
    </div>

    {{-- ==================================================
         BAGIAN 2: FORMULIR EDIT
         ================================================== --}}

    <div class="content-card">

        <form action="{{ route('pegawai.update', $pegawai->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            {{-- NAMA PEGAWAI --}}

            <div class="mb-3">

                <label for="nama_pegawai" class="form-label fw-semibold">
                    Nama Pegawai
                </label>

                <input
                    type="text"
                    id="nama_pegawai"
                    name="nama_pegawai"
                    class="form-control @error('nama_pegawai') is-invalid @enderror"
                    value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}"
                    maxlength="100"
                    required
                >

                @error('nama_pegawai')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- JENIS KELAMIN --}}

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Jenis Kelamin
                </label>

                <div class="d-flex flex-wrap gap-4">

                    <div class="form-check">

                        <input
                            type="radio"
                            id="laki_laki"
                            name="jenis_kelamin"
                            value="Laki-laki"
                            class="form-check-input"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}
                            required
                        >

                        <label for="laki_laki" class="form-check-label">
                            Laki-laki
                        </label>

                    </div>

                    <div class="form-check">

                        <input
                            type="radio"
                            id="perempuan"
                            name="jenis_kelamin"
                            value="Perempuan"
                            class="form-check-input"
                            {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}
                        >

                        <label for="perempuan" class="form-check-label">
                            Perempuan
                        </label>

                    </div>

                </div>

                @error('jenis_kelamin')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- PENDIDIKAN TERAKHIR --}}

            <div class="mb-3">

                <label for="pendidikan_terakhir"
                       class="form-label fw-semibold">
                    Pendidikan Terakhir
                </label>

                <select
                    id="pendidikan_terakhir"
                    name="pendidikan_terakhir"
                    class="form-select @error('pendidikan_terakhir') is-invalid @enderror"
                    required
                >

                    <option value="">-- Pilih Pendidikan --</option>

                    @foreach (['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $pendidikan)

                        <option
                            value="{{ $pendidikan }}"
                            {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) == $pendidikan ? 'selected' : '' }}
                        >
                            {{ $pendidikan }}
                        </option>

                    @endforeach

                </select>

                @error('pendidikan_terakhir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- TANGGAL LAHIR --}}

            <div class="mb-4">

                <label for="tanggal_lahir" class="form-label fw-semibold">
                    Tanggal Lahir
                </label>

                <input
                    type="date"
                    id="tanggal_lahir"
                    name="tanggal_lahir"
                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                    value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir->format('Y-m-d')) }}"
                    max="{{ date('Y-m-d') }}"
                    required
                >

                @error('tanggal_lahir')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- TOMBOL FORMULIR --}}

            <div class="d-flex flex-wrap gap-2">

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('pegawai.index') }}"
                   class="btn btn-outline-secondary">
                    Batal
                </a>

            </div>

        </form>

    </div>

@endsection
