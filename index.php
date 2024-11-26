<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Главная");
use Bitrix\Main\Loader;
use Local\Lib\ReminderLogger;
use Local\Lib\TelegramNotifier;
?>

<?
function testSendRemindersAgent(): void
{
    $currentTime = (new \Bitrix\Main\Type\DateTime())->format("H:i");

    $hlblockId = 2;
    $logHlblockId = 3;

    Loader::includeModule("highloadblock");
    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlblockId)->fetch();
    if (!$hlblock) exit();

    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();

    $logger = new ReminderLogger($logHlblockId);
    $notifier = new TelegramNotifier();

    $currentDate = new \Bitrix\Main\Type\DateTime();

    $reminders = $entityClass::getList([
        "filter" => [
            "<=UF_START_DATE" => $currentDate->format("d.m.Y"),
            ">=UF_END_DATE" => $currentDate->format("d.m.Y"),
//            "UF_REMINDER_TIMES" => "%\"$currentTime\"%",
        ],
    ])->fetchAll();

    echo "<pre>";
    print_r($reminders);
    echo "</pre>";

    foreach ($reminders as $reminder) {
        try {
            $chatId = $reminder["UF_TELEGRAM_ID"];
            $message = "Уже {$currentTime}, напоминанию: " . $reminder["UF_MEDICATION_NAME"];
//            $notifier->sendMessage($chatId, $message);

//            $logger->logReminder($reminder["ID"], $reminder["UF_USER_ID"],451, "Сообщение отправлено", $chatId);
        } catch (Exception $e) {
//            $logger->logReminder($reminder["ID"], $reminder["UF_USER_ID"],452, $e->getMessage(), $chatId);
        }
    }
}
?>

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>