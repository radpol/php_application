<?php
require 'db.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');
mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

$query = "INSERT INTO ecomm_products
            (product_code, name, description, price)
          VALUES (
            '00001', 'Tri�ko s logem na�eho webu',
            'Toto tri�ko zd�razn� va�i vazbu na n� web. Na�e tri�ka maj�
            vysokou kvalitu a jsou ze 100% p�edsr�en� bavlny.',
            17.95),
            ('00002','N�lepka s logem na�eho webu',
            'Dejte v�em v�d�t, �e podporujete n� web. Nalepte si na sklo
            auta na�i barevnou n�lepku.',
            5.95),
            ('00003', '��lek s logem na�eho webu',
            'S ��lkem s logem na�eho webu bude va�e rann� k�va mnohem
            chutn�j��. Lep�� bude i v� vstup do nov�ho dne. Na�e ��lky m��ete
            pou��vat v mikrovlnn� troub� a tak�  m�t v automatick� my�ce.',
            8.95),
            ('00004', 'Oblek superhrdiny',
            'V nab�dce jsou v�echny barevn� odst�ny a velikosti. Tento oblek
            je �hledn�, stylov� a skr�v� va�e nadlidsk� bojov� schopnosti.
            Nab�z�me tak� obleky s monogramem vy�it�m na prsou.',
            99.95),
            ('00005', 'Mal� univerz�ln� h�k',
            'Tento speci�ln� h�k v�s dostane i z nejhor��ch situac� a m�st.
            V�imn�te si p�enosnosti a mo�nosti utajen�.
            H�k m� ov�em omezen� nosnosti.',
            139.95),
            ('00006', 'Velk� univerz�ln� h�k',
            'H�k pro velk� zat�en�, pro skoky z budovy na budovu.
            Tato verze v�m dovol� bezpe�n� cestovat m�stem. V�zte v�ak, �e
            p�i hmotnosti 22 kg se v�m bude obt�n� pou��vat,
            pat��te-li k lidem s men�� a leh�� postavou.',
            199.95)";
mysql_query($query, $db) or die(mysql_error($db));

echo 'Hotovo!';
?>