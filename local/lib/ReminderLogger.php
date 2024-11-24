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
    public function logReminder($reminderId, $userId, $status, $details = ""): void
    {
        Loader::includeModule("highloadblock");
        $hlblock = HL\HighloadBlockTable::getById($this->hlBlockId)->fetch();
        if (!$hlblock) {
            throw new Exception("Highload-блок для логов не найден");
        }

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entityClass = $entity->getDataClass();

        $result = $entityClass::add([
            "UF_REMINDER_ID" => $reminderId,
            "UF_STATUS" => $status,
            "UF_DETAILS" => $details,
            "UF_SENT_TIME" => new \Bitrix\Main\Type\DateTime(),
        ]);

        if (!$result->isSuccess()) {
            throw new Exception("Ошибка записи лога: " . implode(", ", $result->getErrorMessages()));
        }
    }
}
