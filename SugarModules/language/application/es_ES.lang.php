 <?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2007 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

$app_list_strings["moduleList"]["oqc_ExternalContractCosts"] = 'Costes de Contrato Externo';
$app_list_strings["moduleList"]["oqc_ExternalContractDetailedCosts"] = 'Costes Detallados de Contrato Externo'; // 1.7.5 fixes bug in Roles table
$app_list_strings["moduleList"]["oqc_ExternalContractPositions"] = 'Puestos de Trabajo de Contrato Externo';
$app_list_strings["moduleList"]["oqc_ExternalContract"] = 'Contrato Externo';
$app_list_strings["moduleList"]["oqc_ArchivedExternalContract"] = 'Archivo de Contrato';
$app_list_strings["moduleList"]["oqc_Offering"] = 'Ofertas';
$app_list_strings["moduleList"]["oqc_ServiceRecording"] = 'Registro de Servicio';
$app_list_strings["moduleList"]["oqc_Category"] = 'Categorias';
$app_list_strings["moduleList"]["oqc_Product"] = 'Productos';
$app_list_strings["moduleList"]["oqc_Contract"] = 'Contratos';
$app_list_strings["moduleList"]["oqc_Service"] = 'Servicios';
$app_list_strings["moduleList"]["oqc_EditedTextBlock"] = 'Parrafos Editados';
$app_list_strings["moduleList"]["oqc_TextBlock"] = 'Parrafos';
$app_list_strings["moduleList"]["oqc_Addition"] = 'Ampliaciones';
$app_list_strings["moduleList"]["oqc_ProductCatalog"] = 'Catalogo de Productos';
$app_list_strings["moduleList"]["oqc_Task"] = 'Tarea de Equipo';
$app_list_strings["oqc"]["months"] = array(
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo', 
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio', 
        7 => 'Julio', 
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',       
        12 => 'Diciembre'
);
$app_list_strings["oqc"]["common"]["new"] = "Nuevo";
$app_list_strings["oqc"]["common"]["cancel"] = "Cancelar";
$app_list_strings["oqc"]["common"]["showReports"] = "Mostrar Informes";
$app_list_strings["oqc"]["common"]["delete"] = "Borrar";
$app_list_strings["oqc"]["common"]["select"] = "Seleccionar";
$app_list_strings["oqc"]["common"]["contract_number"] = "Numero Contrato";
$app_list_strings["oqc"]["common"]["name"] = "Nombre";
$app_list_strings["oqc"]["common"]["quantity"] = "Cantidad";
$app_list_strings["oqc"]["common"]["price"] = "Precio";
$app_list_strings["oqc"]["common"]["sum"] = "Suma";
$app_list_strings["oqc"]["common"]["description"] = "Descripcion";
$app_list_strings["oqc"]["common"]["payment"] = "Pago";
$app_list_strings["oqc"]["common"]["year"] = "Ano";
$app_list_strings["oqc"]["common"]["type"] = "Tipo";
$app_list_strings["oqc"]["common"]["in"] = "en";        	// following for lines are for the 
$app_list_strings["oqc"]["common"]["for"] = "para";		// 
$app_list_strings["oqc"]["common"]["until"] = "hasta";		// "sum in \euro 1.1.08 until 1.1.09 for 12 months" line
$app_list_strings["oqc"]["common"]["months"] = "mes(es)";	// in the latex template
$app_list_strings["oqc"]["ExternalContracts"]["infinityHint"] = "<h2>Note</h2>Ha seleccionado <em>infinito</em> como fin de contrato. El contrato seguira hasta que lo cancele. La tabla de costes muestra los costes esperados para los cuatros proximos anos.";
$app_list_strings["oqc"]["Email"]["subject"] = "Notificacion de Finalizacion de Contratos de SugarCRM";
$app_list_strings["oqc"]["Email"]["hello"] = "Hola %s,<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["greetings"] = "<br />\nSaludos cordiales, SugarCRM :-)";
$app_list_strings["oqc"]["Email"]["introduction"] = "los siguientes contratos externos se acaban pronto:<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["notificationLine"] = "En %s termina \"%s\", <a href='%s'>ver enlace</a>.<br />\n";
$app_list_strings["oqc"]["pdf"]["contract"]["title"] = "Contrato";
$app_list_strings["oqc"]["pdf"]["contract"]["titleServices"] = "Servicios y Documentacion";
$app_list_strings["oqc"]["pdf"]["contract"]["preamble"] = "Preambulo"; // the preamble title 
$app_list_strings["oqc"]["pdf"]["contract"]["preambleText"] = "inserta tu preambulo aqui"; // the actual preamble paragraph
$app_list_strings["oqc"]["pdf"]["contract"]["textblocksIntro"] = "Clientes y compania acuerdan las siguientes normas."; // the text above the textblocks
$app_list_strings["oqc"]["pdf"]["contract"]["startDate"] = "Fecha Inicio";
$app_list_strings["oqc"]["pdf"]["contract"]["endDate"] = "Fecha Fin";
$app_list_strings["oqc"]["pdf"]["contract"]["deadline"] = "Fecha Tope";
$app_list_strings["oqc"]["pdf"]["contract"]["periodOfNotice"] = "Plazo de preaviso";
$app_list_strings["oqc"]["pdf"]["contract"]["quote_title"] = "Cita";
$app_list_strings["oqc"]["pdf"]["contract"]["addition_title"] = "Ampliacion";

