<?php
session_start();
require 'db.inc.php';
?>
<html>
  <head>
    <title>Toto je obsah va�eho ko��ku!</title>
    <style type="text/css">
      th { background-color: #999;}
      td { vertical-align: top; }
      .odd_row { background-color: #EEE; }
      .even_row { background-color: #FFF; }
    </style>
  </head>
  <body>
    <h1>Obchod pro fanou�ky komiks�</h1>
    <?php
    $db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
    die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

    mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

    $session = session_id();

    $query = 'SELECT
                  t.product_code, qty,
                  name, description, price
              FROM
                  ecomm_temp_cart t JOIN ecomm_products p ON
                      t.product_code = p.product_code
              WHERE
                  session = "' . $session . '"
              ORDER BY
                  t.product_code ASC';
    $result = mysql_query($query, $db) or die (mysql_error($db));

    $rows = mysql_num_rows($result);
    if ($rows == 0) {
      echo '<p>M�te pr�zdn� ko��k.</p>';
    } else if ($rows == 1) {
      echo '<p>V ko��ku m�te vybr�n jeden produkt.</p>';
    } else if ($rows > 1 and $rows < 5) {
      echo '<p>V ko��ku m�te ' . $rows . ' produkty.</p>';
    } else {
      echo '<p>V ko��ku m�te ' . $rows . ' produkt�.</p>';
    }

    if ($rows > 0) {
      ?>
    <table style="width: 75%;">
      <tr>
        <th style="width: 100px;"> </th><th>N�zev zbo��</th><th>Mno�stv�</th>
        <th>Jednotkov� cena</th><th>Celkov� cena</th>
      </tr><tr>
        <?php
        $total = 0;
        $odd = true;
        while ($row = mysql_fetch_array($result)) {
          echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
          $odd = !$odd;
          extract($row);
          ?>
        <td style="text-align:center;">
          <a href="ecomm_view_product.php?product_code=<?php
             echo $product_code; ?>">
            <img src="images/<?php echo $product_code; ?>_t.jpg"
               alt="<?php echo $name; ?>"/></a>
        </td>
        <td><a href="ecomm_view_product.php?product_code=
                 <?php echo $product_code; ?>"><?php echo $name; ?></a>
        </td>
        <td>
          <form method="post" action="ecomm_update_cart.php">
            <div>
              <input type="text" name="qty" maxlength="2" size="2"
                     value="<?php echo $qty; ?>"/>
              <input type="hidden" name="product_code"
                     value="<?php echo $product_code; ?>"/>
              <input type="hidden" name="redirect" value="ecomm_view_cart.php"/>
              <input type="submit" name="submit" value="Zm�nit mno�stv�"/>
            </div>
          </form>
        </td>
        <td style="text-align: right;">
          <?php echo number_format($price, 2, ',', ' '); ?> K�</td>
        <td style="text-align: right;">
          <?php echo number_format($price * $qty, 2, ',', ' '); ?> K� </td>
      </tr>
      <?php
      $total = $total + $price * $qty;
    }
    ?>
    </table>
    <p>Celkov� cena n�kupu bez po�tovn�ho:
    <strong><?php echo number_format($total, 2, ',', ' '); ?></strong> K�</p>
    <form method="post" action="ecomm_checkout.php">
      <div>
        <input type="submit" name="submit" value="Objednat"
               style="font-weight: bold;"/>
      </div>
    </form>
    <form method="post" action="ecomm_update_cart.php">
      <div>
        <input type="hidden" name="redirect" value="ecomm_shop.php"/>
        <input type="submit" name="submit" value="Vypr�zdnit ko��k"/>
      </div>
    </form>
    <?php
  }
  ?>
    <hr/>
    <p><a href="ecomm_shop.php">&lt;&lt; Zp�t na hlavn� str�nku</a></p>
  </body>
</html>