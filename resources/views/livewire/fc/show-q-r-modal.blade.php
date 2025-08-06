<div>
    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h2 class="text-lg font-bold mb-4">Row Details</h2>

                @if($record)
                    <p><strong>ID:</strong> {{ $record->id }}</p>
                    <p><strong>Name:</strong> {{ $record->name ?? 'N/A' }}</p>
                    <p><strong>Other Field:</strong> {{ $record->other_field ?? 'N/A' }}</p>
                @else
                    <p>No data found.</p>
                @endif

                <div class="mt-4 text-right">
                    <button wire:click="closeModal" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
