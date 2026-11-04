<!DOCTYPE html>
<html lang="id">
<head>
    {{-- ==================================================
         BAGIAN 1: META DAN STYLESHEET
         ================================================== --}}

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Sistem Manajemen Data Pegawai</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link href="{{ asset('css/pegawai.css') }}" rel="stylesheet">
</head>

<body class="auth-page">

    {{-- ==================================================
         BAGIAN 2: KARTU LOGIN
         ================================================== --}}

    <main class="login-card">

        <div class="text-center mb-4">
            <span class="brand-mark mb-3">SM</span>

            <h1 class="h4 fw-bold text-brand-dark">
                Sistem Manajemen Data Pegawai
            </h1>

            <p class="text-secondary mb-0">
                Silakan login untuk melanjutkan
            </p>
        </div>

        {{-- ==================================================
             BAGIAN 3: FORM LOGIN
             ================================================== --}}

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    class="form-control @error('username') is-invalid @enderror"
                    placeholder="Masukkan username"
                    autocomplete="username"
                    maxlength="50"
                    required
                    autofocus
                >

                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    Password
                </label>

                <div class="input-group has-validation">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="togglePassword"
                        aria-label="Tampilkan password"
                        aria-pressed="false"
                    >
                        <svg
                            id="eyeIcon"
                            xmlns="http://www.w3.org/2000/svg"
                            width="19"
                            height="19"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                            />
                            <circle cx="12" cy="12" r="3" />
                        </svg>

                        <svg
                            id="eyeOffIcon"
                            class="d-none"
                            xmlns="http://www.w3.org/2000/svg"
                            width="19"
                            height="19"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                d="M3 3l18 18"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9.9 5.9A10 10 0 0 1 12 5.7c6 0 9.5 6.3 9.5 6.3a16 16 0 0 1-3.1 3.7M6.5 6.6C3.9 8.3 2.5 12 2.5 12s3.5 6.3 9.5 6.3c1 0 2-.2 2.9-.5"
                            />
                        </svg>
                    </button>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">
                Login
            </button>
        </form>

        <p class="text-center text-secondary small mt-4 mb-0">
            Sistem Manajemen Data Pegawai
        </p>

    </main>

    {{-- ==================================================
         BAGIAN 4: LIHAT / SEMBUNYIKAN PASSWORD
         ================================================== --}}

    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');

        toggleButton.addEventListener('click', function () {
            const hidden = passwordInput.type === 'password';

            passwordInput.type = hidden ? 'text' : 'password';

            eyeIcon.classList.toggle('d-none', hidden);
            eyeOffIcon.classList.toggle('d-none', !hidden);

            toggleButton.setAttribute(
                'aria-label',
                hidden ? 'Sembunyikan password' : 'Tampilkan password'
            );

            toggleButton.setAttribute('aria-pressed', String(hidden));
        });
    </script>

</body>
</html>
