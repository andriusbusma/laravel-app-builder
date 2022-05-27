var model_fields = [
    "model_string",
    "model_boolean",
    "model_integer",
    "model_decimal",
    "model_date",
    "model_text",
    "model_has_one",
    "model_has_many",
    "model_belongs_to",
    "model_belongs_to_many"
];

var controller_form_fields = [
    "controller_form_text",
    "controller_form_decimal",
    "controller_form_integer",
    "controller_form_textarea",
    "controller_form_switch",
    "controller_form_date",
    "controller_form_relation_belongs_to",
    "controller_form_relation_belongs_to_many"
];

var controller_list_fields = [
    "controller_list_text",
    "controller_list_number",
    "controller_list_boolean",
    "controller_list_date",
    "controller_list_relation",
];

Blockly.Blocks['model_model'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.charAt(0).toUpperCase() + value.slice(1);
        };
        this.appendDummyInput()
            .appendField("Model")
            .appendField(new Blockly.FieldTextInput("", validator), "name")
            .appendField("add dates:")
            .appendField(new Blockly.FieldCheckbox("", validator), "dates")
        this.appendStatementInput("fields")
            .setCheck(model_fields);
        this.setColour(120);
    }
};

Blockly.Blocks['model_string'] = {
    init: function() {
        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };

        this.appendDummyInput()
          .appendField("String field")
          .appendField(new Blockly.FieldTextInput("",validator), "name")
          .appendField("Nullable")
          .appendField(new Blockly.FieldCheckbox("TRUE"), "nullable")
          .appendField("Default")
          .appendField(new Blockly.FieldTextInput(""), "default");
        this.setPreviousStatement(true,model_fields);
        this.setNextStatement(true,model_fields);
        this.setColour(160);
    }
};

Blockly.Blocks['model_integer'] = {
    init: function() {
        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };

        this.appendDummyInput()
          .appendField("Integer field")
          .appendField(new Blockly.FieldTextInput("",validator), "name")
          .appendField("Nullable")
          .appendField(new Blockly.FieldCheckbox("TRUE"), "nullable")
          .appendField("Default")
          .appendField(new Blockly.FieldNumber(0), "default");
        this.setPreviousStatement(true, model_fields);
        this.setNextStatement(true, model_fields);
        this.setColour(160);
    }
};

Blockly.Blocks['model_decimal'] = {
    init: function() {
        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };

        this.appendDummyInput()
          .appendField("Decimal field")
          .appendField(new Blockly.FieldTextInput("",validator), "name")
          .appendField("Nullable")
          .appendField(new Blockly.FieldCheckbox("TRUE"), "nullable")
          .appendField("Default")
          .appendField(new Blockly.FieldNumber(0, -Infinity, Infinity, 2), "default");
        this.setPreviousStatement(true, model_fields);
        this.setNextStatement(true, model_fields);
        this.setColour(160);
    }
};

Blockly.Blocks['model_boolean'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };
      this.appendDummyInput()
          .appendField("Boolean field")
          .appendField(new Blockly.FieldTextInput("",validator), "name")
          .appendField("Default")
          .appendField(new Blockly.FieldDropdown([["true","true"],["false","false"]]), "default");
      this.setPreviousStatement(true,model_fields);
      this.setNextStatement(true,model_fields);
      this.setColour(160);
    }
};

Blockly.Blocks['model_date'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };
      this.appendDummyInput()
          .appendField("Date field")
          .appendField(new Blockly.FieldTextInput("",validator), "name")
          .appendField("Nullable")
          .appendField(new Blockly.FieldCheckbox("TRUE"), "nullable");
      this.setPreviousStatement(true,model_fields);
      this.setNextStatement(true,model_fields);
      this.setColour(160);
    }
};

