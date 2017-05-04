<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);
// else {
    if (isset($_GET['tab'])) {
      // if ($_GET["tab"] == "info") {
      //   if (isset($_GET['act'])) {
      //     if ($_GET["act"]) {
      //       $idUser = $user;
      //       //Nội dung hiển thị
      //     }
      //   }
      // } else
      if ($_GET["tab"]) {
        $id=$_GET['tab'];
      } else $id = $user;
    } else $id = $user;

    // Lấy dữ liệu tài khoản
    $sql_get_data_user = "SELECT * FROM user_info a,user_auth b WHERE (a.idUser = b.idUser) AND (a.idUser = '$id')";
    if ($db->num_rows($sql_get_data_user))
    {
        $data_user_profile = $db->fetch_assoc($sql_get_data_user, 1);
    }
?>
<div class="container">
  <center>
    <legend>Thông tin cá nhân</legend>
    <div class="row">
        <div class="col-sm-6 profile-info">
            <div class="divider"></div>
            <p><strong><br /></strong></p>
            <center>
              <div class="col-sm-3">
                <img class="profile-avatar" alt="200x200" src="<?php echo $_DOMAIN.$data_user_profile['urlImg']; ?>" data-holder-rendered="true">
              </div>
              <div class="col-sm-4">
                <br />
                <?php if (isset($_GET['tab'])) {
                  if ($_GET['tab'] == $user) {
                    echo '<a data-toggle="modal" data-target="#changeAvatar">Chỉnh sửa</a><br  />
                    <a href="'.$_DOMAIN.'profile/'.$data_user_profile['idUser'].'/delAvatar" name="delAvatar">Xóa avatar</a>';
                  }
                } else echo '<a data-toggle="modal" data-target="#changeAvatar">Chỉnh sửa</a><br  />
                <a href="'.$_DOMAIN.'profile/'.$data_user_profile['idUser'].'/delAvatar" name="delAvatar">Xóa avatar</a>';?>
              </div>
            </center>
        </div>
        <div class="col-sm-6 profile-info">
            <div class="divider"></div>
            <p><strong>Thông tin nghiên cứu </strong>
              <?php if (isset($_GET['tab'])) {
                if ($_GET['tab'] == $user) {
                  echo '<a href="#" data-toggle="modal" data-target="#changeResearch">Chỉnh sửa</a>';
                }
              } else echo '<a href="#" data-toggle="modal" data-target="#changeResearch">Chỉnh sửa</a>';?>
            </p>
            <span><strong><?php echo $data_user_profile['position']; ?></strong></span><br  />
            <span><strong>Trình độ: </strong><?php echo $data_user_profile['level']; ?></span><br  />
            <span><strong>Đơn vị: </strong><?php echo $data_user_profile['unit']; ?></span><br  />
            <?php $name = $data_user_profile['fullName'];
            $sql_get_project = "SELECT * FROM project_info WHERE nameUser = '$name'";

            if ($db->num_rows($sql_get_project)) {
              $total_project = $db->num_rows($sql_get_project);
              foreach ($db->fetch_assoc($sql_get_project, 0) as $key => $value_lab) {
                $url_lab = $_DOMAIN.'labs/info/'.$value_lab['idLab'];
              }
              echo '<span><a href="'.$url_lab.'">Các dự án đang tham gia: <span class="badge">'.$total_project.'</span></a></span>';
            } else {
              $total_project = 0;
              echo '<span>Các dự án đang tham gia: <span class="badge">'.$total_project.'</span></span>';
            }
            ?>
        </div>
        <div class="col-sm-6 profile-info">
            <div class="divider"></div>
            <p><strong>Thông tin cá nhân </strong>
              <?php if (isset($_GET['tab'])) {
                if ($_GET['tab'] == $user) {
                  echo '<a href="#" data-toggle="modal" data-target="#changeInfomation">Chỉnh sửa</a>';
                }
              } else echo '<a href="#" data-toggle="modal" data-target="#changeInfomation">Chỉnh sửa</a>';?>
            </p>
            <span><strong><?php echo $data_user_profile['fullName']; ?></strong></span><br  />
            <span><strong>Mã số: </strong><?php echo $data_user_profile['idUser']; ?></span><br  />
            <span><strong>Điện thoại: </strong><?php echo $data_user_profile['phone']; ?></span><br  />
            <span><strong>Email: </strong><?php echo $data_user_profile['email']; ?></span>
        </div>
        <div class="col-sm-6 profile-info">
            <div class="divider"></div>
            <p><strong>Thông tin khác </strong>
              <?php if (isset($_GET['tab'])) {
                if ($_GET['tab'] == $user) {
                  echo '<a href="#" data-toggle="modal" data-target="#changeOther">Chỉnh sửa</a>';
                }
              } else echo '<a href="#" data-toggle="modal" data-target="#changeOther">Chỉnh sửa</a>';?>
             </p>
              <?php if (isset($_GET['tab'])) {
                if ($_GET['tab'] == $user) {
                  echo '<span><strong>Mật khẩu: </strong><a href="#" data-toggle="modal" data-target="#changePass">Thay đổi</a></span><br  />';
                }
              } else echo '<span><strong>Mật khẩu: </strong><a href="#" data-toggle="modal" data-target="#changePass">Thay đổi</a></span><br  />';?>
            <span><strong>Website: </strong><i><a href="<?php echo $data_user_profile['website']; ?>"><?php echo $data_user_profile['website']; ?></a></i></span><br  />
            <span><strong>Mạng xã hội: </strong><i><a href="<?php echo $data_user_profile['social']; ?>"><?php echo $data_user_profile['social']; ?></a></i></span><br  />
            <span><strong>Địa chỉ: </strong><?php echo $data_user_profile['address']; ?></span>
        </div>
        <div class="col-sm-6 profile-info">
            <div class="divider"></div>
        </div>
        <div class="col-sm-6 profile-info">
            <div class="divider"></div>
        </div>
    </div>
    <?php if ($id == $user) {
    echo '<legend>Thông tin mượn thiết bị</legend>';


        $sql_get_borrow = "SELECT * FROM borrow_device_detail WHERE idUser = '$id' ORDER BY idBorrowDeviceDetail DESC";
        if ($db->num_rows($sql_get_borrow)) {

        //SQL get page
        $val_page = "SELECT *,DATE_FORMAT( dateBorrow,  '%d/%m/%Y' ) AS dateBorrow,DATE_FORMAT( dateReturn,  '%d/%m/%Y' ) AS dateReturn FROM borrow_device_detail a,borrow_device b,user_info c,device_info d WHERE (a.idBorrowDeviceDetail = b.idBorrowDevice)  AND (a.idUser = c.idUser) AND (b.idDevice = d.idDevice) AND (a.idUser = '$id') ORDER BY statusBorrow DESC";

        //Hiển thị danh sách quản lý mượn thiết bị
        echo '<form action="'.$_DOMAIN.'profile" method="post">
        <table id="infoBorrow" class="table table-striped">
                <thead>
                    <tr>
                      <tr>
                          <th>Mã số</th>
                          <th>Họ tên</th>
                          <th>Thiết bị</th>
                          <th>Số lượng</th>
                          <th>Ngày mượn</th>
                          <th>Ngày trả</th>
                          <th>Tools</th>
                      </tr>
                    </tr>
                </thead>
                <tbody>';

          foreach ($db->fetch_assoc($val_page, 0) as $key => $row) {
            $get_status = $row['statusBorrow'];
            // echo $get_status.' ';Test biến get status
            if ($get_status != 5) {
            echo '<tr'; if ($get_status == 0) {
              echo ' class="alert alert-danger"';
            } else if ($get_status == 4 || $get_status == 5) {
              echo ' class="alert alert-warning"';
            }
            echo '>
                <td>'.$row['idBorrowDeviceDetail'].'</td>
                <td>'.$row['fullName'].'</td>
                <td>'.$row['nameDevice'].'</td>
                <td>'.$row['totalBorrow'].'</td>';
                if ($get_status == 2) { echo '
                <td>'.$row['dateBorrow'].'</td>
                <td>'.$row['dateReturn'].'</td>
                <td></td>';
              } else if ($get_status == 3) { echo '
              <td>Chờ duyệt</td>
              <td>'.$row['dateReturn'].'</td>
              <td></td>';
            } else if ($get_status == 0) {
                echo '<td>Đã từ chối</td><td> </td><td> </td>';
              } else if ($get_status == 1) { echo '
                <td>'.$row['dateBorrow'].'</td>
                <td>'.$row['dateReturn'].'</td>
                <td> </td>';
              } else if ($get_status == 4 || $get_status == 6) { echo '
                <td>'.$row['dateBorrow'].'</td>
                <td>Đã quá hạn</td>
                <td>
                    <button title="Gửi yêu cầu gia hạn" type="button" id="thisRestRefresh" class="btn btn-info" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowRefresh">
                        <span class="glyphicon glyphicon-new-window"></span>
                    </button></form>
                </td>';
              } else if ($get_status == 5) { echo '
                <td>'.$row['dateBorrow'].'</td>
                <td>Đã quá hạn</td>
                <td>
                    <button title="Xác nhận yêu cầu gia hạn" type="button" id="thisRestRefresh" class="btn btn-warning" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#restRefresh">
                        <span class="glyphicon glyphicon-refresh"></span>
                    </button></form>
                </td>';
              }
            }
                echo '
            </tr>';
          }
          echo '</tbody>
      </table>';
    } else {
        echo '<div class="alert alert-info">Chưa có yêu cầu mượn nào.</div>';
    }
}
    ?>
  </center>

