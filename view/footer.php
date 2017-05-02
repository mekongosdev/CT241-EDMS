<?php
$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key => $data) {
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
} //print_r($value); Kiểm tra hoạt động mảng $value
?>
    <div class="header clearfix"></div>
      <div class="footer div-center"><?php echo $value[5]; ?></div>
</body>
<script>
var i = 0;
for (i = 0; i < 100; i++){
  console.log('%cDừng lại!', 'color: red; font-size: 50px; font-family: sans-serif; text-shadow: 1px 1px 5px #000;');
  console.log('%cCó vẻ như bạn đang cố tình hack website của chúng tôi!', 'color: #444; font-size: 25px; font-family: sans-serif;');
  console.log('%cTruy cập https://www.fb.com/selfxss để biết thêm thông tin chi tiết.', 'color: #444; font-size: 25px; font-family: sans-serif;');
}
</script>
</html>
