<div class="container py-20 max-w-7xl mx-auto">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Browse Our Main Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Main Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-xl-1 g-4">
        @foreach($mainCategories as $mainCategory)
            <div class="col">
                <div class="card text-bg-dark h-100 position-relative overflow-hidden border-0 rounded-5">
                    @if ($mainCategory->image)
                        <img src="{{ asset('storage/' . $mainCategory->image) }}"
                             class="card-img h-100 object-fit-cover rounded-5" alt="{{ $mainCategory->name }}">
                    @else
                        <div class="card-img h-100 d-flex align-items-center justify-content-center bg-secondary text-white fs-5 rounded-5">
                            No Image
                        </div>
                    @endif

                    <div class="card-img-overlay d-flex flex-column justify-content-end text-white text-center"
                         style="background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)); border-radius: 2rem;">
                        <h5 class="card-title mb-1" style="font-size: 60px;">{{ $mainCategory->name }}</h5>
                        <p class="card-text mb-3" style="font-size: 30px;">{{ $mainCategory->categories_count }} subcategories
                            <a href="{{route('main-category.show',$mainCategory->id)}}" style="height: 40px; width: 70px; font-size: large;" class="btn btn-sm btn-outline-primary ml-1">View</a>
                        </p>

                    </div>


                </div>
            </div>
        @endforeach
    </div>
</div>