<!-- Modal -->

<!--Update Avatar-->
<div id="changeAvatar" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Đổi Avatar</h4>
      </div>
      <div class="modal-body">
          <form action="<?php echo $_DOMAIN; ?>profile" method="post" enctype="multipart/form-data">
            <fieldset class="form-group">
              <label>Xem trước</label>
              <center>
                <img id="avatar" class="profile-avatar" alt="your image" src="<?php echo $_DOMAIN.$data_user_profile['urlImg']; ?>" data-holder-rendered="true">
              </center>
            </fieldset>
            <fieldset class="form-group">
              <label for="upload">Tải ảnh mới</label>
              <input type="file" class="form-control" accept="image/*" multiple="true" name="img_up[]" id="upload">
            </fieldset>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="changeAvatar">Đồng ý</button></form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
    }

    $("#upload").change(function(){
    readURL(this);
    });
</script>

<!--Update Resarch-->
<div id="changeResearch" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Đổi thông tin nghiên cứu</h4>
      </div>
      <div class="modal-body">
          <form action="<?php echo $_DOMAIN; ?>profile" method="post">
            <fieldset class="form-group">
              <label for="position">Vị trí</label>
              <input type="text" class="form-control" name="position" id="position" value="<?php echo $data_user_profile['position']; ?>" placeholder="Nhập vị trí. Vd: Thực tập sinh, Nghiên cứu sinh,...">
            </fieldset>
            <fieldset class="form-group">
              <label for="level">Trình độ</label>
              <input type="text" class="form-control" name="level" id="level" value="<?php echo $data_user_profile['level']; ?>" placeholder="Nhập trình độ. Vd: Đại học, Kỹ sư, Thạc sĩ,...">
            </fieldset>
            <fieldset class="form-group">
              <label for="unit">Đơn vị</label>
              <input type="text" class="form-control" name="unit" id="unit" value="<?php echo $data_user_profile['unit']; ?>" placeholder="Nhập đơn vị">
            </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="changeResearch">Đồng ý</button></form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Update Infomation-->
