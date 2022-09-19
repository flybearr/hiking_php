<?php

require __DIR__ . '/connect.php';


// $postData = [
//     'product_sid' => "P0002",
//     'product_name' => '可伸縮拐杖老人杖手杖',
//     'product_category_sid' => '1',
//     'product_price' => '699',
//     'product_inventory' => '3'
// ];




//主鍵會自動生成，可以去掉
$sql = "INSERT INTO 
`product`
( `product_name`, `product_category_sid`, `product_price`, `product_inventory`) 
VALUES (?,?,?,?)";

$stmt = $pdo->prepare($sql);


for ($i = 0; $i < 20; $i++) {

    $name = '登山杖' . $i . '號';
    $product_category_sid = 1;
    $product_price = floor(rand(500, 2000));
    $product_inventory = $i;


    $stmt->execute([
        $name,
        $product_category_sid,
        $product_price,
        $product_inventory

    ]);
}


echo $stmt->rowCount();

//rowCount 會列出 匯入幾筆資料