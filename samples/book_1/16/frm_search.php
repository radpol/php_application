<?php
require_once 'frm_header.inc.php';

echo '<h2>V�sledky hled�n�</h2>';

if (isset($_GET['keywords'])) {
    $sql = 'SELECT
                id, topic_id, subject, MATCH (subject, body) AGAINST ("' .
                $_GET['keywords'] . '") AS score
            FROM
                frm_posts
            WHERE
                MATCH (subject, body) AGAINST ("' . $_GET['keywords'] . '")
            ORDER BY
                score DESC';
    $result = mysql_query($sql, $db) or die(mysql_error($db));

    if (mysql_num_rows($result) == 0) {
    echo '<p>Hled�n� textu "' . '<strong>' . $_GET['keywords'] . '</strong>"' .
         ' bylo dokon�eno. Nejsou k dipozici ��dn� v�sledky k zobrazen�.</p>';
    } else {
        echo '<ol>';
        while ($row = mysql_fetch_array($result)) {
            $topicid = ($row['topic_id'] == 0) ? $row['id'] : $row['topic_id'];
            echo '<li><a href="frm_view_topic.php?t=' . $topicid . '#post' .
                $row['id'] . '">' . $row['subject'] . '</a><br/>' .
                'v�ha: ' . $row['score'] . '</li>';
        }
        echo '</ol>';
    }
    // Pozn�mka p�ekladatele:
    echo '<em>Datab�ze p�i�azuje ka�d�mu slovu <b>v�hu</b>. ' .
         'Slova s nejv�t��m v�skytem ve sloupci maj� nejni��� v�hu. ' .
         'V�ha n�kter�ch velmi �ast�ch slov m��e klesnout i na nulu ' .
         'a potom jej fulltextov� vyhled�v�n� nenajde.</em>';
}

require_once 'frm_footer.inc.php';
?>