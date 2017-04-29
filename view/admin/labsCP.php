<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addProject"></a>

<?php

// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap?>

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
              $retval = $db->query($val);

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idLab'].'</td>
                    <td>'.$row['nameLab'].'</td>
                    <td>'.$row['unit'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['address'].'</td>
                    <td><a href="'.$row['location'].'">'.$row['location'].'</a></td>
                    <td><a href="" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a></td>
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
                          <input type="text" class="form-control" name="labMap" id="labMap" value="không có" placeholder="Nhập địa chỉ URL từ Google Map">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="addNewLab"class="btn btn-primary">Thêm</button></form>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id="editProject" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Chỉnh sửa dự án</h4>
                </div>
                <div class="modal-body">
                    <form>
                      <fieldset class="form-group">
                          <label for="projectName">Tên dự án</label>
                          <input type="text" class="form-control" name="projectName" id="projectName" placeholder="Nhập tên dự án">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="projectOwn">Chủ nhiệm</label>
                          <select class="form-control" name="projectOwn" id="projectOwn">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                          </select>
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="projectGuide">Hướng dẫn</label>
                          <select class="form-control" name="projectGuide" id="projectGuide">
                            <option>Tự nghiên cứu</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                          </select>
                          <small class="text-muted">Nếu tự nghiên cứu, chọn Tự nghiên cứu</i></small>
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="projectStart">Khởi động từ</label>
                          <input type="date" class="form-control" name="projectStart" id="projectStart" placeholder="Nhập ngày bắt đầu">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteProject">Xóa</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button></form>
                </div>
            </div>
        </div>
    </div> -->



    <!-- <div id="deleteProject" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Bạn đang xóa dự án!</h4>
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
?>
