<?php
    $title = 'Quản Lý Danh Mục';
    $baseUrl = '../';
    require_once('../layouts/header.php');
    require_once($baseUrl.'../utils/utility.php');
    require_once($baseUrl.'../database/dbhelper.php');


   

    $search_keyword = isset($_GET['search_keyword']) ? $_GET['search_keyword'] : '';

    // Truy vấn lấy dữ liệu từ bảng 'category' với điều kiện tìm kiếm
    $sql = "SELECT * FROM category WHERE deleted = 0";
    
    if ($search_keyword !== '') {
        $sql .= " AND name LIKE '%$search_keyword%'";
    }

    $data = executeResult($sql);

?>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-12 table-responsive">
        <h1 class="badge-pill badge-primary" style="display:flex;justify-content: center;padding: 10px;">Quản Lý Danh Mục</h1>
    </div>
    

    <?php if (checkPrivilege('category_add.php')) { ?>
        <div class="">    <a href="editor.php"><button class="btn btn-success ml-7 ">Thêm Danh Mục</button></a></div>

    <?php } ?>

    <div class="form-group">
    <input type="text" id="search_keyword" class="form-control mt-5" placeholder="Nhập từ khóa tìm kiếm...">
    <button onclick="searchCategory()" class="btn btn-primary m-1">Tìm kiếm</button>
    </div>
    <table class="table table-bordered table-hover table-striped" style="margin-top: 20px;">
        <thead class="thead-light">
            <tr>
                <th style="padding: 5px 5px;">
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: auto;">STT</span>
                    </div>
                </th>
                <th style="padding: 5px 5px;">
                    <div style="display: flex; align-items: center;">
                        <span style="margin-right: auto;">Tên Danh Mục</span>
                    </div>
                </th>
                <th style="width: 50px;"></th>
                <th style="width: 50px;"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $index = 0;
                foreach($data as $item) {
                    echo '<tr>
                            <th>'.(++$index).'</th>
                            <td>'.$item['name'].'</td>
                            <td style="width: 50px">';
                    
                    // Kiểm tra quyền truy cập và hiển thị nút "Sửa"
                    if (checkPrivilege('category_edit.php')) {
                    echo '<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>';
                    }
                    echo '</td>
                            <td style="width: 50px">';
                            if (checkPrivilege('category_delete.php')) {
                    // Hiển thị nút "Xoá" và kích hoạt hộp thoại xác nhận
                    echo '<button onclick="deleteCategory('.$item['id'].')" class="btn btn-danger">Xoá</button>';
                }
                    echo '</td>
                        </tr>';
                }
            ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    function deleteCategory(id) {
        Swal.fire({
            title: 'Bạn chắc chắn muốn xoá danh mục này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xoá',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng nhấn vào nút Xoá, thực hiện xoá danh mục
                $.post('form_api.php', {
                    'id': id,
                    'action': 'delete'
                }, function(data) {
                    location.reload();
                });
            }
        });
    }
    function searchCategory() {
    var searchKeyword = document.getElementById('search_keyword').value.trim();

    // Tạo URL mới với tham số search_keyword
    var url = window.location.pathname + '?';
    if (searchKeyword !== '') {
        url += 'search_keyword=' + encodeURIComponent(searchKeyword);
    }
    // Chuyển hướng đến URL mới
    window.location.href = url;
}
</script>

<?php
    require_once('../layouts/footer.php');
?>
