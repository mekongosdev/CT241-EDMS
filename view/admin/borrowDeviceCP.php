<?php // Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);
//Giới hạn thời gian mượn thiết bị
// echo (day_limit($date_before,$date_current,12) == 1) ? 'OK' : 'Timeout';

?>


<h3>Quản lý mượn thiết bị</h3>
<form action="<?php echo $_DOMAIN; ?>admin/borrowDeviceCP" method="POST">
  <a href="<?php echo $_DOMAIN; ?>admin/borrowDeviceCP" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>
  <button class="btn btn-primary" name="requestOKBtn" type="submit"><span class="glyphicon glyphicon-ok"></span> Xác nhận mượn</button>
  <button class="btn btn-danger" name="requestCancelBtn" type="submit"><span class="glyphicon glyphicon-remove"></span> Từ chối mượn</button>
  <button class="btn btn-info" name="returnOKBtn" type="submit"><span class="glyphicon glyphicon-repeat"></span> Trả thiết bị</button>
  <button class="btn btn-warning" name="refreshOKBtn" type="submit"><span class="glyphicon glyphicon-refresh"></span> Gửi yêu cầu gia hạn</button>
  <button class="btn btn-success" name="restRefreshOKBtn" type="submit"><span class="glyphicon glyphicon-refresh"></span> Gia hạn mượn</button>
  <button class="btn btn-danger" name="trashOKBtn" type="submit"><span class="glyphicon glyphicon-trash"></span> Xóa yêu cầu</button>

<table id="infoBorrow" class="table table-striped">
        <thead>
            <tr>
              <tr>
                  <th>--</th>
                  <th>Mã số</th>
                  <th>Họ tên</th>
                  <th>Thiết bị</th>
                  <th>Số lượng</th>
                  <th>Ngày mượn</th>
                  <th>Ngày trả</th>
                  <th>Quản lý</th>
              </tr>
            </tr>
        </thead>
        <tbody>

<?php

//Xử lý mượn thiết bị
//Đồng ý
if (isset($_POST['requestOK'])) {
  $request = $_POST['toRequestDevice'];

  $sql_request = "UPDATE borrow_device_detail SET statusBorrow = 2, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$request'";//status = 2 -> Accept
  //GET thiết bị từ bảng mượn
  $get_device = "SELECT * FROM device_info INNER JOIN borrow_device ON device_info.idDevice = borrow_device.idDevice WHERE borrow_device.idBorrowDevice = '$request'";
  foreach ($db->fetch_assoc($get_device,0) as $key => $get_result) {
    $totalDevice = $get_result['total'];
    $idDevice = $get_result['idDevice'];
  }

  //Dem tong so thiet bi
  $qry_totalBorrow = "SELECT totalBorrow FROM borrow_device WHERE idBorrowDevice = '$request'";
  foreach ($db->fetch_assoc($qry_totalBorrow,1) as $key => $result) {
    $totalBorrow = $result;
  }
  $totalNow = $totalDevice - $totalBorrow;
  $qry_totalDevice_now = "UPDATE device_info SET total = '$totalNow' WHERE idDevice = '$idDevice'";//Cap nhat so luong thiet bi
  if ($totalDevice > 0) {
    if ($request) {
      $db->query($sql_request);
      $db->query($qry_totalDevice_now);
    }
    new Success($_DOMAIN.'admin/borrowDeviceCP');
  } else {
    $sql_request = "UPDATE borrow_device_detail SET statusBorrow = 0, dateBorrow = '$date_current', dateReturn = '$date_current' WHERE idBorrowDeviceDetail = '$request'";//status = 0 -> Cancel
    $db->query($sql_request);
    new Danger('','Không còn thiết bị này nữa, đồng ý thất bại!');
  }
}
if (isset($_POST['requestOKBtn'])) {
  $request = $_POST['idBorrow'];

  foreach ($request as $key => $data) {
    $sql_request = "UPDATE borrow_device_detail SET statusBorrow = 2, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$data'";//status = 2 -> Accept

    //GET thiết bị từ bảng mượn
    $get_device = "SELECT * FROM device_info INNER JOIN borrow_device ON device_info.idDevice = borrow_device.idDevice WHERE borrow_device.idBorrowDevice = '$data'";
    foreach ($db->fetch_assoc($get_device,0) as $key => $get_result) {
      $totalDevice = $get_result['total'];
      $idDevice = $get_result['idDevice'];
    }

    //Dem tong so thiet bi
    $qry_totalBorrow = "SELECT totalBorrow FROM borrow_device WHERE idBorrowDevice = '$data'";
    foreach ($db->fetch_assoc($qry_totalBorrow,1) as $key => $result) {
      $totalBorrow = $result;
    }
    $totalNow = $totalDevice - $totalBorrow;
    $qry_totalDevice_now = "UPDATE device_info SET total = '$totalNow' WHERE idDevice = '$idDevice'";//Cap nhat so luong thiet bi
    if ($totalDevice > 0) {
      if ($request) {
        $db->query($sql_request);
        $db->query($qry_totalDevice_now);
      }
      new Success($_DOMAIN.'admin/borrowDeviceCP');
    } else {
      $sql_request = "UPDATE borrow_device_detail SET statusBorrow = 0, dateBorrow = '$date_current', dateReturn = '$date_current' WHERE idBorrowDeviceDetail = '$data'";//status = 0 -> Cancel
      $db->query($sql_request);
      new Danger('','Không còn thiết bị này nữa, đồng ý thất bại!');
    }
  }
}

