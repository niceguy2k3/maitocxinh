<?php
    $id_cate = $_REQUEST['id_cate'];
    $stmt = $conn -> query("SELECT name FROM post_categories WHERE id = $id_cate AND status = 1 AND deleted = 0");
    $cate_name = $stmt->fetch();
    if($cate_name){
        
    }else{
        header("location: index.php");
    }

?>
<style>
    p{
        font-size: 1.2em!important;
    }
</style>
<body>
    <!---->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="index.html">Trang Chủ</a>
        </li>
        <li class="breadcrumb-item active">Danh Mục</li>
        <li class="breadcrumb-item active"><?=$cate_name[0]?></li>
    </ol>
    <!---->
    <!--// mian-content -->
    <!-- banner -->
    <section class="ab-info-main py-5">
        <div class="container py-lg-3">
                <h3 class="tittle text-center mb-lg-5 mb-3">Bài Viết Về <?=$cate_name[0]?></h3>
                <?php
                    if (isset($_REQUEST['pagi'])) {
                        $offset = ($_REQUEST['pagi'] - 1)*16;
                    }else $offset = 0;
                    $stmt = $conn -> query("SELECT * FROM post where id_cate = $id_cate AND status = 1 AND deleted = 0 limit 16 offset $offset ");
                    while ($row = $stmt->fetch()) {
                        echo '
                            <div id="blogView" class="blog-list">
                                <div class="blog span3">
                                    <h3 class="blog-name">
                                        <a href="index.php?page=blog-details&id_blog='.$row[0].'">'.$row['name'].'</a>
                                    </h3>
                                    <div class="blog-image">
                                        <a href="index.php?page=blog-details&id_blog='.$row[0].'"><img src="uploads_blog/'.$row['img'].'" alt=""></a>
                                    </div>
                                    <div class="blog-info">
                                        <p >
                                            '.$row['meta_description'].'
                                        </p>
                                        <div class="blog-viewmore">
                                            <form action="index.php?page=blog-details&id_blog='.$row[0].'" method="post">
                                                <button type = "submit" class="btn" name="add_prod">
                                                    Xem Toàn Bộ
                                                    <span class="meta-nav">→</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>';
                    };
                ?>
            <div id="pagi">
                <?php
                $rows = $conn->query("SELECT count(*) FROM post where id_cate = $id_cate")->fetchColumn();
                $total_pages = ceil($rows/16);
                $current_page = isset($_REQUEST['pagi']) ? $_REQUEST['pagi'] : 1;
                if ($current_page > 1) {
                    echo "<a href='index.php?page=$page&id_cate=$id_cate&pagi=" . ($current_page - 1) . "'>&laquo; Previous</a>";
                }
                for ($i=1; $i <= $total_pages; $i++) { 
                   echo "<a href='index.php?page=$page&id_cate=$id_cate&pagi=$i'>$i</a>";
                   echo "\t";
                }
                if ($current_page < $total_pages) {
                    echo "<a href='index.php?page=$page&id_cate=$id_cate&pagi=" . ($current_page + 1) . "'>Next &raquo;</a>";
                }
                ?>
                
            </div>
        </div>
    </section>
    <!-- //banner -->
    
</body>

</html>
