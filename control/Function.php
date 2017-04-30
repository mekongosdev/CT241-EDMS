<?php

//Nút trang chủ
// function btn_home() {
//     return '<a href="index.php" class="buttonFixed homeBrg"></a>';
// }

// Hàm điều hướng trang
class Redirect {
    public function __construct($url = null) {
        if ($url)
        {
            echo '<script>location.href="'.$url.'";</script>';
        }
    }
}

// Hàm làm mới trang
class Reload {
    public function __construct($url = null) {
        if ($url)
        {
            echo '<script type="text/javascript">
            setTimeout(function () {
               window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
            </script>';
        }
    }
}

// Hàm thông báo công việc thành công
class Success {
    public function __construct($url = null,$alert = null) {
        if ($url) {
          if ($alert) {
            echo '<div class="alert alert-success">'.$alert.'</div>
              <script type="text/javascript">
              setTimeout(function () {
                 window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
              }, 2000); //will call the function after 2 secs.
              </script>';
          } else echo '<div class="alert alert-success">Thành công</div>
            <script type="text/javascript">
            setTimeout(function () {
               window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
            </script>';
        } else if ($alert) {
          echo '<div class="alert alert-success" id="Success">'.$alert.'</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#Success').fadeOut(2000);
          }, 2000);
          </script>";
        } else echo '<div class="alert alert-success" id="Success">Thành công</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#Success').fadeOut(2000);
          }, 2000);
          </script>";
    }
}

// Hàm cảnh báo một việc làm nào đó
class Warning {
    public function __construct($url = null,$alert = null) {
        if ($url) {
          if ($alert) {
            echo '<div class="alert alert-warning">'.$alert.'</div>
              <script type="text/javascript">
              setTimeout(function () {
                 window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
              }, 2000); //will call the function after 2 secs.
              </script>';
          } else echo '<div class="alert alert-warning">Cảnh báo</div>
            <script type="text/javascript">
            setTimeout(function () {
               window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
            </script>';
        } else if ($alert) {
          echo '<div class="alert alert-warning" id="warning">'.$alert.'</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#warning').fadeOut(2000);
          }, 2000);
          </script>";
        } else echo '<div class="alert alert-warning" id="warning">Cảnh báo</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#warning').fadeOut(2000);
          }, 2000);
          </script>";
    }
}

// Hàm cảnh báo nguy hiểm
class Danger {
    public function __construct($url = null,$alert = null) {
        if ($url) {
          if ($alert) {
            echo '<div class="alert alert-danger">'.$alert.'</div>
              <script type="text/javascript">
              setTimeout(function () {
                 window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
              }, 2000); //will call the function after 2 secs.
              </script>';
          } else echo '<div class="alert alert-danger">Nguy hiểm</div>
            <script type="text/javascript">
            setTimeout(function () {
               window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
            </script>';
        } else if ($alert) {
          echo '<div class="alert alert-danger" id="danger">'.$alert.'</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#danger').fadeOut(2000);
          }, 2000);
          </script>";
        } else echo '<div class="alert alert-danger" id="danger">Nguy hiểm</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#danger').fadeOut(2000);
          }, 2000);
          </script>";
    }
}

// Hàm thông báo một mẩu tin
class Info {
    public function __construct($url = null,$alert = null) {
        if ($url) {
          if ($alert) {
            echo '<div class="alert alert-info">'.$alert.'</div>
              <script type="text/javascript">
              setTimeout(function () {
                 window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
              }, 2000); //will call the function after 2 secs.
              </script>';
          } else echo '<div class="alert alert-info">Thông tin</div>
            <script type="text/javascript">
            setTimeout(function () {
               window.location.href = "'.$url.'"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
            </script>';
        } else if ($alert) {
          echo '<div class="alert alert-info" id="info">'.$alert.'</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#info').fadeOut(2000);
          }, 2000);
          </script>";
        } else echo '<div class="alert alert-info" id="info">Thông tin</div>
          <script type="text/javascript">'."
          setTimeout(function() {
              $('#info').fadeOut(2000);
          }, 2000);
          </script>";
    }
}

?>
