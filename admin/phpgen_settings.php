<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/New_York');

function GetGlobalConnectionOptions()
{
    return array(
  'server' => 'localhost',
  'port' => '3306',
  'username' => 'root',
  'password' => 'pirlo1985',
  'database' => 'softcontech_v5'
);
}

function HasAdminPage()
{
    return false;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Activos', 'short_caption' => 'Activos', 'filename' => 'activos.php', 'name' => 'activos');
    $result[] = array('caption' => 'Act Movimientos', 'short_caption' => 'Act Movimientos', 'filename' => 'act_movimientos.php', 'name' => 'act_movimientos');
    $result[] = array('caption' => 'Act Ordenes', 'short_caption' => 'Act Ordenes', 'filename' => 'act_ordenes.php', 'name' => 'act_ordenes');
    $result[] = array('caption' => 'Bodega', 'short_caption' => 'Bodega', 'filename' => 'bodega.php', 'name' => 'bodega');
    $result[] = array('caption' => 'Cartera', 'short_caption' => 'Cartera', 'filename' => 'cartera.php', 'name' => 'cartera');
    $result[] = array('caption' => 'Ciuu', 'short_caption' => 'Ciuu', 'filename' => 'ciuu.php', 'name' => 'ciuu');
    $result[] = array('caption' => 'Clasecuenta', 'short_caption' => 'Clasecuenta', 'filename' => 'clasecuenta.php', 'name' => 'clasecuenta');
    $result[] = array('caption' => 'Clientes', 'short_caption' => 'Clientes', 'filename' => 'clientes.php', 'name' => 'clientes');
    $result[] = array('caption' => 'Cod Departamentos', 'short_caption' => 'Cod Departamentos', 'filename' => 'cod_departamentos.php', 'name' => 'cod_departamentos');
    $result[] = array('caption' => 'Cod Documentos', 'short_caption' => 'Cod Documentos', 'filename' => 'cod_documentos.php', 'name' => 'cod_documentos');
    $result[] = array('caption' => 'Cod Municipios Dptos', 'short_caption' => 'Cod Municipios Dptos', 'filename' => 'cod_municipios_dptos.php', 'name' => 'cod_municipios_dptos');
    $result[] = array('caption' => 'Cod Paises', 'short_caption' => 'Cod Paises', 'filename' => 'cod_paises.php', 'name' => 'cod_paises');
    $result[] = array('caption' => 'Col Registrohoras', 'short_caption' => 'Col Registrohoras', 'filename' => 'col_registrohoras.php', 'name' => 'col_registrohoras');
    $result[] = array('caption' => 'Colaboradores', 'short_caption' => 'Colaboradores', 'filename' => 'colaboradoresact.php', 'name' => 'colaboradores');
    $result[] = array('caption' => 'Comisiones', 'short_caption' => 'Comisiones', 'filename' => 'comisiones.php', 'name' => 'comisiones');
    $result[] = array('caption' => 'Comisionesporventas', 'short_caption' => 'Comisionesporventas', 'filename' => 'comisionesporventas.php', 'name' => 'comisionesporventas');
    $result[] = array('caption' => 'Compras', 'short_caption' => 'Compras', 'filename' => 'compras.php', 'name' => 'compras');
    $result[] = array('caption' => 'Cotizaciones', 'short_caption' => 'Cotizaciones', 'filename' => 'cotizaciones.php', 'name' => 'cotizaciones');
    $result[] = array('caption' => 'Cuentas', 'short_caption' => 'Cuentas', 'filename' => 'cuentas.php', 'name' => 'cuentas');
    $result[] = array('caption' => 'Cuentasfrecuentes', 'short_caption' => 'Cuentasfrecuentes', 'filename' => 'cuentasfrecuentes.php', 'name' => 'cuentasfrecuentes');
    $result[] = array('caption' => 'Devolucionesventas', 'short_caption' => 'Devolucionesventas', 'filename' => 'devolucionesventas.php', 'name' => 'devolucionesventas');
    $result[] = array('caption' => 'Egresos', 'short_caption' => 'Egresos', 'filename' => 'egresos.php', 'name' => 'egresos');
    $result[] = array('caption' => 'Empresapro', 'short_caption' => 'Empresapro', 'filename' => 'empresapro.php', 'name' => 'empresapro');
    $result[] = array('caption' => 'Facturas', 'short_caption' => 'Facturas', 'filename' => 'facturas.php', 'name' => 'facturas');
    $result[] = array('caption' => 'Facturas Abonos', 'short_caption' => 'Facturas Abonos', 'filename' => 'facturas_abonos.php', 'name' => 'facturas_abonos');
    $result[] = array('caption' => 'Facturas Autoretenciones', 'short_caption' => 'Facturas Autoretenciones', 'filename' => 'facturas_autoretenciones.php', 'name' => 'facturas_autoretenciones');
    $result[] = array('caption' => 'Facturas Reten Aplicadas', 'short_caption' => 'Facturas Reten Aplicadas', 'filename' => 'facturas_reten_aplicadas.php', 'name' => 'facturas_reten_aplicadas');
    $result[] = array('caption' => 'Fechas Descuentos', 'short_caption' => 'Fechas Descuentos', 'filename' => 'fechas_descuentos.php', 'name' => 'fechas_descuentos');
    $result[] = array('caption' => 'Gupocuentas', 'short_caption' => 'Gupocuentas', 'filename' => 'gupocuentas.php', 'name' => 'gupocuentas');
    $result[] = array('caption' => 'Impret', 'short_caption' => 'Impret', 'filename' => 'impret.php', 'name' => 'impret');
    $result[] = array('caption' => 'Ingresos', 'short_caption' => 'Ingresos', 'filename' => 'ingresos.php', 'name' => 'ingresos');
    $result[] = array('caption' => 'Ingresosvarios', 'short_caption' => 'Ingresosvarios', 'filename' => 'ingresosvarios.php', 'name' => 'ingresosvarios');
    $result[] = array('caption' => 'Kardexmercancias', 'short_caption' => 'Kardexmercancias', 'filename' => 'kardexmercancias.php', 'name' => 'kardexmercancias');
    $result[] = array('caption' => 'Librodiario', 'short_caption' => 'Librodiario', 'filename' => 'librodiario.php', 'name' => 'librodiario');
    $result[] = array('caption' => 'Libromayorbalances', 'short_caption' => 'Libromayorbalances', 'filename' => 'libromayorbalances.php', 'name' => 'libromayorbalances');
    $result[] = array('caption' => 'Prod Bajas', 'short_caption' => 'Prod Bajas', 'filename' => 'prod_bajas.php', 'name' => 'prod_bajas');
    $result[] = array('caption' => 'Prod Codbarras', 'short_caption' => 'Prod Codbarras', 'filename' => 'prod_codbarras.php', 'name' => 'prod_codbarras');
    $result[] = array('caption' => 'Prod Departamentos', 'short_caption' => 'Prod Departamentos', 'filename' => 'prod_departamentos.php', 'name' => 'prod_departamentos');
    $result[] = array('caption' => 'Prod Sub1', 'short_caption' => 'Prod Sub1', 'filename' => 'prod_sub1.php', 'name' => 'prod_sub1');
    $result[] = array('caption' => 'Prod Sub2', 'short_caption' => 'Prod Sub2', 'filename' => 'prod_sub2.php', 'name' => 'prod_sub2');
    $result[] = array('caption' => 'Prod Sub3', 'short_caption' => 'Prod Sub3', 'filename' => 'prod_sub3.php', 'name' => 'prod_sub3');
    $result[] = array('caption' => 'Prod Sub4', 'short_caption' => 'Prod Sub4', 'filename' => 'prod_sub4.php', 'name' => 'prod_sub4');
    $result[] = array('caption' => 'Prod Sub5', 'short_caption' => 'Prod Sub5', 'filename' => 'prod_sub5.php', 'name' => 'prod_sub5');
    $result[] = array('caption' => 'Prod Sub6', 'short_caption' => 'Prod Sub6', 'filename' => 'prod_sub6.php', 'name' => 'prod_sub6');
    $result[] = array('caption' => 'Productosventa', 'short_caption' => 'Productosventa', 'filename' => 'productosventa.php', 'name' => 'productosventa');
    $result[] = array('caption' => 'Proveedores', 'short_caption' => 'Proveedores', 'filename' => 'proveedores.php', 'name' => 'proveedores');
    $result[] = array('caption' => 'Relacioncompras', 'short_caption' => 'Relacioncompras', 'filename' => 'relacioncompras.php', 'name' => 'relacioncompras');
    $result[] = array('caption' => 'Remisiones', 'short_caption' => 'Remisiones', 'filename' => 'remisiones.php', 'name' => 'remisiones');
    $result[] = array('caption' => 'Servicios', 'short_caption' => 'Servicios', 'filename' => 'servicios.php', 'name' => 'servicios');
    $result[] = array('caption' => 'Subcuentas', 'short_caption' => 'Subcuentas', 'filename' => 'subcuentas.php', 'name' => 'subcuentas');
    $result[] = array('caption' => 'Usuarios', 'short_caption' => 'Usuarios', 'filename' => 'usuarios.php', 'name' => 'usuarios');
    $result[] = array('caption' => 'Usuarios Ip', 'short_caption' => 'Usuarios Ip', 'filename' => 'usuarios_ip.php', 'name' => 'usuarios_ip');
    $result[] = array('caption' => 'Usuarios Keys', 'short_caption' => 'Usuarios Keys', 'filename' => 'usuarios_keys.php', 'name' => 'usuarios_keys');
    $result[] = array('caption' => 'Ventas Devoluciones', 'short_caption' => 'Ventas Devoluciones', 'filename' => 'ventas_devoluciones.php', 'name' => 'ventas_devoluciones');
    return $result;
}

function GetPagesHeader()
{
    return
    'SOFTCONTECH';
}

function GetPagesFooter()
{
    return
        'TECHNO SOLUCIONES SAS, www.technosoluciones.com, info@technosoluciones.com'; 
    }

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(true);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
}

/*
  Default code page: 1252
*/
function GetAnsiEncoding() { return 'windows-1252'; }

function Global_BeforeUpdateHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeDeleteHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function Global_BeforeInsertHandler($page, $rowData, &$cancel, &$message, $tableName)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetEnableLessFilesRunTimeCompilation()
{
    return false;
}



?>