<div id="changeInfomation" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Đổi thông tin cá nhân</h4>
      </div>
      <div class="modal-body">
          <form action="<?php echo $_DOMAIN; ?>profile" method="post">
            <fieldset class="form-group">
              <label for="name">Họ tên</label>
              <input type="text" class="form-control" name="name" id="name" value="<?php echo $data_user_profile['fullName']; ?>" placeholder="Nhập họ tên">
            </fieldset>
            <fieldset class="form-group">
              <label for="id-number">Mã số CB/SV</label>
              <input type="text" class="form-control" name="id-number" id="id-number" value="<?php echo $data_user_profile['idUser']; ?>" placeholder="Nhập mã số CB/SV">
            </fieldset>
            <fieldset class="form-group">
              <label for="phone">Điện thoại</label>
              <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $data_user_profile['phone']; ?>" placeholder="Nhập số điện thoại">
            </fieldset>
            <fieldset class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" name="email" id="email" value="<?php echo $data_user_profile['email']; ?>" placeholder="Nhập địa chỉ email">
            </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="changeInfomation">Đồng ý</button></form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Update Other-->
<div id="changeOther" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">Đổi thông tin khác</h4>
      </div>
      <div class="modal-body">
          <form action="<?php echo $_DOMAIN; ?>profile" method="post">
            <fieldset class="form-group">
              <label for="website">Website</label>
              <input type="text" class="form-control" name="website" id="website" value="<?php echo $data_user_profile['website']; ?>" placeholder="Nhập URL">
            </fieldset>
            <fieldset class="form-group">
              <label for="social">Mạng xã hội</label>
              <input type="text" class="form-control" name="social" id="social" value="<?php echo $data_user_profile['social']; ?>" placeholder="Nhập URL">
            </fieldset>
            <fieldset class="form-group">
              <label for="address">Địa chỉ</label>
              <input type="text" class="form-control" name="address" id="address" value="<?php echo $data_user_profile['address']; ?>" placeholder="Nhập địa chỉ">
            </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="changeOther">Đồng ý</button></form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Change Password Form-->
    <div id="changePass" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Đổi mật khẩu</h4>
          </div>
          <div class="modal-body">
              <form action="<?php echo $_DOMAIN; ?>profile" method="post">
                <fieldset class="form-group">
                  <label for="new-pass">Mật khẩu mới</label>
                  <input type="password" class="form-control" name="new-pass" id="new-pass" placeholder="Nhập mật khẩu mới">
                </fieldset>
                <fieldset class="form-group">
                  <label for="re-password">Nhập lại mật khẩu mới</label>
                  <input type="password" class="form-control" name="re-pass" id="re-password" placeholder="Nhập lại mật khẩu mới">
                </fieldset>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="changePass">Đồng ý</button></form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<!--Modal gia hạn mượn thiết bị-->
