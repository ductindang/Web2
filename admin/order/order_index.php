<?php
$title = 'Quản Lý Đơn Hàng';
$baseUrl = '../';
require_once('../layouts/header.php');

// Khởi tạo biến $sql
$sql = "";

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$search_customer = isset($_GET['search_customer']) ? $_GET['search_customer'] : '';

// Kiểm tra và xử lý yêu cầu tìm kiếm khách hàng
if ($search_customer !== '') {
    $sql = "SELECT * FROM `order` WHERE cus_fullname LIKE '%$search_customer%' OR cus_mobile LIKE '%$search_customer%' OR cus_address LIKE '%$search_customer%'";
} else {
    // Nếu không có yêu cầu tìm kiếm, gán giá trị mặc định cho $sql
    $sql = "SELECT * FROM `order`";
}

// Kiểm tra và xử lý lọc theo ngày
if ($start_date !== '' && $end_date !== '') {
    // Thêm điều kiện vào câu truy vấn SQL để lọc đơn hàng theo ngày
    $sql .= " WHERE created_date BETWEEN '$start_date' AND '$end_date'";
}

$data = executeResult($sql);
?>
	
	<div class="row" style="margin-top: 20px;">
    <div class="col-md-12 table-responsive">
        <h1 class=" badge-pill badge-primary" style="display:flex;justify-content: center;padding: 10px;">Quản Lý Đơn Hàng</h1>
		
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
	<div class="form-group col-md-12 mt-4">
    <input type="text" id="search_customer" class="form-control" placeholder="Nhập tên khách hàng...">
    <button onclick="searchOrder()" class="btn btn-primary mt-3">Tìm kiếm</button>
</div>

		<table class="table table-bordered table-hover table-striped" style="margin-top: 20px;">
		<thead class="thead-light">
				<tr>
					<th style=" padding: 10px;font-size: 16px;">STT
						
					</th>
					<th style=" padding: 10px;font-size: 16px;">Họ & Tên
					<button onclick="sortTable(1, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(1, false)" class="btn btn-primary btn-sm">▼</button>
					</th>
					<th style=" padding: 10px;font-size: 16px;">SĐT
					<button onclick="sortTable(2, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(2, false)" class="btn btn-primary btn-sm">▼</button>
					</th>
					<th style=" padding: 10px;font-size: 16px;">Địa Chỉ
					<button onclick="sortTable(3, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(3, false)" class="btn btn-primary btn-sm">▼</button>
					</th>
					
					<th>Ngày Tạo
					<button onclick="sortTable(4, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(4, false)" class="btn btn-primary btn-sm">▼</button>
					</th>
					<th style=" padding: 10px;font-size: 16px; width: 130px; ">Hình thức thanh toán
					<button onclick="sortTable(5, true)" class="btn btn-primary btn-sm">▲</button>
    <button onclick="sortTable(5, false)" class="btn btn-primary btn-sm">▼</button>
					</th>

				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['cus_fullname'].'</a></td>
					<td><a href="detail.php?id='.$item['id'].'">'.$item['cus_mobile'].'</a></td>					
					<td>'.$item['cus_address'].'</td>
					<td>'.$item['created_date'].'</td>
					<td style="width: 50px " >';
					
					if ($item['payment_method'] == 0) {
						echo  '<span class=" badge-pill badge-success">COD</span>'; 
					} elseif ($item['payment_method'] == 1) {
						echo '<span class="badge-pill badge-info">BANK</span>';
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
	function searchOrder() {
        // Lấy giá trị từ trường nhập liệu tìm kiếm
        var searchKeyword = document.getElementById('search_customer').value.trim();

        // Tạo URL mới với tham số search_customer
        var url = window.location.pathname + '?';
        if (searchKeyword !== '') {
            url += 'search_customer=' + encodeURIComponent(searchKeyword);
        }
        // Chuyển hướng đến URL mới
        window.location.href = url;
    }

</script>
<script type="text/javascript">
	function changeStatus(id, status ) {
		$.post('form_api.php', {
			'id': id,
			'status': status ,
			'action': 'update_status'
		}, function(data) {
	if(data != null && data != ''){
		//alert(data);
		return;
	}
		location.reload
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