//Từ chối
if (isset($_POST['requestCancel'])) {
  $request = $_POST['toRequestDevice'];

  $sql_request = "UPDATE borrow_device_detail SET statusBorrow = 0, dateBorrow = '$date_current', dateReturn = '$date_current' WHERE idBorrowDeviceDetail = '$request'";//status = 0 -> Cancel
  $db->query($sql_request);
  new Danger($_DOMAIN.'admin/borrowDeviceCP','Từ chối thành công');
}
if (isset($_POST['requestCancelBtn'])) {
  $request = $_POST['idBorrow'];

  foreach ($request as $key => $data) {
    $sql_request = "UPDATE borrow_device_detail SET statusBorrow = 0, dateBorrow = '$date_current', dateReturn = '$date_current' WHERE idBorrowDeviceDetail = '$data'";//status = 0 -> Cancel
    $db->query($sql_request);
  }
  new Danger($_DOMAIN.'admin/borrowDeviceCP','Từ chối thành công');
}

//Xử lý trả thiết bị
if (isset($_POST['returnOK'])) {
  $return = $_POST['toReturnDevice'];

  $sql_return = "UPDATE borrow_device_detail SET statusBorrow = 1, dateReturn = '$date_current' WHERE idBorrowDeviceDetail = '$return'";//status = 1 -> Returned

  //GET thiết bị từ bảng mượn
  $get_device = "SELECT * FROM device_info INNER JOIN borrow_device ON device_info.idDevice = borrow_device.idDevice WHERE borrow_device.idBorrowDevice = '$return'";
  foreach ($db->fetch_assoc($get_device,0) as $key => $get_result) {
    $totalDevice = $get_result['total'];
    $idDevice = $get_result['idDevice'];
  }

  //Dem tong so thiet bi đang mượn
  $qry_totalBorrow = "SELECT totalBorrow FROM borrow_device WHERE idBorrowDevice = '$return'";
  foreach ($db->fetch_assoc($qry_totalBorrow,1) as $key => $result) {
    $totalBorrow_return = $result;
  }
  $totalNow = $totalDevice + $totalBorrow_return;
  $qry_totalDevice_now = "UPDATE device_info SET total = '$totalNow' WHERE idDevice = '$idDevice'";//Cap nhat so luong thiet bi
  if ($return) {
    $db->query($sql_return);
    $db->query($qry_totalDevice_now);
  }
  new Success($_DOMAIN.'admin/borrowDeviceCP');
}
if (isset($_POST['returnOKBtn'])) {
  $return = $_POST['idBorrow'];

  foreach ($return as $key => $data) {
    $sql_return = "UPDATE borrow_device_detail SET statusBorrow = 1, dateReturn = '$date_current' WHERE idBorrowDeviceDetail = '$data'";//status = 1 -> Returned

    //GET thiết bị từ bảng mượn
    $get_device = "SELECT * FROM device_info INNER JOIN borrow_device ON device_info.idDevice = borrow_device.idDevice WHERE borrow_device.idBorrowDevice = '$data'";
    foreach ($db->fetch_assoc($get_device,0) as $key => $get_result) {
      $totalDevice = $get_result['total'];
      $idDevice = $get_result['idDevice'];
    }

    //Dem tong so thiet bi đang mượn
    $qry_totalBorrow = "SELECT totalBorrow FROM borrow_device WHERE idBorrowDevice = '$data'";
    foreach ($db->fetch_assoc($qry_totalBorrow,1) as $key => $result) {
      $totalBorrow_return = $result;
    }
    $totalNow = $totalDevice + $totalBorrow_return;
    $qry_totalDevice_now = "UPDATE device_info SET total = '$totalNow' WHERE idDevice = '$idDevice'";//Cap nhat so luong thiet bi
    if ($return) {
      $db->query($sql_return);
      $db->query($qry_totalDevice_now);
    }
  }
  new Success($_DOMAIN.'admin/borrowDeviceCP');
}

