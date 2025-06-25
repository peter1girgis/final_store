<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end mb-2">
                        <button wire:click.prevent="addNew" class="btn btn-outline-primary">
                            <i class="fa fa-plus-circle mr-1"></i> Add New Category
                        </button>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $index => $cat)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $cat->name }}</td>
                                            <td>
                                                @if ($cat->image)
                                                    <img src="{{ asset('storage/' . $cat->image) }}" width="60">
                                                @else
                                                    <span class="text-muted">No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $cat->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="#" wire:click.prevent="edit({{ $cat->id }})">
                                                    <i class="fa fa-edit mr-2"></i>
                                                </a>
                                                <a href="#" wire:click.prevent="confirmCategoryRemoval({{ $cat->id }})">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="formCategory" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="{{ $showEditModal ? 'updateCategory' : 'createCategory' }}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">
                            {{ $showEditModal ? 'Edit Category' : 'Add Category' }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" wire:model.defer="state.name" class="form-control @error('state.name') is-invalid @enderror">
                            @error('state.name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" wire:model="newImage" class="form-control @error('newImage') is-invalid @enderror">
                            @error('newImage') <span class="text-danger">{{ $message }}</span> @enderror

                            @if ($newImage)
                                <div class="mt-2">
                                    <img src="{{ $newImage->temporaryUrl() }}" width="100">
                                </div>
                            @elseif (!empty($state['image']))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $state['image']) }}" width="100">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fa fa-save mr-1"></i>
                            {{ $showEditModal ? 'Save Changes' : 'Save' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" wire:click="$set('CategoryIdBeingRemoved', null)">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-outline-danger" wire:click="deleteCategory">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
