<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Scan History</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

        {{-- Filters --}}
        <div class="bg-white shadow rounded-lg p-4">
            <form method="GET" action="{{ route('scans.index') }}"
                  class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                    <select name="status"
                            class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All</option>
                        @foreach(['authorized','unknown','inactive'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">UID</label>
                    <input type="text" name="uid" value="{{ request('uid') }}"
                           class="w-full border-gray-300 rounded-md text-sm font-mono focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Device</label>
                    <select name="device_id"
                            class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All</option>
                        @foreach($devices as $d)
                            <option value="{{ $d }}" @selected(request('device_id') === $d)>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                           class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
                    <input type="date" name="to" value="{{ request('to') }}"
                           class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex space-x-2">
                    <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        Filter
                    </button>
                    <a href="{{ route('scans.index') }}"
                       class="px-3 py-2 bg-gray-200 text-gray-800 text-sm rounded hover:bg-gray-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Results --}}
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">#</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">UID</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Owner</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Device</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">IP</th>
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Time</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($scans as $scan)
                            <tr>
                                <td class="px-4 py-2 text-xs text-gray-500">{{ $scan->id }}</td>
                                <td class="px-4 py-2 font-mono text-sm">{{ $scan->uid }}</td>
                                <td class="px-4 py-2 text-sm">{{ $scan->rfidCard?->owner_name ?? '—' }}</td>
                                <td class="px-4 py-2 text-xs text-gray-600">{{ $scan->device_id }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $scan->status === 'authorized' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $scan->status === 'unknown'    ? 'bg-red-100 text-red-800'     : '' }}
                                        {{ $scan->status === 'inactive'   ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ ucfirst($scan->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-500">{{ $scan->ip_address ?? '—' }}</td>
                                <td class="px-4 py-2 text-xs text-gray-600">{{ $scan->created_at->format('Y-m-d H:i:s') }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('scans.show', $scan) }}"
                                       class="text-blue-600 hover:underline text-sm">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                    No scans match the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">{{ $scans->links() }}</div>
        </div>
    </div>
</x-app-layout>
