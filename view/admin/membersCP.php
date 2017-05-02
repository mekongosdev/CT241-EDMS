<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addMember"></a>
<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);?>

<h3>Quản lý thành viên</h3>
  <button class="btn btn-success" data-toggle="modal" data-target="#addMember">Thêm thành viên mới</button>
  <a href="<?php echo $_DOMAIN; ?>admin/membersCP" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>

<table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Họ tên</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Chỉnh sửa</th>
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

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idUser'].'</td>
                    <td><a href="'.$_DOMAIN.'profile/'.$row['idUser'].'">'.$row['fullName'].'</td>
                    <td><a href="tel:'.$row['phone'].'">'.$row['phone'].'</td>
                    <td><a href="mailto:'.$row['email'].'">'.$row['email'].'</td>
                    <td>
                        <button type="button" id="editMembers" class="btn btn-primary" data-id="'.$row['idUser'].'" data-unit="'.$row['unit'].'" data-position="'.$row['position'].'" data-level="'.$row['level'].'" data-toggle="modal" data-target="#editMember"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button type="button" id="delMembers" class="btn btn-danger" data-id="'.$row['idUser'].'" data-toggle="modal" data-target="#deleteMember"><span class="glyphicon glyphicon-trash"></span></button>
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
    'link_full'     => $_DOMAIN.'admin/membersCP/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/membersCP',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
</div>

<?php
//Lấy idUser mới nhất
$sql_query_new_id_acc = "SELECT idUser FROM user_auth ORDER BY dateCreate DESC";
foreach ($db->fetch_assoc($sql_query_new_id_acc,1) as $key => $data) {
  $idAcc = $data;
}

//Lấy email của idUser mới nhất
$sql_query_new_id_acc = "SELECT email FROM user_auth WHERE idUser = '$idAcc'";
foreach ($db->fetch_assoc($sql_query_new_id_acc,1) as $key => $data) {
  $newEmail = $data;
}

//Truy vấn idUser và email mới nhất
$sql_query_new_member = "SELECT * FROM user_auth INNER JOIN user_info ON user_auth.idUser = user_info.idUser WHERE user_auth.idUser = '$idAcc'";
if (!$db->num_rows($sql_query_new_member)) {
  $idNewUser = $idAcc;
  $newUserEmail = $newEmail;
} else {
  $idNewUser = '';
  $newUserEmail = '';
}
?>

<!-- Thêm thành viên -->
    <div id="addMember" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thêm thành viên mới</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/membersCP" method="post">
                        <fieldset class="form-group">
                            <label for="nameMember">Họ tên</label>
                            <input type="text" class="form-control" name="nameMember" id="nameMember" placeholder="Nhập tên thành viên">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="idMember">MSCB/MSSV</label>
                            <input type="text" class="form-control" name="idMember" id="idMember" placeholder="Nhập mã số thành viên" value="<?php echo $idNewUser;?>">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="phoneMember">Điện thoại</label>
                            <input type="number" class="form-control" name="phoneMember" id="phoneMember" placeholder="Nhập số điện thoại">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="mailMember">Email</label>
                            <input type="mail" class="form-control" name="mailMember" id="mailMember" placeholder="Nhập email thành viên" value="<?php echo $newUserEmail;?>">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="positionMember">Vị trí nghiên cứu</label>
                            <input type="text" class="form-control" name="positionMember" id="positionMember" placeholder="Nhập vị trí nghiên cứu của thành viên">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="levelMember">Trình độ học vấn</label>
                            <input type="text" class="form-control" name="levelMember" id="levelMember" placeholder="Nhập trình độ học vấn của thành viên">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="typeMember">Phân loại</label>
                            <select class="form-control" name="typeMember" id="typeMember">
                              <option value="1">Cán bộ</option>
                              <option value="0">Sinh viên/Học viên</option>
                            </select>
                        </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="addNewMember">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

