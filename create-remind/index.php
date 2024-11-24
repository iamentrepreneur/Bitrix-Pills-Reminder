<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Создать напоминание");
?>

<?
$APPLICATION->IncludeComponent(
    "reminder.add",
    "",
    [
        "HL_BLOCK_ID" => 1
    ]
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>