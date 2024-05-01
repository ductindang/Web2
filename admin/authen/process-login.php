<?php

$fullname = $email = $msg = '';
$error = false;
require_once('../../database/dbhelper.php');
require_once('../../database/config.php');
if (!empty($_POST)) {
    $email = getPOST('email');
    $password = getPOST('password');

    $userExist = executeResult("SELECT * FROM user WHERE email='$email' AND password = '$password' AND is_active=1", true);
    if ($userExist == null) {
        $msg = 'Đăng nhập không thành công';
    } else {
       $token = getSecurityMD5($userExist[0]['email'].time());
		setcookie('token', $token, time() + 7 * 24 * 60 * 60, '/');
		$created_at = date('Y-m-d H:i:s');

		$_SESSION['user'] = $userExist;

        $userID= $userExist[0]['id'];
        $_SESSION['user']=$userExist;
        //$sql="insert into token (user_id,token,created_at) values ('$user_id','$token','$created_at')";
        //  execute($sql);

        // Phân quyền
        $result = mysqli_query($con, "SELECT * FROM user WHERE email='$email' AND password = '$password' AND is_active=1", true);

        if (!$result) {
            $error = mysqli_error($con);
        } else {
            $user =  mysqli_fetch_assoc($result);
            $userPrivileges = executeResult("SELECT * FROM `user_role` INNER JOIN `role_con` ON user_role.role_con_id=role_con.id WHERE user_role.user_id= " . $user['id']);
            if (!empty($userPrivileges)) {
                $user['privileges'] = array();
                foreach ($userPrivileges as $privilege) {
                    $user['privileges'][] = $privilege['url_match'];
                }
            }
          
            $_SESSION['current_user'] = $user;
            if ($user['role_id'] == 4) {
                // Nếu là user, chuyển hướng đến trang user
                header('Location: ../../');
            } else {
                // Nếu không phải admin hoặc user, chuyển hướng đến trang mặc định
                header('Location: ../dashboard.php');
            }
        }
        // Kết thúc phân quyền

        // header('Location: ../dashboard.php');
        die();
    }
}
?>
