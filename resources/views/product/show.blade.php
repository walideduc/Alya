<?php //dd($products[0]->toArray()); ?>
<!DOCTYPE html>
<html>
<head>
<style>
table,td,th {
    border: 1px solid green;
}

th {
    background-color: green;
	color: white;
}
</style>
</head>
<body>
<table style="width:100%">
    <tr>
        <th>number of products </th>
        <th>purchase_price_ht </th>
        <th>numerator</th>
        <th>denominator</th>
    </tr>
    <tr>
        <td><?php echo sizeof($products) ; ?></td>
        <td><?php echo 'purchase_price_ht     = price_ht + eco_tax / ( 1 + $tva_general ) ' ; ?></td>
        <td><?php echo  '( purchase_price_ht + $transport_cost_ht + $transport_invoiced_ht * ( 1 - comm * ( 1 + $tva_general )) )'; ?></td>
        <td><?php echo '( 1 - marge - comm * (1 + $tva_general) ) ' ; ?></td>
    </tr>
</table>


<h1>Products</h1>

<table style="width: 100%" border="1" align="center">
    <tr>
        <th>category_id</th>
        <th>Ean</th>
        <th>name</th>
        <th>price_ttc</th>
        <th>price_ht</th>
        <th>eco_tax</th>
        <th>vat_rate</th>
        <th>image</th>
        <th>marge</th>
        <th>comm</th>
        <th>purchase_price_ht</th>
        <th>numerator</th>
        <th>denominator</th>
        <th>selling_price_ht</th>
        <th>vat_rate_dicimal</th>
        <th>selling_price_ttc</th>
        <th>coeff</th>
    </tr>
    <?php foreach($products as $product): ?>
    <tr>
        <td><?php echo $product->category_id ; ?></td>
        <td><?php echo $product->ref_value ; ?></td>
        <td><?php echo $product->name  ; ?></td>
        <td><?php echo $product->price_ttc  ; ?></td>
        <td><?php echo $product->price_ht ; ?></td>
        <td><?php echo $product->eco_tax  ?></td>
        <td><?php echo $product->vat_rate  ; ?></td>
        <td> <img src="<?php echo $product->image_url  ; ?>" style="width:100px;height:100px" ></td>
        <td><?php echo $product->marge ; ?></td>
        <td><?php echo $product->comm ; ?></td>
        <td><?php echo $product->purchase_price_ht; ?></td>
        <td><?php echo $product->numerator ; ?></td>
        <td><?php echo $product->denominator; ?></td>
        <td><?php echo round($product->selling_price_ht, 2);?></td>
        <td><?php echo$product->vat_rate_dicimal; ?></td>
        <td><?php echo $product->selling_price_ttc; ?></td>
        <td><?php echo round($product->coeff,2) ?></td>
    </tr>
    <?php endforeach; ?>


</table>
</body>
</html>
