<?php // Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);?>

<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addProducer"></a>

<h3>Quản lý nhà cung cấp/sản xuất</h3>
  <button class="btn btn-success" data-toggle="modal" data-target="#addProducer">Thêm nhà cung cấp/sản xuất</button>
  <a href="<?php echo $_DOMAIN; ?>admin/producerCP" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>

  <?php
  //Thêm nhà cung cấp
    if(isset($_POST['add_Producer'])){
      $producerName = addslashes($_POST['producerName']);
      $serviceProducer = addslashes($_POST['serviceProducer']);
      $phoneProducer = $_POST['phoneProducer'];
      $addressProducer = addslashes($_POST['addressProducer']);
      $mailProducer = addslashes($_POST['mailProducer']);
      if($producerName && $serviceProducer && $phoneProducer && $addressProducer && $mailProducer)
         {
           $sql="INSERT INTO partner_info(nameProducer, service, address, phone, email) VALUES ('{$producerName}', '{$serviceProducer}', '{$addressProducer}', '{$phoneProducer}', '{$mailProducer}')";
           $query = $db->query($sql);
           new Success($_DOMAIN.'admin/producerCP/');
       } else new Warning($_DOMAIN.'admin/producerCP','Vui lòng điền đầy đủ thông tin');
      }
      //Xử lý sửa thông tin nhà cung cấp
      if (isset($_POST['editProducer'])) {
        $idProducer = $_POST['toEditProducer'];
        $name = $_POST['producerName'];
        $service = $_POST['serviceProducer'];
        $phone = $_POST['phoneProducer'];
        $address = $_POST['addressProducer'];
        $mail = $_POST['mailProducer'];

        if ($name && $service && $phone && $address && $mail) {
            $sql_edit_producer = "UPDATE partner_info SET nameProducer = '$name',service = '$service',address = '$address',phone = '$phone',email = '$mail' WHERE idProducer = '$idProducer'";
            $db->query($sql_edit_producer);
            new Success($_DOMAIN.'admin/producerCP/');
        } else new Warning($_DOMAIN.'admin/producerCP','Vui lòng điền đầy đủ thông tin');
      }

      //Xử lý xóa nhà cung cấp
      if (isset($_POST['delProducer'])) {
        $idProducer = $_POST['toDelProducer'];

        $sql_del_producer = "DELETE FROM partner_info WHERE idProducer = '$idProducer'";
        $db->query($sql_del_producer);
        new Success($_DOMAIN.'admin/producerCP/');
      }
  ?>

<table id="infoProducer" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Nhà cung cấp/sản xuất</th>
                <th>Dịch vụ</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Quản lý</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $sql_get_producer = "SELECT * FROM partner_info ORDER BY idProducer DESC";
          if ($db->num_rows($sql_get_producer)) {
              $row="SELECT idProducer FROM partner_info";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['act']) && (int)$_GET['act'])
                   $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
          $val_producer = "SELECT * FROM partner_info limit $start,$row_per_page";

          foreach ($db->fetch_assoc($val_producer, 0) as $key => $row) {
            echo '<tr>
                <td>'.$row['idProducer'].'</td>
                <td>'.$row['nameProducer'].'</td>
                <td>'.$row['service'].'</td>
                <td><a href="tel:'.$row['phone'].'">'.$row['phone'].'</a></td>
                <td><a href="mailto:'.$row['email'].'">'.$row['email'].'</a></td>
                <td>
                    <button type="button" id="thiseditProducer" class="btn btn-primary" data-id="'.$row['idProducer'].'" data-name="'.$row['nameProducer'].'" data-service="'.$row['service'].'" data-phone="'.$row['phone'].'" data-address="'.$row['address'].'" data-mail="'.$row['email'].'" data-toggle="modal" data-target="#editProducer"><span class="glyphicon glyphicon-pencil"></span></button>
                    <button type="button" id="thisdelProducer" class="btn btn-danger" data-id="'.$row['idProducer'].'" data-toggle="modal" data-target="#delProducer"><span class="glyphicon glyphicon-trash"></span></button>
                </td>
            </tr>';
          }
        } else {
            echo '<br><br><div class="alert alert-info">Chưa có nhà cung cấp/sản xuất nào.</div>';
        }
          ?>
        </tbody>
    </table>

