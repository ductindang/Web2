<link rel="stylesheet"type="text/css" href="../../assets/css/dashboard.css">
<?php

	$title = 'Quản Lý Người Dùng';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	
  $sql ="select user.*, Role.name as role_name from user left join Role on User.role_id = Role.id where user.is_active=1";
	    // Check if there's a search query
		$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
		if ($searchKeyword !== '') {
			// Add search condition to SQL query
			$sql .= " AND (user.name LIKE '%$searchKeyword%' OR user.email LIKE '%$searchKeyword%' OR user.mobile LIKE '%$searchKeyword%' OR user.address LIKE '%$searchKeyword%' OR Role.name LIKE '%$searchKeyword%')";
		}
	
	
 
 
  $data = executeResult($sql);
	


?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
	<h1 class=" badge-pill badge-primary" style="display:flex;justify-content: center;padding: 10px;">Quản Lý Người Dùng</h1>
		

		<a href="editor.php"><button class="btn btn-success">Thêm Tài Khoản</button></a>

		<div class="form-group col-md-12 mt-4">
    <input type="text" id="search_customer" class="form-control" placeholder="Nhập tên khách hàng...">
    <button onclick="searchUser()" class="btn btn-primary mt-3">Tìm kiếm</button>
</div>
	
		
		<table class="table table-bordered table-hover table-striped" style="margin-top: 20px;">
			<thead class="thead-light"> 
				<tr>
					<th>STT</th>
					<th>Họ & Tên</th>
					<th>Email</th>
					<th>SĐT</th>
					<th>Địa Chỉ</th>
					<th>
    <div style="display: flex; align-items: center;">
        <span style="margin-right: auto;">Quyền</span>
        <!-- Thêm nút lên và nút xuống cho cột Quyền -->
        <button onclick="sortTable(5, true)" class="btn btn-primary btn-sm">▲</button>
        <button onclick="sortTable(5, false)" class="btn btn-primary btn-sm">▼</button>
    </div>
</th>
					
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
					<td>'.$item['name'].'</td>
					<td>'.$item['email'].'</td>
					<td>'.$item['mobile'].'</td>
					<td>'.$item['address'].'</td>
					<td   >'.$item['role_name'].'</td>
					<td style="width: 50px">
						<a href="privilege.php?id='.$item['id'].'"><button class="btn badge-info">Phân quyền</button></a>
					</td>
					<td style="width: 50px">
						<a href="editor.php?id='.$item['id'].'"><button class="btn btn-warning">Sửa</button></a>
					</td>
					<td style="width: 50px">';
		if( $item['role_id'] != 1) {
			echo '<button onclick="deleteUser('.$item['id'].')" class="btn btn-danger">Xoá</button>';
		}
		echo '
					</td>
				</tr>';
	}
?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function deleteUser(id) {
    Swal.fire({
        title: 'Bạn chắc chắn muốn xoá tài khoản này?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Nếu người dùng nhấn vào nút Xoá, thực hiện xoá sản phẩm
            $.post('form_api.php', {
                'id': id,
                'action': 'delete'
            }, function(data) {
                location.reload();
            });
        }
    });
}
	
</script>

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
	
    function searchUser() {
        // Get the value from the search input field
        var searchKeyword = document.getElementById('search_customer').value.trim();

        // If search keyword is not empty, redirect to the page with the search query
        if (searchKeyword !== '') {
            window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?search=' + encodeURIComponent(searchKeyword);
        }
    }

</script>

<?php
	require_once('../layouts/footer.php');
?>