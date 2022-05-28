Blockly.JSON = new Blockly.Generator('JSON');

Blockly.Generator.prototype.workspaceToCode = function(workspace) {
  if (!workspace) {
    console.warn('No workspace specified in workspaceToCode call.  Guessing.');
    workspace = Blockly.getMainWorkspace();
  }
  var model_code = [];
  var controller_code = [];
  this.init(workspace);
  var blocks = workspace.getTopBlocks(true);
  for (var i = 0, block; (block = blocks[i]); i++) {

    if(block.type != 'model_model' && block.type != 'controller_controller'){
        continue;
    }
    var line = this.blockToCode(block);
    if (Array.isArray(line)) {
      line = line[0];
    }
    if (line) {
      if (block.outputConnection) {
        line = this.scrubNakedValue(line);
        if (this.STATEMENT_PREFIX && !block.suppressPrefixSuffix) {
          line = this.injectId(this.STATEMENT_PREFIX, block) + line;
        }
        if (this.STATEMENT_SUFFIX && !block.suppressPrefixSuffix) {
          line = line + this.injectId(this.STATEMENT_SUFFIX, block);
        }
      }
      if(block.type == 'model_model'){
        if(line){
          model_code.push(line);
        }
      }
      if(block.type == 'controller_controller'){
        if(line){
          controller_code.push(line);
        }
      }
    }
  }
  model_code = '['+model_code.join(',')+']';
  controller_code = '['+controller_code.join(',')+']';

  return '{"models":'+model_code+',"controllers":'+controller_code+'}';
};

Blockly.JSON.scrub_ = function(block, code, opt_thisOnly) {

    var nextBlock = block.nextConnection && block.nextConnection.targetBlock();
    var nextCode = opt_thisOnly ? '' : this.blockToCode(nextBlock);
    if(nextCode && code.length){
      return code +','+ nextCode;
    }else{
        return code + nextCode;
    }
  };

Blockly.JSON['model_model'] = function(block) {

    var fields = Blockly.JSON.statementToCode(block, 'fields').trim();
    var code = '{"name":"'+block.getFieldValue('name')+'","dates":'+block.getFieldValue('dates').toLowerCase()+',"fields":['+fields+']}';
    return code
}

Blockly.JSON['model_string'] = function(block) {
    var code = '{"name":"'+block.getFieldValue('name')+'","type":"string","nullable":'+block.getFieldValue('nullable').toLowerCase()+',"default":"'+block.getFieldValue('default')+'"}';
    return code;
}

Blockly.JSON['model_integer'] = function(block) {
    var code = '{"name":"'+block.getFieldValue('name')+'","type":"integer","nullable":'+block.getFieldValue('nullable').toLowerCase()+',"default":"'+block.getFieldValue('default')+'"}';
    return code;
}

Blockly.JSON['model_decimal'] = function(block) {
    var code = '{"name":"'+block.getFieldValue('name')+'","type":"decimal","nullable":'+block.getFieldValue('nullable').toLowerCase()+',"default":"'+block.getFieldValue('default')+'"}';
    return code;
}

Blockly.JSON['model_boolean'] = function(block) {
    var code = '{"name":"'+block.getFieldValue('name')+'","type":"boolean","default":'+block.getFieldValue('default').toLowerCase()+'}';
    return code;
}

Blockly.JSON['model_date'] = function(block) {
    var code = '{"name":"'+block.getFieldValue('name')+'","type":"date","nullable":'+block.getFieldValue('nullable').toLowerCase()+'}';
    return code;
}

Blockly.JSON['model_text'] = function(block) {
    var code = '{"name":"'+block.getFieldValue('name')+'","type":"text","nullable":'+block.getFieldValue('nullable').toLowerCase()+'}';
    return code;
}

Blockly.JSON['model_has_one'] = function(block) {
  var code = '{"type":"has_one","model":"'+block.getFieldValue('model')+'"}';
  return code;
}
Blockly.JSON['model_has_many'] = function(block) {
  var code = '{"type":"has_many","model":"'+block.getFieldValue('model')+'"}';
  return code;
}
Blockly.JSON['model_belongs_to'] = function(block) {
  var code = '{"type":"belongs_to","model":"'+block.getFieldValue('model')+'"}';
  return code;
}
Blockly.JSON['model_belongs_to_many'] = function(block) {
  var code = '{"type":"belongs_to_many","model":"'+block.getFieldValue('model')+'"}';
  return code;
}

Blockly.JSON['controller_controller'] = function(block) {
  var form_fields = Blockly.JSON.statementToCode(block, 'form_fields').trim();
  var list_fields = Blockly.JSON.statementToCode(block, 'list_fields').trim();
  var code = '{"model":"'+block.getFieldValue('model')+'","form_fields":['+form_fields+'],"list_fields":['+list_fields+']}';
  return code
}

Blockly.JSON['controller_form_text'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"text"}';
  return code;
}

Blockly.JSON['controller_form_integer'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"integer"}';
  return code;
}

Blockly.JSON['controller_form_decimal'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"decimal"}';
  return code;
}

Blockly.JSON['controller_form_textarea'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"textarea"}';
  return code;
}

Blockly.JSON['controller_form_switch'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"switch"}';
  return code;
}

Blockly.JSON['controller_form_date'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"date"}';
  return code;
}

Blockly.JSON['controller_form_relation_belongs_to'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"model":"'+block.getFieldValue('field')+'","type":"belongs_to","label":"'+block.getFieldValue('label')+'"}';
  return code;
}

Blockly.JSON['controller_form_relation_belongs_to_many'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"model":"'+block.getFieldValue('field')+'","type":"belongs_to_many","label":"'+block.getFieldValue('label')+'"}';
  return code;
}

Blockly.JSON['controller_list_text'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"text"}';
  return code;
}

Blockly.JSON['controller_list_number'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"number"}';
  return code;
}

Blockly.JSON['controller_list_boolean'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"boolean"}';
  return code;
}

Blockly.JSON['controller_list_date'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"date"}';
  return code;
}

Blockly.JSON['controller_list_relation'] = function(block) {
  if(block.getFieldValue('field') == '-'){
    return '';
  }
  var code = '{"field":"'+block.getFieldValue('field')+'","type":"relation","label":"'+block.getFieldValue('label')+'"}';
  return code;
}