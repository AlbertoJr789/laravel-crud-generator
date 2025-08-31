@php
echo "
<?php".PHP_EOL;
@endphp

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

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
            
            try {
                Permission::create([ 'name' => '{{$config->modelNames->camelPlural}}.view']);
                Permission::create([ 'name' => '{{$config->modelNames->camelPlural}}.create']);
                Permission::create([ 'name' => '{{$config->modelNames->camelPlural}}.delete']);
            } catch (\Throwable $th) {
            }
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
                
        try {
            Permission::whereName('{{$config->modelNames->camelPlural}}.view')
                  ->orWhereName('{{$config->modelNames->camelPlural}}.create')
                  ->orWhereName('{{$config->modelNames->camelPlural}}.delete')
                  ->delete();
        } catch (\Throwable $th) {
        }
    }
};