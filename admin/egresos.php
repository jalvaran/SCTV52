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
    
    
    
    class egresosPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`egresos`');
            $field = new IntegerField('idEgresos', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('Fecha');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('PagoProg');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('FechaPagoPro');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('FechaPago');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Concepto');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('TipoEgreso');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('ServicioPago');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Beneficiario');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('NIT');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Direccion');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Ciudad');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Subtotal');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('IVA');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Valor');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('NumFactura');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('idProveedor');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('Cuenta');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new IntegerField('Usuario_idUsuario');
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
            $field = new StringField('UsuarioCierreDiario');
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
            $grid->SearchControl = new SimpleSearch('egresosssearch', $this->dataset,
                array('idEgresos', 'Fecha', 'PagoProg', 'FechaPagoPro', 'FechaPago', 'Concepto', 'TipoEgreso', 'ServicioPago', 'Beneficiario', 'NIT', 'Direccion', 'Ciudad', 'Subtotal', 'IVA', 'Valor', 'NumFactura', 'idProveedor', 'Cuenta', 'Usuario_idUsuario'),
                array($this->RenderText('IdEgresos'), $this->RenderText('Fecha'), $this->RenderText('PagoProg'), $this->RenderText('FechaPagoPro'), $this->RenderText('FechaPago'), $this->RenderText('Concepto'), $this->RenderText('TipoEgreso'), $this->RenderText('ServicioPago'), $this->RenderText('Beneficiario'), $this->RenderText('NIT'), $this->RenderText('Direccion'), $this->RenderText('Ciudad'), $this->RenderText('Subtotal'), $this->RenderText('IVA'), $this->RenderText('Valor'), $this->RenderText('NumFactura'), $this->RenderText('IdProveedor'), $this->RenderText('Cuenta'), $this->RenderText('Usuario IdUsuario')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('egresosasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('idEgresos', $this->RenderText('IdEgresos')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Fecha', $this->RenderText('Fecha')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('PagoProg', $this->RenderText('PagoProg')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FechaPagoPro', $this->RenderText('FechaPagoPro')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('FechaPago', $this->RenderText('FechaPago')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Concepto', $this->RenderText('Concepto')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('TipoEgreso', $this->RenderText('TipoEgreso')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('ServicioPago', $this->RenderText('ServicioPago')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Beneficiario', $this->RenderText('Beneficiario')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('NIT', $this->RenderText('NIT')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Direccion', $this->RenderText('Direccion')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Ciudad', $this->RenderText('Ciudad')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Subtotal', $this->RenderText('Subtotal')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('IVA', $this->RenderText('IVA')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Valor', $this->RenderText('Valor')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('NumFactura', $this->RenderText('NumFactura')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('idProveedor', $this->RenderText('IdProveedor')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Cuenta', $this->RenderText('Cuenta')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Usuario_idUsuario', $this->RenderText('Usuario IdUsuario')));
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
            // View column for idEgresos field
            //
            $column = new TextViewColumn('idEgresos', 'IdEgresos', $this->dataset);
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
            // View column for PagoProg field
            //
            $column = new TextViewColumn('PagoProg', 'PagoProg', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for PagoProg field
            //
            $editor = new TextEdit('pagoprog_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('PagoProg', 'PagoProg', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for PagoProg field
            //
            $editor = new TextEdit('pagoprog_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('PagoProg', 'PagoProg', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FechaPagoPro field
            //
            $column = new TextViewColumn('FechaPagoPro', 'FechaPagoPro', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for FechaPagoPro field
            //
            $editor = new TextEdit('fechapagopro_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPagoPro', 'FechaPagoPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for FechaPagoPro field
            //
            $editor = new TextEdit('fechapagopro_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPagoPro', 'FechaPagoPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for FechaPago field
            //
            $column = new TextViewColumn('FechaPago', 'FechaPago', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for FechaPago field
            //
            $editor = new TextEdit('fechapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPago', 'FechaPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for FechaPago field
            //
            $editor = new TextEdit('fechapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPago', 'FechaPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Concepto field
            //
            $column = new TextViewColumn('Concepto', 'Concepto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('Concepto_handler');
            
            /* <inline edit column> */
            //
            // Edit column for Concepto field
            //
            $editor = new TextAreaEdit('concepto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Concepto', 'Concepto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Concepto field
            //
            $editor = new TextAreaEdit('concepto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Concepto', 'Concepto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for TipoEgreso field
            //
            $column = new TextViewColumn('TipoEgreso', 'TipoEgreso', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for TipoEgreso field
            //
            $editor = new TextEdit('tipoegreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TipoEgreso', 'TipoEgreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for TipoEgreso field
            //
            $editor = new TextEdit('tipoegreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TipoEgreso', 'TipoEgreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ServicioPago field
            //
            $column = new TextViewColumn('ServicioPago', 'ServicioPago', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for ServicioPago field
            //
            $editor = new TextEdit('serviciopago_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ServicioPago', 'ServicioPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ServicioPago field
            //
            $editor = new TextEdit('serviciopago_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ServicioPago', 'ServicioPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Beneficiario field
            //
            $column = new TextViewColumn('Beneficiario', 'Beneficiario', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Beneficiario field
            //
            $editor = new TextEdit('beneficiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Beneficiario', 'Beneficiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Beneficiario field
            //
            $editor = new TextEdit('beneficiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Beneficiario', 'Beneficiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for NIT field
            //
            $column = new TextViewColumn('NIT', 'NIT', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for NIT field
            //
            $editor = new TextEdit('nit_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NIT', 'NIT', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for NIT field
            //
            $editor = new TextEdit('nit_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NIT', 'NIT', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Direccion field
            //
            $column = new TextViewColumn('Direccion', 'Direccion', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Direccion field
            //
            $editor = new TextEdit('direccion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Direccion', 'Direccion', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Direccion field
            //
            $editor = new TextEdit('direccion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Direccion', 'Direccion', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Ciudad field
            //
            $column = new TextViewColumn('Ciudad', 'Ciudad', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Ciudad field
            //
            $editor = new TextEdit('ciudad_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Ciudad', 'Ciudad', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Ciudad field
            //
            $editor = new TextEdit('ciudad_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Ciudad', 'Ciudad', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
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
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
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
            // View column for Valor field
            //
            $column = new TextViewColumn('Valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Valor field
            //
            $editor = new TextEdit('valor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Valor', 'Valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Valor field
            //
            $editor = new TextEdit('valor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Valor', 'Valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for NumFactura field
            //
            $column = new TextViewColumn('NumFactura', 'NumFactura', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for NumFactura field
            //
            $editor = new TextEdit('numfactura_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumFactura', 'NumFactura', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for NumFactura field
            //
            $editor = new TextEdit('numfactura_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumFactura', 'NumFactura', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for idProveedor field
            //
            $column = new TextViewColumn('idProveedor', 'IdProveedor', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for idProveedor field
            //
            $editor = new TextEdit('idproveedor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IdProveedor', 'idProveedor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for idProveedor field
            //
            $editor = new TextEdit('idproveedor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IdProveedor', 'idProveedor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Cuenta field
            //
            $column = new TextViewColumn('Cuenta', 'Cuenta', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Cuenta field
            //
            $editor = new TextEdit('cuenta_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cuenta', 'Cuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Cuenta field
            //
            $editor = new TextEdit('cuenta_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cuenta', 'Cuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Usuario_idUsuario field
            //
            $column = new TextViewColumn('Usuario_idUsuario', 'Usuario IdUsuario', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Usuario_idUsuario field
            //
            $editor = new TextEdit('usuario_idusuario_edit');
            $editColumn = new CustomEditColumn('Usuario IdUsuario', 'Usuario_idUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Usuario_idUsuario field
            //
            $editor = new TextEdit('usuario_idusuario_edit');
            $editColumn = new CustomEditColumn('Usuario IdUsuario', 'Usuario_idUsuario', $editor, $this->dataset);
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
            // View column for idEgresos field
            //
            $column = new TextViewColumn('idEgresos', 'IdEgresos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for PagoProg field
            //
            $column = new TextViewColumn('PagoProg', 'PagoProg', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FechaPagoPro field
            //
            $column = new TextViewColumn('FechaPagoPro', 'FechaPagoPro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for FechaPago field
            //
            $column = new TextViewColumn('FechaPago', 'FechaPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Concepto field
            //
            $column = new TextViewColumn('Concepto', 'Concepto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('Concepto_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for TipoEgreso field
            //
            $column = new TextViewColumn('TipoEgreso', 'TipoEgreso', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ServicioPago field
            //
            $column = new TextViewColumn('ServicioPago', 'ServicioPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Beneficiario field
            //
            $column = new TextViewColumn('Beneficiario', 'Beneficiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for NIT field
            //
            $column = new TextViewColumn('NIT', 'NIT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Direccion field
            //
            $column = new TextViewColumn('Direccion', 'Direccion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Ciudad field
            //
            $column = new TextViewColumn('Ciudad', 'Ciudad', $this->dataset);
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
            // View column for Valor field
            //
            $column = new TextViewColumn('Valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for NumFactura field
            //
            $column = new TextViewColumn('NumFactura', 'NumFactura', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idProveedor field
            //
            $column = new TextViewColumn('idProveedor', 'IdProveedor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Cuenta field
            //
            $column = new TextViewColumn('Cuenta', 'Cuenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Usuario_idUsuario field
            //
            $column = new TextViewColumn('Usuario_idUsuario', 'Usuario IdUsuario', $this->dataset);
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
            // Edit column for PagoProg field
            //
            $editor = new TextEdit('pagoprog_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('PagoProg', 'PagoProg', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for FechaPagoPro field
            //
            $editor = new TextEdit('fechapagopro_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPagoPro', 'FechaPagoPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for FechaPago field
            //
            $editor = new TextEdit('fechapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPago', 'FechaPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Concepto field
            //
            $editor = new TextAreaEdit('concepto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Concepto', 'Concepto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for TipoEgreso field
            //
            $editor = new TextEdit('tipoegreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TipoEgreso', 'TipoEgreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ServicioPago field
            //
            $editor = new TextEdit('serviciopago_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ServicioPago', 'ServicioPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Beneficiario field
            //
            $editor = new TextEdit('beneficiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Beneficiario', 'Beneficiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for NIT field
            //
            $editor = new TextEdit('nit_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NIT', 'NIT', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Direccion field
            //
            $editor = new TextEdit('direccion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Direccion', 'Direccion', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Ciudad field
            //
            $editor = new TextEdit('ciudad_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Ciudad', 'Ciudad', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Subtotal field
            //
            $editor = new TextEdit('subtotal_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Subtotal', 'Subtotal', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Valor field
            //
            $editor = new TextEdit('valor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Valor', 'Valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for NumFactura field
            //
            $editor = new TextEdit('numfactura_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumFactura', 'NumFactura', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idProveedor field
            //
            $editor = new TextEdit('idproveedor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IdProveedor', 'idProveedor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Cuenta field
            //
            $editor = new TextEdit('cuenta_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cuenta', 'Cuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Usuario_idUsuario field
            //
            $editor = new TextEdit('usuario_idusuario_edit');
            $editColumn = new CustomEditColumn('Usuario IdUsuario', 'Usuario_idUsuario', $editor, $this->dataset);
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
            // Edit column for PagoProg field
            //
            $editor = new TextEdit('pagoprog_edit');
            $editor->SetSize(10);
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('PagoProg', 'PagoProg', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for FechaPagoPro field
            //
            $editor = new TextEdit('fechapagopro_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPagoPro', 'FechaPagoPro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for FechaPago field
            //
            $editor = new TextEdit('fechapago_edit');
            $editor->SetSize(20);
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('FechaPago', 'FechaPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Concepto field
            //
            $editor = new TextAreaEdit('concepto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Concepto', 'Concepto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for TipoEgreso field
            //
            $editor = new TextEdit('tipoegreso_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('TipoEgreso', 'TipoEgreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ServicioPago field
            //
            $editor = new TextEdit('serviciopago_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ServicioPago', 'ServicioPago', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Beneficiario field
            //
            $editor = new TextEdit('beneficiario_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Beneficiario', 'Beneficiario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for NIT field
            //
            $editor = new TextEdit('nit_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NIT', 'NIT', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Direccion field
            //
            $editor = new TextEdit('direccion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Direccion', 'Direccion', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Ciudad field
            //
            $editor = new TextEdit('ciudad_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Ciudad', 'Ciudad', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Subtotal field
            //
            $editor = new TextEdit('subtotal_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Subtotal', 'Subtotal', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for IVA field
            //
            $editor = new TextEdit('iva_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IVA', 'IVA', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Valor field
            //
            $editor = new TextEdit('valor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Valor', 'Valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for NumFactura field
            //
            $editor = new TextEdit('numfactura_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumFactura', 'NumFactura', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idProveedor field
            //
            $editor = new TextEdit('idproveedor_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('IdProveedor', 'idProveedor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Cuenta field
            //
            $editor = new TextEdit('cuenta_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cuenta', 'Cuenta', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Usuario_idUsuario field
            //
            $editor = new TextEdit('usuario_idusuario_edit');
            $editColumn = new CustomEditColumn('Usuario IdUsuario', 'Usuario_idUsuario', $editor, $this->dataset);
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
            // View column for idEgresos field
            //
            $column = new TextViewColumn('idEgresos', 'IdEgresos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for PagoProg field
            //
            $column = new TextViewColumn('PagoProg', 'PagoProg', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for FechaPagoPro field
            //
            $column = new TextViewColumn('FechaPagoPro', 'FechaPagoPro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for FechaPago field
            //
            $column = new TextViewColumn('FechaPago', 'FechaPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Concepto field
            //
            $column = new TextViewColumn('Concepto', 'Concepto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for TipoEgreso field
            //
            $column = new TextViewColumn('TipoEgreso', 'TipoEgreso', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ServicioPago field
            //
            $column = new TextViewColumn('ServicioPago', 'ServicioPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Beneficiario field
            //
            $column = new TextViewColumn('Beneficiario', 'Beneficiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for NIT field
            //
            $column = new TextViewColumn('NIT', 'NIT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Direccion field
            //
            $column = new TextViewColumn('Direccion', 'Direccion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Ciudad field
            //
            $column = new TextViewColumn('Ciudad', 'Ciudad', $this->dataset);
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
            // View column for Valor field
            //
            $column = new TextViewColumn('Valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for NumFactura field
            //
            $column = new TextViewColumn('NumFactura', 'NumFactura', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for idProveedor field
            //
            $column = new TextViewColumn('idProveedor', 'IdProveedor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Cuenta field
            //
            $column = new TextViewColumn('Cuenta', 'Cuenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Usuario_idUsuario field
            //
            $column = new TextViewColumn('Usuario_idUsuario', 'Usuario IdUsuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idEgresos field
            //
            $column = new TextViewColumn('idEgresos', 'IdEgresos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Fecha field
            //
            $column = new TextViewColumn('Fecha', 'Fecha', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for PagoProg field
            //
            $column = new TextViewColumn('PagoProg', 'PagoProg', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for FechaPagoPro field
            //
            $column = new TextViewColumn('FechaPagoPro', 'FechaPagoPro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for FechaPago field
            //
            $column = new TextViewColumn('FechaPago', 'FechaPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Concepto field
            //
            $column = new TextViewColumn('Concepto', 'Concepto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for TipoEgreso field
            //
            $column = new TextViewColumn('TipoEgreso', 'TipoEgreso', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ServicioPago field
            //
            $column = new TextViewColumn('ServicioPago', 'ServicioPago', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Beneficiario field
            //
            $column = new TextViewColumn('Beneficiario', 'Beneficiario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for NIT field
            //
            $column = new TextViewColumn('NIT', 'NIT', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Direccion field
            //
            $column = new TextViewColumn('Direccion', 'Direccion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Ciudad field
            //
            $column = new TextViewColumn('Ciudad', 'Ciudad', $this->dataset);
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
            // View column for Valor field
            //
            $column = new TextViewColumn('Valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for NumFactura field
            //
            $column = new TextViewColumn('NumFactura', 'NumFactura', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for idProveedor field
            //
            $column = new TextViewColumn('idProveedor', 'IdProveedor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Cuenta field
            //
            $column = new TextViewColumn('Cuenta', 'Cuenta', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Usuario_idUsuario field
            //
            $column = new TextViewColumn('Usuario_idUsuario', 'Usuario IdUsuario', $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'egresosGrid');
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
            // View column for Concepto field
            //
            $column = new TextViewColumn('Concepto', 'Concepto', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Concepto field
            //
            $editor = new TextAreaEdit('concepto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Concepto', 'Concepto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Concepto field
            //
            $editor = new TextAreaEdit('concepto_edit', 50, 8);
            $editColumn = new CustomEditColumn('Concepto', 'Concepto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'Concepto_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Concepto field
            //
            $column = new TextViewColumn('Concepto', 'Concepto', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'Concepto_handler', $column);
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
        $Page = new egresosPage("egresos.php", "egresos", GetCurrentUserGrantForDataSource("egresos"), 'UTF-8');
        $Page->SetShortCaption('Egresos');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Egresos');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("egresos"));
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
	
