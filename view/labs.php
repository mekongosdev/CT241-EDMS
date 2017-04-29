<a href="<?php echo $_DOMAIN; ?>admin/labs" class="buttonFixed adminCP"></a>
<?php
// Nếu đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap

if (isset($_GET["tab"])) {
	//Get tab va trả về kết quả theo ý muốn
      if ($_GET["tab"] == "info") {
        if (isset($_GET['act'])) {
          if ($_GET["act"]) {
            $id=$_GET['act'];
            $sql_get_lab = "SELECT * FROM lab_info WHERE idLab = '$id'";
            if ($db->num_rows($sql_get_lab))
            {
                $data_lab_info = $db->fetch_assoc($sql_get_lab, 1);
            }
            echo '<div class="container">
                <legend>
                    <h1>Thông tin Lab</h1></legend>
                <span class="name">'.$data_lab_info['nameLab'].' </span><a href="'.$_DOMAIN.'#" data-toggle="modal" data-target="#editLab">Chỉnh sửa</a>
                <div class="divider"></div>
                <span>Đơn vị: '.$data_lab_info['unit'].'</span><br />
                <span>Điện thoại: '.$data_lab_info['phone'].'</span><br />
                <span>Địa chỉ: '.$data_lab_info['address'].'</span><br />
                <span>Google Maps: <a href="'.$data_lab_info['location'].'">'.$data_lab_info['location'].'</a></span>
                <div class="divider"></div>';
                $sql_get_project = "SELECT * FROM project_info WHERE idLab = '$id'";
                $total_project = $db->num_rows($sql_get_project);
                echo '
                <span>Các dự án: <span class="badge">'.$total_project.'</span></span><br  />';
                foreach ($db->fetch_assoc($sql_get_project, 0) as $key => $value) {
                  echo '- '.$value['nameProject'].' - '.$value['nameUser'].'<br  />';
                }
                // <a href="'.$_DOMAIN.'#">- '.$data_lab_info['nameProject'].' - '.$data_lab_info['nameUser'].'</a><br  />
            echo '</div>
            ';
          } else new Redirect($_DOMAIN.'labs');
        } else new Redirect($_DOMAIN.'labs');
      }
    } else {
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
      echo '
      <div class="row">
      <center>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="name">'.$row['nameLab'].'</span>
          </div>
          <div class="panel-body">
            <span>Đơn vị: '.$row['unit'].'</span><br />
            <span>Điện thoại: '.$row['phone'].'</span><br />
            <span>Địa chỉ: '.$row['address'].'</span><br />
            <span><a href="'.$_DOMAIN.'labs/info/'.$row['idLab'].'">Xem chi tiết</a></span>
          </div>
        </div>
      </div>';
    }
  } else {
      echo '<br><br><div class="alert alert-info">Chưa có Lab nào.</div>';
  }
}
echo '
<!--Update Lab-->
<div id="editLab" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="">Chỉnh sửa Lab</h4>
</div>
<div class="modal-body">
    <form>
      <fieldset class="form-group">
        <label for="name">Tên Lab</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên Lab">
      </fieldset>
      <fieldset class="form-group">
        <label for="unit">Đơn vị</label>
        <input type="text" class="form-control" name="unit" id="unit" placeholder="Nhập đơn vị">
      </fieldset>
      <fieldset class="form-group">
        <label for="phone">Điện thoại</label>
        <input type="text" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại">
      </fieldset>
      <fieldset class="form-group">
        <label for="address">Địa chỉ</label>
        <input type="text" class="form-control" name="address" id="address" placeholder="Nhập địa chỉ">
      </fieldset>
</div>
<div class="modal-footer">
  <button type="submit" class="btn btn-primary" name="editLab">Đồng ý</button></form>
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
';
?>
