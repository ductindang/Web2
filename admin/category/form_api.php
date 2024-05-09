<?php
session_start();
require_once('../../utils/utility.php');
require_once('../../database/dbhelper.php');

$user = getUserToken();
if($user == null) {
    die();
}

if(!empty($_POST)) {
    $action = getPost('action');

    switch ($action) {
        case 'delete':
            deleteCategory();
            break;
    }
}

function deleteCategory() {
    $id = getPost('id');
    $updated_at = date("Y-m-d H:i:s");
    $sql = "UPDATE category SET deleted = 1 WHERE id = $id";
    execute($sql);
}
?>
