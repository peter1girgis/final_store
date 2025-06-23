<div>
    <aside class="control-sidebar control-sidebar-dark" style="width: 300px; overflow-y: auto;">
        <div class="p-3" wire:poll.5s style="max-height: 90vh; overflow-y: auto;">
            <h5>Notifications</h5>

            @forelse ($notifications as $notification)
                <div class="mb-2 border-bottom pb-2" style="word-wrap: break-word;">
                    <strong>{{ $notification['title'] }} : <br></strong>

                    <strong class="text-muted mb-1" style="font-size: 14px; word-break: break-word;">
                        {{ $notification['type'] }}
                    </strong><br>

                    <strong class="text-muted mb-1" style="font-size: 14px; word-break: break-word;">
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

