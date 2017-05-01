<?php // Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap ?>

<h3>Quản lý mượn thiết bị
  <a href="<?php echo $_DOMAIN; ?>admin/borrow" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>
</h3>

<table id="infoBorrow" class="table table-striped">
        <thead>
            <tr>
              <tr>
                  <th>Mã số</th>
                  <th>Họ tên</th>
                  <th>Thiết bị</th>
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
                    <td>'.$row['idBorrowDeviceDetail'].'</td>
                    <td>'.$row['fullName'].'</td>
                    <td>'.$row['nameDevice'].'</td>
                    <td>'.$row['dateBorrow'].'</td>
                    <td>'.$row['dateReturn'].'</td>
                    <td>
                        <button type="button" id="editLab" class="btn btn-primary" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowAccept"><span class="glyphicon glyphicon-ok"></span></button>
                        <button type="button" id="delLab" class="btn btn-info" data-id="'.$row['idBorrowDeviceDetail'].'" data-toggle="modal" data-target="#borrowReturn"><span class="glyphicon glyphicon-repeat"></span></button>
                    </td>
                </tr>';
              }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có yêu cầu mượn nào.</div>';
          }
          ?>
        </tbody>
    </table>

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

<!-- <table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Họ tên</th>
                <th>Thiết bị</th>
                <th>Ngày mượn</th>
                <th>Ngày trả</th>
                <th>Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>001</td>
                <td>Lê Minh Luân</td>
                <td>Relay 4 kênh</td>
                <td>20/03/2017</td>
                <td>24/03/2017</td>
                <td>---</td>
            </tr>
            <tr>
                <td>002</td>
                <td>Huỳnh Quang Nghi</td>
                <td>Arduino UNO R3</td>
                <td>20/03/2017</td>
                <td>---</td>
                <td>
                  <button type="button" id="ok" class="btn btn-primary"><span class="glyphicon glyphicon-repeatrefresh"></span></button>
                </td>
            </tr>
            <tr>
                <td>003</td>
                <td>Trương Minh Thái</td>
                <td>ESP8266</td>
                <td>---</td>
                <td>---</td>
                <td>
                  <button type="button" id="ok" class="btn btn-primary" data-toggle="modal" data-target="#requestDevice"><span class="glyphicon glyphicon-refresh"></span></button>
                </td>
            </tr>
            <tr>
                <td>004</td>
                <td>Trần Văn Hoàng</td>
                <td>Sensor hồng ngoại</td>
                <td>20/03/2017</td>
                <td>24/03/2017</td>
                <td>---</td>
            </tr>
        </tbody>
    </table> -->

<!--Modal phân quyền-->
<div id="requestDevice" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">Yêu cầu mượn</h4>
            </div>
            <div class="modal-body">
                <h4>Cho phép mượn thiết bị?</h4>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Yes</a></form>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
