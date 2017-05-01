
<?php

// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap?>
        <h3>Hình ảnh</h3>
          <form action="<?php echo $_DOMAIN; ?>admin/images" method="POST">
            <a class="btn btn-default" data-toggle="modal" data-target="#addNewPhoto">
                <span class="glyphicon glyphicon-plus"></span> Thêm
            </a>
            <a href="<?php echo $_DOMAIN; ?>admin/images" class="btn btn-default">
                <span class="glyphicon glyphicon-repeat"></span> Reload
            </a>
            <button class="btn btn-danger" id="del_img_list" name="delImages" type="submit">
                <span class="glyphicon glyphicon-trash"></span> Xoá
            </button>

<?php
       //Xóa nhiều ảnh
        if (isset($_POST['delImages'])) {
        $id_img_del = $_POST['idImg'];
        foreach ($id_img_del as $key => $data) {
          $sql_query_name = "SELECT * FROM images WHERE idImg = '$data'";
          foreach ($db->fetch_assoc($sql_query_name) as $key => $img_url) {
            $sql_del_imgs = "DELETE FROM images WHERE url = '$img_url'";
            $db->query($sql_del_imgs);
          }
        }
        // new Success($_DOMAIN.'admin/images','Xóa các hình ảnh thành công');
        }
        //Xóa 1 ảnh
        if (isset($_POST['delImgOK'])) {
        $idDel = $_POST['toDelImg'];

        $sql_query_name = "SELECT * FROM images WHERE idImg = '$idDel'";
        foreach ($db->fetch_assoc($sql_query_name) as $key => $img_url) {
          $sql_del_img = "DELETE FROM images WHERE url = '$img_url'";
          $db->query($sql_del_img);
        }
        // new Success($_DOMAIN.'admin/images','Xóa hình ảnh thành công');
        }

      // Content danh sách hình ảnh
          $sql_get_images = "SELECT * FROM images ORDER BY idImg DESC";
          if ($db->num_rows($sql_get_images))
          {
              $row="SELECT idImg FROM images";
              $row_per_page=12;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['act']) && (int)$_GET['act'])
                   $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              echo '
                  <div class="row list" id="list_img">
                      <div class="col-md-12">
                          <div class="checkbox"><label><input type="checkbox" onClick="toggle(this)"> Chọn/Bỏ chọn tất cả</label></div>
                      </div>
              ';

              $val_images = "SELECT * FROM images ORDER BY idImg DESC LIMIT $start,$row_per_page";

              foreach($db->fetch_assoc($val_images, 0) as $key => $data_img)
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
                                          <a class="btn btn-danger" data-id="'.$data_img['idImg'].'" data-toggle="modal" data-target="#thisDelImg">
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
              echo '</div>
              </form>';
          }
          else
          {
              echo '<br><br><div class="alert alert-info">Chưa có hình ảnh nào.</div>';
          }
        // }

echo '<div class="container">';

$row="SELECT idImg FROM images";
$rows=$db->num_rows($row);
$config = array(
    'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 12,// limit
    'link_full'     => $_DOMAIN.'admin/images/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/images',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();

echo '</div>';

echo '<!-- Content chức năng tài khoản -->
<!-- Xóa hình ảnh -->
<div class="modal fade" id="thisDelImg" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Xóa tài khoản!</h4>
      </div>
      <div class="modal-body">
      <form action="'.$_DOMAIN.'admin/images" method="POST">
        <input type="hidden" name="toDelImg" id="toDelImg" value=""/>
        <center>
          <p><strong>Xác nhận xóa hình ảnh</strong></p>
        </center>
      </div>
      <div class="modal-footer">
        <button type="submit" name="delImgOK" class="btn btn-primary">Đồng ý</button></form>
      </div>
    </div>
  </div>
</div>';

// Xử Lý Upload
  if (isset($_FILES['img_up'])) {
    foreach($_FILES['img_up']['name'] as $name => $value)
      {
        $dir = 'view/images/';
        $name_img = stripslashes($_FILES['img_up']['name'][$name]);
        $source_img = $_FILES['img_up']['tmp_name'][$name];
        $size_img = $_FILES['img_up']['size'][$name]; // Dung lượng file

        if ($size_img > 10485760){
            new Warning('','File không được lớn hơn 10MB');
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
            new Success($_DOMAIN.'admin/images','Upload ảnh thành công');
            }
          }
        }

?>

<!-- JS Function -->
<script language="JavaScript">
      function toggle(source) {
        checkboxes = document.getElementsByName('idImg[]');
          for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
          }
        }
//delUser
$('#thisDelImg').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toDelImg").val(product);
});
</script>

<div class="modal fade" id="addNewPhoto" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thêm hình ảnh</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">Mỗi file có dung lượng không vượt quá 10MB và có đuôi định dạng là .jpg, .png.gif., </div>
        <form method="post" action="<?php echo $_DOMAIN; ?>admin/images" class="form-group" id="formUpImg" enctype="multipart/form-data">
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
