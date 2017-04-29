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
              $val = "SELECT * FROM project_info ORDER BY idProject ASC limit 0,3";
              $retval = $db->query($val);

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<span>
                  <a href="#" style="color: #1a991a">
                    '.$row['nameProject'].' - '.$row['nameUser'].' &gt;&gt;&gt;&gt;&gt;</a>
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
        <div class="item active">
          <center>
              <img src="view/images/arduino.jpg" style="height:300px;" alt="">
          </center>
          <div class="carousel-caption">
              Arduino ESP8266
          </div>
        </div>
        <div class="item">
          <center>
              <img src="view/images/relay.jpg" style="height:300px;" alt="">
          </center>
          <div class="carousel-caption">
              Relay 1 kênh
          </div>
        </div>
        <div class="item">
          <center>
              <img src="view/images/nanopc.jpg" style="height:300px;" alt="">
          </center>
          <div class="carousel-caption">
              NanoPC
          </div>
        </div>
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
      <center>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <span class="name"><h4><strong>IoT Application</strong></h4></span>
            </div>
            <div class="panel-body">
              <span>Đơn vị: BM CNPM</span><br />
              <span>Điện thoại: 07103 331 328</span><br />
              <span>Địa chỉ: Khoa CNTT&TT</span><br />
              <span>Các dự án: <span class="badge">3</span></span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <span class="name"><h4><strong>IoT Application</strong></h4></span>
            </div>
            <div class="panel-body">
              <span>Đơn vị: BM CNPM</span><br />
              <span>Điện thoại: 07103 331 328</span><br />
              <span>Địa chỉ: Khoa CNTT&TT</span><br />
              <span>Các dự án: <span class="badge">3</span></span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <span class="name"><h4><strong>IoT Application</strong></h4></span>
            </div>
            <div class="panel-body">
              <span>Đơn vị: BM CNPM</span><br />
              <span>Điện thoại: 07103 331 328</span><br />
              <span>Địa chỉ: Khoa CNTT&TT</span><br />
              <span>Các dự án: <span class="badge">3</span></span>
            </div>
          </div>
        </div>
      </center>

    </div>

<!--/div-->

<a href="tel:01234567890" class="buttonFixed callBrg"></a>'
