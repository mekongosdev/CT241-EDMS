<?php

//Nút trang chủ
function btn_home() {
    return '<a href="index.php" class="buttonFixed homeBrg"></a>';
}

// Hàm điều hướng trang
class Redirect {
    public function __construct($url = null) {
        if ($url)
        {
            echo '<script>location.href="'.$url.'";</script>';
        }
    }
}

//Hàm click to call
function callPhone($phoneNumber) {
    return '<a href="tel:'.$phoneNumber.'">'.$phoneNumber.'</a>';
}


?>
