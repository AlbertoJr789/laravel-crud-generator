@php
echo "
<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->controller }};

@if(config('laravel_generator.tables') === 'datatables')
use {{ $config->namespaces->dataTables }}\{{ $config->modelNames->name }}DataTable;
@endif
use {{ $config->namespaces->request }}\Create{{ $config->modelNames->name }}Request;
use {{ $config->namespaces->request }}\Update{{ $config->modelNames->name }}Request;
use {{ $config->namespaces->app }}\Http\Controllers\AppBaseController;
use {{ $config->namespaces->repository }}\{{ $config->modelNames->name }}Repository;
use Illuminate\Http\Request;
use Flash;
use App\Models\{{ $config->modelNames->name }};
use Yajra\DataTables\Facades\DataTables;

class {{ $config->modelNames->name }}Controller extends AppBaseController
{
    /** @var {{ $config->modelNames->name }}Repository ${{ $config->modelNames->camel }}Repository*/
    private ${{ $config->modelNames->camel }}Repository;

    public function __construct({{ $config->modelNames->name }}Repository ${{ $config->modelNames->camel }}Repo)
    {
        $this->{{ $config->modelNames->camel }}Repository = ${{ $config->modelNames->camel }}Repo;
    }

    /**
     * Display a listing of the {{ $config->modelNames->name }}.
     */
    {!! $indexMethod !!}


    public function store(Request $request){
        try {
            $d = $request->all();

            $this->{{ $config->modelNames->camel }}Repository->create($d);
            
            alert()->success(__('Success'),'{{$config->modelNames->name}} '.__('added successfully!'));
        }
        catch (\Throwable $th) {
            \Log::error('Error while submiting {{$config->modelNames->name}}: '.$th->getMessage());
            alert()->error(__('Error'),__('Whoops! Something went wrong.'));
        }
        return redirect()->back();
    }

    public function update({{$config->modelNames->name}} ${{ $config->modelNames->camel }},Request $request){

        try {
            $d = $request->all();
            ${{ $config->modelNames->camel }} = $this->{{ $config->modelNames->camel }}Repository->update($d,${{ $config->modelNames->camel }}->id);

            alert()->success(__('Success'),'{{$config->modelNames->name}} '.__('updated successfully!'));
        }catch (\Throwable $th) {
            \Log::error('Error while submiting {{$config->modelNames->name}}: '.$th->getMessage());
            alert()->error(__('Error'),__('Whoops! Something went wrong.'));
        }
        return redirect()->back();
    }

}