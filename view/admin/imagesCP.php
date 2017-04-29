
<?php

// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap

//
// // Nếu đăng nhập
// if ($user)
// {
//
//     echo '<h3>Hình ảnh</h3>';
//     // Lấy tham số ac
//     if (isset($_GET['ac']))
//     {
//         $ac = trim(addslashes(htmlspecialchars($_GET['ac'])));
//     }
//     else
//     {
//         $ac = '';
//     }
//
//
//     // Nếu có tham số ac
//     if ($ac != '')
//     {
//         // Trang upload hình ảnh
//         if ($ac == 'add')
//         {
//             // Dãy nút của upload hình ảnh
//             echo
//             '';
?>
        <h3>Hình ảnh</h3>
            <a class="btn btn-default" data-toggle="modal" data-target="#addNewPhoto">
                <span class="glyphicon glyphicon-plus"></span> Thêm
            </a>
            <a href="<?php echo $_DOMAIN; ?>admin/images" class="btn btn-default">
                <span class="glyphicon glyphicon-repeat"></span> Reload
            </a>
            <a class="btn btn-danger" id="del_img_list">
                <span class="glyphicon glyphicon-trash"></span> Xoá
            </a>

<?php
        // Content danh sách hình ảnh
        $sql_get_img = "SELECT * FROM images ORDER BY idImg DESC";
          if ($db->num_rows($sql_get_img))
          {
              echo '
                  <div class="row list" id="list_img">
                      <div class="col-md-12">
                          <div class="checkbox"><label><input type="checkbox" onClick="toggle(this)"> Chọn/Bỏ chọn tất cả</label></div>
                      </div>
                  <script language="JavaScript">
                        function toggle(source) {'."
                          checkboxes = document.getElementsByName('idImg[]')".';
                            for(var i=0, n=checkboxes.length;i<n;i++) {
                              checkboxes[i].checked = source.checked;
                            }
                          }
                  </script>
              ';
              foreach($db->fetch_assoc($sql_get_img, 0) as $key => $data_img)
              {
                  // Trạng thái ảnh
                  if (file_exists($data_img['url'])) {
                      $status_img = '<label class="label label-success">Tồn tại</label>';
                  }
                  else
                  {
                      $status_img = '<label class="label label-danger">Hỏng</label>';
                  }

                  // Dung lượng ảnh
                  if ($data_img['size'] < 1024) {
                      $size_img = $data_img['size'] . 'B';
                  } else if ($data_img['size'] < 1048576) {
                      $size_img = round($data_img['size'] / 1024) . 'KB';
                  } else if ($data_img['size'] > 1048576) {
                      $size_img = round($data_img['size'] / 1024 / 1024) . 'MB';
                  }

                  echo
                  '   <div class="col-md-3">
                          <div class="thumbnail">
                              <a href="' . str_replace('admin/', '', $_DOMAIN) . $data_img['url'] . '">
                                  <img src="' . str_replace('admin/', '', $_DOMAIN) . $data_img['url'] . '" style="height: 150px;">
                              </a>
                              <div class="caption">
                                  <div class="input-group">
                                      <span class="input-group-addon">
                                          <input type="checkbox" name="idImg[]" value="' . $data_img['idImg'] . '">
                                      </span>
                                      <input type="text" class="form-control" value="' . str_replace('admin/', '', $_DOMAIN)  . $data_img['url'] . '" disabled>
                                      <span class="input-group-btn">
                                          <a href="'.$_DOMAIN.'admin/images/delete_img" class="btn btn-danger del-img" data-id="' . $data_img['idImg'] . '">
                                              <span class="glyphicon glyphicon-trash"></span>
                                          </a>
                                      </span>
                                  </div>
                                  <p>Trạng thái: ' . $status_img . '</p>
                                  <p>Dung lượng: ' . $size_img . '</p>
                                  <p>Định dạng: ' . strtoupper($data_img['type']) . '</p>
                              </div>
                          </div>
                      </div>
                  ';
              }
              echo '</div>';
          }
          else
          {
              echo '<br><br><div class="alert alert-info">Chưa có hình ảnh nào.</div>';
          }
        // }

        // Xử Lý Upload
          if (isset($_FILES['img_up'])) {
            foreach($_FILES['img_up']['name'] as $name => $value)
          		{
                $dir = 'view/images/';
                $name_img = stripslashes($_FILES['img_up']['name'][$name]);
                $source_img = $_FILES['img_up']['tmp_name'][$name];
                $size_img = $_FILES['img_up']['size'][$name]; // Dung lượng file

                if ($size_img > 10485760){
                    echo "File không được lớn hơn 10MB";
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
                    // echo '<div class="alert alert-success">File Uploaded</div>';
                    new Redirect($_DOMAIN.'admin/images');
                    }
                  }
                }

