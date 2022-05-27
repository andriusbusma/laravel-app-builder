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

        <div class="card shadow-5">
            <h5 class="card-header">Builder</h5>
            <div class="card-body">
                <xml id="toolbox" style="display: none">
                    <category name="Models" colour="120">
                        <block type="model_model"></block>
                        <block type="model_string"></block>
                        <block type="model_boolean"></block>
                        <block type="model_integer"></block>
                        <block type="model_decimal"></block>
                        <block type="model_date"></block>
                        <block type="model_text"></block>
                        <block type="model_has_one"></block>
                        <block type="model_has_many"></block>
                        <block type="model_belongs_to"></block>
                        <block type="model_belongs_to_many"></block>
                    </category>
                    <category name="Controllers" colour="330">
                        <block type="controller_controller"></block>
                        <block type="controller_form_text"></block>
                        <block type="controller_form_integer"></block>
                        <block type="controller_form_decimal"></block>
                        <block type="controller_form_textarea"></block>
                        <block type="controller_form_switch"></block>
                        <block type="controller_form_date"></block>
                        <block type="controller_form_relation_belongs_to"></block>
                        <block type="controller_form_relation_belongs_to_many"></block>
                        <block type="controller_list_text"></block>
                        <block type="controller_list_number"></block>
                        <block type="controller_list_boolean"></block>
                        <block type="controller_list_date"></block>
                        <block type="controller_list_relation"></block>
                    </category>
                </xml>
                <div id="blocklyDiv" style="width:100%;height:500px" class="mb-4"></div>
                <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#modal">Generate</button>
                <!-- Modal -->
                <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">Generate App</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <form action="{{route('generate')}}" method="POST">
                          @csrf
                          <div class="form-outline mb-4">
                          <input type="hidden" name="json"/>
                            <input type="text" id="app_name" class="form-control form-control-lg" name="app_name"/>
                            <label class="form-label" for="app_name">Enter your app name</label>
                          </div>
                            <button type="submit" class="btn btn-primary">Generate</button>

                          </form>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"
    ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/blockly_compressed.js') }}"></script>
    <script src="{{ asset('js/json_generator.js') }}"></script>
    <script src="{{ asset('js/blocks.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
