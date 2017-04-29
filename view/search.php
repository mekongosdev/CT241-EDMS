<?php
// Nếu đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>
<div class="container">
    <div class="search">
      <h3>Tìm kiếm</h3>
      <form class="form-horizontal" method="POST">
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
          <input class="form-control" type="text" name="Content" placeholder="Bạn cần tìm gì?"></div>
          <button class="form-inline hidden" type="submit" name="Search"><span class="glyphicon glyphicon-search"></span></button>
      </form>
    </div>
    <div class="result">
      <br  />
      <legend>Kết quả tìm kiếm</legend>
      <p><strong>* Thiết bị</strong></p>
      <?php
        if (isset($_REQUEST["Search"])) {
          $value = $_REQUEST["Content"];
          $option = $_REQUEST["options"];

          if( ! $value) echo "Vui lòng nhập nội dung cần tìm";

          echo $value;
          echo "<br  />";
          echo $option;
        }
      ?>
      <p><strong>* Thành viên</strong></p>
      <?php
        if (isset($_REQUEST["Search"])) {
          $value = $_REQUEST["Content"];
          $option = $_REQUEST["options"];

          if( ! $value) echo "Vui lòng nhập nội dung cần tìm";

          echo $value;
          echo "<br  />";
          echo $option;
        }
      ?>
      <p><strong>* Dự án</strong></p>
      <?php
        if (isset($_REQUEST["Search"])) {
          $value = $_REQUEST["Content"];
          $option = $_REQUEST["options"];

          if( ! $value) echo "Vui lòng nhập nội dung cần tìm";

          echo $value;
          echo "<br  />";
          echo $option;
        }
      ?>
      <p><strong>* Labs</strong></p>
      <?php
        if (isset($_REQUEST["Search"])) {
          $value = $_REQUEST["Content"];
          $option = $_REQUEST["options"];

          if( ! $value) echo "Vui lòng nhập nội dung cần tìm";

          echo $value;
          echo "<br  />";
          echo $option;
        }
      ?>
    </div>
</div>
