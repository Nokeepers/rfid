<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Device Status</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded text-sm">
            A device is marked <strong>online</strong> when it sends a heartbeat or scan within the last 5 minutes.
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($devices as $device)
                <div class="bg-white shadow rounded-lg p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $device->name }}</h3>
                            <p class="text-xs text-gray-500 font-mono">{{ $device->device_id }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $device->online ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $device->online ? '● Online' : '● Offline' }}
                        </span>
                    </div>

                    <dl class="mt-4 grid grid-cols-2 gap-2 text-sm">
                        <dt class="text-gray-500">Last Seen</dt>
                        <dd>{{ $device->last_seen_at?->diffForHumans() ?? 'Never' }}</dd>

                        <dt class="text-gray-500">IP Address</dt>
                        <dd class="font-mono text-xs">{{ $device->ip_address ?? '—' }}</dd>

                        <dt class="text-gray-500">Scans Today</dt>
                        <dd>{{ $device->scans_today }}</dd>

                        <dt class="text-gray-500">Total Scans</dt>
                        <dd>{{ $device->scans_total }}</dd>
                    </dl>
                </div>
            @empty
                <div class="col-span-full bg-white shadow rounded-lg p-6 text-center text-gray-500">
                    No devices have reported yet. Power up the Arduino + ESP8266 and wait for the first heartbeat.
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
