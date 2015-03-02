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

$app_list_strings["moduleList"]["oqc_ExternalContractCosts"] = 'CustosContratosExternos';
$app_list_strings["moduleList"]["oqc_ExternalContractDetailedCosts"] = 'CustosDetalhadosContratosExternos'; // 1.7.5 fixes bug in Roles table
$app_list_strings["moduleList"]["oqc_ExternalContractPositions"] = 'PosiçõesContratosExternos';
$app_list_strings["moduleList"]["oqc_ExternalContract"] = 'Contrato Externo';
$app_list_strings["moduleList"]["oqc_ArchivedExternalContract"] = 'Arquivo de Contratos';
$app_list_strings["moduleList"]["oqc_Offering"] = 'Propostas';
$app_list_strings["moduleList"]["oqc_ServiceRecording"] = 'RegistroServiços';
$app_list_strings["moduleList"]["oqc_Category"] = 'Categorias';
$app_list_strings["moduleList"]["oqc_Product"] = 'Produtos';
$app_list_strings["moduleList"]["oqc_Contract"] = 'Contratos';
$app_list_strings["moduleList"]["oqc_Service"] = 'Serviços';
$app_list_strings["moduleList"]["oqc_EditedTextBlock"] = 'TextBlocksEditados';
$app_list_strings["moduleList"]["oqc_TextBlock"] = 'TextBlocks';
$app_list_strings["moduleList"]["oqc_Addition"] = 'Aditivos';
$app_list_strings["moduleList"]["oqc_ProductCatalog"] = 'CatalogoProduto';
$app_list_strings["moduleList"]["oqc_Task"] = 'TeamTask';
$app_list_strings["oqc"]["months"] = array(
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março', 
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho', 
        7 => 'Julho', 
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',       
        12 => 'Dezembro'
);
$app_list_strings["oqc"]["common"]["new"] = "Novo";
$app_list_strings["oqc"]["common"]["cancel"] = "Cancelar";
$app_list_strings["oqc"]["common"]["showReports"] = "Mostrar Relatório";
$app_list_strings["oqc"]["common"]["delete"] = "Apagar";
$app_list_strings["oqc"]["common"]["name"] = "Nome";
$app_list_strings["oqc"]["common"]["quantity"] = "Quantidade";
$app_list_strings["oqc"]["common"]["price"] = "Preço";
$app_list_strings["oqc"]["common"]["sum"] = "Soma";
$app_list_strings["oqc"]["common"]["description"] = "Descrição";
$app_list_strings["oqc"]["common"]["payment"] = "Pagamento";
$app_list_strings["oqc"]["common"]["year"] = "Ano";
$app_list_strings["oqc"]["common"]["type"] = "Tipo";
$app_list_strings["oqc"]["common"]["in"] = "em";        	// following for lines are for the 
$app_list_strings["oqc"]["common"]["for"] = "para";		// 
$app_list_strings["oqc"]["common"]["until"] = "até";		// "sum in \euro 1.1.08 until 1.1.09 for 12 months" line
$app_list_strings["oqc"]["common"]["months"] = "mes(es)";	// in the latex template
$app_list_strings["oqc"]["ExternalContracts"]["infinityHint"] = "<h2>Nota</h2>Você selecionou <em>infinito</em> como fim do contrato. O contrato correrá até que você o cancele. As tabelas de custo mostram os custos esperados para os próximos quatro anos.";
$app_list_strings["oqc"]["Email"]["subject"] = "Notificação de Encerramento de Contratos do SugarCRM";
$app_list_strings["oqc"]["Email"]["hello"] = "Olá %s,<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["greetings"] = "<br />\nSaudações, SugarCRM :-)";
$app_list_strings["oqc"]["Email"]["introduction"] = "os seguintes contratos externos se encerrarão em breve:<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["notificationLine"] = "Em %s encerra-se \"%s\", <a href='%s'>veja o link</a>.<br />\n";
$app_list_strings["oqc"]["pdf"]["contract"]["title"] = "Contrato";
$app_list_strings["oqc"]["pdf"]["contract"]["titleServices"] = "Serviços e Documentações";
$app_list_strings["oqc"]["pdf"]["contract"]["preamble"] = "Preâmbulo"; // the preamble title 
$app_list_strings["oqc"]["pdf"]["contract"]["preambleText"] = "insira seu preâmbulo aqui"; // the actual preamble paragraph
$app_list_strings["oqc"]["pdf"]["contract"]["textblocksIntro"] = "Cliente e fornecedor concordam com as seguintes regras."; // the text above the textblocks
$app_list_strings["oqc"]["pdf"]["contract"]["startDate"] = "Data de Início";
$app_list_strings["oqc"]["pdf"]["contract"]["endDate"] = "Data de Fim";
$app_list_strings["oqc"]["pdf"]["contract"]["deadline"] = "Deadline";
$app_list_strings["oqc"]["pdf"]["contract"]["periodOfNotice"] = "Período de notificação";
$app_list_strings["oqc"]["pdf"]["contract"]["quote_title"] = "Proposta";
$app_list_strings["oqc"]["pdf"]["contract"]["addition_title"] = "Aditivo";

