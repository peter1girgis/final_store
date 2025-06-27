<div class="container py-4">
    <h3 class="mb-4">📦 My Orders</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Total Quantity</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->store->store_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge
                                @if($order->state_of_order == 'waiting') badge-warning
                                @elseif($order->state_of_order == 'in_processing') badge-primary
                                @else badge-success @endif">
                                {{ ucfirst($order->state_of_order) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge
                                @if($order->state_of_payment == 'pending') badge-warning
                                @elseif($order->state_of_payment == 'failed') badge-danger
                                @else badge-success @endif">
                                {{ ucfirst($order->state_of_payment) }}
                            </span>
                        </td>
                        <td>{{ $order->total_quantity }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-info"
                                    wire:click="viewOrder({{ $order->id }})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>

    {{-- Modal for order details --}}
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">
                        <i class="fas fa-receipt"></i> Order Details
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @if($selectedOrder)
                    <div class="modal-body">
                        <div class="mb-3">
                            <strong>Order ID:</strong> {{ $selectedOrder->id }} <br>
                            <strong>Status:</strong>
                            <span class="badge badge-{{ $selectedOrder->state_of_order == 'waiting' ? 'warning' : ($selectedOrder->state_of_order == 'in_processing' ? 'info' : 'success') }}">
                                {{ ucfirst($selectedOrder->state_of_order) }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <strong>Customer:</strong> {{ $selectedOrder->user_email }} <br>
                            <strong>Phone:</strong> {{ $selectedOrder->user_phone_number }} <br>
                            <strong>Address:</strong> {{ $selectedOrder->user_address }}
                        </div>

                        <hr>

                        <h6>Products:</h6>
                        <ul class="list-group">
                            @foreach (json_decode($selectedOrder->products, true) as $item)
                                @php
                                    $product = \App\Models\Product::find($item['product_id']);
                                @endphp
                                @if ($product)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $product->name }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($product->description, 60) }}</small>
                                        </div>
                                        <span class="badge badge-primary badge-pill">Qty: {{ $item['quantity'] }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <div class="mt-4 text-right">
                            <strong>Total Quantity:</strong> {{ $selectedOrder->total_quantity }}
                        </div>
                    </div>
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
