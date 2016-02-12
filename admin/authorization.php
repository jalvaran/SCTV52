<?php

require_once 'phpgen_settings.php';
require_once 'components/security/security_info.php';
require_once 'components/security/datasource_security_info.php';
require_once 'components/security/tablebased_auth.php';
require_once 'components/security/user_grants_manager.php';
require_once 'components/security/table_based_user_grants_manager.php';

require_once 'database_engine/mysql_engine.php';

$grants = array('guest' => 
        array()
    ,
    'defaultUser' => 
        array('activos' => new DataSourceSecurityInfo(false, false, false, false),
        'activos.act_movimientos' => new DataSourceSecurityInfo(false, false, false, false),
        'act_movimientos' => new DataSourceSecurityInfo(false, false, false, false),
        'act_ordenes' => new DataSourceSecurityInfo(false, false, false, false),
        'bodega' => new DataSourceSecurityInfo(false, false, false, false),
        'cartera' => new DataSourceSecurityInfo(false, false, false, false),
        'ciuu' => new DataSourceSecurityInfo(false, false, false, false),
        'clasecuenta' => new DataSourceSecurityInfo(false, false, false, false),
        'clientes' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_departamentos' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_documentos' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_municipios_dptos' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_paises' => new DataSourceSecurityInfo(false, false, false, false),
        'col_registrohoras' => new DataSourceSecurityInfo(false, false, false, false),
        'colaboradores' => new DataSourceSecurityInfo(false, false, false, false),
        'comisiones' => new DataSourceSecurityInfo(false, false, false, false),
        'comisionesporventas' => new DataSourceSecurityInfo(false, false, false, false),
        'compras' => new DataSourceSecurityInfo(false, false, false, false),
        'cotizaciones' => new DataSourceSecurityInfo(false, false, false, false),
        'cuentas' => new DataSourceSecurityInfo(false, false, false, false),
        'cuentasfrecuentes' => new DataSourceSecurityInfo(false, false, false, false),
        'devolucionesventas' => new DataSourceSecurityInfo(false, false, false, false),
        'egresos' => new DataSourceSecurityInfo(false, false, false, false),
        'empresapro' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas.facturas_abonos' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas_abonos' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas_autoretenciones' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas_reten_aplicadas' => new DataSourceSecurityInfo(false, false, false, false),
        'fechas_descuentos' => new DataSourceSecurityInfo(false, false, false, false),
        'gupocuentas' => new DataSourceSecurityInfo(false, false, false, false),
        'impret' => new DataSourceSecurityInfo(false, false, false, false),
        'ingresos' => new DataSourceSecurityInfo(false, false, false, false),
        'ingresosvarios' => new DataSourceSecurityInfo(false, false, false, false),
        'kardexmercancias' => new DataSourceSecurityInfo(false, false, false, false),
        'librodiario' => new DataSourceSecurityInfo(false, false, false, false),
        'libromayorbalances' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_bajas' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_codbarras' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_departamentos' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub1' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub2' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub3' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub4' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub5' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub6' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa.kardexmercancias' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa.relacioncompras' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa.prod_codbarras' => new DataSourceSecurityInfo(false, false, false, false),
        'proveedores' => new DataSourceSecurityInfo(false, false, false, false),
        'relacioncompras' => new DataSourceSecurityInfo(false, false, false, false),
        'remisiones' => new DataSourceSecurityInfo(false, false, false, false),
        'servicios' => new DataSourceSecurityInfo(false, false, false, false),
        'subcuentas' => new DataSourceSecurityInfo(false, false, false, false),
        'usuarios' => new DataSourceSecurityInfo(false, false, false, false),
        'usuarios_ip' => new DataSourceSecurityInfo(false, false, false, false),
        'usuarios_keys' => new DataSourceSecurityInfo(false, false, false, false),
        'ventas_devoluciones' => new DataSourceSecurityInfo(false, false, false, false))
    ,
    'admin' => 
        array('activos' => new DataSourceSecurityInfo(false, false, false, false),
        'activos.act_movimientos' => new DataSourceSecurityInfo(false, false, false, false),
        'act_movimientos' => new DataSourceSecurityInfo(false, false, false, false),
        'act_ordenes' => new DataSourceSecurityInfo(false, false, false, false),
        'bodega' => new DataSourceSecurityInfo(false, false, false, false),
        'cartera' => new DataSourceSecurityInfo(false, false, false, false),
        'ciuu' => new DataSourceSecurityInfo(false, false, false, false),
        'clasecuenta' => new DataSourceSecurityInfo(false, false, false, false),
        'clientes' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_departamentos' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_documentos' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_municipios_dptos' => new DataSourceSecurityInfo(false, false, false, false),
        'cod_paises' => new DataSourceSecurityInfo(false, false, false, false),
        'col_registrohoras' => new DataSourceSecurityInfo(false, false, false, false),
        'colaboradores' => new DataSourceSecurityInfo(false, false, false, false),
        'comisiones' => new DataSourceSecurityInfo(false, false, false, false),
        'comisionesporventas' => new DataSourceSecurityInfo(false, false, false, false),
        'compras' => new DataSourceSecurityInfo(false, false, false, false),
        'cotizaciones' => new DataSourceSecurityInfo(false, false, false, false),
        'cuentas' => new DataSourceSecurityInfo(false, false, false, false),
        'cuentasfrecuentes' => new DataSourceSecurityInfo(false, false, false, false),
        'devolucionesventas' => new DataSourceSecurityInfo(false, false, false, false),
        'egresos' => new DataSourceSecurityInfo(false, false, false, false),
        'empresapro' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas.facturas_abonos' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas_abonos' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas_autoretenciones' => new DataSourceSecurityInfo(false, false, false, false),
        'facturas_reten_aplicadas' => new DataSourceSecurityInfo(false, false, false, false),
        'fechas_descuentos' => new DataSourceSecurityInfo(false, false, false, false),
        'gupocuentas' => new DataSourceSecurityInfo(false, false, false, false),
        'impret' => new DataSourceSecurityInfo(false, false, false, false),
        'ingresos' => new DataSourceSecurityInfo(false, false, false, false),
        'ingresosvarios' => new DataSourceSecurityInfo(false, false, false, false),
        'kardexmercancias' => new DataSourceSecurityInfo(false, false, false, false),
        'librodiario' => new DataSourceSecurityInfo(false, false, false, false),
        'libromayorbalances' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_bajas' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_codbarras' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_departamentos' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub1' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub2' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub3' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub4' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub5' => new DataSourceSecurityInfo(false, false, false, false),
        'prod_sub6' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa.kardexmercancias' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa.relacioncompras' => new DataSourceSecurityInfo(false, false, false, false),
        'productosventa.prod_codbarras' => new DataSourceSecurityInfo(false, false, false, false),
        'proveedores' => new DataSourceSecurityInfo(false, false, false, false),
        'relacioncompras' => new DataSourceSecurityInfo(false, false, false, false),
        'remisiones' => new DataSourceSecurityInfo(false, false, false, false),
        'servicios' => new DataSourceSecurityInfo(false, false, false, false),
        'subcuentas' => new DataSourceSecurityInfo(false, false, false, false),
        'usuarios' => new DataSourceSecurityInfo(false, false, false, false),
        'usuarios_ip' => new DataSourceSecurityInfo(false, false, false, false),
        'usuarios_keys' => new DataSourceSecurityInfo(false, false, false, false),
        'ventas_devoluciones' => new DataSourceSecurityInfo(false, false, false, false))
    );

