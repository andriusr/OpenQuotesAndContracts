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

$app_list_strings["moduleList"]["oqc_ExternalContractCosts"] = 'Coûts des Contrats Externes';
$app_list_strings["moduleList"]["oqc_ExternalContractDetailedCosts"] = 'Coûts Détaillés des Contrats Externes'; // 1.7.5 fixes bug in Roles table
$app_list_strings["moduleList"]["oqc_ExternalContractPositions"] = 'Situation des Contrats Externes';
$app_list_strings["moduleList"]["oqc_ExternalContract"] = 'Contrat Externe';
$app_list_strings["moduleList"]["oqc_ArchivedExternalContract"] = 'Archive des Contrats';
$app_list_strings["moduleList"]["oqc_Offering"] = 'Devis';
$app_list_strings["moduleList"]["oqc_ServiceRecording"] = 'Enregistrements de Service';
$app_list_strings["moduleList"]["oqc_Category"] = 'Catégories';
$app_list_strings["moduleList"]["oqc_Product"] = 'Produits';
$app_list_strings["moduleList"]["oqc_Contract"] = 'Contrats';
$app_list_strings["moduleList"]["oqc_Service"] = 'Services';
$app_list_strings["moduleList"]["oqc_EditedTextBlock"] = 'ZonesTexteEditées';
$app_list_strings["moduleList"]["oqc_TextBlock"] = 'ZonesTexte';
$app_list_strings["moduleList"]["oqc_Addition"] = 'Additions';
$app_list_strings["moduleList"]["oqc_ProductCatalog"] = 'CatalogueProduits';
$app_list_strings["moduleList"]["oqc_Task"] = 'Projet';
$app_list_strings["oqc"]["months"] = array(
        1 => 'Janvier',
        2 => 'Février',
        3 => 'Mars', 
        4 => 'Avril',
        5 => 'Mai',
        6 => 'Juin', 
        7 => 'Juillet', 
        8 => 'Août',
        9 => 'Septembre',
        10 => 'Octobre',
        11 => 'Novembre',       
        12 => 'Décembre'
);
$app_list_strings["oqc"]["common"]["new"] = "Nouveau";
$app_list_strings["oqc"]["common"]["cancel"] = "Annuler";
$app_list_strings["oqc"]["common"]["showReports"] = "Afficher les Rapports";
$app_list_strings["oqc"]["common"]["delete"] = "Effacer";
$app_list_strings["oqc"]["common"]["select"] = "Sélectionner";
$app_list_strings["oqc"]["common"]["contract_number"] = "Numéro du Contrat";
$app_list_strings["oqc"]["common"]["name"] = "Nom";
$app_list_strings["oqc"]["common"]["quantity"] = "Quantité";
$app_list_strings["oqc"]["common"]["price"] = "Prix";
$app_list_strings["oqc"]["common"]["sum"] = "Somme";
$app_list_strings["oqc"]["common"]["description"] = "Description";
$app_list_strings["oqc"]["common"]["payment"] = "Paiement";
$app_list_strings["oqc"]["common"]["year"] = "Année";
$app_list_strings["oqc"]["common"]["type"] = "Type";
$app_list_strings["oqc"]["common"]["in"] = "du";        	// following for lines are for the 
$app_list_strings["oqc"]["common"]["for"] = "sur";		// 
$app_list_strings["oqc"]["common"]["until"] = "au";		// "sum in \euro 1.1.08 until 1.1.09 for 12 months" line
$app_list_strings["oqc"]["common"]["months"] = "mois";	// in the latex template
$app_list_strings["oqc"]["ExternalContracts"]["infinityHint"] = "<h2>Note</h2>Vous avez sélectionné <em>infini</em> comme fin de contrat. Le contrat sera effectif jusqu'à ce que vous l'annuliez. Les tableaux de coûts montrent les coûts attendus pour les 4 prochaines années.";
$app_list_strings["oqc"]["Email"]["subject"] = "SugarCRM Notification de Fin de Contrats";
$app_list_strings["oqc"]["Email"]["hello"] = "Bonjour %s,<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["greetings"] = "<br />\nCordialement, SugarCRM :-)";
$app_list_strings["oqc"]["Email"]["introduction"] = "les contrats externes suivants vont bientôt expirer:<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["notificationLine"] = "On %s ends \"%s\", <a href='%s'>voir le lien</a>.<br />\n";		// Osytos AM
$app_list_strings["oqc"]["pdf"]["contract"]["title"] = "Contrat";
$app_list_strings["oqc"]["pdf"]["contract"]["titleServices"] = "Services et Documentation";
$app_list_strings["oqc"]["pdf"]["contract"]["preamble"] = "Preambule"; // the preamble title 
$app_list_strings["oqc"]["pdf"]["contract"]["preambleText"] = "insérer votre preambule ici"; // the actual preamble paragraph
$app_list_strings["oqc"]["pdf"]["contract"]["textblocksIntro"] = "Le client et la société s'accordent sur les règles suivantes."; // the text above the textblocks
$app_list_strings["oqc"]["pdf"]["contract"]["startDate"] = "Date de Début";
$app_list_strings["oqc"]["pdf"]["contract"]["endDate"] = "Date de Fin";
$app_list_strings["oqc"]["pdf"]["contract"]["deadline"] = "Date Limite";
$app_list_strings["oqc"]["pdf"]["contract"]["periodOfNotice"] = "Délai de préavis";
$app_list_strings["oqc"]["pdf"]["contract"]["quote_title"] = "Devis";
$app_list_strings["oqc"]["pdf"]["contract"]["addition_title"] = "Addition";

