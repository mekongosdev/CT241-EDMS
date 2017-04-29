<div class="col-md-9 content">
    <?php
if (isset($_GET["tab"])) {
	//Get tab va trả về kết quả theo ý muốn
      if ($_GET["tab"] == "dashboard") {
        include("view/admin/dashboard.php");
      } else if ($_GET["tab"] == "members") {
        //Chèn trang quan ly thanh vien
        include("view/admin/membersCP.php");
      } else if ($_GET["tab"] == "account") {
        //Chèn trang quan ly tai khoan
        include("view/admin/account.php");
      } else if ($_GET["tab"] == "device") {
        //Chèn trang quan ly thiet bi
        include("view/admin/deviceCP.php");
      } else if ($_GET["tab"] == "project") {
        //Chèn trang quan ly du an
        include("view/admin/projectCP.php");
      } else if ($_GET["tab"] == "producer") {
        //Chèn trang quan ly doi tac
        include("view/admin/producerCP.php");
      } else if ($_GET["tab"] == "roles") {
        //Chèn trang quan ly quyen
        include("view/admin/rolesCP.php");
      } else if ($_GET["tab"] == "rolesCP") {
        //Chèn trang quan ly quyen
        include("view/admin/rolesAD.php");
      } else if ($_GET["tab"] == "setting") {
        //Chèn trang quan ly quyen
        include("view/admin/settingCP.php");
      } else if ($_GET["tab"] == "labs") {
        //Chèn trang quan ly quyen
        include("view/admin/labsCP.php");
      } else if ($_GET["tab"] == "images") {
        //Chèn trang quan ly hinh anh
        include("view/admin/imagesCP.php");
      } else if ($_GET["tab"] == "contentRole") {
        //Chèn trang quan ly quyen
        include("view/admin/contentRoleCP.php");
      } else if ($_GET["tab"] == "borrow") {
        //Chèn trang quan ly muon thiet bi
        include("view/admin/borrowDeviceCP.php");
      } else {
        include("view/admin/dashboard.php");
      }
    } else {
  include("view/admin/dashboard.php");
}
    ?>
</div><!-- div.content -->
