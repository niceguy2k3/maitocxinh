<div class="container">
    <h2 class="py-2 text-center h4 ">QUẢN LÝ  CHI TIẾT ĐƠN HÀNG</h2>
    <table class="table table-hover table-bordered">
    <thead  class="thead-dark" >
        <tr>
            <th>ID</th>
            <th>ID Đơn Hàng</th>
            <th>ID Sản Phẩm</th>
            <th>Tên Sản Phẩm</th>
            <th>Giá</th>
            <th>Số Lượng</th>
            <th>Tổng Tiền</th>
        </tr>
        
    </thead>
    <tbody>
    <?php
        require '../config/config.php';
        require '../model/conn.php';
        if(isset($_REQUEST['id_order'])){
            $id_order = " where id_order = ".$_REQUEST['id_order']."";
        }else{
            $id_order = '';
        }
        $stmt = $conn ->prepare("SELECT * FROM order_details $id_order order by id_order"); 
        $stmt -> execute();
        while($order_details = $stmt->fetch()){
            echo "<tr>
                <td>$order_details[0]</td>
                <td>$order_details[1]</td>
                <td>$order_details[2]</td>
                <td>$order_details[3]</td>
                <td>".number_format($order_details[4], 0, "," , ".")."</td>
                <td>$order_details[5]</td>
                <td>".number_format($order_details[6], 0, "," , ".")."</td>
            </tr>";
        }
    ?>
    </tbody>
</table>
</div>