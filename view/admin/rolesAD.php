<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addRole"></a>

<h3>Tùy biến phân quyền</h3>
  <button class="btn btn-success" data-toggle="modal" data-target="#addRole">Thêm nhóm quyền</button>
  <a href="<?php echo $_DOMAIN; ?>admin/rolesCP" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>
  <button class="btn btn-danger" data-toggle="modal" data-target="#delRole">Xóa nhóm quyền đang xem</button>


<script type="text/javascript">
$(document).ready(function() {
  $('#roleThisUser').on('change', function() {
    var $form = $(this).closest('form');
    $form.find('input[type=submit]').click();
  });
});
</script>

<h4>Tên nhóm quyền</h4>
<form class="form-horizontal" action="<?php echo $_DOMAIN; ?>admin/rolesCP" method="post">
  <div class="form-group">
    <div class="col-sm-6">
      <select class="form-control" name="roleThisUser" id="roleThisUser">
        <?php
          $sql_get_roles = "SELECT * FROM roles_cp ORDER BY idRole ASC";
          foreach($db->fetch_assoc($sql_get_roles, 0) as $key => $roleName) {
            echo '<option value="'.$roleName['roleName'].'">'.$roleName['roleName'].'</option>'; } ?>
      </select>
    </div>
    <div class="col-sm-4">
      <input type="submit" class="form-inline btn btn-default" name="goRole" value="Xem">
    </div>
  </div>
</form>

<?php
if(isset($_POST['goRole'])) {
  $roleNamecp = $_POST['roleThisUser'];
} else {
  $roleNamecp = 'Owner';
}

?>

<!-- Xóa nhóm quyền -->
<div class="modal fade" id="delRole" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Xóa nhóm quyền</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo $_DOMAIN; ?>admin/rolesCP" method="post">
            <input type="hidden" name="toRole" id="toRole" value="<?php echo $roleNamecp; ?>"/>
            <center>
                <h5>Bạn đang xóa quyền <?php echo $roleNamecp; ?>! Hành động này không thể hoàn tác.</h5>
                <h4>Vui lòng xác nhận việc xóa quyền!</h4>
            </center>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" name="delThisRole">Xác nhận xóa</button></form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['delThisRole'])) {
  $delRole = $_POST['toRole'];

  $sql_del_roleName = "DELETE FROM `roles_cp` WHERE roleName = '$delRole'";

  if ($delRole == 'Owner') {
      new Warning($_DOMAIN.'admin/rolesCP','Không thể xóa quyền Owner. Vui lòng báo với quản trị viên nếu đó là lỗi.');
  } else {
      $db->query($sql_del_roleName);
      new Success($_DOMAIN.'admin/rolesCP','Xóa quyền thành công');
  }
}
?>


<!-- Thêm nhóm quyền -->
<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thêm nhóm quyền</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="<?php echo $_DOMAIN; ?>admin/rolesCP" method="post">
          <div class="form-group">
            <label class="control-label col-sm-3" for="roleName">Tên nhóm quyền</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="roleName" id="roleName" placeholder="Nhập tên nhóm quyền">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="roleDescription">Mô tả nhóm quyền</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="roleDescription" id="roleDescription" placeholder="Nhập mô tả nhóm quyền">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="addNewRole">Thêm quyền</button></form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
//Thêm quyền mới
  if(isset($_POST['addNewRole'])){
    if($_POST['roleName'] == NULL||$_POST['roleDescription'] == NULL)
     {
      new Warning($_DOMAIN.'admin/rolesCP','Vui lòng nhập tên quyền hoặc mô tả nhóm quyền còn bỏ trống');
     }
     else
     {
       $roleName = $_POST['roleName'];
       $roleDescription = $_POST['roleDescription'];
     }
     if($roleName && $roleDescription)
       {
         $sql="INSERT INTO roles_cp(roleName,roleDesc,rolesGroup) VALUES('".$roleName."','".$roleDescription."','profile')";
         $query = $db->query($sql);
         new Warning($_DOMAIN.'admin/rolesCP','Đã thêm thành công quyền mới với chức năng mặc định là Profile - Xem thông tin thành viên!');
      }
    }

?>

