<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Procurement Planning</h2>
        <button wire:click="createPlan" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + New Procurement Plan
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if ($showForm)
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">{{ $editingId ? 'Edit Procurement Plan' : 'Create New Procurement Plan' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Budget</label>
                    <select wire:model="budget_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Budget</option>
                        @foreach($budgets as $budget)
                            <option value="{{ $budget->id }}">{{ $budget->fiscal_year }} - {{ $budget->department }}</option>
                        @endforeach
                    </select>
                    @error('budget_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Item Description</label>
                    <input type="text" wire:model="item_description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('item_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Budget</label>
                    <input type="number" step="0.01" wire:model="estimated_budget" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('estimated_budget') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <input type="number" wire:model="quantity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit of Measure</label>
                    <input type="text" wire:model="unit_of_measure" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('unit_of_measure') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Target Procurement Date</label>
                    <input type="date" wire:model="target_procurement_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('target_procurement_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Procurement Mode</label>
                    <select wire:model="procurement_mode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="public_bidding">Public Bidding</option>
                        <option value="limited_source_bidding">Limited Source Bidding</option>
                        <option value="direct_contracting">Direct Contracting</option>
                        <option value="repeat_order">Repeat Order</option>
                        <option value="shopping">Shopping</option>
                        <option value="negotiated_procurement">Negotiated Procurement</option>
                    </select>
                    @error('procurement_mode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="planned">Planned</option>
                        <option value="approved">Approved</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Justification</label>
                    <textarea wire:model="justification" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    @error('justification') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Budget</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($plans as $plan)
                    <tr>
                        <td class="px-6 py-4">{{ $plan->item_description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">₱{{ number_format($plan->estimated_budget, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $plan->quantity }} {{ $plan->unit_of_measure }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $plan->target_procurement_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs">{{ str_replace('_', ' ', ucwords($plan->procurement_mode, '_')) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($plan->status === 'approved') bg-green-100 text-green-800
                                @elseif($plan->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($plan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="edit({{ $plan->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                            <button wire:click="delete({{ $plan->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $plans->links() }}
    </div>
</div>