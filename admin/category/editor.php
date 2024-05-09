<?php
    $name = 'Thêm/Sửa Danh Mục';
    $baseUrl = '../';
    require_once('../layouts/header.php');

    $id = $name = '';
    require_once('form_save.php');
  
    $id = getGet('id');
    if($id != '' && $id > 0) {
        $sql = "SELECT * FROM category WHERE id = '$id'  ";
        $categoryItem = executeResult($sql, true);
        if($categoryItem != null) {
            $name = $categoryItem[0]['name'];
        } else {
            $id = 0;
        }
    } else {
        $id = 0;
    }
?>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-12 table-responsive">
        <h3>Thêm/Sửa Danh Mục</h3>
        <div class="panel panel-primary">
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label for="name">Tên Danh Mục:</label>
                        <input required="true" type="text" class="form-control" id="name" name="name" value="<?=$name?>">
                        <input type="text" name="id" value="<?=$id?>" hidden="true">
                    </div>
                    <button class="btn btn-success">Lưu Danh Mục</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('../layouts/footer.php');
?>
