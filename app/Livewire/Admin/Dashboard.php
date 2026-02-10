<?php

namespace App\Livewire\Admin;

use App\Models\Budget;
use App\Models\Procurement;
use App\Models\Contract;
use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->stats = [
            'total_budgets' => Budget::count(),
            'approved_budgets' => Budget::where('status', 'approved')->count(),
            'active_procurements' => Procurement::whereIn('status', ['approved', 'for_bidding', 'bid_evaluation', 'awarded'])->count(),
            'active_contracts' => Contract::whereIn('status', ['executed', 'ongoing'])->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_budget_amount' => Budget::where('status', 'approved')->sum('total_amount'),
            'total_contract_amount' => Contract::sum('contract_amount'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}