<div class="container">
<?php
$row="SELECT idProducer FROM partner_info";
$rows=$db->num_rows($row);
$config = array(
    'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => $_DOMAIN.'admin/producerCP/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/producerCP',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
</div>

    <!-- Thêm đối tác -->
    <div id="addProducer" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Thêm nhà cung cấp/sản xuất</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/producerCP" method="post">
                      <fieldset class="form-group">
                          <label for="producerName">Tên đối tác</label>
                          <input type="text" class="form-control" name="producerName" id="producerName" placeholder="Nhập tên đối tác">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="serviceProducer">Dịch vụ</label>
                          <input type="text" class="form-control" name="serviceProducer" id="serviceProducer" placeholder="Loại dịch vụ cung cấp?">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="phoneProducer">Điện thoại</label>
                          <input type="number" class="form-control" name="phoneProducer" id="phoneProducer" placeholder="Nhập số điện thoại">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="addressProducer">Địa chỉ</label>
                          <input type="text" class="form-control" name="addressProducer" id="addressProducer" placeholder="Nhập địa chỉ">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="mailProducer">Email</label>
                          <input type="mail" class="form-control" name="mailProducer" id="mailProducer" placeholder="Nhập email">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_Producer" class="btn btn-primary">Thêm</button></form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chỉnh sửa nhà cung cấp/sản xuất -->
    <div id="editProducer" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Chỉnh sửa nhà cung cấp/sản xuất</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/producerCP" method="post">
                      <input type="hidden" name="toEditProducer" id="toEditProducer" value=""/>
                      <fieldset class="form-group">
                          <label for="producerName">Tên đối tác</label>
                          <input type="text" class="form-control" name="producerName" id="thisproducerName" value="" placeholder="Nhập tên đối tác">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="serviceProducer">Dịch vụ</label>
                          <input type="text" class="form-control" name="serviceProducer" id="thisserviceProducer" value="" placeholder="Loại dịch vụ cung cấp?">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="phoneProducer">Điện thoại</label>
                          <input type="number" class="form-control" name="phoneProducer" id="thisphoneProducer" value="" placeholder="Nhập số điện thoại">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="addressProducer">Địa chỉ</label>
                          <input type="text" class="form-control" name="addressProducer" id="thisaddressProducer" value="" placeholder="Nhập địa chỉ">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="mailProducer">Email</label>
                          <input type="mail" class="form-control" name="mailProducer" id="thismailProducer" value="" placeholder="Nhập email">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editProducer" class="btn btn-primary">Thêm</button></form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div id="delProducer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Xóa nhà cung cấp/sản xuất</h4>
                </div>
                <div class="modal-body">
                  <center>
                    <h4>Hành động này cần xác nhận: Không thể hoàn tác!</h4>
                    <p>Vui lòng kiểm tra cẩn thận!</p>
                  </center>
                </div>
                <div class="modal-footer">
                  <form action="<?php echo $_DOMAIN; ?>admin/producerCP" method="post">
                    <input type="hidden" name="toDelProducer" id="toDelProducer" value=""/>
                            <button type="submit" name="delProducer" class="btn btn-danger">Đồng ý</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button></form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS Function -->
        <script language="JavaScript">
        // using latest bootstrap so, show.bs.modal
        //editMember
        $('#editProducer').on('show.bs.modal', function(e) {
          var id = $(e.relatedTarget).data('id');
          $("#toEditProducer").val(id);
          var name = $(e.relatedTarget).data('name');
          $("#thisproducerName").val(name);
          var service = $(e.relatedTarget).data('service');
          $("#thisserviceProducer").val(service);
          var phone = $(e.relatedTarget).data('phone');
          $("#thisphoneProducer").val(phone);
          var address = $(e.relatedTarget).data('address');
          $("#thisaddressProducer").val(address);
          var mail = $(e.relatedTarget).data('mail');
          $("#thismailProducer").val(mail);
        });
        //delMember
        $('#delProducer').on('show.bs.modal', function(e) {
          var product = $(e.relatedTarget).data('id');
          $("#toDelProducer").val(product);
        });
        </script>