$app_list_strings["oqc"]["pdf"]["catalog"]["title"] = "Catálogo de Produto";
$app_list_strings["oqc"]["pdf"]["catalog"]["publisherTitle"] = "Editor";
$app_list_strings["oqc"]["pdf"]["catalog"]["services"] = "Produtos";
$app_list_strings["oqc"]["pdf"]["catalog"]["prices"] = "Preços";
$app_list_strings["oqc"]["pdf"]["catalog"]["price"] = "Preço";
$app_list_strings["oqc"]["pdf"]["catalog"]["unit"] = "Unidade";
$app_list_strings["oqc"]["pdf"]["catalog"]["position"] = "Posição";
$app_list_strings["oqc"]["pdf"]["catalog"]["validityTitle"] = "Validade";
$app_list_strings["oqc"]["pdf"]["catalog"]["imageAppendixTitle"] = "Apendice de Imagens";
$app_list_strings["oqc"]["pdf"]["catalog"]["contactTitle"] = "Seu Contato";

$app_list_strings["oqc"]["pdf"]["common"]["filenamePrefixCatalog"] = "Catalogo";
$app_list_strings["oqc"]["pdf"]["common"]["seeFigure"] = "veja figura";
$app_list_strings["oqc"]["pdf"]["common"]["onPage"] = "na página";
$app_list_strings["oqc"]["pdf"]["common"]["createdOn"] = "Criado em";
$app_list_strings["oqc"]["pdf"]["common"]["customer"] = "Cliente"; // your customer
$app_list_strings["oqc"]["pdf"]["common"]["company"] = "Fornecedor"; // your company
$app_list_strings["oqc"]["Services"]["selectImage"] = "Selecione outro arquivo para substituir a imagem atual:";
$app_list_strings["oqc"]["Services"]["currentImage"] = "Imagem Atual";
$app_list_strings["oqc"]["Services"]["unit"] = "Unidade";
$app_list_strings["oqc"]["Services"]["description"] = "Descrição";
$app_list_strings["oqc"]["Services"]["name"] = "Nome";
$app_list_strings["oqc"]["Services"]["quantity"] = "Quantidade";
$app_list_strings["oqc"]["Services"]["price"] = "Preço de Lista";
$app_list_strings["oqc"]["Services"]["discount"] = "Desconto";
$app_list_strings["oqc"]["Services"]["discountPrice"] = "Preço";
$app_list_strings["oqc"]["Services"]["vat"] = "Impostos";
$app_list_strings["oqc"]["Services"]["vat_default"] = "Valor de imposto padrão";
$app_list_strings["oqc"]["Services"]["vat_legacy"] = "Valor de imposto herdado";
$app_list_strings["oqc"]["Services"]["oqc_position"] = "Não";
$app_list_strings["oqc"]["Services"]["sum"] = "Soma";
$app_list_strings["oqc"]["Services"]["gross"] = "Bruto";
$app_list_strings["oqc"]["Services"]["net"] = "Líquido";
$app_list_strings["oqc"]["Services"]["netTotal"] = "Total Líquido:";
$app_list_strings["oqc"]["Services"]["grandTotal"] = "Total Geral:";
$app_list_strings["oqc"]["Services"]["onceTableTitle"] = "Lista de Produtos";
$app_list_strings["oqc"]["Services"]["ongoingTableTitle"] = "Lista de Despesas Recorrentes";
$app_list_strings["oqc"]["Services"]["defaultDescription"] = "Descrição do Produto";
$app_list_strings["oqc"]["Services"]["totalNegotiatedPrice"] = "Preço total negociado";
$app_list_strings["oqc"]["Services"]["add"] = "Adicionar Produto Padrão";
$app_list_strings["oqc"]["Services"]["addRecurring"] = "Adicionar Despesas Recorrentes";
$app_list_strings["oqc"]["Services"]["addCustom"] = "Adicionar Produto Personalizado";
$app_list_strings["oqc"]["Services"]["addCustomService"] = "Adicionar Despesa Personalizada";
$app_list_strings["oqc"]["Services"]["addDefaultLines"] = "Adicionar Itens Padrão";
$app_list_strings["oqc"]["Services"]["delete"] = "Apagar";
$app_list_strings["oqc"]["Services"]["cst_delete"] = "Apagar";
$app_list_strings["oqc"]["Services"]["updatedVersionAvailable"] = "atualizável";
$app_list_strings["oqc"]["Services"]["updateAll"] = "Atualizar Tudo";
$app_list_strings["oqc"]["Services"]["from"] = "de";
$app_list_strings["oqc"]["Services"]["to"] = "para";
$app_list_strings["oqc"]["Services"]["confirmDelete"] = "Você realmente quer apagar este produto?";
$app_list_strings["oqc"]["Services"]["confirmUpdate"] = "Você realmente quer atualizar este produto?";
$app_list_strings["oqc"]["Services"]["confirmUpdateAll"] = "Você realmente quer atualizar todos os produtos?";
$app_list_strings["oqc"]["Services"]["months"] = "mes(es)";
$app_list_strings["oqc"]["Services"]["ongoingSum"] = "Soma por um período de %d meses (de %s até %s)";
$app_list_strings["oqc"]["Services"]["discountUnits"] = "%or$";
$app_list_strings["oqc"]["Services"]["updateProduct"] = "Sim";
$app_list_strings["oqc"]["Services"]["donotupdateProduct"] = "Não";
$app_list_strings["oqc"]["Services"]["update"] = "Atualizar";
$app_list_strings["oqc"]["Services"]["addOption"] = "Adicionar Opção";
$app_list_strings["oqc"]["Services"]["action"] = "Ação";
$app_list_strings["oqc"]["Services"]["imageHint"] = "As imagens mostradas serão redimensionadas para 700 pixels de largura (requer que a extensão GD esteja instalada) <br>Tipos suportados de imagens são:.jpg, .png, .gif";
$app_list_strings["oqc"]["Services"]["update_file_confirm"] = "Atualizar arquivo de Descrição Técnica do Produto: ";
$app_list_strings["oqc"]["Services"]["zeitbezug"] = "Recorrencia";
$app_list_strings["oqc"]["Documents"]["fileSelectionHint"] = "<small>Você seleciona arquivos de %s.</small>";
$app_list_strings["oqc"]["Documents"]["popupTitle"] = "Por favor, selecione um arquivo";
$app_list_strings["oqc"]["Documents"]["title"] = '<h1 style="margin-bottom: 10px;">Por favor, selecione um arquivo:</h1>';
$app_list_strings["oqc"]["Documents"]["fileNotExists"] = '<span style="margin-left: 5px; color:red; font-weight: bold;">O arquivo não existe.</span>';
$app_list_strings["oqc"]["Textblocks"]["delete"] = "Apagar";
$app_list_strings["oqc"]["Textblocks"]["freeText"] = "Entre com seu texto aqui:";
$app_list_strings["oqc"]["Textblocks"]["addTemplate"] = "Adicionar Modelo";
$app_list_strings["oqc"]["Textblocks"]["addDefaultTemplates"] = "Adicionar Modelo Padrão";
$app_list_strings["oqc"]["Textblocks"]["dragdrop"] = "Utilizar cabeçalho para Drag&Drop";
$app_list_strings["oqc"]["Attachments"]["add"] = "Adicionar Anexo";
$app_list_strings["oqc"]["Attachments"]["addDefault"] = "Adicionar Anexo(s) Padrão";
$app_list_strings["oqc"]["Attachments"]["createNew"] = "Criar Novo Anexo";
$app_list_strings["oqc"]["Attachments"]["delete"] = "Apagar";
$app_list_strings["oqc"]["Attachments"]["default"] = "padrão";
$app_list_strings["oqc"]["Attachments"]["upload"] = "Upload de Nova Revisão";
$app_list_strings["oqc"]["ProductCatalog"]["addCategory"] = "Adicionar";
$app_list_strings["oqc"]["ProductCatalog"]["saveCategory"] = "Salvar";
$app_list_strings["oqc"]["ProductCatalog"]["deleteCategory"] = "Apagar";
$app_list_strings["oqc"]["ProductCatalog"]["categoryTree"] = "Árvore de Categorias"; //1.7.5 addition
$app_list_strings["oqc"]["ProductCatalog"]["confirmDelete"] = "Você quer apagar a categoria selecionada com todos os seus produtos e subcategorias?";
$app_list_strings["oqc"]["ProductCatalog"]["navigationHint"] = "- Suas mudanças são salvas automaticamente.<br />- Use as teclas de setas para navegar através das categorias.<br />- Pressione F2 para editar a categoria selecionada.<br />";
$app_list_strings["oqc"]["ProductOptions"]["add"] = "Adicionar Opção";
$app_list_strings["oqc"]["ProductOptions"]["createNew"] = "Criar Novo Anexo";
$app_list_strings["oqc"]["ProductOptions"]["delete"] = "Apagar";