// Nếu tồn tại POST act
if (isset($_POST['act']))
{
  $act = trim(addslashes(htmlspecialchars($_POST['act'])));

  // Xoá nhiều ảnh cùng lúc
  if ($act == 'delete_img_list')
  {
    foreach ($_POST['idImg'] as $key => $id_img)
    {
      $sql_check_id_img_exist = "SELECT * FROM images WHERE idImg = '$id_img'";
      if ($db->num_rows($sql_check_id_img_exist))
      {
        $data_img = $db->fetch_assoc($sql_check_id_img_exist, 1);
        if (file_exists($data_img['url']))
        {
          unlink($data_img['url']);
        }

        $sql_delete_img = "DELETE FROM images WHERE idImg = '$id_img'";
        $db->query($sql_delete_img);
      }
    }
    $db->close();
  }
  // Xoá ảnh chỉ định
  else if ($act == 'delete_img')
  {
    $id_img = trim(htmlspecialchars(addslashes($_POST['idImg'])));
    $sql_check_id_img_exist = "SELECT * FROM images WHERE idImg = '$id_img'";
    if ($db->num_rows($sql_check_id_img_exist))
    {
      $data_img = $db->fetch_assoc($sql_check_id_img_exist, 1);
      if (file_exists($data_img['url']))
      {
        unlink($data_img['url']);
      }

      $sql_delete_img = "DELETE FROM images WHERE idImg = '$id_img'";
      $db->query($sql_delete_img);
      $db->close();
    }
  }
}
// else
// {
//   new Redirect($_DOMAIN);
// }
// }
// // Ngược lại chưa đăng nhập
// else
// {
//     new Redirect($_DOMAIN); // Trở về trang index
// }

?>


<div class="modal fade" id="addNewPhoto" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thêm hình ảnh</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">Mỗi file có dung lượng không vượt quá 10MB và có đuôi định dạng là .jpg, .png.gif., </div>
        <form method="post" action="#" class="form-group" id="formUpImg" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Chọn hình ảnh</label>
                  <input type="file" class="form-control" accept="image/*" name="img_up[]" multiple="true" id="img_up_sc" onchange="preUpImg();"/>
                </div>
                <div class="form-group box-pre-img hidden">
                    <p><strong>Ảnh xem trước</strong></p>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary" name="uploadclick" value="Upload" id="upload"/>
                  <button class="btn btn-default" type="reset">Chọn lại</button>
                </div>
                <div class="alert alert-danger hidden"></div>
            </form>

            <script>
            // Xem ảnh trước
            function preUpImg() {
                img_up = $('#img_up_sc').val();
                count_img_up = $('#img_up_sc').get(0).files.length;
                $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
                $('#formUpImg .box-pre-img').removeClass('hidden');

                // Nếu đã chọn ảnh
                if (img_up != '')
                {
                    $('#formUpImg .box-pre-img').html('<p><strong>Ảnh xem trước</strong></p>');
                    $('#formUpImg .box-pre-img').removeClass('hidden');
                    for (i = 0; i <= count_img_up - 1; i++)
                    {
                        $('#formUpImg .box-pre-img').append('<img src="' + URL.createObjectURL(event.target.files[i]) + '" style="border: 1px solid #ddd; width: 50px; height: 50px; margin-right: 5px; margin-bottom: 5px;"/>');
                    }
                }
                // Ngược lại chưa chọn ảnh
                else
                {
                    $('#formUpImg .box-pre-img').html('');
                    $('#formUpImg .box-pre-img').addClass('hidden');
                }
            }
            </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
