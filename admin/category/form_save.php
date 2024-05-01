<?php
if(!empty($_POST)){
    $id=getPOST("id");
    $name=getPOST("name");
    if($id>0){
        //sửa
        execute("Update  category set name='$name' where id=$id");

            
    }else{
        //thêm
        execute("INSERT INTO category(name,deleted) VALUES ('$name',0)");
       
    
    }

}