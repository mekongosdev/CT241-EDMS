<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
else {
    if (isset($_GET['tab'])) {
      if ($_GET["tab"]) {
        $id=$_GET['tab'];
      } else $id = $user;
    } else $id = $user;

    // Lấy dữ liệu tài khoản
    $sql_get_data_user = "SELECT * FROM user_info a,user_auth b,images c WHERE (a.idUser = b.idUser) AND (a.idImg = c.idImg) AND (a.idUser = '$id')";
    if ($db->num_rows($sql_get_data_user))
    {
        $data_user_profile = $db->fetch_assoc($sql_get_data_user, 1);
    }
    // $sql_get_data_avatar = "SELECT * FROM user_info INNER JOIN images ON user_info.idImg = images.idImg WHERE user_info.idUser = '$id'";
    // if ($db->num_rows($sql_get_data_avatar))
    // {
    //     $data_user_avatar = $db->fetch_assoc($sql_get_data_avatar, 1);
    // }
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
                <img class="profile-avatar" alt="200x200" src="<?php echo $_DOMAIN.$data_user_profile['url']; ?>" data-holder-rendered="true">
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
            $total_project = $db->num_rows($sql_get_project);
            foreach ($db->fetch_assoc($sql_get_project, 0) as $key => $value_lab) {
              $url_lab = $_DOMAIN.'labs/info/'.$value_lab['idLab'];
            }
            if ($value_lab['idLab'] != 0) {
              echo '
              <span><a href="'.$url_lab.'">Các dự án đang tham gia: <span class="badge">'.$total_project.'</span></a></span>';
            } else echo '
            <span>Các dự án đang tham gia: <span class="badge">'.$total_project.'</span></span>';
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
              } else echo '<a href="#" data-toggle="modal" data-target="#changePass">Thay đổi</a></span><br  />';?>
            <span><strong>Website: </strong><i><?php echo $data_user_profile['website']; ?></i></span><br  />
            <span><strong>Mạng xã hội: </strong><i><?php echo $data_user_profile['social']; ?></i></span><br  />
            <span><strong>Địa chỉ: </strong><?php echo $data_user_profile['address']; ?></span>
        </div>
    </div>
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
                <img id="avatar" class="profile-avatar" alt="your image" src="<?php echo $_DOMAIN.$data_user_profile['url']; ?>" data-holder-rendered="true">
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
            $path_img = $dir.$name_img; // Đường dẫn thư mục chứa file
            move_uploaded_file($source_img, $path_img); // Upload file
            $array = (explode(".",$name_img));
            $type_img = $array[1];// Loại file
            $url_img = $path_img; // Đường dẫn file

            // Thêm dữ liệu vào table
            $sql_up_file = "INSERT INTO images VALUES ('','$url_img','$type_img','$size_img','$date_current')";
            $db->query($sql_up_file);
            $sql_get_img = "SELECT * FROM images ORDER BY idImg DESC";
            $idImg = $db->num_rows($sql_get_img);
            $idImg = $idImg + 1;
            $sql_change_avatar = "UPDATE user_info SET idImg = '$idImg' WHERE idUser = '$id'";
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
        $sql_del_avatar = "UPDATE user_info SET idImg = 1 WHERE idUser = '$id'";
        $db->query($sql_del_avatar);
        new Success($_DOMAIN.'profile','Xóa avatar thành công');
      } else new Warning($_DOMAIN.'profile','Có lỗi xảy ra! Vui lòng kiểm tra lại');
    } else new Redirect($_DOMAIN.'profile');
  } else new Warning('','Bạn không có quyền thay đổi thông tin người dùng khác');
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

?>
