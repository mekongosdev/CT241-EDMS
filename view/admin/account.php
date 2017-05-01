<?php

// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap

        echo '<h3>Tài khoản</h3>';
        // Dãy nút của danh sách tài khoản
        echo
            '<form action="'.$_DOMAIN.'admin/account" method="POST">
                <a class="btn btn-default" data-toggle="modal" data-target="#addAccount">
                    <span class="glyphicon glyphicon-plus"></span> Thêm
                </a>
                <a href="' . $_DOMAIN . 'admin/account" class="btn btn-default">
                    <span class="glyphicon glyphicon-repeat"></span> Reload
                </a>
                <button class="btn btn-warning" id="lock_acc_list" name="lockUsers" type="submit">
                    <span class="glyphicon glyphicon-lock"></span> Khoá
                </button>
                <button class="btn btn-success" id="lock_acc_list" name="unlockUsers" type="submit">
                    <span class="glyphicon glyphicon-lock"></span> Mở khoá
                </button>
                <button class="btn btn-danger" id="del_acc_list" name="delUsers" type="submit">
                    <span class="glyphicon glyphicon-trash"></span> Xoá
                </button>
                <strong>Lưu ý: </strong>Xóa tài khoản sẽ xóa cả thành viên có cùng ID
            ';

// Content danh sách tài khoản
$sql_get_list_acc = "SELECT * FROM user_auth ORDER BY idUser ASC";
// Nếu có tài khoản
if ($db->num_rows($sql_get_list_acc)) {
    $row="SELECT idUser FROM user_auth";
    $row_per_page=10;
    $rows=$db->num_rows($row);
    if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
    else $page=1;
    if(isset($_GET['act']) && (int)$_GET['act'])
         $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
    else $start=0;
    $val_list_acc = "SELECT * FROM user_auth ORDER BY idUser ASC limit $start,$row_per_page";

    echo
    '
        <br><br><form>
        <div class="table-responsive">
            <table class="table table-striped list" id="list_cate">
                <tr>
                    <th><input type="checkbox" onClick="toggle(this)"></th>
                    <th>ID</strong></th>
                    <th>Tên đăng nhập</th>
                    <th>Trạng thái</th>
                    <th>Tools</th>
                </tr>
    ';

    // In danh sách tài khoản
    foreach ($db->fetch_assoc($val_list_acc, 0) as $key => $data_acc)
    {
        // Trạng thái tài khoản
        if ($data_acc['status'] == 1) {
            $stt_acc = '<label class="label label-success">Hoạt động</label>';
        } else if ($data_acc['status'] == 0) {
            $stt_acc = '<label class="label label-danger">Đang khoá</label>';
        }

        echo
        '
            <tr>
                <td><input type="checkbox" name="id_acc[]" value="' . $data_acc['idUser'] .'"></td>
                <td>' . $data_acc['idUser'] .'</td>
                <td>' . $data_acc['email'] . '</td>
                <td>' . $stt_acc . '</td>
                <td>
                    <a data-id="' . $data_acc['idUser'] . '" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#lockUser">
                        <span class="glyphicon glyphicon-lock"></span>
                    </a>
                    <a data-id="' . $data_acc['idUser'] . '" class="btn btn-sm btn-success" data-toggle="modal" data-target="#unlockUser">
                        <span class="glyphicon glyphicon-lock"></span>
                    </a>
                    <a data-id="' . $data_acc['idUser'] . '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delUser">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        ';
    }

    echo
    '
            </table>
        </div>
     </form>
    ';
}
// Nếu không có tài khoản
else
{
    new Info('','Chưa có tài khoản nào');
}

echo '<div class="container">';

