<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);?>

<?php
  echo "<h4>Chào mừng đến với AdminCP. Vui lòng chọn chức năng ở bảng điều khiển. Thân mến!</h4>";
?>
