@extends('layouts.merchant')

@section('title', 'Kelola Pesanan Masuk - Catering Marketplace')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 24px;
    }

    .order-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        opacity: 0;
        transform: translateY(20px);
    }

    .order-header {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background: #f8fafc;
    }

    .customer-info {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #1f4a9c;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.125rem;
    }

    .customer-details h3 {
        margin: 0 0 4px 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: #0f172a;
    }

    .customer-details p {
        margin: 0;
        font-size: 0.875rem;
        color: #64748b;
    }

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
        padding: 20px;
        flex-grow: 1;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .info-label {
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-value {
        font-weight: 600;
        color: #1e293b;
        text-align: right;
    }

    .items-list {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px dashed #e2e8f0;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .item-name {
        color: #334155;
    }

    .item-qty {
        color: #64748b;
        font-weight: 500;
    }

    .order-footer {
        padding: 20px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .total-label {
        font-size: 1rem;
        color: #475569;
        font-weight: 500;
    }

    .total-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f4a9c;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
    }

    .btn {
        flex: 1;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        transition: transform 0.1s, opacity 0.2s;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .btn:active {
        transform: scale(0.98);
    }

    .btn-primary {
        background: #1f4a9c;
        color: white;
    }

    .btn-primary:hover {
        background: #1e3a8a;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-outline {
        background: white;
        color: #1f4a9c;
        border: 1px solid #cbd5e1;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 24px;
        background: white;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        color: #64748b;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title" id="pageTitle">Daftar Pesanan Masuk</h1>
</div>

@if(session('success'))
<div style="background: #dcfce7; color: #166534; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500; display: flex; align-items: center; gap: 8px;">
    <span class="material-symbols-rounded">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="orders-grid">
    @forelse($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <div class="customer-info">
                <div class="customer-avatar">
                    {{ substr($order->customer->user->name, 0, 1) }}
                </div>
                <div class="customer-details">
                    <h3>{{ $order->customer->user->name }}</h3>
                    <p>{{ $order->customer->office_name }}</p>
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
                    <span class="material-symbols-rounded" style="font-size: 16px;">{{ $icon }}</span>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <div class="order-body">
            <div class="info-row">
                <div class="info-label">
                    <span class="material-symbols-rounded" style="font-size: 18px;">calendar_today</span>
                    Tgl Pesan
                </div>
                <div class="info-value">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <span class="material-symbols-rounded" style="font-size: 18px;">event_available</span>
                    Dikirim Pada
                </div>
                <div class="info-value" style="color: #1f4a9c;">{{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('l, d M Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">
                    <span class="material-symbols-rounded" style="font-size: 18px;">location_on</span>
                    Alamat
                </div>
                <div class="info-value" style="font-weight: 500;">
                    {{ Str::limit($order->customer->address, 35) }}
                </div>
            </div>

            <div class="items-list">
                @foreach($order->orderItems as $item)
                <div class="item-row">
                    <div class="item-name">{{ $item->menu->name }}</div>
                    <div class="item-qty">{{ $item->quantity }}x @ Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="order-footer">
            <div class="total-row">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
            </div>

            <div class="action-buttons">
                @if($order->status === 'pending')
                <form action="{{ route('merchant.orders.update-status', $order) }}" method="POST" style="flex: 1;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Konfirmasi Pesanan
                    </button>
                </form>
                @elseif($order->status === 'confirmed')
                <form action="{{ route('merchant.orders.update-status', $order) }}" method="POST" style="flex: 1;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="delivered">
                    <button type="submit" class="btn btn-success" style="width: 100%;">
                        <span class="material-symbols-rounded" style="font-size: 20px;">local_shipping</span>
                        Selesai & Dikirim
                    </button>
                </form>
                @endif

                @if($order->invoice)
                <a href="{{ route('invoices.show', $order->invoice->id) }}" class="btn btn-outline" target="_blank" style="flex: 1;">
                    <span class="material-symbols-rounded" style="font-size: 20px;">receipt</span>
                    Lihat Invoice
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <span class="material-symbols-rounded" style="font-size: 64px; margin-bottom: 16px; opacity: 0.5;">inbox</span>
        <h3 style="font-size: 1.25rem; color: #1e293b; margin-bottom: 8px;">Belum Ada Pesanan</h3>
        <p>Pesanan dari customer akan muncul di sini. Pastikan menu Anda menarik!</p>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        gsap.fromTo("#pageTitle", {
            y: -20,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 0.6,
            ease: "power3.out"
        });

        gsap.to(".order-card", {
            y: 0,
            opacity: 1,
            duration: 0.6,
            stagger: 0.1,
            ease: "back.out(1.2)",
            delay: 0.2
        });
    });
</script>
@endpush