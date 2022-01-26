<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/header.php';

$APPLICATION->SetTitle('Новости');

?><?php $APPLICATION->IncludeComponent("bitrix:news.list", "cardslist", [
    "IBLOCK_TYPE" => "cards",
    "IBLOCK_ID" => "7",
    "NEWS_COUNT" => "5",
    "PROPERTY_CODE" => [
        'CARD_NUMBER',
        'CARD_USER',
        'CARD_TYPE'
    ],

],
    false
); ?><?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>