<?php
//include_once("yourconfig.php"); //include your db config file
extract($_POST);
//if(isset($_POST['roleThisUser'])) $name = $_POST['roleThisUser'];
$role_qry='SELECT * FROM roles_cp WHERE roleName = "'.$roleNamecp.'"';
//$run_qry=mysql_query($check_exist_qry);
$run_qry = $db->query($role_qry);
$total_found = $db->num_rows($role_qry);
if($total_found >0)
{
    //$value = $db->fetch_assoc($role_qry,0);
    foreach ($db->fetch_assoc($role_qry, 0) as $key=>$value) {
      $role=explode(',',$value['rolesGroup']);
      $role_desc= $value['roleDesc'];
    }
}

//Hàm phân quyền
function role($role) {
	if(in_array("fullcontrol",$role)||in_array("adminCP",$role)){
		echo "Access!";
	} else echo "Deny!";
}
echo "<br  />";
role($role);

    //echo $role;
if(isset($_POST['saveRole'])) {
    $all_value = implode(",",$_POST['add']);
    $name = $_POST['disabled'];
    $roleDesc = $_POST['roleDesc'];
    if($total_found >0)
    {
        //echo $all_value." ".$name;//Test
        //update
        $upd_qry="UPDATE roles_cp SET rolesGroup='".$all_value."', roleDesc='".$roleDesc."' WHERE roleName='".$name."'";
        $db->query($upd_qry);
        new Success($_DOMAIN.'admin/rolesCP','Thành công!');
  } else
    {
        //insert
        $ins_qry="INSERT INTO roles_cp(rolesGroup) VALUES('".$all_value."')";
        $db->query($ins_qry);
  }
}
?>