<!-- Chỉnh sửa thành viên -->
    <div id="editMember" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Chỉnh sửa thông tin</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/membersCP" method="post">
                      <input type="hidden" name="toEditMember" id="toEditMember" value=""/>
                      <fieldset class="form-group">
                          <label for="positionMember">Vị trí nghiên cứu</label>
                          <input type="text" class="form-control" name="positionMember" id="toPositionMember" value="" placeholder="Nhập vị trí nghiên cứu của thành viên">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="unitMember">Đơn vị công tác</label>
                          <input type="text" class="form-control" name="unitMember" id="toUnitMember" value="" placeholder="Nhập đơn vị của thành viên">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="levelMember">Trình độ học vấn</label>
                          <input type="text" class="form-control" name="levelMember" id="toLevelMember" value="" placeholder="Nhập trình độ học vấn của thành viên">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="typeMember">Phân loại</label>
                          <select class="form-control" name="typeMember" id="toTypeMember">
                            <option value="1">Cán bộ</option>
                            <option value="0">Sinh viên/Học viên</option>
                          </select>
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="editInfoMember" class="btn btn-primary">Submit</button></form>
                </div>
            </div>
        </div>
    </div>

<!--Xóa thành viên-->
    <div id="deleteMember" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Xóa thành viên!</h4>
                </div>
                <div class="modal-body">
                  <center>
                    <h4>Hành động này cần xác nhận: Không thể hoàn tác!</h4>
                    <p>Vui lòng kiểm tra cẩn thận!</p>
                  </center>
                    <form action="<?php echo $_DOMAIN; ?>admin/membersCP" method="post">
                        <div class="modal-footer">
                            <input type="hidden" name="toDelMember" id="toDelMember" value=""/>
                            <button type="submit" name="delMember" class="btn btn-danger">Đồng ý</button></form>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Function -->
    <script language="JavaScript">
    // using latest bootstrap so, show.bs.modal
    //editMember
    $('#editMember').on('show.bs.modal', function(e) {
      var product = $(e.relatedTarget).data('id');
      $("#toEditMember").val(product);
      var position = $(e.relatedTarget).data('position');
      $("#toPositionMember").val(position);
      var unit = $(e.relatedTarget).data('unit');
      $("#toUnitMember").val(unit);
      var level = $(e.relatedTarget).data('level');
      $("#toLevelMember").val(level);
    });
    //delMember
    $('#deleteMember').on('show.bs.modal', function(e) {
      var product = $(e.relatedTarget).data('id');
      $("#toDelMember").val(product);
    });
    </script>

<?php
//Xử lý thêm thành viên
if (isset($_POST['addNewMember'])) {
  $name = $_POST['nameMember'];
  $idUser = $_POST['idMember'];
  $phone = $_POST['phoneMember'];
  $email = $_POST['mailMember'];
  $position = $_POST['positionMember'];
  $level = $_POST['levelMember'];
  $type = $_POST['typeMember'];

  if ($name && $idUser && $phone && $email && $position && $level) {
      $sql_add_user = "INSERT INTO user_info(idUser,idImg,fullName,phone,email,website,social,address,position,level,unit,type) VALUES ('$idUser',1,'$name','$phone','$email','không có','không có','ĐH Cần Thơ','$position','$level','Khoa CNTT&TT','$type')";
      $db->query($sql_add_user);
      new Success($_DOMAIN.'admin/account/');
  } else new Warning($_DOMAIN.'admin/membersCP','Vui lòng điền đầy đủ thông tin');
}

//Xử lý sửa thông tin thành viên
if (isset($_POST['editInfoMember'])) {
  $idUser = $_POST['toEditMember'];
  $position = $_POST['positionMember'];
  $level = $_POST['levelMember'];
  $unit = $_POST['unitMember'];
  $type = $_POST['typeMember'];

  if ($position && $level && $unit) {
      $sql_edit_user = "UPDATE user_info SET position = '$position',level = '$level',unit = '$unit',type = '$type' WHERE idUser = '$idUser'";
      $db->query($sql_edit_user);
      new Success($_DOMAIN.'admin/membersCP/');
  } else new Warning($_DOMAIN.'admin/membersCP','Vui lòng điền đầy đủ thông tin');
}

//Xử lý xóa thành viên
if (isset($_POST['delMember'])) {
  $idUser = $_POST['toDelMember'];

  $sql_del_user = "DELETE FROM user_info WHERE idUser = '$idUser'";
  $db->query($sql_del_user);
  new Success($_DOMAIN.'admin/membersCP/');
}
?>