$app_list_strings["oqc"]["pdf"]["catalog"]["title"] = "Catalogo de Producto";
$app_list_strings["oqc"]["pdf"]["catalog"]["publisherTitle"] = "Editor";
$app_list_strings["oqc"]["pdf"]["catalog"]["services"] = "Productos";
$app_list_strings["oqc"]["pdf"]["catalog"]["prices"] = "Precios";
$app_list_strings["oqc"]["pdf"]["catalog"]["price"] = "Precio";
$app_list_strings["oqc"]["pdf"]["catalog"]["unit"] = "Unidad/Frecuencia";
$app_list_strings["oqc"]["pdf"]["catalog"]["position"] = "Trabajo";
$app_list_strings["oqc"]["pdf"]["catalog"]["validityTitle"] = "Validez";
$app_list_strings["oqc"]["pdf"]["catalog"]["imageAppendixTitle"] = "Imagen Anexada";
$app_list_strings["oqc"]["pdf"]["catalog"]["contactTitle"] = "Tu contacto";

$app_list_strings["oqc"]["pdf"]["common"]["filenamePrefixCatalog"] = "Catalogo";
$app_list_strings["oqc"]["pdf"]["common"]["seeFigure"] = "ver figura";
$app_list_strings["oqc"]["pdf"]["common"]["onPage"] = "en pagina";
$app_list_strings["oqc"]["pdf"]["common"]["createdOn"] = "Creado en";
$app_list_strings["oqc"]["pdf"]["common"]["customer"] = "Cliente"; // your customer
$app_list_strings["oqc"]["pdf"]["common"]["company"] = "Compania"; // your company
$app_list_strings["oqc"]["Services"]["selectImage"] = "Seleccionar otro fichero para reemplazar la imagen actual:";
$app_list_strings["oqc"]["Services"]["currentImage"] = "Imagen actual";
$app_list_strings["oqc"]["Services"]["unit"] = "Unidad";
$app_list_strings["oqc"]["Services"]["description"] = "Descripcion";
$app_list_strings["oqc"]["Services"]["name"] = "Nombre";
$app_list_strings["oqc"]["Services"]["quantity"] = "Cantidad";
$app_list_strings["oqc"]["Services"]["price"] = "Precio lista";
$app_list_strings["oqc"]["Services"]["discount"] = "Descuento";
$app_list_strings["oqc"]["Services"]["discountPrice"] = "Precio";
$app_list_strings["oqc"]["Services"]["vat"] = "IVA";
$app_list_strings["oqc"]["Services"]["vat_default"] = "Valor IVA defecto";
$app_list_strings["oqc"]["Services"]["vat_legacy"] = "Valor IVA repercutido";
$app_list_strings["oqc"]["Services"]["oqc_position"] = "NO";
$app_list_strings["oqc"]["Services"]["sum"] = "Suma";
$app_list_strings["oqc"]["Services"]["gross"] = "Bruto";
$app_list_strings["oqc"]["Services"]["net"] = "Neto";
$app_list_strings["oqc"]["Services"]["netTotal"] = "Neto Total:";
$app_list_strings["oqc"]["Services"]["grandTotal"] = "Cantidad Total:";
$app_list_strings["oqc"]["Services"]["onceTableTitle"] = "Lista de Productos";
$app_list_strings["oqc"]["Services"]["ongoingTableTitle"] = "Lista Gastos Corrientes";
$app_list_strings["oqc"]["Services"]["defaultDescription"] = "Descripcion Producto";
$app_list_strings["oqc"]["Services"]["totalNegotiatedPrice"] = "Precio Total negociado";
$app_list_strings["oqc"]["Services"]["add"] = "Anadir Producto Estandar";
$app_list_strings["oqc"]["Services"]["addRecurring"] = "Anadir Gastos Corrientes";
$app_list_strings["oqc"]["Services"]["addCustom"] = "Anadir Producto Cliente";
$app_list_strings["oqc"]["Services"]["addCustomService"] = "Anadir Gasto Cliente";
$app_list_strings["oqc"]["Services"]["addDefaultLines"] = "Anadir Elementos Defecto";
$app_list_strings["oqc"]["Services"]["delete"] = "Borrar";
$app_list_strings["oqc"]["Services"]["cst_delete"] = "Borrar";
$app_list_strings["oqc"]["Services"]["updatedVersionAvailable"] = "actualizable";
$app_list_strings["oqc"]["Services"]["updateAll"] = "Actualizar Todo";
$app_list_strings["oqc"]["Services"]["from"] = "de";
$app_list_strings["oqc"]["Services"]["to"] = "a";
$app_list_strings["oqc"]["Services"]["confirmDelete"] = "Realmente quiere borrar este producto?";
$app_list_strings["oqc"]["Services"]["confirmUpdate"] = "Realmente quiere actualizar este producto?";
$app_list_strings["oqc"]["Services"]["confirmUpdateAll"] = "Realmente quiere actualizar todos los productos?";
$app_list_strings["oqc"]["Services"]["months"] = "mes(es)";
$app_list_strings["oqc"]["Services"]["ongoingSum"] = "Suma para un periodo de %d meses (de %s a %s)";
$app_list_strings["oqc"]["Services"]["discountUnits"] = "%or$";
$app_list_strings["oqc"]["Services"]["updateProduct"] = "Si";
$app_list_strings["oqc"]["Services"]["donotupdateProduct"] = "No";
$app_list_strings["oqc"]["Services"]["update"] = "Actualizar";
$app_list_strings["oqc"]["Services"]["addOption"] = "Anadir Opcion";
$app_list_strings["oqc"]["Services"]["action"] = "Accion";
$app_list_strings["oqc"]["Services"]["imageHint"] = "Las imagenes mostradas se redimensionaran a 700 px ancho (requiere tener instalada extension GD) <br>Soportadas imagenes tipo .jpg, .png, .gif";
$app_list_strings["oqc"]["Services"]["update_file_confirm"] = "Actualizar Fichero de Descripcion Tecnica de Producto: ";
$app_list_strings["oqc"]["Services"]["zeitbezug"] = "Frecuencia";
$app_list_strings["oqc"]["Documents"]["fileSelectionHint"] = "<small>Has seleccionado ficheros de %s.</small>";
$app_list_strings["oqc"]["Documents"]["popupTitle"] = "Por favor selecciona un fichero";
$app_list_strings["oqc"]["Documents"]["title"] = '<h1 style="margin-bottom: 10px;">Por favor selecciona un fichero:</h1>';
$app_list_strings["oqc"]["Documents"]["fileNotExists"] = '<span style="margin-left: 5px; color:red; font-weight: bold;">El fichero no existe.</span>';
$app_list_strings["oqc"]["Textblocks"]["delete"] = "Borrar";
$app_list_strings["oqc"]["Textblocks"]["freeText"] = "Entre su texto aqui:";
$app_list_strings["oqc"]["Textblocks"]["addTemplate"] = "Anadir Plantilla";
$app_list_strings["oqc"]["Textblocks"]["addDefaultTemplates"] = "Anadir Plantillas por defecto";
$app_list_strings["oqc"]["Textblocks"]["dragdrop"] = "Usar cabecera para Arrastrar";
$app_list_strings["oqc"]["Attachments"]["add"] = "Anadir Adjunto";
$app_list_strings["oqc"]["Attachments"]["addDefault"] = "Anadir Adjunto(s) por defecto";
$app_list_strings["oqc"]["Attachments"]["createNew"] = "Crear Nuevo Adjunto";
$app_list_strings["oqc"]["Attachments"]["delete"] = "Borrar";
$app_list_strings["oqc"]["Attachments"]["default"] = "defecto";
$app_list_strings["oqc"]["Attachments"]["upload"] = "Subir Nueva Revision";
$app_list_strings["oqc"]["ProductCatalog"]["addCategory"] = "Anadir";
$app_list_strings["oqc"]["ProductCatalog"]["saveCategory"] = "Guardar";
$app_list_strings["oqc"]["ProductCatalog"]["deleteCategory"] = "Borrar";
$app_list_strings["oqc"]["ProductCatalog"]["categoryTree"] = "Arbol de Categorias"; //1.7.5 addition
$app_list_strings["oqc"]["ProductCatalog"]["confirmDelete"] = "Quiere borrar la categoria seleccionada y todos sus productos y subcategorias?";
$app_list_strings["oqc"]["ProductCatalog"]["navigationHint"] = "- Sus cambios se grabaron actuamaticamente.<br />- Use las flechas para navegar por las categorias.<br />- Pulse F2 para editar las categorias seleccionadas.<br />";
$app_list_strings["oqc"]["ProductOptions"]["add"] = "Anadir Opcion";
$app_list_strings["oqc"]["ProductOptions"]["createNew"] = "Crear Nuevo Adjunto";
$app_list_strings["oqc"]["ProductOptions"]["delete"] = "Borrar";

