<?php
session_start();
require 'db.inc.php';
require 'frm_output_functions.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (isset($_REQUEST['action'])) {
  switch (strtoupper($_REQUEST['action'])) {
    case 'ODESLAT P��SP�VEK':
      if (isset($_POST['subject']) && isset($_POST['body']) &&
        isset($_SESSION['user_id'])) {
        $sql = 'INSERT INTO frm_posts
                    (id, topic_id, forum_id, author_id, update_id, date_posted,
                    date_updated, subject, body)
                VALUES (
                    NULL, ' . $_POST['topic_id'] . ', ' .
                    $_POST['forum_id'] . ', ' . $_SESSION['user_id'] . ', 0,
                    "' . date('Y-m-d H:i:s') . '", 0,
                    "' . $_POST['subject'] . '", "' . $_POST['body'] . '")';
        mysql_query($sql, $db) or die(mysql_error($db));
        $postid = mysql_insert_id();

        $sql = 'INSERT IGNORE INTO frm_post_count
                    (user_id, post_count)
                VALUES (' . $_SESSION['user_id'] . ',0)';
        mysql_query($sql, $db) or die(mysql_error($db));

        $sql = 'UPDATE frm_post_count SET
                    post_count = post_count + 1
                WHERE
                    user_id = ' . $_SESSION['user_id'];
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      $topicid = ($_POST['topic_id'] == 0) ? $postid : $_POST['topic_id'];
      header('Location: frm_view_topic.php?t=' . $topicid . '#post' . $postid);
      exit();
      break;

    case 'NOV� KONVERZACE':
      header('Location: frm_compose.php?f=' . $_POST['forum_id']);
      exit();
      break;

    case 'UPRAVIT':
      header('Location: frm_compose.php?a=edit&post=' . $_POST['topic_id']);
      exit();
      break;

    case 'ULO�IT ZM�NY':
      if (isset($_POST['subject']) && isset($_POST['body'])) {
        $sql = 'UPDATE frm_posts SET
                    subject = "' . $_POST['subject'] . '",
                    update_id = ' . $_SESSION['user_id'] . ',
                    body = "' . $_POST['body'] . '",
                    date_updated = "' . date('Y-m-d H:i:s') . '"
                WHERE
                    id = ' . $_POST['post'];
        if (isset($_POST['author_id'])) {
          $sql .= ' AND author_id = ' . $_POST['author_id'];
        }
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      $redirID = ($_POST['topic_id'] == 0) ? $_POST['post'] :$_POST['topic_id'];
      header('Location: frm_view_topic.php?t=' . $redirID);
      exit();
      break;

    case 'ODSTRANIT':
      if ($_REQUEST['post']) {
        $sql = 'DELETE FROM frm_posts WHERE id = ' . $_REQUEST['post'];
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      header('Location: ' . $_REQUEST['r']);
      exit();
      break;
  }
} else {
  header('Location: frm_index.php');
}
?>