<?php
$db = mysql_connect('localhost', 'uzivatel', 'heslo') or
    die('Nemohu se p�ipojit. Zkontrolujte p�ipojovac� parametry.');
mysql_select_db('moviesite', $db) or die(mysql_error($db));
                   
// vytvo� tabulku reviews
$dotaz = 'CREATE TABLE reviews (
        review_movie_id INTEGER UNSIGNED NOT NULL, 
        review_date     DATE             NOT NULL, 
        reviewer_name   VARCHAR(255)     NOT NULL,
        review_comment  VARCHAR(8000)     NOT NULL,
        review_rating   TINYINT UNSIGNED NOT NULL  DEFAULT 0, 
                   
        KEY (review_movie_id)
    )
    ENGINE=MyISAM';
mysql_query($dotaz, $db) or die (mysql_error($db));
                   
// vlo� nov� data do tabulky reviews
$dotaz = <<<ENDSQL
  INSERT INTO reviews (review_movie_id, review_date, 
                       reviewer_name, review_comment,   
                       review_rating)
  VALUES 
    (1, "2008-09-23", "Marek Sk�la", 
        "V�d�l jsem, �e to bude dobr�. I kdy� moje p��telkyn� 
         m� donutila, abych se na n�j pod�val.", 4),
    (1, "2008-09-23", "Jakub Slonek", 
        "No nev�m, Popelka se mi l�bila v�c.", 2),
    (1, "2008-09-28", "P�a", "Naprost� bomba!", 5),
    (2, "2008-09-23", "Marvin", 
        "Tak tohle je m�j obl�ben� film. Moc jsem tomu ned�val,
         ale nakonec jsme tenhle kousek zamyloval.", 5),
    (3, "2008-09-23", "V�clav K.", 
        "Film se mi docela l�bil, i kdy� to nejd��ve vypadalo jako
         nepoveden� video od agenta n�jak� cestovky.", 3)
ENDSQL;
mysql_query($dotaz, $db) or die(mysql_error($db));
                   
echo 'Datab�ze film� byla �sp�n� aktualizov�na!';
?>
