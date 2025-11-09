@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->controller }};

use {{ $config->namespaces->request }}\Create{{ $config->modelNames->name }}Request;
use {{ $config->namespaces->request }}\Update{{ $config->modelNames->name }}Request;
use {{ $config->namespaces->app }}\Http\Controllers\AppBaseController;
use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use Illuminate\Http\Request;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class {{ $config->modelNames->name }}Controller extends Controller
{
    public function index()
    {
        return Inertia::render('{{$config->modelNames->snakePlural}}.index');
    }

    public function create()
    {
        return Inertia::render('{{$config->modelNames->snakePlural}}/Create');
    }

    public function edit({{$config->modelNames->name}} ${{$config->modelNames->camel}})
    {
        return Inertia::render('{{$config->modelNames->snakePlural}}/Create',['{{$config->modelNames->camel}}' => ${{$config->modelNames->camel}}]);
    }

    public function store(Request $request){
        try {
            $d = $request->all();
            $d['creator_id'] = Auth::id();

            ${{$config->modelNames->camel}} = {{$config->modelNames->name}}::create($d);
        } 
        catch (\Throwable $th) {
            Log::error('Error while submiting {{$config->modelNames->name}}: '.$th->getMessage());
            return back()->withErrors(__('Whoops! Something went wrong.'));
        }
        return back();
    }

    public function update({{$config->modelNames->name}} ${{$config->modelNames->camel}},Update{{$config->modelNames->name}}Request $request){

        try {
            $d = $request->all();
            ${{$config->modelNames->camel}}->update($d);
         
        }catch (\Throwable $th) {
            Log::error('Error while submiting {{$config->modelNames->name}}: '.$th->getMessage());
            return back()->withErrors(__('Whoops! Something went wrong.'));
        }
        return back();
    }

    public function deleteAll(Request $request){
        try {
            $ids = $request->ids;
            {{$config->modelNames->name}}::whereIn('id',$ids)->delete();
            return back()->with('success', __('{{$config->modelNames->name}} deleted successfully'));
        } catch (\Throwable $th) {
            Log::error('Error while deleting {{$config->modelNames->name}}: '.$th->getMessage());
            return back()->withErrors(__('Whoops! Something went wrong.'));
        }   
    }

    public function restoreAll(Request $request){

        try {
            $ids = $request->ids;
            {{$config->modelNames->name}}::whereIn('id',$ids)->restore();
            return back()->with('success', __('{{$config->modelNames->name}} restored successfully'));
        } catch (\Throwable $th) {
            Log::error('Error while restoring {{$config->modelNames->name}}: '.$th->getMessage());
            return back()->withErrors(__('Whoops! Something went wrong.'));
        }
    }

    /**
    * Process dataTable ajax response.
    *
    * @param \Yajra\Datatables\Datatables $datatables
    * @return \Illuminate\Http\JsonResponse
    */
   public function dataTableData(Request $request){

       $query = {{$config->modelNames->name}}::with('creator:id,name','editor:id,name','deleter:id,name');
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
