<table
        data-editor="true"
        data-editor-class="MultiLevelAutocomplete"
        data-editable="true"
        data-field-name="<?php echo $this->_tpl_vars['MultilevelEditor']->GetFieldName(); ?>
"
        class="pgui-multilvevel-autocomplete" style="">
<tbody>
<?php $_from = $this->_tpl_vars['Editors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Editors'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Editors']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Editor']):
        $this->_foreach['Editors']['iteration']++;
?>
    <tr>
        <td><span><?php echo $this->_tpl_vars['Editor']['Caption']; ?>
</span></td>
        <td>
            <select data-placeholder="<?php echo $this->_tpl_vars['Captions']->GetMessageString('PleaseSelect'); ?>
"
                    name="<?php echo $this->_tpl_vars['Editor']['Name']; ?>
"
                    search
                    multi-autocomplete="true"
                <?php if ($this->_tpl_vars['Editor']['ParentEditor']): ?>
                    parent-autocomplete="<?php echo $this->_tpl_vars['Editor']['ParentEditor']; ?>
"
                <?php endif; ?>
                    data-url="<?php echo $this->_tpl_vars['Editor']['DataURL']; ?>
"
                <?php if (($this->_foreach['Editors']['iteration'] == $this->_foreach['Editors']['total'])): ?>
                    data-multileveledit-main="true"
                    <?php echo $this->_tpl_vars['Validators']['InputAttributes']; ?>

                <?php endif; ?>
                    ><option value="<?php echo $this->_tpl_vars['Editor']['Value']; ?>
"><?php echo $this->_tpl_vars['Editor']['DisplayValue']; ?>
</option></select>

        </td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</tbody></table>