$app_list_strings["oqc"]["pdf"]["catalog"]["title"] = "Catalogue produits";
$app_list_strings["oqc"]["pdf"]["catalog"]["publisherTitle"] = "Editeur";
$app_list_strings["oqc"]["pdf"]["catalog"]["services"] = "Produits";
$app_list_strings["oqc"]["pdf"]["catalog"]["prices"] = "Prix";
$app_list_strings["oqc"]["pdf"]["catalog"]["price"] = "Prix";
$app_list_strings["oqc"]["pdf"]["catalog"]["unit"] = "Unité/Récurrence";
$app_list_strings["oqc"]["pdf"]["catalog"]["position"] = "Position";
$app_list_strings["oqc"]["pdf"]["catalog"]["validityTitle"] = "Validité";
$app_list_strings["oqc"]["pdf"]["catalog"]["imageAppendixTitle"] = "Image en Annexe";
$app_list_strings["oqc"]["pdf"]["catalog"]["contactTitle"] = "Votre contact";

$app_list_strings["oqc"]["pdf"]["common"]["filenamePrefixCatalog"] = "Catalogue";
$app_list_strings["oqc"]["pdf"]["common"]["seeFigure"] = "voir l'image";
$app_list_strings["oqc"]["pdf"]["common"]["onPage"] = "à la page";
$app_list_strings["oqc"]["pdf"]["common"]["createdOn"] = "Créé le";
$app_list_strings["oqc"]["pdf"]["common"]["customer"] = "Client"; // your customer
$app_list_strings["oqc"]["pdf"]["common"]["company"] = "Société"; // your company
$app_list_strings["oqc"]["Services"]["selectImage"] = "Sélectionner un autre fichier pour remplacer l'image actuelle:";
$app_list_strings["oqc"]["Services"]["currentImage"] = "Image actuelle";
$app_list_strings["oqc"]["Services"]["unit"] = "Unité";
$app_list_strings["oqc"]["Services"]["description"] = "Description";
$app_list_strings["oqc"]["Services"]["name"] = "Nom";
$app_list_strings["oqc"]["Services"]["quantity"] = "Quantité";
$app_list_strings["oqc"]["Services"]["price"] = "Liste de prix";
$app_list_strings["oqc"]["Services"]["discount"] = "Remise";
$app_list_strings["oqc"]["Services"]["discountPrice"] = "Prix";
$app_list_strings["oqc"]["Services"]["vat"] = "TVA";
$app_list_strings["oqc"]["Services"]["vat_default"] = "Valeur de TVA par défaut";
$app_list_strings["oqc"]["Services"]["vat_legacy"] = "Valeur de TVA héritée";
$app_list_strings["oqc"]["Services"]["oqc_position"] = "NO";
$app_list_strings["oqc"]["Services"]["sum"] = "Somme";
$app_list_strings["oqc"]["Services"]["gross"] = "Brut";
$app_list_strings["oqc"]["Services"]["net"] = "Net";
$app_list_strings["oqc"]["Services"]["netTotal"] = "Total Net:";
$app_list_strings["oqc"]["Services"]["grandTotal"] = "Grand Total:";
$app_list_strings["oqc"]["Services"]["onceTableTitle"] = "Liste de Produits";
$app_list_strings["oqc"]["Services"]["ongoingTableTitle"] = "Liste des Dépenses Réccurentes";
$app_list_strings["oqc"]["Services"]["defaultDescription"] = "Description du Produit";
$app_list_strings["oqc"]["Services"]["totalNegotiatedPrice"] = "Prix Total négocié";
$app_list_strings["oqc"]["Services"]["add"] = "Ajouter Produit Standard";
$app_list_strings["oqc"]["Services"]["addRecurring"] = "Ajouter Dépenses Réccurentes";
$app_list_strings["oqc"]["Services"]["addCustom"] = "Ajouter Produit Personnalisé";
$app_list_strings["oqc"]["Services"]["addCustomService"] = "Ajouter Dépense Personnalisée";
$app_list_strings["oqc"]["Services"]["addDefaultLines"] = "Ajouter Obejts par Défaut";
$app_list_strings["oqc"]["Services"]["delete"] = "Effacer";
$app_list_strings["oqc"]["Services"]["cst_delete"] = "Effacer";
$app_list_strings["oqc"]["Services"]["updatedVersionAvailable"] = "actualisable";
$app_list_strings["oqc"]["Services"]["updateAll"] = "Tout mettre à jour";
$app_list_strings["oqc"]["Services"]["from"] = "du";
$app_list_strings["oqc"]["Services"]["to"] = "au";
$app_list_strings["oqc"]["Services"]["confirmDelete"] = "Voulez-vous vraiment effacer ce Produit?";
$app_list_strings["oqc"]["Services"]["confirmUpdate"] = "Voulez-vous vraiment mettre à jour ce Produit?";
$app_list_strings["oqc"]["Services"]["confirmUpdateAll"] = "Voulez-vous vraiment mettre à jour tous les Produits?";
$app_list_strings["oqc"]["Services"]["months"] = "mois";
$app_list_strings["oqc"]["Services"]["ongoingSum"] = "Somme pour une période de %d mois (du %s au %s)";
$app_list_strings["oqc"]["Services"]["discountUnits"] = "%ou$";
$app_list_strings["oqc"]["Services"]["updateProduct"] = "Oui";
$app_list_strings["oqc"]["Services"]["donotupdateProduct"] = "Non";
$app_list_strings["oqc"]["Services"]["update"] = "Mise à jour";
$app_list_strings["oqc"]["Services"]["addOption"] = "Ajouter Option";
$app_list_strings["oqc"]["Services"]["action"] = "Action";
$app_list_strings["oqc"]["Services"]["imageHint"] = "Les images affichées vont être redimensionner à 700px de large (nécessite que l'extension GD soit installée) <br>Les types d'images acceptés sont .jpg, .png, .gif";
$app_list_strings["oqc"]["Services"]["update_file_confirm"] = "Mise à jour du fichier de Description Technique de Produit: ";
$app_list_strings["oqc"]["Documents"]["fileSelectionHint"] = "<small>Sélectionner les fichiers de %s.</small>";
$app_list_strings["oqc"]["Documents"]["popupTitle"] = "Veuillez sélectionner un fichier";
$app_list_strings["oqc"]["Documents"]["title"] = '<h1 style="margin-bottom: 10px;">Veuillez sélectionner un fichier:</h1>';
$app_list_strings["oqc"]["Documents"]["fileNotExists"] = '<span style="margin-left: 5px; color:red; font-weight: bold;">Le fichier n existe pas.</span>';
$app_list_strings["oqc"]["Textblocks"]["delete"] = "Effacer";
$app_list_strings["oqc"]["Textblocks"]["freeText"] = "Inscrivez votre texte ici:";
$app_list_strings["oqc"]["Textblocks"]["addTemplate"] = "Ajout Modèle";
$app_list_strings["oqc"]["Textblocks"]["addDefaultTemplates"] = "Ajout Modèle par défaut";
$app_list_strings["oqc"]["Textblocks"]["dragdrop"] = "Utiliser l en-tête pour le Drag&Drop";
$app_list_strings["oqc"]["Attachments"]["add"] = "Ajouter pièce jointe";
$app_list_strings["oqc"]["Attachments"]["addDefault"] = "Ajouter pièce(s) jointe(s) par défaut";
$app_list_strings["oqc"]["Attachments"]["createNew"] = "Créer nouvelle pièce jointe";
$app_list_strings["oqc"]["Attachments"]["delete"] = "Effacer";
$app_list_strings["oqc"]["Attachments"]["default"] = "par défaut";
$app_list_strings["oqc"]["Attachments"]["upload"] = "Uploader le nouvelle Révision";
$app_list_strings["oqc"]["ProductCatalog"]["addCategory"] = "Ajouter";
$app_list_strings["oqc"]["ProductCatalog"]["saveCategory"] = "Sauvegarder";
$app_list_strings["oqc"]["ProductCatalog"]["deleteCategory"] = "Effacer";
$app_list_strings["oqc"]["ProductCatalog"]["categoryTree"] = "Arbre de Catégories"; //1.7.5 addition
$app_list_strings["oqc"]["ProductCatalog"]["confirmDelete"] = "OVulez-vous effacer la catégorie sélectionnée ainsi que tous ses produits et sous-catégories?";
$app_list_strings["oqc"]["ProductCatalog"]["navigationHint"] = "- Vos modifications sont automatiquement sauvegardées.<br />- Utiliser les touches flechées pour naviguer parmi les catégories.<br />- Appuyer sur F2 pour éditer la catégorie sélectionnée.<br />";
$app_list_strings["oqc"]["ProductOptions"]["add"] = "Ajouter Option";
$app_list_strings["oqc"]["ProductOptions"]["createNew"] = "Créer nouvelle pièce jointe";
$app_list_strings["oqc"]["ProductOptions"]["delete"] = "Effacer";

