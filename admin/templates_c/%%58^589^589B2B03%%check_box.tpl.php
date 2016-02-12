<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'style_block', 'editors/check_box.tpl', 8, false),)), $this); ?>
<?php if ($this->_tpl_vars['RenderText']): ?>
<?php if (! $this->_tpl_vars['CheckBox']->GetReadOnly()): ?>
<input
    data-editor="true"
    data-editor-class="CheckBox"
    data-editable="true"
    data-field-name="<?php echo $this->_tpl_vars['CheckBox']->GetFieldName(); ?>
"
    <?php $this->_tag_stack[] = array('style_block', array()); $_block_repeat=true;smarty_block_style_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
        <?php echo $this->_tpl_vars['CheckBox']->GetCustomAttributes(); ?>

    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_style_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    type="checkbox"
    name="<?php echo $this->_tpl_vars['CheckBox']->GetName(); ?>
"
    id="<?php echo $this->_tpl_vars['CheckBox']->GetName(); ?>
"
    value="on" <?php if ($this->_tpl_vars['CheckBox']->Checked()): ?>
    checked="checked"<?php endif; ?>
    <?php echo $this->_tpl_vars['Validators']['InputAttributes']; ?>
>
<?php else: ?>
<?php if ($this->_tpl_vars['CheckBox']->Checked()): ?>
<img
    data-editor="true"
    data-editor-class="CheckBox"
    data-field-name="<?php echo $this->_tpl_vars['TextEdit']->GetFieldName(); ?>
"
    data-editable="false"
    data-value="1"
    src="images/checked.png" />
<?php else: ?>
<span
    data-editor="true"
    data-editor-class="CheckBox"
    data-field-name="<?php echo $this->_tpl_vars['CheckBox']->GetFieldName(); ?>
"
    data-editable="false"
    data-value="0"></span>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>