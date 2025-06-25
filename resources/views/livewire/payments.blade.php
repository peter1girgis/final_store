<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-credit-card mr-2"></i> Payments History</h4>
        </div>
        <div class="card-body p-0">

            <button wire:click="exportToPdf" class="btn btn-lg btn-outline-primary m-1">Download PDF</button>

            @if(count($payments) > 0)
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Transaction ID</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Quantity</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment->payment_id }}</td>
                                    <td>{{ $payment->product_names }}</td>
                                    <td>{{ $payment->amount }} {{ strtoupper($payment->currency) }}</td>
                                    <td>{{ $payment->total_quantity }}</td>
                                    <td>{{ ucfirst($payment->payment_method) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $payment->payment_status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 text-center text-muted">
                    <i class="fas fa-info-circle"></i> No payment records found.
                </div>
            @endif
        </div>
    </div>
</div>
