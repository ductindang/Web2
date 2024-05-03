<link rel="stylesheet"type="text/css" href="../../assets/css/index.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php
	$name = 'Thêm/Sửa Sản Phẩm';
	$baseUrl = '../';
	require_once('../layouts/header.php');
    $created_time = $last_updated = date("Y-m-d H:i:s");
    if(!empty($_SESSION['current_user'])){

        ?>
    <div class="row" style="margin-top: 20px;">
	<div class="col-md-12">
    <h1>Phân quyền thành viên</h1>
    <div id="content-box">
            <?php
            if (!empty($_GET['action']) && $_GET['action'] == "save"
            ) {
                $data = $_POST;
                $insertString = "";
                $deleteOldPrivileges = mysqli_query($con, "DELETE FROM `user_role` WHERE `user_id` = ".$data['user_id']);
                foreach ($data['privileges'] as $insertPrivilege) {
                    $insertString .= !empty($insertString) ? "," : "";
                    $insertString .= "(NULL, " . $data['user_id'] . ", " . $insertPrivilege . ", '" . $created_time . "', '" . $last_updated . "')";
                }
                $insertPrivilege = mysqli_query($con, "INSERT INTO `user_role` (`id`, `user_id`, `role_con_id`, `created_time`, `last_updated`) VALUES " . $insertString);
                if(!$insertPrivilege){
                    $error = "Phân quyền không thành công. Xin thử lại";
                }
                ?>
                <?php if(!empty($error)){ ?>
                    echo $error;
                <?php } else { ?>
                    Phân quyền thành công. <a href="user_index.php">Quay lại danh sách thành viên</a>
                <?php } ?>
            <?php } else { ?>
                <?php
                $privileges = mysqli_query($con, "SELECT * FROM `role_con`");
                $privileges = mysqli_fetch_all($privileges, MYSQLI_ASSOC);
                
                $privilegeGroup = mysqli_query($con, "SELECT * FROM `role_group` ORDER BY `role_group`.`position` ASC");
                $privilegeGroup = mysqli_fetch_all($privilegeGroup, MYSQLI_ASSOC);
                
                $currentPrivileges = mysqli_query($con, "SELECT * FROM `user_role` WHERE `user_id` = ".$_GET['id']);
                $currentPrivileges = mysqli_fetch_all($currentPrivileges, MYSQLI_ASSOC);
                $currentPrivilegeList = array();
                if(!empty($currentPrivileges)){
                    foreach($currentPrivileges as $currentPrivilege){
                        $currentPrivilegeList[] = $currentPrivilege['role_con_id'];
                    }
                }
                ?>
                <form id="editing-form" method="POST" action="?action=save" enctype="multipart/form-data">
                <button type="submit" class="btn btn-primary" title="Lưu thành viên">Lưu thành viên</button>
                    <input type="hidden" name="user_id" value="<?= $_GET['id'] ?>" />
                    <div class="clear-both"></div>
                    <?php foreach ($privilegeGroup as $group) { ?>
                        <div class="privilege-group col-md-6">
                            <h3 class="group-name card mt-4"><?= $group['name'] ?></h3>
                            <ul >
                                <?php foreach ($privileges as $privilege) { ?>
                                    <?php if ($privilege['group_id'] == $group['id']) { ?>
                                        <li style="padding: 13px 15px;">
                                            <input type="checkbox" 
                                                <?php if(in_array($privilege['id'], $currentPrivilegeList)){ ?> 
                                                checked=""    
                                                <?php } ?>
                                                value="<?= $privilege['id'] ?>" id="privilege_<?= $privilege['id'] ?>" name="privileges[]" />
                                            <label for="privilege_<?= $privilege['id'] ?>"><?= $privilege['name'] ?></label>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <div class="clear-both"></div>
                            </ul>
                        </div>
                    <?php } ?>
                </form>
            <?php } ?>
        </div>



	</div>
    </div>




    <?php
}
	require_once('../layouts/footer.php');
  ?>