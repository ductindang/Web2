<?php
session_start();
require_once('../../utils/utility.php');
require_once('../../database/dbhelper.php');

$user = getUserToken();
if($user == null) {
    die();
}

if (!empty($_POST)) {   
    $action = getPost('action');
    switch ($action) {
        case 'delete':
            deleteCategory();
            break;
    }
}

function deleteCategory() {
    $id = getPost('id');
    $sql = "select count(*) as total from product where category_id= '$id' and deleted = 0";
    $data = executeResult($sql, true);
    $total = $data[0]['total'];
    
    if ($total > 0) {
        echo 'Danh mục đang chứa sản phẩm không được xóa';
        die();
    }
    
    $sql = "update category set deleted = 1 where id = $id";
    execute($sql);
    die();
}
?>
