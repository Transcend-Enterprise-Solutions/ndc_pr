<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Procurement Management</h2>
        <button wire:click="createProcurement" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + New Procurement
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if ($showForm)
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">{{ $editingId ? 'Edit Procurement' : 'Create New Procurement' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Procurement Plan</label>
                    <select wire:model="procurement_planning_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Procurement Plan</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->item_description }}</option>
                        @endforeach
                    </select>
                    @error('procurement_planning_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">PR Number</label>
                    <input type="text" wire:model="pr_number" placeholder="PR-2024-001" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('pr_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">PR Date</label>
                    <input type="date" wire:model="pr_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('pr_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="draft">Draft</option>
                        <option value="for_approval">For Approval</option>
                        <option value="approved">Approved</option>
                        <option value="for_bidding">For Bidding</option>
                        <option value="bid_evaluation">Bid Evaluation</option>
                        <option value="awarded">Awarded</option>
                        <option value="po_issued">PO Issued</option>
                        <option value="delivered">Delivered</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Purpose</label>
                    <textarea wire:model="purpose" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    @error('purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button wire:click="cancel" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                    Cancel
                </button>
                <button wire:click="save" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    {{ $editingId ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PR Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($procurements as $procurement)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $procurement->pr_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $procurement->pr_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">{{ $procurement->procurementPlanning->item_description ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ Str::limit($procurement->purpose, 40) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($procurement->status === 'completed') bg-green-100 text-green-800
                                @elseif($procurement->status === 'cancelled') bg-red-100 text-red-800
                                @elseif(in_array($procurement->status, ['approved', 'awarded'])) bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ str_replace('_', ' ', ucwords($procurement->status, '_')) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="edit({{ $procurement->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                            <button wire:click="delete({{ $procurement->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $procurements->links() }}
    </div>
</div>