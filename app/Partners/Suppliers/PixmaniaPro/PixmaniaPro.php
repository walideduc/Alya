<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 27/08/15
 * Time: 16:49
 */

namespace Alyya\Partners\Suppliers\PixmaniaPro;
use Alyya\Partners\Suppliers\AbstractSupplier ;
use Illuminate\Support\Facades\DB;

class PixmaniaPro extends AbstractSupplier {
    public function getCatalog(){
        return 'yes PixmaniaPro catalog';
    }

    public function testCatalog(){
        //$filePath = $this->referenceList['CATALOG']['local_dir'] . $fileName ;
        $fileName = 'pixpro_feed_v2_fr_fr_full_hdr_20151021134006.csv';
        $fileName = 'pixpro_feed_v2_fr_fr_full_hdr_20150811094007.csv' ;
        $filePath = '/home/walid/Desktop/Dropshipping/pixmania/'.$fileName;
        $fp = fopen($filePath, 'r') ;
        if(!$fp)
        {
            return -2 ;
        }

        $fieldNames = [
            'Category',
            'Market',
            'Segment',
            'PIXpro_SKU',
            'Brand',
            'Label',
            'Description',
            'PIXpro_price',
            'Delivery',
            'Price',
            'Picture',
            'Availability',
            'Weight',
            'Weight_Volume',
            'Express_Delivery',
            'EAN',
            'Manufacturer_Reference',
            'WEEE',
            'Reprography',
            'Private_Copying',
        ];




        $entete = $this->readline1($fp, $fieldNames);
        $i = 0 ;
        while($dataLine = $this->readline1($fp, $fieldNames))
        {
            $i++;
            DB::table('pixmania_pro_products')->insert(
                [
                    'Category' => $dataLine->Category,
                    'Market' => $dataLine->Market,
                    'Segment' => $dataLine->Segment,
                    'PIXpro_SKU' => $dataLine->PIXpro_SKU,
                    'Brand' => $dataLine->Brand,
                    'Label' => $dataLine->Label,
                    'Description' => $dataLine->Description,
                    'PIXpro_price' => $dataLine->PIXpro_price,
                    'Delivery' => $dataLine->Delivery,
                    'Price' => $dataLine->Price,
                    'Picture' => $dataLine->Picture,
                    'Availability' => $dataLine->Availability,
                    'Weight' => $dataLine->Weight,
                    'Weight_Volume' => $dataLine->Weight_Volume,
                    'Express_Delivery' => $dataLine->Express_Delivery,
                    'EAN' => $dataLine->EAN,
                    'Manufacturer_Reference' => $dataLine->Manufacturer_Reference,
                    'WEEE' => $dataLine->WEEE,
                    'Reprography' => $dataLine->Reprography,
                    'Private_Copying' => $dataLine->Private_Copying,
                ]
            );
        }
        dd($i);

    }

    private function readLine1($fp, $fieldNames = null )
    {
        try{
            $res = @fgetcsv($fp, 0, ';') ;
            if(!$res)
                return false ;
            $line = new \stdClass() ;
            foreach($fieldNames as $id => $fieldName)
            {
                $line->$fieldName = utf8_encode(trim($res[$id])) ; // Les fichiers sont encodés en ISO-8859-1, mais notre système accèpte uniquement du UTF-8
            }
        }catch (\ErrorException $e){
            echo $e->getMessage();
            dd($res);
        }

        return $line ;
    }

}