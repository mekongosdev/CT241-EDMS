<a href="<?php echo $_DOMAIN; ?>admin/device" class="buttonFixed adminCP"></a>

<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>

<legend>
    <h1>Danh sách Thiết bị Nhúng</h1></legend>
<?php
  if (isset($_POST['newBorrowDevice'])) {
      $idDevice = $_POST['toIdDevice'];
      $idProject = $_POST['toProject'];
      $total = $_POST['totalBorrow'];
      $user_borrow = $user;//Thanh vien dang dang nhap

      //Get idDevice hien tai va xuat ra idDevice moi nhat
      $qry_get_idBorrowDevice = "SELECT idBorrowDevice FROM borrow_device ORDER BY idBorrowDevice DESC";
      if ($db->num_rows($qry_get_idBorrowDevice)) {
         $idNow = $db->num_rows($qry_get_idBorrowDevice);
         $idNewest = $idNow + 1;
      } else $idNewest = 1;
      //Dem tong so thiet bi
      $qry_total = "SELECT total FROM device_info WHERE idDevice = '$idDevice'";
      foreach ($db->fetch_assoc($qry_total,0) as $key => $result) {
        $totalDevice = $result['total'];
      }
      $totalNow = $totalDevice - $total;
      $qry_totalDevice_now = "UPDATE device_info SET total = '$totalNow' WHERE idDevice = '$idDevice'";//Cap nhat so luong thiet bi
      //Ghi nhan qua trinh muon
      $qry_borrow = "INSERT INTO borrow_device(idDevice,idProject,totalBorrow) VALUES ('$idDevice','$idProject','$total')";
      $qry_borrow_detail = "INSERT INTO borrow_device_detail(idBorrowDevice,idUser,status) VALUES ('$idNewest','$user_borrow',0)";//status = 0 -> waiting accept
      if ($totalDevice > 0) {
          if ($total <= $totalDevice) {
              $db->query($qry_totalDevice_now);
              $db->query($qry_borrow);
              $db->query($qry_borrow_detail);
              new Success($_DOMAIN.'device','Đăng ký mượn thành công');
          } else new Warning($_DOMAIN.'device','Vượt quá số lượng hiện có');
      } else new Warning($_DOMAIN.'device','Không còn thiết bị này để mượn');
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
                        <th>Số lượng hiện tại</th>
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
                      if(isset($_GET['tab']) && (int)$_GET['tab'])
                           $start=($_GET['tab']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
                      else $start=0;
                      $val_device = "SELECT *,DATE_FORMAT( dateImport,  '%d/%m/%Y' ) AS date FROM device_info a,partner_info b WHERE (a.idProducer = b.idProducer) ORDER BY a.idDevice ASC limit $start,$row_per_page";

                      foreach ($db->fetch_assoc($val_device, 0) as $key => $row_device) {
                        echo '<tr>
                            <td>'.$row_device['idDevice'].'</td>
                            <td><img src="';echo $_DOMAIN.$row_device['urlImg']; echo '" style="width:100px;height:100px;"/></td>
                            <td>'.$row_device['nameDevice'].'</td>
                            <td>'.$row_device['description'].'</td>
                            <td>'.$row_device['date'].'</td>
                            <td>'.$row_device['status'].'</td>
                            <td>'.$row_device['total'].'</td>
                            <td>
                                <button type="button" data-id="'.$row_device['idDevice'].'" data-toggle="modal" data-target="#borrowDevice" class="btn btn-primary borrowDevice"><span class="glyphicon glyphicon-bookmark"></span></button>
                            </td>
                        </tr>';
                      }//data-toggle="modal" data-target="#borrowDevice"
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
            'current_page'  => isset($_GET['tab']) ? $_GET['tab'] : 1, // Trang hiện tại
            'total_record'  => $rows, // Tổng số record
            'limit'         => 10,// limit
            'link_full'     => $_DOMAIN.'device/{page}',// Link full có dạng như sau: domain/com/page/{page}
            'link_first'    => $_DOMAIN.'device',// Link trang đầu tiên
            'range'         => 3 // Số button trang bạn muốn hiển thị
        );

        $paging = new Pagination();

        $paging->init($config);

        echo $paging->html();
        ?>
      </div>

    <div id="borrowDevice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Đăng ký mượn thiết bị</h4>
          </div>
          <div class="modal-body edit-content">
              <form class="form-group" action="<?php echo $_DOMAIN; ?>device" method="post">
                <input type="hidden" name="toIdDevice" id="toIdDevice" value=""/>
                  <fieldset class="form-group">
                      <label for="toProject">Cho dự án</label>
                      <select class="form-control" name="toProject" id="toProject">
                        <?php
                            //Chọn dự án
                            $sql_project = "SELECT idProject,nameProject FROM project_info";
                            foreach ($db->fetch_assoc($sql_project,0) as $key => $data) {
                              echo '<option value="'.$data['idProject'].'">'.$data['nameProject'].'</option>
                              ';
                            }
                        ?>
                      </select>
                  </fieldset>
                  <fieldset class="form-group">
                      <label for="totalBorrow">Số lượng mượn</label>
                      <input type="number" class="form-control" name="totalBorrow" id="totalBorrow" placeholder="Nhập số lượng">
                  </fieldset>
          </div>
          <div class="modal-footer">
            <button type="submit" name="newBorrowDevice"class="btn btn-primary">Thêm</button></form>
          </div>
        </div>
      </div>
    </div>

    <script>
    // using latest bootstrap so, show.bs.modal
    $('#borrowDevice').on('show.bs.modal', function(e) {
      var product = $(e.relatedTarget).data('id');
      $("#toIdDevice").val(product);
    });
    </script>
