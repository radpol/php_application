<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

session_start();
$session = session_id();

$qty = (isset($_POST['qty']) && ctype_digit($_POST['qty'])) ? $_POST['qty'] : 0;
$product_code = (isset($_POST['product_code'])) ? $_POST['product_code'] : '';
$action = (isset($_POST['submit'])) ? $_POST['submit'] : '';
$redirect = (isset($_POST['redirect'])) ? $_POST['redirect'] : 'ecomm_shop.php';

switch ($action) {
  case 'P�idat do ko��ku':
    if (!empty($product_code) && $qty > 0) {
      $query = 'INSERT INTO ecomm_temp_cart
                    (session, product_code, qty)
                VALUES
                    ("' . $session . '", "' .
                    mysql_real_escape_string($product_code, $db) . '", ' .
                    $qty . ')';
      mysql_query($query, $db) or die(mysql_error($db));
    }
    header('Location: ' . $redirect);
    exit();
    break;

  case 'Zm�nit mno�stv�':
    if (!empty($product_code)) {
      if ($qty > 0) {
        $query = 'UPDATE ecomm_temp_cart
                  SET
                      qty = ' . $qty . '
                  WHERE
                      session = "' . $session . '" AND
                      product_code = "' .
                      mysql_real_escape_string($product_code, $db) . '"';
      } else {
        $query = 'DELETE FROM ecomm_temp_cart
                  WHERE
                      session = "' . $session . '" AND
                      product_code = "' .
                      mysql_real_escape_string($product_code, $db) . '"';
      }
      mysql_query($query, $db) or die(mysql_error($db));
    }
    header('Location: ' . $redirect);
    exit();
    break;

  case 'Vypr�zdnit ko��k':
    $query = 'DELETE FROM ecomm_temp_cart
              WHERE
                  session = "' . $session . '"';
    mysql_query($query, $db) or die(mysql_error($db));
    header('Location: ' . $redirect);
    exit();
    break;
}
?>