<?php

// Require các thư viện PHP
require_once 'control/DB.php';
require_once 'control/Session.php';
require_once 'control/Function.php';
require 'control/pagination.php';

// Kết nối database
$db = new DB();
$db->connect();
$db->set_char('utf8');

// Thông tin chung
// $_DOMAIN = 'http://admin.dev/demo_ptycpm/';
$_DOMAIN = 'http://192.168.0.187/demo_ptycpm/';


date_default_timezone_set('Asia/Ho_Chi_Minh');
$date_current = '';
$date_current = date("Y-m-d H:i:sa");
$day_current = substr($date_current, 8, 2);
$month_current = substr($date_current, 5, 2);
$year_current = substr($date_current, 0, 4);
$hour_current = substr($date_current, 11, 2);
$minute_current = substr($date_current, 14, 2);
$second_current = substr($date_current, 17, 2);
$am_to_pm_current = substr($date_current, 19, 2);

//Get giá trị limit mượn thiết bị
$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key => $data) {
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
}
$limitBorrow = $value[6];

//Get giá trị avatar mặc định
$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key => $data) {
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
}
$avatarDefault = $value[7];

//Get giá trị icon mặc định
$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key => $data) {
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
}
$iconDefault = $value[8];

//Get giá trị img thiết bị mặc định
$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key => $data) {
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
}
$imgDeviceDefault = $value[9];

// Khởi tạo session
$session = new Session();
$session->start();

// Kiểm tra session

if ($session->get() != '')
{
    $user = $session->get();
}
else
{
    $user = '';
}

// Nếu đăng nhập
if ($user)
{
    // Lấy dữ liệu tài khoản
    $sql_get_data_user = "SELECT * FROM user_auth INNER JOIN user_info ON user_auth.idUser = user_info.idUser WHERE user_auth.idUser = '$user'";
    if ($db->num_rows($sql_get_data_user))
    {
        $data_user = $db->fetch_assoc($sql_get_data_user, 1);
    }
}

//Get quyền truy cập
$role_qry="SELECT rolesGroup FROM user_auth INNER JOIN roles_cp ON user_auth.roleName = roles_cp.roleName WHERE user_auth.idUser = '$user'";
if($db->num_rows($role_qry))
{
    foreach ($db->fetch_assoc($role_qry, 1) as $key=>$value) {
      $roleUser=explode(',',$value);
    }
}


?>
