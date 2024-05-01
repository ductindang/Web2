
<?php


	$title = 'Quản Lý Sản Phẩm';
	$baseUrl = '../';
	require_once('../layouts/header.php');
	require_once($baseUrl.'../utils/utility.php');
    require_once($baseUrl.'../database/dbhelper.php');
	
	


	$sql = "SELECT Product.*, Category.name AS category_name, Brand.name AS brand_name 
	FROM Product 
	LEFT JOIN Category ON Product.category_id = Category.id 
	LEFT JOIN Brand ON Product.brand_id = Brand.id 
	WHERE Product.deleted = 0";

// Xử lý lọc theo ngày
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Kiểm tra xem ngày bắt đầu và kết thúc có được cung cấp không
if ($start_date !== '' && $end_date !== '') {
    // Thêm điều kiện vào câu truy vấn SQL để lọc sản phẩm theo ngày
    $sql .= " AND Product.created_date BETWEEN '$start_date' AND '$end_date'";
}



$data = executeResult($sql);



?>
<script type="text/javascript">
   function applyFilter() {
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        // Tạo URL mới với tham số start_date và end_date
        var url = window.location.pathname + '?';
        if (startDate !== '' && endDate !== '') {
            url += 'start_date=' + startDate + '&end_date=' + endDate;
        }
        // Chuyển hướng đến URL mới
        window.location.href = url;
    }
</script>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h>Quản Lý Đơn Hàng</h	3>
	
		<div class="row">
    <div class="col-md-3">
        <label for="start_date">Từ ngày:</label>
        <input type="date" class="form-control" id="start_date" name="start_date">
    </div>
    <div class="col-md-3">
        <label for="end_date">Đến ngày:</label>
        <input type="date" class="form-control" id="end_date" name="end_date">
    </div>
    <div class="col-md-2">
        <button onclick="applyFilter()" class="btn btn-primary" style="margin-top: 30px;">Lọc</button>
    </div>
</div>
   
   
</div>
<?php if (checkPrivilege('product_add.php')) { ?> 
	<a href="editor.php"><button class="btn btn-success">Thêm Sản Phẩm</button></a>
	
<?php } ?>	

		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Thumbnail</th>
					<th style=" padding: 10px;font-size: 16px;">
            Tên Sản Phẩm
            <!-- Thêm nút lên và nút xuống cho cột Tên Sản Phẩm -->
            <button onclick="sortTable(2, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(2, false)" class="btn btn-primary btn-sm">▼</button>
        </th>
					<th style=" padding: 10px 20px;font-size: 16px;">
					Nhãn hiệu
						<!-- Thêm nút lên và nút xuống cho cột Tên Sản Phẩm -->
						<button onclick="sortTable(3, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(3, false)" class="btn btn-primary btn-sm">▼</button>
					</th>
					<th style=" padding: 10px;font-size: 16px;">
					Số lượng tồn
					<!-- Thêm nút lên và nút xuống cho cột Tên Sản Phẩm -->
					<button onclick="sortTable(4, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(4, false)" class="btn btn-primary btn-sm">▼</button>

					</th>
					<th style=" padding: 10px 60px;font-size: 16px;">
					Mô tả
						<!-- Thêm nút lên và nút xuống cho cột Tên Sản Phẩm -->
						<button onclick="sortTable(5, true)" class="btn btn-primary btn-sm" >▲</button>
    <button onclick="sortTable(5, false)" class="btn btn-primary btn-sm">▼</button>

					</th>
					<th style=" padding: 10px 20px;font-size: 16px;">Giá nhập
						<!-- Thêm nút lên và nút xuống cho cột Tên Sản Phẩm -->
						<button onclick="sortTable(6, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(6, false)" class="btn btn-primary btn-sm">▼</button>
					</th>
					<th style=" padding: 10px 20px;font-size: 16px;">Giá bán
						<!-- Thêm nút lên và nút xuống cho cột Tên Sản Phẩm -->
						<button onclick="sortTable(7, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(7, false)" class="btn btn-primary btn-sm">▼</button>
					</th>
					<th style=" padding: 10px 20px;font-size: 16px;">Danh Mục
						<!-- Thêm nút lên và nút xuống cho cột Tên Sản Phẩm -->
						<button onclick="sortTable(8, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(8, false)" class="btn btn-primary btn-sm">▼</button>
					</th >
					<th style="width: 50px"></th>
					<th style="width: 50px"></th>
				</tr>
			</thead>
			<tbody>
<?php
$index = 0;
foreach($data as $item) {
    echo '<tr>
                <th>'.(++$index).'</th>
                <td><img src="'.($item['featured_image']).'" style="height: 100px"/></td>
                <td>'.$item['name'].'</td>
                <td>'.$item['brand_name'].'</td>
                <td>'.$item['inventory_qty'].'</td>
                <td>'.$item['description'].'</td>
                <td>'.number_format($item['enter_price']).' VNĐ</td>
                <td>'.number_format($item['price']).' VNĐ</td>
                <td>'.$item['category_name'].'</td>
                <td style="width: 50px">';

    // Kiểm tra quyền truy cập và hiển thị nút "Sửa"
    if (checkPrivilege('product_edit.php')) {
        echo '<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>';
    }

    echo '</td>
            <td style="width: 50px">';

    // Kiểm tra quyền truy cập và hiển thị nút "Xóa"
    if (checkPrivilege('product_delete.php')) {
        echo '<button onclick="deleteProduct('.$item['id'].')" class="btn btn-danger">Xoá</button>';
    }

    echo '</td>
          </tr>';
}
?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function deleteProduct(id) {
		option = confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')
		if(!option) return;

		$.post('form_api.php', {
			'id': id,
			'action': 'delete'
		}, function(data) {
			location.reload()
		})
		
	}
	
</script>
<script type="text/javascript">
    function sortTable(columnIndex, ascending) {
        var table = document.querySelector('table');
        var rows = Array.from(table.querySelectorAll('tbody tr'));

        // Sắp xếp các hàng dựa trên giá trị của cột columnIndex
        rows.sort(function(rowA, rowB) {
            var valueA = rowA.cells[columnIndex].textContent.trim();
            var valueB = rowB.cells[columnIndex].textContent.trim();
            if (ascending) {
                return valueA.localeCompare(valueB);
            } else {
                return valueB.localeCompare(valueA);
            }
        });

        // Xóa tất cả các hàng trong bảng
        while (table.querySelector('tbody').firstChild) {
            table.querySelector('tbody').removeChild(table.querySelector('tbody').firstChild);
        }

        // Thêm lại các hàng đã sắp xếp vào bảng
        rows.forEach(function(row) {
            table.querySelector('tbody').appendChild(row);
        });
    }
</script>

<?php
	require_once('../layouts/footer.php');
?>