<?php
date_default_timezone_set('Europe/Prague');

function msg_box($message, $title, $destination = 'frm_index.php') {
  $msg = '<div>';
  $msg .= '<h2>' . $title . '</h2>';
  $msg .= '<p>' . $message . '</p>';
  $msg .= '<p><a href="' . $destination . '">Ano</a> <a href="frm_index.php">' .
        'Ne</a></p>';
  $msg .= '</div>';
  return $msg;
}

function get_forum($db, $id) {
  $sql = 'SELECT
              forum_name as name, forum_desc as description,
              forum_moderator as moderator
          FROM
              frm_forum
          WHERE id = ' . $id;
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  $row = mysql_fetch_assoc($result);
  mysql_free_result($result);
  return $row;
}

function get_forum_id($db, $topic_id) {
  $sql = 'SELECT forum_id FROM frm_posts WHERE id = ' . $topic_id;
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  $row = mysql_fetch_assoc($result);
  $retVal = $row['forum_id'];
  mysql_free_result($result);
  return $retVal;
}

function breadcrumb($db, $id, $get_from = 'F') {
  $separator = ' &middot; ';
  if ($get_from == 'P') {
    $sql = 'SELECT forum_id, subject FROM frm_posts WHERE id = ' . $id;
    $result = mysql_query($sql, $db) or die(mysql_error($db));
    $row = mysql_fetch_array($result);
    $id = $row['forum_id'];
    $topic = $row['subject'];
    mysql_free_result($result);
  }
  $row = get_forum($db, $id);

  $bcrumb = '<a href="frm_index.php">Dom�</a>' . $separator;
  switch ($get_from) {
    case 'P':
      $bcrumb .= '<a href="frm_view_forum.php?f=' . $id . '">' . $row['name'] .
            '</a>' . $separator . $topic;
      break;

    case 'F':
      $bcrumb .= $row['name'];
      break;
  }
  return '<h2>' . $bcrumb . '</h2>';
}

