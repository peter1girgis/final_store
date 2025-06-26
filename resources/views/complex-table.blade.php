<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* مهم جدًا لتثبيت الأعمدة */
    }

    th, td {
        border: 1px solid #444;
        padding: 5px;
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
    }

    th {
        background-color: #f5f5f5;
    }

    /* ضبط عرض الأعمدة */
    th:nth-child(1), td:nth-child(1) { width: 30px; }
    th:nth-child(2), td:nth-child(2) { width: 160px; }
    th:nth-child(3), td:nth-child(3) { width: 120px; }
    th:nth-child(4), td:nth-child(4) { width: 70px; }
    th:nth-child(5), td:nth-child(5) { width: 60px; }
    th:nth-child(6), td:nth-child(6) { width: 80px; }
    th:nth-child(7), td:nth-child(7) { width: 70px; }
    th:nth-child(8), td:nth-child(8) { width: 100px; }
</style>

</head>
<body>
    <h2 style="text-align: center;">Payments Report</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Transaction ID</th>
            <th>Product Names</th>
            <th>Amount</th>
            <th>Qty</th>
            <th>Method</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $index => $payment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payment->payment_id }}</td>
                <td>{{ $payment->product->name }}</td>
                <td>{{ $payment->amount }} {{ strtoupper($payment->currency) }}</td>
                <td>{{ $payment->total_quantity }}</td>
                <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                <td>{{ ucfirst($payment->payment_status ?? 'N/A') }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