$row="SELECT idUser FROM user_auth";
$rows=$db->num_rows($row);
$config = array(
'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
'total_record'  => $rows, // Tổng số record
'limit'         => 10,// limit
'link_full'     => $_DOMAIN.'admin/account/{page}',// Link full có dạng như sau: domain/com/page/{page}
'link_first'    => $_DOMAIN.'admin/account',// Link trang đầu tiên
'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();

echo '</div>';

// Content thêm tài khoản
echo '<div class="modal fade" id="addAccount" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thêm tài khoản</h4>
      </div>
      <div class="modal-body">
        <form action="'.$_DOMAIN.'admin/account" method="POST">
            <div class="form-group">
                <label>Tên đăng nhập</label>
                <input type="text" name="id_user" class="form-control title" placeholder="Nhập tên đăng nhập">
            </div>
            <div class="form-group">
                <label>Mật khẩu</label>
                <input type="password" name="pwd" class="form-control title" placeholder="Nhập mật khẩu">
            </div>
            <div class="form-group">
                <label>Nhập lại mật khẩu</label>
                <input type="password" name="re-pwd" class="form-control title" placeholder="Nhập lại mật khẩu">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control title" placeholder="Nhập email">
            </div><div class="form-group">
                <label>Phân quyền</label>
                <select class="form-control" name="role">
                  ';
                $sql_get_role = "SELECT * FROM roles_cp";
                foreach ($db->fetch_assoc($sql_get_role, 0) as $key=>$data) {
                  echo '<option value="'.$data['roleName'].'">'.$data['roleName'].'</option>
                  ';
              } echo '</select>
            </div>
            <!-- <div class="alert alert-danger hidden"></div>         -->
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_account" class="btn btn-primary">Thêm</button></form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>';

//Content chức năng tài khoản
echo '
<!-- Khóa tài khoản -->
<div class="modal fade" id="lockUser" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Khóa tài khoản</h4>
      </div>
      <div class="modal-body">
      <form action="'.$_DOMAIN.'admin/account" method="POST">
        <input type="hidden" name="toLockUser" id="toLockUser" value=""/>
        <center>
          <p><strong>Xác nhận khóa tài khoản!</strong></p>
        </center>
      </div>
      <div class="modal-footer">
        <button type="submit" name="lockUser" class="btn btn-primary">Đồng ý</button></form>
      </div>
    </div>
  </div>
</div>
<!-- Mở khóa tài khoản -->
<div class="modal fade" id="unlockUser" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Mở khóa tài khoản</h4>
      </div>
      <div class="modal-body">
      <form action="'.$_DOMAIN.'admin/account" method="POST">
        <input type="hidden" name="toUnlockUser" id="toUnlockUser" value=""/>
        <center>
          <p><strong>Xác nhận mở khóa tài khoản!</strong></p>
        </center>
      </div>
      <div class="modal-footer">
        <button type="submit" name="unlockUser" class="btn btn-primary">Đồng ý</button></form>
      </div>
    </div>
  </div>
</div>
<!-- Xóa tài khoản -->
<div class="modal fade" id="delUser" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Xóa tài khoản!</h4>
      </div>
      <div class="modal-body">
      <form action="'.$_DOMAIN.'admin/account" method="POST">
        <input type="hidden" name="toDelUser" id="toDelUser" value=""/>
        <center>
          <p><strong>Xác nhận xóa tài khoản</strong></p>
          <p><strong>Lưu ý: </strong>Xóa tài khoản sẽ xóa cả thành viên có cùng ID</p>
        </center>
      </div>
      <div class="modal-footer">
        <button type="submit" name="delUser" class="btn btn-primary">Đồng ý</button></form>
      </div>
    </div>
  </div>
</div>
';

//Them tai khoan
if (isset($_POST['add_account'])){
  $id_user = $_POST['id_user'];
  $pwd = $_POST['pwd'];
  $re_pwd = $_POST['re-pwd'];
  $email = $_POST['email'];
  $role = $_POST['role'];

  if ($pwd != $re_pwd) {
    new Warning($_DOMAIN.'admin/account','Mật khẩu không trùng khớp');
  }
  if ($role == 'Owner') {
    new Warning($_DOMAIN.'admin/account','Chỉ có duy nhất một Chủ sở hữu - Owner');
  }
  if (!$id_user || !$pwd || !$email){
    new Warning($_DOMAIN.'admin/account','Vui lòng nhập đầy đủ thông tin');
  }
  if ($id_user && $pwd == $re_pwd && $email && $role != 'Owner') {
    $sql_add_new_account = "INSERT INTO user_auth(idUser,pwd,email,roleName,status,dateCreate) VALUES ('$id_user','$pwd','$email','$role',1,'$date_current')";//status=1 -> Account active
    $db->query($sql_add_new_account);
    new Success($_DOMAIN.'admin/members','Thêm tài khoản mới thành công');
  } else new Warning($_DOMAIN.'admin/account','Có lỗi xảy ra. Vui lòng kiểm tra lại');
}
//Chức năng xử lý tài khoản
//Khóa nhiều user
if (isset($_POST['lockUsers'])) {
  $id_acc_lock = $_POST['id_acc'];
  foreach ($id_acc_lock as $key => $data) {
    $sql_lock_users = "UPDATE user_auth SET status = 0 WHERE idUser = '$data'";
    $db->query($sql_lock_users);
  }
  new Success($_DOMAIN.'admin/account','Khóa các tài khoản thành công');
}
//Khóa 1 user
if (isset($_POST['lockUser'])) {
  $idLock = $_POST['toLockUser'];

  $sql_lock_user = "UPDATE user_auth SET status = 0 WHERE idUser = '$idLock'";
  $db->query($sql_lock_user);
  new Success($_DOMAIN.'admin/account','Khóa tài khoản thành công');
}
//Mở khóa nhiều user
if (isset($_POST['unlockUsers'])) {
  $id_acc_unlock = $_POST['id_acc'];
  foreach ($id_acc_unlock as $key => $data) {
    $sql_unlock_users = "UPDATE user_auth SET status = 1 WHERE idUser = '$data'";
    $db->query($sql_unlock_users);
  }
  new Success($_DOMAIN.'admin/account','Mở khóa các tài khoản thành công');
}
//Mở khóa 1 user
if (isset($_POST['unlockUser'])) {
  $idUnlock = $_POST['toUnlockUser'];

  $sql_unlock_user = "UPDATE user_auth SET status = 1 WHERE idUser = '$idUnlock'";
  $db->query($sql_unlock_user);
  new Success($_DOMAIN.'admin/account','Mở khóa tài khoản thành công');
}
//Xóa nhiều user
if (isset($_POST['delUsers'])) {
  $id_acc_del = $_POST['id_acc'];
  foreach ($id_acc_del as $key => $data) {
    $sql_del_users = "DELETE FROM user_auth WHERE idUser = '$data'";
    $sql_del_members = "DELETE FROM user_info WHERE idUser = '$data'";
    $db->query($sql_del_users);
    $db->query($sql_del_members);
  }
  new Success($_DOMAIN.'admin/account','Xóa các tài khoản và thành viên cùng tên thành công');
}
//Xóa 1 user
if (isset($_POST['delUser'])) {
  $idDel = $_POST['toDelUser'];

  $sql_del_user = "DELETE FROM user_auth WHERE idUser = '$idDel'";
  $sql_del_member = "DELETE FROM user_info WHERE idUser = '$idDel'";
  $db->query($sql_del_user);
  $db->query($sql_del_member);
  new Success($_DOMAIN.'admin/account','Xóa tài khoản và thành viên cùng tên thành công');
}
?>

<!-- JS Function -->
<script language="JavaScript">
//chooseAll
function toggle(source) {
  checkboxes = document.getElementsByName('id_acc[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
// using latest bootstrap so, show.bs.modal
//lockUser
$('#lockUser').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toLockUser").val(product);
});
//unlockUser
$('#unlockUser').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toUnlockUser").val(product);
});
//delUser
$('#delUser').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toDelUser").val(product);
});
</script>
