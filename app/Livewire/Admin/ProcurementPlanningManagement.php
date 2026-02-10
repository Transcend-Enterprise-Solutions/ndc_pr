<?php

namespace App\Livewire\Admin;

use App\Models\Budget;
use App\Models\ProcurementPlanning;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('layouts.app')]
#[Title('Procurement Planning')]
class ProcurementPlanningManagement extends Component
{
    use WithPagination;

    public $budget_id;
    public $item_description;
    public $estimated_budget;
    public $quantity;
    public $unit_of_measure;
    public $target_procurement_date;
    public $procurement_mode = 'public_bidding';
    public $justification;
    public $status = 'planned';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'budget_id' => 'required|exists:budgets,id',
        'item_description' => 'required|string',
        'estimated_budget' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:1',
        'unit_of_measure' => 'required|string',
        'target_procurement_date' => 'required|date',
        'procurement_mode' => 'required|in:public_bidding,limited_source_bidding,direct_contracting,repeat_order,shopping,negotiated_procurement',
        'justification' => 'nullable|string',
        'status' => 'required|in:planned,approved,cancelled',
    ];

    public function createPlan()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $plan = ProcurementPlanning::find($this->editingId);
            $plan->update([
                'budget_id' => $this->budget_id,
                'item_description' => $this->item_description,
                'estimated_budget' => $this->estimated_budget,
                'quantity' => $this->quantity,
                'unit_of_measure' => $this->unit_of_measure,
                'target_procurement_date' => $this->target_procurement_date,
                'procurement_mode' => $this->procurement_mode,
                'justification' => $this->justification,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Procurement plan updated successfully.');
        } else {
            ProcurementPlanning::create([
                'budget_id' => $this->budget_id,
                'item_description' => $this->item_description,
                'estimated_budget' => $this->estimated_budget,
                'quantity' => $this->quantity,
                'unit_of_measure' => $this->unit_of_measure,
                'target_procurement_date' => $this->target_procurement_date,
                'procurement_mode' => $this->procurement_mode,
                'justification' => $this->justification,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Procurement plan created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $plan = ProcurementPlanning::find($id);
        $this->editingId = $id;
        $this->budget_id = $plan->budget_id;
        $this->item_description = $plan->item_description;
        $this->estimated_budget = $plan->estimated_budget;
        $this->quantity = $plan->quantity;
        $this->unit_of_measure = $plan->unit_of_measure;
        $this->target_procurement_date = $plan->target_procurement_date->format('Y-m-d');
        $this->procurement_mode = $plan->procurement_mode;
        $this->justification = $plan->justification;
        $this->status = $plan->status;
        $this->showForm = true;
    }

    public function delete($id)
    {
        ProcurementPlanning::find($id)->delete();
        session()->flash('message', 'Procurement plan deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset([
            'budget_id', 'item_description', 'estimated_budget', 'quantity',
            'unit_of_measure', 'target_procurement_date', 'procurement_mode',
            'justification', 'status', 'editingId'
        ]);
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.procurement-planning-management', [
            'plans' => ProcurementPlanning::with('budget')->latest()->paginate(10),
            'budgets' => Budget::where('status', 'approved')->get()
        ]);
    }
}
