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

$app_list_strings["moduleList"]["oqc_ExternalContractCosts"] = 'Расходы по внешним контрактам';
$app_list_strings["moduleList"]["oqc_ExternalContractDetailedCosts"] = 'ExternalContractDetailedCosts'; // 1.7.5 fixes bug in Roles table
$app_list_strings["moduleList"]["oqc_ExternalContractPositions"] = 'ExternalContractPositions';
$app_list_strings["moduleList"]["oqc_ExternalContract"] = 'Внешние контракты';
$app_list_strings["moduleList"]["oqc_ArchivedExternalContract"] = 'Архив контрактов';
$app_list_strings["moduleList"]["oqc_Offering"] = 'Ценовое предложение';
$app_list_strings["moduleList"]["oqc_ServiceRecording"] = 'ServiceRecordings';
$app_list_strings["moduleList"]["oqc_Category"] = 'Категории';
$app_list_strings["moduleList"]["oqc_Product"] = 'Продукты';
$app_list_strings["moduleList"]["oqc_Contract"] = 'Контракты';
$app_list_strings["moduleList"]["oqc_Service"] = 'Услуги';
$app_list_strings["moduleList"]["oqc_EditedTextBlock"] = 'EditedTextBlocks';
$app_list_strings["moduleList"]["oqc_TextBlock"] = 'TextBlocks';
$app_list_strings["moduleList"]["oqc_Addition"] = 'Дополнения';
$app_list_strings["moduleList"]["oqc_ProductCatalog"] = 'Каталог продуктов';
$app_list_strings["moduleList"]["oqc_Task"] = 'Групповая задача';
$app_list_strings["oqc"]["months"] = array(
        1 => 'январь',
        2 => 'Февраль',
        3 => 'март', 
        4 => 'апрель',
        5 => 'май',
        6 => 'июнь', 
        7 => 'июль', 
        8 => 'август',
        9 => 'сентябрь',
        10 => 'октябрь',
        11 => 'ноябрь',       
        12 => 'декабрь'
);
$app_list_strings["oqc"]["common"]["new"] = "Новый";
$app_list_strings["oqc"]["common"]["cancel"] = "Отмена";
$app_list_strings["oqc"]["common"]["showReports"] = "Показать отчёты";
$app_list_strings["oqc"]["common"]["delete"] = "Удалить";
$app_list_strings["oqc"]["common"]["select"] = "Выбрать";
$app_list_strings["oqc"]["common"]["contract_number"] = "Номер контракта";
$app_list_strings["oqc"]["common"]["name"] = "Название";
$app_list_strings["oqc"]["common"]["quantity"] = "Количество";
$app_list_strings["oqc"]["common"]["price"] = "Цена";
$app_list_strings["oqc"]["common"]["sum"] = "Сумма";
$app_list_strings["oqc"]["common"]["description"] = "Описание";
$app_list_strings["oqc"]["common"]["payment"] = "Платёж";
$app_list_strings["oqc"]["common"]["year"] = "Год";
$app_list_strings["oqc"]["common"]["type"] = "Тип";
$app_list_strings["oqc"]["common"]["in"] = "в";        	// following for lines are for the 
$app_list_strings["oqc"]["common"]["for"] = "для";		// 
$app_list_strings["oqc"]["common"]["until"] = "до";		// "sum in \euro 1.1.08 until 1.1.09 for 12 months" line
$app_list_strings["oqc"]["common"]["months"] = "мес.";	// in the latex template
$app_list_strings["oqc"]["ExternalContracts"]["infinityHint"] = "<h2>Примечание</h2>Вы выбрали <em>бесконечность</em> в качестве даты окончания контракта. Контракт будет действовать, пока вы не отмените его действие. Таблицы стоимость услуг показывают стоимость за четыре года.";
$app_list_strings["oqc"]["Email"]["subject"] = "SugarCRM извещение об окончании контракта";
$app_list_strings["oqc"]["Email"]["hello"] = "Здравствуйте, %s,<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["greetings"] = "<br />\nС уважением, SugarCRM :-)";
$app_list_strings["oqc"]["Email"]["introduction"] = "следующие внешние контракты вскоре закончат своё действие:<br /><br />\n\n";
$app_list_strings["oqc"]["Email"]["notificationLine"] = "На %s заканчивается \"%s\", <a href='%s'>см. ссылку</a>.<br />\n";
$app_list_strings["oqc"]["pdf"]["contract"]["title"] = "Контракт";
$app_list_strings["oqc"]["pdf"]["contract"]["titleServices"] = "Услуги и документация";
$app_list_strings["oqc"]["pdf"]["contract"]["preamble"] = "Преамбула"; // the preamble title 
$app_list_strings["oqc"]["pdf"]["contract"]["preambleText"] = "вставьте преамбулу сюда"; // the actual preamble paragraph
$app_list_strings["oqc"]["pdf"]["contract"]["textblocksIntro"] = "Клиент и коапания договариваются о нижеследующем."; // the text above the textblocks
$app_list_strings["oqc"]["pdf"]["contract"]["startDate"] = "Дата начала";
$app_list_strings["oqc"]["pdf"]["contract"]["endDate"] = "Дата окончания";
$app_list_strings["oqc"]["pdf"]["contract"]["deadline"] = "Срок";
$app_list_strings["oqc"]["pdf"]["contract"]["periodOfNotice"] = "Срок уведомления о расторжении";
$app_list_strings["oqc"]["pdf"]["contract"]["quote_title"] = "Предложение цены";
$app_list_strings["oqc"]["pdf"]["contract"]["addition_title"] = "Дополнение";

