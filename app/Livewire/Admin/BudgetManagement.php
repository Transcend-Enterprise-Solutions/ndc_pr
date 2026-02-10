<?php

namespace App\Livewire\Admin;

use App\Models\Budget;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('layouts.app')]
#[Title('Budget Management')]
class BudgetManagement extends Component
{
    use WithPagination;

    public $fiscal_year;
    public $department;
    public $total_amount;
    public $description;
    public $status = 'draft';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'fiscal_year' => 'required|string',
        'department' => 'required|string',
        'total_amount' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'status' => 'required|in:draft,submitted,approved,rejected',
    ];

    public function createBudget()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $budget = Budget::find($this->editingId);
            $budget->update([
                'fiscal_year' => $this->fiscal_year,
                'department' => $this->department,
                'total_amount' => $this->total_amount,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Budget updated successfully.');
        } else {
            Budget::create([
                'fiscal_year' => $this->fiscal_year,
                'department' => $this->department,
                'total_amount' => $this->total_amount,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Budget created successfully.');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $budget = Budget::find($id);
        $this->editingId = $id;
        $this->fiscal_year = $budget->fiscal_year;
        $this->department = $budget->department;
        $this->total_amount = $budget->total_amount;
        $this->description = $budget->description;
        $this->status = $budget->status;
        $this->showForm = true;
    }

    public function delete($id)
    {
        Budget::find($id)->delete();
        session()->flash('message', 'Budget deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['fiscal_year', 'department', 'total_amount', 'description', 'status', 'editingId']);
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.budget-management', [
            'budgets' => Budget::latest()->paginate(10)
        ]);
    }
}