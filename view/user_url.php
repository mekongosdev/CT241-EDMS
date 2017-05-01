<?php

// Nếu đăng nhập
// if ($user) {
//   new Redirect($_DOMAIN); // Tro ve trang dang nhap
// } else isset($_GET['tab']) ? $_GET['tab'] : '';
//
//   $url = $_GET['tab'];
//   $array = array();
//
//   $sql_get_user = "SELECT idUser FROM user_auth";
//   foreach ($db->fetch_assoc($sql_get_user,0) as $key => $imp) {
//     array_push($array,($url == sha1(md5($imp['idUser']))) ? $user_login = $imp['idUser'] : $user_login = 'wrong');
//   }
//   $id = str_replace( 'wrong', '', implode('', $array));
//   // echo $id;
//   if ($id) {
//     $sql_check_stt = "SELECT idUser,status FROM user_auth WHERE idUser = '$id' AND status = 1";
//     // Nếu username và password khớp và tài khoản không bị khoá (status = 1)
//     if ($db->num_rows($sql_check_stt)) {
//           // Lưu session
//           $session->send($id);
//           // $db->close(); // Giải phóng
//
//           new Success($_DOMAIN,'Đăng nhập thành công'); // Trở về trang index
//           // new Success('','Đăng nhập thành công'); // Trở về trang index
//     } else {
//         new Warning('','Tài khoản của bạn đã bị khoá, vui lòng liên hệ quản trị viên để biết thêm thông tin chi tiết');
//     }
//   } else new Warning('','Có lỗi xảy ra, vui lòng liên hệ quản trị viên để biết thêm thông tin chi tiết');

//Test link
// Test_URL: http://192.168.0.102/demo_ptycpm/user_url/7f954d00890af2c2c15e5be712fff271b17d6489 //Mã hóa với MD5 và SHA1

// $a = '574525485';

echo Hash_Encrypt('ada5d5ad');

?>
