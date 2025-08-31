@php
    echo "<?php".PHP_EOL;
@endphp

namespace App\Livewire\{{trim($config->modelNames->plural)}};

use Livewire\Component;
use Livewire\Attributes\On;

class Filter extends Component
{

    //screen attributes
    public $open;
    
    //filter fields
    public $dateType;
    public $active;
    public $initialDate;
    public $endDate;

    public function mount(){
        $this->open = false;
        $this->standardFields();
    }

    public function render()
    {
        return view('{{$config->modelNames->snakePlural}}.filter');
    }

    #[On('openFilter')]
    public function openFilter()
    {
        $this->open = true;
    }

    public function resetFields(){
        $this->standardFields();
    }

    public function updated(){
        $this->dispatch('filter',$this->all());
    }

    private function standardFields(){
        $this->dateType = 'C';
        $this->active = true;
        $this->initialDate = $this->endDate = null;
    }

}
