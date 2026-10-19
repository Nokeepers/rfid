<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Reports</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

        {{-- Filter Bar --}}
        <div class="bg-white shadow rounded-lg p-4">
            <form method="GET" action="{{ route('reports.index') }}"
                  class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
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
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">RFID User</label>
                    <select name="rfid_card_id"
                            class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All users</option>
                        @foreach($cards as $c)
                            <option value="{{ $c->id }}" @selected((string)request('rfid_card_id') === (string)$c->id)>
                                {{ $c->owner_name }} ({{ $c->uid }})
                            </option>
                        @endforeach
                    </select>
                </div>
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
                <div class="md:col-span-2 flex justify-end space-x-2">
                    <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                        Generate
                    </button>
                    <a href="{{ route('reports.index') }}"
                       class="px-3 py-2 bg-gray-200 text-gray-800 text-sm rounded hover:bg-gray-300">
                        Reset
                    </a>
                    <a href="{{ route('reports.export', request()->query()) }}"
                       class="px-3 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                        Export CSV
                    </a>
                </div>
            </form>
        </div>

        {{-- Summary --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-xs uppercase text-gray-500">Total Scans</p>
                <p class="text-2xl font-bold text-gray-800">{{ $summary['total'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-xs uppercase text-gray-500">Authorized</p>
                <p class="text-2xl font-bold text-green-600">{{ $summary['authorized'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-xs uppercase text-gray-500">Unknown</p>
                <p class="text-2xl font-bold text-red-600">{{ $summary['unknown'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-xs uppercase text-gray-500">Inactive</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $summary['inactive'] }}</p>
            </div>
        </div>

        {{-- Results Table --}}
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
                            <th class="px-4 py-2 text-left text-xs uppercase text-gray-500">Time</th>
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
                                <td class="px-4 py-2 text-xs text-gray-600">{{ $scan->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    No records found for the selected filters.
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