$app_list_strings["oqc_externalcontract_type_dom"] = array (
  'Administration' => 'Administração',
  'Product' => 'Produto',
  'User' => 'Usuário',
);
$app_list_strings["oqc_externalcontract_status_dom"] = array (
  'New' => 'Novo',
  'Assigned' => 'Atribuído',
  'Closed' => 'Encerrado',
  'Pending Input' => 'Entrada Pendente',
  'Rejected' => 'Rejeitado',
  'Duplicate' => 'Duplicado',
);
$app_list_strings["oqc_externalcontract_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Médio',
  'P3' => 'Baixo',
);
$app_list_strings["oqc_externalcontract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceito',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Encerrado',
  'Out of Date' => 'Desatualizado',
  'Invalid' => 'Inválido',
);


$app_list_strings["oqc_productcatalog_type_dom"] = array (
  'Administration' => 'Administração',
  'Product' => 'Produto',
  'User' => 'Usuário',
);
$app_list_strings["oqc_productcatalog_status_dom"] = array (
  'New' => 'Novo',
  'Assigned' => 'Atribuído',
  'Closed' => 'Encerrado',
  'Pending Input' => 'Entrada Pendente',
  'Rejected' => 'Rejeitado',
  'Duplicate' => 'Duplicado',
);
$app_list_strings["oqc_productcatalog_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Médio',
  'P3' => 'Baixo',
);
$app_list_strings["oqc_productcatalog_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceito',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Encerrado',
  'Out of Date' => 'Desatualizado',
  'Invalid' => 'Inválido',
);

