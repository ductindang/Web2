<?php
if(!empty($_POST)) {
    $id = getPost('id');
    $name = getPost('name');
    $created_date = $updated_at = date("Y-m-d H:i:s");
    if($id > 0) {
        //update
        $sql = "UPDATE brand SET name = '$name' WHERE id = $id";
        execute($sql);
        echo '<div class="alert alert-success" role="alert">Chúc mừng bạn đã sửa danh mục thành công!</div>';
        die();
    } else {
        //insert
        $sql = "INSERT INTO brand (name, deleted) VALUES ('$name', 0)";
        execute($sql);
        echo '<div class="alert alert-success" role="alert">Chúc mừng bạn đã thêm danh mục thành công!</div>';
        die();
    }
}
?>
