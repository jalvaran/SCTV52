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
    
    
    
    class serviciosPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`servicios`');
            $field = new IntegerField('idServicios', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Referencia');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Nombre');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('PrecioVenta');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('PrecioEspecial');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('CostoUnitario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('IVA');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Departamento');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('ImagenRuta');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('CuentaPUC');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $this->dataset->AddLookupField('Departamento', 'prod_departamentos', new IntegerField('idDepartamentos', null, null, true), new StringField('Nombre', 'Departamento_Nombre', 'Departamento_Nombre_prod_departamentos'), 'Departamento_Nombre_prod_departamentos');
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
            $grid->SearchControl = new SimpleSearch('serviciosssearch', $this->dataset,
                array('idServicios', 'Referencia', 'Nombre', 'PrecioVenta', 'PrecioEspecial', 'CostoUnitario', 'IVA', 'Departamento_Nombre', 'ImagenRuta', 'CuentaPUC'),
                array($this->RenderText('IdServicios'), $this->RenderText('Referencia'), $this->RenderText('Nombre'), $this->RenderText('PrecioVenta'), $this->RenderText('PrecioEspecial'), $this->RenderText('CostoUnitario'), $this->RenderText('IVA'), $this->RenderText('Departamento'), $this->RenderText('ImagenRuta'), $this->RenderText('CuentaPUC')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('serviciosasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('idServicios', $this->RenderText('IdServicios')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Referencia', $this->RenderText('Referencia')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Nombre', $this->RenderText('Nombre')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('PrecioVenta', $this->RenderText('PrecioVenta')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('PrecioEspecial', $this->RenderText('PrecioEspecial')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('CostoUnitario', $this->RenderText('CostoUnitario')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('IVA', $this->RenderText('IVA')));
            
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`prod_departamentos`');
            $field = new IntegerField('idDepartamentos', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Nombre');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Tabla');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateLookupSearchInput('Departamento', $this->RenderText('Departamento'), $lookupDataset, 'idDepartamentos', 'Nombre', false));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('ImagenRuta', $this->RenderText('ImagenRuta')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('CuentaPUC', $this->RenderText('CuentaPUC')));
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
            // View column for idServicios field
            //
            $column = new TextViewColumn('idServicios', 'IdServicios', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Referencia field
            //
            $column = new TextViewColumn('Referencia', 'Referencia', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Referencia field
            //
            $editor = new TextEdit('referencia_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Referencia', 'Referencia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Referencia field
            //
            $editor = new TextEdit('referencia_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Referencia', 'Referencia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('Nombre_handler');
            
            /* <inline edit column> */
            //
            // Edit column for Nombre field
            //
            $editor = new TextAreaEdit('nombre_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Nombre field
            //
            $editor = new TextAreaEdit('nombre_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for PrecioVenta field
            //
            $column = new TextViewColumn('PrecioVenta', 'PrecioVenta', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for PrecioVenta field
            //
            $editor = new TextEdit('precioventa_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioVenta', 'PrecioVenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for PrecioVenta field
            //
            $editor = new TextEdit('precioventa_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioVenta', 'PrecioVenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for PrecioEspecial field
            //
            $column = new TextViewColumn('PrecioEspecial', 'PrecioEspecial', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for PrecioEspecial field
            //
            $editor = new TextEdit('precioespecial_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioEspecial', 'PrecioEspecial', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for PrecioEspecial field
            //
            $editor = new TextEdit('precioespecial_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioEspecial', 'PrecioEspecial', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CostoUnitario field
            //
            $column = new TextViewColumn('CostoUnitario', 'CostoUnitario', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for CostoUnitario field
            //
            $editor = new TextEdit('costounitario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CostoUnitario', 'CostoUnitario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for CostoUnitario field
            //
            $editor = new TextEdit('costounitario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CostoUnitario', 'CostoUnitario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Departamento_Nombre', 'Departamento', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Departamento field
            //
            $editor = new ComboBox('departamento_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`prod_departamentos`');
            $field = new IntegerField('idDepartamentos', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Nombre');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Tabla');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Nombre', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Departamento', 
                'Departamento', 
                $editor, 
                $this->dataset, 'idDepartamentos', 'Nombre', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Departamento field
            //
            $editor = new ComboBox('departamento_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`prod_departamentos`');
            $field = new IntegerField('idDepartamentos', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Nombre');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Tabla');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Nombre', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Departamento', 
                'Departamento', 
                $editor, 
                $this->dataset, 'idDepartamentos', 'Nombre', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ImagenRuta field
            //
            $column = new ExternalImageColumn('ImagenRuta', 'ImagenRuta', $this->dataset, '');
            $column->SetSourcePrefix('');
            $column->SetSourceSuffix('');
            
            /* <inline edit column> */
            //
            // Edit column for ImagenRuta field
            //
            $editor = new ImageUploader('imagenruta_edit');
            $editor->SetShowImage(true);
            $editColumn = new UploadFileToFolderColumn('ImagenRuta', 'ImagenRuta', $editor, $this->dataset, false, false, 'sevicios_img');
            $editColumn->OnCustomFileName->AddListener('ImagenRuta_GenerateFileName_inline_edit', $this);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $editColumn->SetGenerationImageThumbnails(
                'ImagenRuta',
                '',
                Delegate::CreateFromMethod($this, 'ImagenRuta_Thumbnail_GenerateFileName_inline_edit'),
                new ImageFitByHeightResizeFilter(200)
            );
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ImagenRuta field
            //
            $editor = new ImageUploader('imagenruta_edit');
            $editor->SetShowImage(true);
            $editColumn = new UploadFileToFolderColumn('ImagenRuta', 'ImagenRuta', $editor, $this->dataset, false, false, 'sevicios_img');
            $editColumn->OnCustomFileName->AddListener('ImagenRuta_GenerateFileName_inline_insert', $this);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $editColumn->SetGenerationImageThumbnails(
                'ImagenRuta',
                '',
                Delegate::CreateFromMethod($this, 'ImagenRuta_Thumbnail_GenerateFileName_inline_insert'),
                new ImageFitByHeightResizeFilter(200)
            );
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CuentaPUC field
            //
            $column = new TextViewColumn('CuentaPUC', 'CuentaPUC', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for CuentaPUC field
            //
            $editor = new TextEdit('cuentapuc_edit');
            $editColumn = new CustomEditColumn('CuentaPUC', 'CuentaPUC', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for CuentaPUC field
            //
            $editor = new TextEdit('cuentapuc_edit');
            $editColumn = new CustomEditColumn('CuentaPUC', 'CuentaPUC', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('4135'));
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
            // View column for idServicios field
            //
            $column = new TextViewColumn('idServicios', 'IdServicios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Referencia field
            //
            $column = new TextViewColumn('Referencia', 'Referencia', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('Nombre_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for PrecioVenta field
            //
            $column = new TextViewColumn('PrecioVenta', 'PrecioVenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for PrecioEspecial field
            //
            $column = new TextViewColumn('PrecioEspecial', 'PrecioEspecial', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CostoUnitario field
            //
            $column = new TextViewColumn('CostoUnitario', 'CostoUnitario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Departamento_Nombre', 'Departamento', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ImagenRuta field
            //
            $column = new ExternalImageColumn('ImagenRuta', 'ImagenRuta', $this->dataset, '');
            $column->SetSourcePrefix('');
            $column->SetSourceSuffix('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CuentaPUC field
            //
            $column = new TextViewColumn('CuentaPUC', 'CuentaPUC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Referencia field
            //
            $editor = new TextEdit('referencia_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Referencia', 'Referencia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nombre field
            //
            $editor = new TextAreaEdit('nombre_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for PrecioVenta field
            //
            $editor = new TextEdit('precioventa_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioVenta', 'PrecioVenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for PrecioEspecial field
            //
            $editor = new TextEdit('precioespecial_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioEspecial', 'PrecioEspecial', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CostoUnitario field
            //
            $editor = new TextEdit('costounitario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CostoUnitario', 'CostoUnitario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Departamento field
            //
            $editor = new ComboBox('departamento_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`prod_departamentos`');
            $field = new IntegerField('idDepartamentos', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Nombre');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Tabla');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Nombre', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Departamento', 
                'Departamento', 
                $editor, 
                $this->dataset, 'idDepartamentos', 'Nombre', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ImagenRuta field
            //
            $editor = new ImageUploader('imagenruta_edit');
            $editor->SetShowImage(true);
            $editColumn = new UploadFileToFolderColumn('ImagenRuta', 'ImagenRuta', $editor, $this->dataset, false, false, 'sevicios_img');
            $editColumn->OnCustomFileName->AddListener('ImagenRuta_GenerateFileName_edit', $this);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $editColumn->SetGenerationImageThumbnails(
                'ImagenRuta',
                '',
                Delegate::CreateFromMethod($this, 'ImagenRuta_Thumbnail_GenerateFileName_edit'),
                new ImageFitByHeightResizeFilter(200)
            );
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CuentaPUC field
            //
            $editor = new TextEdit('cuentapuc_edit');
            $editColumn = new CustomEditColumn('CuentaPUC', 'CuentaPUC', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Referencia field
            //
            $editor = new TextEdit('referencia_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Referencia', 'Referencia', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nombre field
            //
            $editor = new TextAreaEdit('nombre_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for PrecioVenta field
            //
            $editor = new TextEdit('precioventa_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioVenta', 'PrecioVenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for PrecioEspecial field
            //
            $editor = new TextEdit('precioespecial_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PrecioEspecial', 'PrecioEspecial', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CostoUnitario field
            //
            $editor = new TextEdit('costounitario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CostoUnitario', 'CostoUnitario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Departamento field
            //
            $editor = new ComboBox('departamento_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`prod_departamentos`');
            $field = new IntegerField('idDepartamentos', null, null, true);
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, true);
            $field = new StringField('Nombre');
            $lookupDataset->AddField($field, false);
            $field = new StringField('Tabla');
            $field->SetIsNotNull(true);
            $lookupDataset->AddField($field, false);
            $lookupDataset->SetOrderBy('Nombre', GetOrderTypeAsSQL(otAscending));
            $editColumn = new LookUpEditColumn(
                'Departamento', 
                'Departamento', 
                $editor, 
                $this->dataset, 'idDepartamentos', 'Nombre', $lookupDataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ImagenRuta field
            //
            $editor = new ImageUploader('imagenruta_edit');
            $editor->SetShowImage(true);
            $editColumn = new UploadFileToFolderColumn('ImagenRuta', 'ImagenRuta', $editor, $this->dataset, false, false, 'sevicios_img');
            $editColumn->OnCustomFileName->AddListener('ImagenRuta_GenerateFileName_insert', $this);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $editColumn->SetGenerationImageThumbnails(
                'ImagenRuta',
                '',
                Delegate::CreateFromMethod($this, 'ImagenRuta_Thumbnail_GenerateFileName_insert'),
                new ImageFitByHeightResizeFilter(200)
            );
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CuentaPUC field
            //
            $editor = new TextEdit('cuentapuc_edit');
            $editColumn = new CustomEditColumn('CuentaPUC', 'CuentaPUC', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue($this->RenderText('4135'));
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
            // View column for idServicios field
            //
            $column = new TextViewColumn('idServicios', 'IdServicios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Referencia field
            //
            $column = new TextViewColumn('Referencia', 'Referencia', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for PrecioVenta field
            //
            $column = new TextViewColumn('PrecioVenta', 'PrecioVenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for PrecioEspecial field
            //
            $column = new TextViewColumn('PrecioEspecial', 'PrecioEspecial', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CostoUnitario field
            //
            $column = new TextViewColumn('CostoUnitario', 'CostoUnitario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Departamento_Nombre', 'Departamento', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ImagenRuta field
            //
            $column = new TextViewColumn('ImagenRuta', 'ImagenRuta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CuentaPUC field
            //
            $column = new TextViewColumn('CuentaPUC', 'CuentaPUC', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idServicios field
            //
            $column = new TextViewColumn('idServicios', 'IdServicios', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Referencia field
            //
            $column = new TextViewColumn('Referencia', 'Referencia', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for PrecioVenta field
            //
            $column = new TextViewColumn('PrecioVenta', 'PrecioVenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for PrecioEspecial field
            //
            $column = new TextViewColumn('PrecioEspecial', 'PrecioEspecial', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for CostoUnitario field
            //
            $column = new TextViewColumn('CostoUnitario', 'CostoUnitario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for IVA field
            //
            $column = new TextViewColumn('IVA', 'IVA', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Departamento_Nombre', 'Departamento', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ImagenRuta field
            //
            $column = new TextViewColumn('ImagenRuta', 'ImagenRuta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for CuentaPUC field
            //
            $column = new TextViewColumn('CuentaPUC', 'CuentaPUC', $this->dataset);
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
    
        public function ImagenRuta_Thumbnail_GenerateFileName_inline_edit(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), '');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('small_%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        
        public function ImagenRuta_GenerateFileName_inline_edit(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), 'sevicios_img');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        
        public function ImagenRuta_Thumbnail_GenerateFileName_inline_insert(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), '');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('small_%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        
        public function ImagenRuta_GenerateFileName_inline_insert(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), 'sevicios_img');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        function serviciosGrid_AfterInsertRecord($page, $rowData, $tableName)
        {
            include("../conexion.php");
            $con=mysql_connect($host,$user,$pw) or die("problemas con el servidor");
            mysql_select_db($db,$con) or die("la base de datos no abre");
            
            if($rowData["Referencia"]==""){
            				
            				
            				$ProxID="RSER$rowData[idServicios]";
            				 mysql_query("UPDATE servicios SET Referencia='$ProxID'
            				WHERE idServicios = '$rowData[idServicios]'",$con) or die("problemas con la consulta".mysql_error());
            				
            			}
        }
        public function ImagenRuta_Thumbnail_GenerateFileName_edit(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), '');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('small_%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        
        public function ImagenRuta_GenerateFileName_edit(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), 'sevicios_img');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        public function ImagenRuta_Thumbnail_GenerateFileName_insert(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), '');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('small_%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        
        public function ImagenRuta_GenerateFileName_insert(&$filepath, &$handled, $original_file_name, $original_file_extension, $file_size)
        {
        $targetFolder = FormatDatasetFieldsTemplate($this->GetDataset(), 'sevicios_img');
        FileUtils::ForceDirectories($targetFolder);
        
        $filename = ApplyVarablesMapToTemplate('%original_file_name%',
            array(
                'original_file_name' => $original_file_name,
                'original_file_extension' => $original_file_extension,
                'file_size' => $file_size
            )
        );
        $filepath = Path::Combine($targetFolder, $filename);
        
        $handled = true;
        }
        public function ShowEditButtonHandler(&$show)
        {
            if ($this->GetRecordPermission() != null)
                $show = $this->GetRecordPermission()->HasEditGrant($this->GetDataset());
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset, 'serviciosGrid');
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
            $result->AfterInsertRecord->AddListener('serviciosGrid' . '_' . 'AfterInsertRecord', $this);
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
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Nombre field
            //
            $editor = new TextAreaEdit('nombre_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Nombre field
            //
            $editor = new TextAreaEdit('nombre_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'Nombre_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'Nombre_handler', $column);
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
        $Page = new serviciosPage("servicios.php", "servicios", GetCurrentUserGrantForDataSource("servicios"), 'UTF-8');
        $Page->SetShortCaption('Servicios');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Servicios');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("servicios"));
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
	