$app_list_strings["oqc"]["pdf"]["catalog"]["title"] = "Каталог продуктов";
$app_list_strings["oqc"]["pdf"]["catalog"]["publisherTitle"] = "Опубликовано";
$app_list_strings["oqc"]["pdf"]["catalog"]["services"] = "Продукты";
$app_list_strings["oqc"]["pdf"]["catalog"]["prices"] = "Цены";
$app_list_strings["oqc"]["pdf"]["catalog"]["price"] = "Цена";
$app_list_strings["oqc"]["pdf"]["catalog"]["unit"] = "Единица/Повторение";
$app_list_strings["oqc"]["pdf"]["catalog"]["position"] = "Позиция";
$app_list_strings["oqc"]["pdf"]["catalog"]["validityTitle"] = "Действительно";
$app_list_strings["oqc"]["pdf"]["catalog"]["imageAppendixTitle"] = "Изображение";
$app_list_strings["oqc"]["pdf"]["catalog"]["contactTitle"] = "Ваш контакт";
 
$app_list_strings["oqc"]["pdf"]["common"]["filenamePrefixCatalog"] = "Каталог";
$app_list_strings["oqc"]["pdf"]["common"]["seeFigure"] = "см. изображение";
$app_list_strings["oqc"]["pdf"]["common"]["onPage"] = "на странице";
$app_list_strings["oqc"]["pdf"]["common"]["createdOn"] = "Создано";
$app_list_strings["oqc"]["pdf"]["common"]["customer"] = "Клиент"; // your customer
$app_list_strings["oqc"]["pdf"]["common"]["company"] = "Компания"; // your company
$app_list_strings["oqc"]["Services"]["selectImage"] = "Выберите файл, чтобы заменить имеющееся изображение:";
$app_list_strings["oqc"]["Services"]["currentImage"] = "Имеющееся изображение";
$app_list_strings["oqc"]["Services"]["unit"] = "Единица";
$app_list_strings["oqc"]["Services"]["description"] = "Описание";
$app_list_strings["oqc"]["Services"]["name"] = "Название";
$app_list_strings["oqc"]["Services"]["quantity"] = "Количество";
$app_list_strings["oqc"]["Services"]["price"] = "Цена по прайс-листу";
$app_list_strings["oqc"]["Services"]["discount"] = "Скидка";
$app_list_strings["oqc"]["Services"]["discountPrice"] = "Цена";
$app_list_strings["oqc"]["Services"]["vat"] = "НДС";
$app_list_strings["oqc"]["Services"]["vat_default"] = "НДС по-умолчанию";
$app_list_strings["oqc"]["Services"]["vat_legacy"] = "Историческое значение НДС";
$app_list_strings["oqc"]["Services"]["oqc_position"] = "№";
$app_list_strings["oqc"]["Services"]["sum"] = "Сумма";
$app_list_strings["oqc"]["Services"]["gross"] = "Включая НДС";
$app_list_strings["oqc"]["Services"]["net"] = "Без НДС";
$app_list_strings["oqc"]["Services"]["netTotal"] = "Всего без НДС:";
$app_list_strings["oqc"]["Services"]["grandTotal"] = "Общая сумма:";
$app_list_strings["oqc"]["Services"]["onceTableTitle"] = "Список продуктов";
$app_list_strings["oqc"]["Services"]["ongoingTableTitle"] = "Список подписок";
$app_list_strings["oqc"]["Services"]["defaultDescription"] = "Описание продукта";
$app_list_strings["oqc"]["Services"]["totalNegotiatedPrice"] = "Согласованная цена, итого";
$app_list_strings["oqc"]["Services"]["add"] = "Добавить стандартный продукт";
$app_list_strings["oqc"]["Services"]["addRecurring"] = "Добавить подписку";
$app_list_strings["oqc"]["Services"]["addCustom"] = "Добавить нестандартный продукт";
$app_list_strings["oqc"]["Services"]["addCustomService"] = "Добавить нестандартные расходы";
$app_list_strings["oqc"]["Services"]["addDefaultLines"] = "Добавить продукты/услуги по-умолчанию";
$app_list_strings["oqc"]["Services"]["delete"] = "Удалить";
$app_list_strings["oqc"]["Services"]["cst_delete"] = "Удалить";
$app_list_strings["oqc"]["Services"]["updatedVersionAvailable"] = "обновляемо";
$app_list_strings["oqc"]["Services"]["updateAll"] = "Обновить все";
$app_list_strings["oqc"]["Services"]["from"] = "от";
$app_list_strings["oqc"]["Services"]["to"] = "к";
$app_list_strings["oqc"]["Services"]["confirmDelete"] = "Вы действительно хотите удалить этот продукт?";
$app_list_strings["oqc"]["Services"]["confirmUpdate"] = "Вы действительно ходтите обновить этот продукт?";
$app_list_strings["oqc"]["Services"]["confirmUpdateAll"] = "Вы действительно хотите обновить все продукты?";
$app_list_strings["oqc"]["Services"]["months"] = "мес.";
$app_list_strings["oqc"]["Services"]["ongoingSum"] = "Сумма для периода %d мес. (от %s до %s)";
$app_list_strings["oqc"]["Services"]["discountUnits"] = "%or$";
$app_list_strings["oqc"]["Services"]["updateProduct"] = "Да";
$app_list_strings["oqc"]["Services"]["donotupdateProduct"] = "Нет";
$app_list_strings["oqc"]["Services"]["update"] = "Обновить";
$app_list_strings["oqc"]["Services"]["addOption"] = "Добавить опцию";
$app_list_strings["oqc"]["Services"]["action"] = "Действие";
$app_list_strings["oqc"]["Services"]["imageHint"] = "Показанное изображение будет изменено в размере до ширины 700 пикселей (требуется расширение GD) <br>Поддерживаемые форматы: .jpg, .png, .gif";
$app_list_strings["oqc"]["Services"]["update_file_confirm"] = "Обновить файл технического описания продукта: ";
$app_list_strings["oqc"]["Services"]["zeitbezug"] = "Повторение";
$app_list_strings["oqc"]["Documents"]["fileSelectionHint"] = "<small>Выберите файлы из %s.</small>";
$app_list_strings["oqc"]["Documents"]["popupTitle"] = "Выберите файл";
$app_list_strings["oqc"]["Documents"]["title"] = '<h1 style="margin-bottom: 10px;">Выберите файл:</h1>';
$app_list_strings["oqc"]["Documents"]["fileNotExists"] = '<span style="margin-left: 5px; color:red; font-weight: bold;">Файл не существует.</span>';
$app_list_strings["oqc"]["Textblocks"]["delete"] = "Удалить";
$app_list_strings["oqc"]["Textblocks"]["freeText"] = "Введите текст:";
$app_list_strings["oqc"]["Textblocks"]["addTemplate"] = "Добавить шаблон";
$app_list_strings["oqc"]["Textblocks"]["addDefaultTemplates"] = "Добавить шаблоны по-умолчанию";
$app_list_strings["oqc"]["Textblocks"]["dragdrop"] = "Используйте заголовок для Drag&Drop";
$app_list_strings["oqc"]["Attachments"]["add"] = "Добавить вложение";
$app_list_strings["oqc"]["Attachments"]["addDefault"] = "Добавить вложения по-умолчанию";
$app_list_strings["oqc"]["Attachments"]["createNew"] = "Создать новое вложение";
$app_list_strings["oqc"]["Attachments"]["delete"] = "Удалить";
$app_list_strings["oqc"]["Attachments"]["default"] = "по-умолчанию";
$app_list_strings["oqc"]["Attachments"]["upload"] = "Загрузить новую версию";
$app_list_strings["oqc"]["ProductCatalog"]["addCategory"] = "Добавить";
$app_list_strings["oqc"]["ProductCatalog"]["saveCategory"] = "Сохранить";
$app_list_strings["oqc"]["ProductCatalog"]["deleteCategory"] = "Удалить";
$app_list_strings["oqc"]["ProductCatalog"]["categoryTree"] = "Дерево категорий"; //1.7.5 addition
$app_list_strings["oqc"]["ProductCatalog"]["confirmDelete"] = "Вы действительно хотите удалить выбранную категорию из всех продуктов и подкатегорий?";
$app_list_strings["oqc"]["ProductCatalog"]["navigationHint"] = "- Изменения сохранены автоматически.<br />- Используйте стрелки для навигации по категориям.<br />- Нажмите F2 для редактирования выбранной категории.<br />";
$app_list_strings["oqc"]["ProductOptions"]["add"] = "Добавить опцию";
$app_list_strings["oqc"]["ProductOptions"]["createNew"] = "Создать новое вложение";
$app_list_strings["oqc"]["ProductOptions"]["delete"] = "Удалить";

