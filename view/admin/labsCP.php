<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addProject"></a>

<?php

// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap?>

<h3>Quản lý Labs</h3>
  <button class="btn btn-success" data-toggle="modal" data-target="#addProject">Thêm Lab mới</button>
  <a href="<?php echo $_DOMAIN; ?>admin/labs" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>

<table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Tên Lab</th>
                <th>Đơn vị</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Google Map</th>
                <th>Quản lý</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $sql_get_user = "SELECT * FROM lab_info ORDER BY idLab DESC";
          if ($db->num_rows($sql_get_user)) {
              $row="SELECT idLab FROM lab_info";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['page']) && (int)$_GET['page'])
                   $start=($_GET['page']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              // var_dump($start);
              $val = "SELECT * FROM lab_info ORDER BY idLab ASC limit $start,$row_per_page";

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idLab'].'</td>
                    <td><a href="'.$_DOMAIN.'labs/info/'.$row['idLab'].'">'.$row['nameLab'].'</a></td>
                    <td>'.$row['unit'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['address'].'</td>
                    <td><a href="'.$row['location'].'">'.$row['location'].'</a></td>
                    <td>
                        <button type="button" id="editLab" class="btn btn-primary" data-id="'.$row['idLab'].'" data-name="'.$row['nameLab'].'" data-unit="'.$row['unit'].'" data-phone="'.$row['phone'].'" data-address="'.$row['address'].'" data-location="'.$row['location'].'" data-toggle="modal" data-target="#editThisLab"><span class="glyphicon glyphicon-pencil"></span></button>
                        <button type="button" id="delLab" class="btn btn-danger" data-id="'.$row['idLab'].'" data-toggle="modal" data-target="#deleteLab"><span class="glyphicon glyphicon-trash"></span></button>
                    </td>
                </tr>';
              }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có Lab nào.</div>';
          }
          ?>
        </tbody>
    </table>

    <div class="container">
<?php
$row="SELECT idLab FROM lab_info";
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

    <!-- Thêm Lab -->
    <div id="addProject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thêm Lab</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/labs" method="post">
                      <fieldset class="form-group">
                          <label for="labName">Tên Lab</label>
                          <input type="text" class="form-control" name="labName" id="labName" placeholder="Nhập tên Lab">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labUnit">Đơn vị</label>
                          <input type="text" class="form-control" name="labUnit" id="labUnit" placeholder="Nhập tên đơn vị">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labPhone">Điện thoại</label>
                          <input type="text" class="form-control" name="labPhone" id="labPhone" placeholder="Nhập số điện thoại">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labAddress">Địa chỉ</label>
                          <input type="text" class="form-control" name="labAddress" id="labAddress" placeholder="Nhập địa chỉ">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labMap">URL Google Map</label>
                          <input type="text" class="form-control" name="labMap" id="labMap" placeholder="Nhập địa chỉ URL từ Google Map">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="addNewLab"class="btn btn-primary">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

    <!-- Chỉnh sửa Lab -->
    <div id="editThisLab" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Chỉnh sửa Lab</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/labs" method="post">
                      <input type="hidden" name="toEditLab" id="toEditLab" value=""/>
                      <fieldset class="form-group">
                          <label for="labName">Tên Lab</label>
                          <input type="text" class="form-control" name="labName" id="thislabName" value="" placeholder="Nhập tên Lab">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labUnit">Đơn vị</label>
                          <input type="text" class="form-control" name="labUnit" id="thislabUnit" value="" placeholder="Nhập tên đơn vị">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labPhone">Điện thoại</label>
                          <input type="text" class="form-control" name="labPhone" id="thislabPhone" value="" placeholder="Nhập số điện thoại">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labAddress">Địa chỉ</label>
                          <input type="text" class="form-control" name="labAddress" id="thislabAddress" value="" placeholder="Nhập địa chỉ">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="labMap">URL Google Map</label>
                          <input type="text" class="form-control" name="labMap" id="thislabMap" value="" placeholder="Nhập địa chỉ URL từ Google Map">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="editInfoLab"class="btn btn-primary">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

    <!-- Xóa Lab -->
    <div id="deleteLab" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Xóa thành viên!</h4>
                </div>
                <div class="modal-body">
                  <center>
                    <h4>Hành động này cần xác nhận: Không thể hoàn tác!</h4>
                    <p>Vui lòng kiểm tra cẩn thận!</p>
                  </center>
                    <form action="<?php echo $_DOMAIN; ?>admin/labs" method="post">
                        <div class="modal-footer">
                            <input type="hidden" name="toDelLab" id="toDelLab" value=""/>
                            <button type="submit" name="delLab" class="btn btn-danger">Đồng ý</button></form>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Không</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Function -->
    <script language="JavaScript">
    // using latest bootstrap so, show.bs.modal
    //editMember
    $('#editThisLab').on('show.bs.modal', function(e) {
      var id = $(e.relatedTarget).data('id');
      $("#toEditLab").val(id);
      var name = $(e.relatedTarget).data('name');
      $("#thislabName").val(name);
      var unit = $(e.relatedTarget).data('unit');
      $("#thislabUnit").val(unit);
      var phone = $(e.relatedTarget).data('phone');
      $("#thislabPhone").val(phone);
      var address = $(e.relatedTarget).data('address');
      $("#thislabAddress").val(address);
      var location = $(e.relatedTarget).data('location');
      $("#thislabMap").val(location);
    });
    //delMember
    $('#deleteLab').on('show.bs.modal', function(e) {
      var product = $(e.relatedTarget).data('id');
      $("#toDelLab").val(product);
    });
    </script>

<?php
//Thêm lab
  if(isset($_POST['addNewLab'])){
    $labName = addslashes($_POST['labName']);
    $labUnit = addslashes($_POST['labUnit']);
    $labPhone = addslashes($_POST['labPhone']);
    $labAddress = addslashes($_POST['labAddress']);
    $labMap = addslashes($_POST['labMap']);

    if($labName && $labUnit && $labPhone && $labAddress)
       {
         $sql="INSERT INTO lab_info(nameLab,unit,phone,address,location) VALUES ('$labName','$labUnit','$labPhone','$labAddress','$labMap')";
         $query = $db->query($sql);
         new Redirect($_DOMAIN.'admin/labs');
      } else echo '<div class="alert alert-warning">Vui lòng điền đầy đủ thông tin.</div>';
    }
    //Xử lý sửa thông tin Lab
    if (isset($_POST['editInfoLab'])) {
      $idLab = $_POST['toEditLab'];
      $name = $_POST['labName'];
      $unit = $_POST['labUnit'];
      $phone = $_POST['labPhone'];
      $address = $_POST['labAddress'];
      $location = $_POST['labMap'];

      if ($name && $unit && $phone && $address) {
          $sql_edit_lab = "UPDATE lab_info SET nameLab = '$name',unit = '$unit',phone = '$phone',address = '$address',location = '$location' WHERE idLab = '$idLab'";
          $db->query($sql_edit_lab);
          new Success($_DOMAIN.'admin/labs/');
      } else new Warning($_DOMAIN.'admin/labs','Vui lòng điền đầy đủ thông tin');
    }

    //Xử lý xóa Lab
    if (isset($_POST['delLab'])) {
      $idLab = $_POST['toDelLab'];

      $sql_del_lab = "DELETE FROM lab_info WHERE idLab = '$idLab'";
      $db->query($sql_del_lab);
      new Success($_DOMAIN.'admin/labs/');
    }
?>
