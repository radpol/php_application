<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or 
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

// Vytvo�te tabulku pro obr�zky pohlednic.
$query = 'CREATE TABLE IF NOT EXISTS pc_image (
            image_id      INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
            image_url     VARCHAR(255)     NOT NULL DEFAULT "",
            description   VARCHAR(255)     NOT NULL DEFAULT "",

            PRIMARY KEY (image_id)
          )
          ENGINE=MyISAM';
mysql_query($query, $db) or die (mysql_error($db));

// P�izp�sobte tuto cestu skute�n�mu um�st�n�.
$images_path = 'http://localhost/php/11/pohlednice/';

// Vlo�te do tabulky obr�zk� nov� data.
$query = 'INSERT IGNORE INTO pc_image
            (image_id, image_url, description)
          VALUES
            (1, "' . $images_path . 'punyearth.jpg", "K� byste byli s n�mi"),
            (2, "' . $images_path . 'congrats.jpg", "Gratulujeme"),
            (3, "' . $images_path . 'visit.jpg", "Budeme u v�s coby dup"),
            (4, "' . $images_path . 'sympathy.jpg", "Our Sympathies")';
mysql_query($query, $db) or die (mysql_error($db));

echo 'Operace prob�hla �sp�n�!';
?>