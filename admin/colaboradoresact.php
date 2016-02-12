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
    
    
    
    class colaboradoresPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                new MyConnectionFactory(),
                GetConnectionOptions(),
                '`colaboradores`');
            $field = new IntegerField('idColaboradores', null, null, true);
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, true);
            $field = new StringField('CuentaPUC');
            $this->dataset->AddField($field, false);
            $field = new StringField('Nombre');
            $this->dataset->AddField($field, false);
            $field = new StringField('Identificacion');
            $this->dataset->AddField($field, false);
            $field = new StringField('Telefono');
            $this->dataset->AddField($field, false);
            $field = new StringField('Direccion');
            $this->dataset->AddField($field, false);
            $field = new StringField('Ciudad');
            $this->dataset->AddField($field, false);
            $field = new StringField('Email');
            $this->dataset->AddField($field, false);
            $field = new StringField('Contacto');
            $this->dataset->AddField($field, false);
            $field = new StringField('NumContacto');
            $this->dataset->AddField($field, false);
            $field = new StringField('Cargo');
            $this->dataset->AddField($field, false);
            $field = new StringField('SalarioBasico');
            $this->dataset->AddField($field, false);
            $field = new StringField('EPS');
            $this->dataset->AddField($field, false);
            $field = new StringField('ValorEPS');
            $this->dataset->AddField($field, false);
            $field = new StringField('PorcentajeAsumidoEPS');
            $this->dataset->AddField($field, false);
            $field = new StringField('ARL');
            $this->dataset->AddField($field, false);
            $field = new StringField('ValorARL');
            $this->dataset->AddField($field, false);
            $field = new StringField('Pensiones');
            $this->dataset->AddField($field, false);
            $field = new StringField('PorcentajeAsumidoPensiones');
            $this->dataset->AddField($field, false);
            $field = new StringField('ValorPensiones');
            $this->dataset->AddField($field, false);
            $field = new StringField('CajaCompensacion');
            $this->dataset->AddField($field, false);
            $field = new StringField('ValorCajaCompensacion');
            $this->dataset->AddField($field, false);
            $field = new StringField('HojaDeVida');
            $this->dataset->AddField($field, false);
            $field = new StringField('Clave');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('HV_Type');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('HV_name');
            $field->SetIsNotNull(true);
            $this->dataset->AddField($field, false);
            $field = new StringField('HV_size');
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
            $grid->SearchControl = new SimpleSearch('colaboradoresssearch', $this->dataset,
                array('idColaboradores', 'Nombre', 'Identificacion', 'Telefono', 'Direccion', 'Ciudad', 'Email', 'Contacto', 'NumContacto', 'Cargo', 'SalarioBasico', 'EPS', 'ValorEPS', 'PorcentajeAsumidoEPS', 'ARL', 'ValorARL', 'Pensiones', 'PorcentajeAsumidoPensiones', 'ValorPensiones', 'CajaCompensacion', 'ValorCajaCompensacion', 'HojaDeVida', 'Clave', 'HV_name'),
                array($this->RenderText('IdColaboradores'), $this->RenderText('Nombre'), $this->RenderText('Identificacion'), $this->RenderText('Telefono'), $this->RenderText('Direccion'), $this->RenderText('Ciudad'), $this->RenderText('Email'), $this->RenderText('Contacto'), $this->RenderText('NumContacto'), $this->RenderText('Cargo'), $this->RenderText('SalarioBasico'), $this->RenderText('EPS'), $this->RenderText('ValorEPS'), $this->RenderText('PorcentajeAsumidoEPS'), $this->RenderText('ARL'), $this->RenderText('ValorARL'), $this->RenderText('Pensiones'), $this->RenderText('PorcentajeAsumidoPensiones'), $this->RenderText('ValorPensiones'), $this->RenderText('CajaCompensacion'), $this->RenderText('ValorCajaCompensacion'), $this->RenderText('HojaDeVida'), $this->RenderText('Clave'), $this->RenderText('HV Name')),
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
            $this->AdvancedSearchControl = new AdvancedSearchControl('colaboradoresasearch', $this->dataset, $this->GetLocalizerCaptions(), $this->GetColumnVariableContainer(), $this->CreateLinkBuilder());
            $this->AdvancedSearchControl->setTimerInterval(1000);
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('idColaboradores', $this->RenderText('IdColaboradores')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Nombre', $this->RenderText('Nombre')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Identificacion', $this->RenderText('Identificacion')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Telefono', $this->RenderText('Telefono')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Direccion', $this->RenderText('Direccion')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Ciudad', $this->RenderText('Ciudad')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Email', $this->RenderText('Email')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Contacto', $this->RenderText('Contacto')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('NumContacto', $this->RenderText('NumContacto')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Cargo', $this->RenderText('Cargo')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('SalarioBasico', $this->RenderText('SalarioBasico')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('EPS', $this->RenderText('EPS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('ValorEPS', $this->RenderText('ValorEPS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('PorcentajeAsumidoEPS', $this->RenderText('PorcentajeAsumidoEPS')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('ARL', $this->RenderText('ARL')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('ValorARL', $this->RenderText('ValorARL')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Pensiones', $this->RenderText('Pensiones')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('PorcentajeAsumidoPensiones', $this->RenderText('PorcentajeAsumidoPensiones')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('ValorPensiones', $this->RenderText('ValorPensiones')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('CajaCompensacion', $this->RenderText('CajaCompensacion')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('ValorCajaCompensacion', $this->RenderText('ValorCajaCompensacion')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HojaDeVida', $this->RenderText('HojaDeVida')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('Clave', $this->RenderText('Clave')));
            $this->AdvancedSearchControl->AddSearchColumn($this->AdvancedSearchControl->CreateStringSearchInput('HV_name', $this->RenderText('HV Name')));
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
            // View column for idColaboradores field
            //
            $column = new TextViewColumn('idColaboradores', 'IdColaboradores', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Identificacion field
            //
            $column = new TextViewColumn('Identificacion', 'Identificacion', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Identificacion field
            //
            $editor = new TextEdit('identificacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Identificacion', 'Identificacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Identificacion field
            //
            $editor = new TextEdit('identificacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Identificacion', 'Identificacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Telefono field
            //
            $column = new TextViewColumn('Telefono', 'Telefono', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Telefono field
            //
            $editor = new TextEdit('telefono_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Telefono', 'Telefono', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Telefono field
            //
            $editor = new TextEdit('telefono_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Telefono', 'Telefono', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Contacto field
            //
            $column = new TextViewColumn('Contacto', 'Contacto', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Contacto field
            //
            $editor = new TextEdit('contacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Contacto', 'Contacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Contacto field
            //
            $editor = new TextEdit('contacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Contacto', 'Contacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for NumContacto field
            //
            $column = new TextViewColumn('NumContacto', 'NumContacto', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for NumContacto field
            //
            $editor = new TextEdit('numcontacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumContacto', 'NumContacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for NumContacto field
            //
            $editor = new TextEdit('numcontacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumContacto', 'NumContacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Cargo field
            //
            $column = new TextViewColumn('Cargo', 'Cargo', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Cargo field
            //
            $editor = new TextEdit('cargo_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cargo', 'Cargo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Cargo field
            //
            $editor = new TextEdit('cargo_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cargo', 'Cargo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for SalarioBasico field
            //
            $column = new TextViewColumn('SalarioBasico', 'SalarioBasico', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for SalarioBasico field
            //
            $editor = new TextEdit('salariobasico_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SalarioBasico', 'SalarioBasico', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for SalarioBasico field
            //
            $editor = new TextEdit('salariobasico_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SalarioBasico', 'SalarioBasico', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for EPS field
            //
            $column = new TextViewColumn('EPS', 'EPS', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for EPS field
            //
            $editor = new TextEdit('eps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('EPS', 'EPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for EPS field
            //
            $editor = new TextEdit('eps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('EPS', 'EPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ValorEPS field
            //
            $column = new TextViewColumn('ValorEPS', 'ValorEPS', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for ValorEPS field
            //
            $editor = new TextEdit('valoreps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorEPS', 'ValorEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ValorEPS field
            //
            $editor = new TextEdit('valoreps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorEPS', 'ValorEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for PorcentajeAsumidoEPS field
            //
            $column = new TextViewColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for PorcentajeAsumidoEPS field
            //
            $editor = new TextEdit('porcentajeasumidoeps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for PorcentajeAsumidoEPS field
            //
            $editor = new TextEdit('porcentajeasumidoeps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ARL field
            //
            $column = new TextViewColumn('ARL', 'ARL', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for ARL field
            //
            $editor = new TextEdit('arl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ARL', 'ARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ARL field
            //
            $editor = new TextEdit('arl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ARL', 'ARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ValorARL field
            //
            $column = new TextViewColumn('ValorARL', 'ValorARL', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for ValorARL field
            //
            $editor = new TextEdit('valorarl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorARL', 'ValorARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ValorARL field
            //
            $editor = new TextEdit('valorarl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorARL', 'ValorARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Pensiones field
            //
            $column = new TextViewColumn('Pensiones', 'Pensiones', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Pensiones field
            //
            $editor = new TextEdit('pensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Pensiones', 'Pensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Pensiones field
            //
            $editor = new TextEdit('pensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Pensiones', 'Pensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for PorcentajeAsumidoPensiones field
            //
            $column = new TextViewColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for PorcentajeAsumidoPensiones field
            //
            $editor = new TextEdit('porcentajeasumidopensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for PorcentajeAsumidoPensiones field
            //
            $editor = new TextEdit('porcentajeasumidopensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ValorPensiones field
            //
            $column = new TextViewColumn('ValorPensiones', 'ValorPensiones', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for ValorPensiones field
            //
            $editor = new TextEdit('valorpensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorPensiones', 'ValorPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ValorPensiones field
            //
            $editor = new TextEdit('valorpensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorPensiones', 'ValorPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CajaCompensacion field
            //
            $column = new TextViewColumn('CajaCompensacion', 'CajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for CajaCompensacion field
            //
            $editor = new TextEdit('cajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CajaCompensacion', 'CajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for CajaCompensacion field
            //
            $editor = new TextEdit('cajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CajaCompensacion', 'CajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ValorCajaCompensacion field
            //
            $column = new TextViewColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for ValorCajaCompensacion field
            //
            $editor = new TextEdit('valorcajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for ValorCajaCompensacion field
            //
            $editor = new TextEdit('valorcajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for HojaDeVida field
            //
            $column = new TextViewColumn('HojaDeVida', 'HojaDeVida', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for HojaDeVida field
            //
            $editor = new ImageUploader('hojadevida_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('HojaDeVida', 'HojaDeVida', $editor, $this->dataset, false, false, 'HojaDeVida_handler_inline_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileTypeFieldName('HV_Type');
            $editColumn->SetFileNameFieldName('HV_name');
            $editColumn->SetFileSizeFieldName('HV_size');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for HojaDeVida field
            //
            $editor = new ImageUploader('hojadevida_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('HojaDeVida', 'HojaDeVida', $editor, $this->dataset, false, false, 'HojaDeVida_handler_inline_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileTypeFieldName('HV_Type');
            $editColumn->SetFileNameFieldName('HV_name');
            $editColumn->SetFileSizeFieldName('HV_size');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, '%HV_name%' , '_blank');
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Clave field
            //
            $column = new TextViewColumn('Clave', 'Clave', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('Clave_handler');
            
            /* <inline edit column> */
            //
            // Edit column for Clave field
            //
            $editor = new TextEdit('clave_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clave', 'Clave', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Clave field
            //
            $editor = new TextEdit('clave_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clave', 'Clave', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $column->SetDescription($this->RenderText(''));
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for HV_name field
            //
            $column = new TextViewColumn('HV_name', 'HV Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('HV_name_handler');
            
            /* <inline edit column> */
            //
            // Edit column for HV_name field
            //
            $editor = new TextAreaEdit('hv_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('HV Name', 'HV_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for HV_name field
            //
            $editor = new TextAreaEdit('hv_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('HV Name', 'HV_name', $editor, $this->dataset);
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
            // View column for idColaboradores field
            //
            $column = new TextViewColumn('idColaboradores', 'IdColaboradores', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Identificacion field
            //
            $column = new TextViewColumn('Identificacion', 'Identificacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Telefono field
            //
            $column = new TextViewColumn('Telefono', 'Telefono', $this->dataset);
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
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Contacto field
            //
            $column = new TextViewColumn('Contacto', 'Contacto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for NumContacto field
            //
            $column = new TextViewColumn('NumContacto', 'NumContacto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Cargo field
            //
            $column = new TextViewColumn('Cargo', 'Cargo', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for SalarioBasico field
            //
            $column = new TextViewColumn('SalarioBasico', 'SalarioBasico', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for EPS field
            //
            $column = new TextViewColumn('EPS', 'EPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ValorEPS field
            //
            $column = new TextViewColumn('ValorEPS', 'ValorEPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for PorcentajeAsumidoEPS field
            //
            $column = new TextViewColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ARL field
            //
            $column = new TextViewColumn('ARL', 'ARL', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ValorARL field
            //
            $column = new TextViewColumn('ValorARL', 'ValorARL', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Pensiones field
            //
            $column = new TextViewColumn('Pensiones', 'Pensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for PorcentajeAsumidoPensiones field
            //
            $column = new TextViewColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ValorPensiones field
            //
            $column = new TextViewColumn('ValorPensiones', 'ValorPensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CajaCompensacion field
            //
            $column = new TextViewColumn('CajaCompensacion', 'CajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ValorCajaCompensacion field
            //
            $column = new TextViewColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for HojaDeVida field
            //
            $column = new TextViewColumn('HojaDeVida', 'HojaDeVida', $this->dataset);
            $column->SetOrderable(true);
            $column = new ExtendedHyperLinkColumnDecorator($column, $this->dataset, '%HV_name%' , '_blank');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Clave field
            //
            $column = new TextViewColumn('Clave', 'Clave', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('Clave_handler');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for HV_name field
            //
            $column = new TextViewColumn('HV_name', 'HV Name', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('HV_name_handler');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Identificacion field
            //
            $editor = new TextEdit('identificacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Identificacion', 'Identificacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Telefono field
            //
            $editor = new TextEdit('telefono_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Telefono', 'Telefono', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Direccion field
            //
            $editor = new TextEdit('direccion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Direccion', 'Direccion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Ciudad field
            //
            $editor = new TextEdit('ciudad_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Ciudad', 'Ciudad', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Contacto field
            //
            $editor = new TextEdit('contacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Contacto', 'Contacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for NumContacto field
            //
            $editor = new TextEdit('numcontacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumContacto', 'NumContacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Cargo field
            //
            $editor = new TextEdit('cargo_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cargo', 'Cargo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for SalarioBasico field
            //
            $editor = new TextEdit('salariobasico_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SalarioBasico', 'SalarioBasico', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for EPS field
            //
            $editor = new TextEdit('eps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('EPS', 'EPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ValorEPS field
            //
            $editor = new TextEdit('valoreps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorEPS', 'ValorEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for PorcentajeAsumidoEPS field
            //
            $editor = new TextEdit('porcentajeasumidoeps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ARL field
            //
            $editor = new TextEdit('arl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ARL', 'ARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ValorARL field
            //
            $editor = new TextEdit('valorarl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorARL', 'ValorARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Pensiones field
            //
            $editor = new TextEdit('pensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Pensiones', 'Pensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for PorcentajeAsumidoPensiones field
            //
            $editor = new TextEdit('porcentajeasumidopensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ValorPensiones field
            //
            $editor = new TextEdit('valorpensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorPensiones', 'ValorPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CajaCompensacion field
            //
            $editor = new TextEdit('cajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CajaCompensacion', 'CajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ValorCajaCompensacion field
            //
            $editor = new TextEdit('valorcajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for HojaDeVida field
            //
            $editor = new ImageUploader('hojadevida_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('HojaDeVida', 'HojaDeVida', $editor, $this->dataset, false, false, 'HojaDeVida_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileTypeFieldName('HV_Type');
            $editColumn->SetFileNameFieldName('HV_name');
            $editColumn->SetFileSizeFieldName('HV_size');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Clave field
            //
            $editor = new TextEdit('clave_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clave', 'Clave', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for HV_name field
            //
            $editor = new TextAreaEdit('hv_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('HV Name', 'HV_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Nombre', 'Nombre', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Identificacion field
            //
            $editor = new TextEdit('identificacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Identificacion', 'Identificacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Telefono field
            //
            $editor = new TextEdit('telefono_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Telefono', 'Telefono', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Direccion field
            //
            $editor = new TextEdit('direccion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Direccion', 'Direccion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Ciudad field
            //
            $editor = new TextEdit('ciudad_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Ciudad', 'Ciudad', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Contacto field
            //
            $editor = new TextEdit('contacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Contacto', 'Contacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for NumContacto field
            //
            $editor = new TextEdit('numcontacto_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('NumContacto', 'NumContacto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Cargo field
            //
            $editor = new TextEdit('cargo_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Cargo', 'Cargo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for SalarioBasico field
            //
            $editor = new TextEdit('salariobasico_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('SalarioBasico', 'SalarioBasico', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for EPS field
            //
            $editor = new TextEdit('eps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('EPS', 'EPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ValorEPS field
            //
            $editor = new TextEdit('valoreps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorEPS', 'ValorEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for PorcentajeAsumidoEPS field
            //
            $editor = new TextEdit('porcentajeasumidoeps_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ARL field
            //
            $editor = new TextEdit('arl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ARL', 'ARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ValorARL field
            //
            $editor = new TextEdit('valorarl_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorARL', 'ValorARL', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Pensiones field
            //
            $editor = new TextEdit('pensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Pensiones', 'Pensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for PorcentajeAsumidoPensiones field
            //
            $editor = new TextEdit('porcentajeasumidopensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ValorPensiones field
            //
            $editor = new TextEdit('valorpensiones_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorPensiones', 'ValorPensiones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CajaCompensacion field
            //
            $editor = new TextEdit('cajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('CajaCompensacion', 'CajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ValorCajaCompensacion field
            //
            $editor = new TextEdit('valorcajacompensacion_edit');
            $editor->SetSize(45);
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for HojaDeVida field
            //
            $editor = new ImageUploader('hojadevida_edit');
            $editor->SetShowImage(false);
            $editColumn = new FileUploadingColumn('HojaDeVida', 'HojaDeVida', $editor, $this->dataset, false, false, 'HojaDeVida_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetFileTypeFieldName('HV_Type');
            $editColumn->SetFileNameFieldName('HV_name');
            $editColumn->SetFileSizeFieldName('HV_size');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Clave field
            //
            $editor = new TextEdit('clave_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clave', 'Clave', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for HV_name field
            //
            $editor = new TextAreaEdit('hv_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('HV Name', 'HV_name', $editor, $this->dataset);
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
            // View column for idColaboradores field
            //
            $column = new TextViewColumn('idColaboradores', 'IdColaboradores', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Identificacion field
            //
            $column = new TextViewColumn('Identificacion', 'Identificacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Telefono field
            //
            $column = new TextViewColumn('Telefono', 'Telefono', $this->dataset);
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
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Contacto field
            //
            $column = new TextViewColumn('Contacto', 'Contacto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for NumContacto field
            //
            $column = new TextViewColumn('NumContacto', 'NumContacto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Cargo field
            //
            $column = new TextViewColumn('Cargo', 'Cargo', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for SalarioBasico field
            //
            $column = new TextViewColumn('SalarioBasico', 'SalarioBasico', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for EPS field
            //
            $column = new TextViewColumn('EPS', 'EPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ValorEPS field
            //
            $column = new TextViewColumn('ValorEPS', 'ValorEPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for PorcentajeAsumidoEPS field
            //
            $column = new TextViewColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ARL field
            //
            $column = new TextViewColumn('ARL', 'ARL', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ValorARL field
            //
            $column = new TextViewColumn('ValorARL', 'ValorARL', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Pensiones field
            //
            $column = new TextViewColumn('Pensiones', 'Pensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for PorcentajeAsumidoPensiones field
            //
            $column = new TextViewColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ValorPensiones field
            //
            $column = new TextViewColumn('ValorPensiones', 'ValorPensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CajaCompensacion field
            //
            $column = new TextViewColumn('CajaCompensacion', 'CajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ValorCajaCompensacion field
            //
            $column = new TextViewColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for HojaDeVida field
            //
            $column = new TextViewColumn('HojaDeVida', 'HojaDeVida', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Clave field
            //
            $column = new TextViewColumn('Clave', 'Clave', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for HV_name field
            //
            $column = new TextViewColumn('HV_name', 'HV Name', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idColaboradores field
            //
            $column = new TextViewColumn('idColaboradores', 'IdColaboradores', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nombre field
            //
            $column = new TextViewColumn('Nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Identificacion field
            //
            $column = new TextViewColumn('Identificacion', 'Identificacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Telefono field
            //
            $column = new TextViewColumn('Telefono', 'Telefono', $this->dataset);
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
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Contacto field
            //
            $column = new TextViewColumn('Contacto', 'Contacto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for NumContacto field
            //
            $column = new TextViewColumn('NumContacto', 'NumContacto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Cargo field
            //
            $column = new TextViewColumn('Cargo', 'Cargo', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for SalarioBasico field
            //
            $column = new TextViewColumn('SalarioBasico', 'SalarioBasico', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for EPS field
            //
            $column = new TextViewColumn('EPS', 'EPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ValorEPS field
            //
            $column = new TextViewColumn('ValorEPS', 'ValorEPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for PorcentajeAsumidoEPS field
            //
            $column = new TextViewColumn('PorcentajeAsumidoEPS', 'PorcentajeAsumidoEPS', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ARL field
            //
            $column = new TextViewColumn('ARL', 'ARL', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ValorARL field
            //
            $column = new TextViewColumn('ValorARL', 'ValorARL', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Pensiones field
            //
            $column = new TextViewColumn('Pensiones', 'Pensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for PorcentajeAsumidoPensiones field
            //
            $column = new TextViewColumn('PorcentajeAsumidoPensiones', 'PorcentajeAsumidoPensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ValorPensiones field
            //
            $column = new TextViewColumn('ValorPensiones', 'ValorPensiones', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for CajaCompensacion field
            //
            $column = new TextViewColumn('CajaCompensacion', 'CajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for ValorCajaCompensacion field
            //
            $column = new TextViewColumn('ValorCajaCompensacion', 'ValorCajaCompensacion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for HojaDeVida field
            //
            $column = new TextViewColumn('HojaDeVida', 'HojaDeVida', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Clave field
            //
            $column = new TextViewColumn('Clave', 'Clave', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for HV_name field
            //
            $column = new TextViewColumn('HV_name', 'HV Name', $this->dataset);
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
            $result = new Grid($this, $this->dataset, 'colaboradoresGrid');
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
            $handler = new ImageHTTPHandler($this->dataset, 'HojaDeVida', 'HojaDeVida_handler_inline_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'HojaDeVida', 'HojaDeVida_handler_inline_insert', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for Clave field
            //
            $column = new TextViewColumn('Clave', 'Clave', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for Clave field
            //
            $editor = new TextEdit('clave_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clave', 'Clave', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for Clave field
            //
            $editor = new TextEdit('clave_edit');
            $editor->SetSize(100);
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Clave', 'Clave', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'Clave_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for HV_name field
            //
            $column = new TextViewColumn('HV_name', 'HV Name', $this->dataset);
            $column->SetOrderable(true);
            
            /* <inline edit column> */
            //
            // Edit column for HV_name field
            //
            $editor = new TextAreaEdit('hv_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('HV Name', 'HV_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetEditOperationColumn($editColumn);
            /* </inline edit column> */
            
            /* <inline insert column> */
            //
            // Edit column for HV_name field
            //
            $editor = new TextAreaEdit('hv_name_edit', 50, 8);
            $editColumn = new CustomEditColumn('HV Name', 'HV_name', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $this->RenderText($editColumn->GetCaption())));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $column->SetInsertOperationColumn($editColumn);
            /* </inline insert column> */
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'HV_name_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);//
            // View column for Clave field
            //
            $column = new TextViewColumn('Clave', 'Clave', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'Clave_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            //
            // View column for HV_name field
            //
            $column = new TextViewColumn('HV_name', 'HV Name', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'HV_name_handler', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            $handler = new ImageHTTPHandler($this->dataset, 'HojaDeVida', 'HojaDeVida_handler_edit', new NullFilter());
            GetApplication()->RegisterHTTPHandler($handler);
            $handler = new ImageHTTPHandler($this->dataset, 'HojaDeVida', 'HojaDeVida_handler_insert', new NullFilter());
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
        $Page = new colaboradoresPage("colaboradoresact.php", "colaboradores", GetCurrentUserGrantForDataSource("colaboradores"), 'UTF-8');
        $Page->SetShortCaption('Colaboradores');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetCaption('Colaboradores');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("colaboradores"));
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
	
