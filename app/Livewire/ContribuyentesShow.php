<?php

namespace App\Livewire;

use App\Models\Contribuyente;
use Livewire\Component;

class ContribuyentesShow extends Component
{
    public Contribuyente $contribuyente;

    public function mount(Contribuyente $contribuyente): void
    {
        $this->contribuyente = $contribuyente;
    }

    public function render()
    {
        return view('livewire.contribuyentes-show');
    }
}