$app_list_strings["oqc_externalcontract_type_dom"] = array (
  'Administration' => 'Администрирование',
  'Product' => 'Продукт',
  'User' => 'Пользователь',
);
$app_list_strings["oqc_externalcontract_status_dom"] = array (
  'New' => 'Новый',
  'Assigned' => 'Присвоен',
  'Closed' => 'Закрыт',
  'Pending Input' => 'Ожидание реакции',
  'Rejected' => 'Отклонён',
  'Duplicate' => 'Дубликат',
);
$app_list_strings["oqc_externalcontract_priority_dom"] = array (
  'P1' => 'Высокий',
  'P2' => 'Средний',
  'P3' => 'Низкий',
);
$app_list_strings["oqc_externalcontract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Принят',
  'Duplicate' => 'Дубликат',
  'Closed' => 'Закрыт',
  'Out of Date' => 'Истёк',
  'Invalid' => 'Неверный',
);


$app_list_strings["oqc_productcatalog_type_dom"] = array (
  'Administration' => 'Администрирование',
  'Product' => 'Продукт',
  'User' => 'Пользователь',
);
$app_list_strings["oqc_productcatalog_status_dom"] = array (
  'New' => 'Новый',
  'Assigned' => 'Присвоен',
  'Closed' => 'Закрыт',
  'Pending Input' => 'Ожидание реакции',
  'Rejected' => 'Отклонён',
  'Duplicate' => 'Дубликат',
);
$app_list_strings["oqc_productcatalog_priority_dom"] = array (
  'P1' => 'Высокий',
  'P2' => 'Средний',
  'P3' => 'Низкий',
);
$app_list_strings["oqc_productcatalog_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Принят',
  'Duplicate' => 'Дубликат',
  'Closed' => 'Закрыт',
  'Out of Date' => 'Истёк',
  'Invalid' => 'Неверный',
);