$appGrants = array('guest' => new DataSourceSecurityInfo(false, false, false, false),
    'defaultUser' => new AdminDataSourceSecurityInfo(),
    'admin' => new AdminDataSourceSecurityInfo());

$dataSourceRecordPermissions = array();

$tableCaptions = array('activos' => 'Activos',
'activos.act_movimientos' => 'Activos.Act Movimientos',
'act_movimientos' => 'Act Movimientos',
'act_ordenes' => 'Act Ordenes',
'bodega' => 'Bodega',
'cartera' => 'Cartera',
'ciuu' => 'Ciuu',
'clasecuenta' => 'Clasecuenta',
'clientes' => 'Clientes',
'cod_departamentos' => 'Cod Departamentos',
'cod_documentos' => 'Cod Documentos',
'cod_municipios_dptos' => 'Cod Municipios Dptos',
'cod_paises' => 'Cod Paises',
'col_registrohoras' => 'Col Registrohoras',
'colaboradores' => 'Colaboradores',
'comisiones' => 'Comisiones',
'comisionesporventas' => 'Comisionesporventas',
'compras' => 'Compras',
'cotizaciones' => 'Cotizaciones',
'cuentas' => 'Cuentas',
'cuentasfrecuentes' => 'Cuentasfrecuentes',
'devolucionesventas' => 'Devolucionesventas',
'egresos' => 'Egresos',
'empresapro' => 'Empresapro',
'facturas' => 'Facturas',
'facturas.facturas_abonos' => 'Facturas.Facturas Abonos',
'facturas_abonos' => 'Facturas Abonos',
'facturas_autoretenciones' => 'Facturas Autoretenciones',
'facturas_reten_aplicadas' => 'Facturas Reten Aplicadas',
'fechas_descuentos' => 'Fechas Descuentos',
'gupocuentas' => 'Gupocuentas',
'impret' => 'Impret',
'ingresos' => 'Ingresos',
'ingresosvarios' => 'Ingresosvarios',
'kardexmercancias' => 'Kardexmercancias',
'librodiario' => 'Librodiario',
'libromayorbalances' => 'Libromayorbalances',
'prod_bajas' => 'Prod Bajas',
'prod_codbarras' => 'Prod Codbarras',
'prod_departamentos' => 'Prod Departamentos',
'prod_sub1' => 'Prod Sub1',
'prod_sub2' => 'Prod Sub2',
'prod_sub3' => 'Prod Sub3',
'prod_sub4' => 'Prod Sub4',
'prod_sub5' => 'Prod Sub5',
'prod_sub6' => 'Prod Sub6',
'productosventa' => 'Productosventa',
'productosventa.kardexmercancias' => 'Productosventa.Kardexmercancias',
'productosventa.relacioncompras' => 'Productosventa.Relacioncompras',
'productosventa.prod_codbarras' => 'Productosventa.Prod Codbarras',
'proveedores' => 'Proveedores',
'relacioncompras' => 'Relacioncompras',
'remisiones' => 'Remisiones',
'servicios' => 'Servicios',
'subcuentas' => 'Subcuentas',
'usuarios' => 'Usuarios',
'usuarios_ip' => 'Usuarios Ip',
'usuarios_keys' => 'Usuarios Keys',
'ventas_devoluciones' => 'Ventas Devoluciones');

