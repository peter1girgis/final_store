<div class="container py-4">
    <h3 class="mb-4">🧾 Manage All Orders</h3>

    <input type="text" class="form-control mb-3" placeholder="🔍 Search by user name..." wire:model.live="search" />

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Store</th>
                <th>Status</th>
                <th>Phone</th>
                <th>Qty</th>
                <th>View/Edit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ $order->store->store_name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($order->state_of_order) }}</td>
                    <td>{{ $order->user_phone_number }}</td>
                    <td>{{ $order->total_quantity }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" wire:click="viewOrder({{ $order->id }})">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}

    {{-- Modal --}}
    <div wire:ignore.self class="modal fade" id="orderModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                @if($selectedOrder)
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Order #{{ $selectedOrder->id }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" wire:model.defer="editedPhone">
                        </div>

                        <div class="mb-2">
                            <label>Order Status</label>
                            <select class="form-control" wire:model.defer="editedState">
                                <option value="waiting" {{ $editedState === 'waiting' ? 'selected' : '' }}>Waiting</option>
                                <option value="in_processing" {{ $editedState === 'in_processing' ? 'selected' : '' }}>In Processing</option>
                                <option value="delivered" {{ $editedState === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>


                        <hr>
                        <h5>Products</h5>
                        @foreach ($editedProducts as $index => $item)
                            @php $product = \App\Models\Product::find($item['product_id']); @endphp
                            @if($product)
                                <div class="d-flex justify-content-between align-items-center border p-2 mb-2">
                                    <div>
                                        <strong>{{ $product->name }}</strong><br>
                                        <small>{{ Str::limit($product->description, 60) }}</small>
                                    </div>
                                    <div>
                                        <input type="number" class="form-control" wire:model.defer="editedProducts.{{ $index }}.quantity" min="1">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" wire:click="updateOrder">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                        <button class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

