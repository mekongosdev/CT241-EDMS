

<table id="infoDevice" class="table table-striped">
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
              if(isset($_GET['page']) && (int)$_GET['page'])
                   $start=($_GET['page']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
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
                        <a href="'.$_DOMAIN.'admin/roles/edit/'.$row['idUser'].'" type="button" id="editRoles" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
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
    'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => $_DOMAIN.'admin/roles/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/roles/',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>

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
