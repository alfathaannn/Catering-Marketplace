<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering Marketplace</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ $pengaturan->logo_dark_url ?? asset('assets/images/4S.png') }}">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Google Material Icons · lebih fresh dan modern -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <!-- Assets CSS Landing -->
    <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">

</head>

<body>
    <main class="card">
        <div class="selection-panel">
            <!-- headline sederhana -->
            <div class="panel-headline">
                <h1>Catering Marketplace</h1>
                <p>Pilih peran untuk melanjutkan</p>
            </div>

            <div class="button-duo">
                <!-- button merchant -->
                <a href="{{ route('merchant.login') }}" class="btn btn-merchant" id="merchantBtn" aria-label="Pilih peran Merchant">
                    <span class="btn-inner">
                        <span class="btn-icon" aria-hidden="true"></span>
                        <span class="btn-text">Merchant</span>
                    </span>
                </a>

                <!-- button customer -->
                <a href="{{ route('customer.login') }}" class="btn btn-customer" id="customerBtn" aria-label="Pilih peran Customer">
                    <span class="btn-inner">
                        <span class="btn-icon" aria-hidden="true"></span>
                        <span class="btn-text">Customer</span>
                    </span>
                </a>
            </div>

            <!-- garis halus dan info kecil (tanpa emoji) -->
            <div class="attribution">
                <span class="material-icons">rocket_launch</span> Catering Marketplace · by alfathaannn
            </div>
        </div>
    </main>

    <!-- Assets JS Landing -->
    <script src="{{ asset('assets/js/script-landing.js') }}"></script>
</body>

</html>