$app_list_strings["oqc_product_type_dom"] = array (
  'Administration' => 'Администрирование',
  'Product' => 'Продукт',
  'User' => 'Пользователь',
);
$app_list_strings["oqc_product_status_list"] = array (
  'New' => 'Новый',
  'Assigned' => 'Присвоен',
  'Closed' => 'Закрыт',
  'Pending Input' => 'Ожидание реакции',
  'Rejected' => 'Отклонён',
  'Duplicate' => 'Дубликат',
  'Default' => 'По-умолчанию',
);
$app_list_strings["oqc_product_priority_dom"] = array (
  'P1' => 'Высокий',
  'P2' => 'Средний',
  'P3' => 'Низкий',
);
$app_list_strings["oqc_product_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Принят',
  'Duplicate' => 'Дубликат',
  'Closed' => 'Закрыт',
  'Out of Date' => 'Истёк',
  'Invalid' => 'Неверный',
);
$app_list_strings["oqc_contract_type_dom"] = array (
  'Administration' => 'Администрирование',
  'Product' => 'Продукт',
  'User' => 'Пользователь',
);
$app_list_strings["oqc_addition_type_dom"] = array (
  'Administration' => 'Администрирование',
  'Product' => 'Продукт',
  'User' => 'Пользователь',
);
$app_list_strings["oqc_offering_type_dom"] = array (
  'Administration' => 'Администрирование',
  'Product' => 'Продукт',
  'User' => 'Пользователь',
);
$app_list_strings["oqc_contract_status_dom"] = array (
  'Draft' => 'Черновик',
  'Sent' => 'Отправлен',
  'Signed' => 'Подписан',
  'Completed' => 'Выполнен',
);
$app_list_strings["oqc_offering_status_dom"] = array (
  'Draft' => 'Черновик',
  'Sent' => 'Отправлен',
  'Accepted' => 'Принят',
);
$app_list_strings["oqc_contract_priority_dom"] = array (
  'P1' => 'Высокий',
  'P2' => 'Средний',
  'P3' => 'Низкий',
);
$app_list_strings["oqc_offering_priority_dom"] = array (
  'P1' => 'Высокий',
  'P2' => 'Средний',
  'P3' => 'Низкий',
);
$app_list_strings["oqc_addition_priority_dom"] = array (
  'P1' => 'Высокий',
  'P2' => 'Средний',
  'P3' => 'Низкий',
);
$app_list_strings["oqc_addition_status_dom"] = array (
  'New' => 'Новый',
  'Assigned' => 'Присвоен',
  'Closed' => 'Закрыт',
  'Pending Input' => 'Ожидание реакции',
  'Rejected' => 'Отклонён',
  'Duplicate' => 'Дубликат',
);
$app_list_strings["oqc_contract_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Принят',
  'Duplicate' => 'Дубликат',
  'Closed' => 'Закрыт',
  'Out of Date' => 'Истёк',
  'Invalid' => 'Неверный',
);
$app_list_strings["oqc_offering_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Принят',
  'Duplicate' => 'Дубликат',
  'Closed' => 'Закрыт',
  'Out of Date' => 'Истёк',
  'Invalid' => 'Неверный',
);
$app_list_strings["oqc_addition_resolution_dom"] = array ( '' => '',
  '' => '',
  'Accepted' => 'Принят',
  'Duplicate' => 'Дубликат',
  'Closed' => 'Закрыт',
  'Out of Date' => 'Истёк',
  'Invalid' => 'Неверный',
);
$app_list_strings["unit_list"] = array (
  'pieces' => 'шт',
  'hours' => 'час',
  'kg' => 'кг',
  'm' => 'м',
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
  'once' => 'разово',
  'monthly' => 'в месяц',
  'annually' => 'в год',
);
$app_list_strings["periodofnotice_list"] = array (
  '6months' => 'шесть месяцев',
  '3months' => 'три месяца',
  '1month' => 'один месяц',
);
$app_list_strings["externalcontracttype_list"] = array (
  'EVB-IT System' => 'IT система',
  'EVB-IT Kaufvertrag (Langfassung)' => 'IT контракт - расширенная версия',
  'EVB-IT Kaufvertrag (Kurzfassung)' => 'IT контракт - резюме',
  'EVB-IT Dienstleistungsvertrag' => 'IT контракт на обслуживание',
  'EVB-IT Überlassungsvertrag Typ A (Langfassung)' => 'IT рабочий контракт - расширенная версия',
  'EVB-IT Überlassungsvertrag Typ A (Kurzfassung)' => 'IT рабочий контракт - резюме',
  'individuell' => 'индивидуальный',
);
$app_list_strings["externalcontractmatter_list"] = array (
  'software' => 'Программное обеспечение',
  'hardware' => 'Аппаратное обеспечение',
  'furniture' => 'Мебель',
  'service' => 'Услуга',
  'innerservice' => 'Внутренняя услуга',
  'other' => 'Другое',
);
$app_list_strings["ownershipsituation_list"] = array (
  'Handelsware' => 'Товар',
  'Eigentum' => 'Собственность',
);
$app_list_strings["contractservicetype_list"] = array (
  'Beratung' => 'Консалтинг',
  'Projektleitungsunterstützung' => 'Управление проектами',
  'Schulung' => 'Обучение',
  'Einführungsunterstützung' => 'Установка продукта',
  'Betreiberleistungen' => 'Гарантийный ремонт',
  'Benutzerunterstützungsleistungen' => 'Негарантийный ремонт',
  'sonstige Dienstleistung' => 'Другое',
);
$app_list_strings["contractpaymentterms_list"] = array (
  'leer' => 'путо',
  'monatlich' => 'ежемесячно',
  'quartalsweise' => 'ежеквартально',
  'halbjährlich' => 'раз в полгода',
  'jährlich' => 'раз в год',
  'einmalig' => 'единоразово',
  'sonstige' => 'другое',
);
$app_list_strings["agreementtype_list"] = array (
  'Kauf' => 'Покупка',
  'Miete' => 'Аренда',
  'Leasing' => 'Лизинг',
  'Wartung' => 'Обслуживание',
  'Pflege' => 'Уход',
);
$app_list_strings["endperiod_list"] = array (
  '3months' => '3 месяца',
  '6months' => '6 месяцев',
  '9months' => '9 месяцев',
  '12months' => '12 месяцев',
  '24months' => '24 месяца',
  '36months' => '36 месяцев',
  '48months' => '48 месяцев',
  'infinite' => 'без ограничений',
  'other' => 'другое',
);
$app_list_strings["paymentinterval_list"] = array (
  'monthly' => 'едемесячно',
  'quarterly' => 'ежеквартально',
  'halfyearly' => 'раз в полгода',
  'annually' => 'раз в год',
  'once' => 'единоразово',
  'other' => 'другое',
);
$app_list_strings["publish_state_list"] = array (
  'unknown' => '',
  'pending' => 'Ожидает',
  'published' => 'Опубликован',
);
//1.7.6 modifications
$app_list_strings['document_category_dom']= array (
	'General' => 'Общее',
	'Addition' => 'Дополнение',
	'Contract' => 'Контракт',
	'Product' => 'Продукт',
	'ProductCatalog' => 'Каталог продуктов',
	'Quote' => 'Предложение цены',
	'ExternalContract' => 'Внешний контракт',
	'' => '',
	);
