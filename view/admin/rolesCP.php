<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>

<h3>Quản lý phân quyền thành viên
  <a href="<?php echo $_DOMAIN; ?>admin/roles" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>
</h3>

<?php
  if (isset($_POST['changeRolethisUser'])) {
      $idUser = $_POST['toIdUser'];
      $roleName = $_POST['roleChange'];

      $qry_change_role_to_user = "UPDATE user_auth SET roleName = '$roleName' WHERE idUser = '$idUser'";//Cap nhat quyen cua tai khoan
      if ($roleName == 'Owner') {
          new Warning($_DOMAIN.'admin/roles','Quyền Owner là duy nhất. Vui lòng báo với quản trị viên nếu đó là lỗi.');
      } else if ($idUser && $roleName) {
          $db->query($qry_change_role_to_user);
          new Success($_DOMAIN.'admin/roles','Thay đổi phân quyền thành công');
      } else new Warning($_DOMAIN.'admin/roles','Có lỗi xảy ra! Vui lòng kiểm tra lại hoặc báo cáo với kỹ thuật viên.');
  }
?>

<table id="roleCP" class="table table-striped">
        <thead>
            <tr>
                <th>MSCB/MSSV</th>
                <th>Họ tên</th>
                <th>Phân quyền</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $sql_get_user = "SELECT * FROM user_info ORDER BY idUser DESC";
          if ($db->num_rows($sql_get_user)) {
              $row="SELECT idUser FROM user_info";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['act']) && (int)$_GET['act'])
                   $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              // var_dump($start);
              $val = "SELECT * FROM user_info ORDER BY idUser ASC limit $start,$row_per_page";
              $retval = $db->query($val);

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '
                <tr>
                    <td>'.$row['idUser'].'</td>
                    <td>'.$row['fullName'].'</td>
                    <td>
                        <button type="button" data-id="'.$row['idUser'].'" data-toggle="modal" data-target="#editRoles" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
                    </td>
                </tr>';
              }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có thành viên nào.</div>';
          }
          ?>
        </tbody>
    </table>

    <div class="container">
<?php
$row="SELECT idUser FROM user_info";
$rows=$db->num_rows($row);
$config = array(
    'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => $_DOMAIN.'admin/roles/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/roles',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
</div>

<?php
// if (isset($_GET["tab"])) {
// 	//Get tab va trả về kết quả theo ý muốn
//       if ($_GET["tab"] == "edit") {
//         if (isset($_GET['act'])) {
//           if ($_GET["act"]) {
//             $id=$_GET['act'];
//             echo '       <form action="'.$_DOMAIN.'admin/roles" method="post">
//                               <fieldset class="form-group">
//                                   <label for="roleThisUser">Phân quyền thành viên</label>
//                                   <select class="form-control" name="roleThisUser" id="roleThisUser">';
//                                   $sql_roles = "SELECT roleName FROM roles_cp";
//                                       foreach ($db->fetch_assoc($sql_roles,0) as $key => $data) {
//                                         echo '<option value="'.$data['roleName'].'">'.$data['roleName'].'</option>';
//                                       }
//                                   echo '
//                                   </select>
//                               </fieldset>
//                               <button type="submit" name="changeRole" class="btn btn-primary">Yes</button>
//                             </form>
//             ';
//           }
//         }
//       } else new Redirect($_DOMAIN.'admin/roles');
//     } else new Redirect($_DOMAIN.'admin/roles');
//
// if (isset($_POST['changeRole'])){
//   $role = $_POST['roleThisUser'];
//
//   if ($role) {
//     $sql_update_role = "UPDATE rolesName FROM user_auth WHERE idUser = '$id'";
//     $db->query($sql_update_role);
//     new Redirect($_DOMAIN.'admin/roles');
//   }
// }

?>

<div id="editRoles" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thay đổi quyền</h4>
      </div>
      <div class="modal-body edit-content">
          <form class="form-group" action="<?php echo $_DOMAIN; ?>admin/roles" method="post">
            <input type="hidden" name="toIdUser" id="toIdUser" value=""/>
              <fieldset class="form-group">
                  <label for="roleChange">Tên quyền</label>
                  <select class="form-control" name="roleChange" id="roleChange">
                    <?php
                        //Chọn quyền
                        $sql_roles = "SELECT roleName FROM roles_cp";
                        foreach ($db->fetch_assoc($sql_roles,0) as $key => $data) {
                          echo '<option value="'.$data['roleName'].'">'.$data['roleName'].'</option>';
                        }
                    ?>
                  </select>
              </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" name="changeRolethisUser"class="btn btn-primary">Thay đổi</button></form>
      </div>
    </div>
  </div>
</div>

<script>
// using latest bootstrap so, show.bs.modal
$('#editRoles').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toIdUser").val(product);
});
</script>