$app_list_strings["oqc_externalcontract_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Produit',
  'User' => 'Utilisateur',
);
$app_list_strings["oqc_externalcontract_status_dom"] = array (
  'New' => 'Nouveau',
  'Assigned' => 'Assigné',
  'Closed' => 'Fermé',
  'Pending Input' => 'En Attente',
  'Rejected' => 'Rejeté',
  'Duplicate' => 'Dupliqué',
);
$app_list_strings["oqc_externalcontract_priority_dom"] = array (
  'P1' => 'Haute',
  'P2' => 'Moyenne',
  'P3' => 'Basse',
);
$app_list_strings["oqc_externalcontract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepté',
  'Duplicate' => 'Dupliqué',
  'Closed' => 'Fermé',
  'Out of Date' => 'Périmé',
  'Invalid' => 'Invalide',
);


$app_list_strings["oqc_productcatalog_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Produit',
  'User' => 'Utilisateur',
);
$app_list_strings["oqc_productcatalog_status_dom"] = array (
  'New' => 'Nouveau',
  'Assigned' => 'Assigné',
  'Closed' => 'Fermé',
  'Pending Input' => 'En Attente',
  'Rejected' => 'Rejeté',
  'Duplicate' => 'Dupliqué',
);
$app_list_strings["oqc_productcatalog_priority_dom"] = array (
  'P1' => 'Haute',
  'P2' => 'Moyenne',
  'P3' => 'Basse',
);
$app_list_strings["oqc_productcatalog_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepté',
  'Duplicate' => 'Dupliqué',
  'Closed' => 'Fermé',
  'Out of Date' => 'Périmé',
  'Invalid' => 'Invalide',
);

