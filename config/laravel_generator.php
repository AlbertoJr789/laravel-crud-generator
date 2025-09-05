<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    */

    'path' => [

        'migration'         => env('CRUD_PATH') .'/database/migrations/',

        'model'             => env('CRUD_PATH') .'/app/Models/',

        'datatables'        => env('CRUD_PATH') .'/app/DataTables/',

        'livewire_tables'   => env('CRUD_PATH') .'/app/Http/Livewire/',

        'repository'        => env('CRUD_PATH') .'/app/Repositories/',

        'routes'            => env('CRUD_PATH') .'/routes/web.php',

        'api_routes'        => env('CRUD_PATH') .'/routes/api.php',

        'request'           => env('CRUD_PATH') .'/app/Http/Requests/',

        'api_request'       => env('CRUD_PATH') .'/app/Http/Requests/API/',

        'controller'        => env('CRUD_PATH') .'/app/Http/Controllers/',

        'api_controller'    => env('CRUD_PATH') .'/app/Http/Controllers/API/',

        'api_resource'      => env('CRUD_PATH') .'/app/Http/Resources/',

        'schema_files'      => env('CRUD_PATH') .'/model_schemas/',

        'seeder'            => env('CRUD_PATH') .'/database/seeders/',

        'database_seeder'   => env('CRUD_PATH') .'/database/seeders/DatabaseSeeder.php',

        'factory'           => env('CRUD_PATH') .'/database/factories/',

        'view_provider'     => env('CRUD_PATH') .'/app/Providers/ViewServiceProvider.php',

        'tests'             => env('CRUD_PATH') .'/tests/',

        'repository_test'   => env('CRUD_PATH') .'/tests/Repositories/',

        'api_test'          => env('CRUD_PATH') .'/tests/APIs/',

        'views'             => env('CRUD_PATH') .'/resources/views/',

        'menu_file'         => env('CRUD_PATH') .'/resources/views/layouts/menu.blade.php',
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => [

        'model'             => 'App\Models',

        'datatables'        => 'App\DataTables',

        'livewire_tables'   => 'App\Http\Livewire',

        'repository'        => 'App\Repositories',

        'controller'        => 'App\Http\Controllers',

        'api_controller'    => 'App\Http\Controllers\API',

        'api_resource'      => 'App\Http\Resources',

        'request'           => 'App\Http\Requests',

        'api_request'       => 'App\Http\Requests\API',

        'seeder'            => 'Database\Seeders',

        'factory'           => 'Database\Factories',

        'tests'             => 'Tests',

        'repository_test'   => 'Tests\Repositories',

        'api_test'          => 'Tests\APIs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    */

    'templates' => 'adminlte-templates',

    /*
    |--------------------------------------------------------------------------
    | Model extend class
    |--------------------------------------------------------------------------
    |
    */

    'model_extend_class' => 'Illuminate\Database\Eloquent\Model',

    /*
    |--------------------------------------------------------------------------
    | API routes prefix & version
    |--------------------------------------------------------------------------
    |
    */

    'api_prefix'  => 'api',

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    */

    'options' => [

        'soft_delete' => true,

        'save_schema_file' => false,

        'localized' => false,

        'repository_pattern' => false,

        'resources' => false,

        'factory' => false,

        'seeder' => false,

        'swagger' => false, // generate swagger for your APIs

        'tests' => false, // generate test cases for your APIs

        'excluded_fields' => ['id'], // Array of columns that doesn't required while creating module
    ],

    /*
    |--------------------------------------------------------------------------
    | Prefixes
    |--------------------------------------------------------------------------
    |
    */

    'prefixes' => [

        'route' => '',  // e.g. admin or admin.shipping or admin.shipping.logistics

        'namespace' => '',  // e.g. Admin or Admin\Shipping or Admin\Shipping\Logistics

        'view' => '',  // e.g. admin or admin/shipping or admin/shipping/logistics
    ],

    /*
    |--------------------------------------------------------------------------
    | Table Types
    |
    | Possible Options: blade, datatables, livewire
    |--------------------------------------------------------------------------
    |
    */

    'tables' => 'livewire',

    /*
    |--------------------------------------------------------------------------
    | Timestamp Fields
    |--------------------------------------------------------------------------
    |
    */

    'timestamps' => [

        'enabled'       => true,

        'created_at'    => 'created_at',

        'updated_at'    => 'updated_at',

        'deleted_at'    => 'deleted_at',
    ],

    /*
    |--------------------------------------------------------------------------
    | Specify custom doctrine mappings as per your need
    |--------------------------------------------------------------------------
    |
    */

    'from_table' => [

        'doctrine_mappings' => [],
    ],

];