$app_list_strings['document_subcategory_dom']= array (
	'Document' => 'Документ',
	'Attachment' => 'Вложение',
	'Brochure' => 'Брошюра',
	'Drawing' => 'Чертёж',
	'Pdf' => 'Pdf',
	'Picture' => 'Изображение',
	'Technical' => 'Техническое описание',
	'' => '',
	);	

//1.7.5 addition
$app_list_strings["document_purpose_list"] = array (
  'Internal' => 'Для внутреннего использования',
  'Catalog' => 'Для каталога продуктов',
  'Customer' => 'Для клиента',
  'Distributor' => 'Для дистрибьютора',
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
  'default' => '18%',
  '0.0' => '0%',
  '0.1' => '10%',
);
$app_list_strings["oqc_templates_list"] = array (
  'Contract' => 'Контракт',
  'Offering' => 'Предложение цены',
  'Offering2' => 'Новое предложение',
  'Addition' => 'Дополнение',
);
$app_list_strings["oqc_catalog_templates_list"] = array (
  'ProductCatalog' => 'Каталог продуктов',
  'ProductCatalog2' => 'Только описания',
  'ProductCatalog3' => 'Только прайс-лист',
  'ProductCatalog4' => 'Зарезервировано',
);

$app_list_strings["oqc_task_status_list"] = array (
    'Not Started' => 'Не начато',
    'In Progress' => 'В процессе',
    'Completed' => 'Завершено',
    'Pending Input' => 'Ожидание',
    'Deferred' => 'Отложено',
);

