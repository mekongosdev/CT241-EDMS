<?php

// Require database & thông tin chung
require_once 'control/init.php';

//Chèn header
include("view/header.php");

//Chèn menu
include("view/menu.php");

//Controller
if (isset($_GET["action"])) {
	//Get Action va trả về kết quả theo ý muốn
      if ($_GET["action"] == "profile") {
        //Chèn trang profile
        include("view/profile.php");
      } else if ($_GET["action"] == "members") {
        //Chèn trang danh sach thanh vien
        include("view/members.php");
      } else if ($_GET["action"] == "profile2") {
        //Chèn trang danh sach thanh vien
        include("view/profile2.php");
      } else if ($_GET["action"] == "admin") {
        //Chèn trang quan tri admin
        include("view/admin.php");
      } else if ($_GET["action"] == "device") {
        //Chèn trang danh sach thiet bi
        include("view/device.php");
      } else if ($_GET["action"] == "project") {
        //Chèn trang danh sach du an
        include("view/project.php");
      } else if ($_GET["action"] == "contact") {
        //Chèn trang lien he
        include("view/contact.php");
      } else if ($_GET["action"] == "labs") {
        //Chèn trang lien he
        include("view/labs.php");
      } else if ($_GET["action"] == "search") {
        //Chèn trang lien he
        include("view/search.php");
      } else if ($_GET["action"] == "login") {
        //Chèn trang dang nhap
        include("view/login.php");
      } else if ($_GET["action"] == "signout") {
        //Dang xuat khoi tai khoan hien huu
        // new Redirect($_DOMAIN);
        include("view/logout.php");
      } else {
        //Chèn trang tong quan
        include("view/general.php");
      }
    } else {
  //Chèn trang tong quan
  include("view/general.php");
}

//Chèn footer
if (isset($_GET["action"])) if ($_GET["action"] == "login") echo ''; else include("view/footer.php"); else include("view/footer.php");
?>
