<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Contract Management</h2>
        <button wire:click="createContract" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + New Contract
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if ($showForm)
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">{{ $editingId ? 'Edit Contract' : 'Create New Contract' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Procurement</label>
                    <select wire:model="procurement_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Procurement</option>
                        @foreach($procurements as $procurement)
                            <option value="{{ $procurement->id }}">{{ $procurement->pr_number }}</option>
                        @endforeach
                    </select>
                    @error('procurement_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contract Number</label>
                    <input type="text" wire:model="contract_number" placeholder="CN-2024-001" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('contract_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Supplier Name</label>
                    <input type="text" wire:model="supplier_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('supplier_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Supplier TIN</label>
                    <input type="text" wire:model="supplier_tin" placeholder="000-000-000-000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('supplier_tin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Supplier Address</label>
                    <input type="text" wire:model="supplier_address" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('supplier_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contract Amount</label>
                    <input type="number" step="0.01" wire:model="contract_amount" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('contract_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contract Date</label>
                    <input type="date" wire:model="contract_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('contract_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Date</label>
                    <input type="date" wire:model="delivery_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('delivery_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Days</label>
                    <input type="number" wire:model="delivery_days" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('delivery_days') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="executed">Executed</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                        <option value="terminated">Terminated</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Terms and Conditions</label>
                    <textarea wire:model="terms_and_conditions" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    @error('terms_and_conditions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contract No.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contract Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($contracts as $contract)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $contract->contract_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $contract->supplier_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">₱{{ number_format($contract->contract_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $contract->contract_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $contract->delivery_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($contract->status === 'completed') bg-green-100 text-green-800
                                @elseif($contract->status === 'terminated') bg-red-100 text-red-800
                                @elseif($contract->status === 'ongoing') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($contract->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button wire:click="edit({{ $contract->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                            <button wire:click="delete({{ $contract->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $contracts->links() }}
    </div>
</div>