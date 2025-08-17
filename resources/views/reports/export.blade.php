<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            color: #666;
        }
        .summary {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            width: 30%;
        }
        .summary-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 20px;
            color: #333;
        }
        .transactions {
            margin-bottom: 30px;
        }
        .transactions-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">POS SYSTEM</div>
        <div class="subtitle">{{ $title }}</div>
        <div>Generated on: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="summary">
        <div class="summary-box">
            <div class="summary-title">Total Sales</div>
            <div class="summary-value">Rp {{ number_format($total_sales, 0, ',', '.') }}</div>
        </div>
        <div class="summary-box">
            <div class="summary-title">Total Transactions</div>
            <div class="summary-value">{{ $total_transactions }}</div>
        </div>
        <div class="summary-box">
            <div class="summary-title">Average Transaction</div>
            <div class="summary-value">Rp {{ $total_transactions > 0 ? number_format($total_sales / $total_transactions, 0, ',', '.') : '0' }}</div>
        </div>
    </div>

    <div class="transactions">
        <div class="transactions-title">Transaction Details</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Cashier</th>
                    <th>Payment Method</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ strtoupper($transaction->payment_method) }}</td>
                    <td>{{ $transaction->transactionDetails->count() }}</td>
                    <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div>This report was generated automatically by POS System</div>
        <div>© {{ date('Y') }} POS System. All rights reserved.</div>
    </div>
</body>
</html> 