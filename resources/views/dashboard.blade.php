@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- ================================================
         BAGIAN 1: JUDUL DASHBOARD & INDIKATOR FILTER
         ================================================ --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold text-brand-dark mb-1">
                Dashboard Informasi Pegawai
            </h1>

            <p class="text-secondary mb-0">
                Visualisasi dan ringkasan demografi pegawai
            </p>
        </div>

        {{-- BADGE INDIKATOR FILTER AKTIF --}}
        <div id="filterStatusContainer" style="display: none;">
            <div class="badge bg-primary text-white px-3 py-2 fs-6 shadow-sm d-flex align-items-center gap-2">
                <span>Filter: <strong id="filterStatusText"></strong></span>
                <button type="button" class="btn-close btn-close-white" style="font-size: 0.65rem;" onclick="resetFilter()" title="Reset Filter"></button>
            </div>
        </div>
    </div>


    {{-- ================================================
         BAGIAN 2: KARTU TOTAL PEGAWAI
         ================================================ --}}

    <div class="row g-4">

        <div class="col-12 col-md-6 col-xl-4">

            <section class="content-card h-100">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-secondary mb-2">
                            Total Pegawai
                        </p>

                        <div class="stat-value">
                            {{ $totalPegawai }}
                        </div>

                        <p class="small text-secondary mb-0">
                            Pegawai terdaftar
                        </p>
                    </div>

                    <div class="rounded-3 p-3" style="background: #eaf1fb; color: #7096D1;">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>

                </div>

            </section>

        </div>

    </div>


    {{-- ================================================
         BAGIAN 3: GRAFIK INTERAKSI (CROSS-FILTERING)
         ================================================ --}}

    <div class="row g-4 mt-1">

        {{-- GRAFIK JENIS KELAMIN --}}
        <div class="col-12 col-lg-5">

            <section class="content-card h-100">

                <h2 class="h5 fw-semibold text-brand-dark mb-1">
                    Jenis Kelamin
                </h2>

                <p class="small text-secondary mb-3">
                    Klik pada diagram untuk memfilter grafik lain.
                </p>

                <div style="height: 280px; position: relative;">
                    <canvas id="grafikJenisKelamin"></canvas>
                </div>

            </section>

        </div>


        {{-- GRAFIK PENDIDIKAN --}}
        <div class="col-12 col-lg-7">

            <section class="content-card h-100">

                <h2 class="h5 fw-semibold text-brand-dark mb-1">
                    Pendidikan Terakhir
                </h2>

                <p class="small text-secondary mb-3">
                    Klik pada batang untuk memfilter grafik lain.
                </p>

                <div style="height: 280px; position: relative;">
                    <canvas id="grafikPendidikan"></canvas>
                </div>

            </section>

        </div>


        {{-- GRAFIK KELOMPOK USIA --}}
        <div class="col-12">

            <section class="content-card">

                <h2 class="h5 fw-semibold text-brand-dark mb-1">
                    Kelompok Usia Pegawai
                </h2>

                <p class="small text-secondary mb-3">
                    Klik pada batang untuk memfilter grafik lain.
                </p>

                <div style="height: 300px; position: relative;">
                    <canvas id="grafikUsia"></canvas>
                </div>

            </section>

        </div>

    </div>

@endsection


