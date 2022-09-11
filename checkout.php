<?php
if (!isset($_SESSION)) { 
    session_start(); 
} 

require_once "./assets/database/db-connect.php";
header('Content-Type: text/html; charset=UTF-8');

//Lấy dữ liệu từ file dangky.php
$err = null;//mảng chứa cảnh báo lỗi
$errPhone = null;
$errEmail = null;

if (isset($_POST['checkout'])) {
    $fullname      = addslashes($_POST['email']);
    $email      = addslashes($_POST['email']);
    $phone   = addslashes($_POST['phone']);
    $address   = addslashes($_POST['address']);
    $note        = addslashes($_POST['note']);

    //Kiểm tra người dùng đã nhập liệu đầy đủ chưa
    if ($fullname == '' || $email == '' || $phone == '' || $address == '') {
        $err = 'Vui lòng nhập đầy đủ thông tin';
        // header("Location:register_user.php");
    } else {
        //Kiểm tra email này đã có người dùng chưa
        if (!mb_eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
            $errEmail = 'Email này không hợp lệ. Vui lòng nhập email khác';
        }
        //Kiểm tra SĐT có đúng định dạng hay không
        else if (!mb_eregi("^[0-9]", $phone)) {
            $errPhone = 'SĐT không hợp lệ. Vui lòng nhập SĐT khác';
        //Sau khi validate dữ liệu ghi vào DB
        } else {
            @$addOrder = mysqli_query($conn,"
                INSERT INTO orders (full_name,email,phone,address,note,total_price)
                VALUE ('{$fullname}','{$email}','{$phone}','{$address}','{$note}','{$_SESSION['payment_price']['total_price']}')
            ");
                                
            //Thông báo quá trình lưu
            if ($addOrder) {
                echo "Bạn đã đặt hàng thành công";
                header("Location:notification.php");
            } else {
                echo "Có lỗi xảy ra trong quá trình đặt hàng. <a href='cart.php'>Thử lại</a>";
            }
        }
    }
}
?>

<!DOCTYPE html>
    <head>
        <title>Checkout</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatile" content="IE=edge" />
        <link rel="stylesheet" href="./assets/css/checkout.css">
        <link rel="stylesheet" href="./assets/fonts_icon/css/all.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
        <body>
        <!-- <?php include 'header.php' ?> -->
        <div class="container">
            <div class="row" class="height:1000px;">
                <div class="col-sm-6 checkout_layout">
                    <div class="noi-dung">
                        <div class="form">
                            <h2>Thông tin giao hàng</h2>
                            <form action="" method="post" enctype="">
                            <?php if ($err) { ?>
                                <div style="color:red"><?php echo $err; ?></div>
                            <?php } ?>
                                <div class="input-form">
                                    <span>Họ và tên khách hàng</span>
                                    <br/>
                                    <input type="text" name="fullname" class="" placeholder="Vui lòng nhập họ tên đầy đủ">
                                </div>
                                <div class="input-form">
                                    <span>Email</span>
                                    <br/>
                                    <input type="text" name="email" placeholder="Vui lòng nhập email">
                                </div>
                                <?php if ($errEmail) { ?>
                                    <div style="color:red"><?php echo $errEmail; ?></div>
                                <?php } ?> 
                                <div class="input-form">
                                    <span>Số điện thoại</span>
                                    <br/>
                                    <input type="text" name="phone" placeholder="Vui lòng nhập số điện thoại">
                                </div>
                                <?php if ($errPhone) { ?>
                                    <div style="color:red"><?php echo $errPhone; ?></div>
                                <?php } ?>
                                <div class="input-form">
                                    <span>Địa chỉ</span>
                                    <br/>
                                    <input type="text" name="address" placeholder="Vui lòng nhập địa chỉ giao hàng">
                                </div>
                                <div class="input-form">
                                    <span>Ghi chú</span>
                                    <br/>
                                    <input type="text" name="note" placeholder="Ghi chú">
                                </div>
                                <div class="input-form">
                                    <input type="submit" value="Đặt hàng" name="checkout">
                                </div>
                                <div class="input-form">
                                    <p>Bạn Đã Có Tài Khoản? <a href="login.php">Đăng nhập</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 checkout_product">
                    <div class="noi-dung">
                        <div class="form">
                            <h2>Thông tin sản phẩm</h2>
                            <?php if (isset($_SESSION['cart'])) { 
                                $total = 0;
                                foreach ($_SESSION['cart'] as $checkoutProduct) {
                                    if ($checkoutProduct['id'] != null) {
                                        $price = intval($checkoutProduct['price'] * $checkoutProduct['quantity']);
                                        $total += $price;
                            ?>
                            <div class="d-flex mb-3 text-box pr-5 list-item" style="border-bottom: 1px #ccc solid">
                                <div class="col-sm-6">  
                                    <h4 class="" style="font-size:20px"><?=$checkoutProduct['name'];?></h4>
                                </div>
                                <div class="col-sm-3">  
                                    <span class="d-flex">
                                        <p class="price-promo"><?=$checkoutProduct['quantity'];?></p>
                                    </span>
                                </div>
                                <div class="col-sm-3">  
                                    <p class="amount me-3"><?=$checkoutProduct['price']* $checkoutProduct['quantity'];?></p>
                                </div>
                            </div>
                            <?php } } } ?>
                            <div class="payment-price d-flex">
                                <div class="col-sm-9 text-box pr-5">
                                    <h4 class="" style="font-size:25px"><b>THÀNH TIỀN</b></h4>
                                </div>
                                <?php if (isset($total)) {?> 
                                <div class="col-sm-3 text-box pr-5">
                                    <h4 class="" style="font-size:25px"><b><?=$total + $total*0.08?></b></h4>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php include './footer.php' ?>
    </body>
</html>