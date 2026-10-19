<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Total RFID Cards</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalCards }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $activeCards }} active</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Scans Today</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $todayScans }}</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Unknown Scans Today</p>
                    <p class="text-3xl font-bold text-red-600">{{ $unknownScans }}</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Device Status</p>
                    <p class="text-xl font-bold {{ $deviceOnline ? 'text-green-600' : 'text-red-600' }}">
                        {{ $deviceOnline ? '● Online' : '● Offline' }}
                    </p>
                    @if($lastDevice)
                        <p class="text-xs text-gray-400 mt-1 truncate">
                            {{ $lastDevice->device_id }} —
                            {{ $lastDevice->last_seen_at?->diffForHumans() ?? 'never' }}
                        </p>
                    @else
                        <p class="text-xs text-gray-400 mt-1">No device has reported yet</p>
                    @endif
                </div>
            </div>

            {{-- Recent Scans --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Recent RFID Scans</h3>
                        <a href="{{ route('scans.index') }}" class="text-sm text-blue-600 hover:underline">
                            View all →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">UID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Owner</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Device</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($recentScans as $scan)
                                    <tr>
                                        <td class="px-4 py-2 font-mono text-sm">{{ $scan->uid }}</td>
                                        <td class="px-4 py-2 text-sm">{{ $scan->rfidCard?->owner_name ?? '—' }}</td>
                                        <td class="px-4 py-2 text-xs text-gray-500">{{ $scan->device_id }}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $scan->status === 'authorized' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $scan->status === 'unknown'    ? 'bg-red-100 text-red-800'     : '' }}
                                                {{ $scan->status === 'inactive'   ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                {{ ucfirst($scan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            {{ $scan->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                            No scans yet. Waiting for the ESP8266 to send data…
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