function show_topic($db, $topic_id, $user_id, $limit = 25) {

  echo breadcrumb($db, $topic_id, 'P');

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }

  $start = ($page - 1) * $limit;

  if (isset($_SESSION['user_id'])) {
    echo topic_reply_bar($db, $topic_id, get_forum_id($db, $topic_id));
  }

  $sql = 'SELECT SQL_CALC_FOUND_ROWS
              p.id, p.subject, p.body, p.date_posted, p.date_updated,
              u.name as author, u.id as author_id, u.signature as sig,
              c.post_count as postcount, p.forum_id as forum_id,
              f.forum_moderator as moderator, p.update_id, u2.name as updated_by
          FROM
              frm_forum f JOIN frm_posts p ON f.id = p.forum_id
              JOIN frm_users u ON u.id = p.author_id
              LEFT JOIN frm_users u2 ON u2.id = p.update_id
              LEFT JOIN frm_post_count c ON u.id = c.user_id
          WHERE
              p.topic_id = ' . $topic_id . ' OR
              p.id = ' . $topic_id . '
          ORDER BY
              p.topic_id, p.date_posted
          LIMIT ' . $start . ', ' . $limit;
  $result = mysql_query($sql, $db) or die(mysql_error($db));

  $page_links = paginate($db, $limit);
  if (mysql_num_rows($result) == 0) {
    $msg = 'Do tohoto diskusn�ho f�ra je�t� nebyl odesl�n ��dn� p��sp�vek. ' .
           'Bu�te prvn� a vytvo�te novou konverzaci!';
    $title = "��dn� p��sp�vky...";
    $dest = "frm_compose.php?forumid=" . $forum_id;
    echo msg_box($msg, $title, $dest);
  } else {
    echo '<table style="width: 80%;">';
    echo '<tr>';
    echo '<th>Autor</th>';
    echo '<th style="width: 85%;">P��sp�vek</th>';
    echo '</tr>';
    $rowclass = '';
    while ($row = mysql_fetch_array($result)) {
      $lastupdate = '';
      $editlink = '';
      $dellink = '';
      $replylink = '&nbsp;';
      $pcount = '';
      $pdate = '';
      $sig = '';
      $body = $row['body'];
      if (isset($_SESSION['user_id'])) {
        $replylink = '<a href="frm_compose.php?forumid=' .
        $row['forum_id'] . '&topicid=' . $topic_id .'&reid=' .
        $row['id'] . '">ODPOV�D�T</a> ';
      } else {
        $replylink = '';
      }
      if ($row['update_id'] > 0) {
        $lastupdate = '<p>Posledn� zm�na: ' . datum($row['date_updated']) .
                    ', upravil ' . $row['updated_by'] . '</p>';
      }
      if ($user_id == $row['author_id'] ||
        $user_id == $row['moderator'] ||
        (isset($_SESSION['access_lvl']) && $_SESSION['access_lvl'] > 2)) {
        $editlink = '<a href="frm_compose.php?a=edit&post=' .
        $row['id'] . '">UPRAVIT</a> ';
        $dellink = '<a href="frm_transact_affirm.php?' .
          'action=odstranitprispevek&id=' . $row['id'] . '">ODSTRANIT</a> ';
      }
      $pcount = '<br/>P��sp�vk� celkem: ' . ($row['postcount'] == '' ? 0 :
        $row['postcount']);
      $pdate = datum($row['date_posted']);
      $sig = (($row['sig'] != '') ? '<p class="sig">' .
        bbcode($db, nl2br($row['sig'])) : '') . '</p>';
      $rowclass = ($rowclass == 'odd_row') ? 'even_row' : 'odd_row';
      echo '<tr class="' . $rowclass . '">';
      echo '<td>' . $row['author'];
      echo $pcount;
      echo '</td><td><p>';
      if (isset($_SESSION['user_id']) &&
        $_SESSION['last_login'] < $row['date_posted']) {
        echo NEWPOST . ' ';
      }
      if (isset($_GET['page'])) {
        $pagelink = '&page=' . $_GET['page'];
      } else {
        $pagelink = '';
      }
      echo '<a name="post' . $row['id'] . '" href="frm_view_topic.php?t=' .
      $topic_id . $pagelink . '#post' . $row['id'] . '">' . POSTLINK .
                '</a>';
      if (isset($row['subject'])) {
        echo ' <strong>' . $row['subject'] . '</strong>';
      }
      echo '</p><p>' . bbcode($db, nl2br(htmlspecialchars($body))) . '</p>';
      echo $sig;
      echo $lastupdate;
      echo '</td>';
      echo '</tr><tr class="' . $rowclass . '">';
      echo '<td>' . $pdate . '</td>';
      echo '<td style="text-align: right;">';
      echo $replylink;
      echo $editlink;
      echo $dellink;
      echo '</td></tr>';
    }
    echo '</table>';
    echo $pagelink;
    echo '<p>' . NEWPOST . ' = Nov� p��sp�vek&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo POSTLINK . ' = Odkaz na p��sp�vek (pou��t jako z�lo�ku)</p>';
  }
}

function isParent($page) {
  return (strpos($_SERVER['PHP_SELF'], $page) !== false);
}

function topic_reply_bar($db, $topic_id, $forum_id) {
  $html = '<p>';
  if ($topic_id > 0) {
    $html .= '<a href="frm_compose.php?forumid=' . $forum_id . '&topicid=' .
    $topic_id . '&reid=' . $topic_id . '">Odpov�d�t v konverzaci</a>';
  }
  if ($forum_id > 0) {
    $html .= ' <a href="frm_compose.php?forumid=' . $forum_id . '">' .
             'Nov� konverzace</a>';
  }
  $html .= '</p>';
  return $html;
}

