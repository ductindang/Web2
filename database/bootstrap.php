<?php
    // Truy cập các file trong model
    require_once("../model/base/BaseRepository.php");
    require_once("../model/category/Category.php");
    require_once("../model/category/CategoryRepository.php");
    require_once("../model/brand/Brand.php");
    require_once("../model/brand/BrandRepository.php");
    require_once("../model/comment/Comment.php");
    require_once("../model/comment/CommentRepository.php");
    require_once("../model/product/Product.php");
    require_once("../model/product/ProductRepository.php");

    // trả về tên host của trang web hiện tại.
    function get_host_name(){
        return $_SERVER['HTTP_HOST'];
    }

    // xác định đường dẫn https hay http
    function getProtocol(){
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http//";
        return $protocol;
    }

    // tạo ra địa chỉ domain tuyệt đối của trang web hiện tại
    function get_domain(){
        $protocol = getProtocol();
        return $protocol . $_SERVER['HTTP_HOST'];
    }

    function get_domain_site(){
        return get_domain() . "/site";
    }

?>