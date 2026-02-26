<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Catering Profile</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ $pengaturan->logo_dark_url ?? asset('assets/images/4S.png') }}">
    
    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f6f8fc 0%, #f0f4fa 100%);
            min-height: 100vh;
        }

        /* Modern Steps Styling */
        .steps-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: relative;
            margin: 40px 0 60px;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .step-marker {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            color: #94a3b8;
            margin-bottom: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .step-marker.completed {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .step-marker.active {
            background: #1f4a9c;
            border-color: #1f4a9c;
            color: white;
            box-shadow: 0 8px 16px rgba(31, 74, 156, 0.15);
            transform: scale(1.05);
        }

        .step-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .step-label.active {
            color: #1f4a9c;
            font-weight: 600;
        }

        .step-label.completed {
            color: #10b981;
        }

        .step-progress-line {
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }

        .step-progress-fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(90deg, #1f4a9c 0%, #3b82f6 100%);
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            width: 33.33%;
        }

        /* Form Styling */
        .form-card {
            background: white;
            border-radius: 32px;
            box-shadow:
                0 20px 40px -12px rgba(0, 20, 50, 0.12),
                0 4px 18px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            box-shadow:
                0 30px 60px -12px rgba(31, 74, 156, 0.15),
                0 8px 24px rgba(0, 0, 0, 0.02);
        }

        .form-header {
            padding: 32px 40px;
            background: linear-gradient(to right, #f8fafc, white);
            border-bottom: 1px solid #edf2f7;
        }

        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0a1e3c;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .form-header p {
            color: #5f6b7a;
            font-size: 0.95rem;
        }

        .form-body {
            padding: 40px;
        }

        .input-group {
            margin-bottom: 28px;
        }

        .input-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .input-label span {
            color: #ef4444;
            margin-left: 2px;
        }

        .input-field {
            width: 100%;
            padding: 14px 18px;
            background: #f9fafc;
            border: 1.5px solid #e9edf2;
            border-radius: 16px;
            font-size: 0.95rem;
            color: #1e293b;
            transition: all 0.2s ease;
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .input-field:hover {
            background: white;
            border-color: #d0d9e3;
        }

        .input-field:focus {
            background: white;
            border-color: #1f4a9c;
            box-shadow: 0 4px 12px rgba(31, 74, 156, 0.08);
        }

        .input-field::placeholder {
            color: #9aa4b2;
            font-weight: 400;
        }

        textarea.input-field {
            resize: vertical;
            min-height: 120px;
            line-height: 1.5;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b98a9;
            font-size: 1.3rem;
        }

        .input-icon-wrapper .input-field {
            padding-left: 52px;
        }

        .hint-text {
            font-size: 0.8rem;
            color: #6f7c8f;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .hint-text .material-symbols-rounded {
            font-size: 1rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-footer {
            padding: 32px 40px;
            background: #f9fafc;
            border-top: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: none;
            outline: none;
            letter-spacing: -0.01em;
        }

        .btn-primary {
            background: #1f4a9c;
            color: white;
            box-shadow: 0 8px 16px -4px rgba(31, 74, 156, 0.2);
        }

        .btn-primary:hover {
            background: #153b7a;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -4px rgba(31, 74, 156, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 4px 8px -2px rgba(31, 74, 156, 0.2);
        }

        .btn-secondary {
            background: white;
            color: #1e293b;
            border: 1.5px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .btn .material-symbols-rounded {
            font-size: 1.2rem;
        }

        .header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            height: 80px;
            display: flex;
            align-items: center;
            padding: 0 40px;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            background: linear-gradient(135deg, #1f4a9c 0%, #2563eb 100%);
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px -4px rgba(31, 74, 156, 0.25);
        }

        .logo-icon span {
            color: white;
            font-size: 24px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.3rem;
            color: #0b1f3b;
            letter-spacing: -0.02em;
        }

        .logo-text span {
            color: #1f4a9c;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 100px;
            color: #4b5a6e;
            font-weight: 500;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid transparent;
        }

        .logout-btn:hover {
            background: white;
            border-color: #e2e8f0;
            color: #1e293b;
        }

        .main-content {
            max-width: 880px;
            margin: 40px auto;
            padding: 0 24px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .page-title h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0a1e3c;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .page-title p {
            color: #54687a;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>
    <main class="main-content">
        <div class="page-title">
            <h1>Complete Your Catering Profile</h1>
            <p>Set up your business details to start receiving catering orders</p>
        </div>

        <!-- Modern Steps Indicator -->
        <div class="steps-container">
            <div class="step-progress-line">
                <div class="step-progress-fill"></div>
            </div>

            <div class="step-item">
                <div class="step-marker completed">
                    <span class="material-symbols-rounded" style="font-size: 1.3rem;">check</span>
                </div>
                <span class="step-label completed">Account Created</span>
            </div>

            <div class="step-item">
                <div class="step-marker active">2</div>
                <span class="step-label active">Business Profile</span>
            </div>

            <div class="step-item">
                <div class="step-marker">3</div>
                <span class="step-label">Services & Menu</span>
            </div>

            <div class="step-item">
                <div class="step-marker">4</div>
                <span class="step-label">Ready to Go</span>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="form-card">
            <div class="form-header">
                <h2>Business Information</h2>
                <p>Please provide accurate details about your catering business</p>
            </div>

            <form action="{{ route('merchant.profile.store') }}" method="POST" class="form-body">
                @csrf
                <div class="input-group">
                    <label class="input-label" for="company_name">Company Name <span>*</span></label>
                    <input type="text"
                        id="company_name"
                        name="company_name"
                        class="input-field"
                        placeholder="e.g., Delicious Catering Co."
                        value=""
                        required>
                    <div class="hint-text">
                        <span class="material-symbols-rounded">info</span>
                        This will appear on your public profile
                    </div>
                </div>

                <div class="grid-2">
                    <div class="input-group">
                        <label class="input-label" for="contact">Phone Number <span>*</span></label>
                        <div class="input-icon-wrapper">
                            <span class="material-symbols-rounded input-icon">call</span>
                            <input type="tel"
                                id="contact"
                                name="contact"
                                class="input-field"
                                placeholder="+62 812-3456-7890"
                                required>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="address">Business Address <span>*</span></label>
                    <div class="input-icon-wrapper">
                        <span class="material-symbols-rounded input-icon">location_on</span>
                        <input type="text"
                            id="address"
                            name="address"
                            class="input-field"
                            placeholder="Street address, city, postal code"
                            required>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="description">About Your Business</label>
                    <textarea id="description"
                        name="description"
                        class="input-field"
                        placeholder="Tell potential customers about your catering services, specialties, experience..."></textarea>
                    <div class="hint-text">
                        <span class="material-symbols-rounded">description</span>
                        Max 500 characters - Be concise and compelling
                    </div>
                </div>

                <div class="form-footer">
                    <form action="{{ route('merchant.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn secondary">
                            <span class="material-symbols-rounded">logout</span>
                            Sign Out
                        </button>
                    </form>
                    <button type="submit" class="btn btn-primary">
                        Continue
                        <span class="material-symbols-rounded">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Trust Badge -->
        <div style="text-align: center; margin-top: 24px;">
            <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.6); padding: 8px 16px; border-radius: 100px; font-size: 0.85rem; color: #475569;">
                <span class="material-symbols-rounded" style="font-size: 1rem; color: #10b981;">verified</span>
                Your information is secure and encrypted
            </span>
        </div>
    </main>
</body>

</html>