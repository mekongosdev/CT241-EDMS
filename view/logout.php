<?php
// Nếu đăng nhập
if ($user)
{
  // Xoá session
  $session->destroy();
  new Success($_DOMAIN.'login','Đăng xuất thành công'); // Trở về trang dang nhap
} else new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>
