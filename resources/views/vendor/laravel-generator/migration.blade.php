@php
echo "
<?php".PHP_EOL;
@endphp

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ $config->tableName }}', function (Blueprint $table) {
            {!! $fields !!}
            $table->boolean('active')->default(true);
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users');
            $table->foreignId('deleter_id')->nullable()->references('id')->on('users');
            
            
            Permission::create([ 'name' => '{{$config->modelNames->camelPlural}}.all', 'description' => 'All {{$config->modelNames->name}} permissions'])->children()->createMany([
                ['name' => '{{$config->modelNames->camelPlural}}.view', 'description' => 'View {{$config->modelNames->name}}'],
                ['name' => '{{$config->modelNames->camelPlural}}.create', 'description' => 'Create {{$config->modelNames->name}}'],
                ['name' => '{{$config->modelNames->camelPlural}}.edit', 'description' => 'Edit {{$config->modelNames->name}}'],
                ['name' => '{{$config->modelNames->camelPlural}}.delete', 'description' => 'Delete {{$config->modelNames->name}}'],
            ]);
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ $config->tableName }}');
                
        Schema::disableForeignKeyConstraints();
        Permission::where('name','like','{{$config->modelNames->camelPlural}}%')->delete();
        Schema::enableForeignKeyConstraints();
       
    }
};