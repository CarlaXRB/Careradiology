<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Radiography;
use App\Models\Tomography;
use Illuminate\Support\Facades\DB;

class DashboardChart extends Component
{
    public $data = [];
    public function mount(){
        $this->data=[
            'patients'=>Patient::count(),
            'radiographies'=>Radiography::count(),
            'tomographies'=>Tomography::count(),
        ];
    }
    public function render(){
        return view('livewire.dashboard-chart');
    }
}