$app_list_strings["oqc_task_user_status_list"] = array (
    'Not Started' => 'Не начато',
    'In Progress' => 'В процессе',
    'Completed' => 'Завершено',
);

$app_list_strings["oqc_task_resolution_list"] = array (
    'None' => 'Нет',
    'Accepted' => 'Принято',
    'Corrected' => 'Принято с исправлениями',
    'Rejected' => 'Отклонено',
    'Duplicate' => 'Дубликат',
    'Out of Date' => 'Просрочено',
    'Invalid' => 'Неприменимо',
    'Other' => 'Другое',
);

$app_list_strings["oqc_task_priority_list"] = array (
        'High' => 'Высокий',
        'Medium' => 'Средний',
        'Low' => 'Низкий',
);

$app_list_strings["record_type_display_notes"]["oqc_Task"] =  'Групповая задача';
    

$app_list_strings["oqc_parent_type_display_list"] = array (
    'oqc_Product' => 'Продукт',
    'oqc_Offering' => 'Предложение',
    'oqc_Contract' => 'Контракт',
    'oqc_Addition' => 'Дополнение',
    'oqc_Task' => 'Групповая задача',
    'oqc_ProductCatalog' => 'Каталог продуктов',
);

$app_list_strings["oqc_task_finished_list"] = array (
        'InProgress' => 'Нет',
        'Finished' => 'Да',
);

