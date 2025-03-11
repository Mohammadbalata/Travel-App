<div class="relative">
    <button @click="notificationsOpen = !notificationsOpen" class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <!-- Notification Count Badge -->
        @if($unreadNotificationsCount > 0)
        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
            {{ $unreadNotificationsCount }}
        </span>
        @endif
    </button>

    <!-- Notifications Dropdown Content -->
    <div x-show="notificationsOpen" @click.away="notificationsOpen = false" class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
        <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">Notifications</h3>
            <div class="divide-y divide-gray-200">
                @forelse($notifications as $notification)
                <div class="py-2">
                    <p class="text-sm text-gray-700">{{ $notification->data['body'] }}</p>
                    <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @empty
                <p class="text-sm text-gray-500">No new notifications.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const id = "{{Auth::id()}}";

    Pusher.logToConsole = true;

    var pusher = new Pusher('d917e76cffb0a5d90d4e', {
        cluster: 'ap2',
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        }
    });

    var channel = pusher.subscribe(`private-user-collaborate-channel.${id}`);
    channel.bind('user-collaborate-event', function(data) {
        alert(JSON.stringify(data));
    });
</script>