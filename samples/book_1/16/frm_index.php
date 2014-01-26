<?php
require 'frm_header.inc.php';

$sql = 'SELECT
            f.id as id, f.forum_name as forum, f.forum_desc as description,
            COUNT(forum_id) as threads, u.name as moderator
        FROM
            frm_forum f LEFT JOIN frm_posts p
               ON f.id = p.forum_id AND p.topic_id = 0
            LEFT JOIN frm_users u ON f.forum_moderator = u.id
        GROUP BY
            f.id';
$result = mysql_query($sql, $db)or die(mysql_error($db));
if (mysql_num_rows($result) == 0) {
  echo '<h2>Moment�ln� neexistuj� ��dn� diskusn� f�ra.</h2>';
} else {
  ?>
<table>
<tr>
  <th>Diskusn� f�rum</th>
  <th>Konverzace</th>
  <th>Moder�tor</th>
</tr>
<?php
$odd = true;
while ($row = mysql_fetch_array($result)) {
  echo ($odd == true) ? '<tr class="odd_row">' : '<tr class="even_row">';
  $odd = !$odd;
  echo '<td><a href="frm_view_forum.php?f=' . $row['id'] . '">' .
  $row['forum'] . '</a><br/>' . $row['description'] . '</td>';
  echo '<td style="text-align: center;">' . $row['threads'] . '</td>';
  echo '<td>' . $row['moderator'] . '</td>';
  echo '</tr>';
}
echo '</table>';
}

require 'frm_footer.inc.php';
?>