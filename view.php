<?php
require_once("config.php");
function generateView($filters) {
   global $product_data, $columns2Include, $column_names_map, $drinkTypes;
   $t = createProductsTable($product_data, $columns2Include, $column_names_map, $filters);
   $t .= createTypesFilter($drinkTypes);
    
   return $t;
}

function createTypesFilter($types) {
    $t = '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="get">'; 
    $t .= "<label for='type'>Näytä:</label><br><select name='type' id='type'>";
    for ($i = 0; $i< count($types); $i++) {
        $t .= "<option value=".$types[$i].">".$types[$i]."</option>";
    }
    $t .= "</select><input type='submit' name='submit'></form>";
    return $t;
}

function createColumnHeaders($columns2Include) {
    $t = "<thead>";
    $t .= "<tr>";
    for ($i = 0; $i < count($columns2Include); $i++) {
        $val = $columns2Include[$i];
        $t .= '<th scope="col">'.$val.'</th>';
    }
    $t .= "</tr></thead>";
    return $t;
}

function createTableRow($product, $columns2Include, $column_names_map) {
    $t = "<tr>";
    for($i = 0; $i < count($columns2Include); $i++) {
        $name = $columns2Include[$i];
        $value = $product[ $column_names_map[$name]];
        $t .= "<td>".$value."</td>";
    }
    $t .= "</tr>";
    return $t;
}

function createProductsTable($products, $columns2Include, $column_names_map, $filters) {
    
    $pageno = $filters['PAGENO'];
    $offsetBottom = $filters['LIMIT'] * $pageno;
    $offsetTop = $offsetBottom + $filters['LIMIT'];
    $limitCounter = 0;
    $t = "<table>";
    
    $t .= createColumnHeaders($columns2Include);
    $t .= "<tbody>";
    for($i = ($filters['LIMIT'] * $pageno); $i < count($products); $i++) {
        $product = $products[$i];
        //FILTERING
        if($filters['TYPE'] != null) {
            $startsWith = substr($product[$column_names_map['Tyyppi']], 0, strlen($filters['TYPE'])) === $filters['TYPE'];
            if(!$startsWith) {
                continue;
            }
        }
        
        if($filters['COUNTRY'] !== null) {
            if($product[$column_names_map['Valmistusmaa']] !== $filters['COUNTRY']) {
                continue;
            }
        }
        
        $limitCounter++;
        if ($limitCounter > $offsetTop) {
            break;
        }
        if ($limitCounter > $offsetBottom) {
        $t .= createTableRow($product, $columns2Include, $column_names_map);    
        }
        
    }
    
    $typeQuery = $filters['TYPE'];
    
    $t .= "</tbody></table><ul><li class=><a href=?pageno=";
    if ($pageno == 0) {
        $t .= ($pageno);
    } else {
        $t .= ($pageno - 1);
    }
    $t .= "&type=".($typeQuery).">Prev</a></li><li><a href=";
    $t .= '?pageno='.($pageno + 1)."&type=".($typeQuery); 
    $t .= ">Next</a></li><br>";

    return $t;
}


