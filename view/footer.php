<?php
$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key => $data) {
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
} //print_r($value); Kiểm tra hoạt động mảng $value
?>
    <div class="header clearfix"></div>
      <div class="footer div-center"><?php echo $value[4]; ?></div>
</body>
</html>
