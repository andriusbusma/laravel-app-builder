var model_fields = [
  "string",
  "boolean",
  "integer",
  "decimal",
  "date",
  "text",
];

var model_relation_fields = ["belongs_to", "belongs_to_many"];

var workspace = Blockly.inject("blocklyDiv", {
  toolbox: document.getElementById("toolbox"),
  trashcan: true,
  zoom: {
    controls: true,
    wheel: true,
    startScale: 1.0,
    maxScale: 3,
    minScale: 0.3,
    scaleSpeed: 1.2,
    pinch: true,
  },
});

function update(event) {
  var code = Blockly.JSON.workspaceToCode(workspace);
  $("input[name=json]").val(code);

  models = [];

  for (const block of workspace.getBlocksByType("model_model")) {
    models.push([block.getField("name").value_, block.getField("name").value_]);
  }

  if (!models.length) {
    models.push(["-", "-"]);
  }

  for (const block of workspace.getBlocksByType("controller_controller")) {
    block.getField("model").menuGenerator_ = models;
  }

  for (const block of workspace.getBlocksByType("model_has_one")) {
    if (block.getSurroundParent()) {
      block.getField("model").menuGenerator_ = models;
    } else {
      block.getField("model").menuGenerator_ = [["-", "-"]];
    }
  }
  for (const block of workspace.getBlocksByType("model_has_many")) {
    if (block.getSurroundParent()) {
      block.getField("model").menuGenerator_ = models;
    } else {
      block.getField("model").menuGenerator_ = [["-", "-"]];
    }
  }
  for (const block of workspace.getBlocksByType("model_belongs_to")) {
    if (block.getSurroundParent()) {
      block.getField("model").menuGenerator_ = models;
    } else {
      block.getField("model").menuGenerator_ = [["-", "-"]];
    }
  }
  for (const block of workspace.getBlocksByType("model_belongs_to_many")) {
    if (block.getSurroundParent()) {
      block.getField("model").menuGenerator_ = models;
    } else {
      block.getField("model").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_text")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelTextFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_integer")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelIntegerFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_decimal")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelDecimalFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_switch")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelSwitchFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_textarea")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelTextareaFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_date")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelDateFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_relation_belongs_to")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelRelationFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_form_relation_belongs_to_many")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelRelationManyFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_list_text")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelTextFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_list_number")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelNumberFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_list_boolean")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelSwitchFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_list_date")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelDateFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }

  for (const block of workspace.getBlocksByType("controller_list_relation")) {
    if (block.getSurroundParent()) {
      block.getField("field").menuGenerator_ = getModelRelationFields(
        block.getSurroundParent().getField("model").value_,
        code
      );
    } else {
      block.getField("field").menuGenerator_ = [["-", "-"]];
    }
  }
}
workspace.addChangeListener(update);

function getModelFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (model_fields.includes(block_field.type)) {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelRelationFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'belongs_to') {
          fields.push([block_field.model, block_field.model]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelRelationManyFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'belongs_to_many') {
          fields.push([block_field.model, block_field.model]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelTextFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'string') {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelIntegerFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'integer') {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelDecimalFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'decimal') {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelNumberFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'decimal' || block_field.type == 'integer') {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelSwitchFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'boolean') {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelDateFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'date') {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}

function getModelTextareaFields(model_name, code) {
  var fields = [];

  for (const model of JSON.parse(code).models) {
    if (model.name == model_name) {
      for (const block_field of model.fields) {
        if (block_field.type == 'text') {
          fields.push([block_field.name, block_field.name]);
        }
      }
      if (!fields.length) {
        fields.push(["-", "-"]);
      }
      return fields;
    }
  }
}