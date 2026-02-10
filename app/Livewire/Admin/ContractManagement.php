<?php

namespace App\Livewire\Admin;

use App\Models\Contract;
use App\Models\Procurement;
use Livewire\Component;
use Livewire\WithPagination;

class ContractManagement extends Component
{
    use WithPagination;

    public $procurement_id;
    public $contract_number;
    public $supplier_name;
    public $supplier_tin;
    public $supplier_address;
    public $contract_amount;
    public $contract_date;
    public $delivery_date;
    public $delivery_days;
    public $terms_and_conditions;
    public $status = 'executed';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'procurement_id' => 'required|exists:procurements,id',
        'contract_number' => 'required|string|unique:contracts,contract_number',
        'supplier_name' => 'required|string',
        'supplier_tin' => 'required|string',
        'supplier_address' => 'required|string',
        'contract_amount' => 'required|numeric|min:0',
        'contract_date' => 'required|date',
        'delivery_date' => 'required|date',
        'delivery_days' => 'required|integer|min:1',
        'terms_and_conditions' => 'nullable|string',
        'status' => 'required|in:executed,ongoing,completed,terminated',
    ];

    public function createContract()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $contract = Contract::find($this->editingId);
            $contract->update([
                'procurement_id' => $this->procurement_id,
                'contract_number' => $this->contract_number,
                'supplier_name' => $this->supplier_name,
                'supplier_tin' => $this->supplier_tin,
                'supplier_address' => $this->supplier_address,
                'contract_amount' => $this->contract_amount,
                'contract_date' => $this->contract_date,
                'delivery_date' => $this->delivery_date,
                'delivery_days' => $this->delivery_days,
                'terms_and_conditions' => $this->terms_and_conditions,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Contract updated successfully.');
        } else {
            Contract::create([
                'procurement_id' => $this->procurement_id,
                'contract_number' => $this->contract_number,
                'supplier_name' => $this->supplier_name,
                'supplier_tin' => $this->supplier_tin,
                'supplier_address' => $this->supplier_address,
                'contract_amount' => $this->contract_amount,
                'contract_date' => $this->contract_date,
                'delivery_date' => $this->delivery_date,
                'delivery_days' => $this->delivery_days,
                'terms_and_conditions' => $this->terms_and_conditions,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Contract created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $contract = Contract::find($id);
        $this->editingId = $id;
        $this->procurement_id = $contract->procurement_id;
        $this->contract_number = $contract->contract_number;
        $this->supplier_name = $contract->supplier_name;
        $this->supplier_tin = $contract->supplier_tin;
        $this->supplier_address = $contract->supplier_address;
        $this->contract_amount = $contract->contract_amount;
        $this->contract_date = $contract->contract_date->format('Y-m-d');
        $this->delivery_date = $contract->delivery_date->format('Y-m-d');
        $this->delivery_days = $contract->delivery_days;
        $this->terms_and_conditions = $contract->terms_and_conditions;
        $this->status = $contract->status;
        $this->showForm = true;
    }

    public function delete($id)
    {
        Contract::find($id)->delete();
        session()->flash('message', 'Contract deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset([
            'procurement_id', 'contract_number', 'supplier_name', 'supplier_tin',
            'supplier_address', 'contract_amount', 'contract_date', 'delivery_date',
            'delivery_days', 'terms_and_conditions', 'status', 'editingId'
        ]);
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.contract-management', [
            'contracts' => Contract::with('procurement')->latest()->paginate(10),
            'procurements' => Procurement::where('status', 'awarded')->get()
        ]);
    }
}