//Xử lý gia hạn thiết bị
if (isset($_POST['refreshOK'])) {
  $refresh = $_POST['toRefreshDevice'];

  $sql_refresh = "UPDATE borrow_device_detail SET statusBorrow = 3, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$refresh'";//status = 2 -> Accept
  if ($refresh) {
    $db->query($sql_refresh);
  }
  new Success($_DOMAIN.'admin/borrowDeviceCP');
}
if (isset($_POST['refreshOKBtn'])) {
  $refresh = $_POST['idBorrow'];

  foreach ($refresh as $key => $data) {
    $sql_refresh = "UPDATE borrow_device_detail SET statusBorrow = 3, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$data'";//status = 2 -> Accept
    if ($refresh) {
      $db->query($sql_refresh);
    }
  }
  new Success($_DOMAIN.'admin/borrowDeviceCP');
}

//Xử lý yêu cầu gia hạn thiết bị
if (isset($_POST['restRefreshOK'])) {
  $rest = $_POST['toRestRefreshDevice'];

  $sql_rest_refresh = "UPDATE borrow_device_detail SET statusBorrow = 3, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$rest'";//status = 5 -> Rest
  if ($rest) {
    $db->query($sql_rest_refresh);
  }
  new Success($_DOMAIN.'admin/borrowDeviceCP');
}
if (isset($_POST['restRefreshOKBtn'])) {
  $rest = $_POST['idBorrow'];

  foreach ($rest as $key => $data) {
    $sql_rest_refresh = "UPDATE borrow_device_detail SET statusBorrow = 3, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$data'";//status = 5 -> Rest
    if ($rest) {
      $db->query($sql_rest_refresh);
    }
  }
  new Success($_DOMAIN.'admin/borrowDeviceCP');
}

//Update người mượn quá hạn
///Khai báo các giá trị limit
$date_before = '';
$date_after = $date_current;
$limit = $limitBorrow;
$sql_borrow_out_of_date = "SELECT * FROM borrow_device_detail WHERE statusBorrow = 2";
if ($db->num_rows($sql_borrow_out_of_date)){
  foreach ($db->fetch_assoc($sql_borrow_out_of_date,0) as $key => $date) {
    $date_before = $date['dateBorrow'];
    $idBorrowDeviceDetail = $date['idBorrowDeviceDetail'];
    if (day_limit($date_before,$date_after,$limit) == 0) {
      $sql_update_status = "UPDATE borrow_device_detail SET statusBorrow = 4 WHERE idBorrowDeviceDetail = '$idBorrowDeviceDetail'";
      $db->query($sql_update_status);
    }
  }
}


//Xử lý xóa yêu cầu mượn thiết bị
if (isset($_POST['trashOKBtn'])) {
  $trash = $_POST['idBorrow'];

  foreach ($trash as $key => $data) {
    $sql_del_request = "DELETE FROM borrow_device_detail WHERE idBorrowDeviceDetail = '$data'";
    $db->query($sql_del_request);
  }
  new Success($_DOMAIN.'admin/borrowDeviceCP');
}

