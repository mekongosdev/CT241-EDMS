<?php

// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap

$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key=>$data){
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
} //print_r($value); //Kiểm tra hoạt động mảng $value
?>
<div class="container">
  <legend>Cài đặt chung</legend>
  <form class="form-horizontal" action="<?php echo $_DOMAIN; ?>admin/setting" method="post">
    <div class="form-group">
      <label class="control-label col-sm-3" for="nameSite">Tên trang web</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="nameSite" id="nameSite" placeholder="Nhập tên trang web"<?php echo ' value="'.$value[0].'"'; ?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="descriptionSite">Mô tả trang web</label>
      <div class="col-sm-9">
        <input type="textarea" class="form-control" name="descriptionSite" id="descriptionSite" placeholder="Nhập mô tả"<?php echo ' value="'.$value[1].'"'; ?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="keyword">Từ khóa tìm kiếm</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Nhập từ khóa, ngăn cách nhau bởi dấu phẩy."<?php echo ' value="'.$value[2].'"'; ?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="goAna">Mã theo dõi Google Analytics</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="goAna" id="goAna" placeholder="Nhập mã theo dõi của GA"<?php echo ' value="'.$value[3].'"'; ?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="footerSite">Nội dung chân trang</label>
      <div class="col-sm-9">
        <input type="textarea" class="form-control" name="footerSite" id="footerSite" placeholder="Nhập nội dung hiển thị"<?php echo ' value="'.$value[4].'"'; ?>>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="saveSetting">Lưu thiết lập</label>
      <div class="col-sm-9">
      <!--div class="col-sm-offset-2 col-sm-9"-->
        <button type="submit" class="btn btn-default btn-warning" name="saveSetting" id="saveSetting">Đồng ý</button>
      </div>
    </div>
  </form>

  <legend>Đổi icon trang web</legend>
  <form class="form-horizontal" action="<?php echo $_DOMAIN; ?>admin/setting" method="post" enctype="multipart/form-data">
    <div class="col-sm-4">
      <center>
        <!-- <img id="iconSite" class="profile-avatar" alt="your image" src="<?php //echo $_DOMAIN; ?>view/icon/<?php echo $value[5]; ?>" data-holder-rendered="true"> -->
        <img id="iconSite" class="profile-avatar" alt="your image" src="<?php echo $_DOMAIN; echo $value[5]; ?>" data-holder-rendered="true">
      </center>
    </div>
    <div class="col-sm-8">
      <div class="form-group">
        <input type="file" class="form-control" name="icon_up" id="upload" accept="image/*">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-default" name="saveIcon">Lưu ảnh</button>
      </div>
    </div>
  </form>
</div>

<script>
    function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#iconSite').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
    }

    $("#upload").change(function(){
    readURL(this);
    });
</script>

<?php
  //Luu thiet lap
  if(isset($_POST['saveSetting'])){
    $option = array();//Khoi tao mang
    //Nhan gia tri tu POST, sau do ghi vao mang
    $nameSite = $_POST['nameSite'];
    array_push($option,$nameSite);
    $descriptionSite = $_POST['descriptionSite'];
    array_push($option,$descriptionSite);
    $keyword = $_POST['keyword'];
    array_push($option,$keyword);
    $goAna = $_POST['goAna'];
    array_push($option,$goAna);
    $footerSite = $_POST['footerSite'];
    array_push($option,$footerSite);
    //Ghi tung gia tri tu mang vao CSDL
    for ($i = 1; $i <= 5; $i++)
        {
            $j = $i-1;
            $sql_update_value = "UPDATE options SET valueOption = '$option[$j]' WHERE idOption = $i";
            $qry_update = $db->query($sql_update_value);
            new Success($_DOMAIN.'admin/setting','Cập nhật thành công');
        }
      }

    // Xử Lý Upload
    if (isset($_FILES['icon_up'])) {
        $dir_img = 'view/images/';
        $name_img = stripslashes($_FILES['icon_up']['name']);
        $source_img = $_FILES['icon_up']['tmp_name'];
        $size_img = $_FILES['icon_up']['size']; // Dung lượng file

          if ($size_img > 5242880){
              new Warning('','File không được lớn hơn 5MB');
          } else {
              // Upload file
              $path_img = $dir_img.$name_img; // Đường dẫn thư mục chứa file
              move_uploaded_file($source_img, $path_img); // Upload file
              $array = (explode(".",$name_img));
              $type_img = $array[1];// Loại file
              $url_img = $path_img; // Đường dẫn file

              // Thêm ảnh vào table images
              $sql_up_file = "INSERT INTO images VALUES ('','$url_img','$type_img','$size_img','$date_current')";
              $db->query($sql_up_file);
              //Cập nhật ảnh vào table options
              $sql_update_icon = "UPDATE options SET valueOption = '$url_img' WHERE idOption = 6";
              $db->query($sql_update_icon);
              new Success($_DOMAIN.'admin/setting','Thay đổi icon thành công');
              }
          }

?>
