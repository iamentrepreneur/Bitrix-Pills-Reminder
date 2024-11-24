<?

require_once __DIR__ . '/../../vendor/autoload.php';
((file_exists(__DIR__ . "/..//constants.php")) && require_once(__DIR__ . "/../constants.php"));

use Local\Lib\ReminderLogger;
use Local\Lib\TelegramNotifier;

//AddEventHandler("main", "OnBeforeProlog", "myMock", 50);

function myMock(): void
{
   global $USER;
   if(!is_object($USER)){
      $USER = new CUser();
   }
   if (!$USER->IsAdmin()){
      include($_SERVER["DOCUMENT_ROOT"] . "/coming-soon/site_closed.php");
      die();
   }
}

function sendRemindersAgent()
{
    $currentTime = (new \Bitrix\Main\Type\DateTime())->format("H:i");

    // ID HL-блока с напоминаниями
    $hlblockId = 2;
    // ID HL-блока логов
    $logHlblockId = 3;

    $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlblockId)->fetch();
    if (!$hlblock) return;

    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();

    $logger = new ReminderLogger($logHlblockId);
    $notifier = new TelegramNotifier("YOUR_TELEGRAM_BOT_TOKEN");

    $reminders = $entityClass::getList([
        "filter" => [
            "=UF_START_DATE" => new \Bitrix\Main\Type\DateTime(),
            ">=UF_END_DATE" => new \Bitrix\Main\Type\DateTime(),
            "UF_REMINDER_TIMES" => "%\"$currentTime\"%",
        ],
    ])->fetchAll();

    foreach ($reminders as $reminder) {
        try {
            $chatId = $reminder["UF_TELEGRAM_ID"];
            $message = "Напоминание: " . $reminder["UF_NAME"];
            $notifier->sendMessage($chatId, $message);

            $logger->logReminder($reminder["ID"], $reminder["UF_TELEGRAM_ID"], 451, "Сообщение отправлено");
        } catch (Exception $e) {
            $logger->logReminder($reminder["ID"], $reminder["UF_TELEGRAM_ID"], 452, $e->getMessage());
        }
    }

    // Агенты должны возвращать своё имя
    return "sendRemindersAgent();";
}
