<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addMember"></a>
<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap ?>

<h3>Quản lý thành viên</h3>
  <button class="btn btn-success" data-toggle="modal" data-target="#addMember">Thêm thành viên mới</button>
  <a href="<?php echo $_DOMAIN; ?>admin/members" class="btn btn-default">
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
              $retval = $db->query($val);

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idUser'].'</td>
                    <td><a href="'.$_DOMAIN.'profile/'.$row['idUser'].'">'.$row['fullName'].'</td>
                    <td><a href="tel:'.$row['phone'].'">'.$row['phone'].'</td>
                    <td><a href="mailto:'.$row['email'].'">'.$row['email'].'</td>
                    <td>
                        <button type="button" id="editMembers" class="btn btn-primary" data-toggle="modal" data-target="#editMember"><span class="glyphicon glyphicon-pencil"></span></button>
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
    'link_full'     => $_DOMAIN.'admin/members/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/members',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
</div>

    <div id="addMember" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thêm thành viên mới</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/members" method="post">
                        <fieldset class="form-group">
                            <label for="nameMember">Họ tên</label>
                            <input type="text" class="form-control" name="nameMember" id="nameMember" placeholder="Nhập tên thành viên">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="idMember">MSCB/MSSV</label>
                            <input type="text" class="form-control" name="idMember" id="idMember" placeholder="Nhập mã số thành viên">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="phoneMember">Điện thoại</label>
                            <input type="number" class="form-control" name="phoneMember" id="phoneMember" placeholder="Nhập số điện thoại">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="mailMember">Email</label>
                            <input type="mail" class="form-control" name="mailMember" id="mailMember" placeholder="Nhập email thành viên">
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
                              <option value="0">Sinh viên</option>
                            </select>
                        </fieldset>
                        <!-- <fieldset class="form-group">
                            <label for="pictureMember">Hình ảnh</label>
                            <input type="file" class="form-control-file" name="pictureMember" id="pictureMember">
                            <small class="text-muted">Ảnh được chọn phải nhỏ hơn 5MB. Định dạng hỗ trợ: jpeg/jpg, png, gif.</small>
                        </fieldset> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="addNewMember">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

    <div id="editMember" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Chỉnh sửa thông tin</h4>
                </div>
                <div class="modal-body">
                    <form>
                      <fieldset class="form-group">
                          <label for="nameMember">Họ tên</label>
                          <input type="text" class="form-control" name="nameMember" id="nameMember" placeholder="Nhập tên thành viên">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="idMember">MSCB/MSSV</label>
                          <input type="text" class="form-control" name="idMember" id="idMember" placeholder="Nhập mã số thành viên">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="phoneMember">Điện thoại</label>
                          <input type="number" class="form-control" name="phoneMember" id="phoneMember" placeholder="Nhập số điện thoại">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="mailMember">Email</label>
                          <input type="mail" class="form-control" name="mailMember" id="mailMember" placeholder="Nhập email thành viên">
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
                          <label for="pictureMember">Hình ảnh</label>
                          <input type="file" class="form-control-file" name="pictureMember" id="pictureMember">
                          <small class="text-muted">Ảnh được chọn phải nhỏ hơn 5MB. Định dạng hỗ trợ: jpeg/jpg, png, gif.</small>
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteMember">Delete</button>
                    <button type="submit" class="btn btn-primary">Submit</button></form>
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
                    <h4 class="modal-title" id="">Bạn đang xóa thành viên!</h4>
                </div>
                <div class="modal-body">
                    <h3>Bạn có muốn tiếp tục?</h3>
                    <form>
                        <div class="modal-footer">
                            <a href="delete" type="button" class="btn btn-danger">Yes</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

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

  if ($name && $idUser && $phone && $email && $position && $level && $type) {
      $sql_add_user = "INSERT INTO user_info(idUser, idImg, fullName, phone, email, website, social, address, position, level, unit,type) VALUES ('$idUser','','$name','$phone','$email','không có','không có','ĐH Cần Thơ','$position','$level','Khoa CNTT&TT','$type')";
      $db->query($sql_add_user);
      new Redirect($_DOMAIN.'admin/account/add');
  } else echo '<div class="alert alert-warning">Vui lòng điền đầy đủ thông tin.</div>';
}
?>
