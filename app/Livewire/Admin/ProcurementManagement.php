<?php

namespace App\Livewire\Admin;

use App\Models\Procurement;
use App\Models\ProcurementPlanning;
use Livewire\Component;
use Livewire\WithPagination;

class ProcurementManagement extends Component
{
    use WithPagination;

    public $procurement_planning_id;
    public $pr_number;
    public $pr_date;
    public $purpose;
    public $status = 'draft';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'procurement_planning_id' => 'required|exists:procurement_plannings,id',
        'pr_number' => 'required|string|unique:procurements,pr_number',
        'pr_date' => 'required|date',
        'purpose' => 'required|string',
        'status' => 'required|in:draft,for_approval,approved,for_bidding,bid_evaluation,awarded,po_issued,delivered,completed,cancelled',
    ];

    public function createProcurement()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $procurement = Procurement::find($this->editingId);
            $procurement->update([
                'procurement_planning_id' => $this->procurement_planning_id,
                'pr_number' => $this->pr_number,
                'pr_date' => $this->pr_date,
                'purpose' => $this->purpose,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Procurement updated successfully.');
        } else {
            Procurement::create([
                'procurement_planning_id' => $this->procurement_planning_id,
                'pr_number' => $this->pr_number,
                'pr_date' => $this->pr_date,
                'purpose' => $this->purpose,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Procurement created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $procurement = Procurement::find($id);
        $this->editingId = $id;
        $this->procurement_planning_id = $procurement->procurement_planning_id;
        $this->pr_number = $procurement->pr_number;
        $this->pr_date = $procurement->pr_date->format('Y-m-d');
        $this->purpose = $procurement->purpose;
        $this->status = $procurement->status;
        $this->showForm = true;
    }

    public function delete($id)
    {
        Procurement::find($id)->delete();
        session()->flash('message', 'Procurement deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['procurement_planning_id', 'pr_number', 'pr_date', 'purpose', 'status', 'editingId']);
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.procurement-management', [
            'procurements' => Procurement::with('procurementPlanning')->latest()->paginate(10),
            'plans' => ProcurementPlanning::where('status', 'approved')->get()
        ]);
    }
}