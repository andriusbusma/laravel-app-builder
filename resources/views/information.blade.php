<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Style CSS-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.1/mdb.min.css" rel="stylesheet" />
    <title>Laravel app builder</title>
</head>

<body>
    <div class="header shadow-5 mb-4">
        <h3 class="text-center text-white p-3">Laravel app builder</h3>
    </div>
    <div class="container">
        <div class="card shadow-5 mb-4">
            <h5 class="card-header">Model blocks</h5>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_model.png')}}">
                        <h5>Model block</h5>
                        <p class="mb-0">Block that respresents model structure.</p>
                        <p class="mb-0"><b>Name field</b> - model name</p>
                        <p class="mb-0"><b>Dates field</b> - creates auto updated data fields (<i>created_at</i> and <i>updated_at</i> in Laravel)</p>
                        <p class="mb-0"><b>Field list</b> - list of different type field blocks</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_string.png')}}">
                        <h5>String field</h5>
                        <p class="mb-0">Block that respresents model string field (<i>varchar</i> database field).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_boolean.png')}}">
                        <h5>Boolean field</h5>
                        <p class="mb-0">Block that respresents model boolean field (<i>tinyint</i> database field).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_integer.png')}}">
                        <h5>Integer field</h5>
                        <p class="mb-0">Block that respresents model integer field (<i>integer</i> database field).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_decimal.png')}}">
                        <h5>Decimal field</h5>
                        <p class="mb-0">Block that respresents model decimal field (<i>decimal</i> database field).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_date.png')}}">
                        <h5>Data field</h5>
                        <p class="mb-0">Block that respresents model data field (<i>timestamp</i> database field).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_text.png')}}">
                        <h5>Text field</h5>
                        <p class="mb-0">Block that respresents model text field (<i>text</i> database field).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_has_one.png')}}">
                        <h5>Has One</h5>
                        <p class="mb-0">Block that respresents one-to-one relationship (<i>hasOne()</i> function in Laravel).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_has_many.png')}}">
                        <h5>Has Many</h5>
                        <p class="mb-0">Block that respresents one-to-many relationship (<i>hasMany()</i> function in Laravel).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_belongs_to.png')}}">
                        <h5>Belongs To</h5>
                        <p class="mb-0">Block that respresents one-to-one and one-to-many inverse relationship (<i>belongsTo()</i> function in Laravel).</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/model_belongs_to.png')}}">
                        <h5>Belongs To Many</h5>
                        <p class="mb-0">Block that respresents many-to-many relationship (<i>belongsToMany()</i> function in Laravel).</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-5 mb-4">
            <h5 class="card-header">Controller blocks</h5>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/controller_controller.png')}}">
                        <h5>Controller block</h5>
                        <p class="mb-0">Block that respresents controller structure.</p>
                        <p class="mb-0"><b>Model selection</b> - model block</p>
                        <p class="mb-0"><b>Form fields list</b> - list of form fields in record edit and creation pages</p>
                        <p class="mb-0"><b>List fields list</b> - list of records table columns</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_text.png')}}">
                        <h5>Form text</h5>
                        <p class="mb-0">Block that respresents HTML <i>text</i> input</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_integer.png')}}">
                        <h5>Form integer</h5>
                        <p class="mb-0">Block that respresents HTML <i>number</i> input (step is 1)</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_decimal.png')}}">
                        <h5>Form decimal</h5>
                        <p class="mb-0">Block that respresents HTML <i>number</i> input</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_textarea.png')}}">
                        <h5>Form textarea</h5>
                        <p class="mb-0">Block that respresents HTML <i>textarea</i> input</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_switch.png')}}">
                        <h5>Form switch</h5>
                        <p class="mb-0">Block that respresents HTML <i>checkbox</i> input</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_date.png')}}">
                        <h5>Form date</h5>
                        <p class="mb-0">Block that respresents HTML <i>date</i> input</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_belongs_to.png')}}">
                        <h5>Form relation (Belongs To)</h5>
                        <p class="mb-0">Block that respresents HTML <i>select</i> input with selectable relation fields.</p>
                        <p class="mb-0"><b>Label</b> - displayed relation field</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/form_belongs_to_many.png')}}">
                        <h5>Form relation (Belongs To Many)</h5>
                        <p class="mb-0">Block that respresents HTML <i>checkbox</i> group input with selectable relation fields</p>
                        <p class="mb-0"><b>Label</b> - displayed relation field</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/list_text.png')}}">
                        <h5>List text</h5>
                        <p class="mb-0">Block that respresents text in table</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/list_number.png')}}">
                        <h5>List number</h5>
                        <p class="mb-0">Block that respresents formated number in table</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/list_boolean.png')}}">
                        <h5>List booelean</h5>
                        <p class="mb-0">Block that respresents boolean state in table</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/list_date.png')}}">
                        <h5>List date</h5>
                        <p class="mb-0">Block that respresents formated date in table</p>
                    </div>
                    <div class="col-4 mb-4">
                        <img src="{{asset('img/list_relation.png')}}">
                        <h5>List relation</h5>
                        <p class="mb-0">Block that respresents relation (Belongs To) field in table</p>
                        <p class="mb-0"><b>Label</b> - displayed relation field</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-5 mb-4">
            <h5 class="card-header">Running generated app</h5>
            <div class="card-body">
                <ol>
                    <li>Install <a href="https://laravel.com/docs/9.x/installation">Laravel</a> web framework</li>
                    <li>Set up database by typing database connection credentials in <i>.env</i> file</li>
                    <li>Copy generated files from archive to Laravel installation directory</li>
                    <li>Run <kbd>php artisan migrate</kbd> command in Command Line Interface(CLI)</li>
                </ol>
            </div>
        </div>
    </div>

    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"
    ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
