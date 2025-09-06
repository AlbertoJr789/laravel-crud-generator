
@php
$action = htmlspecialchars_decode("{{ route('admin.{$config->modelNames->camelPlural}.store') }}");
@endphp
<div>
    <h2 class="text-2xl font-bold mb-6 text-gray-800" id="create{{$config->modelNames->camelPlural}}">{{ $config->modelNames->humanPlural}}</h2>
    <form action="@php echo $action @endphp" method="post" id="form{{ucfirst($config->modelNames->camelPlural)}}">
        @@csrf
        @@method('POST')
        @@include('{{$config->modelNames->snakePlural}}.fields')    
        <div class="flex justify-end mt-6">
            <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded transition-all cursor-pointer me-2 hidden" type="button"
            id="cancel{{ucfirst($config->modelNames->camelPlural)}}Button" onclick="cancelEdit()">
                Cancel
            </button>

            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition-all cursor-pointer" type="submit"
            id="create{{ucfirst($config->modelNames->camelPlural)}}Button">
                Save
            </button>
        </div>
    </form>
</div>