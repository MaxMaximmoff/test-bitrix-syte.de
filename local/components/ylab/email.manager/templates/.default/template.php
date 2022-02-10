<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<table border="1">
    <tr>
        <?php
        foreach ($arResult['HEADER'] as $header) {
            ?>
            <td><?= $header ?></td>
            <?php
        }
        ?>
    </tr>
    <?php
    foreach ($arResult['PROFILES'] as $profile) {
        ?>
        <tr>
            <td><?= $profile['ID'] ?></td>
            <td><?= $profile['NAME'] ?></td>
            <td><?= $profile['EMAIL'] ?></td>
            <td><?= $profile['ADDRESS'] ?></td>
            <td><?= $profile['MAIL_MANAGER_ORM_EMAILS_ADDR_CITY'] ?></td>
            <td><?= $profile['MAIL_MANAGER_ORM_EMAILS_ADDR_STREET'] ?></td>
            <td><?= $profile['MAIL_MANAGER_ORM_EMAILS_ADDR_HOUSE'] ?></td>
        </tr>
        <?php
    }
    ?>
</table>
