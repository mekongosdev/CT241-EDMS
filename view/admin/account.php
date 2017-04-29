<?php

// Nếu đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap

// // Nếu đăng nhập
// if ($user)
// {
    // Nếu tài khoản là tác giả
    // if ($data_user['position'] == 0)
    // {
    //     echo '<div class="alert alert-danger">Bạn không có đủ quyền để vào trang này.</div>';
    // }
    // Ngược lại tài khoản là admin
    // else if ($data_user['position'] == 1)
    // {
        echo '<h3>Tài khoản</h3>';
        // Lấy tham số ac
        if (isset($_GET['act']))
        {
            $act = trim(addslashes(htmlspecialchars($_GET['act'])));
        }
        else
        {
            $act = '';
        }

        // Lấy tham số id
        if (isset($_GET['id']))
        {
            $id = trim(addslashes(htmlspecialchars($_GET['id'])));
        }
        else
        {
            $id = '';
        }

        // Nếu có tham số ac
        if ($act != '')
        {
            // Trang thêm tài khoản
            if ($act == 'add')
            {
                // Dãy nút của thêm tài khoản
                echo
                '
                    <a href="' . $_DOMAIN . 'admin/account" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span> Trở về
                    </a>
                ';

                // Content thêm tài khoản
                echo '
                    <p class="form-add-acc">
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label>Tên đăng nhập</label>
                                <input type="text" name="id_user" class="form-control title" placeholder="Nhập tên đăng nhập">
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" name="pwd" class="form-control title" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" name="re-pwd" class="form-control title" placeholder="Nhập lại mật khẩu">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control title" placeholder="Nhập email">
                            </div><div class="form-group">
                                <label>Phân quyền</label>
                                <select class="form-control" name="role">
                                  ';
                                $sql_get_role = "SELECT * FROM roles_cp";
                                foreach ($db->fetch_assoc($sql_get_role, 0) as $key=>$data) {
                                  echo '<option value="'.$data['roleName'].'">'.$data['roleName'].'</option>
                                  ';
                              } echo '</select>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="add_account" class="btn btn-primary">Thêm</button>
                            </div>
                            <div class="alert alert-danger hidden"></div>
                        </form>
                    </p>
                ';

                //Them tai khoan
                if (isset($_POST['add_account'])){
                  $id_user = $_POST['id_user'];
                  $pwd = $_POST['pwd'];
                  $re_pwd = $_POST['re-pwd'];
                  $email = $_POST['email'];
                  $role = $_POST['role'];

                  if ($pwd != $re_pwd) {
                    echo '<div class="alert alert-warning">Mật khẩu không trùng khớp</div>';
                  }
                  if ($role == 'Owner') {
                    echo '<div class="alert alert-warning">Chỉ có duy nhất một Chủ sở hữu - Owner</div>';
                  }
                  if (!$id_user || !$pwd || !$email){
                    echo '<div class="alert alert-warning">Vui lòng nhập đầy đủ thông tin</div>';
                  }
                  if ($id_user && $pwd == $re_pwd && $email && $role != 'Owner') {
                    $sql_update_value = "INSERT INTO `user_auth`(`idUser`, `pwd`, `email`, `rolesName`, `status`) VALUES ('$id_user','$pwd','$email','$role',1)";
                    $qry_update = $db->query($sql_update_value);
                    new Redirect($_DOMAIN.'admin/members');
                  }
                }
            }
        }
        // Ngược lại không có tham số ac
        // Trang danh sách tài khoản
        else
        {
            // Dãy nút của danh sách tài khoản
            echo
            '
                <a href="' . $_DOMAIN . 'admin/account/add" class="btn btn-default">
                    <span class="glyphicon glyphicon-plus"></span> Thêm
                </a>
                <a href="' . $_DOMAIN . 'admin/account" class="btn btn-default">
                    <span class="glyphicon glyphicon-repeat"></span> Reload
                </a>
                <a class="btn btn-warning" id="lock_acc_list">
                    <span class="glyphicon glyphicon-lock"></span> khoá
                </a>
                <a class="btn btn-success" id="lock_acc_list">
                    <span class="glyphicon glyphicon-lock"></span> Mở khoá
                </a>
                <a class="btn btn-danger" id="del_acc_list">
                    <span class="glyphicon glyphicon-trash"></span> Xoá
                </a>
            ';

            // Content danh sách tài khoản
$sql_get_list_acc = "SELECT * FROM user_auth ORDER BY idUser ASC";
// Nếu có tài khoản
if ($db->num_rows($sql_get_list_acc))
{
    echo
    '
        <br><br>
        <div class="table-responsive">
            <table class="table table-striped list" id="list_cate">
                <tr>
                    <td><input type="checkbox"></td>
                    <td><strong>ID</strong></td>
                    <td><strong>Tên đăng nhập</strong></td>
                    <td><strong>Trạng thái</strong></td>
                    <td><strong>Tools</strong></td>
                </tr>
    ';

    // In danh sách tài khoản
    foreach ($db->fetch_assoc($sql_get_list_acc, 0) as $key => $data_acc)
    {
        // Trạng thái tài khoản
        if ($data_acc['status'] == 1) {
            $stt_acc = '<label class="label label-success">Hoạt động</label>';
        } else if ($data_acc['status'] == 0) {
            $stt_acc = '<label class="label label-warming">Khoá</label>';
        }

        echo
        '
            <tr>
                <td><input type="checkbox" name="id_acc[]" value="' . $data_acc['idUser'] .'"></td>
                <td>' . $data_acc['idUser'] .'</td>
                <td>' . $data_acc['email'] . '</td>
                <td>' . $stt_acc . '</td>
                <td>
                    <a data-id="' . $data_acc['idUser'] . '" class="btn btn-sm btn-warning">
                        <span class="glyphicon glyphicon-lock"></span>
                    </a>
                    <a data-id="' . $data_acc['idUser'] . '" class="btn btn-sm btn-success">
                        <span class="glyphicon glyphicon-lock"></span>
                    </a>
                    <a data-id="' . $data_acc['idUser'] . '" class="btn btn-sm btn-danger">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        ';
    }

    echo
    '
            </table>
        </div>
    ';
}
// Nếu không có tài khoản
else
{
    echo '<br><br><div class="alert alert-info">Chưa có tài khoản nào.</div>';
}
        }
//     }
// }
// // Ngược lại chưa đăng nhập
// else
// {
//     new Redirect($_DOMAIN); // Trở về trang index
// }

?>
