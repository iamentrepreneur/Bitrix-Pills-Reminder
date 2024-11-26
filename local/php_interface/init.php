<?
require_once __DIR__ . '/../vendor/autoload.php';
((file_exists(__DIR__ . "/constants.php")) && require_once(__DIR__ . "/constants.php"));

use Bitrix\Main\Loader;
use Local\Lib\ReminderLogger;
use Local\Lib\TelegramNotifier;


function sendRemindersAgent()
{
    $currentTime = (new \Bitrix\Main\Type\DateTime())->format("H:i");

    $hlBlockId = 2;
    $logHlBlockId = 3;

    Loader::includeModule("highloadblock");
    $hlBlock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlBlockId)->fetch();
    if (!$hlBlock) exit();

    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlBlock);
    $entityClass = $entity->getDataClass();

    $logger = new ReminderLogger($logHlBlockId);
    $notifier = new TelegramNotifier();

    $currentDate = new \Bitrix\Main\Type\DateTime();

    $reminders = $entityClass::getList([
        "filter" => [
            "<=UF_START_DATE" => $currentDate->format("d.m.Y"),
            ">=UF_END_DATE" => $currentDate->format("d.m.Y"),
            "UF_REMINDER_TIMES" => "%\"$currentTime\"%",
        ],
    ])->fetchAll();

    foreach ($reminders as $reminder) {
        try {
            $chatId = $reminder["UF_TELEGRAM_ID"];
            $message = "Уже {$currentTime}, напоминанию: " . $reminder["UF_MEDICATION_NAME"];
            $notifier->sendMessage($chatId, $message);

            $logger->logReminder($reminder["ID"], $reminder["UF_USER_ID"],451, "Сообщение отправлено", $chatId);
        } catch (Exception $e) {
            $logger->logReminder($reminder["ID"], $reminder["UF_USER_ID"],452, $e->getMessage(), $chatId);
        }
    }

    return "sendRemindersAgent();";
}
