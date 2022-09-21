<?php


require __DIR__ . '/connect.php';
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM `product` WHERE sid={$sid}";


$pdo->query($sql);

$come_from = 'product-list';

if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}


header("Location: {$come_from}");
