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

    /**
    * Process dataTable ajax response.
    *
    * @param \Yajra\Datatables\Datatables $datatables
    * @return \Illuminate\Http\JsonResponse
    */
   public function dataTableData(Request $request){

       $query = {{$config->modelNames->name}}::select('{{$config->tableName}}.*','C.name','E.name','D.name')
                                    ->leftjoin('users as C','C.id','{{$config->tableName}}.creator_id')
                                    ->leftjoin('users as E','E.id','{{$config->tableName}}.editor_id')
                                    ->leftjoin('users as D','D.id','{{$config->tableName}}.deleter_id');
       $query = $this->filterDataTableData($query,$request->all());
       return DataTables::eloquent($query)
                         ->addColumn('select',function($reg){
                               return '';
                         })
                         ->editColumn('created_at',function($reg){
                               return $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '';
                         })
                         ->editColumn('updated_at',function($reg){
                               return $reg->updated_at ? $reg->updated_at->format('d/m/Y H:i') : '';
                         })
                         ->editColumn('deleted_at',function($reg){
                               return $reg->deleted_at ? $reg->deleted_at->format('d/m/Y H:i') : '';
                         })
                         ->addColumn('creator',function($reg){
                               return $reg->creator ? $reg->creator->name : '';
                         })
                         ->addColumn('editor',function($reg){
                               return $reg->editor ? $reg->editor->name : '';
                         })
                         ->addColumn('deleter',function($reg){
                               return $reg->deleter ? $reg->deleter->name : '';
                         })
                         ->editColumn('active',function($reg){
                            return $reg->active ? '<span class="badge badge-green uppercase">'.__('Yes').'</span>' : '<span class="badge badge-red uppercase">'.__('No').'</span>';
                         })
                         ->addColumn('action',function($reg){
                               return view('{{$config->modelNames->snakePlural}}.action-buttons',['data' => $reg]);
                         })
                         ->rawColumns(['action','active'])
                         ->make();

   }

    private function filterDataTableData($query,$r){
        if(isset($r['dateTypeFilter'])){
            $field = null;
            switch($r['dateTypeFilter']){
                case 'C': $field = 'created_at'; break;
                case 'U': $field = 'updated_at'; break;
                case 'D': $field = 'deleted_at'; $query->onlyTrashed(); break;
            }
            if(isset($r['initialDate']) && $r['initialDate'])
                $query->where($field,'>=',$r['initialDate']);
            if(isset($r['endDate']) && $r['endDate'])
                $query->where($field,'<=',$r['initialDate']);
        }
        if(isset($r['activeFilter'])){
            if($r['activeFilter'] == 'true'){
                $query->active();
            }else{
                $query->unactive();
            }
        }
        return $query;
    }


}