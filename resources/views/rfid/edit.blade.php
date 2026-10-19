<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit RFID Card — {{ $rfidCard->uid }}</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">

            @if($errors->any())
                <div class="mb-4 bg-red-100 text-red-800 p-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rfid.update', $rfidCard) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">RFID UID *</label>
                    <input type="text" name="uid" value="{{ old('uid', $rfidCard->uid) }}" required
                           class="w-full border-gray-300 rounded-md shadow-sm font-mono uppercase focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Owner Name *</label>
                    <input type="text" name="owner_name" value="{{ old('owner_name', $rfidCard->owner_name) }}" required
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Owner Email</label>
                        <input type="email" name="owner_email" value="{{ old('owner_email', $rfidCard->owner_email) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Owner Phone</label>
                        <input type="text" name="owner_phone" value="{{ old('owner_phone', $rfidCard->owner_phone) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $rfidCard->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Card is active</span>
                    </label>
                </div>

                <div class="flex justify-between pt-4 border-t">
                    <form action="{{ route('rfid.destroy', $rfidCard) }}" method="POST"
                          onsubmit="return confirm('Delete this card? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete Card
                        </button>
                    </form>

                    <div class="space-x-2">
                        <a href="{{ route('rfid.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