<div id="borrowRefresh" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Gia hạn mượn thiết bị</h4>
            </div>
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>profile" method="post">
                <input type="hidden" name="toRefreshDevice" id="toRefreshDevice" value=""/>
                <button type="submit" name="refreshOK" class="btn btn-primary">Đồng ý</button></form>
            </div>
        </div>
    </div>
</div>

<!--Modal yêu cầu gian hạn mượn thiết bị-->
<div id="restRefresh" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Gửi yêu cầu gia mượn thiết bị</h4>
            </div>
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>profile" method="post">
                <input type="hidden" name="toRestRefreshDevice" id="toRestRefreshDevice" value=""/>
                <button type="submit" name="restRefreshOK" class="btn btn-primary">Đồng ý</button></form>
            </div>
        </div>
    </div>
</div>

<!-- JS Function -->
<script type="text/javascript">
$('#borrowRefresh').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toRefreshDevice").val(product);
});

$('#restRefresh').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toRestRefreshDevice").val(product);
});
</script>
<?php
// Xử Lý avatar
  if (isset($_FILES['img_up'])) {
    foreach($_FILES['img_up']['name'] as $name => $value)
      {
        $dir = 'view/images/';
        $name_img = stripslashes($_FILES['img_up']['name'][$name]);
        $source_img = $_FILES['img_up']['tmp_name'][$name];
        $size_img = $_FILES['img_up']['size'][$name]; // Dung lượng file

        if ($size_img > 5242880){
            new Warning($_DOMAIN.'profile','File không được lớn hơn 5MB');
        } else {
            // Upload file
            // Tạo folder năm hiện tại
            if (!is_dir($dir.$year_current))
            {
                mkdir($dir.$year_current.'/');
            }

            // Tạo folder tháng hiện tại
            if (!is_dir($dir.$year_current.'/'.$month_current))
            {
                mkdir($dir.$year_current.'/'.$month_current.'/');
            }

            // Tạo folder ngày hiện tại
            if (!is_dir($dir.$year_current.'/'.$month_current.'/'.$day_current))
            {
                mkdir($dir.$year_current.'/'.$month_current.'/'.$day_current.'/');
            }

            $path_img = $dir.$year_current.'/'.$month_current.'/'.$day_current.'/'.$name_img; // Đường dẫn thư mục chứa file
            move_uploaded_file($source_img, $path_img); // Upload file
            $array = (explode(".",$name_img));
            $type_img = $array[1];// Loại file
            $url_img = $path_img; // Đường dẫn file

            // Thêm dữ liệu vào table
            $sql_up_file = "INSERT INTO images VALUES ('','$url_img','$type_img','$size_img','$date_current')";
            $db->query($sql_up_file);
            $sql_change_avatar = "UPDATE user_info SET urlImg = '$url_img' WHERE idUser = '$id'";
            $db->query($sql_change_avatar);
            // echo '<div class="alert alert-success">File Uploaded</div>';
            new Success($_DOMAIN.'profile','Thay đổi avatar thành công');
            }
          }
        }

