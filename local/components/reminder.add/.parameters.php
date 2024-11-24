<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;

$arHLBlocks = [];
if (Loader::includeModule("highloadblock")) {
    $hlBlocks = HighloadBlockTable::getList([
        "select" => ["ID", "NAME"],
        "order" => ["NAME" => "ASC"]
    ]);
    while ($hlBlock = $hlBlocks->fetch()) {
        $arHLBlocks[$hlBlock["ID"]] = "[" . $hlBlock["ID"] . "] " . $hlBlock["NAME"];
    }
}

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        "HL_BLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => "ID Highload-блока",
            "TYPE" => "LIST",
            "VALUES" => $arHLBlocks,
            "DEFAULT" => "",
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "N",
        ],
        "CACHE_TIME" => ["DEFAULT" => 3600],
    ],
];