<form class="form-horizontal" action="<?php echo $_DOMAIN; ?>admin/rolesCP" method="post">
  <div class="form-group">
    <div class="col-sm-10 roles-admin">
        <input class="hidden" name="disabled" id="disabledInput" type="text" value="<?php echo $roleNamecp;?>">
    </div>
    <div class="col-sm-12 roles-admin">
        <p><strong>Tùy biến phân quyền của nhóm <?php echo $roleNamecp;?></strong></p>
        <script language="JavaScript">
          function toggle(source) {
            checkboxes = document.getElementsByName('add[]');
            for(var i=1, n=checkboxes.length;i<n;i++) {
              checkboxes[i].checked = source.checked;
            }
          }
        </script>
        <div class="col-sm-10 roles-admin">
          <label for="roleDescription">Mô tả nhóm quyền</label>
          <input type="text" class="form-control" name='roleDesc' id="roleDescription" value="<?php echo $role_desc; ?>" placeholder="Nhập mô tả">
        </div>
    </div>
    <div class="col-sm-12 roles-admin">
        <script language="JavaScript">
          function toggle(source) {
            checkboxes = document.getElementsByName('add[]');
            for(var i=1, n=checkboxes.length;i<n;i++) {
              checkboxes[i].checked = source.checked;
            }
          }
        </script>
        <div class="col-sm-12">
          <label for="roleGroup">Chức năng nhóm quyền</label><br  />
          <input type="checkbox" onClick="toggle(this)" id="roleGroup"> Chọn tất cả
          <input type="checkbox" name='add[]' value="fullcontrol"<?php if(in_array("fullcontrol",$role)){echo " checked";}?> onClick="toggle(this)">Tất cả quyền
        </div>
        <div class="col-sm-4">
          <p><strong>Nhóm quyền xem</strong></p>
          <input type="checkbox" name='add[]' value="device" <?php if(in_array("device",$role)){echo "checked";}?>>Xem danh sách thiết bị<br />
          <input type="checkbox" name='add[]' value="borrowDevice" <?php if(in_array("borrowDevice",$role)){echo "checked";}?>>Đăng ký mượn thiết bị<br />
          <input type="checkbox" name='add[]' value="members" <?php if(in_array("members",$role)){echo "checked";}?>>Xem danh sách thành viên<br />
          <input type="checkbox" name='add[]' value="project" <?php if(in_array("project",$role)){echo "checked";}?>>Xem danh sách dự án<br />
          <input type="checkbox" name='add[]' value="labs" <?php if(in_array("labs",$role)){echo "checked";}?>>Xem danh sách Labs<br />
          <input type="checkbox" name='add[]' value="profile" <?php if(in_array("profile",$role)){echo "checked";}?>>Xem thông tin thành viên<br />
          <input type="checkbox" name='add[]' value="search" <?php if(in_array("search",$role)){echo "checked";}?>>Sử dụng Tìm kiếm<br />
          <input type="checkbox" name='add[]' value="adminCP" <?php if(in_array("adminCP",$role)){echo "checked";}?>>Truy cập AdminCP<br />
        </div>
        <div class="col-sm-4">
          <p><strong>Nhóm quyền thêm/xóa</strong></p>
          <input type="checkbox" name='add[]' value="addDevice" <?php if(in_array("addDevice",$role)){echo "checked";}?>>Thêm thiết bị<br />
          <input type="checkbox" name='add[]' value="removeDevice" <?php if(in_array("removeDevice",$role)){echo "checked";}?>>Xóa thiết bị<br />
          <input type="checkbox" name='add[]' value="addMember" <?php if(in_array("addMember",$role)){echo "checked";}?>>Thêm thành viên<br />
          <input type="checkbox" name='add[]' value="removeMember" <?php if(in_array("removeMember",$role)){echo "checked";}?>>Xóa thành viên<br />
          <input type="checkbox" name='add[]' value="addProject" <?php if(in_array("addProject",$role)){echo "checked";}?>>Thêm dự án<br />
          <input type="checkbox" name='add[]' value="removeProject" <?php if(in_array("removeProject",$role)){echo "checked";}?>>Xóa dự án<br />
          <input type="checkbox" name='add[]' value="addLabs" <?php if(in_array("addLabs",$role)){echo "checked";}?>>Thêm Labs<br />
          <input type="checkbox" name='add[]' value="removeLab" <?php if(in_array("removeLab",$role)){echo "checked";}?>>Xóa Labs<br />
          <input type="checkbox" name='add[]' value="addPartner" <?php if(in_array("addPartner",$role)){echo "checked";}?>>Thêm đối tác<br />
          <input type="checkbox" name='add[]' value="removePartner" <?php if(in_array("removePartner",$role)){echo "checked";}?>>Xóa đối tác<br />
        </div>
        <div class="col-sm-4">
          <p><strong>Nhóm quyền chỉnh sửa/quản lý</strong></p>
          <p><strong> * Nhóm quyền quản lý cơ bản</strong></p>
          <input type="checkbox" name='add[]' value="deviceCP" <?php if(in_array("deviceCP",$role)){echo "checked";}?>>Quản lý thiết bị<br />
          <input type="checkbox" name='add[]' value="borrowDeviceCP" <?php if(in_array("borrowDeviceCP",$role)){echo "checked";}?>>Quản lý mượn thiết bị<br />
          <input type="checkbox" name='add[]' value="membersCP" <?php if(in_array("membersCP",$role)){echo "checked";}?>>Quản lý thành viên<br />
          <input type="checkbox" name='add[]' value="projectCP" <?php if(in_array("projectCP",$role)){echo "checked";}?>>Quản lý dự án<br />
          <input type="checkbox" name='add[]' value="labsCP" <?php if(in_array("labsCP",$role)){echo "checked";}?>>Quản lý Lab<br />
          <input type="checkbox" name='add[]' value="partnerCP" <?php if(in_array("partnerCP",$role)){echo "checked";}?>>Quản lý đối tác<br />
          <p><strong> * Nhóm quyền quản lý cao cấp</strong></p>
          <input type="checkbox" name='add[]' value="imagesCP" <?php if(in_array("imagesCP",$role)){echo "checked";}?>>Quản lý hình ảnh<br />
          <input type="checkbox" name='add[]' value="rolesCP" <?php if(in_array("rolesCP",$role)){echo "checked";}?>>Thay đổi quyền thành viên<br />
          <input type="checkbox" name='add[]' value="profileCP" <?php if(in_array("profileCP",$role)){echo "checked";}?>>Thay đổi thông tin thành viên<br />
          <input type="checkbox" name='add[]' value="rolesAD" <?php if(in_array("rolesAD",$role)){echo "checked";}?>>Quản lý nhóm quyền<br />
          <input type="checkbox" name='add[]' value="settingCP" <?php if(in_array("settingCP",$role)){echo "checked";}?>>Quản lý cài đặt<br />
        </div>
        <input type="submit" class="btn btn-primary" name="saveRole" value="Lưu">
    </div>
  </div>
</form>

<?php
/*
if(isset($_POST['roleThisUser'])){
   $role = $_POST['roleThisUser'];
   $add = $_POST['add'];

   echo $role;
   echo "<br  />";
   echo "Role : ";
   foreach ($add as $add=>$value) {
             echo $value." - ";
        }
}*/
?>