$app_list_strings["oqc_product_type_dom"] = array (
  'Administration' => 'Administração',
  'Product' => 'Produto',
  'User' => 'Usuário',
);
$app_list_strings["oqc_product_status_list"] = array (
  'New' => 'Novo',
  'Assigned' => 'Atribuído',
  'Closed' => 'Encerrado',
  'Pending Input' => 'Entrada Pendente',
  'Rejected' => 'Rejeitado',
  'Duplicate' => 'Duplicado',
  'Default' => 'Padrão',
);
$app_list_strings["oqc_product_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Médio',
  'P3' => 'Baixo',
);
$app_list_strings["oqc_product_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceito',
  'Duplicate' => 'Duplicado',
  'Closed' => 'Encerrado',
  'Out of Date' => 'Desatualizado',
  'Invalid' => 'Inválido',
);
$app_list_strings["oqc_contract_type_dom"] = array (
  'Administration' => 'Administração',
  'Product' => 'Produto',
  'User' => 'Usuário',
);
$app_list_strings["oqc_addition_type_dom"] = array (
  'Administration' => 'Administração',
  'Product' => 'Produto',
  'User' => 'Usuário',
);
$app_list_strings["oqc_offering_type_dom"] = array (
  'Administration' => 'Administração',
  'Product' => 'Produto',
  'User' => 'Usuário',
);
$app_list_strings["oqc_contract_status_dom"] = array (
  'Draft' => 'Rascunho',
  'Sent' => 'Enviado',
  'Signed' => 'Assinado',
  'Completed' => 'Completado',
);
$app_list_strings["oqc_offering_status_dom"] = array (
  'Draft' => 'Rascunho',
  'Sent' => 'Enviado',
  'Accepted' => 'Aceito',
);
$app_list_strings["oqc_contract_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Médio',
  'P3' => 'Baixo',
);
$app_list_strings["oqc_offering_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Médio',
  'P3' => 'Baixo',
);
$app_list_strings["oqc_addition_priority_dom"] = array (
  'P1' => 'Alto',
  'P2' => 'Médio',
  'P3' => 'Baixo',
);
$app_list_strings["oqc_addition_status_dom"] = array (
  'New' => 'Novo',
  'Assigned' => 'Atribuído',
  'Closed' => 'Encerrado',
  'Pending Input' => 'Entrada Pendente',
  'Rejected' => 'Rejeitado',
  'Duplicate' => 'Duplicate',
);
$app_list_strings["oqc_contract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceito',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Encerrado',
  'Out of Date' => 'Desatualizado',
  'Invalid' => 'Inválido',
);
$app_list_strings["oqc_offering_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceito',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Encerrado',
  'Out of Date' => 'Desatualizado',
  'Invalid' => 'Inválido',
);
$app_list_strings["oqc_addition_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Aceito',
  'Duplicate' => 'Duplicate',
  'Closed' => 'Encerrado',
  'Out of Date' => 'Desatualizado',
  'Invalid' => 'Inválido',
);
$app_list_strings["unit_list"] = array (
  'pieces' => 'peças',
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
  'ExCnt' => 'CntEx',
  'InCnt' => 'CntIn',
);
$app_list_strings["quote_abbreviation_list"] = array (
  'Qt' => 'Prop',
  'ExQt' => 'PropEx',
  'InQt' => 'PropIn',
 );
