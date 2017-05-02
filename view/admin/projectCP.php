<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addProject"></a>

<?php

// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);?>

<h3>Quản lý dự án</h3>
  <button class="btn btn-success" data-toggle="modal" data-target="#addProject">Thêm dự án mới</button>
  <a href="<?php echo $_DOMAIN; ?>admin/projectCP" class="btn btn-default">
      <span class="glyphicon glyphicon-repeat"></span> Tải lại
  </a>

<table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Tên dự án</th>
                <th>Chủ nhiệm</th>
                <th>Hướng dẫn</th>
                <th>Khởi động</th>
                <th>Quản lý</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $sql_get_project = "SELECT * FROM project_info ORDER BY idProject DESC";
          if ($db->num_rows($sql_get_project)) {
              $row="SELECT idProject FROM project_info";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['act']) && (int)$_GET['act'])
                   $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              $val = "SELECT *,DATE_FORMAT( dateStart,  '%d/%m/%Y' ) AS date FROM project_info ORDER BY idProject ASC limit $start,$row_per_page";

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idProject'].'</td>
                    <td>'.$row['nameProject'].'</td>
                    <td>'.$row['nameUser'].'</td>
                    <td>'.$row['nameStaff'].'</td>
                    <td>'.$row['date'].'</td>
                    <td><a href="" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></a></td>
                </tr>';
              }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có dự án nào.</div>';
          }
          ?>
        </tbody>
    </table>

    <div class="container">
<?php
$row="SELECT idProject FROM project_info";
$rows=$db->num_rows($row);
$config = array(
    'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => $_DOMAIN.'admin/projectCP/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'admin/projectCP',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
</div>

    <div id="addProject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thêm dự án</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $_DOMAIN; ?>admin/projectCP" method="post">
                      <fieldset class="form-group">
                          <label for="projectName">Tên dự án</label>
                          <input type="text" class="form-control" name="projectName" id="projectName" placeholder="Nhập tên dự án">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="projectOwn">Chủ nhiệm</label>
                          <select class="form-control" name="projectOwn" id="projectOwn">
                            <?php
                                //Chọn chủ nhiệm
                                $sql_producer = "SELECT fullName FROM user_info";
                                foreach ($db->fetch_assoc($sql_producer,0) as $key => $data) {
                                  echo '<option value="'.$data['fullName'].'">'.$data['fullName'].'</option>';
                                }
                            ?>
                          </select>
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="projectGuide">Hướng dẫn</label>
                          <select class="form-control" name="projectGuide" id="projectGuide">
                            <option value="Tự nghiên cứu">Tự nghiên cứu</option>
                            <?php
                                //Chọn người hướng dẫn
                                $sql_producer = "SELECT fullName FROM user_info WHERE type = 1";
                                foreach ($db->fetch_assoc($sql_producer,0) as $key => $data) {
                                  echo '<option value="'.$data['fullName'].'">'.$data['fullName'].'</option>';
                                }
                            ?>
                          </select>
                          <small class="text-muted">Nếu tự nghiên cứu, chọn Tự nghiên cứu</i></small>
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="projectLab">Phòng thí nghiệm</label>
                          <select class="form-control" name="projectLab" id="projectLab">
                            <option value="0">Không có Lab</option>
                            <?php
                                //Chọn lab
                                $sql_lab = "SELECT idLab,nameLab FROM lab_info";
                                foreach ($db->fetch_assoc($sql_lab,0) as $key => $data) {
                                  echo '<option value="'.$data['idLab'].'">'.$data['nameLab'].'</option>
                            ';
                                }
                            ?>
                          </select>
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="projectStart">Khởi động từ</label>
                          <input type="date" class="form-control" name="projectStart" id="projectStart" placeholder="Nhập ngày bắt đầu">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="addNewProject"class="btn btn-primary">Thêm</button></form>
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
//Thêm dự án
  if(isset($_POST['addNewProject'])){
    $projectName = addslashes($_POST['projectName']);
    $projectOwn = $_POST['projectOwn'];
    $projectGuide = $_POST['projectGuide'];
    $projectLab = $_POST['projectLab'];
    $projectStart = $_POST['projectStart'];

    if($projectName && $projectOwn && $projectGuide && $projectStart && $projectLab)
       {
         $sql="INSERT INTO project_info(idLab,nameProject,nameUser,nameStaff,dateStart) VALUES ('$projectLab','$projectName','$projectOwn','$projectGuide','$projectStart')";
         $query = $db->query($sql);
         new Redirect($_DOMAIN.'admin/projectCP');
      } else echo '<div class="alert alert-warning">Vui lòng điền đầy đủ thông tin.</div>';
    }
?>
