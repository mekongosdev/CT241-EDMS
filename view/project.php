<a href="<?php echo $_DOMAIN; ?>admin/project" class="buttonFixed adminCP"></a>

<?php
// Nếu chưa đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
new Role($roleUser);
?>
    <legend>
        <h1>Danh sách Dự án</h1></legend>
    <table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Tên dự án</th>
                <th>Chủ nhiệm</th>
                <th>Hướng dẫn</th>
                <th>Khởi động</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $sql_get_user = "SELECT * FROM project_info ORDER BY idProject DESC";
          if ($db->num_rows($sql_get_user)) {
              $row="SELECT idProject FROM project_info";
              $row_per_page=10;
              $rows=$db->num_rows($row);
              if ($rows>$row_per_page) $page=ceil($rows/$row_per_page);
              else $page=1;
              if(isset($_GET['tab']) && (int)$_GET['tab'])
                   $start=($_GET['tab']-1)*$row_per_page; //dòng bắt đầu từ nơi ta muốn lấy
              else $start=0;
              // var_dump($start);
              $val = "SELECT *,DATE_FORMAT( dateStart,  '%d/%m/%Y' ) AS date FROM project_info ORDER BY idProject ASC limit $start,$row_per_page";

              foreach ($db->fetch_assoc($val, 0) as $key => $row) {
                echo '<tr>
                    <td>'.$row['idProject'].'</td>
                    <td>'.$row['nameProject'].'</td>
                    <td>'.$row['nameUser'].'</td>
                    <td>'.$row['nameStaff'].'</td>
                    <td>'.$row['date'].'</td>
                </tr>';
              }
          } else {
              echo '<br><br><div class="alert alert-info">Chưa có dự án nào.</div>';
          }
          ?>
        </tbody>
    </table>

<div class="container">
<?php
$row="SELECT idProject FROM project_info";
$rows=$db->num_rows($row);
$config = array(
    'current_page'  => isset($_GET['tab']) ? $_GET['tab'] : 1, // Trang hiện tại
    'total_record'  => $rows, // Tổng số record
    'limit'         => 10,// limit
    'link_full'     => $_DOMAIN.'project/{page}',// Link full có dạng như sau: domain/com/page/{page}
    'link_first'    => $_DOMAIN.'project',// Link trang đầu tiên
    'range'         => 3 // Số button trang bạn muốn hiển thị
);

$paging = new Pagination();

$paging->init($config);

echo $paging->html();
?>
</div>
