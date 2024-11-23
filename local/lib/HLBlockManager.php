<?php

namespace Local\Lib;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

class HLBlockManager
{
    private $entityDataClass;

    /**
     * Конструктор класса
     *
     * @param int $hlblockId ID Highload-блока
     * @throws \Bitrix\Main\LoaderException
     */
    public function __construct(int $hlblockId)
    {
        Loader::includeModule("highloadblock");
        $hlblock = HL\HighloadBlockTable::getById($hlblockId)->fetch();

        if (!$hlblock) {
            throw new \Exception("Highload-блок с ID $hlblockId не найден.");
        }

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $this->entityDataClass = $entity->getDataClass();
    }

    /**
     * Добавление записи
     *
     * @param array $data Данные для добавления
     * @return int ID добавленной записи
     * @throws \Exception
     */
    public function add(array $data): int
    {
        $result = $this->entityDataClass::add($data);
        if ($result->isSuccess()) {
            return $result->getId();
        } else {
            throw new \Exception(implode(', ', $result->getErrorMessages()));
        }
    }

    /**
     * Получение записей
     *
     * @param array $filter Фильтр для выборки
     * @param array $select Поля для выборки
     * @return array Массив записей
     */
    public function getList(array $filter = [], array $select = ['*']): array
    {
        $result = $this->entityDataClass::getList([
            'select' => $select,
            'filter' => $filter,
        ]);

        $items = [];
        while ($row = $result->fetch()) {
            $items[] = $row;
        }

        return $items;
    }

    /**
     * Обновление записи
     *
     * @param int $id ID записи
     * @param array $data Данные для обновления
     * @throws \Exception
     */
    public function update(int $id, array $data): void
    {
        $result = $this->entityDataClass::update($id, $data);
        if (!$result->isSuccess()) {
            throw new \Exception(implode(', ', $result->getErrorMessages()));
        }
    }

    /**
     * Удаление записи
     *
     * @param int $id ID записи
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        $result = $this->entityDataClass::delete($id);
        if (!$result->isSuccess()) {
            throw new \Exception(implode(', ', $result->getErrorMessages()));
        }
    }
}
