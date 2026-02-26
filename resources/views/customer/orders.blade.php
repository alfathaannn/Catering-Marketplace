@extends('layouts.customer')

@section('title', 'My Orders - Catering Marketplace')

@push('styles')
<style>
    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .orders-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .order-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        gap: 16px;
        opacity: 0;
        /* for GSAP animation */
        transform: translateY(20px);
        /* for GSAP animation */
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 16px;
    }

    .merchant-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .merchant-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
    }

    .merchant-details h3 {
        margin: 0 0 4px 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
    }

    .merchant-details p {
        margin: 0;
        font-size: 0.875rem;
        color: #64748b;
    }

    /* Badges */
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: capitalize;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-confirmed,
    .status-paid {
        background: #dcfce7;
        color: #16a34a;
    }

    .status-delivered {
        background: #e0f2fe;
        color: #0284c7;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #dc2626;
    }

    .order-body {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background: #f8fafc;
        border-radius: 8px;
    }

    .item-info {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .item-image {
        width: 48px;
        height: 48px;
        border-radius: 6px;
        background-size: cover;
        background-position: center;
        background-color: #e2e8f0;
    }

    .item-details h4 {
        margin: 0 0 4px 0;
        font-size: 1rem;
        font-weight: 500;
        color: #334155;
    }

    .item-details p {
        margin: 0;
        font-size: 0.875rem;
        color: #64748b;
    }

    .item-price {
        font-weight: 600;
        color: #0f172a;
    }

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
        margin-top: 8px;
    }

    .total-label {
        font-size: 0.875rem;
        color: #64748b;
    }

    .total-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f4a9c;
    }

    .empty-state {
        text-align: center;
        padding: 64px 24px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        color: #64748b;
    }

    .empty-state .material-symbols-rounded {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        color: #1e293b;
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
    }
</style>
@endpush

@section('content')
<div class="orders-container">
    <div class="orders-header">
        <h1 class="orders-title" id="page-title">Riwayat Pesanan Anda</h1>
    </div>

    @if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500;">
        {{ session('success') }}
    </div>
    @endif

    <div class="orders-list">
        @forelse($orders as $order)
        <div class="order-card">
            <!-- Header: Merchant & Status -->
            <div class="order-header">
                <div class="merchant-info">
                    <div class="merchant-icon">
                        <span class="material-symbols-rounded">store</span>
                    </div>
                    <div class="merchant-details">
                        <h3>{{ $order->merchant->company_name }}</h3>
                        <p>Tanggal Pesan: {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                <div>
                    @php
                    $badgeClass = 'status-pending';
                    $icon = 'schedule';
                    if($order->status == 'confirmed' || $order->status == 'paid') {
                    $badgeClass = 'status-confirmed';
                    $icon = 'check_circle';
                    } elseif($order->status == 'delivered') {
                    $badgeClass = 'status-delivered';
                    $icon = 'local_shipping';
                    } elseif($order->status == 'cancelled') {
                    $badgeClass = 'status-cancelled';
                    $icon = 'cancel';
                    }
                    @endphp
                    <span class="status-badge {{ $badgeClass }}">
                        <span class="material-symbols-rounded" style="font-size: 18px;">{{ $icon }}</span>
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <!-- Body: Items -->
            <div class="order-body">
                <div style="font-size: 0.875rem; font-weight: 600; color: #475569; margin-bottom: 4px;">
                    Jadwal Pengiriman: {{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('l, d F Y') }}
                </div>

                @foreach($order->orderItems as $item)
                <div class="order-item">
                    <div class="item-info">
                        @if($item->menu->image)
                        @php
                        $imageUrl = str_starts_with($item->menu->image, 'http') ? $item->menu->image : asset('storage/' . $item->menu->image);
                        @endphp
                        <div class="item-image" style="background-image: url('{{ $imageUrl }}')"></div>
                        @else
                        <div class="item-image" style="display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                            <span class="material-symbols-rounded">restaurant</span>
                        </div>
                        @endif
                        <div class="item-details">
                            <h4>{{ $item->menu->name }}</h4>
                            <p>{{ $item->quantity }} Porsi &times; Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="item-price">
                        Rp {{ number_format($item->quantity * $item->price_at_order, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Footer: Total -->
            <div class="order-footer">
                <div>
                    <span class="total-label" style="display: block;">Total Pembayaran</span>
                    <span class="total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                @if($order->invoice)
                <a href="{{ route('invoices.show', $order->invoice->id) }}" style="background: #f1f5f9; color: #1f4a9c; border: 1px solid #cbd5e1; padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: background 0.2s;">
                    <span class="material-symbols-rounded" style="font-size: 18px;">receipt</span>
                    Lihat Invoice
                </a>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <span class="material-symbols-rounded">receipt_long</span>
            <h3>Belum Ada Pesanan</h3>
            <p>Anda belum pernah melakukan pemesanan katering. Yuk, cari merchant favorit Anda sekarang!</p>
            <a href="{{ route('customer.dashboard') }}" style="display: inline-block; margin-top: 16px; background: #1f4a9c; color: white; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: background 0.2s;">Cari Katering</a>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        // Simple GSAP animations for the page elements
        gsap.fromTo("#page-title", {
            y: -20,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.6,
            ease: "power3.out"
        });

        // Stagger in order cards
        gsap.to(".order-card", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.15,
            ease: "back.out(1.2)",
            delay: 0.2
        });

        // Non-card empty state animation
        gsap.fromTo(".empty-state", {
            scale: 0.95,
            opacity: 0
        }, {
            scale: 1,
            opacity: 1,
            duration: 0.6,
            ease: "power2.out",
            delay: 0.2
        });
    });
</script>
@endpush