<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>

<?$APPLICATION->IncludeComponent("bitrix:main.profile", "personal", Array(
	"CHECK_RIGHTS" => "N",	// Проверять права доступа
		"SEND_INFO" => "N",	// Генерировать почтовое событие
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"USER_PROPERTY" => array(	// Показывать доп. свойства
			0 => "UF_TELEGRAM_ID",
		),
		"USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>