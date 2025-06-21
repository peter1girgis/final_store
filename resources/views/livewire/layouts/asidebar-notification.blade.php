<div >
    <aside class="control-sidebar control-sidebar-dark" >
        <div class="p-3"  wire:poll.5s>
            <h5>Notifications</h5>

            @forelse ($notifications as $notification)
                <div class="mb-2 border-bottom pb-2">
                    <strong>{{ $notification['title'] }} : <br></strong>
                    <strong class="text-muted mb-1" style="font-size: 14px;">
                        {{ $notification['message'] }}
                    </strong>
                    <br>
                    <small class="text-light">
                        {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                    </small>
                </div>
            @empty
                <p class="text-muted">No notifications found.</p>
            @endforelse
        </div>
    </aside>

</div>
