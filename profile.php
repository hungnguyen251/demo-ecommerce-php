<?php
if (!isset($_SESSION)) { 
    session_start(); 
} 

if (!isset($_SESSION['account'])) {
    header('Location:login.php');
}
?>

<!DOCTYPE html>
    <head>
        <title>Thông tin cá nhân</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatile" content="IE=edge" />
        <link rel="stylesheet" href="./assets/css/profile.css">
        <link rel="stylesheet" href="./assets/fonts_icon/css/all.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
        <body>
        <?php include 'header.php' ?>
        <div class="container" style="height: 700px;">
            <div class="row">
                <div class="d-flex">
                    <div class="col-sm-4 nav-info">
                        <div class="nav-left">
                            <ul class="nav-left-list">
                                <li><a href="profile.php">THÔNG TIN TÀI KHOẢN</a></li>
                                <li><a href="user_update.php">CẬP NHẬT THÔNG TIN</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-8 login_layout">
                        <div class="noi-dung">
                            <div class="form">
                                <h2>Thông tin của bạn</h2>
                                <form action="" method="post" enctype="">
                                    <div class="input-form">
                                        <div class="form-group d-flex">
                                            <label for="userlogin" class="col-sm-3 control-label col-xs-5">
                                                Email:
                                            </label>
                                            <div class="col-sm-6 col-xs-7">
                                                <p><?=$_SESSION['account']['email']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex">
                                            <label for="userlogin" class="col-sm-3 control-label col-xs-5">
                                                Tên:
                                            </label>
                                            <div class="col-sm-6 col-xs-7">
                                               <?php if ($_SESSION['account']['full_name'] != '') { ?>
                                                <p><?=$_SESSION['account']['full_name']?></p>
                                                <?php } else { ?>
                                                <p><i class="" style="color:red;">Đang cập nhật</i></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex">
                                            <label for="userlogin" class="col-sm-3 control-label col-xs-5">
                                                Địa chỉ:
                                            </label>
                                            <div class="col-sm-6 col-xs-7">
                                                <?php if ($_SESSION['account']['address'] != '') { ?>
                                                <p><?=$_SESSION['account']['address']?></p>
                                                <?php } else { ?>
                                                <p><i class="" style="color:red;">Đang cập nhật</i></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex">
                                            <label for="userlogin" class="col-sm-3 control-label col-xs-5">
                                                Số điện thoại:
                                            </label>
                                            <div class="col-sm-6 col-xs-7">
                                                <p><?=$_SESSION['account']['phone']?></p>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex">
                                            <label for="userlogin" class="col-sm-3 control-label col-xs-5">
                                                Ngày sinh:
                                            </label>
                                            <div class="col-sm-6 col-xs-7">
                                                <p><?=$_SESSION['account']['birthday']?></p>
                                            </div>
                                        </div>
                                        <a href="logout.php">Đăng xuất ?</a>
                                    </div>
                                    <div class="btn-navigation">
                                        <a class="back-home" href="index.php">Quay lại trang chủ</a>
                                        <a class="go-to-cart" href="cart.php">Đi đến giỏ hàng</a>         
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include './footer.php' ?>
    </body>
</html>