{{-- ================================================
     BAGIAN 4: LOGIKA INTERAKTIF JAVASCRIPT
     ================================================ --}}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
    if (typeof Chart !== 'undefined') {

        // DATA MENTAH DARI BACKEND
        const rawPegawai = @json($rawPegawai);

        const labelJenisKelamin = @json($labelJenisKelamin);
        const dataJenisKelamin = @json($dataJenisKelamin);

        const labelPendidikan = @json($labelPendidikan);
        const dataPendidikan = @json($dataPendidikan);

        const labelUsia = @json($labelUsia);
        const dataUsia = @json($dataUsia);

        Chart.defaults.font.family = 'system-ui, -apple-system, "Segoe UI", sans-serif';
        Chart.defaults.color = '#536078';

        // STATE FILTER AKTIF
        let currentFilter = { type: null, value: null };

        // FUNGSI HELPER GRADASI WARNA
        function generateGradation(dataArray, baseRgb = [112, 150, 209]) {
            const maxVal = Math.max(...dataArray, 1);
            return dataArray.map(val => {
                if (val === 0) return 'rgba(226, 232, 240, 0.4)';
                const opacity = 0.35 + ((val / maxVal) * 0.65);
                return `rgba(${baseRgb[0]}, ${baseRgb[1]}, ${baseRgb[2]}, ${opacity.toFixed(2)})`;
            });
        }

        // FUNGSI PENAMBUNGAN KELOMPOK USIA
        function matchUsiaGroup(usia, groupName) {
            if (groupName === 'Di bawah 25 tahun') return usia < 25;
            if (groupName === '25–34 tahun') return usia >= 25 && usia <= 34;
            if (groupName === '35–44 tahun') return usia >= 35 && usia <= 44;
            if (groupName === '45–54 tahun') return usia >= 45 && usia <= 54;
            if (groupName === '55 tahun ke atas') return usia >= 55;
            return false;
        }

        // ==========================================
        // 1. INISIALISASI GRAFIK JENIS KELAMIN
        // ==========================================
        const chartJenisKelamin = new Chart(document.getElementById('grafikJenisKelamin'), {
            type: 'doughnut',
            data: {
                labels: labelJenisKelamin,
                datasets: [{
                    data: dataJenisKelamin,
                    backgroundColor: ['#7096D1', '#E88D96'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20 }
                    }
                },
                onHover: (event, elements) => {
                    event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        applyFilter('jenis_kelamin', labelJenisKelamin[index]);
                    } else {
                        applyFilter(null, null);
                    }
                }
            }
        });

        // ==========================================
        // 2. INISIALISASI GRAFIK PENDIDIKAN
        // ==========================================
        const chartPendidikan = new Chart(document.getElementById('grafikPendidikan'), {
            type: 'bar',
            data: {
                labels: labelPendidikan,
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: dataPendidikan,
                    backgroundColor: generateGradation(dataPendidikan, [112, 150, 209]),
                    borderRadius: 6,
                    maxBarThickness: 38
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                },
                onHover: (event, elements) => {
                    event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        applyFilter('pendidikan_terakhir', labelPendidikan[index]);
                    } else {
                        applyFilter(null, null);
                    }
                }
            }
        });

        // ==========================================
        // 3. INISIALISASI GRAFIK KELOMPOK USIA
        // ==========================================
        const chartUsia = new Chart(document.getElementById('grafikUsia'), {
            type: 'bar',
            data: {
                labels: labelUsia,
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: dataUsia,
                    backgroundColor: generateGradation(dataUsia, [8, 31, 92]),
                    borderRadius: 7,
                    maxBarThickness: 65
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                },
                onHover: (event, elements) => {
                    event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
                },
                onClick: (event, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;
                        applyFilter('usia', labelUsia[index]);
                    } else {
                        applyFilter(null, null);
                    }
                }
            }
        });

        // ==========================================
        // LOGIKA PENERAPAN FILTER INTERAKTIF
        // ==========================================
        function applyFilter(type, value) {
            // Jika memilih filter yang sama, maka toggle matikan filter (reset)
            if (currentFilter.type === type && currentFilter.value === value) {
                currentFilter = { type: null, value: null };
            } else {
                currentFilter = { type: type, value: value };
            }

            // Update Tampilan Badge Status Filter
            const statusContainer = document.getElementById('filterStatusContainer');
            const statusText = document.getElementById('filterStatusText');

            if (currentFilter.type) {
                const labelMap = {
                    'jenis_kelamin': 'Jenis Kelamin',
                    'pendidikan_terakhir': 'Pendidikan',
                    'usia': 'Usia'
                };
                statusText.textContent = `${labelMap[currentFilter.type]}: ${currentFilter.value}`;
                statusContainer.style.display = 'block';
            } else {
                statusContainer.style.display = 'none';
            }

            // Filter Data Pegawai Berdasarkan Filter Aktif
            let filteredList = rawPegawai;
            if (currentFilter.type === 'jenis_kelamin') {
                filteredList = rawPegawai.filter(item => item.jenis_kelamin === currentFilter.value);
            } else if (currentFilter.type === 'pendidikan_terakhir') {
                filteredList = rawPegawai.filter(item => item.pendidikan_terakhir === currentFilter.value);
            } else if (currentFilter.type === 'usia') {
                filteredList = rawPegawai.filter(item => matchUsiaGroup(item.usia, currentFilter.value));
            }

            // Hitung Ulang Distribusi Jenis Kelamin
            const newJenisKelamin = [
                filteredList.filter(item => item.jenis_kelamin === 'Laki-laki').length,
                filteredList.filter(item => item.jenis_kelamin === 'Perempuan').length
            ];

            // Hitung Ulang Distribusi Pendidikan
            const newPendidikan = labelPendidikan.map(p => 
                filteredList.filter(item => item.pendidikan_terakhir === p).length
            );

            // Hitung Ulang Distribusi Usia
            const newUsia = labelUsia.map(u => 
                filteredList.filter(item => matchUsiaGroup(item.usia, u)).length
            );

            // Pembaruan Animasi Grafik Tanpa Reload Halaman
            chartJenisKelamin.data.datasets[0].data = newJenisKelamin;
            chartJenisKelamin.update();

            chartPendidikan.data.datasets[0].data = newPendidikan;
            chartPendidikan.data.datasets[0].backgroundColor = generateGradation(newPendidikan, [112, 150, 209]);
            chartPendidikan.update();

            chartUsia.data.datasets[0].data = newUsia;
            chartUsia.data.datasets[0].backgroundColor = generateGradation(newUsia, [8, 31, 92]);
            chartUsia.update();
        }

        // FUNGSI RESET FILTER (PANGGILAN DARI TOMBOL SILANG)
        window.resetFilter = function() {
            applyFilter(null, null);
        };

    } else {
        console.error('Chart.js gagal dimuat.');
    }
</script>
@endpush