$app_list_strings["oqc_externalcontract_type_dom"] = array (
  'Administration' => 'Administracion',
  'Product' => 'Producto',
  'User' => 'Usuario',
);
$app_list_strings["oqc_externalcontract_status_dom"] = array (
  'New' => 'Nuevo',
  'Assigned' => 'Asignado',
  'Closed' => 'Cerrado',
  'Pending Input' => 'Entrada pendiente',
  'Rejected' => 'Rechazado',
  'Duplicate' => 'Duplicado',
);
$app_list_strings["oqc_externalcontract_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Medio',
  'P3' => 'Bajo',
);
$app_list_strings["oqc_externalcontract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceptado',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Cerrado',
  'Out of Date' => 'Caducado',
  'Invalid' => 'Invalido',
);


$app_list_strings["oqc_productcatalog_type_dom"] = array (
  'Administration' => 'Administracion',
  'Product' => 'Producto',
  'User' => 'Usuario',
);
$app_list_strings["oqc_productcatalog_status_dom"] = array (
  'New' => 'Nuevo',
  'Assigned' => 'Asignado',
  'Closed' => 'Cerrado',
  'Pending Input' => 'Entrada pendiente',
  'Rejected' => 'Rechazado',
  'Duplicate' => 'Duplicado',
);
$app_list_strings["oqc_productcatalog_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Medio',
  'P3' => 'Bajo',
);
$app_list_strings["oqc_productcatalog_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceptado',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Cerrado',
  'Out of Date' => 'Caducado',
  'Invalid' => 'Invalido',
);

