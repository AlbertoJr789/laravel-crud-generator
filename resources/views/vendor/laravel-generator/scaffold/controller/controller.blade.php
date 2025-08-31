@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->controller }};

@if(config('laravel_generator.tables') == 'datatables')
use {{ $config->namespaces->dataTables }}\{{ $config->modelNames->name }}DataTable;
@endif
use {{ $config->namespaces->request }}\Create{{ $config->modelNames->name }}Request;
use {{ $config->namespaces->request }}\Update{{ $config->modelNames->name }}Request;
use {{ $config->namespaces->app }}\Http\Controllers\AppBaseController;
use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use Illuminate\Http\Request;
use Flash;

class {{ $config->modelNames->name }}Controller extends AppBaseController
{
    /**
     * Display a listing of the {{ $config->modelNames->name }}.
     */
    {!! $indexMethod !!}

    /**
     * Show the form for creating a new {{ $config->modelNames->name }}.
     */
    public function create()
    {
        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.create');
    }

    /**
     * Store a newly created {{ $config->modelNames->name }} in storage.
     */
    public function store(Create{{ $config->modelNames->name }}Request $request)
    {
        $input = $request->all();

        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::create($input);

        @include('laravel-generator::scaffold.controller.messages.save_success')

        return redirect(route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.index'));
    }

    /**
     * Display the specified {{ $config->modelNames->name }}.
     */
    public function show($id)
    {
        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::find($id);

        @include('laravel-generator::scaffold.controller.messages.not_found')

        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.show')->with('{{ $config->modelNames->camel }}', ${{ $config->modelNames->camel }});
    }

    /**
     * Show the form for editing the specified {{ $config->modelNames->name }}.
     */
    public function edit($id)
    {
        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::find($id);

        @include('laravel-generator::scaffold.controller.messages.not_found')

        return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.edit')->with('{{ $config->modelNames->camel }}', ${{ $config->modelNames->camel }});
    }

    /**
     * Update the specified {{ $config->modelNames->name }} in storage.
     */
    public function update($id, Update{{ $config->modelNames->name }}Request $request)
    {
        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::find($id);

        @include('laravel-generator::scaffold.controller.messages.not_found')

        ${{ $config->modelNames->camel }}->fill($request->all());
        ${{ $config->modelNames->camel }}->save();

        @include('laravel-generator::scaffold.controller.messages.update_success')

        return redirect(route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.index'));
    }

    /**
     * Remove the specified {{ $config->modelNames->name }} from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::find($id);

        @include('laravel-generator::scaffold.controller.messages.not_found')

        ${{ $config->modelNames->camel }}->delete();

        @include('laravel-generator::scaffold.controller.messages.delete_success')

        return redirect(route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.index'));
    }

    /**
    * Process dataTable ajax response.
    *
    * @param \Yajra\Datatables\Datatables $datatables
    * @return \Illuminate\Http\JsonResponse
    */
   public function dataTableData(Request $request){

       $query = {{$config->modelNames->name}}::select('{{$config->modelNames->snakePlural}}.*','C.name','E.name','D.name')
                                    ->leftjoin(['users as C','C.id','{{$config->modelNames->snakePlural}}.creator_id'])
                                    ->leftjoin(['users as E','E.id','{{$config->modelNames->snakePlural}}.editor_id'])
                                    ->leftjoin(['users as D','D.id','{{$config->modelNames->snakePlural}}.deleter_id']);
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
                               return view('{{$config->modelNames->camelPlural}}.action-buttons',['data' => $reg]);
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
