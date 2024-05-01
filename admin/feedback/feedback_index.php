
<?php

    $title = 'Quản lý phản hồi';
    $baseUrl=  '../';
    require_once('../layouts/header.php');
  
    $sql = "select * from comment order by status asc,created_date desc";
	$data = executeResult($sql);
    ?>
          <div class ="row" style="margin-top:20px;">
        <div class="col-md-12 table-responsive">
        <h1>Quản lý phản hồi</h1>

       
            <table class="table table-bordered table-hover  ">
            <thread>
              <tr>
              <th>STT</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Star</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
                <th style="width: 130px"></th>
           
              </tr>

            </thread>
        <?php
        $index=0;
            foreach($data as $item){
                echo '<tr>
                <td>'.(++$index).'</td>
                  <td>'.$item['fullname'].'</td>
                  <td>'.$item['email'].'</td>         
                  <td>'.$item['star'].'</td>
                  <td>'.$item['description'].'</td>
                  <td>'.$item['created_date'].'</td>
                  <td style="width: 50px">';
                  if($item['status'] == 0)
                  {
                 echo'   <button onclick="markRead('.$item['id'].')" class="btn btn-danger">Đánh dấu đã đọc</button>      '    ;                   
                  }else {
                    // Display green label if status is 1 (read)
                    echo '<span class="label label-success">Đã đọc</span>';
                }
                echo '</td>
            </tr>';
            }

?>

            </table>
        </div>
 </div>
 <script type="text/javascript">
	function markRead(id) {
		$.post('form_api.php', {
			'id': id,
			'action': 'mark'
		}, function(data) {
			location.reload()
		})
	}
</script>
<?php
 require_once('../layouts/footer.php');
 ?>

