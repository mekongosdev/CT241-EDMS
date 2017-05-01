<?php
// Nếu đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>

<div class="header-menu-top">
      <div class="box-left-blog">
        <marquee behavior="scroll" direction="left">
          <?php
          $sql_get_user = "SELECT * FROM project_info ORDER BY idProject DESC";
          if ($db->num_rows($sql_get_user)) {
              //Dự án đầu tiên
              $val_1st = "SELECT * FROM project_info ORDER BY idProject DESC limit 1";

              foreach ($db->fetch_assoc($val_1st, 0) as $key => $row_1st) {
                echo '<span>
                  <a href="#" style="color: red">
                    '.$row_1st['nameProject'].' - '.$row_1st['nameUser'].' &gt;&gt;&gt;&gt;&gt;</a>
                </span>';
              }

              //Dự án thứ 2
              $val_2nd = "SELECT * FROM project_info ORDER BY idProject DESC limit 1,1";

              foreach ($db->fetch_assoc($val_2nd, 0) as $key => $row_2nd) {
                echo '<span>
                  <a href="#" style="color: blue">
                    '.$row_2nd['nameProject'].' - '.$row_2nd['nameUser'].' &gt;&gt;&gt;&gt;&gt;</a>
                </span>';
              }

              //Dự án thứ 3
              $val_3rd = "SELECT * FROM project_info ORDER BY idProject DESC limit 2,1";;

              foreach ($db->fetch_assoc($val_3rd, 0) as $key => $row_3rd) {
                echo '<span>
                  <a href="#" style="color: green">
                    '.$row_3rd['nameProject'].' - '.$row_3rd['nameUser'].' &gt;&gt;&gt;&gt;&gt;</a>
                </span>';
              }
          } else {
              echo '<span>
                <a href="#" style="color: #1a991a">
                  Chưa có dự án nào. &gt;&gt;&gt;&gt;&gt;</a>
              </span>';
          }
          ?>
        </marquee>
    </div>
</div>

<!--div class="container"-->


    <div id="newDevice" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#newDevice" data-slide-to="0" class="active"></li>
        <li data-target="#newDevice" data-slide-to="1"></li>
        <li data-target="#newDevice" data-slide-to="2"></li>
      </ol>
        <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <?php
        $sql_get_device = "SELECT * FROM device_info";
        $total_device = $db->num_rows($sql_get_device);

        if ($total_device > 0) {
          $img_device_active = "SELECT * FROM device_info ORDER BY idDevice DESC LIMIT 1";

          foreach ($db->fetch_assoc($img_device_active, 0) as $key => $data_img_active) {
            echo '
            <div class="item active">
              <center>
                  <img src="'.$_DOMAIN.$data_img_active['urlImg'].'" style="height:300px;" alt="'.substr($data_img_active['nameDevice'], 12).'">
              </center>
              <div class="carousel-caption">
                  '.$data_img_active['nameDevice'].'
              </div>
            </div>';
          }

          $img_device = "SELECT * FROM device_info ORDER BY idDevice DESC LIMIT 1,3";

          foreach ($db->fetch_assoc($img_device, 0) as $key => $data_img) {
            echo '
            <div class="item">
              <center>
                  <img src="'.$_DOMAIN.$data_img['urlImg'].'" style="height:300px;" alt="'.substr($data_img['nameDevice'], 12).'">
              </center>
              <div class="carousel-caption">
                  '.$data_img['nameDevice'].'
              </div>
            </div>';
          }
        } else echo '<br><div class="alert alert-info">Chưa có thiết bị nào.</div>';
        ?>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#newDevice" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
      </a>
      <a class="right carousel-control" href="#newDevice" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
      </a>
    </div>

    <legend><h4 style="margin-left:50px;"><span class="glyphicon glyphicon-blackboard"></span><strong> Labs mới nhất </strong></h4></legend>

    <div class="row" style="margin-left:30px;margin-right:30px;">
      <center><?php
          $sql_get_user = "SELECT * FROM lab_info ORDER BY idLab DESC";
          if ($db->num_rows($sql_get_user)) {
            $row="SELECT idLab FROM lab_info";
            $row_per_page=6;
            $rows=$db->num_rows($row);
            if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
            else $page=1;
            if(isset($_GET['page']) && (int)$_GET['page'])
                 $start=($_GET['page']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
            else $start=0;
            // var_dump($start);
            $val = "SELECT * FROM lab_info ORDER BY idLab ASC limit $start,$row_per_page";

            foreach ($db->fetch_assoc($val, 0) as $key => $row) {
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
            }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có Lab nào.</div>';
          }
        ?>

      </center>
    </div>

<!--/div-->

<a href="#" class="buttonFixed search-btn" data-toggle="modal" data-target="#searchBtn"></a>

<div class="modal fade" id="searchBtn">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title">Tìm kiếm</h4>
      </div>
      <div class="modal-body">
        <form class="form-inline" action="<?php echo $_DOMAIN; ?>search" method="post" style="margin:17px;">
            <input class="hidden" type="selected" name="options" value="all">
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
              <input class="form-control" type="text" name="Content" placeholder="Bạn cần tìm gì?">
            </div>
            <!-- <button class="hidden" type="submit" name="Search"><span class="glyphicon glyphicon-search"></span></button>
        </form> -->
      </div>
      <div class="modal-footer">
        <!-- <center><p></p></center> -->
        <button class="btn btn-primary" type="submit" name="Search"><span class="glyphicon glyphicon-search"></span> Tìm kiếm</button></form>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
