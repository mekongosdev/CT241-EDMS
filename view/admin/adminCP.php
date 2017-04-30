<!--Admin Panel-->
<div class="col-md-3 sidebar">
    <ul class="list-group">
        <li class="list-group-item">
            <div class="media">
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $data_user['fullName']; ?></h4>
                    <!-- <span class="label label-danger">Chủ sở hữu</span> -->
                    <?php

                    // Hiển thị cấp bậc tài khoản
                    // Nếu tài khoản là admin
                    switch ($data_user['rolesName']) {
                      case 'Owner':
                          echo '<span class="label label-danger">Chủ sở hữu</span>';
                          break;
                      case 'Admin':
                          echo '<span class="label label-primary">Quản trị viên</span>';
                          break;
                      case 'Manager':
                          echo '<span class="label label-primary">Quản lý</span>';
                          break;
                      case 'Member':
                          echo '<span class="label label-primary">Thành viên</span>';
                          break;
                      default:
                          echo '<span class="label label-primary">Thành viên</span>';
                          break;
                    }

                    ?>
                </div>
            </div>
        </li>
        <a class="list-group-item <?php if (isset($_GET["tab"])) if ($_GET["tab"] == "dashboard") echo ' active'; else echo ''; else echo ' active'; ?>" href="<?php echo $_DOMAIN; ?>admin/dashboard">
            <span class="glyphicon glyphicon-dashboard"></span> Bảng điều khiển
        </a>

        <div class="dropdown">
            <button class="list-group-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="glyphicon glyphicon-list-alt"></i> Thao tác quản lý
            </button>
            <ul class="dropdown-menu">
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "device") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/device">
                        <span class="glyphicon glyphicon-list-alt"></span> Quản lý thiết bị
                    </a>
                </li>
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "members") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/members">
                        <span class="glyphicon glyphicon-user"></span> Quản lý thành viên
                    </a>
                </li>
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "account") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/account">
                        <span class="glyphicon glyphicon-lock"></span> Quản lý tài khoản
                    </a>
                </li>
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "labs") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/labs">
                        <span class="glyphicon glyphicon-list-alt"></span> Quản lý Labs
                    </a>
                </li>
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "project") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/project">
                        <span class="glyphicon glyphicon-list-alt"></span> Quản lý dự án
                    </a>
                </li>
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "partner") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/producer">
                        <span class="glyphicon glyphicon-list-alt"></span> Quản lý nhà cung cấp/sản xuất
                    </a>
                </li>
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "images") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/images">
                        <span class="glyphicon glyphicon-picture"></span> Quản lý hình ảnh
                    </a>
                </li>
            </ul>
        </div>

        <a class="list-group-item <?php if (isset($_GET["tab"])) if ($_GET["tab"] == "borrow") echo ' active'; else echo ''; else echo ''; ?>" href="<?php echo $_DOMAIN; ?>admin/borrow">
            <span class="glyphicon glyphicon-check"></span> Mượn thiết bị
        </a>

        <a class="list-group-item <?php if (isset($_GET["tab"])) if ($_GET["tab"] == "roles") echo ' active'; else echo ''; else echo ''; ?>" href="<?php echo $_DOMAIN; ?>admin/roles">
            <span class="glyphicon glyphicon-sort"></span> Phân quyền
        </a>

        <div class="dropdown">
            <button class="list-group-item dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="glyphicon glyphicon-list-alt"></i> Cài đặt
            </button>
            <ul class="dropdown-menu">
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "setting") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/setting">
                        <span class="glyphicon glyphicon-cog"></span> Cài đặt chung
                    </a>
                </li>
                <li<?php if (isset($_GET["tab"])) if ($_GET["tab"] == "rolesCP") echo ' class="active"'; else echo ''; else echo ''; ?>>
                    <a href="<?php echo $_DOMAIN; ?>admin/rolesCP">
                        <span class="glyphicon glyphicon-cog"></span> Cài đặt phân quyền
                    </a>
                </li>
            </ul>
        </div>

        <?php

        // Phân quyền sidebar
        // Nếu tài khoản là admin
        // if ($data_user['rolesName'] == 'Owner')
        // {
        //     echo
        //     '
        //         <a class="list-group-item" href="' . $_DOMAIN . 'categories">
        //             <span class="glyphicon glyphicon-tag"></span> Chuyên mục
        //         </a>
        //         <a class="list-group-item" href="' . $_DOMAIN . 'setting">
        //             <span class="glyphicon glyphicon-cog"></span> Cài đặt chung
        //         </a>
        //     ';
        // }

        ?>
        <a class="list-group-item" href="<?php echo $_DOMAIN; ?>signout">
            <span class="glyphicon glyphicon-off"></span> Thoát
        </a>
    </ul><!-- ul.list-group -->
</div><!-- div.sidebar -->
