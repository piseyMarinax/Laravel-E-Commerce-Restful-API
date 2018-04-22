<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongToUSer extends Exception
{
   public function render()
   {
       return ['Error' => 'Product Not Belong to user'];
   }  
}
