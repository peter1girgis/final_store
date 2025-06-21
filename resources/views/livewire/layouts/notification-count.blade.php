<div wire:poll.5s>
    <li class="nav-item">
    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="far fa-bell" style="font-size: 18px;"></i>
        <span class="badge badge-warning navbar-badge" style="font-size: 12px;">
            {{ auth()->user()->notifications->count() }}
        </span>
    </a>
</li>

</div>