$app_list_strings["oqc_product_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Produit',
  'User' => 'Utilisateur',
);
$app_list_strings["oqc_product_status_list"] = array (
  'New' => 'Nouveau',
  'Assigned' => 'Assigné',
  'Closed' => 'Fermé',
  'Pending Input' => 'En Attente',
  'Rejected' => 'Rejeté',
  'Duplicate' => 'Dupliqué',
  'Default' => 'Par Défaut',
);
$app_list_strings["oqc_product_priority_dom"] = array (
  'P1' => 'Haute',
  'P2' => 'Moyenne',
  'P3' => 'Basse',
);
$app_list_strings["oqc_product_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepté',
  'Duplicate' => 'Dupliqué',
  'Closed' => 'Fermé',
  'Out of Date' => 'Périmé',
  'Invalid' => 'Invalide',
);
$app_list_strings["oqc_contract_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Produit',
  'User' => 'Utilisateur',
);
$app_list_strings["oqc_addition_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Produit',
  'User' => 'Utilisateur',
);
$app_list_strings["oqc_offering_type_dom"] = array (
  'Administration' => 'Administration',
  'Product' => 'Produit',
  'User' => 'Utilisateur',
);
$app_list_strings["oqc_contract_status_dom"] = array (
  'Draft' => 'Brouillon',
  'Sent' => 'Envoyé',
  'Signed' => 'Signé',
  'Completed' => 'Terminé',
);
$app_list_strings["oqc_offering_status_dom"] = array (
  'Draft' => 'Brouillon',
  'Sent' => 'Envoyé',
  'Accepted' => 'Accepté',
);
$app_list_strings["oqc_contract_priority_dom"] = array (
  'P1' => 'Haute',
  'P2' => 'Moyenne',
  'P3' => 'Basse',
);
$app_list_strings["oqc_offering_priority_dom"] = array (
  'P1' => 'Haute',
  'P2' => 'Moyenne',
  'P3' => 'Basse',
);
$app_list_strings["oqc_addition_priority_dom"] = array (
  'P1' => 'Haute',
  'P2' => 'Moyenne',
  'P3' => 'Basse',
);
$app_list_strings["oqc_addition_status_dom"] = array (
  'New' => 'Nouveau',
  'Assigned' => 'Assigné',
  'Closed' => 'Fermé',
  'Pending Input' => 'En Attente',
  'Rejected' => 'Rejeté',
  'Duplicate' => 'Dupliqué',
);
$app_list_strings["oqc_contract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepté',
  'Duplicate' => 'Dupliqué',
  'Closed' => 'Fermé',
  'Out of Date' => 'Périmé',
  'Invalid' => 'Invalide',
);
$app_list_strings["oqc_offering_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepté',
  'Duplicate' => 'Dupliqué',
  'Closed' => 'Fermé',
  'Out of Date' => 'Périmé',
  'Invalid' => 'Invalide',
);
$app_list_strings["oqc_addition_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Accepté',
  'Duplicate' => 'Dupliqué',
  'Closed' => 'Fermé',
  'Out of Date' => 'Périmé',
  'Invalid' => 'Invalide',
);
$app_list_strings["unit_list"] = array (
  'pieces' => 'pieces',
  'hours' => 'heures',
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
  'Qt' => 'Qt',
  'ExQt' => 'QtEx',
  'InQt' => 'QtIn',
 );
