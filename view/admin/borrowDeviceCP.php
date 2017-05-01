<?php // Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap

//Giới hạn thời gian mượn thiết bị
// echo (day_limit($date_before,$date_current,12) == 1) ? 'OK' : 'Timeout';

?>


<h3>Quản lý mượn thiết bị</h3>
<form action="<?php echo $_DOMAIN; ?>admin/borrow" method="POST">
  <a href="<?php echo $_DOMAIN; ?>admin/borrow" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>
  <button class="btn btn-primary" name="requestOKBtn" type="submit"><span class="glyphicon glyphicon-ok"></span> Xác nhận mượn</button>
  <button class="btn btn-danger" name="requestCancelBtn" type="submit"><span class="glyphicon glyphicon-remove"></span> Từ chối mượn</button>
  <button class="btn btn-info" name="returnOKBtn" type="submit"><span class="glyphicon glyphicon-repeat"></span> Trả thiết bị</button>
  <button class="btn btn-warning" name="refreshOKBtn" type="submit"><span class="glyphicon glyphicon-refresh"></span> Gia hạn mượn</button>

<h2>  </h2>

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
              // var_dump($start);
              $val = "SELECT *,DATE_FORMAT( dateBorrow,  '%d/%m/%Y' ) AS dateBorrow,DATE_FORMAT( dateReturn,  '%d/%m/%Y' ) AS dateReturn FROM borrow_device_detail a,borrow_device b,user_info c,device_info d WHERE (a.idBorrowDevice = b.idBorrowDevice)  AND (a.idUser = c.idUser) AND (b.idDevice = d.idDevice) ORDER BY idBorrowDeviceDetail DESC limit $start,$row_per_page";

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td><input type="radio" name="idBorrow" value="' . $row['idBorrowDeviceDetail'] .'"></td>
                    <td>'.$row['idBorrowDeviceDetail'].'</td>
                    <td>'.$row['fullName'].'</td>
                    <td>'.$row['nameDevice'].'</td>
                    <td>'.$row['totalBorrow'].'</td>
                    <td>'.$row['dateBorrow'].'</td>
                    <td>'.$row['dateReturn'].'</td>
                    <td>
                        <button type="button" id="thisrequestDevice" class="btn btn-primary" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#requestDevice"><span class="glyphicon glyphicon-ok"></span></button>
                        <button type="button" id="thisborrowReturn" class="btn btn-info" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowReturn"><span class="glyphicon glyphicon-repeat"></span></button>
                        <button type="button" id="thisborrowRefresh" class="btn btn-warning" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowRefresh"><span class="glyphicon glyphicon-refresh"></span></button>
                    </td>
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
    'link_full'     => $_DOMAIN.'admin/borrow/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/borrow',// Link trang đầu tiên
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
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>admin/borrow" method="post">
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
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>admin/borrow" method="post">
                <input type="hidden" name="toReturnDevice" id="toReturnDevice" value=""/>
                <button type="submit" name="returnOK" class="btn btn-primary">Đồng ý</button></form>
            </div>
        </div>
    </div>
</div>

<!--Modal gian hạn mượn thiết bị-->
<div id="borrowRefresh" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Gia hạn mượn thiết bị</h4>
            </div>
            <div class="modal-footer"><form action="<?php echo $_DOMAIN; ?>admin/borrow" method="post">
                <input type="hidden" name="toRefreshDevice" id="toRefreshDevice" value=""/>
                <button type="submit" name="refreshOK" class="btn btn-primary">Đồng ý</button></form>
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
</script>

<?php
//Xử lý mượn thiết bị
//Đồng ý
if (isset($_POST['requestOK'])) {
  $request = $_POST['toRequestDevice'];

  $sql_request = "UPDATE borrow_device_detail SET status = 1, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$request'";//status = 1 -> Accept
  $db->query($sql_request);
  new Success($_DOMAIN.'admin/borrow');
}
if (isset($_POST['requestOKBtn'])) {
  $request = $_POST['idBorrow'];

  $sql_request = "UPDATE borrow_device_detail SET status = 1, dateBorrow = '$date_current' WHERE idBorrowDeviceDetail = '$request'";//status = 1 -> Accept
  $db->query($sql_request);
  new Success($_DOMAIN.'admin/borrow');
}

//Từ chối
if (isset($_POST['requestCancel'])) {
  $request = $_POST['toRequestDevice'];

  $sql_request = "UPDATE borrow_device_detail SET status = 2, dateBorrow = 'yyyy-mm-dd hh:mm:ss', dateReturn = 'yyyy-mm-dd hh:mm:ss' WHERE idBorrowDeviceDetail = '$request'";//status = 2 -> Cancel
  $db->query($sql_request);
  new Danger($_DOMAIN.'admin/borrow','Từ chối thành công');
}
if (isset($_POST['requestCancelBtn'])) {
  $request = $_POST['idBorrow'];

  $sql_request = "UPDATE borrow_device_detail SET status = 2, dateBorrow = 'yyyy-mm-dd hh:mm:ss', dateReturn = 'yyyy-mm-dd hh:mm:ss' WHERE idBorrowDeviceDetail = '$request'";//status = 2 -> Cancel
  $db->query($sql_request);
  new Danger($_DOMAIN.'admin/borrow','Từ chối thành công');
}

//Xử lý trả thiết bị
// if (isset($_POST['returnOK'])) {
//   $return = $_POST['toReturnDevice'];
//
// }
// if (isset($_POST['returnOKBtn'])) {
//   $return = $_POST['idBorrow'];
//
// }

//Xử lý trả thiết bị
// if (isset($_POST['refreshOK'])) {
//   $refresh = $_POST['toRefreshDevice'];
//
// }
// if (isset($_POST['refreshOKBtn'])) {
//   $refresh = $_POST['idBorrow'];
//
// }

?>
