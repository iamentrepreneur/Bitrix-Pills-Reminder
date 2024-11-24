<?
require_once __DIR__ . '/../vendor/autoload.php';
((file_exists(__DIR__ . "/constants.php")) && require_once(__DIR__ . "/constants.php"));

use Bitrix\Main\Loader;
use Local\Lib\ReminderLogger;
use Local\Lib\TelegramNotifier;


function sendRemindersAgent()
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

    $reminders = $entityClass::getList([
        "filter" => [
            "=UF_START_DATE" => new \Bitrix\Main\Type\DateTime(),
            ">=UF_END_DATE" => new \Bitrix\Main\Type\DateTime(),
            "UF_REMINDER_TIMES" => "%\"$currentTime\"%",
        ],
    ])->fetchAll();

    $manualDebug = "\n---------START----------\n";
    $manualDebug .= date("Y.m.d G:i:s") . "\n";
    $manualDebug .= print_r($reminders, true) . "\n";
    $manualDebug .= "\n----------END-----------\n";
    file_put_contents(__DIR__.'/reminders.txt', $manualDebug);

    foreach ($reminders as $reminder) {
        try {
            $chatId = $reminder["UF_TELEGRAM_ID"];
            $message = "Напоминание: " . $reminder["UF_MEDICATION_NAME"];
            $notifier->sendMessage($chatId, $message);

            $logger->logReminder($reminder["ID"], $reminder["UF_USER_ID"],451, "Сообщение отправлено", $chatId);
        } catch (Exception $e) {
            $logger->logReminder($reminder["ID"], $reminder["UF_USER_ID"],452, $e->getMessage(), $chatId);
        }
    }

    return "sendRemindersAgent();";
}
