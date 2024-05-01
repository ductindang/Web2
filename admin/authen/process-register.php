<?php
$name=$email=$mobile=$msg='';

if(!empty($_POST))
{
    $name=getPOST('name');
    $email=getPOST('email');
    $password=getPOST('password');
    $mobile=getPOST('mobile');

if(empty($name) || empty($email) || empty($password) || strlen($password)< 6)
{}else{
    //validate thanh cong\

    $userExist= executeResult("select * from user where email='$email'",true);
    if($userExist!= null){
        $msg='Email đã được đăng ký';

        
    }else{
        $created_at = $updated_at=date('Y-m-d H:i:s');
        $password=getSecuritymd5($password);
        $sql="insert into user (name,email,mobile,password,role_id,created_at,updated_at,is_active)
         values ('$name','$email','$mobile','$password',2,'$created_at','$updated_at',1)";
        execute($sql);
        header('Location : login.php');
    
        die();
    }

}


}
