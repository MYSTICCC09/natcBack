<table>
    <tr>
        <th>Stock Number</th>
        <th>Industry</th>
        <th>Type</th>
        <th>Sub Type</th>
        <th>Configuration</th>
        <th>Model</th>
        <th>Make</th>
        <th>Retail Price</th>
        <th>M.Specific</th>
    </tr>
    <?php foreach($products as $product){?>
    <tr>
        <td><?php echo $product['stockNumber']?></td>
        <td><?php echo $product['industry']?></td>
        <td><?php echo $product['type']?></td>
        <td><?php echo $product['subtype']?></td>
        <td><?php echo $product['configuration']?></td>
        <td><?php echo $product['model']?></td>
        <td><?php echo $product['make']?></td>
        <td><?php echo $product['srp']?></td>
        <?php if(isset($product['ms'])){?>
        <td><?php echo $product['ms']?></td>
        <?php }?>
    </tr>
    <?php }?>
</table>