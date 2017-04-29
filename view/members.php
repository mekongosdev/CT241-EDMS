<a href="<?php echo $_DOMAIN; ?>admin/members" class="buttonFixed adminCP"></a>
<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>
  <div><br  /></div>

  <div class="row" style="margin: 0 50px 0 50px;">
    <center>
            <?php
            $sql_get_user = "SELECT * FROM user_info ORDER BY idUser DESC";
            if ($db->num_rows($sql_get_user)) {
                $row="SELECT idUser FROM user_info";
                $row_per_page=10;
                $rows=$db->num_rows($row);
                if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
                else $page=1;
                if(isset($_GET['page']) && (int)$_GET['page'])
                     $start=($_GET['page']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
                else $start=0;
                // var_dump($start);
                $val = "SELECT * FROM user_info a,user_auth b,images c WHERE (a.idUser = b.idUser) AND (a.idImg = c.idImg) ORDER BY a.idUser ASC limit $start,$row_per_page";
                $retval = $db->query($val);


                foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                  echo '<div class="col-md-2">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <img src="'.$_DOMAIN.$row['url'].'" alt="User" style="width:150px;height:150px;">
                      </div>
                      <div class="panel-body">
                        <span>'.$row['idUser'].'</span><br />
                        <span>'.$row['fullName'].'</span><br />
                        <span>'.$row['rolesName'].'</span><br />
                        <span><a href="'.$_DOMAIN.'profile/'.$row['idUser'].'">Chi tiết</a></span>
                      </div>
                    </div>
                  </div>';
                }
            } else {
                echo '<br><br><div class="alert alert-info">Chưa có thành viên nào.</div>';
            }
            ?>
          </center>
        </div>

      <div class="container">
  <?php
  $row="SELECT idUser FROM user_info";
  $rows=$db->num_rows($row);
  $config = array(
      'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1, // Trang hiện tại
      'total_record'  => $rows, // Tổng số record
      'limit'         => 10,// limit
      'link_full'     => '?action=history&page={page}',// Link full có dạng như sau: domain/com/page/{page}
      'link_first'    => '?action=history',// Link trang đầu tiên
      'range'         => 3 // Số button trang bạn muốn hiển thị
  );

  $paging = new Pagination();

  $paging->init($config);

  echo $paging->html();
  ?>