$app_list_strings["addition_abbreviation_list"] = array (
  'Ad' => 'Ad',
  'ExAd' => 'AdEx',
  'InAd' => 'AdIn',
 );

$app_list_strings["externalcontractsabbreviation_list"] = array (
  'VW-IT' => 'VW-IT',
  'VW-SO' => 'VW-SO',
);
$app_list_strings["zeitbezug_list"] = array (
  'once' => 'une fois',
  'monthly' => 'mensuel',
  'annually' => 'annuel',
);
$app_list_strings["periodofnotice_list"] = array (
  '6months' => '6 mois',
  '3months' => '3 mois',
  '1month' => '1 mois',
);
$app_list_strings["externalcontracttype_list"] = array (
  'EVB-IT System' => 'Système d Information',
  'EVB-IT Kaufvertrag (Langfassung)' => 'Version Etendue du Contrat SI',
  'EVB-IT Kaufvertrag (Kurzfassung)' => 'Résumé du Contrat SI',
  'EVB-IT Dienstleistungsvertrag' => 'Contrat de Service SI',
  'EVB-IT Überlassungsvertrag Typ A (Langfassung)' => 'Version Etendue du Contrat de Travail SI',
  'EVB-IT Überlassungsvertrag Typ A (Kurzfassung)' => 'Résumé du Contrat de Travail SI',
  'individuell' => 'Individuel',
);
$app_list_strings["externalcontractmatter_list"] = array (
  'software' => 'Logiciel',
  'hardware' => 'Matériel',
  'furniture' => 'Fourniture',
  'service' => 'Service',
  'innerservice' => 'Intere',
  'other' => 'Autre',
);
$app_list_strings["ownershipsituation_list"] = array (
  'Handelsware' => 'Marchandise',
  'Eigentum' => 'Propriété',
);
$app_list_strings["contractservicetype_list"] = array (
  'Beratung' => 'Consulting',
  'Projektleitungsunterstützung' => 'Gestion de Projet',
  'Schulung' => 'Formation',
  'Einführungsunterstützung' => 'Installation de Produit',
  'Betreiberleistungen' => 'Réparation sous Garantie',
  'Benutzerunterstützungsleistungen' => 'Réparation hors Garantie',
  'sonstige Dienstleistung' => 'Autre',
);
$app_list_strings["contractpaymentterms_list"] = array (
  'leer' => '-vide-',
  'monatlich' => 'mensuel',
  'quartalsweise' => 'trimestriel',
  'halbjährlich' => 'semestriel',
  'jährlich' => 'annuel',
  'einmalig' => 'une fois',
  'sonstige' => 'autre',
);
$app_list_strings["agreementtype_list"] = array (
  'Kauf' => 'Achat',
  'Miete' => 'Location',
  'Leasing' => 'Crédit-bail',
  'Wartung' => 'Maintenance',
  'Pflege' => 'Surveillance',
);
$app_list_strings["endperiod_list"] = array (
  '3months' => '3 Mois',
  '6months' => '6 Mois',
  '9months' => '9 Mois',
  '12months' => '12 Mois',
  '24months' => '24 Mois',
  '36months' => '36 Mois',
  '48months' => '48 Mois',
  'infinite' => 'infini',
  'other' => 'autre',
);
$app_list_strings["paymentinterval_list"] = array (
  'monthly' => 'mensuel',
  'quarterly' => 'trimestriel',
  'halfyearly' => 'semestriel',
  'annually' => 'annuel',
  'once' => 'une fois',
  'other' => 'autre',
);
$app_list_strings["publish_state_list"] = array (
  'unknown' => '',
  'pending' => 'En Attente',
  'published' => 'Publié',
);
//1.7.6 modifications
$app_list_strings['document_category_dom']= array (
	'General' => 'Général',
	'Addition' => 'Addition',
	'Contract' => 'Contact',
	'Product' => 'Produit',
	'ProductCatalog' => 'Catalogue produit',
	'Quote' => 'Devis',
	'ExternalContract' => 'Contrat Externe',
	'' => '',
	);