function user_option_list($db, $level) {
  $sql = 'SELECT
              id, name, access_lvl
          FROM
              frm_users
          WHERE
              access_lvl = ' . $level . '
          ORDER BY
              name';
  $result = mysql_query($sql) or die(mysql_error($db));

  while ($row = mysql_fetch_array($result)) {
    echo '<option value="' . $row['id'] . '">' .
    htmlspecialchars($row['name']) . '</option>';
  }
  mysql_free_result($result);
}

function paginate($db, $limit = 10) {
  global $admin;

  $sql = 'SELECT FOUND_ROWS();';
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  $row = mysql_fetch_array($result);
  $numrows = $row[0];
  $pagelinks = '<p>';
  if ($numrows > $limit) {
    if(isset($_GET['page'])){
      $page = $_GET['page'];
    } else {
      $page = 1;
    }
    $currpage = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
    $currpage = str_replace('&page=' . $page, '', $currpage);

    if($page == 1) {
      $pagelinks .= '&lt; P�EDCHOZ�';
    } else {
      $pageprev = $page - 1;
      $pagelinks .= '<a href="' . $currpage . '&page=' . $pageprev .
                '">&lt; P�EDCHOZ�</a>';
    }

    $numofpages = ceil($numrows / $limit);
    $range = $admin['pageRange']['value'];
    if ($range == '' or $range == 0) {
      $range = 7;
    }
    $lrange = max(1, $page - (($range - 1) / 2));
    $rrange = min($numofpages, $page + (($range - 1) / 2));
    if (($rrange - $lrange) < ($range - 1)) {
      if ($lrange == 1) {
        $rrange = min($lrange + ($range - 1), $numofpages);
      } else {
        $lrange = max($rrange - ($range - 1), 0);
      }
    }

    if ($lrange > 1) {
      $pagelinks .= '..';
    } else {
      $pagelinks .= '&nbsp;&nbsp;';
    }
    for($i = 1; $i <= $numofpages; $i++) {
      if ($i == $page) {
        $pagelinks .= $i;
      } else {
        if ($lrange <= $i and $i <= $rrange) {
          $pagelinks .= '<a href="' . $currpage . '&page=' . $i .
                        '">' . $i . '</a>';
        }
      }
    }
    if ($rrange < $numofpages) {
      $pagelinks .= '..';
    } else {
      $pagelinks .= '&nbsp;&nbsp;';
    }

    if(($numrows - ($limit * $page)) > 0) {
      $pagenext = $page + 1;
      $pagelinks .= '<a href="' . $currpage . '&page=' . $pagenext .
                '">DAL�� &gt;</a>';
    } else {
      $pagelinks .= 'DAL�� &gt;';
    }
  } else {
    $pagelinks .= '&lt; P�EDCHOZ�&nbsp;&nbsp;DAL�� &gt;&nbsp;&nbsp;';
  }
  $pagelinks .= '</p>';
  return $pagelinks;
}

function bbcode($db, $data) {
  $sql = 'SELECT
              template, replacement
          FROM
              frm_bbcode';
  $result = mysql_query($sql, $db) or die(mysql_error($db));
  if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_array($result)) {
      $bbcode['tpl'][] = '/' .
      html_entity_decode($row['template'], ENT_QUOTES). '/i';
      $bbcode['rep'][] = html_entity_decode($row['replacement'],
        ENT_QUOTES);
    }
    $data1 = preg_replace($bbcode['tpl'], $bbcode['rep'], $data);
    $count = 1;
    while (($data1 != $data) and ($count < 4)) {
      $count++;
      $data = $data1;
      $data1 = preg_replace($bbcode['tpl'], $bbcode['rep'], $data);
    }
  }
  return $data;
}

function datum($datestring){
  $datetime = strtotime($datestring);
  $format_string = "d.m.Y H:i:s";
  $datum = date($format_string, $datetime);
  return $datum;
}
?>