$app_list_strings["oqc_task_accepted_list"] = array (
        'notAccepted' => 'Не принято',
        'accepted' => 'Принято',
        'decline' => 'Отклонено',
);
$app_list_strings["oqc_task_abbreviation_list"] = array (
  'Tsk' => 'Здч',
  'Apr' => 'Подтв',
  'Sgn' => 'Подп',
 );
$app_list_strings["oqc_reminder_interval_options"] = array (
    '-2' => 'разово',
    '1' => 'раз в день',
    '3' => 'раз в 3 дня',
    '7' => 'раз в неделю',
);
 
//Some default settings DO NOT TRANSLATE!
$app_list_strings['oqc_dropdowns_default']['oqc_parent_type_default_key'] = 'oqc_Task';
$app_list_strings['oqc_dropdowns_default']['oqc_priority_default_key'] = 'Medium';
$app_list_strings['oqc_dropdowns_default']['oqc_remind_default_key'] = '1';
//$app_list_strings['oqc_dropdowns_default']['oqc_accept_status_default_key'] = 'notAccepted';
//$app_list_strings['oqc_dropdowns_default']['oqc_progress_default_key'] = 'Not Started';
//$app_list_strings['oqc_dropdowns_default']['oqc_resolution_default_key'] = 'None';
$app_strings['LBL_OQC_PRODUCT_DELETE'] = 'Продует более не доступен';
$app_strings['LBL_OQC_PRODUCT_INACTIVE'] = 'Продукт не активен';

?>