$app_list_strings["oqc_product_type_dom"] = array (
  'Administration' => 'Administracion',
  'Product' => 'Producto',
  'User' => 'Usuario',
);
$app_list_strings["oqc_product_status_list"] = array (
  'New' => 'Nuevo',
  'Assigned' => 'Asignado',
  'Closed' => 'Cerrado',
  'Pending Input' => 'Entrada pendiente',
  'Rejected' => 'Rechazado',
  'Duplicate' => 'Duplicado',
  'Default' => 'Defecto',
);
$app_list_strings["oqc_product_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Medio',
  'P3' => 'Bajo',
);
$app_list_strings["oqc_product_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceptado',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Cerrado',
  'Out of Date' => 'Caducado',
  'Invalid' => 'Invalido',
);
$app_list_strings["oqc_contract_type_dom"] = array (
  'Administration' => 'Administracion',
  'Product' => 'Producto',
  'User' => 'Usuario',
);
$app_list_strings["oqc_addition_type_dom"] = array (
  'Administration' => 'Administracion',
  'Product' => 'Producto',
  'User' => 'Usuario',
);
$app_list_strings["oqc_offering_type_dom"] = array (
  'Administration' => 'Administracion',
  'Product' => 'Producto',
  'User' => 'Usuario',
);
$app_list_strings["oqc_contract_status_dom"] = array (
  'Draft' => 'Borrador',
  'Sent' => 'Enviado',
  'Signed' => 'Firmado',
  'Completed' => 'Completado',
);
$app_list_strings["oqc_offering_status_dom"] = array (
  'Draft' => 'Borrador',
  'Sent' => 'Enviado',
  'Accepted' => 'Aceptado',
);
$app_list_strings["oqc_contract_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Medio',
  'P3' => 'Bajo',
);
$app_list_strings["oqc_offering_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Medio',
  'P3' => 'Bajo',
);
$app_list_strings["oqc_addition_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Medio',
  'P3' => 'Bajo',
);
$app_list_strings["oqc_addition_status_dom"] = array (
  'New' => 'Nuevo',
  'Assigned' => 'Asignado',
  'Closed' => 'Cerrado',
  'Pending Input' => 'Entrada pendiente',
  'Rejected' => 'Rechazado',
  'Duplicate' => 'Duplicado',
);
$app_list_strings["oqc_contract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceptado',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Cerrado',
  'Out of Date' => 'Caducado',
  'Invalid' => 'Invalido',
);
$app_list_strings["oqc_offering_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceptado',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Cerrado',
  'Out of Date' => 'Caducado',
  'Invalid' => 'Invalido',
);
$app_list_strings["oqc_addition_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceptado',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Cerrado',
  'Out of Date' => 'Caducado',
  'Invalid' => 'Invalido',
);
$app_list_strings["unit_list"] = array (
  'pieces' => 'piezas',
  'hours' => 'horas',
  'kg' => 'kg',
  'm' => 'm',
);
$app_list_strings["discount_select_list"] = array (
  'rel' => '%',
  'abs' => 'abs',
);
$app_list_strings["contract_abbreviation_list"] = array (
  'Cnt' => 'Cnt',
  'ExCnt' => 'ExCnt',
  'InCnt' => 'InCnt',
);
$app_list_strings["quote_abbreviation_list"] = array (
  'Qt' => 'Qt',
  'ExQt' => 'ExQt',
  'InQt' => 'InQt',
 );
