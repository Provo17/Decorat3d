<?php
/**
 * set currency in main.php params
 * @param type $price
 * @return price format with currency
 */
function format_price($price) {
    
   return Yii::app()->numberFormatter->formatCurrency($price,  Yii::app()->params->currency);
     
}


 function calculatePrice($price,$store_commision="",$admin_commision="",$format=TRUE)
    {
     if($admin_commision=="")
     {
         $admin_commision=Yii::app()->params->admin_commision;
     }
     $result_price=$price+$admin_commision;
     if($store_commision!=""){
        $result_price=$price+$admin_commision+(($price*$store_commision)/100);
     }
        if($format){
        return format_price($result_price);
        }else{
            return $result_price;  
        }
    }