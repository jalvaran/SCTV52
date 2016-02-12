<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */


    include_once dirname(__FILE__) . '/' . 'components/utils/check_utils.php';
    CheckPHPVersion();
    CheckTemplatesCacheFolderIsExistsAndWritable();


    include_once dirname(__FILE__) . '/' . 'phpgen_settings.php';
    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthorizationStrategy()->ApplyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    // OnBeforePageExecute event handler
    
    
    
    class facturas_abonosDetailView0facturasPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`facturas_abonos`');
            $field = new IntegerField('idFacturasAbonos', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Fecha');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Monto');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('CuentaIngreso');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('NombreCuenta');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Usuarios_idUsuarios');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Facturas_idFacturas');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('CerradoDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('FechaCierreDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('HoraCierreDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for idFacturasAbonos field
            //
            $column = new TextViewColumn('idFacturasAbonos', 'IdFacturasAbonos', $this->dataset);
            $column->SetOrderable(false);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Monto field
            //
            $column = new TextViewColumn('Monto', 'Monto', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for Monto field
            //
            $editor = new TextEdit('monto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Monto', 'Monto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Monto field
            //
            $editor = new TextEdit('monto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Monto', 'Monto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CuentaIngreso field
            //
            $column = new TextViewColumn('CuentaIngreso', 'CuentaIngreso', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for CuentaIngreso field
            //
            $editor = new TextEdit('cuentaingreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CuentaIngreso', 'CuentaIngreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for CuentaIngreso field
            //
            $editor = new TextEdit('cuentaingreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CuentaIngreso', 'CuentaIngreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('NombreCuenta_handler');
            
            /* <inline edit column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Facturas_idFacturas field
            //
            $column = new TextViewColumn('Facturas_idFacturas', 'Facturas IdFacturas', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for Facturas_idFacturas field
            //
            $editor = new TextEdit('facturas_idfacturas_edit');
            $editColumn = new CustomEditColumn('Facturas IdFacturas', 'Facturas_idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Facturas_idFacturas field
            //
            $editor = new TextEdit('facturas_idfacturas_edit');
            $editColumn = new CustomEditColumn('Facturas IdFacturas', 'Facturas_idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CerradoDiario field
            //
            $column = new TextViewColumn('CerradoDiario', 'CerradoDiario', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for CerradoDiario field
            //
            $editor = new TextEdit('cerradodiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CerradoDiario', 'CerradoDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for CerradoDiario field
            //
            $editor = new TextEdit('cerradodiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CerradoDiario', 'CerradoDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FechaCierreDiario field
            //
            $column = new TextViewColumn('FechaCierreDiario', 'FechaCierreDiario', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for FechaCierreDiario field
            //
            $editor = new TextEdit('fechacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('FechaCierreDiario', 'FechaCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for FechaCierreDiario field
            //
            $editor = new TextEdit('fechacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('FechaCierreDiario', 'FechaCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for HoraCierreDiario field
            //
            $column = new TextViewColumn('HoraCierreDiario', 'HoraCierreDiario', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for HoraCierreDiario field
            //
            $editor = new TextEdit('horacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('HoraCierreDiario', 'HoraCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for HoraCierreDiario field
            //
            $editor = new TextEdit('horacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('HoraCierreDiario', 'HoraCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetShowSetToNullCheckBox(false);
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'facturas_abonosDetailViewGrid0facturas');
            $result->SetAllowDeleteSelected(false);
            $result->SetUseFixedHeader(false);
            
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddFieldColumns($result);
            //
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(false);
            
            /* <inline edit column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'NombreCuenta_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
    }
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class facturas_abonosDetailEdit0facturasPage extends DetailPageEdit
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`facturas_abonos`');
            $field = new IntegerField('idFacturasAbonos', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Fecha');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Monto');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('CuentaIngreso');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('NombreCuenta');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Usuarios_idUsuarios');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Facturas_idFacturas');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('CerradoDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('FechaCierreDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('HoraCierreDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            return null;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl(Grid $grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('facturas_abonosDetailEdit0facturasssearch', $this->dataset,
                array('idFacturasAbonos', 'Fecha', 'Monto', 'CuentaIngreso', 'NombreCuenta', 'Usuarios_idUsuarios', 'Facturas_idFacturas', 'CerradoDiario', 'FechaCierreDiario', 'HoraCierreDiario'),
                array($this->RenderText('IdFacturasAbonos'), $this->RenderText('Fecha'), $this->RenderText('Monto'), $this->RenderText('CuentaIngreso'), $this->RenderText('NombreCuenta'), $this->RenderText('Usuarios IdUsuarios'), $this->RenderText('Facturas IdFacturas'), $this->RenderText('CerradoDiario'), $this->RenderText('FechaCierreDiario'), $this->RenderText('HoraCierreDiario')),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl(Grid $grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('facturas_abonosDetailEdit0facturasasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('idFacturasAbonos', $this->RenderText('IdFacturasAbonos')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Fecha', $this->RenderText('Fecha')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Monto', $this->RenderText('Monto')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('CuentaIngreso', $this->RenderText('CuentaIngreso')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('NombreCuenta', $this->RenderText('NombreCuenta')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Usuarios_idUsuarios', $this->RenderText('Usuarios IdUsuarios')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Facturas_idFacturas', $this->RenderText('Facturas IdFacturas')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('CerradoDiario', $this->RenderText('CerradoDiario')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FechaCierreDiario', $this->RenderText('FechaCierreDiario')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HoraCierreDiario', $this->RenderText('HoraCierreDiario')));
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/edit_action.png');
                $column->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            //
            // View column for idFacturasAbonos field
            //
            $column = new TextViewColumn('idFacturasAbonos', 'IdFacturasAbonos', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Monto field
            //
            $column = new TextViewColumn('Monto', 'Monto', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Monto field
            //
            $editor = new TextEdit('monto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Monto', 'Monto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Monto field
            //
            $editor = new TextEdit('monto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Monto', 'Monto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CuentaIngreso field
            //
            $column = new TextViewColumn('CuentaIngreso', 'CuentaIngreso', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for CuentaIngreso field
            //
            $editor = new TextEdit('cuentaingreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CuentaIngreso', 'CuentaIngreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for CuentaIngreso field
            //
            $editor = new TextEdit('cuentaingreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CuentaIngreso', 'CuentaIngreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('NombreCuenta_handler');
            
            /* <inline edit column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Facturas_idFacturas field
            //
            $column = new TextViewColumn('Facturas_idFacturas', 'Facturas IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Facturas_idFacturas field
            //
            $editor = new TextEdit('facturas_idfacturas_edit');
            $editColumn = new CustomEditColumn('Facturas IdFacturas', 'Facturas_idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Facturas_idFacturas field
            //
            $editor = new TextEdit('facturas_idfacturas_edit');
            $editColumn = new CustomEditColumn('Facturas IdFacturas', 'Facturas_idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CerradoDiario field
            //
            $column = new TextViewColumn('CerradoDiario', 'CerradoDiario', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for CerradoDiario field
            //
            $editor = new TextEdit('cerradodiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CerradoDiario', 'CerradoDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for CerradoDiario field
            //
            $editor = new TextEdit('cerradodiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CerradoDiario', 'CerradoDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FechaCierreDiario field
            //
            $column = new TextViewColumn('FechaCierreDiario', 'FechaCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for FechaCierreDiario field
            //
            $editor = new TextEdit('fechacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('FechaCierreDiario', 'FechaCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for FechaCierreDiario field
            //
            $editor = new TextEdit('fechacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('FechaCierreDiario', 'FechaCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for HoraCierreDiario field
            //
            $column = new TextViewColumn('HoraCierreDiario', 'HoraCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for HoraCierreDiario field
            //
            $editor = new TextEdit('horacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('HoraCierreDiario', 'HoraCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for HoraCierreDiario field
            //
            $editor = new TextEdit('horacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('HoraCierreDiario', 'HoraCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idFacturasAbonos field
            //
            $column = new TextViewColumn('idFacturasAbonos', 'IdFacturasAbonos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Monto field
            //
            $column = new TextViewColumn('Monto', 'Monto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CuentaIngreso field
            //
            $column = new TextViewColumn('CuentaIngreso', 'CuentaIngreso', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('NombreCuenta_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Facturas_idFacturas field
            //
            $column = new TextViewColumn('Facturas_idFacturas', 'Facturas IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CerradoDiario field
            //
            $column = new TextViewColumn('CerradoDiario', 'CerradoDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FechaCierreDiario field
            //
            $column = new TextViewColumn('FechaCierreDiario', 'FechaCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for HoraCierreDiario field
            //
            $column = new TextViewColumn('HoraCierreDiario', 'HoraCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Monto field
            //
            $editor = new TextEdit('monto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Monto', 'Monto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CuentaIngreso field
            //
            $editor = new TextEdit('cuentaingreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CuentaIngreso', 'CuentaIngreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Facturas_idFacturas field
            //
            $editor = new TextEdit('facturas_idfacturas_edit');
            $editColumn = new CustomEditColumn('Facturas IdFacturas', 'Facturas_idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CerradoDiario field
            //
            $editor = new TextEdit('cerradodiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CerradoDiario', 'CerradoDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for FechaCierreDiario field
            //
            $editor = new TextEdit('fechacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('FechaCierreDiario', 'FechaCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for HoraCierreDiario field
            //
            $editor = new TextEdit('horacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('HoraCierreDiario', 'HoraCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Monto field
            //
            $editor = new TextEdit('monto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Monto', 'Monto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CuentaIngreso field
            //
            $editor = new TextEdit('cuentaingreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CuentaIngreso', 'CuentaIngreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Facturas_idFacturas field
            //
            $editor = new TextEdit('facturas_idfacturas_edit');
            $editColumn = new CustomEditColumn('Facturas IdFacturas', 'Facturas_idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CerradoDiario field
            //
            $editor = new TextEdit('cerradodiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CerradoDiario', 'CerradoDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for FechaCierreDiario field
            //
            $editor = new TextEdit('fechacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('FechaCierreDiario', 'FechaCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for HoraCierreDiario field
            //
            $editor = new TextEdit('horacierrediario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('HoraCierreDiario', 'HoraCierreDiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(true);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for idFacturasAbonos field
            //
            $column = new TextViewColumn('idFacturasAbonos', 'IdFacturasAbonos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Monto field
            //
            $column = new TextViewColumn('Monto', 'Monto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CuentaIngreso field
            //
            $column = new TextViewColumn('CuentaIngreso', 'CuentaIngreso', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Facturas_idFacturas field
            //
            $column = new TextViewColumn('Facturas_idFacturas', 'Facturas IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CerradoDiario field
            //
            $column = new TextViewColumn('CerradoDiario', 'CerradoDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for FechaCierreDiario field
            //
            $column = new TextViewColumn('FechaCierreDiario', 'FechaCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for HoraCierreDiario field
            //
            $column = new TextViewColumn('HoraCierreDiario', 'HoraCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idFacturasAbonos field
            //
            $column = new TextViewColumn('idFacturasAbonos', 'IdFacturasAbonos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Monto field
            //
            $column = new TextViewColumn('Monto', 'Monto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for CuentaIngreso field
            //
            $column = new TextViewColumn('CuentaIngreso', 'CuentaIngreso', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Facturas_idFacturas field
            //
            $column = new TextViewColumn('Facturas_idFacturas', 'Facturas IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for CerradoDiario field
            //
            $column = new TextViewColumn('CerradoDiario', 'CerradoDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for FechaCierreDiario field
            //
            $column = new TextViewColumn('FechaCierreDiario', 'FechaCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for HoraCierreDiario field
            //
            $column = new TextViewColumn('HoraCierreDiario', 'HoraCierreDiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetShowSetToNullCheckBox(false);
    	$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function ShowEditButtonHandler(&$show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasEditGrant($this->GetDataset());
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'facturas_abonosDetailEditGrid0facturas');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
                $result->SetAllowDeleteSelected(false);
            else
                $result->SetAllowDeleteSelected(false);
            ApplyCommonPageSettings($this, $result);
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetHidePageListByDefault(false);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetFilterRowAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            //
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for NombreCuenta field
            //
            $editor = new TextAreaEdit('nombrecuenta_edit', 50, 8);
            $editColumn = new CustomEditColumn('NombreCuenta', 'NombreCuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'NombreCuenta_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for NombreCuenta field
            //
            $column = new TextViewColumn('NombreCuenta', 'NombreCuenta', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'NombreCuenta_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        public function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class facturasPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`facturas`');
            $field = new IntegerField('idFacturas', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Fecha');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('OCompra');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('OSalida');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('FormaPago');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Subtotal');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('IVA');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Descuentos');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Total');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('SaldoFact');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Cotizaciones_idCotizaciones');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('EmpresaPro_idEmpresaPro');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Usuarios_idUsuarios');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Clientes_idClientes');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('TotalCostos');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('CerradoDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('FechaCierreDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('HoraCierreDiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        public function GetPageList()
        {
            $currentPageCaption = $this->GetShortCaption();
            $result = new PageList($this);
            if (GetCurrentUserGrantForDataSource('activos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Activos'), 'activos.php', $this->RenderText('Activos'), $currentPageCaption == $this->RenderText('Activos')));
            if (GetCurrentUserGrantForDataSource('act_movimientos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Act Movimientos'), 'act_movimientos.php', $this->RenderText('Act Movimientos'), $currentPageCaption == $this->RenderText('Act Movimientos')));
            if (GetCurrentUserGrantForDataSource('act_ordenes')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Act Ordenes'), 'act_ordenes.php', $this->RenderText('Act Ordenes'), $currentPageCaption == $this->RenderText('Act Ordenes')));
            if (GetCurrentUserGrantForDataSource('bodega')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Bodega'), 'bodega.php', $this->RenderText('Bodega'), $currentPageCaption == $this->RenderText('Bodega')));
            if (GetCurrentUserGrantForDataSource('cartera')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cartera'), 'cartera.php', $this->RenderText('Cartera'), $currentPageCaption == $this->RenderText('Cartera')));
            if (GetCurrentUserGrantForDataSource('ciuu')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Ciuu'), 'ciuu.php', $this->RenderText('Ciuu'), $currentPageCaption == $this->RenderText('Ciuu')));
            if (GetCurrentUserGrantForDataSource('clasecuenta')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Clasecuenta'), 'clasecuenta.php', $this->RenderText('Clasecuenta'), $currentPageCaption == $this->RenderText('Clasecuenta')));
            if (GetCurrentUserGrantForDataSource('clientes')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Clientes'), 'clientes.php', $this->RenderText('Clientes'), $currentPageCaption == $this->RenderText('Clientes')));
            if (GetCurrentUserGrantForDataSource('cod_departamentos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cod Departamentos'), 'cod_departamentos.php', $this->RenderText('Cod Departamentos'), $currentPageCaption == $this->RenderText('Cod Departamentos')));
            if (GetCurrentUserGrantForDataSource('cod_documentos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cod Documentos'), 'cod_documentos.php', $this->RenderText('Cod Documentos'), $currentPageCaption == $this->RenderText('Cod Documentos')));
            if (GetCurrentUserGrantForDataSource('cod_municipios_dptos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cod Municipios Dptos'), 'cod_municipios_dptos.php', $this->RenderText('Cod Municipios Dptos'), $currentPageCaption == $this->RenderText('Cod Municipios Dptos')));
            if (GetCurrentUserGrantForDataSource('cod_paises')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cod Paises'), 'cod_paises.php', $this->RenderText('Cod Paises'), $currentPageCaption == $this->RenderText('Cod Paises')));
            if (GetCurrentUserGrantForDataSource('col_registrohoras')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Col Registrohoras'), 'col_registrohoras.php', $this->RenderText('Col Registrohoras'), $currentPageCaption == $this->RenderText('Col Registrohoras')));
            if (GetCurrentUserGrantForDataSource('colaboradores')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Colaboradores'), 'colaboradoresact.php', $this->RenderText('Colaboradores'), $currentPageCaption == $this->RenderText('Colaboradores')));
            if (GetCurrentUserGrantForDataSource('comisiones')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Comisiones'), 'comisiones.php', $this->RenderText('Comisiones'), $currentPageCaption == $this->RenderText('Comisiones')));
            if (GetCurrentUserGrantForDataSource('comisionesporventas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Comisionesporventas'), 'comisionesporventas.php', $this->RenderText('Comisionesporventas'), $currentPageCaption == $this->RenderText('Comisionesporventas')));
            if (GetCurrentUserGrantForDataSource('compras')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Compras'), 'compras.php', $this->RenderText('Compras'), $currentPageCaption == $this->RenderText('Compras')));
            if (GetCurrentUserGrantForDataSource('cotizaciones')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cotizaciones'), 'cotizaciones.php', $this->RenderText('Cotizaciones'), $currentPageCaption == $this->RenderText('Cotizaciones')));
            if (GetCurrentUserGrantForDataSource('cuentas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cuentas'), 'cuentas.php', $this->RenderText('Cuentas'), $currentPageCaption == $this->RenderText('Cuentas')));
            if (GetCurrentUserGrantForDataSource('cuentasfrecuentes')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Cuentasfrecuentes'), 'cuentasfrecuentes.php', $this->RenderText('Cuentasfrecuentes'), $currentPageCaption == $this->RenderText('Cuentasfrecuentes')));
            if (GetCurrentUserGrantForDataSource('devolucionesventas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Devolucionesventas'), 'devolucionesventas.php', $this->RenderText('Devolucionesventas'), $currentPageCaption == $this->RenderText('Devolucionesventas')));
            if (GetCurrentUserGrantForDataSource('egresos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Egresos'), 'egresos.php', $this->RenderText('Egresos'), $currentPageCaption == $this->RenderText('Egresos')));
            if (GetCurrentUserGrantForDataSource('empresapro')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Empresapro'), 'empresapro.php', $this->RenderText('Empresapro'), $currentPageCaption == $this->RenderText('Empresapro')));
            if (GetCurrentUserGrantForDataSource('facturas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Facturas'), 'facturas.php', $this->RenderText('Facturas'), $currentPageCaption == $this->RenderText('Facturas')));
            if (GetCurrentUserGrantForDataSource('facturas_abonos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Facturas Abonos'), 'facturas_abonos.php', $this->RenderText('Facturas Abonos'), $currentPageCaption == $this->RenderText('Facturas Abonos')));
            if (GetCurrentUserGrantForDataSource('facturas_autoretenciones')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Facturas Autoretenciones'), 'facturas_autoretenciones.php', $this->RenderText('Facturas Autoretenciones'), $currentPageCaption == $this->RenderText('Facturas Autoretenciones')));
            if (GetCurrentUserGrantForDataSource('facturas_reten_aplicadas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Facturas Reten Aplicadas'), 'facturas_reten_aplicadas.php', $this->RenderText('Facturas Reten Aplicadas'), $currentPageCaption == $this->RenderText('Facturas Reten Aplicadas')));
            if (GetCurrentUserGrantForDataSource('fechas_descuentos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Fechas Descuentos'), 'fechas_descuentos.php', $this->RenderText('Fechas Descuentos'), $currentPageCaption == $this->RenderText('Fechas Descuentos')));
            if (GetCurrentUserGrantForDataSource('gupocuentas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Gupocuentas'), 'gupocuentas.php', $this->RenderText('Gupocuentas'), $currentPageCaption == $this->RenderText('Gupocuentas')));
            if (GetCurrentUserGrantForDataSource('impret')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Impret'), 'impret.php', $this->RenderText('Impret'), $currentPageCaption == $this->RenderText('Impret')));
            if (GetCurrentUserGrantForDataSource('ingresos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Ingresos'), 'ingresos.php', $this->RenderText('Ingresos'), $currentPageCaption == $this->RenderText('Ingresos')));
            if (GetCurrentUserGrantForDataSource('ingresosvarios')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Ingresosvarios'), 'ingresosvarios.php', $this->RenderText('Ingresosvarios'), $currentPageCaption == $this->RenderText('Ingresosvarios')));
            if (GetCurrentUserGrantForDataSource('kardexmercancias')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Kardexmercancias'), 'kardexmercancias.php', $this->RenderText('Kardexmercancias'), $currentPageCaption == $this->RenderText('Kardexmercancias')));
            if (GetCurrentUserGrantForDataSource('librodiario')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Librodiario'), 'librodiario.php', $this->RenderText('Librodiario'), $currentPageCaption == $this->RenderText('Librodiario')));
            if (GetCurrentUserGrantForDataSource('libromayorbalances')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Libromayorbalances'), 'libromayorbalances.php', $this->RenderText('Libromayorbalances'), $currentPageCaption == $this->RenderText('Libromayorbalances')));
            if (GetCurrentUserGrantForDataSource('prod_bajas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Bajas'), 'prod_bajas.php', $this->RenderText('Prod Bajas'), $currentPageCaption == $this->RenderText('Prod Bajas')));
            if (GetCurrentUserGrantForDataSource('prod_codbarras')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Codbarras'), 'prod_codbarras.php', $this->RenderText('Prod Codbarras'), $currentPageCaption == $this->RenderText('Prod Codbarras')));
            if (GetCurrentUserGrantForDataSource('prod_departamentos')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Departamentos'), 'prod_departamentos.php', $this->RenderText('Prod Departamentos'), $currentPageCaption == $this->RenderText('Prod Departamentos')));
            if (GetCurrentUserGrantForDataSource('prod_sub1')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Sub1'), 'prod_sub1.php', $this->RenderText('Prod Sub1'), $currentPageCaption == $this->RenderText('Prod Sub1')));
            if (GetCurrentUserGrantForDataSource('prod_sub2')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Sub2'), 'prod_sub2.php', $this->RenderText('Prod Sub2'), $currentPageCaption == $this->RenderText('Prod Sub2')));
            if (GetCurrentUserGrantForDataSource('prod_sub3')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Sub3'), 'prod_sub3.php', $this->RenderText('Prod Sub3'), $currentPageCaption == $this->RenderText('Prod Sub3')));
            if (GetCurrentUserGrantForDataSource('prod_sub4')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Sub4'), 'prod_sub4.php', $this->RenderText('Prod Sub4'), $currentPageCaption == $this->RenderText('Prod Sub4')));
            if (GetCurrentUserGrantForDataSource('prod_sub5')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Sub5'), 'prod_sub5.php', $this->RenderText('Prod Sub5'), $currentPageCaption == $this->RenderText('Prod Sub5')));
            if (GetCurrentUserGrantForDataSource('prod_sub6')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Prod Sub6'), 'prod_sub6.php', $this->RenderText('Prod Sub6'), $currentPageCaption == $this->RenderText('Prod Sub6')));
            if (GetCurrentUserGrantForDataSource('productosventa')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Productosventa'), 'productosventa.php', $this->RenderText('Productosventa'), $currentPageCaption == $this->RenderText('Productosventa')));
            if (GetCurrentUserGrantForDataSource('proveedores')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Proveedores'), 'proveedores.php', $this->RenderText('Proveedores'), $currentPageCaption == $this->RenderText('Proveedores')));
            if (GetCurrentUserGrantForDataSource('relacioncompras')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Relacioncompras'), 'relacioncompras.php', $this->RenderText('Relacioncompras'), $currentPageCaption == $this->RenderText('Relacioncompras')));
            if (GetCurrentUserGrantForDataSource('remisiones')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Remisiones'), 'remisiones.php', $this->RenderText('Remisiones'), $currentPageCaption == $this->RenderText('Remisiones')));
            if (GetCurrentUserGrantForDataSource('servicios')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Servicios'), 'servicios.php', $this->RenderText('Servicios'), $currentPageCaption == $this->RenderText('Servicios')));
            if (GetCurrentUserGrantForDataSource('subcuentas')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Subcuentas'), 'subcuentas.php', $this->RenderText('Subcuentas'), $currentPageCaption == $this->RenderText('Subcuentas')));
            if (GetCurrentUserGrantForDataSource('usuarios')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Usuarios'), 'usuarios.php', $this->RenderText('Usuarios'), $currentPageCaption == $this->RenderText('Usuarios')));
            if (GetCurrentUserGrantForDataSource('usuarios_ip')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Usuarios Ip'), 'usuarios_ip.php', $this->RenderText('Usuarios Ip'), $currentPageCaption == $this->RenderText('Usuarios Ip')));
            if (GetCurrentUserGrantForDataSource('usuarios_keys')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Usuarios Keys'), 'usuarios_keys.php', $this->RenderText('Usuarios Keys'), $currentPageCaption == $this->RenderText('Usuarios Keys')));
            if (GetCurrentUserGrantForDataSource('ventas_devoluciones')->HasViewGrant())
                $result->AddPage(new PageLink($this->RenderText('Ventas Devoluciones'), 'ventas_devoluciones.php', $this->RenderText('Ventas Devoluciones'), $currentPageCaption == $this->RenderText('Ventas Devoluciones')));
            
            if ( HasAdminPage() && GetApplication()->HasAdminGrantForCurrentUser() )
              $result->AddPage(new PageLink($this->GetLocalizerCaptions()->GetMessageString('AdminPage'), 'phpgen_admin.php', $this->GetLocalizerCaptions()->GetMessageString('AdminPage'), false, true));
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function CreateGridSearchControl(Grid $grid)
        {
            $grid->UseFilter = true;
            $grid->SearchControl = new SimpleSearch('facturasssearch', $this->dataset,
                array('idFacturas', 'Fecha', 'OCompra', 'OSalida', 'FormaPago', 'Subtotal', 'IVA', 'Descuentos', 'Total', 'SaldoFact', 'TotalCostos', 'Cotizaciones_idCotizaciones', 'EmpresaPro_idEmpresaPro', 'Usuarios_idUsuarios', 'Clientes_idClientes'),
                array($this->RenderText('IdFacturas'), $this->RenderText('Fecha'), $this->RenderText('OCompra'), $this->RenderText('OSalida'), $this->RenderText('FormaPago'), $this->RenderText('Subtotal'), $this->RenderText('IVA'), $this->RenderText('Descuentos'), $this->RenderText('Total'), $this->RenderText('SaldoFact'), $this->RenderText('TotalCostos'), $this->RenderText('Cotizaciones IdCotizaciones'), $this->RenderText('EmpresaPro IdEmpresaPro'), $this->RenderText('Usuarios IdUsuarios'), $this->RenderText('Clientes IdClientes')),
                array(
                    '=' => $this->GetLocalizerCaptions()->GetMessageString('equals'),
                    '<>' => $this->GetLocalizerCaptions()->GetMessageString('doesNotEquals'),
                    '<' => $this->GetLocalizerCaptions()->GetMessageString('isLessThan'),
                    '<=' => $this->GetLocalizerCaptions()->GetMessageString('isLessThanOrEqualsTo'),
                    '>' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThan'),
                    '>=' => $this->GetLocalizerCaptions()->GetMessageString('isGreaterThanOrEqualsTo'),
                    'ILIKE' => $this->GetLocalizerCaptions()->GetMessageString('Like'),
                    'STARTS' => $this->GetLocalizerCaptions()->GetMessageString('StartsWith'),
                    'ENDS' => $this->GetLocalizerCaptions()->GetMessageString('EndsWith'),
                    'CONTAINS' => $this->GetLocalizerCaptions()->GetMessageString('Contains')
                    ), $this->GetLocalizerCaptions(), $this, 'CONTAINS'
                );
        }
    
        protected function CreateGridAdvancedSearchControl(Grid $grid)
        {
            $this->AdvancedSearchControl = new AdvancedSearchControl('facturasasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('idFacturas', $this->RenderText('IdFacturas')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Fecha', $this->RenderText('Fecha')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('OCompra', $this->RenderText('OCompra')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('OSalida', $this->RenderText('OSalida')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FormaPago', $this->RenderText('FormaPago')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Subtotal', $this->RenderText('Subtotal')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('IVA', $this->RenderText('IVA')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Descuentos', $this->RenderText('Descuentos')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Total', $this->RenderText('Total')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SaldoFact', $this->RenderText('SaldoFact')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('TotalCostos', $this->RenderText('TotalCostos')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Cotizaciones_idCotizaciones', $this->RenderText('Cotizaciones IdCotizaciones')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('EmpresaPro_idEmpresaPro', $this->RenderText('EmpresaPro IdEmpresaPro')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Usuarios_idUsuarios', $this->RenderText('Usuarios IdUsuarios')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Clientes_idClientes', $this->RenderText('Clientes IdClientes')));
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actionsBandName = 'actions';
            $grid->AddBandToBegin($actionsBandName, $this->GetLocalizerCaptions()->GetMessageString('Actions'), true);
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/view_action.png');
            }
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/edit_action.png');
                $column->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $column = new RowOperationByLinkColumn($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset);
                $grid->AddViewColumn($column, $actionsBandName);
                $column->SetImagePath('images/copy_action.png');
            }
        }
    
        protected function AddFieldColumns(Grid $grid)
        {
            if (GetCurrentUserGrantForDataSource('facturas.facturas_abonos')->HasViewGrant())
            {
              //
            // View column for facturas_abonosDetailView0facturas detail
            //
            $column = new DetailColumn(array('idFacturas'), 'detail0facturas', 'facturas_abonosDetailEdit0facturas_handler', 'facturas_abonosDetailView0facturas_handler', $this->dataset, 'Facturas Abonos', $this->RenderText('Facturas Abonos'));
              $grid->AddViewColumn($column);
            }
            
            //
            // View column for idFacturas field
            //
            $column = new TextViewColumn('idFacturas', 'IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for idFacturas field
            //
            $editor = new TextEdit('idfacturas_edit');
            $editColumn = new CustomEditColumn('IdFacturas', 'idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for idFacturas field
            //
            $editor = new TextEdit('idfacturas_edit');
            $editColumn = new CustomEditColumn('IdFacturas', 'idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OCompra field
            //
            $column = new TextViewColumn('OCompra', 'OCompra', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for OCompra field
            //
            $editor = new TextEdit('ocompra_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OCompra', 'OCompra', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for OCompra field
            //
            $editor = new TextEdit('ocompra_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OCompra', 'OCompra', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for OSalida field
            //
            $column = new TextViewColumn('OSalida', 'OSalida', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for OSalida field
            //
            $editor = new TextEdit('osalida_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OSalida', 'OSalida', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for OSalida field
            //
            $editor = new TextEdit('osalida_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OSalida', 'OSalida', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FormaPago field
            //
            $column = new TextViewColumn('FormaPago', 'FormaPago', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for FormaPago field
            //
            $editor = new TextEdit('formapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FormaPago', 'FormaPago', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for FormaPago field
            //
            $editor = new TextEdit('formapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FormaPago', 'FormaPago', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Subtotal field
            //
            $column = new TextViewColumn('Subtotal', 'Subtotal', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Subtotal field
            //
            $editor = new TextEdit('subtotal_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Subtotal', 'Subtotal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Subtotal field
            //
            $editor = new TextEdit('subtotal_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Subtotal', 'Subtotal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Descuentos field
            //
            $column = new TextViewColumn('Descuentos', 'Descuentos', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Descuentos field
            //
            $editor = new TextEdit('descuentos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Descuentos', 'Descuentos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Descuentos field
            //
            $editor = new TextEdit('descuentos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Descuentos', 'Descuentos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Total field
            //
            $column = new TextViewColumn('Total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Total field
            //
            $editor = new TextEdit('total_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Total', 'Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Total field
            //
            $editor = new TextEdit('total_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Total', 'Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SaldoFact field
            //
            $column = new TextViewColumn('SaldoFact', 'SaldoFact', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for SaldoFact field
            //
            $editor = new TextEdit('saldofact_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SaldoFact', 'SaldoFact', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for SaldoFact field
            //
            $editor = new TextEdit('saldofact_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SaldoFact', 'SaldoFact', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TotalCostos field
            //
            $column = new TextViewColumn('TotalCostos', 'TotalCostos', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for TotalCostos field
            //
            $editor = new TextEdit('totalcostos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TotalCostos', 'TotalCostos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for TotalCostos field
            //
            $editor = new TextEdit('totalcostos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TotalCostos', 'TotalCostos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Cotizaciones_idCotizaciones field
            //
            $column = new TextViewColumn('Cotizaciones_idCotizaciones', 'Cotizaciones IdCotizaciones', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Cotizaciones_idCotizaciones field
            //
            $editor = new TextEdit('cotizaciones_idcotizaciones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cotizaciones IdCotizaciones', 'Cotizaciones_idCotizaciones', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Cotizaciones_idCotizaciones field
            //
            $editor = new TextEdit('cotizaciones_idcotizaciones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cotizaciones IdCotizaciones', 'Cotizaciones_idCotizaciones', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for EmpresaPro_idEmpresaPro field
            //
            $column = new TextViewColumn('EmpresaPro_idEmpresaPro', 'EmpresaPro IdEmpresaPro', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for EmpresaPro_idEmpresaPro field
            //
            $editor = new TextEdit('empresapro_idempresapro_edit');
            $editColumn = new CustomEditColumn('EmpresaPro IdEmpresaPro', 'EmpresaPro_idEmpresaPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for EmpresaPro_idEmpresaPro field
            //
            $editor = new TextEdit('empresapro_idempresapro_edit');
            $editColumn = new CustomEditColumn('EmpresaPro IdEmpresaPro', 'EmpresaPro_idEmpresaPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Clientes_idClientes field
            //
            $column = new TextViewColumn('Clientes_idClientes', 'Clientes IdClientes', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Clientes_idClientes field
            //
            $editor = new TextEdit('clientes_idclientes_edit');
            $editColumn = new CustomEditColumn('Clientes IdClientes', 'Clientes_idClientes', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Clientes_idClientes field
            //
            $editor = new TextEdit('clientes_idclientes_edit');
            $editColumn = new CustomEditColumn('Clientes IdClientes', 'Clientes_idClientes', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idFacturas field
            //
            $column = new TextViewColumn('idFacturas', 'IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for OCompra field
            //
            $column = new TextViewColumn('OCompra', 'OCompra', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for OSalida field
            //
            $column = new TextViewColumn('OSalida', 'OSalida', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FormaPago field
            //
            $column = new TextViewColumn('FormaPago', 'FormaPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Subtotal field
            //
            $column = new TextViewColumn('Subtotal', 'Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Descuentos field
            //
            $column = new TextViewColumn('Descuentos', 'Descuentos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Total field
            //
            $column = new TextViewColumn('Total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SaldoFact field
            //
            $column = new TextViewColumn('SaldoFact', 'SaldoFact', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for TotalCostos field
            //
            $column = new TextViewColumn('TotalCostos', 'TotalCostos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Cotizaciones_idCotizaciones field
            //
            $column = new TextViewColumn('Cotizaciones_idCotizaciones', 'Cotizaciones IdCotizaciones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for EmpresaPro_idEmpresaPro field
            //
            $column = new TextViewColumn('EmpresaPro_idEmpresaPro', 'EmpresaPro IdEmpresaPro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Clientes_idClientes field
            //
            $column = new TextViewColumn('Clientes_idClientes', 'Clientes IdClientes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idFacturas field
            //
            $editor = new TextEdit('idfacturas_edit');
            $editColumn = new CustomEditColumn('IdFacturas', 'idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for OCompra field
            //
            $editor = new TextEdit('ocompra_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OCompra', 'OCompra', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for OSalida field
            //
            $editor = new TextEdit('osalida_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OSalida', 'OSalida', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for FormaPago field
            //
            $editor = new TextEdit('formapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FormaPago', 'FormaPago', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Subtotal field
            //
            $editor = new TextEdit('subtotal_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Subtotal', 'Subtotal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Descuentos field
            //
            $editor = new TextEdit('descuentos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Descuentos', 'Descuentos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Total field
            //
            $editor = new TextEdit('total_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Total', 'Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SaldoFact field
            //
            $editor = new TextEdit('saldofact_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SaldoFact', 'SaldoFact', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for TotalCostos field
            //
            $editor = new TextEdit('totalcostos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TotalCostos', 'TotalCostos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Cotizaciones_idCotizaciones field
            //
            $editor = new TextEdit('cotizaciones_idcotizaciones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cotizaciones IdCotizaciones', 'Cotizaciones_idCotizaciones', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for EmpresaPro_idEmpresaPro field
            //
            $editor = new TextEdit('empresapro_idempresapro_edit');
            $editColumn = new CustomEditColumn('EmpresaPro IdEmpresaPro', 'EmpresaPro_idEmpresaPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Clientes_idClientes field
            //
            $editor = new TextEdit('clientes_idclientes_edit');
            $editColumn = new CustomEditColumn('Clientes IdClientes', 'Clientes_idClientes', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for idFacturas field
            //
            $editor = new TextEdit('idfacturas_edit');
            $editColumn = new CustomEditColumn('IdFacturas', 'idFacturas', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Fecha field
            //
            $editor = new TextEdit('fecha_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Fecha', 'Fecha', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for OCompra field
            //
            $editor = new TextEdit('ocompra_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OCompra', 'OCompra', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for OSalida field
            //
            $editor = new TextEdit('osalida_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('OSalida', 'OSalida', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for FormaPago field
            //
            $editor = new TextEdit('formapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FormaPago', 'FormaPago', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Subtotal field
            //
            $editor = new TextEdit('subtotal_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Subtotal', 'Subtotal', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Descuentos field
            //
            $editor = new TextEdit('descuentos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Descuentos', 'Descuentos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Total field
            //
            $editor = new TextEdit('total_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Total', 'Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SaldoFact field
            //
            $editor = new TextEdit('saldofact_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SaldoFact', 'SaldoFact', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for TotalCostos field
            //
            $editor = new TextEdit('totalcostos_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TotalCostos', 'TotalCostos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Cotizaciones_idCotizaciones field
            //
            $editor = new TextEdit('cotizaciones_idcotizaciones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cotizaciones IdCotizaciones', 'Cotizaciones_idCotizaciones', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for EmpresaPro_idEmpresaPro field
            //
            $editor = new TextEdit('empresapro_idempresapro_edit');
            $editColumn = new CustomEditColumn('EmpresaPro IdEmpresaPro', 'EmpresaPro_idEmpresaPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Usuarios_idUsuarios field
            //
            $editor = new TextEdit('usuarios_idusuarios_edit');
            $editColumn = new CustomEditColumn('Usuarios IdUsuarios', 'Usuarios_idUsuarios', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Clientes_idClientes field
            //
            $editor = new TextEdit('clientes_idclientes_edit');
            $editColumn = new CustomEditColumn('Clientes IdClientes', 'Clientes_idClientes', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $grid->SetShowAddButton(true);
                $grid->SetShowInlineAddButton(false);
            }
            else
            {
                $grid->SetShowInlineAddButton(false);
                $grid->SetShowAddButton(false);
            }
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for idFacturas field
            //
            $column = new TextViewColumn('idFacturas', 'IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for OCompra field
            //
            $column = new TextViewColumn('OCompra', 'OCompra', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for OSalida field
            //
            $column = new TextViewColumn('OSalida', 'OSalida', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for FormaPago field
            //
            $column = new TextViewColumn('FormaPago', 'FormaPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Subtotal field
            //
            $column = new TextViewColumn('Subtotal', 'Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Descuentos field
            //
            $column = new TextViewColumn('Descuentos', 'Descuentos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Total field
            //
            $column = new TextViewColumn('Total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SaldoFact field
            //
            $column = new TextViewColumn('SaldoFact', 'SaldoFact', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for TotalCostos field
            //
            $column = new TextViewColumn('TotalCostos', 'TotalCostos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Cotizaciones_idCotizaciones field
            //
            $column = new TextViewColumn('Cotizaciones_idCotizaciones', 'Cotizaciones IdCotizaciones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for EmpresaPro_idEmpresaPro field
            //
            $column = new TextViewColumn('EmpresaPro_idEmpresaPro', 'EmpresaPro IdEmpresaPro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Clientes_idClientes field
            //
            $column = new TextViewColumn('Clientes_idClientes', 'Clientes IdClientes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idFacturas field
            //
            $column = new TextViewColumn('idFacturas', 'IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for OCompra field
            //
            $column = new TextViewColumn('OCompra', 'OCompra', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for OSalida field
            //
            $column = new TextViewColumn('OSalida', 'OSalida', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for FormaPago field
            //
            $column = new TextViewColumn('FormaPago', 'FormaPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Subtotal field
            //
            $column = new TextViewColumn('Subtotal', 'Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Descuentos field
            //
            $column = new TextViewColumn('Descuentos', 'Descuentos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Total field
            //
            $column = new TextViewColumn('Total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SaldoFact field
            //
            $column = new TextViewColumn('SaldoFact', 'SaldoFact', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for TotalCostos field
            //
            $column = new TextViewColumn('TotalCostos', 'TotalCostos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Cotizaciones_idCotizaciones field
            //
            $column = new TextViewColumn('Cotizaciones_idCotizaciones', 'Cotizaciones IdCotizaciones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for EmpresaPro_idEmpresaPro field
            //
            $column = new TextViewColumn('EmpresaPro_idEmpresaPro', 'EmpresaPro IdEmpresaPro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Clientes_idClientes field
            //
            $column = new TextViewColumn('Clientes_idClientes', 'Clientes IdClientes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetShowSetToNullCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGridForfacturas_abonosDetailEdit0facturasGrid()
        {
            $result = new Grid($this, $this->dataset, 'MasterDetailRecordGridForfacturas_abonosDetailEdit0facturas');
            $result->SetAllowDeleteSelected(false);
            $result->SetShowFilterBuilder(false);
            $result->SetAdvancedSearchAvailable(false);
            $result->SetFilterRowAvailable(false);
            $result->SetShowUpdateLink(false);
            $result->SetEnabledInlineEditing(false);
            $result->SetName('master_grid');
            //
            // View column for idFacturas field
            //
            $column = new TextViewColumn('idFacturas', 'IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for OCompra field
            //
            $column = new TextViewColumn('OCompra', 'OCompra', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for OSalida field
            //
            $column = new TextViewColumn('OSalida', 'OSalida', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for FormaPago field
            //
            $column = new TextViewColumn('FormaPago', 'FormaPago', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Subtotal field
            //
            $column = new TextViewColumn('Subtotal', 'Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Descuentos field
            //
            $column = new TextViewColumn('Descuentos', 'Descuentos', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Total field
            //
            $column = new TextViewColumn('Total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for SaldoFact field
            //
            $column = new TextViewColumn('SaldoFact', 'SaldoFact', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for TotalCostos field
            //
            $column = new TextViewColumn('TotalCostos', 'TotalCostos', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Cotizaciones_idCotizaciones field
            //
            $column = new TextViewColumn('Cotizaciones_idCotizaciones', 'Cotizaciones IdCotizaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for EmpresaPro_idEmpresaPro field
            //
            $column = new TextViewColumn('EmpresaPro_idEmpresaPro', 'EmpresaPro IdEmpresaPro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for Clientes_idClientes field
            //
            $column = new TextViewColumn('Clientes_idClientes', 'Clientes IdClientes', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $result->AddViewColumn($column);
            
            //
            // View column for idFacturas field
            //
            $column = new TextViewColumn('idFacturas', 'IdFacturas', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for OCompra field
            //
            $column = new TextViewColumn('OCompra', 'OCompra', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for OSalida field
            //
            $column = new TextViewColumn('OSalida', 'OSalida', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for FormaPago field
            //
            $column = new TextViewColumn('FormaPago', 'FormaPago', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Subtotal field
            //
            $column = new TextViewColumn('Subtotal', 'Subtotal', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Descuentos field
            //
            $column = new TextViewColumn('Descuentos', 'Descuentos', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Total field
            //
            $column = new TextViewColumn('Total', 'Total', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for SaldoFact field
            //
            $column = new TextViewColumn('SaldoFact', 'SaldoFact', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for TotalCostos field
            //
            $column = new TextViewColumn('TotalCostos', 'TotalCostos', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Cotizaciones_idCotizaciones field
            //
            $column = new TextViewColumn('Cotizaciones_idCotizaciones', 'Cotizaciones IdCotizaciones', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for EmpresaPro_idEmpresaPro field
            //
            $column = new TextViewColumn('EmpresaPro_idEmpresaPro', 'EmpresaPro IdEmpresaPro', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Usuarios_idUsuarios field
            //
            $column = new TextViewColumn('Usuarios_idUsuarios', 'Usuarios IdUsuarios', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            //
            // View column for Clientes_idClientes field
            //
            $column = new TextViewColumn('Clientes_idClientes', 'Clientes IdClientes', $this->dataset);
            $column->SetOrderable(true);
            $result->AddPrintColumn($column);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        public function ShowEditButtonHandler(&$show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasEditGrant($this->GetDataset());
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'facturasGrid');
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            
            $result->SetShowLineNumbers(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->CreateGridSearchControl($result);
            $this->CreateGridAdvancedSearchControl($result);
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddOperationsColumns($result);
            $this->SetShowPageList(true);
            $this->SetHidePageListByDefault(false);
            $this->SetExportToExcelAvailable(true);
            $this->SetExportToWordAvailable(true);
            $this->SetExportToXmlAvailable(true);
            $this->SetExportToCsvAvailable(true);
            $this->SetExportToPdfAvailable(true);
            $this->SetPrinterFriendlyAvailable(true);
            $this->SetSimpleSearchAvailable(true);
            $this->SetAdvancedSearchAvailable(true);
            $this->SetFilterRowAvailable(true);
            $this->SetVisualEffectsEnabled(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
    
            //
            // Http Handlers
            //
            $pageView = new facturas_abonosDetailView0facturasPage($this, 'Facturas Abonos', 'Facturas Abonos', array('Facturas_idFacturas'), GetCurrentUserGrantForDataSource('facturas.facturas_abonos'), 'UTF-8', 20, 'facturas_abonosDetailEdit0facturas_handler');
            
            $pageView->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('facturas.facturas_abonos'));
            $handler = new PageHTTPHandler('facturas_abonosDetailView0facturas_handler', $pageView);
            GetApplication()->RegisterHTTPHandler($handler);
            $pageEdit = new facturas_abonosDetailEdit0facturasPage($this, array('Facturas_idFacturas'), array('idFacturas'), $this->GetForeingKeyFields(), $this->CreateMasterDetailRecordGridForfacturas_abonosDetailEdit0facturasGrid(), $this->dataset, GetCurrentUserGrantForDataSource('facturas.facturas_abonos'), 'UTF-8');
            
            $pageEdit->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('facturas.facturas_abonos'));
            $pageEdit->SetShortCaption('Facturas Abonos');
            $pageEdit->SetHeader(GetPagesHeader());
            $pageEdit->SetFooter(GetPagesFooter());
            $pageEdit->SetCaption('Facturas Abonos');
            $pageEdit->SetHttpHandlerName('facturas_abonosDetailEdit0facturas_handler');
            $handler = new PageHTTPHandler('facturas_abonosDetailEdit0facturas_handler', $pageEdit);
            GetApplication()->RegisterHTTPHandler($handler);
            return $result;
        }
        
        public function OpenAdvancedSearchByDefault()
        {
            return false;
        }
    
        protected function DoGetGridHeader()
        {
            return '';
        }
    }

    SetUpUserAuthorization(GetApplication());

    try
    {
        $Page = new facturasPage("facturas.php", "facturas", GetCurrentUserGrantForDataSource("facturas"), 'UTF-8');
        $Page->SetShortCaption('Facturas');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Facturas');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("facturas"));
        GetApplication()->SetEnableLessRunTimeCompile(GetEnableLessFilesRunTimeCompilation());
        GetApplication()->SetCanUserChangeOwnPassword(
            !function_exists('CanUserChangeOwnPassword') || CanUserChangeOwnPassword());
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e->getMessage());
    }
	
