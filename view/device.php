<a href="<?php echo $_DOMAIN; ?>admin/device" class="buttonFixed adminCP"></a>

<?php
// Nếu đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
?>
    <legend>
        <h1>Danh sách Thiết bị Nhúng</h1></legend>
        <table id="infoDevice" class="table table-striped">
                <thead>
                    <tr>
                        <th>Mã số</th>
                        <th>Hình ảnh</th>
                        <th>Tên thiết bị</th>
                        <th>Mô tả</th>
                        <th>Ngày nhập</th>
                        <th>Trạng thái</th>
                        <th>Số lượng</th>
                        <th>Chỉnh sửa</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $sql_get_user = "SELECT * FROM device_info ORDER BY idDevice DESC";
                  if ($db->num_rows($sql_get_user)) {
                      $row="SELECT idDevice FROM device_info";
                      $row_per_page=10;
                      $rows=$db->num_rows($row);
                      if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
                      else $page=1;
                      if(isset($_GET['page']) && (int)$_GET['page'])
                           $start=($_GET['page']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
                      else $start=0;
                      // var_dump($start);
                      $val = "SELECT *,DATE_FORMAT( dateImport,  '%d/%m/%Y' ) AS date FROM device_info a,partner_info b,images c WHERE (a.idProducer = b.idProducer) AND (a.idImg = c.idImg) ORDER BY a.idDevice ASC limit $start,$row_per_page";
                      $retval = $db->query($val);

                      foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                        echo '<tr>
                            <td>'.$row['idDevice'].'</td>
                            <td><img src="';echo $_DOMAIN.$row['url']; echo '" style="width:100px;height:100px;"/></td>
                            <td>'.$row['nameDevice'].'</td>
                            <td>'.$row['description'].'</td>
                            <td>'.$row['date'].'</td>
                            <td>'.$row['status'].'</td>
                            <td>'.$row['total'].'</td>
                            <td>
                                <button type="button" id="borrowDevice2" class="btn btn-primary" data-toggle="modal" data-target="#borrowDevice"><span class="glyphicon glyphicon-bookmark"></span></button>
                            </td>
                        </tr>';
                      }
                  } else {
                      echo '<br><br><div class="alert alert-info">Chưa có thiết bị nào.</div>';
                  }
                  ?>
                </tbody>
            </table>

            <div class="container">
        <?php
        $row="SELECT idDevice FROM device_info";
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


    <div id="borrowDevice" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Bạn muốn mượn thiết bị?</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Vui lòng đăng ký và chờ!</strong></p>
                    <form>
                        <div class="modal-footer">
                            <a href="borrow" type="button" class="btn btn-primary">Yes</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
