# Laravel CRUD Generator

This project is a courtesy from [InfyomLabs](https://github.com/InfyOmLabs/laravel-generator). Shout out for the bois for making this possible with the fundamental code !

This is a Laravel CRUD generator that allows you to automatically create models, controllers, views, migrations, and other files necessary for a complete CRUD. The generator uses customizable template files located in `resources/views/vendor/` that you can modify to meet your specific needs.

The difference here is simple. You won't limit your laravel version with development dependencies and you're still able to generate CRUD files from a standalone solution.

That is possible as long as you inform your target laravel project path the moment you browse this application.

When setting up the path on Windows:

    C:\Users\user\folder

or if you're in linux:

    /var/www/folder

Always pass the absolute path, DO NOT ADD a slash (/) after "folder":

    /var/www/folder/ (SHOULDN'T BE LIKE THIS !!!)

## Running

Install base dependencies:

    composer install

Copy the .env file:

    cp .env.example .env

Since its a dev package, simply run it as:

    php artisan serve

Access the link:

    http://localhost:8000

## Template Customization

The templates are located in `resources/views/vendor/` and are divided into two main categories:

- `adminlte-templates/`: Interface templates, including all Blade frontend, HTML input variations, datatables action buttons and much more.
- `laravel-generator/`: Base Laravel generator templates. In here, you can define how to backend classes can look like. 

## Available Template Variables

### 1. Model Names (`$config->modelNames`)

These variables provide different formats of the model name:

#### Main Variables:
- `$config->modelNames->name` - Model name (ex: `User`)
- `$config->modelNames->camel` - Name in camelCase (ex: `user`)
- `$config->modelNames->plural` - Name in plural (ex: `Users`)
- `$config->modelNames->camelPlural` - Plural name in camelCase (ex: `users`)
- `$config->modelNames->snake` - Name in snake_case (ex: `user`)
- `$config->modelNames->snakePlural` - Plural name in snake_case (ex: `users`)
- `$config->modelNames->human` - Humanized name (ex: `User`)
- `$config->modelNames->humanPlural` - Humanized name in plural (ex: `Users`)
- `$config->modelNames->dashedPlural` - Plural name with dash (ex: `users`)

#### Usage Examples:
```blade
// Controller
class {{ $config->modelNames->name }}Controller extends AppBaseController

// Route
Route::resource('{{ $config->modelNames->camelPlural }}', ...)

// View
return view('{{ $config->modelNames->snakePlural }}.index')

// Variable names
${{ $config->modelNames->camel }} = new {{ $config->modelNames->name }}();
```

### 2. Namespaces (`$config->namespaces`)

These variables define the namespaces used in the generated files:

- `$config->namespaces->app` - Application namespace (ex: `App`)
- `$config->namespaces->model` - Models namespace (ex: `App\Models`)
- `$config->namespaces->controller` - Controllers namespace (ex: `App\Http\Controllers`)
- `$config->namespaces->apiController` - API controllers namespace (ex: `App\Http\Controllers\API`)
- `$config->namespaces->request` - Requests namespace (ex: `App\Http\Requests`)
- `$config->namespaces->apiRequest` - API requests namespace (ex: `App\Http\Requests\API`)
- `$config->namespaces->repository` - Repositories namespace (ex: `App\Repositories`)
- `$config->namespaces->repositoryTests` - Repository tests namespace
- `$config->namespaces->tests` - Tests namespace (ex: `Tests`)
- `$config->namespaces->dataTables` - DataTables namespace (ex: `App\DataTables`)
- `$config->namespaces->factory` - Factories namespace (ex: `Database\Factories`)
- `$config->namespaces->apiResource` - API resources namespace

#### Usage Examples:
```blade
// Import statements
use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use {{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller;

// Namespace declaration
namespace {{ $config->namespaces->controller }};
```

### 3. Prefixes (`$config->prefixes`)

Variables for route and view prefixes:

- `$config->prefixes->getViewPrefixForInclude()` - Prefix for view includes
- `$config->prefixes->getRoutePrefixWith('.')` - Prefix for routes with separator
- `$config->prefixes->getRoutePrefixWith('/')` - Prefix for routes with slash

#### Usage Examples:
```blade
// View includes
return view('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.create');

// Route names
return redirect(route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.index'));
```

### 4. Database (`$config->tableName`)

- `$config->tableName` - Database table name

#### Usage Examples:
```blade
// Model
public $table = '{{ $config->tableName }}';

// Migration
Schema::create('{{ $config->tableName }}', function (Blueprint $table) {

// Query
$query = {{ $config->modelNames->name }}::select('{{ $config->tableName }}.*')
```

### 5. Fields (`$config->fields`)

Array with the model fields. Each field has the following properties:

- `$field->name` - Field name
- `$field->dbType` - Database field type
- `$field->htmlType` - HTML field type
- `$field->inForm` - Whether it appears in the form
- `$field->inIndex` - Whether it appears in the listing
- `$field->variables()` - Array with all field variables

#### Usage Examples:
```blade
// Loop through fields
@foreach($config->fields as $field)
    @if($field->inForm)
        <!-- Field {{ $field->name }} -->
    @endif
@endforeach
```

### 6. Template Variables for Fields

For specific field templates, the following variables are available:

- `$fieldName` - Field name
- `$fieldTitle` - Field title
- `$modelVariable` - Model variable name
- `$selectValues` - Values for select fields (when applicable)
- `$options` - Additional field options

#### Usage Examples:
```blade
<!-- Field label -->
{!! Form::label('{{ $fieldName }}', '{{ $fieldTitle }}:') !!}

<!-- Field input -->
{!! Form::text('{{ $fieldName }}', null, ['class' => 'form-control']) !!}

<!-- Field display -->
<p>{{ ${{ $modelVariable }}->{{ $fieldName }} }}</p>
```

### 7. Dynamic Template Variables

Some variables are dynamically injected depending on the context:

- `$fillables` - List of fillable fields for the model
- `$casts` - List of casts for the model
- `$rules` - Validation rules
- `$relations` - Model relationships
- `$fields` - Migration fields
- `$indexMethod` - Controller index method
- `$renderType` - Render type (for views)
- `$table` - Table content (for index views)

#### Usage Examples:
```blade
// Model
public $fillable = [
    {!! $fillables !!}
];

protected $casts = [
    {!! $casts !!}
];

// Controller
{!! $indexMethod !!}

// View
{!! $table !!}
```

## Template File Structure

### Controllers
- `laravel-generator/scaffold/controller/controller.blade.php` - Basic controller
- `laravel-generator/scaffold/controller/controller_repository.blade.php` - Controller with repository pattern

### Views
- `adminlte-templates/templates/scaffold/index.blade.php` - Listing page
- `adminlte-templates/templates/scaffold/create.blade.php` - Creation page
- `adminlte-templates/templates/scaffold/fields.blade.php` - Form fields

### Models
- `laravel-generator/model/model.blade.php` - Model template

### Migrations
- `laravel-generator/migration.blade.php` - Migration template

### Requests
- `laravel-generator/scaffold/request/create.blade.php` - Creation request
- `laravel-generator/scaffold/request/update.blade.php` - Update request

### Fields (Form Fields)
- `adminlte-templates/templates/fields/text.blade.php` - Text field
- `adminlte-templates/templates/fields/select.blade.php` - Select field
- `adminlte-templates/templates/fields/email.blade.php` - Email field
- `adminlte-templates/templates/fields/password.blade.php` - Password field
- `adminlte-templates/templates/fields/textarea.blade.php` - Textarea field
- `adminlte-templates/templates/fields/number.blade.php` - Number field
- `adminlte-templates/templates/fields/date.blade.php` - Date field
- `adminlte-templates/templates/fields/checkbox.blade.php` - Checkbox field
- `adminlte-templates/templates/fields/radio.blade.php` - Radio field
- `adminlte-templates/templates/fields/file.blade.php` - File field

## How to Customize

1. **Navigate to** `resources/views/vendor/`
2. **Choose the template** you want to customize
3. **Modify the file** using the available variables listed above
4. **Run the generator** - your customizations will be applied automatically

## Customization Example

To customize the controller, edit `resources/views/vendor/laravel-generator/scaffold/controller/controller.blade.php`:

```blade
<?php

namespace {{ $config->namespaces->controller }};

use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
use Illuminate\Http\Request;

class {{ $config->modelNames->name }}Controller extends Controller
{
    // Your custom code here
    // Using {{ $config->modelNames->camel }} for variables
    // And {{ $config->modelNames->name }} for classes
}
```

## Advanced Customizations

In case you want to manipulate the way the files are saved, changing default folder behavior, or even adding more files, you can do so by adapting the code inside 
`app/CRUDGenerator/`.

I've already made some changes in how the Controllers,Routes and Views are generated by default from the original library, that's why I cloned these classes to the project.

In case you need to change some of the ones I didn't choose, you can do so by entering into `vendor/infyomlabs/laravel-generator/src/Generators/` and clone the desired class
to `app/CRUDGenerator/`. Change the namespaces accordingly and feel free to make any adjustments!