<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 27/08/15
 * Time: 16:49
 */

namespace App\Partners\Suppliers\Suppliers\PixmaniaPro;
use App\Partners\Suppliers\AbstractSupplier ;

class PixmaniaPro extends AbstractSupplier {
    public function getCatalog(){
        return 'yes PixmaniaPro catalog';
    }

}