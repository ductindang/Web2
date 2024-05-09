
<?php
	session_start();
	require_once('../../utils/utility.php');
	require_once('../../database/dbhelper.php');
	require_once('process-login.php');

	 $user= getUserToken();
	 if($user != null) {
	 	header('Location: ../');
        die();
 }
 ?>
 
 
 
 <!DOCTYPE html>
<html>
<head>
	<title>Đăng nhập</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet"type="text/css" href="../../assets/css/dashboard.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<style>
		body{
			background-image: url(https://giphy.com/gifs/sky-clouds-beauty-Pp9W9tuVF5NwQ);
        background-size: cover; /* để hình ảnh tự động điều chỉnh kích thước để phù hợp với kích thước của phần tử */
        /* Các thuộc tính khác tùy chỉnh */
        background-repeat: no-repeat;
		}
	</style>
</head>
<body>
	

<section class=" " style=" background-size: cover;background-repeat: no-repeat;background-image: url(https://64.media.tumblr.com/d2dc6c08e7cdd2f56202f86996bbb977/tumblr_o2x9qnZ04n1tchrkco1_500.gif);" >
  <div class="container py-5 h-80">
    <div class="row d-flex justify-content-center align-items-center h-80">
      <div class="col-xl-13" >
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="../../assets/img/logo.jpg"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Đăng nhập tài khoản</h4>
                </div>
				<h5 style="color : red;"	class="text-center" ><?=$msg?></h5>
               
              

				<div class="panel-body">
			<form method="post">
					
				<div class="form-group">
				  <label for="email">Email:</label>
				  <input required="true" type="email" class="form-control" id="email" name="email" value="<?=$email?>">
				</div>
				
				<div class="form-group">
				  <label for="password">Mật khẩu:</label>
				  <input required="true" type="password" class="form-control" id="password" name="password" minlength="6">
				</div>
				
			<p>
				<a href="register.php">
					Đăng kí tài khoản mới 
				</a>
		</p>
				<button class="btn btn-success">ĐĂNG NHẬP</button>
			</form>
			</div>
                  <div class="text-center pt-1 mb-5 pb-1">
                   
                    <a class="text-muted" href="#!">Forgot password?</a>
                  </div>

               
               

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center " style="background-color: #ff5858;">
              <div class=" px-3 py-4 p-md-5 mx-md-4">
                <h3 class="mb-4">SOLANA STORE</h3>
                <p class="medium mb-0">Chào mừng bạn đến với trang mua sắm của chúng tôi! Đăng nhập để trải nghiệm các tính năng độc quyền, theo dõi đơn hàng và quản lý thông tin cá nhân của bạn
					. Nếu bạn chưa có tài khoản, hãy đăng kí ngay để trở thành thành viên của cộng đồng của chúng tôi và nhận được nhiều ưu đãi hấp dẫn</p>
				  <div class="d-flex align-items-center justify-content-center pb-4">
                   
				
				  
				 </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>

