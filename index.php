<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Главная");
?>

<?
//use Local\Lib\HLBlockManager;
//
//try {
//    $hlManager = new HLBlockManager(2); // ID Highload-блока
//    $reminders = $hlManager->getList();
//    print_r($reminders);
//} catch (\Exception $e) {
//    echo "Ошибка: " . $e->getMessage();
//}

echo $USER->getId()

?>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>