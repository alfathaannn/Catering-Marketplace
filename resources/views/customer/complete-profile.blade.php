@extends('layouts.customer')

@section('title', 'Complete Profile | Catering Marketplace')

@push('styles')
<style>
    /* Mimicking MaryUI/DaisyUI Steps look using Tailwind utility classes concepts */
    .steps-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 70vh;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 40px;
        width: 100%;
        max-width: 600px;
    }

    .step-indicator {
        display: flex;
        align-items: center;
        margin-bottom: 32px;
        justify-content: space-between;
        position: relative;
    }

    .step-indicator::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
        transform: translateY(-50%);
    }

    .step-item {
        position: relative;
        z-index: 2;
        background: white;
        padding: 0 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .step-item.active .step-circle {
        background: #1f4a9c;
        color: white;
        box-shadow: 0 0 0 4px rgba(31, 74, 156, 0.1);
    }

    .step-item.done .step-circle {
        background: #10b981;
        color: white;
    }

    .step-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .step-item.active .step-label {
        color: #1f4a9c;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 24px;
        opacity: 0;
        transform: translateY(10px);
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #334155;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 1rem;
        color: #0f172a;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: #1f4a9c;
        box-shadow: 0 0 0 3px rgba(31, 74, 156, 0.1);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 100px;
    }

    .btn-submit {
        background-color: #1f4a9c;
        color: white;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        width: 100%;
        font-size: 1rem;
        transition: background-color 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        opacity: 0;
    }

    .btn-submit:hover {
        background-color: #15387a;
    }
</style>
@endpush

@section('content')
<div class="steps-container">

    <div style="text-align: center; margin-bottom: 24px;" class="welcome-text">
        <h1 style="font-size: 1.875rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Welcome, {{ Auth::user()->name }}! 👋</h1>
        <p style="color: #64748b;">Let's complete your customer profile to start browsing and ordering catering.</p>
    </div>

    <div class="form-card">

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step-item done">
                <div class="step-circle"><span class="material-symbols-rounded" style="font-size: 16px;">check</span></div>
                <span class="step-label">Account</span>
            </div>
            <div class="step-item active">
                <div class="step-circle">2</div>
                <span class="step-label">Office Profile</span>
            </div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <span class="step-label">Ready</span>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('customer.profile.store') }}" method="POST" id="profileForm">
            @csrf

            <div class="form-group">
                <label for="office_name" class="form-label">Office / Company Name <span style="color: #ef4444;">*</span></label>
                <input type="text" id="office_name" name="office_name" class="form-input" placeholder="e.g. PT Maju Bersama" required value="{{ old('office_name') }}">
                @error('office_name')
                <span style="color: #ef4444; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="contact" class="form-label">Contact Number <span style="color: #ef4444;">*</span></label>
                <input type="text" id="contact" name="contact" class="form-input" placeholder="e.g. 08123456789" required value="{{ old('contact') }}">
                @error('contact')
                <span style="color: #ef4444; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Delivery Address <span style="color: #ef4444;">*</span></label>
                <textarea id="address" name="address" class="form-input" placeholder="Enter the complete address for catering deliveries..." required>{{ old('address') }}</textarea>
                @error('address')
                <span style="color: #ef4444; font-size: 0.75rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Complete Profile
                <span class="material-symbols-rounded" style="font-size: 20px;">arrow_forward</span>
            </button>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        // Animate elements in
        gsap.fromTo(".welcome-text", {
            y: -20,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.6,
            ease: "power2.out"
        });

        gsap.fromTo(".form-card", {
            y: 20,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.6,
            delay: 0.2,
            ease: "power2.out"
        });

        gsap.to(".form-group", {
            y: 0,
            opacity: 1,
            duration: 0.5,
            stagger: 0.1,
            delay: 0.4,
            ease: "power2.out"
        });

        gsap.to(".btn-submit", {
            opacity: 1,
            duration: 0.5,
            delay: 0.8,
            ease: "power2.out"
        });
    });
</script>
@endpush
