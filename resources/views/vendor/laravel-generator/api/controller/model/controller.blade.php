@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->apiController }};

use {{ $config->namespaces->apiRequest }}\Create{{ $config->modelNames->name }}APIRequest;
use {{ $config->namespaces->apiRequest }}\Update{{ $config->modelNames->name }}APIRequest;
use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use {{ $config->namespaces->app }}\Http\Controllers\Controller;

{!! $docController !!}
class {{ $config->modelNames->name }}APIController extends Controller
{
    {!! $docIndex !!}
    public function index(Request $request): JsonResponse
    {
        $query = {{ $config->modelNames->name }}::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        ${{ $config->modelNames->camelPlural }} = $query->get();
        @if($config->options->localized)
        return response()->json([
            'success' => true,
            'data' => ${{ $config->modelNames->camelPlural }},
            'message' => __('messages.retrieved', ['model' => __('models/{{ $config->modelNames->camelPlural }}.plural')])
        ]);
        @else
        return response()->json([
            'success' => true,
            'data' => ${{ $config->modelNames->camelPlural }},
            'message' => 'Testes retrieved successfully'
        ]);
        @endif
    }

    {!! $docStore !!}
    public function store(Create{{ $config->modelNames->name }}APIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::create($input);

        @if($config->options->localized)
            return response()->json([
                'success' => true,
                'data' => ${{ $config->modelNames->camel }},
                'message' => __('messages.saved', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')])
            ]);
        @else
            return response()->json([
                'success' => true,
                'data' => ${{ $config->modelNames->camel }},
                'message' => '{{ $config->modelNames->human }} saved successfully'
            ]);
        @endif
    }

    {!! $docShow !!}
    public function show($id): JsonResponse
    {
        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::find($id);

        if (empty(${{ $config->modelNames->camel }})) {
            @if($config->options->localized)
            return response()->json([
                'success' => false,
                'message' => __('messages.not_found', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')])
            ],404);
            @else
            return response()->json([
                'success' => false,
                'message' => '{{ $config->modelNames->human }} not found'
            ],404);
            @endif
        }

        @if($config->options->localized)
        return response()->json([
            'success' => true,
            'data' => ${{ $config->modelNames->camel }},
            'message' => __('messages.retrieved', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')])
        ]);
        @else
        return response()->json([
            'success' => true,
            'data' => ${{ $config->modelNames->camel }},
            'message' => '{{ $config->modelNames->human }} retrieved successfully'
        ]);
        @endif
    }

    {!! $docUpdate !!}
    public function update($id, Update{{ $config->modelNames->name }}APIRequest $request): JsonResponse
    {
        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::find($id);

        if (empty(${{ $config->modelNames->camel }})) {
            @if($config->options->localized)
            return response()->json([
                'success' => false,
                'message' => __('messages.not_found', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')])
            ],404);
            @else
            return response()->json([
                'success' => false,
                'message' => '{{ $config->modelNames->human }} not found'
            ],404);
            @endif
        }

        ${{ $config->modelNames->camel }}->fill($request->all());
        ${{ $config->modelNames->camel }}->save();

        @if($config->options->localized)
        return response()->json([
            'success' => true,
            'data' => ${{ $config->modelNames->camel }},
            'message' => __('messages.updated', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')])
        ]);
        @else
        return response()->json([
            'success' => true,
            'data' => ${{ $config->modelNames->camel }},
            'message' => '{{ $config->modelNames->name }} updated successfully'
        ]);
        @endif
    }

    {!! $docDestroy !!}
    public function destroy($id): JsonResponse
    {
        /** @var {{ $config->modelNames->name }} ${{ $config->modelNames->camel }} */
        ${{ $config->modelNames->camel }} = {{ $config->modelNames->name }}::find($id);

        if (empty(${{ $config->modelNames->camel }})) {
            @if($config->options->localized)
            return response()->json([
                'success' => false,
                'message' => __('messages.not_found', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')])
            ],404);
            @else
            return response()->json([
                'success' => false,
                'message' => '{{ $config->modelNames->human }} not found'
            ],404);
            @endif
        }

        ${{ $config->modelNames->camel }}->delete();

        @if($config->options->localized)
        return response()->json([
            'success' => true,
            'data' => $id,
            'message' => __('messages.deleted', ['model' => __('models/{{ $config->modelNames->camelPlural }}.singular')])
        ]);
        @else
        return response()->json([
            'success' => true,
            'data' => $id,
            'message' => '{{ $config->modelNames->human }} deleted successfully'
        ]);
        @endif
    }
}