$app_list_strings["addition_abbreviation_list"] = array (
  'Ad' => 'Ad',
  'ExAd' => 'ExAd',
  'InAd' => 'InAd',
 );

$app_list_strings["externalcontractsabbreviation_list"] = array (
  'VW-IT' => 'VW-IT',
  'VW-SO' => 'VW-SO',
);
$app_list_strings["zeitbezug_list"] = array (
  'once' => 'contado',
  'monthly' => 'mensualmente',
  'annually' => 'anualmente',
);
$app_list_strings["periodofnotice_list"] = array (
  '6months' => 'seis meses',
  '3months' => 'tres meses',
  '1month' => 'un mes',
);
$app_list_strings["externalcontracttype_list"] = array (
  'EVB-IT System' => 'Sistema IT',
  'EVB-IT Kaufvertrag (Langfassung)' => 'Version extendida contrato IT',
  'EVB-IT Kaufvertrag (Kurzfassung)' => 'Resumen contrato IT',
  'EVB-IT Dienstleistungsvertrag' => 'Contrato servicios IT',
  'EVB-IT Überlassungsvertrag Typ A (Langfassung)' => 'Version extendida contrato empleo IT',
  'EVB-IT Überlassungsvertrag Typ A (Kurzfassung)' => 'Resumen contrato empleo IT',
  'individuell' => 'Personal',
);
$app_list_strings["externalcontractmatter_list"] = array (
  'software' => 'Software',
  'hardware' => 'Hardware',
  'furniture' => 'Mobiliario',
  'service' => 'Servicio',
  'innerservice' => 'Interno',
  'other' => 'Otros',
);
$app_list_strings["ownershipsituation_list"] = array (
  'Handelsware' => 'Mercancia',
  'Eigentum' => 'Propiedad',
);
$app_list_strings["contractservicetype_list"] = array (
  'Beratung' => 'Consultoria',
  'Projektleitungsunterstützung' => 'Gestion Proyecto',
  'Schulung' => 'Formacion',
  'Einführungsunterstützung' => 'Instalacion Producto',
  'Betreiberleistungen' => 'Reparacion con garantia',
  'Benutzerunterstützungsleistungen' => 'Reparacion Sin Garantia',
  'sonstige Dienstleistung' => 'Otros',
);
$app_list_strings["contractpaymentterms_list"] = array (
  'leer' => 'leer',
  'monatlich' => 'mensualmente',
  'quartalsweise' => 'trimestralmente',
  'halbjährlich' => 'semestralmente',
  'jährlich' => 'anualmente',
  'einmalig' => 'contado',
  'sonstige' => 'Otros',
);
$app_list_strings["agreementtype_list"] = array (
  'Kauf' => 'Compra',
  'Miete' => 'Alquiler',
  'Leasing' => 'Leasing',
  'Wartung' => 'Mantenimiento',
  'Pflege' => 'Soporte',
);
$app_list_strings["endperiod_list"] = array (
  '3months' => '3 Meses',
  '6months' => '6 Meses',
  '9months' => '9 Meses',
  '12months' => '12 Meses',
  '24months' => '24 Meses',
  '36months' => '36 Meses',
  '48months' => '48 Meses',
  'infinite' => 'infinito',
  'other' => 'Otros',
);
$app_list_strings["paymentinterval_list"] = array (
  'monthly' => 'mensualmente',
  'quarterly' => 'trimestralmente',
  'halfyearly' => 'semestralmente',
  'annually' => 'anualmente',
  'once' => 'contado',
  'other' => 'Otros',
);
$app_list_strings["publish_state_list"] = array (
  'unknown' => '',
  'pending' => 'Pendiente',
  'published' => 'Publicado',
);
//1.7.6 modifications
$app_list_strings['document_category_dom']= array (
	'General' => 'General',
	'Addition' => 'Ampliacion',
	'Contract' => 'Contrato',
	'Product' => 'Producto',
	'Catalogo de Productos' => 'Catalogo Producto',
	'Quote' => 'Ofertas',
	'ExternalContract' => 'Contrato Externo',
	'' => '',
	);
