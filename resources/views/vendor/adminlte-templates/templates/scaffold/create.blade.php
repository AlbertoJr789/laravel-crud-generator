
<div>
    <div class="text-2xl">
        Create new register
    </div>

    @php
        $action = "{{ route('admin.{$config->modelNames->camelPlural}.store') }}";
    @endphp
    <form action="{{ $action }}" method="post">
        @@csrf
        @@include('{{$config->modelNames->snakePlural}}.fields')
                  
        <div class="flex justify-end">
            <button class="btn-primary ml-3" type="submit">Save</button>
        </div>

    </form>

</div>