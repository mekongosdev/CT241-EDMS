<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);

if (requestRole($roleUser,'projectCP') == 1) {
  echo '<a href="'.$_DOMAIN.'admin/projectCP" class="buttonFixed adminCP"></a>';
}

if (isset($_GET["tab"])) {
	//Get tab va trả về kết quả theo ý muốn
      if ($_GET["tab"] == "info") {
        if (isset($_GET['act'])) {
          if ($_GET["act"]) {
            $id=$_GET['act'];
            $sql_get_full_prj = "SELECT *,DATE_FORMAT( dateStart,  '%d/%m/%Y' ) AS dateStart FROM project_info a, project_info_detail b, lab_info c, user_info d WHERE (a.idProject = b.idProject) AND (b.idUser = d.idUser) AND (a.idLab = c.idLab) AND a.idProject = '$id'";
            $sql_get_info_prj = "SELECT *,DATE_FORMAT( dateStart,  '%d/%m/%Y' ) AS dateStart FROM project_info a, lab_info b WHERE (a.idLab = b.idLab) AND a.idProject = '$id'";
            // if ($db->num_rows($sql_get_full_prj)) //Dự án có nhiều người tham gia
            // {
            //     $data_lab_info = $db->fetch_assoc($sql_get_lab, 1);
            // }
            if ($db->num_rows($sql_get_full_prj)) //Dự án có nhiều người tham gia
            {
               $data_prj_info = $db->fetch_assoc($sql_get_full_prj, 1);
               echo '<div class="container">
                  <legend>
                      <h1>Thông tin Dự án</h1></legend>
                  <span class="name"><strong>'.$data_prj_info['nameProject'].' </strong></span>
                  <div class="divider"></div>
                  <span>Chủ nhiệm: '.$data_prj_info['nameUser'].'</span><br />
                  <span>Hướng dẫn: '.$data_prj_info['nameStaff'].'</span><br />
                  <span>Lab tham gia: '.$data_prj_info['nameLab'].'</span><br />
                  <span>Ngày khởi động: '.$data_prj_info['dateStart'].'</span><br />
                  <div class="divider"></div>';
                  $sql_get_member = "SELECT * FROM project_info_detail INNER JOIN user_info ON project_info_detail.idUser = user_info.idUser WHERE project_info_detail.idProject = '$id'";
                  $total_members = $db->num_rows($sql_get_member);
                  echo '
                  <span>Tổng số thành viên đang tham gia: <span class="badge">'.$total_members.'</span></span><br  />';

                  foreach ($db->fetch_assoc($sql_get_member, 0) as $key => $info_member) {
                    echo '- <a href="'.$_DOMAIN.'profile/'.$info_member['idUser'].'">'.$info_member['fullName'].'</a><br  />';
                  }
                  echo '<div class="divider"></div>';
                  $sql_get_device = "SELECT * FROM project_info a, borrow_device b, device_info c WHERE (a.idProject = b.idProject) AND (b.idDevice = c.idDevice) AND a.idProject = '$id'";
                  $total_device_using = $db->num_rows($sql_get_device);
                  echo '
                  <span>Các thiết bị đang mượn: <span class="badge">'.$total_device_using.'</span></span><br  />';
                  if ($total_device_using > 0) {
                    foreach ($db->fetch_assoc($sql_get_device, 0) as $key => $value_device) {
                      echo '- '.$value_device['nameDevice'].' - '.$value_lab['totalBorrow'].'<br  />';
                    }
                  } else echo '<br><div class="alert alert-info">Chưa sử dụng thiết bị nào.</div>';
                  // <a href="'.$_DOMAIN.'#">- '.$data_lab_info['nameProject'].' - '.$data_lab_info['nameUser'].'</a><br  />
              echo '</div>
              ';
            } else {
              $data_prj_info = $db->fetch_assoc($sql_get_info_prj, 1);
              echo '<div class="container">
                 <legend>
                     <h1>Thông tin Dự án</h1></legend>
                 <span class="name"><strong>'.$data_prj_info['nameProject'].' </strong></span>
                 <div class="divider"></div>
                 <span>Chủ nhiệm: '.$data_prj_info['nameUser'].'</span><br />
                 <span>Hướng dẫn: '.$data_prj_info['nameStaff'].'</span><br />
                 <span>Lab tham gia: '.$data_prj_info['nameLab'].'</span><br />
                 <span>Ngày khởi động: '.$data_prj_info['dateStart'].'</span><br />
                 <div class="divider"></div>';
                 $sql_get_device = "SELECT * FROM project_info a, borrow_device b, device_info c WHERE (a.idProject = b.idProject) AND (b.idDevice = c.idDevice) AND a.idProject = '$id'";
                 $total_device_using = $db->num_rows($sql_get_device);
                 echo '
                 <span>Các thiết bị đang mượn: <span class="badge">'.$total_device_using.'</span></span><br  />';
                 if ($total_device_using > 0) {
                   foreach ($db->fetch_assoc($sql_get_device, 0) as $key => $value_device) {
                     echo '- '.$value_device['nameDevice'].' - Số lượng: '.$value_device['totalBorrow'].'<br  />';
                   }
                 } else echo '<br><div class="alert alert-info">Chưa sử dụng thiết bị nào.</div>';
                 // <a href="'.$_DOMAIN.'#">- '.$data_lab_info['nameProject'].' - '.$data_lab_info['nameUser'].'</a><br  />
             echo '</div>
             ';
            }
          }
        }
      }
    } else {
      echo '<legend>
        <h1>Danh sách Dự án</h1></legend>
    <table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Tên dự án</th>
                <th>Chủ nhiệm</th>
                <th>Hướng dẫn</th>
                <th>Khởi động</th>
            </tr>
        </thead>
        <tbody>';
          $sql_get_user = "SELECT * FROM project_info ORDER BY idProject DESC";
          if ($db->num_rows($sql_get_user)) {
              $row="SELECT idProject FROM project_info";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['tab']) && (int)$_GET['tab'])
                   $start=($_GET['tab']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              // var_dump($start);
              $val = "SELECT *,DATE_FORMAT( dateStart,  '%d/%m/%Y' ) AS date FROM project_info ORDER BY idProject ASC limit $start,$row_per_page";

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idProject'].'</td>
                    <td><a href="'.$_DOMAIN.'project/info/'.$row['idProject'].'">'.$row['nameProject'].'</a></td>
                    <td>'.$row['nameUser'].'</td>
                    <td>'.$row['nameStaff'].'</td>
                    <td>'.$row['date'].'</td>
                </tr>';
              }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có dự án nào.</div>';
          }
          echo '
        </tbody>
    </table>

    <div class="container">';

    $row="SELECT idProject FROM project_info";
    $rows=$db->num_rows($row);
    $config = array(
        'current_page'  => isset($_GET['tab']) ? $_GET['tab'] : 1, // Trang hiện tại
        'total_record'  => $rows, // Tổng số record
        'limit'         => 10,// limit
        'link_full'     => $_DOMAIN.'project/{page}',// Link full có dạng như sau: domain/com/page/{page}
        'link_first'    => $_DOMAIN.'project',// Link trang đầu tiên
        'range'         => 3 // Số button trang bạn muốn hiển thị
    );

    $paging = new Pagination();

    $paging->init($config);

    echo $paging->html();
    echo '
    </div>';
}
?>
