<div wire:poll.5s>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">

            <i class="fas fa-cart-plus"></i>
            <span class="badge badge-warning navbar-badge">
                {{ auth()->user()->cartItems->sum('quantity') }}
            </span>

        </a>
</div>
