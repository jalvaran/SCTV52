<?php if (! $this->_tpl_vars['ComboBox']->GetReadOnly()): ?>
<?php if ($this->_tpl_vars['RenderText']): ?>
    <select data-placeholder="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PleaseSelect'); ?>
"
            data-editor="true"
            data-editor-class="Autocomplete"
            data-editable="true"
            data-field-name="<?php echo $this->_tpl_vars['ComboBox']->GetFieldName(); ?>
"
            name="<?php echo $this->_tpl_vars['ComboBox']->GetName(); ?>
"
            search
            autocomplete="true"
            data-url="<?php echo $this->_tpl_vars['ComboBox']->GetDataUrl(); ?>
"
            <?php echo $this->_tpl_vars['Validators']['InputAttributes']; ?>

            ><option value="<?php echo $this->_tpl_vars['ComboBox']->GetValue(); ?>
"><?php echo $this->_tpl_vars['ComboBox']->GetDisplayValue(); ?>
</option></select>
<?php endif; ?>
<?php else: ?>
<?php echo $this->_tpl_vars['ComboBox']->GetDisplayValue(); ?>

<?php endif; ?>