function CreateTableBasedGrantsManager()
{
    return null;
}

function SetUpUserAuthorization()
{
    global $grants;
    global $appGrants;
    global $dataSourceRecordPermissions;
    $hardCodedGrantsManager = new HardCodedUserGrantsManager($grants, $appGrants);
$tableBasedGrantsManager = CreateTableBasedGrantsManager();
$grantsManager = new CompositeGrantsManager();
$grantsManager->AddGrantsManager($hardCodedGrantsManager);
if (!is_null($tableBasedGrantsManager)) {
    $grantsManager->AddGrantsManager($tableBasedGrantsManager);
    GetApplication()->SetUserManager($tableBasedGrantsManager);
}
$userAuthorizationStrategy = new TableBasedUserAuthorization(new MyConnectionFactory(), GetGlobalConnectionOptions(), 'usuarios', 'Login', 'Login', $grantsManager);
    GetApplication()->SetUserAuthorizationStrategy($userAuthorizationStrategy);

GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(
    new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}

function GetIdentityCheckStrategy()
{
    return new TableBasedIdentityCheckStrategy(new MyConnectionFactory(), GetGlobalConnectionOptions(), 'usuarios', 'Login', 'Password', '');
}

function CanUserChangeOwnPassword()
{
    return false;
}

?>