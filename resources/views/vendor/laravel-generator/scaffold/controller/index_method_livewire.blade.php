    public function index(Request $request)
    {
        return view('{{ $config->modelNames->snakePlural }}.index',[
            'data' => {{ $config->modelNames->name }}::when($request->get('deleted'), function($query){
                return $query->onlyTrashed();
            })->get()
        ]);
    }