$app_list_strings['document_subcategory_dom']= array (
	'Document' => 'Document',
	'Attachment' => 'Pièce Jointe',
	'Brochure' => 'Brochure',
	'Drawing' => 'Tableau',
	'Pdf' => 'Pdf',
	'Picture' => 'Image',
	'Technical' => 'Description Technique',
	'' => '',
	);	

//1.7.5 addition
$app_list_strings["document_purpose_list"] = array (
  'Internal' => 'Pour usage interne',
  'Catalog' => 'Pour Catalogue Produit',
  'Customer' => 'Pour Client',
  'Distributor' => 'Pour Distributeur',
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
  'Contract' => 'Contrat',
  'Offering' => 'Devis',
  'Offering2' => 'nouveau Devis',
  'Addition' => 'Addition',
);
$app_list_strings["oqc_catalog_templates_list"] = array (
  'ProductCatalog' => 'Catalogue Produit',
  'ProductCatalog2' => 'Descriptions seules',
  'ProductCatalog3' => 'Liste De Prix seule',
  'ProductCatalog4' => 'Réservé',
);

$app_list_strings["oqc_task_status_list"] = array (
    'Not Started' => 'Pas commencé',
    'In Progress' => 'En Cours',
    'Completed' => 'Terminé',
    'Pending Input' => 'En Attente',
    'Deferred' => 'Différé',
);

