<?php

class DiscountRepository extends BaseRepository{
    protected function fetchAll($condition = null){
        global $conn;
        $discounts = array();
        $sql = "SELECT * FROM discount";
        if($condition){
            $sql .= "WHERE $condition";
        }

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $discount = new Discount($row["id"], $row["name"], $row["discount_percentage"], $row["start_day"], $row["start_day"], $row["finish_day"], $row["display"]);
                $discounts[] = $discount;
            }
        }
        return $discounts;
    }

    function getAll(){
        return $this->fetchAll();
    }

    function find($id){
        global $conn;
        $condition = "id = $id";
        $discounts = $this->fetchAll($condition);
        $discount = current($discounts);
        return $discount;
    }
}