<?php
// Nếu chưa đăng nhập
if (!$user) {
  new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
}
if (requestRole($roleUser,'dashboard') == 0) {
  new Redirect($_DOMAIN);
}
?>

<?php
  echo "<h4>Chào mừng đến với AdminCP. Vui lòng chọn chức năng ở bảng điều khiển. Thân mến!</h4>";
?>
