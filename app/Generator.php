<?php

namespace App;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class Generator{

    public static function getTables($data){
        $json = json_decode($data);

        $tables = [];
        
        foreach ($json->models as $key => $model) {

            $table = Str::snake(Pluralizer::plural($model->name));
            $tables[$table] = [];
            $tables[$table][] = "\$table->id();";
            foreach ($model->fields as $key => $field) {
                $field_name = isset($field->name) ? Str::snake($field->name) : Str::snake($field->model);
                switch ($field->type) {
                    case "string":
                      $line = "\$table->string('".$field_name."')";
                      if($field->nullable){
                        $line .= "->nullable()";
                      }
                      if(!empty($field->default)){
                        $line .= "->default('".$field->default."')";
                      }
                      $line .= ";";
                      $tables[$table][] = $line;
                      break;
                    case "boolean":
                      $line = "\$table->boolean('".$field_name."')";
                      if(!empty($field->default)){
                        $line .= "->default('".$field->default."')";
                      }
                      $line .= ";";
                      $tables[$table][] = $line;
                      break;
                    case "integer":
                      $line = "\$table->integer('".$field_name."')";
                      if($field->nullable){
                        $line .= "->nullable()";
                      }
                      if(!empty($field->default)){
                        $line .= "->default('".$field->default."')";
                      }
                      $line .= ";";
                      $tables[$table][] = $line;
                      break;
                    case "decimal":
                      $line = "\$table->decimal('".$field_name."',10,4)";
                      if($field->nullable){
                        $line .= "->nullable()";
                      }
                      if(!empty($field->default)){
                        $line .= "->default('".$field->default."')";
                      }
                      $line .= ";";
                      $tables[$table][] = $line;
                      break;
                    case "date":
                      $line = "\$table->timestamp('".$field_name."')";
                      if($field->nullable){
                        $line .= "->nullable()";
                      }
                      if(!empty($field->default)){
                        $line .= "->default('".$field->default."')";
                      }
                      $line .= ";";
                      $tables[$table][] = $line;
                      break;
                    case "text":
                      $line = "\$table->text('".$field_name."')";
                      if($field->nullable){
                        $line .= "->nullable()";
                      }
                      $line .= ";";
                      $tables[$table][] = $line;
                      break;
                    case "belongs_to":
                      $line = "\$table->integer('".$field_name."_id')";
                      $line .= "->nullable()";
                      $line .= ";";
                      $tables[$table][] = $line;
                      break;
                    case "belongs_to_many":
                      $table_names = [$table,Str::snake(Pluralizer::plural($field->model))];
                      sort($table_names);
                      $table_name = implode('_',$table_names);

                      if(!array_key_exists($table_name, $tables)){
                        $tables[$table_name] = [];
                        $tables[$table_name][] = "\$table->integer('".Str::snake($field->model)."_id');";
                        $tables[$table_name][] = "\$table->integer('".Str::snake($model->name)."_id');";
                      }
                      break;
                }
            }

            if($model->dates){
                $tables[$table][] = "\$table->timestamps();";
            }
        }

        return $tables;

    }

    public static function getRequired($data){
      $json = json_decode($data);

      $return = [];

      foreach ($json->models as $key => $model) {
        $return[$model->name] = [];
        foreach ($model->fields as $key => $value) {
          if(!isset($value->name)){
            continue;
          }
          if(!isset($value->nullable) || $value->nullable == false){
            $return[$model->name][$value->name] = true;
          }
        }
      }

      return $return;
    }

    public static function getModels($data){
        $json = json_decode($data);

        $models = [];
        
        foreach ($json->models as $key => $model) {

            $model_name = ucfirst(Str::camel($model->name));
            $models[$model_name] = [];

            $models[$model_name][] = "protected \$table = '".Str::snake(Pluralizer::plural($model->name))."';
            
";
            $models[$model_name][] = "    protected \$guarded = [];
";
            foreach ($model->fields as $key => $field) {
                switch ($field->type) {
                    case "belongs_to":
                      $name = Str::snake($field->model);

                      $line = "
    public function $name()
    {
        return \$this->belongsTo(\App\Models\\$field->model::class);
    }

    ";
                      $models[$model_name][] = $line;
                      break;

                    case "belongs_to_many":
                      $name = Str::snake(Str::plural($field->model));

                      $table_names = [Str::snake(Pluralizer::plural($model->name)),Str::snake(Pluralizer::plural($field->model))];
                      sort($table_names);
                      $table_name = implode('_',$table_names);
                      $line = "
    public function $name()
    {
        return \$this->belongsToMany(\App\Models\\$field->model::class, '$table_name');
    }

    ";
                      $models[$model_name][] = $line;
                      break;
                    case "has_one":
                      $name = Str::snake($field->model);
                      $line = "
    public function $name()
    {
        return \$this->hasOne(\App\Models\\$field->model::class);
    }

    ";
                      $models[$model_name][] = $line;
                    case "has_many":
                      $name = Str::snake(Str::plural($field->model));
                      $line = "
    public function $name()
    {
        return \$this->hasMany(\App\Models\\$field->model::class);
    }

    ";
                      $models[$model_name][] = $line;
                      break;
                }
            }

            if($model->dates){
                $models[$model_name][] = "public \$timestamps = true;
                ";
            }else{
                $models[$model_name][] = "public \$timestamps = false;
                ";
            }
        }

        return $models;

    }

