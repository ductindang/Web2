<?php
    class BaseRepository{
        // chỉ truy cập bên trong lớp hoặc các lớp con kế thừa
        protected $error;

        function getError(){
            // Lấy dữ liệu lỗi
            return $this->error;
        }
    }


?>