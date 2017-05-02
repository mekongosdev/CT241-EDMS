<?php
$sql_get_setting = "SELECT * FROM options ";
$value = array();//Khởi tạo mảng của biến $value
foreach ($db->fetch_assoc($sql_get_setting, 0) as $key=>$data){
  array_push($value,$data['valueOption']);//Push từng giá trị mới vào mảng cho đến khi dùng vòng lặp
} //print_r($value); Kiểm tra hoạt động mảng $value
?>
<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta http-equiv="content-Type" content="text/html; charset=utf-8">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title><?php echo $value[1]; ?></title>
    <meta name="description" content="<?php echo $value[2]; ?>">
    <meta name="keywords" content="<?php echo $value[3]; ?>">
    <meta property="og:title" content="<?php echo $value[1]; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo $_DOMAIN; echo $value[0]; ?>" />
    <meta property="og:description" content="<?php echo $value[1]; ?>" />
    <meta property="og:url" content="<?php echo $_DOMAIN; ?>" />
    <link rel="canonical" href="<?php echo $_DOMAIN; echo $value[0]; ?>" />
    <meta property="og:site_name" content="<?php echo $_DOMAIN; ?>" />
    <meta name="robots" content="INDEX, FOLLOW" />
    <link rel="icon" href="<?php echo $_DOMAIN; echo $value[0]; ?>" type="image/png">
    <link rel="alternate" href="<?php echo $_DOMAIN; ?>" hreflang="vi-vn" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

   <!-- Bootstrap core JS -->
   <script src="<?php echo $_DOMAIN; ?>view/js/main.js"></script>
   <script src="<?php echo $_DOMAIN; ?>view/js/form.js"></script>

   <!-- ImportCSS -->
   <link href="<?php echo $_DOMAIN; ?>view/css/style.css" rel="stylesheet">
   <link href="<?php echo $_DOMAIN; ?>view/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?php echo $_DOMAIN; ?>view/css/jumbotron-narrow.css" rel="stylesheet">

   <!-- Bootstrap core CSS & JS online -->
   <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

   <!-- Google Analytics -->
   <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', '<?php echo $value[4]; ?>', 'auto');
    ga('send', 'pageview');

  </script>
</head>
<body id="page-header"<?php if (isset($_GET["action"])) if ($_GET["action"] == "login") echo ' class="login-page modal-open"'; ?>>
<?php
  if (isset($_GET["action"])) {
    if ($_GET["action"] == "admin" || $_GET["action"] == "labs" || $_GET["action"] == "profile")
        echo '<div class="none" style="padding:37px;"></div>';
    else echo '<div class="none" style="padding:35px;"></div>';
  } else echo '<div class="none" style="padding:35px;"></div>';
?>
