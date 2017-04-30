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
                <span class="name"><strong>'.$data_lab_info['nameLab'].' </strong></span>
                <div class="divider"></div>
                <span>Đơn vị: '.$data_lab_info['unit'].'</span><br />
                <span>Điện thoại: <a href="tel:'.$data_lab_info['phone'].'">'.$data_lab_info['phone'].'</a></span><br />
                <span>Địa chỉ: '.$data_lab_info['address'].'</span><br />
                <span>Google Maps: <a href="'.$data_lab_info['location'].'">'.$data_lab_info['location'].'</a></span>
                <div class="divider"></div>';
                $sql_get_project = "SELECT * FROM project_info WHERE idLab = '$id'";
                $total_project = $db->num_rows($sql_get_project);
                echo '
                <span>Các dự án: <span class="badge">'.$total_project.'</span></span><br  />';
                if ($total_project > 0) {
                  foreach ($db->fetch_assoc($sql_get_project, 0) as $key => $value_lab) {
                    echo '- '.$value_lab['nameProject'].' - '.$value_lab['nameUser'].'<br  />';
                  }
                } else echo '<br><div class="alert alert-info">Chưa có dự án nào.</div>';
                // <a href="'.$_DOMAIN.'#">- '.$data_lab_info['nameProject'].' - '.$data_lab_info['nameUser'].'</a><br  />
            echo '</div>
            ';
          } else new Redirect($_DOMAIN.'labs');
        } else new Redirect($_DOMAIN.'labs');
      } else if ($_GET["tab"] == "page") {
        echo '<div class="row" style="margin-left:30px;margin-right:30px;">
          <center>';
    $sql_get_user = "SELECT * FROM lab_info ORDER BY idLab DESC";
    if ($db->num_rows($sql_get_user)) {
      $row="SELECT idLab FROM lab_info";
      $row_per_page=6;
      $rows=$db->num_rows($row);
      if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
      else $page=1;
      if(isset($_GET['act']) && (int)$_GET['act'])
           $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
      else $start=0;
      // var_dump($start);
      $val_lab = "SELECT * FROM lab_info ORDER BY idLab ASC limit $start,$row_per_page";

      foreach ($db->fetch_assoc($val_lab, 0) as $key => $row) {
        echo '
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <span class="name"><h4><strong>'.$row['nameLab'].'</strong></h4></span>
            </div>
            <div class="panel-body">
              <span>Đơn vị: '.$row['unit'].'</span><br />
              <span>Điện thoại: <a href="tel:'.$row['phone'].'">'.$row['phone'].'</a></span><br />
              <span>Địa chỉ: '.$row['address'].'</span><br />
              <span><a href="'.$_DOMAIN.'labs/info/'.$row['idLab'].'">Xem chi tiết</a></span>
            </div>
          </div>
        </div>';
      } echo '
      </center>
    </div>
    <div class="container">';

      $row="SELECT idLab FROM lab_info";
      $rows=$db->num_rows($row);
      $config = array(
          'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
          'total_record'  => $rows, // Tổng số record
          'limit'         => 6,// limit
          'link_full'     => $_DOMAIN.'labs/page/{page}',// Link full có dạng như sau: domain/com/page/{page}
          'link_first'    => $_DOMAIN.'labs',// Link trang đầu tiên
          'range'         => 3 // Số button trang bạn muốn hiển thị
      );

      $paging = new Pagination();

      $paging->init($config);

      echo $paging->html();

      echo'</div>';
    } else {
        echo '<br><br><div class="alert alert-info">Chưa có Lab nào.</div>';
    }
      }
    } else {
      echo '<div class="row" style="margin-left:30px;margin-right:30px;">
        <center>';
  $sql_get_user = "SELECT * FROM lab_info ORDER BY idLab DESC";
  if ($db->num_rows($sql_get_user)) {
    $row="SELECT idLab FROM lab_info";
    $row_per_page=6;
    $rows=$db->num_rows($row);
    if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
    else $page=1;
    if(isset($_GET['act']) && (int)$_GET['act'])
         $start=($_GET['act']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
    else $start=0;
    // var_dump($start);
    $val_lab = "SELECT * FROM lab_info ORDER BY idLab ASC limit $start,$row_per_page";

    foreach ($db->fetch_assoc($val_lab, 0) as $key => $row) {
      echo '
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="name"><h4><strong>'.$row['nameLab'].'</strong></h4></span>
          </div>
          <div class="panel-body">
            <span>Đơn vị: '.$row['unit'].'</span><br />
            <span>Điện thoại: <a href="tel:'.$row['phone'].'">'.$row['phone'].'</a></span><br />
            <span>Địa chỉ: '.$row['address'].'</span><br />
            <span><a href="'.$_DOMAIN.'labs/info/'.$row['idLab'].'">Xem chi tiết</a></span>
          </div>
        </div>
      </div>';
    } echo '
    </center>
  </div>
  <div class="container">';

    $row="SELECT idLab FROM lab_info";
    $rows=$db->num_rows($row);
    $config = array(
        'current_page'  => isset($_GET['act']) ? $_GET['act'] : 1, // Trang hiện tại
        'total_record'  => $rows, // Tổng số record
        'limit'         => 6,// limit
        'link_full'     => $_DOMAIN.'labs/page/{page}',// Link full có dạng như sau: domain/com/page/{page}
        'link_first'    => $_DOMAIN.'labs',// Link trang đầu tiên
        'range'         => 3 // Số button trang bạn muốn hiển thị
    );

    $paging = new Pagination();

    $paging->init($config);

    echo $paging->html();

    echo'</div>';
  } else {
      echo '<br><br><div class="alert alert-info">Chưa có Lab nào.</div>';
  }
}
?>
