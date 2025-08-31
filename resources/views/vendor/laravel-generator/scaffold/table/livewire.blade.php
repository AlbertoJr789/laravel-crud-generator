@php
    echo "<?php".PHP_EOL;
    $fields = [
        'inline' => array_map(function($field){
            return  "$$field->name";
        },$config->fields),
         'this' =>  array_map(function($field){
            return '$this->'.$field->name;
        },$config->fields),
        'thisEq' => array_map(function($field) use ($config){
            $name = $config->modelNames->camel;
            return '$this->'.$field->name." = $$name->".$field->name;
        },$config->fields)
    ];
@endphp

namespace App\Livewire\{{$config->modelNames->plural}};

use App\Models\{{$config->modelNames->name}};
use App\Repositories\{{$config->modelNames->name}}Repository;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{

    //screen attributes
    public $open, $create, $update;

    public ?{{$config->modelNames->name}} ${{$config->modelNames->name}};

    //attributes
    public {!! implode(',',$fields['inline']) !!},$active;
    
    
    public function mount(){
        $this->open = $this->create = $this->update = false;
        ${{$config->modelNames->name}} = null;
        {!! implode(' = ',$fields['this']) !!} = $this->active = null;
    
    }

    public function render()
    {
        return view('{{$config->modelNames->snakePlural}}.create');
    }

    #[On('openCreate')]
    public function openCreate()
    {
        $this->reset();
        $this->create = true;
        $this->open = true;
    }

    #[On('openEdit')]
    public function openEdit({{$config->modelNames->name}} ${{$config->modelNames->camel}})
    {
        $this->{{$config->modelNames->name}} = ${{$config->modelNames->camel}};
        {!! implode(';',$fields['thisEq']) !!};
        $this->active = ${{$config->modelNames->camel}}->active;
        $this->open = $this->update = true;
        $this->create = false;
    }

    #[On('delete')]
    public function delete(${{$config->modelNames->camelPlural}}){
        try {
            if(!is_array(${{$config->modelNames->camelPlural}}))
                ${{$config->modelNames->camelPlural}} = [${{$config->modelNames->camelPlural}}];
            (new {{$config->modelNames->name}}Repository)->deleteMultiple(${{$config->modelNames->camelPlural}});
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => '{{$config->modelNames->name}}(s) '.__('deleted successfuly!')
            ];
        } catch (\Throwable $th) {
            $message = [
                'icon' => 'error',
                'title' => __('Error'),
                'text' => __('Whoops! Something went wrong.')
            ];
        }
        $this->dispatch('alert',$message);
    }

    #[On('restore')]
    public function restore(${{$config->modelNames->camelPlural}}){
        try {
            if(!is_array(${{$config->modelNames->camelPlural}}))
                ${{$config->modelNames->camelPlural}} = [${{$config->modelNames->camelPlural}}];
            (new {{$config->modelNames->name}}Repository)->restoreMultiple(${{$config->modelNames->camelPlural}});
            $message = [
                'icon' => 'success',
                'title' => __('Success'),
                'text' => '{{$config->modelNames->name}}(s) '.__('restored successfuly!')
            ];
        } catch (\Throwable $th) {
            $message = [
                'icon' => 'error',
                'title' => __('Error'),
                'text' => __('Whoops! Something went wrong.')
            ];
        }
        $this->dispatch('alert',$message);
    }
}
