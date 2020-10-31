<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once('model.php');
        initModel();
        $filters = handleRequest();
        $html_product_table = generateView($filters);
        // put your code here
        echo "<h1>Alkon hinnasto $product_catalog_date</h1>";
        echo $html_product_table;
       
        ?>
    </body>
</html>
