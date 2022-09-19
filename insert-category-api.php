<?php

require __DIR__ . './connect.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, // 除錯用的
];

if (empty($_POST['product_category'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}









// TODO: 檢查欄位資料

$sql2 = "INSERT INTO `product_category`(`product_category`,`brand`,`gender`
    ) VALUES (?, ?, ?)";

$stmt = $pdo->prepare($sql2);





//篩選圖片最新編號
$select_sql =
    "SELECT  `picture` FROM `product`  ORDER BY `sid` DESC LIMIT 1;";
$pic_lastid = $pdo->query($select_sql)->fetch(PDO::FETCH_NUM)[0];

//取代雙引號
$pic_last_id = str_replace('"', '', $pic_lastid);
//只取數字
$pic_int_id = substr($pic_last_id, 2, 4);


try {
    $stmt->execute([
        $_POST['product_category'],
        $_POST['brand'],
        $_POST['gender'],
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有新增';
}




echo json_encode($output, JSON_UNESCAPED_UNICODE);
