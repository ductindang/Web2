<?php
	$name = 'Thêm/Sửa Sản Phẩm';
	$baseUrl = '../';
	require_once('../layouts/header.php');

	$id = $featured_image = $name = $price=$inventory_qty=$brand_id = $enter_price = $category_id = $description = '';
	require_once('form_save.php');
  
	$id = getGet('id');
	if($id != '' && $id > 0) {
		$sql = "select * from Product where id = '$id' and deleted = 0";
		$userItem = executeResult($sql, true);
		if($userItem != null) {
			$featured_image = $userItem[0]['featured_image'];
			$name = $userItem[0]['name'];
			$inventory_qty = $userItem[0]['inventory_qty'];
			$brand_id= $userItem[0]['brand_id'];
			$price = $userItem[0]['price'];
			$enter_price = $userItem[0]['enter_price'];
			$category_id = $userItem[0]['category_id'];
			$description = $userItem[0]['description'];
		} else {
			$id = 0;
		}
	} else {
		$id = 0;
	}

	$sql = "select * from category";
	$categoryItems = executeResult($sql);
	$sql="select * from brand";
	$brandItems=executeResult($sql);
?>
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<div class="row" style="margin-top: 20px;">
	<div class="col-md-12 table-responsive">
		<h3>Thêm/Sửa Sản Phẩm</h3>
		<div class="panel panel-primary">
			<div class="panel-body">
				<form method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-9 col-12">
						<div class="form-group">
						  <label for="usr">Tên Sản Phẩm:</label>
						  <input required="true" type="text" class="form-control" id="name" name="name" value="<?=$name?>">
						  <input type="text" name="id" value="<?=$id?>" hidden="true">
						</div>
						<div class="form-group">
						  <label for="pwd">Nội Dung:</label>
						  <textarea class="form-control" rows="5" name="description" id="description"><?=$description?></textarea>
						</div>

						<button class="btn btn-success">Lưu Sản Phẩm</button>
					</div>
					<div class="col-md-3 col-12" style="border: solid grey 1px; padding-top: 10px; padding-bottom: 10px;">
						<div class="form-group">
						  <label for="featured_image">featured_image:</label>
						  <input type="file" class="form-control" id="featured_image" name="featured_image" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
						  <img id="thumbnail_img" src="<?=($featured_image)?>" style="max-height: 160px; margin-top: 5px; margin-bottom: 15px;">
						</div>

						<div class="form-group">
						  <label for="usr">Danh Mục Sản Phẩm:</label>
						  <select class="form-control" name="category_id" id="category_id" required="true">
						  	<option value="">-- Chọn --</option>
						  	<?php
						  		foreach($categoryItems as $item) {
						  			if($item['id'] == $category_id) {
						  				echo '<option selected value="'.$item['id'].'">'.$item['name'].'</option>';
						  			} else {
						  				echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
						  			}
						  		}
						  	?>
						  </select>
						</div>
						<div class="form-group">
						  <label for="usr">Nhãn hiệu:</label>
						  <select class="form-control" name="brand_id" id="brand_id" required="true">
						  	<option value="">-- Chọn --</option>
						  	<?php
						  		foreach($brandItems as $item) {
						  			if($item['id'] == $brand_id) {
						  				echo '<option selected value="'.$item['id'].'">'.$item['name'].'</option>';
						  			} else {
						  				echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
						  			}
						  		}
						  	?>
						  </select>
						</div>
						<div class="form-group">
						  <label for="enter_price">Giá nhập:</label>
						  <input required="true" type="text" class="form-control" id="enter_price" name="enter_price" value="<?=$enter_price?>">
						</div>
						<div class="form-group">
						  <label for="price">Giá:</label>
						  <input required="true" type="number" class="form-control" id="price" name="price" value="<?=$price?>">
						</div>
						<div class="form-group">
						  <label for="inventory_qty">Số lượng tồn:</label>
						  <input required="true" type="number" class="form-control" id="inventory_qty" name="inventory_qty" value="<?=$inventory_qty?>">
						</div>
					
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function updateThumbnail() {
		$('#thumbnail_img').attr('src', $('#featured_image').val())
	}
</script>
<script>
  $('#description').summernote({
    placeholder: 'Nhập nội dung dữ liệu',
    tabsize: 2,
    height: 300,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]
    ]
  });
</script>

<?php
	require_once('../layouts/footer.php');
?>