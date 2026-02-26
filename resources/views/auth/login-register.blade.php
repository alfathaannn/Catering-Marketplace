<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5, user-scalable=yes" />
    <title>Authentikasi {{ ucfirst($role) }} - Catering Marketplace</title>

        <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ $pengaturan->logo_dark_url ?? asset('assets/images/4S.png') }}">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Google Material Icons · lebih fresh dan modern -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- GSAP (GreenSock) untuk transisi super empuk -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <!-- Custom Auth Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}" />
    @if($role == 'customer')
    <style>
        /* Override specific styles based on role if needed, e.g. Customer is slightly different theme */
        :root {
            --blue-deep: #10b981;
            --blue-soft: #d1fae5;
            --blue-outline: #059669;
        }
    </style>
    @endif
</head>

<body>
    <div class="toast-message" id="toast">
        <span class="material-icons">info</span>
        <span id="toastText">Notifikasi</span>
    </div>

    <!-- Pass flash messages to window object for JS to pick up -->
    @if(session('error'))
    <script>
        window.flashErrors = "{{ session('error') }}";
    </script>
    @endif
    @if(session('success'))
    <script>
        window.flashSuccess = "{{ session('success') }}";
    </script>
    @endif

    <main class="auth-card" id="authCard">
        <div class="auth-header">
            <span class="material-icons icon-head">{{ $role == 'merchant' ? 'storefront' : 'person' }}</span>
            <h2 id="formTitle">Welcome {{ ucfirst($role) }}</h2>
            <div class="auth-underline"></div>
        </div>

        <!-- tab toggle dengan icon -->
        <div class="toggle-tabs" id="tabContainer">
            <button class="tab-btn active" id="tabLogin">
                <span class="material-icons">login</span> <span>Login</span>
            </button>
            <button class="tab-btn" id="tabRegister">
                <span class="material-icons">person_add</span> <span>Register</span>
            </button>
        </div>

        <!-- wrapper khusus untuk sliding GSAP -->
        <div class="form-wrapper" id="formWrapper">
            <!-- LOGIN FORM -->
            <form class="auth-form" id="loginForm" action="{{ route($routePrefix . 'login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label><span class="material-icons">mail</span> Email</label>
                    <input type="email" id="loginEmail" name="email" value="{{ old('email') }}" placeholder="Masukan Email Anda" required />
                    @if($errors->has('email') && !old('name'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="input-group">
                    <label><span class="material-icons">lock</span> Password</label>
                    <div class="input-with-icon">
                        <input type="password" id="loginPassword" name="password" placeholder="Masukan Password Anda" required />
                        <span class="material-icons toggle-password" data-target="loginPassword">visibility_off</span>
                    </div>
                </div>
                <button type="submit" class="submit-btn" id="loginSubmit">
                    <span class="material-icons">keyboard_arrow_right</span> Sign in
                </button>
                <div class="auth-footer">
                    <!-- <a href="#" id="forgotLink"><span class="material-icons">help_outline</span> Lupa password?</a>
                    <span>·</span> -->
                    <a href="#" id="switchToRegister"><span class="material-icons">app_registration</span> Buat akun</a>
                </div>
            </form>

            <!-- REGISTER FORM -->
            <form class="auth-form" id="registerForm" action="{{ route($routePrefix . 'register') }}" method="POST">
                @csrf
                <div class="name-row">
                    <div class="input-group">
                        <label><span class="material-icons">badge</span> Nama Lengkap</label>
                        <input type="text" id="regName" name="name" value="{{ old('name') }}" placeholder="Masukan Nama Anda" required />
                        @if($errors->has('name'))
                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="input-group">
                    <label><span class="material-icons">mail</span> Email</label>
                    <input type="email" id="regEmail" name="email" value="{{ old('name') ? old('email') : '' }}" placeholder="Masukan Email Anda" required />
                    @if($errors->has('email') && old('name'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="input-group">
                    <label><span class="material-icons">lock</span> Password</label>
                    <div class="input-with-icon">
                        <input type="password" id="regPassword" name="password" placeholder="Masukan Password Anda" required />
                        <span class="material-icons toggle-password" data-target="regPassword">visibility_off</span>
                    </div>
                    @if($errors->has('password'))
                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="input-group">
                    <label><span class="material-icons">sync_lock</span> Konfirmasi</label>
                    <div class="input-with-icon">
                        <input type="password" id="regConfirm" name="password_confirmation" placeholder="Masukan Konfirmasi Password Anda" required />
                        <span class="material-icons toggle-password" data-target="regConfirm">visibility_off</span>
                    </div>
                </div>
                <!-- We pass the role as a hidden input or rely on the POST route controller -->
                <button type="submit" class="submit-btn" id="registerSubmit">
                    <span class="material-icons">how_to_reg</span> Buat akun
                </button>
                <div class="auth-footer">
                    <a href="#" id="switchToLogin"><span class="material-icons">arrow_back</span> Sudah punya akun? Login</a>
                </div>
            </form>
        </div>

        <div class="attribution-note">
            <span class="material-icons">rocket_launch</span> Catering Marketplace · by alfathaannn
        </div>
    </main>

    <!-- Custom Auth Scripts -->
    <script>
        window.userRole = "{{ ucfirst($role) }}";
    </script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
</body>

</html>