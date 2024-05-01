<?php
	$title = 'Thông Tin Chi Tiết Đơn Hàng';
	$baseUrl = '../';
	require_once('../layouts/header.php');
	require_once('../../utils/utility.php');
	$orderId = getGet('id');

	$sql = "SELECT order_item.*, Product.name, Product.featured_image FROM order_item LEFT JOIN Product ON Product.id = order_item.product_id WHERE order_item.order_id = $orderId";
	$data = executeResult($sql);
	

	$sql = "SELECT * FROM `order` WHERE id = $orderId";
	$orderItem = executeResult($sql);

?>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
		<h3>Chi Tiết Đơn Hàng</h3>
	</div>
	<div class="col-md-8 table-responsive">
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th>STT</th>
					<th>Thumbnail</th>
					<th>Tên Sản Phẩm</th>
					<th>Giá</th>
					<th>Số Lượng</th>
					<th>Tổng Giá</th>
				</tr>
			</thead>
			<tbody>
<?php
	$index = 0;
	foreach($data as $item) {
		echo '<tr>
					<th>'.(++$index).'</th>
					<td><img src="'.fixUrl($item['featured_image']).'" style="height: 120px"/></td>
					<td>'.$item['name'].'</td>
					<td>'.$item['unit_price'].'</td>
					<td>'.$item['qty'].'</td>
					<td>'.$item['total_price'].'</td>
				</tr>';
	}
?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<th>Tổng Tiền</th>
					<th><?php echo isset($orderItem[0]['total_price']) ? $orderItem[0]['total_price'] : ''; ?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-4">
		<table class="table table-bordered table-hover" style="margin-top: 20px;">
			<tr>
				<th>Họ & Tên: </th>
				<td><?php echo isset($orderItem[0]['cus_fullname']) ? $orderItem[0]['cus_fullname'] : ''; ?></td>
			</tr>
			
			<tr>
				<th>Địa Chỉ: </th>
				<td><?php echo isset($orderItem[0]['cus_address']) ? $orderItem[0]['cus_address'] : ''; ?></td>
			</tr>
			<tr>
				<th>Phone: </th>
				<td><?php echo isset($orderItem[0]['cus_mobile']) ? $orderItem[0]['cus_mobile'] : ''; ?></td>
			</tr>
		</table>
	</div>
</div>
<?php
	require_once('../layouts/footer.php');
?>