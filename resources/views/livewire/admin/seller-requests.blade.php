
<div class="container py-4">
    <h2 class="mb-4 fw-bold">Pending Seller Requests</h2>


    <div class="content">
        <div class="container-fluid">
        <div class="row">
            @foreach(@$requests as $request)
                <div class="col-lg-9">

                    <div class="card card-primary card-outline">
                        <div class="card-body d-flex justify-content-between align-items-start flex-wrap">

    {{-- Left Side: Store Name & Email --}}
                            <div class="d-flex flex-column">
                                <h5 class="card-title mb-2">
                                    <strong>Store Name: </strong> {{ @$request->store_name }}
                                </h5>
                                <p class="card-text mb-0">
                                    <strong>User Email: </strong> {{ @$request->user->email }}
                                </p>
                            </div>

                            {{-- Right Side: Status & View Button --}}
                            <div class="d-flex flex-column align-items-end text-end">
                                <p class="card-text mb-2">
                                    <strong>Status: </strong>
                                    <span class="badge bg-warning text-dark">{{ @$request->status }}</span>
                                </p>
                                <a href="" wire:click.prevent="show_request({{ @$request->id }})" class="text-decoration-none">
                                    <i class="fa-solid fa-eye fa-lg text-primary"></i>
                                </a>
                            </div>

                        </div>

                    </div><!-- /.card -->
                </div><!-- /.card -->
            @endforeach
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    <div class="modal fade" id="form_requests" tabindex="-1" role="dialog" aria-labelledby="becomeSellerLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="card shadow mb-4">
                <div class="modal-header">
                    <h5 class="modal-title" id="becomeSellerLabel">
                        <i class="fa fa-store mr-1"></i> seller requests
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form wire:submit.prevent="submitRequest" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="row">
                            {{-- Store Logo Preview --}}
                            <div class="col-md-4 mb-3">
                                @if (@$store_logo)
                                    <img src="{{ asset('storage/' . @$store_logo) }}"
                                        class="img-fluid rounded border shadow-sm"
                                        style="max-height: 300px; object-fit: contain;"
                                        alt="Store Logo Preview">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center border"
                                        style="height: 300px;">
                                        <span class="text-muted">No Logo</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Store Info --}}
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><strong>Store Name</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.store_name" readonly>
                                    @error('state.store_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>Description</strong></label>
                                    <textarea class="form-control" rows="3" wire:model.defer="state.store_description" readonly></textarea>
                                    @error('state.store_description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>Phone</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.phone" readonly>
                                    @error('state.phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>stripe_account_id</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.stripe_account_id" readonly>
                                    @error('state.stripe_account_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label><strong>Address</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.address" readonly>
                                    @error('state.address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label><strong>Status</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.status"  readonly>
                                </div>

                                {{-- Admin Feedback --}}
                                @if (!empty($state['admin_feedback']))
                                    <div class="form-group">
                                        <label><strong>Admin Feedback</strong></label>
                                        <textarea class="form-control text-danger" wire:model.defer="state.admin_feedback" rows="2" readonly></textarea>
                                    </div>
                                @endif
                            </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Close
                        </button>

                        <button type="button" class="btn btn-success" wire:click.prevent="approved({{ $state['id'] ?? '' }})">
                            <i class="fa fa-check mr-1"></i> Approve
                        </button>

                        <button type="button" class="btn btn-danger" wire:click.prevent="rejected({{ $state['id'] ?? '' }})">
                            <i class="fa fa-times-circle mr-1"></i> Reject
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



</div>