$app_list_strings["addition_abbreviation_list"] = array (
  'Ad' => 'Adit',
  'ExAd' => 'AditEx',
  'InAd' => 'AditIn',
 );

$app_list_strings["externalcontractsabbreviation_list"] = array (
  'VW-IT' => 'VW-IT',
  'VW-SO' => 'VW-SO',
);
$app_list_strings["zeitbezug_list"] = array (
  'once' => 'uma vez',
  'monthly' => 'mensalmente',
  'annually' => 'anualmente',
);
$app_list_strings["periodofnotice_list"] = array (
  '6months' => 'seis meses',
  '3months' => 'três meses',
  '1month' => 'um mês',
);
$app_list_strings["externalcontracttype_list"] = array (
  'EVB-IT System' => 'Sistema de IT',
  'EVB-IT Kaufvertrag (Langfassung)' => 'Versão extendida de contrato de TI',
  'EVB-IT Kaufvertrag (Kurzfassung)' => 'Sumário do contrato de TI',
  'EVB-IT Dienstleistungsvertrag' => 'Contrato de serviços de TI',
  'EVB-IT Überlassungsvertrag Typ A (Langfassung)' => 'Versão extendida do contrato de emprego de TI',
  'EVB-IT Überlassungsvertrag Typ A (Kurzfassung)' => 'Sumário de contrato de emprego de TI',
  'individuell' => 'Pessoal',
);
$app_list_strings["externalcontractmatter_list"] = array (
  'software' => 'Software',
  'hardware' => 'Hardware',
  'furniture' => 'Mobiliário',
  'service' => 'Serviço',
  'innerservice' => 'Interno',
  'other' => 'Outro',
);
$app_list_strings["ownershipsituation_list"] = array (
  'Handelsware' => 'Commodity',
  'Eigentum' => 'Propriedade',
);
$app_list_strings["contractservicetype_list"] = array (
  'Beratung' => 'Consultoria',
  'Projektleitungsunterstützung' => 'Gerenciamento de Projeto',
  'Schulung' => 'Treinamento',
  'Einführungsunterstützung' => 'Instalação de Produto',
  'Betreiberleistungen' => 'Reparo em Garantia',
  'Benutzerunterstützungsleistungen' => 'Reparo Avulso',
  'sonstige Dienstleistung' => 'Outro',
);
$app_list_strings["contractpaymentterms_list"] = array (
  'leer' => 'fiado',
  'monatlich' => 'mensalmente',
  'quartalsweise' => 'trimestralmente',
  'halbjährlich' => 'semestralmente',
  'jährlich' => 'anualmente',
  'einmalig' => 'uma vez',
  'sonstige' => 'outro',
);
$app_list_strings["agreementtype_list"] = array (
  'Kauf' => 'Compra',
  'Miete' => 'Aluguel',
  'Leasing' => 'Leasing',
  'Wartung' => 'Manutenção',
  'Pflege' => 'Gestão',
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
  'other' => 'outro',
);
$app_list_strings["paymentinterval_list"] = array (
  'monthly' => 'mensalmente',
  'quarterly' => 'trimestralmente',
  'halfyearly' => 'semestralmente',
  'annually' => 'anualmente',
  'once' => 'uma vez',
  'other' => 'outro',
);
$app_list_strings["publish_state_list"] = array (
  'unknown' => 'Desconhecido',
  'pending' => 'Pendente',
  'published' => 'Publicado',
);
//1.7.6 modifications
$app_list_strings['document_category_dom']= array (
	'General' => 'Geral',
	'Addition' => 'Aditivo',
	'Contract' => 'Contrato',
	'Product' => 'Produto',
	'ProductCatalog' => 'Catálogo de Produto',
	'Quote' => 'Proposta',
	'ExternalContract' => 'Contrato Externo',
	'' => '',
	);
