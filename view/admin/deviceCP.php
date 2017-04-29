<?php // Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap ?>

<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addDevice"></a>

<table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Hình ảnh</th>
                <th>Tên thiết bị</th>
                <th>Mô tả</th>
                <th>Ngày nhập</th>
                <th>Trạng thái</th>
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
              if(isset($_GET['page']) && (int)$_GET['page'])
                   $start=($_GET['page']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              // var_dump($start);
              $val = "SELECT *,DATE_FORMAT( dateImport,  '%d/%m/%Y' ) AS date FROM device_info a,partner_info b,images c WHERE (a.idProducer = b.idProducer) AND (a.idImg = c.idImg) ORDER BY a.idDevice ASC limit $start,$row_per_page";
              $retval = $db->query($val);

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idDevice'].'</td>
                    <td><img src="';echo $_DOMAIN.$row['url']; echo '" style="width:100px;height:100px;"/></td>
                    <td>'.$row['nameDevice'].'</td>
                    <td>'.$row['description'].'</td>
                    <td>'.$row['date'].'</td>
                    <td>'.$row['status'].'</td>
                    <td>'.$row['total'].'</td>
                    <td>
                        <button type="button" id="editMembers" class="btn btn-primary" data-toggle="modal" data-target="#editMember"><span class="glyphicon glyphicon-pencil"></span></button>
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
    'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => '?action=history&page={page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => '?action=history',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>

    <div id="addDevice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Thêm thiết bị mới</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/device" method="post" enctype="multipart/form-data">
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
                            <label for="partnerDevice">Nhà cung cấp</label>
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
                            <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#viewDevice">View</a> -->
                            <!-- <input type="file" class="form-control" accept="image/*" name="imgDevice" id="pictureDevice">
                            <small class="text-muted">Ảnh được chọn phải nhỏ hơn 5MB. Định dạng hỗ trợ: jpeg/jpg, png, gif.</small> -->
                            <!-- <div class="picker"> -->
                            <select class="form-control image-picker show-html" name="pictureDevice" id="pictureDevice">
                              <?php
                                  //Chọn nhà sản xuất
                                  $sql_producer = "SELECT idImg,url FROM images";
                                  foreach ($db->fetch_assoc($sql_producer,0) as $key => $data) {
                                    // echo '<option data-img-src="'.$_DOMAIN.$data['url'].'" data-img-class="first" data-img-alt="Page 1" value="'.$data['idImg'].'">'. substr($data_img['url'], 12).'</option>';
                                    echo '<option value="'.$data['idImg'].'" style="background-image:'."url('".$_DOMAIN.$data['url']."'".');">'. substr($data_img['url'], 12).'</option>';
                                  }
                              ?>
                            </select>
                        </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="add_device" class="btn btn-primary">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>$("select").imagepicker()</script> -->

    <!-- <div id="editDevice" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Chỉnh sửa thông tin</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <fieldset class="form-group">
                            <label for="nameDevice">Tên thiết bị</label>
                            <input type="text" class="form-control" name="nameDevice" id="nameDevice" placeholder="Nhập tên thiết bị">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="dateDevice">Ngày nhập</label>
                            <input type="date" class="form-control" name="dateDevice" id="dateDevice" placeholder="Chọn ngày nhập">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="statusDevice">Tình trạng thiết bị</label>
                            <select class="form-control" name="statusDevice" id="statusDevice">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                            <small class="text-muted">Nếu đang bảo trì thì chọn Đang bảo trì. Nếu đã thanh lý, chọn Đã thanh lý. Ngược lại, chọn các mức tình trạng tự đánh giá.</i></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="useDevice">Tình trạng sử dụng</label>
                            <select class="form-control" name="usingDevice" id="usingDevice">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                            <small class="text-muted">Nếu đang lưu kho thì chọn Đang lưu kho. Nếu đang bảo trì thì chọn Đang bảo trì</i></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="partnerDevice">Nhà sản xuất</label>
                            <select class="form-control" name="partnerDevice" id="partnerDevice">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                            <small class="text-muted">Nếu không rõ nhà sản xuất thì chọn Other</i></small>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="pictureDevice">Hình ảnh</label>
                            <input type="file" class="form-control-file" name="pictureDevice" id="pictureDevice">
                            <small class="text-muted">Ảnh được chọn phải nhỏ hơn 5MB. Định dạng hỗ trợ: jpeg/jpg, png, gif.</small>
                        </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteDevice">Xóa</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button></form>
                </div>
            </div>
        </div>
    </div>

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
    </div> -->

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
        $idImg = $_POST['pictureDevice'];

        // $img = $_FILE['imgDevice'];
        // Xử Lý upload ảnh
        //   if (isset($_FILES['imgDevice'])) {
        //         $dir = 'view/images/';
        //         $name_img = stripslashes($_FILES['imgDevice']['name']);
        //         $source_img = $_FILES['imgDevice']['tmp_name'];
        //         $size_img = $_FILES['imgDevice']['size']; // Dung lượng file
        //
        //         if ($size_img > 5242880){
        //             echo "File không được lớn hơn 5MB";
        //         } else {
        //             // Upload file
        //             $path_img = $dir.$name_img; // Đường dẫn thư mục chứa file
        //             move_uploaded_file($source_img, $path_img); // Upload file
        //             $array = (explode(".",$name_img));
        //             $type_img = $array[1];// Loại file
        //             $url_img = $path_img; // Đường dẫn file
        //
        //             // Thêm dữ liệu vào table
        //             $sql_up_file = "INSERT INTO images VALUES ('','$url_img','$type_img','$size_img','$date_current')";
        //             $db->query($sql_up_file);
        //             }
        //         }
        //
        // $sql_get_img = "SELECT * FROM images ORDER BY idImg DESC";
        // $idImg = $db->num_rows($sql_get_img);
        // $idImg = $idImg + 1;

        if($nameDevice && $dateDevice && $statusDevice && $totalDevice && $producerDevice && $idImg && $currencyDevice && $descriptionDevice)
           {
             $sql="INSERT INTO device_info(idProducer,idImg,nameDevice,status,currency,pricing,total,dateImport,description) VALUES ('$producerDevice','$idImg','$nameDevice','$statusDevice','$currencyDevice',0,'$totalDevice','$dateDevice','$descriptionDevice')";
             $query = $db->query($sql);
             new Redirect($_DOMAIN.'admin/device');
          } else echo '<div class="alert alert-warning">Vui lòng điền đầy đủ thông tin.</div>';
        }
    ?>
