

<table id="infoDevice" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Họ tên</th>
                <th>Thiết bị</th>
                <th>Ngày mượn</th>
                <th>Ngày trả</th>
                <th>Quản lý</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>001</td>
                <td>Lê Minh Luân</td>
                <td>Relay 4 kênh</td>
                <td>20/03/2017</td>
                <td>24/03/2017</td>
                <td>---</td>
            </tr>
            <tr>
                <td>002</td>
                <td>Huỳnh Quang Nghi</td>
                <td>Arduino UNO R3</td>
                <td>20/03/2017</td>
                <td>---</td>
                <td>
                  <button type="button" id="ok" class="btn btn-primary"><span class="glyphicon glyphicon-repeat"></span></button>
                </td>
            </tr>
            <tr>
                <td>003</td>
                <td>Trương Minh Thái</td>
                <td>ESP8266</td>
                <td>---</td>
                <td>---</td>
                <td>
                  <button type="button" id="ok" class="btn btn-primary" data-toggle="modal" data-target="#requestDevice"><span class="glyphicon glyphicon-refresh"></span></button>
                </td>
            </tr>
            <tr>
                <td>004</td>
                <td>Trần Văn Hoàng</td>
                <td>Sensor hồng ngoại</td>
                <td>20/03/2017</td>
                <td>24/03/2017</td>
                <td>---</td>
            </tr>
        </tbody>
    </table>

<!--Modal phân quyền-->
<div id="requestDevice" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">Yêu cầu mượn</h4>
            </div>
            <div class="modal-body">
                <h4>Cho phép mượn thiết bị?</h4>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Yes</a></form>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
