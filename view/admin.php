
<div>
<?php
// Nếu đăng nhập
if ($user)
{
  include("view/admin/adminCP.php");
  include("view/admin/contentCP.php");
} else new Redirect($_DOMAIN.'login'); // Trở về trang index
?>
</div>
