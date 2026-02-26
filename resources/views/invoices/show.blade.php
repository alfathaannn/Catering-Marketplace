<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    
    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ $pengaturan->logo_dark_url ?? asset('assets/images/4S.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 40px;
            color: #333;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
        }

        .invoice-box {
            max-width: 800px;
            width: 100%;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border: 1px solid #eee;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #1f4a9c;
            margin: 0;
            font-size: 2.5rem;
        }

        .invoice-details {
            text-align: right;
            color: #555;
        }

        .invoice-details p {
            margin: 4px 0;
            font-size: 0.9rem;
        }

        .invoice-details span {
            font-weight: bold;
            color: #333;
        }

        .billing-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .billing-box {
            width: 45%;
        }

        .billing-box h3 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .billing-box p {
            margin: 4px 0;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .items-table th {
            background: #f8f8f8;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            color: #555;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .items-table th.right,
        .items-table td.right {
            text-align: right;
        }

        .totals {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .totals-table {
            width: 300px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 12px;
        }

        .totals-table td.label {
            text-align: left;
            font-weight: bold;
            color: #666;
        }

        .totals-table td.amount {
            text-align: right;
            font-weight: bold;
        }

        .totals-table tr.grand-total {
            background: #f8f8f8;
            border-top: 2px solid #ddd;
        }

        .totals-table tr.grand-total td {
            font-size: 1.25rem;
            color: #1f4a9c;
            padding: 16px 12px;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            color: #888;
            font-size: 0.85rem;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .action-buttons {
            margin-bottom: 20px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 16px;
        }

        .btn {
            background: #1f4a9c;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline {
            background: white;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        /* Status Badge for printing */
        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .status-unpaid {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .status-paid {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-box {
                box-shadow: none;
                border: none;
                padding: 0;
                width: 100%;
                max-width: none;
            }

            .action-buttons {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div style="width: 100%; max-width: 800px;">
        <div class="action-buttons">
            <button onclick="window.print()" class="btn">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak / Simpan PDF
            </button>
            <button onclick="history.back()" class="btn btn-outline">Kembali</button>
        </div>

        <div class="invoice-box">
            <div class="header">
                <div>
                    <h1>INVOICE</h1>
                    <p style="color: #666; margin-top: 8px; font-size: 0.9rem;">No. {{ $invoice->invoice_number }}</p>
                </div>
                <div class="invoice-details">
                    <p>Tanggal Diterbitkan:<br><span>{{ $invoice->issue_date->format('d/m/Y H:i') }}</span></p>
                    <p>Tanggal Pengiriman:<br><span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span></p>
                    <div style="margin-top: 12px;">
                        <span class="status {{ $invoice->payment_status == 'paid' ? 'status-paid' : 'status-unpaid' }}">
                            {{ $invoice->payment_status == 'paid' ? 'LUNAS' : 'BELUM BAYAR' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="billing-info">
                <div class="billing-box">
                    <h3>Dari (Merchant)</h3>
                    <p><strong>{{ $order->merchant->company_name }}</strong></p>
                    <p>{{ $order->merchant->address }}</p>
                    <p>{{ $order->merchant->contact }}</p>
                </div>
                <div class="billing-box" style="text-align: right;">
                    <h3>Kepada (Customer)</h3>
                    <p><strong>{{ $order->customer->office_name }}</strong></p>
                    <p>{{ $order->customer->user->name }}</p>
                    <p>{{ $order->customer->address }}</p>
                    <p>{{ $order->customer->contact }}</p>
                </div>
            </div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Deskripsi Menu</th>
                        <th class="right">Harga Satuan</th>
                        <th class="right" style="width: 15%">Qty</th>
                        <th class="right" style="width: 25%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->menu->name }}</strong>
                        </td>
                        <td class="right">Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</td>
                        <td class="right">{{ $item->quantity }}</td>
                        <td class="right">Rp {{ number_format($item->quantity * $item->price_at_order, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals">
                <table class="totals-table">
                    <tr>
                        <td class="label">Subtotal</td>
                        <td class="amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="grand-total">
                        <td class="label">Total Pembayaran</td>
                        <td class="amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>Terima kasih telah berbelanja di Catering Marketplace.</p>
                <p>Dokumen ini adalah bukti transaksi yang sah dan dicetak oleh sistem komputer.</p>
            </div>
        </div>
    </div>
</body>

</html>