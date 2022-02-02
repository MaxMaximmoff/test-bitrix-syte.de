<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>

<?php
$APPLICATION->IncludeComponent(
  'mylab:emails.list',
  'grid',
  [

  ]
);
?>

<?php
//$APPLICATION->IncludeComponent(
//    'ylab:email.manager',
//    '',
//    []
//);
//?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php'; ?>