Blockly.Blocks['model_text'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };
      this.appendDummyInput()
          .appendField("Text field")
          .appendField(new Blockly.FieldTextInput("",validator), "name")
          .appendField("Nullable")
          .appendField(new Blockly.FieldCheckbox("TRUE"), "nullable");
      this.setPreviousStatement(true,model_fields);
      this.setNextStatement(true,model_fields);
      this.setColour(160);
    }
};

Blockly.Blocks['model_has_one'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };
      this.appendDummyInput()
          .appendField("Has One")
          .appendField(new Blockly.FieldDropdown([["-","-"]]), "model");
          this.setPreviousStatement(true,model_fields);
          this.setNextStatement(true,model_fields);
          this.setColour(65);
    }
};

Blockly.Blocks['model_has_many'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };
      this.appendDummyInput()
          .appendField("Has Many")
          .appendField(new Blockly.FieldDropdown([["-","-"]]), "model");
          this.setPreviousStatement(true,model_fields);
          this.setNextStatement(true,model_fields);
          this.setColour(65);
    }
};

Blockly.Blocks['model_belongs_to'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };
      this.appendDummyInput()
          .appendField("Belongs To")
          .appendField(new Blockly.FieldDropdown([["-","-"]]), "model");
          this.setPreviousStatement(true,model_fields);
          this.setNextStatement(true,model_fields);
          this.setColour(65);
    }
};

Blockly.Blocks['model_belongs_to_many'] = {
    init: function() {

        var validator = function(value) {
            if(!value.length){
                return null;
            }
            return value.toLowerCase();
        };
      this.appendDummyInput()
          .appendField("Belongs To Many")
          .appendField(new Blockly.FieldDropdown([["-","-"]]), "model");
          this.setPreviousStatement(true,model_fields);
          this.setNextStatement(true,model_fields);
          this.setColour(65);
    }
};

Blockly.Blocks['controller_controller'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Controller")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "model");
        this.appendDummyInput()
            .appendField("Form fields");
        this.appendStatementInput("form_fields")
            .setCheck(controller_form_fields);
        this.appendDummyInput()
            .appendField("List fields");
        this.appendStatementInput("list_fields")
            .setCheck(controller_list_fields);
        this.setColour(330);
    }
};

Blockly.Blocks['controller_form_text'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form text field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_form_integer'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form integer field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_form_decimal'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form decimal field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_form_textarea'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form textarea field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_form_switch'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form switch field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_form_date'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form date field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_form_relation_belongs_to'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form relation (belongs to) field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field")
            .appendField("Label:")
            .appendField(new Blockly.FieldTextInput(""), "label");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_form_relation_belongs_to_many'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("Form relation (belongs to many) field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field")
            .appendField("Label:")
            .appendField(new Blockly.FieldTextInput(""), "label");
        this.setPreviousStatement(true,controller_form_fields);
        this.setNextStatement(true,controller_form_fields);
        this.setColour(210);
    }
};

Blockly.Blocks['controller_list_text'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("List text field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_list_fields);
        this.setNextStatement(true,controller_list_fields);
        this.setColour(270);
    }
};

Blockly.Blocks['controller_list_number'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("List number field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_list_fields);
        this.setNextStatement(true,controller_list_fields);
        this.setColour(270);
    }
};

Blockly.Blocks['controller_list_boolean'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("List boolean field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_list_fields);
        this.setNextStatement(true,controller_list_fields);
        this.setColour(270);
    }
};

Blockly.Blocks['controller_list_date'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("List date field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field");
        this.setPreviousStatement(true,controller_list_fields);
        this.setNextStatement(true,controller_list_fields);
        this.setColour(270);
    }
};

Blockly.Blocks['controller_list_relation'] = {
    init: function() {
        this.appendDummyInput()
            .appendField("List relation field")
            .appendField(new Blockly.FieldDropdown([["-","-"]]), "field")
            .appendField("Label:")
            .appendField(new Blockly.FieldTextInput(""), "label");
        this.setPreviousStatement(true,controller_list_fields);
        this.setNextStatement(true,controller_list_fields);
        this.setColour(270);
    }
};