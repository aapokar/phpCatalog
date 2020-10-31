<?php

require_once("config.php");
require_once 'view.php';
require_once 'controller.php';

$product_data = [];
$column_names = [];
$column_names_map = [];
$drinkTypes = [];

function initModel() {
    global $drinkTypes, $product_catalog_filename, $product_data, $column_names, $column_names_map;

    $product_data = readProductCatalog($product_catalog_filename);
    $column_names_map = createColumnNamesMap($column_names);
    $drinkTypes = getTypes($product_data);
}

function getTypes($products) {
    $types = [];
    for ($i = 0; $i < count($products); $i++) {
        if (in_array($products[$i][8], $types)) {
        continue;   
        } else {
            array_push($types, $products[$i][8]);
        }
    }
    return $types;
}

function readProductCatalog($filename) {
    global $product_catalog_date, $column_names;

    $row = 0;
    $index = 0;
    $products = [];

    if (($handle = fopen($filename, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            if ($row == 0) {
                $key = "Alkon hinnasto ";
                if ($key == substr($data[0], 0, strlen($key))) {
                    $product_catalog_date = substr($data[0], strlen($key));
                }
            } else if ($row == 1) {
                //skip
            } else if ($row == 2) {
                //skip
                
            } else if ($row == 3) {
                $column_names = $data;
            } else {
                $products[$index] = $data;
                $index++;
            }
            $row++;
        }
        
        fclose($handle);
    }
    return $products;
}

function createColumnNamesMap($column_names) {
    $column_names_map = [];
    for( $i = 0; $i < count($column_names); $i++) {
        $column_names_map[$column_names[$i]] = $i;
    }
    return $column_names_map;
}


