<?php // Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);?>

<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addDevice"></a>

<h3>Quản lý thiết bị</h3>
  <button class="btn btn-success" data-toggle="modal" data-target="#addDevice">Thêm thiết bị mới</button>
  <a href="<?php echo $_DOMAIN; ?>admin/deviceCP" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>

  <?php
  //Thêm thiết bị
    if(isset($_POST['add_device'])){
      $nameDevice = addslashes($_POST['nameDevice']);
      $dateDevice = $_POST['dateDevice'];
      $statusDevice = $_POST['statusDevice'];
      $currencyDevice = $_POST['currencyDevice'];
      $totalDevice = $_POST['totalDevice'];
      $descriptionDevice = $_POST['descriptionDevice'];
      $producerDevice = $_POST['partnerDevice'];

      if($nameDevice && $dateDevice && $statusDevice && $totalDevice && $producerDevice && $currencyDevice && $descriptionDevice)
         {
           // Xử Lý Upload
           if (isset($_FILES['icon_up'])) {
               $dir_img = 'view/images/';
               $name_img = stripslashes($_FILES['icon_up']['name']);
               $source_img = $_FILES['icon_up']['tmp_name'];
               $size_img = $_FILES['icon_up']['size']; // Dung lượng file

                 if ($size_img > 10485760){
                     new Warning('','File không được lớn hơn 10MB');
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

                     // Thêm ảnh vào table images
                     $sql_up_file = "INSERT INTO images VALUES ('','$url_img','$type_img','$size_img','$date_current')";
                     $db->query($sql_up_file);
                     }
                 }
            $sql_add_new_device = "INSERT INTO device_info(idProducer,urlImg,nameDevice,status,currency,pricing,total,dateImport,description) VALUES ('$producerDevice','$url_img','$nameDevice','$statusDevice','$currencyDevice',0,'$totalDevice','$dateDevice','$descriptionDevice')";
            $query = $db->query($sql_add_new_device);
           new Success($_DOMAIN.'admin/deviceCP','Thêm thiết bị mới thành công');
        } else new Warning($_DOMAIN.'admin/deviceCP','Vui lòng điền đầy đủ thông tin');
      }

      //Xử lý icon bị xóa
      $sql_get_num_rows = "SELECT idDevice FROM device_info";
      $num = $db->num_rows($sql_get_num_rows);
      for ($i = 1; $i <= $num; $i++) {
        $sql_get_icon_device = "SELECT urlImg FROM device_info WHERE idDevice = '$i'";
        foreach ($db->fetch_assoc($sql_get_icon_device,1) as $key => $img) {
          if (!file_exists($img))
            {
              // new Info('','Hình ảnh thiết bị đã bị xóa! Hệ thống tự động chuyển về hình ảnh mặc định sau 2s.');
              $sql_img_default = "UPDATE device_info SET urlImg = '$imgDeviceDefault' WHERE idDevice = '$i'";
              $db->query($sql_img_default);
              new Reload($_DOMAIN.'admin/deviceCP');
            }
        }
      }

  ?>

<table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Hình ảnh</th>
                <th>Tên thiết bị</th>
                <th>Mô tả</th>
                <th>Ngày nhập</th>
                <th>Trạng thái</th>
                <th>Giá trị</th>
                <th>Số lượng</th>
                <th>Chỉnh sửa</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $sql_get_user = "SELECT * FROM device_info ORDER BY idDevice DESC";
          if ($db->num_rows($sql_get_user)) {
              $row="SELECT idDevice FROM device_info";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['act']) && (int)$_GET['act'])
                   $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              // var_dump($start);
              $val_device = "SELECT *,DATE_FORMAT( dateImport,  '%d/%m/%Y' ) AS date FROM device_info a,partner_info b WHERE (a.idProducer = b.idProducer) ORDER BY a.idDevice DESC limit $start,$row_per_page";

              foreach ($db->fetch_assoc($val_device, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idDevice'].'</td>
                    <td><img src="'.$_DOMAIN.$row['urlImg'].'" style="width:100px;height:100px;"/></td>
                    <td>'.$row['nameDevice'].'</td>
                    <td>'.$row['description'].'</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['status'].'</td>
                    <td>'.$row['pricing'].'</td>
                    <td>'.$row['total'].'</td>
                    <td>
                        <button type="button" id="thisaddTotal" class="btn btn-warning" data-id="'.$row['idDevice'].'" data-toggle="modal" data-target="#addTotal"><span class="glyphicon glyphicon-plus"></span></button>
                        <button type="button" id="thiseditDevice" class="btn btn-primary" data-id="'.$row['idDevice'].'" data-name="'.$row['nameDevice'].'" data-description="'.$row['description'].'" data-pricing="'.$row['pricing'].'" data-total="'.$row['total'].'" data-toggle="modal" data-target="#editThisDevice"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button type="button" id="thisdelDevice" class="btn btn-danger" data-id="'.$row['idDevice'].'" data-toggle="modal" data-target="#deleteDevice"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>';
              }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có thiết bị nào.</div>';
          }
          ?>
        </tbody>
    </table>

    <div class="container">
