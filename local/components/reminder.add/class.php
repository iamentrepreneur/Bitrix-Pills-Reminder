<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Application;

class ReminderAddComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($params)
    {
        $params["HL_BLOCK_ID"] = isset($params["HL_BLOCK_ID"]) ? (int)$params["HL_BLOCK_ID"] : 0;
        return $params;
    }

    public function executeComponent(): void
    {
        if ($this->arParams["HL_BLOCK_ID"] <= 0) {
            ShowError("Не указан ID Highload-блока");
            return;
        }

        if (!Loader::includeModule("highloadblock")) {
            ShowError("Модуль Highload-блоков не подключен");
            return;
        }

        $this->handlePost();
        $this->includeComponentTemplate();
    }

    private function handlePost(): void
    {
        $request = Application::getInstance()->getContext()->getRequest();
        if ($request->isPost() && check_bitrix_sessid()) {
            $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($this->arParams["HL_BLOCK_ID"])->fetch();
            if (!$hlblock) {
                ShowError("Highload-блок не найден");
                return;
            }

            $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
            $entityClass = $entity->getDataClass();

            $timesPerDay = $request->getPost("UF_REMINDER_TIMES");
            if (!is_array($timesPerDay) || empty($timesPerDay)) {
                $this->arResult["ERRORS"][] = "Укажите хотя бы одно время напоминания.";
                return;
            }

            $timesPerDay = array_filter($timesPerDay, function ($time) {
                return !empty($time);
            });
            if (empty($timesPerDay)) {
                $this->arResult["ERRORS"][] = "Укажите хотя бы одно корректное время.";
                return;
            }
            $timesPerDayJson = json_encode(array_values($timesPerDay));

            $result = $entityClass::add([
                "UF_USER_ID" => $GLOBALS["USER"]->GetID(),
                "UF_MEDICATION_NAME" => $request->getPost("UF_MEDICATION_NAME"),
                "UF_START_DATE" => $this->handleDate($request->getPost("UF_START_DATE")),
                "UF_END_DATE" => $this->handleDate($request->getPost("UF_END_DATE")),
                "UF_REMINDER_TIMES" => $timesPerDayJson,
                "UF_TELEGRAM_ID" => $this->getUserFiled($GLOBALS["USER"]->GetID(), "UF_TELEGRAM_ID"),
            ]);

            if ($result->isSuccess()) {
                LocalRedirect('/create-remind/?success=1');
            } else {
                $this->arResult["ERRORS"] = $result->getErrorMessages();
            }
        }
    }

    public function handleDate(string $date): string
    {
        $dateFromPhp = \Bitrix\Main\Type\Date::createFromPhp(new \DateTime($date));
        return $dateFromPhp->format("d.m.Y H:i:s");
    }

    public function getUserFiled(int $userId, string $fieldName): ?string
    {
        $filter = ["ID" => $userId];
        $select = ["ID", $fieldName];
        $rsUser = CUser::GetList(($by = "id"), ($order = "asc"), $filter, ["SELECT" => $select]);

        if ($arUser = $rsUser->Fetch()) {
            return $arUser[$fieldName];
        } else {
            return null;
        }
    }
}