$app_list_strings['document_subcategory_dom']= array (
	'Document' => 'Documento',
	'Attachment' => 'Anexo',
	'Brochure' => 'Brochura',
	'Drawing' => 'Desenho',
	'Pdf' => 'Pdf',
	'Picture' => 'Figura',
	'Technical' => 'Descrição Técnica',
	'' => '',
	);	

//1.7.5 addition
$app_list_strings["document_purpose_list"] = array (
  'Internal' => 'Para uso interno',
  'Catalog' => 'Para catálogo de produto',
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
  'default' => '19%',
  '0.0' => '0%',
  '0.05' => '5%',
  '0.12' => '12%',
);
$app_list_strings["oqc_templates_list"] = array (
  'Contract' => 'Contrato',
  'Offering' => 'Proposta',
  'Offering2' => 'Quote new',
  'Addition' => 'Aditivo',
);
$app_list_strings["oqc_catalog_templates_list"] = array (
  'ProductCatalog' => 'CatalogoProduto',
  'ProductCatalog2' => 'Apenas Descrições',
  'ProductCatalog3' => 'Apenas Listas de Preço',
  'ProductCatalog4' => 'Reservado',
);

$app_list_strings["oqc_task_status_list"] = array (
    'Not Started' => 'Não Iniciado',
    'In Progress' => 'Em Progresso',
    'Completed' => 'Completado',
    'Pending Input' => 'Entrada Pendente',
    'Deferred' => 'Deferido',
);