<?php
$row="SELECT idDevice FROM device_info";
$rows=$db->num_rows($row);
$config = array(
    'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => $_DOMAIN.'admin/deviceCP/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/deviceCP',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
    <!-- Thêm thiết bị -->
    <div id="addDevice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Thêm thiết bị mới</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/deviceCP" method="post" enctype="multipart/form-data">
                        <fieldset class="form-group">
                            <label for="nameDevice">Tên thiết bị</label>
                            <input type="text" class="form-control" name="nameDevice" id="nameDevice" placeholder="Nhập tên thiết bị">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="dateDevice">Ngày nhập</label>
                            <input type="date" class="form-control" name="dateDevice" id="dateDevice" placeholder="Chọn ngày nhập">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="statusDevice">Tình trạng nhập vào</label>
                            <select class="form-control" name="statusDevice" id="statusDevice">
                              <option>Rất tốt</option>
                              <option>Tốt</option>
                              <option>Trung bình</option>
                              <option>Kém</option>
                              <option>Hỏng</option>
                              <option>Đang bảo trì</option>
                              <option>Đã thanh lý</option>
                            </select>
                            <small class="text-muted">Nếu đang bảo trì thì chọn Đang bảo trì. Nếu đã thanh lý, chọn Đã thanh lý. Ngược lại, chọn các mức tình trạng tự đánh giá.</i></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="totalDevice">Số lượng</label>
                            <input type="number" class="form-control" name="totalDevice" id="totalDevice" placeholder="Nhập số lượng">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="currencyDevice">Đơn vị tính</label>
                            <input type="text" class="form-control" name="currencyDevice" id="currencyDevice" placeholder="Nhập đơn vị tính">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="descriptionDevice">Mô tả</label>
                            <input type="text" class="form-control" name="descriptionDevice" id="descriptionDevice" placeholder="Nhập mô tả về thiết bị">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="partnerDevice">Nhà cung cấp/sản xuất</label>
                            <select class="form-control" name="partnerDevice" id="partnerDevice">
                              <option value="Other">Other</option>
                              <?php
                                  //Chọn nhà sản xuất
                                  $sql_producer = "SELECT idProducer,nameProducer FROM partner_info";
                                  foreach ($db->fetch_assoc($sql_producer,0) as $key => $data) {
                                    echo '<option value="'.$data['idProducer'].'">'.$data['nameProducer'].'</option>';
                                  }
                              ?>
                            </select>
                            <small class="text-muted">Nếu không rõ nhà sản xuất thì chọn Other</i></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="pictureDevice">Hình ảnh</label>
                            <input type="file" class="form-control" name="icon_up" id="pictureDevice" accept="image/*">
                        </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="add_device" class="btn btn-primary">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

    <!-- Chỉnh sửa thiết bị -->
    <div id="editThisDevice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Thêm thiết bị mới</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/deviceCP" method="post" enctype="multipart/form-data">
                        <fieldset class="form-group">
                            <label for="nameDevice">Tên thiết bị</label>
                            <input type="text" class="form-control" name="nameDevice" id="nameDevice" placeholder="Nhập tên thiết bị">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="dateDevice">Ngày nhập</label>
                            <input type="date" class="form-control" name="dateDevice" id="dateDevice" placeholder="Chọn ngày nhập">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="statusDevice">Tình trạng nhập vào</label>
                            <select class="form-control" name="statusDevice" id="statusDevice">
                              <option>Rất tốt</option>
                              <option>Tốt</option>
                              <option>Trung bình</option>
                              <option>Kém</option>
                              <option>Hỏng</option>
                              <option>Đang bảo trì</option>
                              <option>Đã thanh lý</option>
                            </select>
                            <small class="text-muted">Nếu đang bảo trì thì chọn Đang bảo trì. Nếu đã thanh lý, chọn Đã thanh lý. Ngược lại, chọn các mức tình trạng tự đánh giá.</i></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="totalDevice">Số lượng</label>
                            <input type="number" class="form-control" name="totalDevice" id="totalDevice" placeholder="Nhập số lượng">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="currencyDevice">Đơn vị tính</label>
                            <input type="text" class="form-control" name="currencyDevice" id="currencyDevice" placeholder="Nhập đơn vị tính">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="descriptionDevice">Mô tả</label>
                            <input type="text" class="form-control" name="descriptionDevice" id="descriptionDevice" placeholder="Nhập mô tả về thiết bị">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="partnerDevice">Nhà cung cấp/sản xuất</label>
                            <select class="form-control" name="partnerDevice" id="partnerDevice">
                              <option value="Other">Other</option>
                              <?php
                                  //Chọn nhà sản xuất
                                  $sql_producer = "SELECT idProducer,nameProducer FROM partner_info";
                                  foreach ($db->fetch_assoc($sql_producer,0) as $key => $data) {
                                    echo '<option value="'.$data['idProducer'].'">'.$data['nameProducer'].'</option>';
                                  }
                              ?>
                            </select>
                            <small class="text-muted">Nếu không rõ nhà sản xuất thì chọn Other</i></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="pictureDevice">Hình ảnh</label>
                            <input type="file" class="form-control" name="icon_up" id="pictureDevice" accept="image/*">
                        </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="add_device" class="btn btn-primary">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bổ sung số lượng -->
    <div id="addTotal" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Bạn đang xóa thiết bị!</h4>
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

    <!-- Xóa thiết bị -->
    <div id="deleteDevice" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Bạn đang xóa thiết bị!</h4>
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
