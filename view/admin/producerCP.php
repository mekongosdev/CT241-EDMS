<a href="#" class="buttonFixed addBrg" data-toggle="modal" data-target="#addProducer"></a>

<table id="infoProducer" class="table table-striped">
        <thead>
            <tr>
                <th>Mã số</th>
                <th>Nhà cung cấp/sản xuất</th>
                <th>Dịch vụ</th>
                <th>Điện thoại</th>
                <th>Email</th>
                <th>Quản lý</th>
            </tr>
        </thead>
        <tbody>
          <?php
          $val = "SELECT * FROM partner_info";
          $retval = $db->query($val);

          foreach ($db->fetch_assoc($val, 0) as $key => $row) {
            echo '<tr>
                <td>'.$row['idProducer'].'</td>
                <td>'.$row['nameProducer'].'</td>
                <td>'.$row['service'].'</td>
                <td>'.$row['phone'].'</td>
                <td>'.$row['email'].'</td>
                <td><a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProducer"><span class="glyphicon glyphicon-pencil"></span></a></td>
            </tr>';
          } //<td><a href="?action=transaction-edit&id='.$row['id'].'"><span class="glyphicon glyphicon-pencil"></span></a></td>
          ?>
        </tbody>
    </table>

    <div id="addProducer" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Thêm đối tác</h4>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                      <fieldset class="form-group">
                          <label for="producerName">Tên đối tác</label>
                          <input type="text" class="form-control" name="producerName" id="producerName" placeholder="Nhập tên đối tác">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="serviceProducer">Dịch vụ</label>
                          <input type="text" class="form-control" name="serviceProducer" id="serviceProducer" placeholder="Loại dịch vụ cung cấp?">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="phoneProducer">Điện thoại</label>
                          <input type="number" class="form-control" name="phoneProducer" id="phoneProducer" placeholder="Nhập số điện thoại">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="addressProducer">Địa chỉ</label>
                          <input type="text" class="form-control" name="addressProducer" id="addressProducer" placeholder="Nhập địa chỉ">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="mailProducer">Email</label>
                          <input type="mail" class="form-control" name="mailProducer" id="mailProducer" placeholder="Nhập email">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_Producer" class="btn btn-primary">Thêm</button></form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id="editProducer" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Chỉnh sửa đối tác</h4>
                </div>
                <div class="modal-body">
                    <form>
                      <fieldset class="form-group">
                          <label for="ProducerName">Tên đối tác</label>
                          <input type="text" class="form-control" name="ProducerName" id="ProducerName" placeholder="Nhập tên đối tác">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="serviceProducer">Dịch vụ</label>
                          <input type="text" class="form-control" name="serviceProducer" id="serviceProducer" placeholder="Loại dịch vụ cung cấp?">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="phoneProducer">Điện thoại</label>
                          <input type="number" class="form-control" name="phoneProducer" id="phoneProducer" placeholder="Nhập số điện thoại">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="addressProducer">Địa chỉ</label>
                          <input type="text" class="form-control" name="addressProducer" id="addressProducer" placeholder="Nhập địa chỉ">
                      </fieldset>
                      <fieldset class="form-group">
                          <label for="mailProducer">Email</label>
                          <input type="mail" class="form-control" name="mailProducer" id="mailProducer" placeholder="Nhập email">
                      </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteProducer">Xóa</button>
                    <button type="submit" class="btn btn-primary">Đồng ý</button></form>
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div id="deleteProducer" class="modal fade" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">Bạn đang xóa đối tác!</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Bạn có muốn tiếp tục?</strong></p>
                    <form>
                        <div class="modal-footer">
                            <a href="delete" type="button" class="btn btn-danger">Yes</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                </div>
            </div>
        </div>
    </div> -->

    <?php
    //Thêm thiết bị
      if(isset($_POST['add_Producer'])){
        $producerName = addslashes($_POST['producerName']);
        $serviceProducer = addslashes($_POST['serviceProducer']);
        $phoneProducer = $_POST['phoneProducer'];
        $addressProducer = addslashes($_POST['addressProducer']);
        $mailProducer = addslashes($_POST['mailProducer']);
        if($ProducerName && $serviceProducer && $phoneProducer && $addressProducer && $mailProducer)
           {
             $sql="INSERT INTO partner_info(nameProducer, service, address, phone, email) VALUES ('{$producerName}', '{$serviceProducer}', '{$addressProducer}', '{$phoneProducer}', '{$mailProducer}')";
             $query = $db->query($sql);
             echo "<script>alert('Thêm giao dịch thành công!')</script>";
          } else echo "<script>alert('Vui lòng nhập trường còn bỏ trống')</script>";
        }
    ?>
