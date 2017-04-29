<a href="<?php echo $_DOMAIN; ?>admin/project" class="buttonFixed adminCP"></a>

<?php
// Nếu đăng nhập
if (!$user) new Redirect($_DOMAIN.'login'); // Tro ve trang dang nhap
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
            <tr>
                <td>1</td>
                <td>Hệ thống Theo dõi Thời tiết khoa CNTT&TT</td>
                <td>Huỳnh Quang Nghi</td-->
                <td>Tự nghiên cứu</td>
                <td>23/03/2017</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Giải pháp Điều khiển Nhà ở qua Wifi</td>
                <td>Trần Văn Hoàng</td-->
                <td>Tự nghiên cứu</td>
                <td>27/02/2017</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Hệ thống Theo dõi Môi trường Ao nuôi cá</td>
                <td>Từ Quốc Huy</td-->
                <td>Trương Minh Thái</td>
                <td>04/03/2017</td>
            </tr>
        </tbody>
    </table>