    public static function generateTable($data, $name){
        $table = "<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('$name', function (Blueprint \$table) {
";
        foreach ($data as $key => $value) {
            $table.="           ".$value."
";
        }
        
        $table.=             "        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('$name');
    }
};";
    return $table;
    }

    public static function generateModel($data, $name){
        $model = "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class $name extends Model
{

    ";
foreach ($data as $key => $value) {
    $model .= $value;
}
$model .= "
}
        ";
    return $model;
    }

    public static function generateLayout(){
$data = <<<EOD
<!doctype html>
<html>

<head>
    @include('includes.head')
</head>

<body class="bg-light">

    @include('includes.header')

    <section>
        <div class="container">

            @yield('content')
            
        </div>
    </section>

    <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"
></script>

<script>
function tableToCSV() {
 
    var csv_data = [];
    var rows = document.getElementsByTagName('tr');
    for (var i = 0; i < rows.length; i++) {
        var cols = rows[i].querySelectorAll('td,th');
        var csvrow = [];
        for (var j = 0; j < cols.length; j++) {
            if(j == cols.length-1){
                continue;
            }
            csvrow.push(cols[j].textContent);
        }
        csv_data.push(csvrow.join(","));
    }
    csv_data = csv_data.join('\\n');
    downloadCSVFile(csv_data);
}

function downloadCSVFile(csv_data) {
    CSVFile = new Blob([csv_data], { type: "text/csv" });
    var temp_link = document.createElement('a');
    temp_link.download = "data.csv";
    var url = window.URL.createObjectURL(CSVFile);
    temp_link.href = url;
    temp_link.style.display = "none";
    document.body.appendChild(temp_link);
    temp_link.click();
    document.body.removeChild(temp_link);
}
</script>
</body>

</html>
EOD;
      return $data;
    }

    public static function generateHead($app_name){
      $data = <<<EOD
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
<!-- MDB -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.css" rel="stylesheet" />

<title>$app_name</title>
EOD;

      return $data;
    }

    public static function generateHeader($data, $app_name){
      $return = <<<EOD
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container">
          <a class="navbar-brand" href="{{ route('home') }}">$app_name</a>
          <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">

      EOD;

      foreach ($data as $key => $value) {
        $name = $value['name'];
        $label = ucfirst($name);
        $return .= <<<EOD
                  <li class="nav-item">
                      <a class="nav-link" href="{{route('$name.index')}}">$label</a>
                  </li>
        
        EOD;

      }

      $return .= <<<EOD
      </ul>
    </div>
  </div>
</nav>
  
EOD;

      return $return;
    }

    public static function generateHome($data){
      $return = <<<EOD
      @extends('layouts.default')
      @section('content')
      <div class="row">

      EOD;

      foreach ($data as $key => $value) {
        $name = $value['name'];
        $model = $value['model'];
        $label = ucfirst($name);
        $return .= <<<EOD
          <div class="col-6 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">$label</h5>
                <a href="{{route('$name.index')}}" class="btn btn-primary">View all</a>
                <a href="{{route('$name.create')}}" class="btn btn-success">New $model</a>
              </div>
            </div>
          </div>

        EOD;

      }

      $return .= 
      <<<EOD
      </div>
      @stop
  
      EOD;

      return $return;
    }

    public static function getControllers($data){
        $json = json_decode($data);

        if(empty($json->controllers)){
          return false;
        }
        $controllers = [];

        $required = \App\Generator::getRequired($data);
        
        foreach ($json->controllers as $key => $value) {

            $model = $value->model;
            $model_lower = Str::snake($value->model);
            $name = Str::snake(Pluralizer::plural($value->model));
            $controller_name = ucfirst($value->model).'Controller';

            $controller = [
                "model" => $model,
                "name" => $name,
                "controller" => $controller_name
            ];

            $controller["form_fields_create"] = [];
            $controller["form_fields_edit"] = [];
            $controller["list_fields_header"] = [];
            $controller["list_fields_row"] = [];

            $controller["list_fields_header"][] = 
            <<<EOD
            ID
            EOD;

            $controller["list_fields_row"][] = 
            <<<EOD
            {{\$$model_lower -> id}}
            EOD;

            foreach ($value->list_fields as $key => $field) {
              $label = ucfirst(str_replace('_', ' ', $field->field));
              $field_name = Str::snake($field->field);
              $controller["list_fields_header"][] = 
              <<<EOD
              $label
              EOD;

              switch ($field->type) {
                case "boolean":
                  $controller["list_fields_row"][] = 
                  <<<EOD
                  @if(\$$model_lower -> $field_name)<span class="badge badge-success">Yes</span>@else<span class="badge badge-danger">No</span>@endif
                  EOD;
                  break;
                case "relation":
                  $relation_label = $field->label;
                  $controller["list_fields_row"][] = 
                  <<<EOD
                  @if(\$$model_lower -> $field_name) {{\$$model_lower -> $field_name -> $relation_label}}@endif
                  EOD;
                  break;
                default:
                  $controller["list_fields_row"][] = 
                  <<<EOD
                  {{\$$model_lower -> $field_name}}
                  EOD;
                  break;
              }
            }

            $controller["list_fields_header"][] = 
            <<<EOD
            Actions
            EOD;

            $controller["list_fields_row"][] = 
            <<<EOD
            
                                      <a href="{{route('$name.edit', ['$model_lower' => \$$model_lower])}}" class="btn btn-primary btn-sm">Edit</a>
                                      <form method="POST" action="{{route('$name.destroy', ['$model_lower' => \$$model_lower])}}" class="d-inline">
                                          @csrf
                                          @method('DELETE')
                                          <button href="{{route('$name.destroy', ['$model_lower' => \$$model_lower])}}" class="btn btn-danger btn-sm">Delete</button>
                                      </form>
            EOD;

            $with = [];
            foreach ($value->form_fields as $key => $field) {
              if(isset($field->field)){
                $label = ucfirst(str_replace('_', ' ', $field->field));
                $field_name = Str::snake($field->field);
                $required_attr = isset($required[$model][$field->field]) ? "required" : "";
              }
              switch ($field->type) {
                case "switch":
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      <div class="form-check form-switch">
                                          <input type="hidden" name="$field_name" value="0"> 
                                          <input class="form-check-input" type="checkbox" role="switch" id="$field_name" name="$field_name" value="1"/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      <div class="form-check form-switch">
                                          <input type="hidden" name="$field_name" value="0"> 
                                          <input class="form-check-input" type="checkbox" role="switch" id="$field_name" name="$field_name" value="1" @if( $$model_lower -> $field_name)checked @endif/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  break;
                case "text":
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="text" id="$field_name" class="form-control" name="$field_name" $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="text" id="$field_name" class="form-control" name="$field_name" @if($$model_lower -> $field_name)value="{{ $$model_lower -> $field_name}}"@endif $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  break;
                case "integer":
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="number" id="$field_name" class="form-control" name="$field_name" step="1" $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="number" id="$field_name" class="form-control" name="$field_name" step="1" @if($$model_lower -> $field_name)value="{{ $$model_lower -> $field_name}}"@endif $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  break;
                case "decimal":
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="number" id="$field_name" class="form-control" name="$field_name" step="any" $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="number" id="$field_name" class="form-control" name="$field_name" step="any" @if($$model_lower -> $field_name)value="{{ $$model_lower -> $field_name}}"@endif $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  break;
                case "date":
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="date" id="$field_name" class="form-control" name="$field_name" $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <input type="date" id="$field_name" class="form-control" name="$field_name" @if($$model_lower -> $field_name)value="{{ date("Y-m-d", strtotime($$model_lower -> $field_name))}}"@endif $required_attr/>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  break;
                case "textarea":
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <textarea class="form-control" id="$field_name" rows="4" name="$field_name" $required_attr></textarea>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      <div class="form-outline">
                                          <textarea class="form-control" id="$field_name" rows="4" name="$field_name" $required_attr> @if($$model_lower -> $field_name){{ $$model_lower -> $field_name}}@endif</textarea>
                                          <label class="form-label" for="$field_name">$label</label>
                                      </div>
                  EOD;
                  break;
                case "belongs_to":
                  $field_name = strtolower($field->model);
                  $relation_name = strtolower(Pluralizer::plural($field->model));
                  $relation_label = strtolower($field->label);
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      <select class="form-select" name="{$field_name}_id">
                                      @foreach ($$relation_name as $$field_name)
                                      <option value="{{ $$field_name ->id}}">{{ $$field_name ->$relation_label}}</option>
                                          
                                      @endforeach
                                      </select>
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      <select class="form-select" name="{$field_name}_id">
                                      @foreach ($$relation_name as $$field_name)
                                      <option value="{{ $$field_name ->id}}" @if ($$model_lower -> {$field_name}_id == $$field_name ->id) selected @endif>{{ $$field_name ->$relation_label}}</option>
                                          
                                      @endforeach
                                      </select>
                  EOD;
                  $with[$relation_name] = $field->model;
                  break;
                case "belongs_to_many":
                  $field_name = strtolower($field->model);
                  $relation_name = strtolower(Pluralizer::plural($field->model));
                  $relation_label = strtolower($field->label);
                  $controller["form_fields_create"][] = 
                  <<<EOD
                                      @foreach ($$relation_name as $$field_name)
                                      <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="{{ $$field_name ->id}}" id="{$relation_name}_{{ $$field_name ->id }}" name="{$relation_name}[]"/>
                                          <label class="form-check-label" for="{$relation_name}_{{ $$field_name ->id }}">{{ $$field_name ->$relation_label}}</label>
                                      </div>
                                      @endforeach
                  EOD;
                  $controller["form_fields_edit"][] = 
                  <<<EOD
                                      @foreach ($$relation_name as $$field_name)
                                      <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="{{ $$field_name ->id}}" id="{$relation_name}_{{ $$field_name ->id }}" name="{$relation_name}[]" @if($$model_lower ->$relation_name ->contains($$field_name)) checked @endif/>
                                          <label class="form-check-label" for="{$relation_name}_{{ $$field_name ->id }}">{{ $$field_name ->$relation_label}}</label>
                                      </div>
                                      @endforeach
                  EOD;
                  $with[$relation_name] = $field->model;
                  break;
                
                
              }
            }

            $create = 
            <<<EOD
                public function create()
                {

            EOD;
            $create .= "        return view('pages.$name.create')";
            foreach ($with as $k => $v) {
              $create .= "->with('".$k."',\App\Models\\".$v."::all())";
            }
            $create .= ";";
            $create .= 
            <<<EOD

                }
            EOD;

            $edit = 
            <<<EOD
                public function edit(\App\Models\\$model $$model_lower)
                {

            EOD;
            $edit .= "        return view('pages.$name.edit', ['$model_lower' => \$$model_lower])";
            foreach ($with as $k => $v) {
              $edit .= "->with('".$k."',\App\Models\\".$v."::all())";
            }
            $edit .= ";";
            $edit .= 
            <<<EOD

                }
            EOD;

            $store =
            <<<EOD

            EOD;

            $controller["functions"] = [
              <<<EOD
                  public function index()
                  {
                      return view('pages.$name.index', ['$name' => \App\Models\\$model::query()->orderBy('id', 'DESC')->paginate(20)]);
                  }
              EOD,
              $create,
              <<<EOD
                  public function store(Request \$request)
                  {
                      \$data = \$request->except(['_method', '_token']);

                      \$relations = [];

                      foreach (\$data as \$key => \$value) {
                          if(is_array(\$value)){
                              unset(\$data[\$key]);
                              \$relations[\$key] = \$value;
                          }
                      }

                      $$model_lower = \App\Models\\$model::create(\$data);

                      foreach (\$relations as \$key => \$value) {
                        \$$model_lower->{\$key}()->sync(\$value);
                      }
                      return redirect()->route('$name.index');
                  }
              EOD,
              $edit,
              <<<EOD
                  public function update(Request \$request, \App\Models\\$model $$model_lower)
                  {
                      \$data = \$request->except(['_method', '_token']);

                      \$relations = [];

                      foreach (\$data as \$key => \$value) {
                          if(is_array(\$value)){
                              unset(\$data[\$key]);
                              \$relations[\$key] = \$value;
                          }
                      }

                      $$model_lower ->update(\$data);

                      foreach (\$relations as \$key => \$value) {
                        \$$model_lower->{\$key}()->sync(\$value);
                      }

                      return redirect()->route('$name.index');
                  }
              EOD,
              <<<EOD
                  public function destroy(\App\Models\\$model $$model_lower)
                  {
                      $$model_lower ->delete();
                      return redirect()->route('$name.index');
                  }
              EOD,
            ];

            $controllers[] = $controller;
        }
        return $controllers;

    }

    public static function generateController($data){
        $return = "<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class {$data['controller']} extends Controller
{
  
";

  foreach ($data['functions'] as $key => $value) {
    $return .= $value."

";
  }
  $return .="
}
";
return $return;

    }

    public static function generateIndexView($data){
      $model_lower = Str::snake($data['model']);
      $label = ucfirst($data['name']);
      $name = $data['name'];
      $return = <<<EOD
      @extends('layouts.default')
      @section('content')
          <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                  <span class="fw-bold">$label</span>
                  <div>
                  <button type="button" class="btn btn-success btn-sm" onclick="tableToCSV()">
                  Export CSV
                  </button>
                  <a href="{{route('{$data['name']}.create')}}"
                          class="btn btn-primary btn-sm">New {$data['model']}</a></div>
              </div>
              <div class="card-body table-responsive">
                  <table class="table" id="table">
                      <thead>
                          <tr>
      
      EOD;

      foreach ($data['list_fields_header'] as $key => $value) {
        $class = ($key == 0) ? 'text_start' : (($key == count($data['list_fields_header'])-1) ? 'text-end' : 'text-center');
        $return .= '                        <th class="'.$class.'">'.$value.'</th>
';
      }

      $return .= 
      <<<EOD
                          </tr>
                      </thead>
                      <tbody>
                          @foreach (\$$name as $$model_lower)
                              <tr>
      
      EOD;
      foreach ($data['list_fields_row'] as $key => $value) {
        $style = (($key == count($data['list_fields_header'])-1) ? 'style="width:15%"' : '');
        $class = ($key == 0) ? 'text_start' : (($key == count($data['list_fields_header'])-1) ? 'text-end' : 'text-center');

        $return .= '                          <td class="'.$class.'" '.$style.'>'.$value.'</td>
';
      }
      $return .= 
      <<<EOD
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  {{ \$$name ->links() }}
              </div>
          </div>
      @stop
      EOD;
      
      return $return;

  }

  public static function generateCreateView($data){
    $model = $data['model'];
    $name = $data['name'];
    $return = 
    <<<EOD
    @extends('layouts.default')
    @section('content')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">New $model</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('$name.store')}}">
                @csrf
                <div class="row">
                    
    EOD;

    foreach ($data['form_fields_create'] as $key => $value) {
      $return .= 
      <<<EOD
      <div class="col-6 mb-4">
      $value
                      </div>
                      
      EOD;
    }
    $return .= 
    <<<EOD
                </div>    
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    @stop
    
    EOD;

    return $return;
  }

  public static function generateEditView($data){
    $model = $data['model'];
    $name = $data['name'];
    $model_lower = Str::snake($model);
    $return = 
    <<<EOD
    @extends('layouts.default')
    @section('content')
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">Edit $model</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('$name.update', ['$model_lower' => $$model_lower])}}">
                @method('PUT')
                @csrf
                <div class="row">

    EOD;

    foreach ($data['form_fields_edit'] as $key => $value) {
      $return .= 
      <<<EOD
      <div class="col-6 mb-4">
      $value
                      </div>
                      
      EOD;
    }
    $return .= 
    <<<EOD
                </div>    
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    @stop
    
    EOD;

    return $return;
  }

  public static function getRoutes($data){
    $json = json_decode($data);
    $routes = [];
    
    foreach ($json->controllers as $key => $value) {
        $name = strtolower(Pluralizer::plural($value->model));
        $controller_name = ucfirst($value->model).'Controller';
        $routes[] = "Route::resource('$name', \App\Http\Controllers\\$controller_name::class);
";
    }

    return $routes;
  }

  public static function generateRoutes($data){
    $return = 
    <<<EOD
    <?php

    use Illuminate\Support\Facades\Route;
    
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/', function () {
      return view('pages.home');
    })->name('home');

    EOD;

    foreach ($data as $key => $value) {
      $return .= $value;
    }

    return $return;
  }

  public static function generateAppServiceProvider(){
    $return = 
    <<<EOD
    <?php
    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Pagination\Paginator;
    
    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Register any application services.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot()
        {
            Paginator::useBootstrapFive();
        }
    }
    EOD;

    return $return;
  }

}