//Xử lý xóa avatar
if (isset($_GET['tab'])) {
  if ($_GET['tab'] == $user) {
    if (isset($_GET['act'])) {
      if ($_GET['act'] == 'delAvatar') {
        $url = $data_user_profile['urlImg'];
        $sql_check_id_img_exist = "SELECT * FROM images WHERE url = '$url'";
          if ($db->num_rows($sql_check_id_img_exist))
          {
              $data_img = $db->fetch_assoc($sql_check_id_img_exist, 1);
              if (file_exists($data_img['url']))
              {
                  unlink($data_img['url']);
              }

              $sql_delete_img = "DELETE FROM images WHERE url = '$url'";
              $db->query($sql_delete_img);
              $sql_del_avatar = "UPDATE user_info SET urlImg = '$avatarDefault' WHERE idUser = '$id'";
              $db->query($sql_del_avatar);
          }
        new Success($_DOMAIN.'profile','Xóa avatar thành công');
      } else new Warning($_DOMAIN.'profile','Có lỗi xảy ra! Vui lòng kiểm tra lại');
    } else new Redirect($_DOMAIN.'profile');
  } else new Warning('','Bạn không có quyền thay đổi thông tin người dùng khác');
}

//Xử lý avatar bị xóa
$sql_get_avatar = "SELECT urlImg FROM user_info WHERE idUser = '$id'";
foreach ($db->fetch_assoc($sql_get_avatar,1) as $key => $img) {
  if (!file_exists($img))
    {
      new Info('','Avatar đã bị xóa! Hệ thống tự động chuyển về avatar mặc định sau 2s.');
      $sql_del_avatar = "UPDATE user_info SET urlImg = '$avatarDefault' WHERE idUser = '$id'";
      $db->query($sql_del_avatar);
      new Reload($_DOMAIN.'profile');
    }
}

//Xử lý thông tin nghiên cứu
if (isset($_POST['changeResearch'])) {
  $position = $_POST['position'];
  $level = $_POST['level'];
  $unit = $_POST['unit'];

  if ($position && $level && $unit) {
    $sql_change_research = "UPDATE user_info SET position='$position',level='$level',unit='$unit' WHERE idUser = '$id'";
    $db->query($sql_change_research);
    new Success($_DOMAIN.'profile');
  } else new Warning($_DOMAIN.'profile','Vui lòng điền đầy đủ thông tin');
}
//Xử lý thông tin cá nhân
if (isset($_POST['changeInfomation'])) {
  $name = $_POST['name'];
  $id_number = $_POST['id-number'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

  if ($name && $id_number && $phone && $email) {
    $sql_change_info = "UPDATE user_info SET fullName='$name',idUser='$id_number',phone='$phone',email='$email' WHERE idUser = '$id'";
    $db->query($sql_change_info);
    new Success($_DOMAIN.'profile');
  } else new Warning($_DOMAIN.'profile','Vui lòng điền đầy đủ thông tin');
}
//Xử lý thông tin khác
if (isset($_POST['changeOther'])) {
  $website = $_POST['website'];
  $social = $_POST['social'];
  $address = $_POST['address'];

  if ($website && $social && $address) {
    $sql_change_other = "UPDATE user_info SET website='$website',social='$social',address='$address' WHERE idUser = '$id'";
    $db->query($sql_change_other);
    new Success($_DOMAIN.'profile');
  } else new Warning($_DOMAIN.'profile','Vui lòng điền đầy đủ thông tin');
}
//Xử lý đổi mật khẩu
if (isset($_POST['changePass'])) {
  $new_pass = $_POST['new-pass'];
  $re_pass = $_POST['re-pass'];

  if ($new_pass && $re_pass ) {
    if ($new_pass == $re_pass ) {
      $sql_change_pass = "UPDATE user_auth SET pwd='$new_pass' WHERE idUser = '$id'";
      $db->query($sql_change_pass);
      new Success($_DOMAIN.'profile');
    } else new Warning($_DOMAIN.'profile','Mật khẩu không khớp');
  } else new Warning($_DOMAIN.'profile','Vui lòng điền đầy đủ thông tin');
}

//Xử lý đồng ý gia hạn thiết bị
if (isset($_POST['refreshOK'])) {
  $refresh = $_POST['toRefreshDevice'];

  $sql_refresh = "UPDATE borrow_device_detail SET statusBorrow = 2, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$refresh'";//status = 2 -> Accept
  if ($refresh) {
    $db->query($sql_refresh);
  }
  new Success($_DOMAIN.'profile');
}

//Xử lý gửi yêu cầu gia hạn thiết bị
if (isset($_POST['restRefreshOK'])) {
  $rest = $_POST['toRestRefreshDevice'];

  $sql_rest_refresh = "UPDATE borrow_device_detail SET statusBorrow = 5 WHERE idBorrowDeviceDetail = '$rest'";//status = 5 -> Rest
  if ($rest) {
    $db->query($sql_rest_refresh);
  }
  new Success($_DOMAIN.'profile');
}


?>