$app_list_strings["oqc_task_user_status_list"] = array (
    'Not Started' => 'Pas commencé',
    'In Progress' => 'En Cours',
    'Completed' => 'Terminé',
);

$app_list_strings["oqc_task_resolution_list"] = array (
    'None' => 'Aucun',
    'Accepted' => 'Approuvé',
    'Corrected' => 'Approuvé avec corrections',
    'Rejected' => 'Rejeté',
    'Duplicate' => 'Dupliqué',
    'Out of Date' => 'Périmé',
    'Invalid' => 'Invalide',
    'Other' => 'Autre',
);

$app_list_strings["oqc_task_priority_list"] = array (
        'High' => 'Haute',
        'Medium' => 'Moyenne',
        'Low' => 'Basse',
);

$app_list_strings["record_type_display_notes"]["oqc_Task"] =  'Projet';
    

$app_list_strings["oqc_parent_type_display_list"] = array (
    'oqc_Product' => 'Produit',
    'oqc_Offering' => 'Devis',
    'oqc_Contract' => 'Contrat',
    'oqc_Addition' => 'Addition',
    'oqc_Task' => 'Projet',
    'oqc_ProductCatalog' => 'Catalogue Produit',
);

$app_list_strings["oqc_task_finished_list"] = array (
        'InProgress' => 'Non',
        'Finished' => 'Oui',
);

$app_list_strings["oqc_task_accepted_list"] = array (
        'notAccepted' => 'Pas accepté',
        'accepted' => 'Accepté',
        'decline' => 'Refusé',
);
$app_list_strings["oqc_task_abbreviation_list"] = array (
  'Tsk' => 'Tch',
  'Apr' => 'Apr',
  'Sgn' => 'Sig',
 );
$app_list_strings["oqc_reminder_interval_options"] = array (
    '-2' => 'une fois',
    '1' => 'quotidien',
    '3' => 'tous les 3 jours',
    '7' => 'hebdomadaire',
);
$app_strings['LBL_OQC_PRODUCT_DELETE'] = "Ce Produit n'est plus disponible";
$app_strings['LBL_OQC_PRODUCT_INACTIVE'] = "Ce Produit n'est pas actif";
$app_strings['LBL_NO_RECORDS_MESSAGE'] = 'Aucun Produits trouvé';
$app_strings['LBL_DATA_ERROR_MESSAGE'] = 'Erreur de Données';
$app_strings['LBL_LOADING_MESSAGE'] = 'Chargement...';
 
//Some default settings DO NOT TRANSLATE!
$app_list_strings['oqc_dropdowns_default']['oqc_parent_type_default_key'] = 'oqc_Task';
$app_list_strings['oqc_dropdowns_default']['oqc_priority_default_key'] = 'Medium';
$app_list_strings['oqc_dropdowns_default']['oqc_remind_default_key'] = '1';



?>


