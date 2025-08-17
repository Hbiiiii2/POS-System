<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $transaction->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* ===== Thermal 58mm safe zone: 48mm printable ===== */
        :root {
            --paper-width: 58mm;
            /* ukuran gulungan */
            --printable: 48mm;
            /* lebar cetak efektif */
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: "Courier New", ui-monospace, SFMono-Regular, Menlo, monospace;
            font-size: 7px;
            /* sedikit lebih besar biar kebaca */
            line-height: 1.2;
            color: #000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Ukuran halaman untuk browser */
        @page {
            size: var(--paper-width) auto;
            margin: 0;
        }

        body {
            width: var(--paper-width);
        }

        .receipt {
            width: var(--printable);
            margin: 0 auto;
            padding: 1mm 0;
            /* tipis saja */
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: 700;
        }

        /* Header */
        .header {
            border-bottom: 1px dashed #000;
            padding-bottom: 1mm;
            margin-bottom: 1mm;
        }

        .company {
            font-size: 9px;
            font-weight: 700;
        }

        .meta {
            font-size: 7px;
        }

        /* Tabel generik */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* wajib untuk 58 mm */
        }

        td {
            padding: 0;
            vertical-align: top;
        }

        /* Info transaksi */
        .info td {
            padding: 0.3mm 0;
        }

        .info .label {
            width: 16mm;
        }

        .info .value {
            width: calc(48mm - 16mm);
            text-align: right;
        }

        /* Items */
        .items {
            margin-top: 0.5mm;
        }

        .items thead td {
            border-bottom: 1px solid #000;
            padding-bottom: 0.3mm;
            font-weight: 700;
            font-size: 7px;
        }

        .items tbody td {
            padding: 0.3mm 0;
            font-size: 7px;
        }

        /* Kolom lebar disesuaikan agar total kanan tidak kepotong */
        .col-name {
            width: 26mm;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .col-qty {
            width: 6mm;
            text-align: center;
        }

        .col-price {
            width: 7mm;
            text-align: right;
        }

        .col-total {
            width: 9mm;
            text-align: right;
        }

        /* Totals */
        .totals {
            border-top: 1px dashed #000;
            margin-top: 1mm;
            padding-top: 1mm;
        }

        .totals tr td {
            padding: 0.4mm 0;
        }

        .totals .label {
            width: 28mm;
        }

        .totals .value {
            width: calc(48mm - 28mm);
            text-align: right;
        }

        .totals .final td {
            border-top: 1px solid #000;
            padding-top: 0.6mm;
            font-weight: 700;
            font-size: 8px;
        }

        /* Footer */
        .footer {
            border-top: 1px dashed #000;
            margin-top: 1mm;
            padding-top: 1mm;
            text-align: center;
            font-size: 6px;
        }

        .qr-note {
            font-size: 5px;
        }

        /* Print overrides */
        @media print {

            html,
            body {
                width: var(--paper-width);
            }

            .receipt {
                width: var(--printable);
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header center">
            <div class="company">POS SYSTEM</div>
            <div class="meta bold">Receipt #{{ $transaction->id }}</div>
            <div class="meta">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y H:i') }}</div>
            <div class="meta">Kasir: {{ $transaction->user->name }}</div>
        </div>

        <!-- Info -->
        <table class="info">
            <tr>
                <td class="label">ID</td>
                <td class="value">{{ $transaction->id }}</td>
            </tr>
            <tr>
                <td class="label">Metode</td>
                <td class="value">{{ strtoupper($transaction->payment_method) }}</td>
            </tr>
        </table>

        <!-- Items -->
        <table class="items">
            <thead>
                <tr>
                    <td class="col-name">Item</td>
                    <td class="col-qty">Qty</td>
                    <td class="col-price">Harga</td>
                    <td class="col-total">Total</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->transactionDetails as $detail)
                    <tr>
                        <td class="col-name">{{ $detail->product->name }}</td>
                        <td class="col-qty">{{ $detail->qty }}</td>
                        <td class="col-price">{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="col-total">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="totals">
            <tr>
                <td class="label">Subtotal</td>
                <td class="value">{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Bayar</td>
                <td class="value">{{ number_format($transaction->payment->amount_paid, 0, ',', '.') }}</td>
            </tr>
            <tr class="final">
                <td class="label">Kembalian</td>
                <td class="value">{{ number_format($transaction->payment->change, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Status -->
        <table class="info" style="margin-top:0.5mm">
            <tr>
                <td class="label">Status</td>
                <td class="value bold">LUNAS</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <div>Terima kasih telah berbelanja!</div>
            <div>Silakan datang kembali</div>
            <div class="qr-note">Scan QR untuk info lebih lanjut</div>
            <div style="font-size:5px; margin-top:0.5mm;">
                {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
            </div>
        </div>
    </div>
</body>

</html>
