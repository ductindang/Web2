<?php

class Discount{
    protected $id;
    protected $name;
    protected $discount_percentage;
    protected $start_day;
    protected $finish_day;
    protected $display;

    function __construct($id, $name, $discount_percentage, $start_day, $finish_day, $display){
        $this->id = $id;
        $this->name = $name;
        $this->discount_percentage = $discount_percentage;
        $this->start_day = $start_day;
        $this->finish_day = $finish_day;
        $this->display = $display;
    }

    function getId(){
        return $this->id;
    }

    function getName(){
        return $this->name;
    }

    function getDiscountPercentage(){
        return $this->discount_percentage;
    }

    function getStartDay(){
        return $this->start_day;
    }

    function getFinishDay(){
        return $this->finish_day;
    }

    function getDisplay(){
        return $this->display;
    }

}