$app_list_strings["oqc_task_user_status_list"] = array (
    'Not Started' => 'Não Iniciado',
    'In Progress' => 'Em Progresso',
    'Completed' => 'Completado',
);

$app_list_strings["oqc_task_resolution_list"] = array (
    'None' => 'Nenhum',
    'Accepted' => 'Aprovado',
    'Corrected' => 'Aprovado com correções',
    'Rejected' => 'Rejeitado',
    'Duplicate' => 'Duplicado',
    'Out of Date' => 'Desatualizado',
    'Invalid' => 'Não Aplicável',
    'Other' => 'Outro',
);

$app_list_strings["oqc_task_priority_list"] = array (
        'High' => 'Alto',
        'Medium' => 'Médio',
        'Low' => 'Baixo',
);

$app_list_strings["record_type_display_notes"]["oqc_Task"] =  'TeamTask';
    

$app_list_strings["oqc_parent_type_display_list"] = array (
    'oqc_Product' => 'Produto',
    'oqc_Offering' => 'Proposta',
    'oqc_Contract' => 'Contrato',
    'oqc_Addition' => 'Aditivo',
    'oqc_Task' => 'TeamTask',
    'oqc_ProductCatalog' => 'Catálogo de Produto',
);

$app_list_strings["oqc_task_finished_list"] = array (
        'InProgress' => 'Não',
        'Finished' => 'Sim',
);

$app_list_strings["oqc_task_accepted_list"] = array (
        'notAccepted' => 'Não Aceito',
        'accepted' => 'Aceito',
        'decline' => 'Declinado',
);
$app_list_strings["oqc_task_abbreviation_list"] = array (
  'Tsk' => 'Tsk',
  'Apr' => 'Apr',
  'Sgn' => 'Sgn',
 );
$app_list_strings["oqc_reminder_interval_options"] = array (
    '-2' => 'uma vez',
    '1' => 'uma vez ao dia',
    '3' => 'uma vez a cada 3 dias',
    '7' => 'uma vez por semana',
);
$app_strings['LBL_OQC_PRODUCT_DELETE'] = 'Este produto não está mais disponível';
$app_strings['LBL_OQC_PRODUCT_INACTIVE'] = 'Este produto não está ativo';
$app_strings['LBL_NO_RECORDS_MESSAGE'] = 'Nenhum produto encontrado';
$app_strings['LBL_DATA_ERROR_MESSAGE'] = 'Erro de Dados';
$app_strings['LBL_LOADING_MESSAGE'] = 'Carregando...';
 
//Some default settings DO NOT TRANSLATE!
$app_list_strings['oqc_dropdowns_default']['oqc_parent_type_default_key'] = 'oqc_Task';
$app_list_strings['oqc_dropdowns_default']['oqc_priority_default_key'] = 'Medium';
$app_list_strings['oqc_dropdowns_default']['oqc_remind_default_key'] = '1';



?>


