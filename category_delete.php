<?php


require __DIR__ . '/connect.php';
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE  FROM `product_category` WHERE sid={$sid}";


$pdo->query($sql);

$come_from = 'category-list';

if (!empty($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");
