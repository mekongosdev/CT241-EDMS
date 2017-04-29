<!--Menu bar-->
<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="navbar-color">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- <a class="navbar-brand" href="<?php //echo $_DOMAIN; ?>"><h4><b>Hệ thống Quản lý Thiết bị Nhúng</b></h4></a> -->
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-color">
            <li<?php if (isset($_GET["action"])) if ($_GET["action"] == "") echo ' class="active">'; else echo '>'; else echo ' class="active">'; ?><a href="<?php echo $_DOMAIN; ?>"><h4><b><span class="glyphicon glyphicon-home"></span> Trang chủ</b></h4></a></li>
            <!-- <li class="dropdown">
              <a href="<?php //echo $_DOMAIN; ?>#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><h4><b>Các danh sách <span class="caret"></span></b></h3></a>
              <ul class="dropdown-menu"> -->
                <li<?php if (isset($_GET["action"])) if ($_GET["action"] == "members") echo ' class="active">'; else echo '>'; else echo '>'; ?><a href="<?php echo $_DOMAIN; ?>members"><h4><b><span class="glyphicon glyphicon-user"></span> Thành viên</b></h4></a></li>
                <li<?php if (isset($_GET["action"])) if ($_GET["action"] == "device") echo ' class="active">'; else echo '>'; else echo '>'; ?><a href="<?php echo $_DOMAIN; ?>device"><h4><b><span class="glyphicon glyphicon-hdd"></span> Thiết bị</b></h4></a></li>
                <li<?php if (isset($_GET["action"])) if ($_GET["action"] == "project") echo ' class="active">'; else echo '>'; else echo '>'; ?><a href="<?php echo $_DOMAIN; ?>project"><h4><b><span class="glyphicon glyphicon-tasks"></span> Dự án</b></h4></a></li>
                <li<?php if (isset($_GET["action"])) if ($_GET["action"] == "labs") echo ' class="active">'; else echo '>'; else echo '>'; ?><a href="<?php echo $_DOMAIN; ?>labs"><h4><b><span class="glyphicon glyphicon-briefcase"></span> Labs</b></h4></a></li>
              <!-- </ul>
            </li> -->
          </ul>
          <ul class="nav navbar-nav navbar-right navbar-color"><?php // Nếu đăng nhập
          if ($user) {
            echo '
            <li>
              <form class="form-inline" action="'.$_DOMAIN.'search'.'" method="post" style="margin:17px;">
                  <input class="hidden" type="selected" name="options" value="all">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    <input class="form-control" type="text" name="Content" placeholder="Bạn cần tìm gì?">
                  </div>
                  <button class="hidden" type="submit" name="Search"><span class="glyphicon glyphicon-search"></span></button>
              </form>
            </li>';
          } ?>
          <?php // Nếu đăng nhập
          if ($user) {
            echo '
            <li';if (isset($_GET["action"])) if ($_GET["action"] == "admin") echo ' class="active">'; else echo '>'; else echo '>'; echo '<a href="'.$_DOMAIN; echo 'admin"><h4><b><span class="glyphicon glyphicon-dashboard"></span> AdminCP</b></h4></a></li>';} ?>
            <li<?php if (isset($_GET["action"])) if ($_GET["action"] == "profile") echo ' class="active">'; else echo '>'; else echo '>'; ?><a href="<?php echo $_DOMAIN; ?>profile"><h4><b><span class="glyphicon glyphicon-info-sign"></span> Profile</b></h4></a></>
            <!-- <li><a href="<?php echo $_DOMAIN; ?>#" data-toggle="modal" data-target="#loginForm"><h4><b>Đăng nhập/Đăng ký</b></h4></a></li> -->
            <li><a href="<?php echo $_DOMAIN; ?>signout"><h4><b><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</b></h4></a></li>
            <li style="margin-right:10px;"></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<!--Login Form-->
    <div id="loginForm" class="modal fade<?php if (isset($_GET["action"])) if ($_GET["action"] == "login") echo ' in'; ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"<?php if (isset($_GET["action"])) if($_GET["action"] == "login") echo ' style="display: block; padding-left: 0px; margin-top:100px;"'; ?>>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <?php if (isset($_GET["action"])) if ($_GET["action"] != "login") echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'; ?>
            <h4 class="modal-title" id="">Đăng nhập</h4>
          </div>
          <div class="modal-body">
              <form action="<?php echo $_DOMAIN; ?>login" method="post" id="sign-in-form">
                <fieldset class="form-group">
                  <label for="id">Mã số CB/SV</label>
                  <input type="text" class="form-control" name="id_login" id="id" placeholder="Nhập mã số CB/SV">
                </fieldset>
                <fieldset class="form-group">
                  <label for="password">Mật khẩu</label>
                  <input type="password" class="form-control" name="pwd_login" id="password" placeholder="Nhập mật khẩu">
                </fieldset>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="login">Đăng nhập</button>
            <!-- <button type="button" class="btn btn-warning" name="register" data-toggle="modal" data-target="#registerForm">Đăng kí</button></form> -->
            <?php if (isset($_GET["action"])) if ($_GET["action"] != "login") echo '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'; ?>
          </div>
        </div>
      </div>
    </div>

<!--Register Form-->
    <div id="registerForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">Đăng ký mới</h4>
          </div>
          <div class="modal-body">
              <form id="sign-up-form">
                <fieldset class="form-group">
                  <label for="id">Mã số CB/SV</label>
                  <input type="text" class="form-control" name="id" id="id" placeholder="Nhập mã số CB/SV">
                </fieldset>
                <fieldset class="form-group">
                  <label for="email">Địa chỉ email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Nhập email">
                  <small class="text-muted">Sử dụng email thật để khôi phục tài khoản khi có sự cố!</small>
                </fieldset>
                <fieldset class="form-group">
                  <label for="password">Mật khẩu</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu">
                </fieldset>
                <fieldset class="form-group">
                  <label for="re-password">Nhập lại mật khẩu</label>
                  <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Nhập lại mật khẩu">
                </fieldset>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="signup">Đăng ký</button></form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
