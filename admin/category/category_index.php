
  <?php

      $title = 'Quản lý danh mục sản phẩm';
      $baseUrl=  '../';
      require_once('../layouts/header.php');
    
      
    
      require_once('../category/form_save.php');  
      require_once('../category/form_api.php');  
      
      $id=$name='';
      if (isset($_GET['id'])) {
          $id = getGET('id');
          $sql = "SELECT * FROM category WHERE id = $id";
          $data = executeResult($sql, true);
          if (!empty($data)) {
              $name = $data[0]['name']; // Access the first row
          }
      }
  

      $sql ="select * from category    WHERE category.deleted = 0";
      $data= executeResult($sql);
      ?>   <div class ="row" style="margin-top:20px;">
        <div class="col-md-12 ">
        <h3>Quản lý danh mục sản phẩm</h3>
        </div>
        <div class="col-md-6 " style="margin-top:20px">
        <form method="post" action="category_index.php" onsubmit="return validateForm();">
            <div class="form-group">
            <label for="usr" style="font-weight:bold;">Tên danh mục:</label>
            <input required="true" type="text" class="form-control" id="name" name="name" value="<?=$name?>">
          <input type="text" name ="id" value="<?=$id?>" hidden="true">
          <?php if (checkPrivilege('category_add.php')) { ?> 
           <button class="btn btn-success">Thêm</button>
	
          <?php } ?>	
          <?php if (checkPrivilege('category_edit.php')) { ?> 
            <button class="btn btn-success">Sửa</button>
	
          <?php } ?>	
                  </div>
              
              </form>  
              </div>

        <div class="col-md-12 table-responsive">
      

    
          <table class="table table-bordered table-hover  ">
          <thread>
            <tr>
            <th>STT</th>
              <th>Tên danh mục</th>
              
              <th style="width: 50px"></th>
              <th style="width: 50px"></th>
            </tr>

          </thread>
      <?php
      $index=0;
      foreach ($data as $item) {
         echo '<tr>
            <td>' . (++$index) . '</td>
            <td>' . $item['name'] . '</td>
            <td style="width: 50px">';
    
    // Kiểm tra quyền truy cập
    if (checkPrivilege('category_edit.php')) {
        echo '<a href="?id=' . $item['id'] . '"><button class="btn btn-warning">Sửa</button></a>';
    }
    echo '</td>
    <td style="width: 50px">';
        // Kiểm tra quyền truy cập
        if (checkPrivilege('category_delete.php')) {
            echo '<a href="#" onclick="deleteCategory(' . $item['id'] . '); return false;">
                      <button class="btn btn-danger">Xóa</button>
                  </a>
                  <form id="deleteForm' . $item['id'] . '" action="form_api.php" method="post" style="display: none;">
                      <input type="hidden" name="id" value="' . $item['id'] . '">
                      <input type="hidden" name="action" value="delete">
                  </form>';
        }
    
        echo '</td>
              </tr>';
    }

  ?>

          </table>
      </div>
  </div>
  
 <script>
    function deleteCategory(id) {
        option = confirm('Bạn có chắc chắn muốn xóa danh mục này không?');
        if (!option) return;

        // Gửi yêu cầu xóa danh mục
        $.post('form_api.php', {
            'id': id,
            'action': 'delete'
        }, function(data) {
            // Sau khi xóa thành công, chuyển hướng người dùng trở lại trang quản lý danh mục
            window.location.href = 'category_index.php';
        });
    }
</script>

  <?php
  require_once('../layouts/footer.php');
  ?>

