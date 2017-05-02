<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);
?>
<div class="container">
    <div class="search">
      <h3>Tìm kiếm</h3>
      <form action="<?php echo $_DOMAIN;?>search" class="form-horizontal" method="POST">
          <div class="form-group col-sm-3">
            <select class="form-control" name="options">
                <option <?php echo "selected";?> value="all">Tất cả</option>
                <option <?php if (isset($options) && $options=="device") echo "selected";?> value="device">Thiết bị</option>
                <option <?php if (isset($options) && $options=="member") echo "selected";?> value="member">Thành viên</option>
                <option <?php if (isset($options) && $options=="project") echo "selected";?> value="project">Dự án</option>
                <option <?php if (isset($options) && $options=="labs") echo "selected";?> value="labs">Labs</option>
            </select>
          </div>
          <div class="form-group col-sm-9">
          <input class="form-control" type="text" name="Content" placeholder="Bạn cần tìm gì? Gõ Enter hoặc click để tìm kiếm"></div>
          <button class="form-inline btn btn-default" type="submit" name="Search"><span class="glyphicon glyphicon-search"></span></button>
      </form>
    </div>
    <div class="result">
      <br  />
      <legend>Kết quả tìm kiếm</legend>
      <?php
        if (isset($_REQUEST["Search"])) {
          $value = $_REQUEST["Content"];
          $option = $_REQUEST["options"];

          //Cac cau lenh tim kiem
          $search_device = "SELECT * FROM device_info WHERE nameDevice LIKE '%$value%'";
          $search_member = "SELECT * FROM user_info INNER JOIN images ON user_info.idImg = images.idImg WHERE fullName LIKE '%$value%' OR phone LIKE '%$value%' OR email LIKE '%$value%' OR idUser LIKE '%$value%'";
          $search_project = "SELECT *,DATE_FORMAT( dateStart,  '%d/%m/%Y' ) AS date FROM project_info WHERE nameProject LIKE '%$value%'";
          $search_lab = "SELECT * FROM lab_info WHERE nameLab LIKE '%$value%' OR unit LIKE '%$value%' OR phone LIKE '%$value%' OR address LIKE '%$value%'";

          if ($option == 'all') {
            if( ! $value) {
              echo '<br><div class="alert alert-info">Vui lòng nhập nội dung cần tìm</div>';
            } else {
                echo '<p><strong>* Thiết bị</strong></p>';
                if ($db->num_rows($search_device)) {
                echo '<table id="infoDevice" class="table table-striped">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên thiết bị</th>
                        <th>Mô tả</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->fetch_assoc($search_device,0) as $key => $device_result) {
                  echo '
                  <tr>
                      <td><img src="'.$_DOMAIN.$device_result['urlImg'].'" style="width:100px;height:100px;"/></td>
                      <td>'.$device_result['nameDevice'].'</td>
                      <td>'.$device_result['description'].'</td>
                  </tr>';
              }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';

                echo '<p><strong>* Thành viên</strong></p>';
                if ($db->num_rows($search_member)) {
                echo '<table id="infoMember" class="table table-striped">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên thành viên</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Mạng xã hội</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->fetch_assoc($search_member,0) as $key => $member_result) {
                  echo '
                  <tr>
                      <td><img src="'.$_DOMAIN.$member_result['url'].'" style="width:100px;height:100px;"/></td>
                      <td><a href="'.$_DOMAIN.'profile/'.$member_result['idUser'].'">'.$member_result['fullName'].'</a></td>
                      <td><a href="tel:'.$member_result['phone'].'">'.$member_result['phone'].'</a></td>
                      <td><a href="mailto:'.$member_result['email'].'">'.$member_result['email'].'</a></td>
                      <td><a href="'.$member_result['social'].'">'.$member_result['social'].'</a></td>
                  </tr>';
              }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';

                echo '<p><strong>* Dự án</strong></p>';
                if ($db->num_rows($search_project)) {
                  echo '<table id="infoMember" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Tên dự án</th>
                          <th>Chủ nhiệm</th>
                          <th>Hướng dẫn</th>
                          <th>Ngày bắt đầu</th>
                      </tr>
                  </thead>
                  <tbody>';
                  foreach ($db->fetch_assoc($search_project,0) as $key => $project_result) {
                    echo '
                      <tr>
                          <td>'.$project_result['nameProject'].'</td>
                          <td>'.$project_result['nameUser'].'</td>
                          <td>'.$project_result['nameStaff'].'</td>
                          <td>'.$project_result['date'].'</td>
                      </tr>';
                }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';

                echo '<p><strong>* Lab</strong></p>';
                if ($db->num_rows($search_lab)) {
                  echo '<table id="infoMember" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Tên Lab</th>
                          <th>Điện thoại</th>
                          <th>Đơn vị</th>
                          <th>Địa chỉ</th>
                      </tr>
                  </thead>
                  <tbody>';
                  foreach ($db->fetch_assoc($search_lab,0) as $key => $lab_result) {
                    echo '
                      <tr>
                          <td><a href="'.$_DOMAIN.'labs/info/'.$lab_result['idLab'].'">'.$lab_result['nameLab'].'</a></td>
                          <td><a href="tel:'.$lab_result['phone'].'">'.$lab_result['phone'].'</a></td>
                          <td>'.$lab_result['unit'].'</td>
                          <td>'.$lab_result['address'].'</td>
                      </tr>';
                }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';
            }
          } else if ($option == 'device') {
            if( ! $value) {
              echo '<br><div class="alert alert-info">Vui lòng nhập nội dung cần tìm</div>';
            } else {
                echo '<p><strong>* Thiết bị</strong></p>';
                if ($db->num_rows($search_device)) {
                echo '<table id="infoDevice" class="table table-striped">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên thiết bị</th>
                        <th>Mô tả</th>
                    </tr>
                </thead>
                <tbody>';
                  foreach ($db->fetch_assoc($search_device,0) as $key => $device_result) {
                    echo '
                    <tr>
                        <td><img src="'.$_DOMAIN.$device_result['urlImg'].'" style="width:100px;height:100px;"/></td>
                        <td>'.$device_result['nameDevice'].'</td>
                        <td>'.$device_result['description'].'</td>
                    </tr>';
                }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';
            }
          } else if ($option == 'member') {
            if( ! $value) {
              echo '<br><div class="alert alert-info">Vui lòng nhập nội dung cần tìm</div>';
            } else {
                echo '<p><strong>* Thành viên</strong></p>';
                if ($db->num_rows($search_member)) {
                echo '<table id="infoMember" class="table table-striped">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên thành viên</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Mạng xã hội</th>
                    </tr>
                </thead>
                <tbody>';
                  foreach ($db->fetch_assoc($search_member,0) as $key => $member_result) {
                    echo '
                    <tr>
                        <td><img src="'.$_DOMAIN.$member_result['url'].'" style="width:100px;height:100px;"/></td>
                        <td><a href="'.$_DOMAIN.'profile/'.$member_result['idUser'].'">'.$member_result['fullName'].'</a></td>
                        <td><a href="tel:'.$member_result['phone'].'">'.$member_result['phone'].'</a></td>
                        <td><a href="mailto:'.$member_result['email'].'">'.$member_result['email'].'</a></td>
                        <td><a href="'.$member_result['social'].'">'.$member_result['social'].'</a></td>
                    </tr>';
                }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';
            }
          } else if ($option == 'project') {
            if( ! $value) {
              echo '<br><div class="alert alert-info">Vui lòng nhập nội dung cần tìm</div>';
            } else {
                echo '<p><strong>* Dự án</strong></p>';
                if ($db->num_rows($search_project)) {
                  echo '<table id="infoMember" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Tên dự án</th>
                          <th>Chủ nhiệm</th>
                          <th>Hướng dẫn</th>
                          <th>Ngày bắt đầu</th>
                      </tr>
                  </thead>
                  <tbody>';
                  foreach ($db->fetch_assoc($search_project,0) as $key => $project_result) {
                    echo '
                      <tr>
                          <td>'.$project_result['nameProject'].'</td>
                          <td>'.$project_result['nameUser'].'</td>
                          <td>'.$project_result['nameStaff'].'</td>
                          <td>'.$project_result['date'].'</td>
                      </tr>';
                }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';
            }
          } else if ($option == 'labs') {
            if( ! $value) {
              echo '<br><div class="alert alert-info">Vui lòng nhập nội dung cần tìm</div>';
            } else {
                echo '<p><strong>* Lab</strong></p>';
                if ($db->num_rows($search_lab)) {
                  echo '<table id="infoMember" class="table table-striped">
                  <thead>
                      <tr>
                          <th>Tên Lab</th>
                          <th>Điện thoại</th>
                          <th>Đơn vị</th>
                          <th>Địa chỉ</th>
                      </tr>
                  </thead>
                  <tbody>';
                  foreach ($db->fetch_assoc($search_lab,0) as $key => $lab_result) {
                    echo '
                      <tr>
                          <td><a href="'.$_DOMAIN.'labs/info/'.$lab_result['idLab'].'">'.$lab_result['nameLab'].'</a></td>
                          <td><a href="tel:'.$lab_result['phone'].'">'.$lab_result['phone'].'</a></td>
                          <td>'.$lab_result['unit'].'</td>
                          <td>'.$lab_result['address'].'</td>
                      </tr>';
                }
                    echo '</tbody>
                </table>';
              } else echo '<div class="alert alert-info">Không tìm thấy từ khóa!</div>';
            }
          } else echo '<br><div class="alert alert-info">Vui lòng nhập nội dung cần tìm</div>';
          //new Redirect($_DOMAIN);

          // echo $value;
          // echo "<br  />";
          // echo $option;
        } else echo '<br><div class="alert alert-info">Vui lòng nhập nội dung cần tìm</div>';
      ?>
    </div>
</div>
