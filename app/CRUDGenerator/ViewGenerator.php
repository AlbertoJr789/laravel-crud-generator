<?php

namespace App\CRUDGenerator;

use Exception;
use Illuminate\Support\Str;
use InfyOm\Generator\Common\GeneratorField;
use InfyOm\Generator\Generators\BaseGenerator;
use InfyOm\Generator\Generators\ViewServiceProviderGenerator;
use InfyOm\Generator\Utils\HTMLFieldGenerator;

class ViewGenerator extends BaseGenerator
{
    private string $templateType;
    private string $templateViewPath;

    public function __construct()
    {
        parent::__construct();

        $this->path = $this->config->paths->views;
        $this->templateType = config('laravel_generator.templates', 'adminlte-templates');
        $this->templateViewPath = $this->templateType.'::templates';
    }

    public function generate()
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }

//        $htmlInputs = Arr::pluck($this->config->fields, 'htmlInput');

        //TODO: Manage files
//        if (in_array('file', $htmlInputs)) {
//            $this->config->addDynamicVariable('$FILES$', ", 'files' => true");
//        }

$this->config->commandComment(infy_nl().'Generating Views...');

    if ($this->config->getOption('views')) {
        $viewsToBeGenerated = explode(',', $this->config->getOption('views'));
    
            if (in_array('index', $viewsToBeGenerated)) {
                // $this->generateTable();
                $this->generateIndex();
            }

            if (count(array_intersect(['create', 'update'], $viewsToBeGenerated)) > 0) {
                $this->generateFields();
            }

            // if (in_array('create', $viewsToBeGenerated)) {
            //     $this->generateCreate();
            // }

            // if (in_array('edit', $viewsToBeGenerated)) {
            //     $this->generateUpdate();
            // }

            // if (in_array('show', $viewsToBeGenerated)) {
                // $this->generateShowFields();
            //     $this->generateFilter();
            // }
        } else {

            // $this->generateTable();
            // $this->generateShowFields();
            $this->generateCreate();
            $this->generateIndex();
            $this->generateDatatable();
            $this->generateActionButtons();
            $this->generateFields();
            $this->generateFilter();
        }

        $this->config->commandComment('Views created: ');
    }

    protected function generateTable()
    {
        if ($this->config->tableType === 'livewire') {
            return;
        }

        switch ($this->config->tableType) {
            case 'blade':
                $templateData = $this->generateBladeTableBody();
                break;

            case 'datatables':
                $templateData = $this->generateDataTableBody();
                $this->generateDataTableActions();
                break;

            default:
                throw new Exception('Invalid Table Type');
        }

        g_filesystem()->createFile($this->path.'table.blade.php', $templateData);

        $this->config->commandInfo('table.blade.php created');
    }

    protected function generateDataTableBody(): string
    {
        return view($this->templateViewPath.'.scaffold.table.datatable.body')->render();
    }

    protected function generateDataTableActions()
    {
        $templateData = view($this->templateViewPath.'.scaffold.table.datatable.actions')->render();

        g_filesystem()->createFile($this->path.'datatables_actions.blade.php', $templateData);

        $this->config->commandInfo('datatables_actions.blade.php created');
    }

    protected function generateBladeTableBody(): string
    {
        $tableBodyFields = [];

        foreach ($this->config->fields as $field) {
            if (!$field->inIndex) {
                continue;
            }

            $tableBodyFields[] = view($this->templateViewPath.'.scaffold.table.blade.cell', [
                'modelVariable' => $this->config->modelNames->camel,
                'fieldName'     => $field->name,
            ])->render();
        }

        $tableBodyFields = implode(infy_nl_tab(1, 5), $tableBodyFields);

        $paginate = view($this->templateViewPath.'.scaffold.paginate')->render();

        return view($this->templateViewPath.'.scaffold.table.blade.body', [
            'fieldHeaders' => $this->generateTableHeaderFields(),
            'fieldBody'    => $tableBodyFields,
            'paginate'     => $paginate,
        ])->render();
    }

    protected function generateTableHeaderFields(): string
    {
        $headerFields = [];

        foreach ($this->config->fields as $field) {
            if (!$field->inIndex) {
                continue;
            }

            $headerFields[] = view(
                $this->templateType.'::templates.scaffold.table.blade.header',
                $field->variables()
            )->render();
        }

        return implode(infy_nl_tab(1, 4), $headerFields);
    }

    protected function generateIndex()
    {
        switch ($this->config->tableType) {
            case 'datatables':
            case 'blade':
                $tableReplaceString = "@include('".$this->config->prefixes->getViewPrefixForInclude().$this->config->modelNames->snakePlural.".table')";
                break;

            case 'livewire':
                $tableReplaceString = view($this->templateViewPath.'.scaffold.table.livewire.body')->render();
                break;

            default:
                throw new Exception('Invalid table type');
        }

        $templateData = view('adminlte-templates::templates.scaffold.index', ['table' => $tableReplaceString])
            ->render();

        g_filesystem()->createFile($this->path.'index.blade.php', $templateData);

        $this->config->commandInfo('index.blade.php created');
    }

    protected function generateFields()
    {
        $htmlFields = [];


        foreach ($this->config->fields as $field) {
            if (!$field->inForm) {
                continue;
            }
            // * Field Input Format: field_name <space> db_type <space> html_type(optional) <space> options(optional)
            // * Options are to skip the field from certain criteria like searchable, fillable, not in form, not in index
            // * Searchable (s), Fillable (f), In Form (if), In Index (ii)
            // * Sample Field Inputs
            if(str_contains($field->htmlType,'select')){
                $fieldNovo = clone $field;
                $fieldNovo->htmlType = 'select';
                $field = $fieldNovo;
            }
            $htmlFields[] = HTMLFieldGenerator::generateHTML(
                $field,
                $this->templateViewPath
            );

            // TODO
//            if ($field->htmlType == 'selectTable') {
//                $inputArr = explode(',', $field->htmlValues[1]);
//                $columns = '';
//                foreach ($inputArr as $item) {
//                    $columns .= "'$item'" . ',';  //e.g 'email,id,'
//                }
//                $columns = substr_replace($columns, '', -1); // remove last ,
//
//                $htmlValues = explode(',', $field->htmlValues[0]);
//                $selectTable = $htmlValues[0];
//                $modalName = null;
//                if (count($htmlValues) == 2) {
//                    $modalName = $htmlValues[1];
//                }
//
//                $tableName = $this->config->tableName;
//                $viewPath = $this->config->prefixes->view;
//                if (!empty($viewPath)) {
//                    $tableName = $viewPath . '.' . $tableName;
//                }
//
//                $variableName = Str::singular($selectTable) . 'Items'; // e.g $userItems
//
//                $fieldTemplate = $this->generateViewComposer($tableName, $variableName, $columns, $selectTable, $modalName);
//            }
        }

        $htmlFields[] = "@if($".$this->config->modelNames->name.")
        <div class=\"flex sm:justify-start justify-center sm:my-auto my-4\">
            {!! Form::label('active', __('Active'),['class' => \"block mx-1\"]) !!}
            {!! Form::checkbox('active',null,".'$active'.", ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
        </div>
        @endif
    ";

        g_filesystem()->createFile($this->path.'fields.blade.php', implode(infy_nls(2), $htmlFields));
        $this->config->commandInfo('field.blade.php created');
    }

    private function generateViewComposer($tableName, $variableName, $columns, $selectTable, $modelName = null): string
    {
        $templateName = 'scaffold.fields.select';
        if ($this->config->isLocalizedTemplates()) {
            $templateName .= '_locale';
        }
        $fieldTemplate = get_template($templateName, $this->templateType);

        $viewServiceProvider = new ViewServiceProviderGenerator();
        $viewServiceProvider->generate();
        $viewServiceProvider->addViewVariables($tableName.'.fields', $variableName, $columns, $selectTable, $modelName);

        return str_replace(
            '$INPUT_ARR$',
            '$'.$variableName,
            $fieldTemplate
        );
    }

    protected function generateDatatable()
    {
        $templateData = view($this->templateViewPath.'.scaffold.Datatable')->render();

        g_filesystem()->createFile($this->path."Datatable{$this->config->modelNames->plural}.vue", $templateData);
        $this->config->commandInfo("Datatable{$this->config->modelNames->name}.vue created");
    }

    protected function generateActionButtons()
    {
        $templateData = view($this->templateViewPath.'.scaffold.action-buttons')->render();

        g_filesystem()->createFile($this->path.'action-buttons.blade.php', $templateData);
        $this->config->commandInfo('action-buttons.blade.php created');
    }

    protected function generateCreate()
    {
        $templateData = view($this->templateViewPath.'.scaffold.create')->render();

        g_filesystem()->createFile($this->path.'create.blade.php', $templateData);
        $this->config->commandInfo('create.blade.php created');
    }


    protected function generateShowFields()
    {
        $fieldsStr = '';

        foreach ($this->config->fields as $field) {
            if (!$field->inView) {
                continue;
            }

            $fieldsStr .= view($this->templateViewPath.'.scaffold.fields', $field->variables());
            $fieldsStr .= infy_nls(2);
        }

    
        g_filesystem()->createFile($this->path.'fields.blade.php', $fieldsStr);
        $this->config->commandInfo('fields.blade.php created');
    }

    protected function generateFilter()
    {
        $templateData = view($this->templateViewPath.'.scaffold.filter')->render();

        g_filesystem()->createFile($this->path.'filter.blade.php', $templateData);
        $this->config->commandInfo('filter.blade.php created');
    }

    public function rollback($views = [])
    {
        $files = [
            'table.blade.php',
            'index.blade.php',
            'fields.blade.php',
            'create.blade.php',
            'edit.blade.php',
            'show.blade.php',
            'show_fields.blade.php',
        ];

        if (!empty($views)) {
            $files = [];
            foreach ($views as $view) {
                $files[] = $view.'.blade.php';
            }
        }

        if ($this->config->tableType === 'datatables') {
            $files[] = 'datatables_actions.blade.php';
        }

        foreach ($files as $file) {
            if ($this->rollbackFile($this->path, $file)) {
                $this->config->commandComment($file.' file deleted');
            }
        }
    }
}
