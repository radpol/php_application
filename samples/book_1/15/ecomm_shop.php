<html>
  <head>
    <title>Nab�dka produkt� pro fanou�ky komiks�</title>
    <style type="text/css">
      th { background-color: #999;}
      td { vertical-align: top; }
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <h1>Obchod pro fanou�ky komiks�</h1>
    <p><a href="ecomm_view_cart.php">Zobrazit obsah n�kupn�ho ko��ku</a></p>
    <p>D�kujeme, �e jste nav�t�vili n� web!
      Prohl�dn�te si seznam na�ich skv�l�ch produkt�. Chcete-li se dov�d�t
    n�co bli���ho, klepn�te na p��slu�n� odkaz:</p>
    <table style="width:75%;">
      <?php
      require 'db.inc.php';

      $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
        die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

      mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

      $query = 'SELECT
                    product_code, name, price
                FROM
                    ecomm_products
                ORDER BY
                    product_code ASC';
      $result = mysql_query($query, $db)or die(mysql_error($db));

      $odd = true;
      while ($row = mysql_fetch_array($result)) {
        echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
        $odd = !$odd;
        extract($row);
        echo '<td style="text-align: center; width:100px;"><a href="' .
              'ecomm_view_product.php?product_code=' . $product_code .
              '"><img src="images/' . $product_code .'_t.jpg" alt="' . $name .
              '"/></a></td>';
        echo '<td><a href="ecomm_view_product.php?product_code=' . 
              $product_code . '">' . $name . '</a></td>';
        echo '<td style="text-align: right;"><a href="ecomm_view_product.php?' .
              'product_code=' . $product_code . '">' . $price . ' K�</a></td>';
        echo '</tr>';
      }
      ?>
    </table>
  </body>
</html>