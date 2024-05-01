<?php
if(!empty($_POST)) {
	$id = getPost('id');
	$name = getPost('name');
	$price = getPost('price');
	$brand_id=getPOST('brand_id');
	$inventory_qty=getPOST('inventory_qty');
	$enter_price = getPost('enter_price');
	$featured_image = moveFile('featured_image');
	$description = getPost('description');
	$category_id = getPost('category_id');
	$created_date = $updated_at = date("Y-m-d H:i:s");
	if($id > 0) {
		//update
		if($featured_image != '') {
			$sql = "update Product set brand_id='$brand_id',inventory_qty='$inventory_qty',  featured_image = '$featured_image', name = '$name', price = $price, enter_price = $enter_price, description = '$description', updated_at = '$updated_at', category_id = '$category_id' where id = $id";
		} else {
			$sql = "update Product set brand_id='$brand_id',inventory_qty='$inventory_qty', name = '$name', price = $price, enter_price = $enter_price, description = '$description', updated_at = '$updated_at', category_id = '$category_id' where id = $id";
		}
		execute($sql);
		echo '<div class="alert alert-success" role="alert">Chúc mừng bạn đã sửa sản phẩm thành công!</div>';
		die();
	} else {
		//insert
		$sql = "insert into Product(brand_id,inventory_qty,featured_image, name, price, enter_price, description, updated_at, created_date, deleted, category_id)
		 values ('$brand_id','$inventory_qty','$featured_image', '$name', '$price', '$enter_price', '$description', '$updated_at', '$created_date', 0, $category_id)";
		execute($sql);
		echo '<div class="alert alert-success" role="alert">Chúc mừng bạn đã thêm sản phẩm thành công!</div>';
		die();
	}
}