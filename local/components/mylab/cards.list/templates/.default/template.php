<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div class="list">
    <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
        <div>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.NUMBER') ?> <?= $arItem['CARD_NUMBER'] ?></p>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.USER') ?> <?= $arItem['CARD_USER'] ?></p>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.TYPE') ?> <?= $arItem['CARD_TYPE'] ?></p>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.COST') ?> <?= $arItem['CARD_MAINTENANCE_COST'] ?></p>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.PERIOD') ?> <?= $arItem['CARD_VALID_PERIOD'] ?></p>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.EXP_DATA') ?> <?= $arItem['CARD_EXPIRATION_DATE'] ?></p>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.TOTAL_COST') ?> <?= $arItem['CARD_TOTAL_COST'] ?></p>
            <p><?= Loc::getMessage('MYLAB.CARD.LIST.SECRET') ?> <?= $arItem['CARD_SECRET'] ?></p>
        </div>
        <hr>
    <?php } ?>
</div>