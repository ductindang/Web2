<link rel="stylesheet"type="text/css" href="../../assets/css/dashboard.css">
<?php

	$title = 'Quản Lý Người Dùng';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	
  $sql ="select user.*, Role.name as role_name from user left join Role on User.role_id = Role.id where user.is_active=1";
	$data = executeResult($sql);
	
	// Sắp xếp
	if(isset($_GET['sort_option']) && !empty($_GET['sort_option'])) {
		$sort_option = $_GET['sort_option'];
		$sort_option_parts = explode("-", $sort_option);
		$column_name = $sort_option_parts[0];
		$sort_order = strtoupper($sort_option_parts[1]);
		$sql .= " ORDER BY $column_name $sort_order";
	}

	$data = executeResult($sql);

?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Quản Lý Người Dùng</h3>

		<a href="editor.php"><button class="btn btn-success">Thêm Tài Khoản</button></a>

		
		<div class="row">
			<div class="col-md-3">
				<select class="form-control" id="sort_option">
					<option value="">Chọn tiêu đề để sắp xếp</option>
					<option value="id-asc">Mã tăng dần</option>
					<option value="id-desc">Mã giảm dần</option>
					<option value="name-asc">Họ & Tên tăng dần</option>
					<option value="name-desc">Họ & Tên giảm dần</option>
					<option value="email-asc">Email tăng dần</option>
					<option value="email-desc">Email giảm dần</option>
					<option value="mobile-asc">SĐT tăng dần</option>
					<option value="mobile-desc">SĐT giảm dần</option>
					<option value="role_name-asc">Quyền tăng dần</option>
					<option value="role_name-desc">Quyền giảm dần</option>
				</select>
				
			</div>
			
			
		</div>
		<div class="col-md-2">
        <button onclick="applyFilter()" class="btn btn-primary" style="margin-top: 30px;">Lọc</button>
    </div>
		
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Họ & Tên</th>
					<th>Email</th>
					<th>SĐT</th>
					<th>Địa Chỉ</th>
					<th>Quyền</th>
					<th>Phân Quyền</th>
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
					<td>'.$item['role_name'].'</td>
					<td style="width: 50px">
						<a href="privilege.php?id='.$item['id'].'"><button class="btn btn-warning">Phân quyền</button></a>
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
		option = confirm('Bạn có chắc chắn muốn xoá tài khoản này không?')
		if(!option) return;

		$.post('form_api.php', {
			'id': id,
			'action': 'delete'
		}, function(data) {
			location.reload()
		})
	}
	function applyFilter() {
     
        var sortOption = document.getElementById('sort_option').value;

        var queryString = "?";
       
        if(sortOption !== '') {
            if(queryString !== "?") {
                queryString += "&";
            }
            queryString += "sort_option=" + sortOption;
        }

        window.location.href = "index.php" + queryString;
    }
</script>
</script>

<?php
	require_once('../layouts/footer.php');
?>