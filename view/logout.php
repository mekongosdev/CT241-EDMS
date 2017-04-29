<?php
// Nếu đăng nhập
if ($user)
{
  // Xoá session
  $session->destroy();
  new Redirect($_DOMAIN); // Trở về trang index
} else new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>