?>


          <?php
          $sql_get_borrow = "SELECT * FROM borrow_device_detail ORDER BY idBorrowDeviceDetail DESC";
          if ($db->num_rows($sql_get_borrow)) {
              $row="SELECT idBorrowDeviceDetail FROM borrow_device_detail";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['act']) && (int)$_GET['act'])
                   $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;

              //SQL get page
              $val_page = "SELECT * FROM borrow_device_detail a,borrow_device b,user_info c,device_info d WHERE (a.idBorrowDeviceDetail = b.idBorrowDevice)  AND (a.idUser = c.idUser) AND (b.idDevice = d.idDevice) ORDER BY statusBorrow DESC limit $start,$row_per_page";

              //Hiển thị danh sách quản lý mượn thiết bị
                foreach ($db->fetch_assoc($val_page, 0) as $key => $row) {
                  $get_status = $row['statusBorrow'];
                  // echo $get_status.' ';Test biến get status
                  echo '<tr'; if ($get_status == 0) {
                    echo ' class="alert alert-danger"';
                  } else if ($get_status == 4 || $get_status == 5) {
                    echo ' class="alert alert-warning"';
                  }
                  echo '>
                      <td>'; if ($get_status == 2 || $get_status == 3 || $get_status == 4 || $get_status == 5) {
                        echo '<input type="checkbox" name="idBorrow[]" value="' . $row['idBorrowDeviceDetail'] .'">';
                      } echo '</td>
                      <td>'.$row['idBorrowDeviceDetail'].'</td>
                      <td>'.$row['fullName'].'</td>
                      <td>'.$row['nameDevice'].'</td>
                      <td>'.$row['totalBorrow'].'</td>';
                      if ($get_status == 2) { echo '
                      <td>'.$row['dateBorrow'].'</td>
                      <td>'.$row['dateReturn'].'</td>
                      <td>
                          <button type="button" id="thisborrowReturn" class="btn btn-info" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowReturn"><span class="glyphicon glyphicon-repeat"></span></button>
                      </td>';
                    } else if ($get_status == 3) { echo '
                    <td>Chờ duyệt</td>
                    <td>'.$row['dateReturn'].'</td>
                    <td>
                        <button type="button" id="thisrequestDevice" class="btn btn-primary" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#requestDevice"><span class="glyphicon glyphicon-ok"></span></button>
                    </td>';
                  } else if ($get_status == 0) {
                      echo '<td>Đã từ chối</td><td> </td><td> </td>';
                    } else if ($get_status == 1) { echo '
                      <td>'.$row['dateBorrow'].'</td>
                      <td>'.$row['dateReturn'].'</td>
                      <td> </td>';
                    } else if ($get_status == 4) { echo '
                      <td>'.$row['dateBorrow'].'</td>
                      <td>Đã quá hạn</td>
                      <td>
                          <button type="button" id="thisborrowReturn" class="btn btn-info" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowReturn"><span class="glyphicon glyphicon-repeat"></span></button>
                          <button type="button" id="thisRestRefresh" class="btn btn-warning" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#restRefresh"><span class="glyphicon glyphicon-refresh"></span></button>
                      </td>';
                    } else if ($get_status == 5) { echo '
                      <td>'.$row['dateBorrow'].'</td>
                      <td>Đã quá hạn</td>
                      <td>
                          <button type="button" id="thisborrowReturn" class="btn btn-info" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowReturn"><span class="glyphicon glyphicon-repeat"></span></button>
                          <button type="button" id="thisborrowRefresh" class="btn btn-success" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowRefresh"><span class="glyphicon glyphicon-refresh"></span></button>
                      </td>';
                    }
                      echo '
                  </tr>';
                }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có yêu cầu mượn nào.</div>';
          }
          ?>
        </tbody>
    </table>
</form>
    <div class="container">
<?php
$row="SELECT idBorrowDeviceDetail FROM borrow_device_detail";
$rows=$db->num_rows($row);
$config = array(
    'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => $_DOMAIN.'admin/borrowDeviceCP/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/borrowDeviceCP',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
</div>

<!--Modal mượn thiết bị-->
<div id="requestDevice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Yêu cầu mượn</h4>
            </div>
            <div class="modal-body">
              <center>
                <h4><strong>Cho phép mượn thiết bị?</strong></h4>
              </center>
            </div>
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>admin/borrowDeviceCP" method="post">
                <input type="hidden" name="toRequestDevice" id="toRequestDevice" value=""/>
                <button type="submit" name="requestOK" class="btn btn-primary">Đồng ý</button>
                <button type="submit" name="requestCancel" class="btn btn-danger">Từ chối</button></form>
            </div>
        </div>
    </div>
</div>

<!--Modal trả thiết bị-->
<div id="borrowReturn" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Xác nhận trả thiết bị</h4>
            </div>
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>admin/borrowDeviceCP" method="post">
                <input type="hidden" name="toReturnDevice" id="toReturnDevice" value=""/>
                <button type="submit" name="returnOK" class="btn btn-primary">Đồng ý</button></form>
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
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>admin/borrowDeviceCP" method="post">
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
                <h4 class="modal-title">Đồng ý gửi yêu cầu gia mượn thiết bị</h4>
            </div>
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>admin/borrowDeviceCP" method="post">
                <input type="hidden" name="toRestRefreshDevice" id="toRestRefreshDevice" value=""/>
                <button type="submit" name="restRefreshOK" class="btn btn-primary">Đồng ý</button></form>
            </div>
        </div>
    </div>
</div>

<!-- JS Function -->
<script language="JavaScript">
// using latest bootstrap so, show.bs.modal
$('#requestDevice').on('show.bs.modal', function(e) {
  var id = $(e.relatedTarget).data('id');
  $("#toRequestDevice").val(id);
});

$('#borrowReturn').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toReturnDevice").val(product);
});

$('#borrowRefresh').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toRefreshDevice").val(product);
});

$('#restRefresh').on('show.bs.modal', function(e) {
  var product = $(e.relatedTarget).data('id');
  $("#toRestRefreshDevice").val(product);
});
</script>
