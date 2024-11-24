<?php

namespace Local\Lib;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
use Exception;

class ReminderLogger
{
    private int $hlBlockId;

    public function __construct($hlBlockId)
    {
        $this->hlBlockId = $hlBlockId;
    }

    /**
     * @throws Exception
     */
    public function logReminder($reminderId, $userId, $status, $details = "", $chatId = null): void
    {
        Loader::includeModule("highloadblock");
        $hlblock = HL\HighloadBlockTable::getById($this->hlBlockId)->fetch();
        if (!$hlblock) {
            throw new Exception("Highload-блок для логов не найден");
        }

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();

        $result = $entityClass::add([
            "UF_USER_ID" => $userId,
            "UF_REMINDER_ID" => $reminderId,
            "UF_SENT_TIME" => new \Bitrix\Main\Type\DateTime(),
            "UF_STATUS" => $status,
            "UF_DETAILS" => $details,
            "UF_TELEGRAM_ID" => $chatId,
        ]);

        if (!$result->isSuccess()) {
            throw new Exception("Ошибка записи лога: " . implode(", ", $result->getErrorMessages()));
        }
    }
}