$app_list_strings['document_subcategory_dom']= array (
	'Document' => 'Documento',
	'Attachment' => 'Adjunto',
	'Brochure' => 'Folleto',
	'Drawing' => 'Pintura',
	'Pdf' => 'Pdf',
	'Picture' => 'Imagen',
	'Technical' => 'Descripcion tecnica',
	'' => '',
	);	

//1.7.5 addition
$app_list_strings["document_purpose_list"] = array (
  'Internal' => 'Para Uso Interno',
  'Catalog' => 'Para Catalogo de Productos',
  'Customer' => 'Para Cliente',
  'Distributor' => 'Para Distribuidor',
  '' => '',
);
$app_list_strings["shipment_terms_list"] = array (
  'Default' => '',
  'EXW' => 'EXW',
  'FCA' => 'FCA',
  'CPT' => 'CPT',
  'CIP' => 'CIP',
  'DDU' => 'DDU',
  'DDP' => 'DDP',
);
$app_list_strings["oqc_vat_list"] = array (
  'default' => '21%',
  '0.0' => '0%',
  '0.05' => '5%',
  '0.12' => '12%',
);
$app_list_strings["oqc_templates_list"] = array (
  'Contract' => 'Contrato',
  'Offering' => 'Ofertas',
  'Offering2' => 'Nueva oferta',
  'Addition' => 'Ampliacion',
);
$app_list_strings["oqc_catalog_templates_list"] = array (
  'Catalogo de Productos' => 'Catalogo de Productos',
  'ProductCatalog2' => 'Solo descripcion',
  'ProductCatalog3' => 'Solo Lista Precios',
  'ProductCatalog4' => 'Reservado',
);

