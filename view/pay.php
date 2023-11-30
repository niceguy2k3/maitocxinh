<?php
if ($_SESSION['cart'] != []) {
    if (isset($_POST['pay_button'])) {
        if ($_SESSION['cart'] != []) {
            if (isset($_COOKIE['usr'])) {
                echo "<script>window.location.href='index.php?page=pay';</script>";
            } else {
                echo "<div class='alert alert-warning'>
                    <strong></strong>Đăng nhập để thanh toán.
                    </div>";
                echo "<div class='alert alert-warning'>
                <strong></strong><a style='color: #254525;' href='index.php?page=login&page_return'>ĐĂNG NHẬP NGAY</a>
                </div>";
            }
            echo "<div class='alert alert-warning'>
            <strong></strong>Không có sản phẩm để thanh toán.
            </div>";
        } else {
            echo "<div class='alert alert-warning'>
            <strong></strong>Không có sản phẩm để thanh toán.
            </div>";
        }
    }
    if (isset($_COOKIE['usr'])) {
        $stmt = $conn->prepare("SELECT * FROM usr WHERE username = ? /*and pass = ?*/");
        $stmt->bindParam(1, $_COOKIE['usr']);
        $stmt->execute();
        $user = $stmt->fetch();
    } else {
        // echo "<script> window.location.href='index.php?page=cart';</script>";
    }
} else {
    echo "<div class='alert alert-warning'>
    <strong></strong>Không có sản phẩm để thanh toán.
    </div>";
    header("location: index.php?page=cart");
}
?>
<html>
<style>
    .main-banner {
        background: #255C45;
        height: 100px;
        animation: none;
    }

    .banner-info {
        display: none;
    }
</style>
</html>
<section class="about py-5">
    <div class="container pb-lg-3">
        <h3 class="tittle text-center">Thanh Toán</h3>
        <div class="row" <?php if ($_SESSION['cart'] == []) {
                                echo 'style="display: none;"';
                            } ?>>
            <div class="container__cart">
                <div class="container__cart__first">
                    <!--something is here-->
                    <div class="container__cart__first__pay">
                        <div class="Tien__Hanh_Thanh__Toan" style="border: none; margin-top: 10px;">
                            <form action="model/pay_process.php" method="post">
                                <input class="babaphantram" type="hidden" name="id_user" value="<?= $user[0] ?? "" ?>">
                                <input class="babaphantram" type="text" name="name_user" placeholder="Họ và tên"
                                    required="" value="<?= $user[2] ?? "" ?>">
                                <input class="babaphantram" type="email" class="email" name="email" placeholder="Email"
                                    required="" value="<?= $user[4] ?? "" ?>">
                                <input class="babaphantram" type="tel" name="SDT" placeholder="Số điện thoại" required=""
                                    value="<?= $user[5] ?? "" ?>">
                                <select class="form-select form-select-sm mb-3" id="city" name="city"
                                    aria-label=".form-select-sm" required="">
                                    <option value="" selected>Chọn tỉnh thành</option>
                                </select>

                                <select class="form-select form-select-sm mb-3" id="district" name="district"
                                    aria-label=".form-select-sm" required="">
                                    <option value="" selected>Chọn quận huyện</option>
                                </select>

                                <select class="form-select form-select-sm" id="ward" name="ward"
                                    aria-label=".form-select-sm" required="">
                                    <option value="" selected>Chọn phường xã</option>
                                </select>
                                <input type="text" name="address" placeholder="Địa chỉ" required="">
                                <textarea name="note"
                                    placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết"></textarea>

                                <h4 class="mb-333">Hình thức thanh toán</h4>
                                <div class="d-block my-333">
                                    <div class="custom-control custom-radio">
                                        <input id="httt-1" name="payment" value="ship_cod" type="radio" class="custom-control-input"
                                            required="">
                                        <label class="custom-control-label" for="httt-1">Thanh toán khi nhận hàng</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="httt-2" name="payment" value="vnpay" type="radio" class="custom-control-input"
                                            required="">
                                        <label class="custom-control-label" for="httt-2">VNPAY</label>
                                    </div>
                                </div>
                                <button name="order_button" class="pay_button" type="submit">Đặt Hàng</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");
    var Parameter = {
        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
        method: "GET",
        responseType: "application/json",
    };
    var promise = axios(Parameter);
    promise.then(function (result) {
        renderCity(result.data);
    });

    function renderCity(data) {
        for (const x of data) {
            citis.options[citis.options.length] = new Option(x.Name, x.Id);
        }
        citis.onchange = function () {
            district.length = 1;
            ward.length = 1;
            if (this.value != "") {
                const result = data.filter(n => n.Id === this.value);

                for (const k of result[0].Districts) {
                    district.options[district.options.length] = new Option(k.Name, k.Id);
                }
            }
        };
        district.onchange = function () {
            ward.length = 1;
            const dataCity = data.filter((n) => n.Id === citis.value);
            if (this.value != "") {
                const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

                for (const w of dataWards) {
                    wards.options[wards.options.length] = new Option(w.Name, w.Id);
                }
            }
        };
    }

</script>
