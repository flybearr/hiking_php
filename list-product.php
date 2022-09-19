<?php require __DIR__ . '/connect.php' ?>


<?php
$pagename = 'product-list'; // 設置當前所在頁面
$prepage = 5; // 每頁5個
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  //設置第幾頁面，如果沒有預設都是第一頁
$t_sql = "SELECT count(1) FROM product ";







//輸出時是陣列 用pdo fetch_num去掉欄位，[0] 只取值 ，得到有幾行資料
$totalrows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//  $totalRows 當php從資料庫讀取出來的數字為字串  Ceil 無條件進位
$totalpage = ceil($totalrows / $prepage);
//總共幾筆 除以 每頁幾筆 取得 總共的頁數 


// 判斷資料是否有傳進來  >> 如果有再判斷頁數是否 小於1 or 大於總頁數，調整頁數上下限
if ($totalrows) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalpage) {
        header('Location: ?page=' . $totalpage);
        exit;
    }
    //因後方有%s 需要帶入 並用sprintf 來解決 sprintf(format,arg1,arg2,arg++)
    //litmit(起始index, 往後算多少個)
    $sql = sprintf("SELECT * FROM product ORDER BY `sid` DESC LIMIT %s,%s", ($page - 1) * $prepage, $prepage);

    //取出所有的資料
    $rows = $pdo->query($sql)->fetchAll();
}


$output = [
    'totalrows' => $totalrows,
    'totalrows' => $totalpage,
    'page' => $page,
    'row' => $rows,
    'prepage' => $prepage,
];




?>


<?php require __DIR__ . '/head.php'; ?>

<style>
    img {
        width: 200px;
        text-align: center;
    }
</style>

<?php require __DIR__ . '/nav.php'; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <li class="page-item <?= 1 == $page ? 'disabled' : 0 ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                        <li class="page-item <?= $i == $page ? 'active' : 0 ?>">
                            <a class="page-link" href=" ?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $totalpage == $page ? 'disabled' : 0 ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>

                </ul>
            </nav>
            <h1>商品</h1>
            <table class="table table-dark -columns">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>

                        <th scope="col">#</th>
                        <th scope="col">品名</th>
                        <th scope="col">種類編號</th>
                        <th scope="col">價格</th>
                        <th scope="col">庫存</th>
                        <th scope="col">產品說明</th>
                        <th scope="col">圖片</th>

                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>

                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['product_name'] ?></td>
                            <td><?= $r['product_category_sid'] ?></td>
                            <td><?= $r['product_price'] ?></td>
                            <td><?= $r['product_inventory'] ?></td>
                            <td><?= $r['product_description'] ?></td>
                            <td><img src="./picture/<?= $r['picture'] ?>" alt=""></td>

                            <td>
                                <a href="edit-form.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>






<?php require __DIR__ . '/script.php'; ?>
<script>
    function delete_it(sid) {
        if (confirm(`確定要刪除編號為${sid}的資料嗎?`)) {
            location.href = `product_delete.php?sid=${sid}`;
        }
    }
</script>
<?php require __DIR__ . '/foot.php'; ?>