$app_list_strings["oqc_task_status_list"] = array (
    'Not Started' => 'No Comenzado',
    'In Progress' => 'En Desarrollo',
    'Completed' => 'Completado',
    'Pending Input' => 'Entrada pendiente',
    'Deferred' => 'Deferred',
);

$app_list_strings["oqc_task_user_status_list"] = array (
    'Not Started' => 'No Comenzado',
    'In Progress' => 'En Desarrollo',
    'Completed' => 'Completado',
);

$app_list_strings["oqc_task_resolution_list"] = array (
    'None' => 'Nada',
    'Accepted' => 'Aceptado',
    'Corrected' => 'Aceptado con correcciones',
    'Rejected' => 'Rechazado',
    'Duplicate' => 'Duplicado',
    'Out of Date' => 'Caducado',
    'Invalid' => 'No aplicable',
    'Other' => 'Otros',
);

$app_list_strings["oqc_task_priority_list"] = array (
        'High' => 'Alto',
        'Medium' => 'Medio',
        'Low' => 'Bajo',
);

$app_list_strings["record_type_display_notes"]["oqc_Task"] =  'Tarea de Equipo';
    

$app_list_strings["oqc_parent_type_display_list"] = array (
    'oqc_Product' => 'Producto',
    'oqc_Offering' => 'Ofertas',
    'oqc_Contract' => 'Contrato',
    'oqc_Addition' => 'Ampliacion',
    'oqc_Task' => 'Tarea de Equipo',
    'oqc_ProductCatalog' => 'Catalogo Producto',
);

$app_list_strings["oqc_task_finished_list"] = array (
        'InProgress' => 'No',
        'Finished' => 'Si',
);

$app_list_strings["oqc_task_accepted_list"] = array (
        'notAccepted' => 'No Aceptado',
        'accepted' => 'Aceptado',
        'decline' => 'Rechazado',
);
$app_list_strings["oqc_task_abbreviation_list"] = array (
  'Tsk' => 'Tsk',
  'Apr' => 'Apr',
  'Sgn' => 'Sgn',
 );
$app_list_strings["oqc_reminder_interval_options"] = array (
    '-2' => 'contado',
    '1' => 'en 1 dia',
    '3' => 'en 3 dias',
    '7' => 'en 1 semana',
);
$app_strings['LBL_OQC_PRODUCT_DELETE'] = 'Este producto no esta disponible';
$app_strings['LBL_OQC_PRODUCT_INACTIVE'] = 'Producto no activo';
$app_strings['LBL_NO_RECORDS_MESSAGE'] = 'Ningun producto encontrado';
$app_strings['LBL_DATA_ERROR_MESSAGE'] = 'Error de Datos';
$app_strings['LBL_LOADING_MESSAGE'] = 'Cargando...';
 
//Some default settings DO NOT TRANSLATE!
$app_list_strings['oqc_dropdowns_default']['oqc_parent_type_default_key'] = 'oqc_Task';
$app_list_strings['oqc_dropdowns_default']['oqc_priority_default_key'] = 'Medium';
$app_list_strings['oqc_dropdowns_default']['oqc_remind_default_key'] = '1';



?>


