<?php
require 'db.inc.php';
require 'frm_output_functions.inc.php';

$db = mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) or
  die ('Nemohu se p�ipojit. Zkontrolujte pros�m p�ipojen� k serveru.');

mysql_select_db(MYSQL_DB, $db) or die(mysql_error($db));

if (isset($_REQUEST['action'])) {
  switch ($_REQUEST['action']) {
    case 'P�idat f�rum':
      if (isset($_POST['forumname']) && $_POST['forumname'] != '' &&
        isset($_POST['forumdesc']) && $_POST['forumdesc'] != '') {
        $sql = 'INSERT IGNORE INTO frm_forum
                  (id, forum_name, forum_desc, forum_moderator)
                VALUES
                  (NULL, "' . htmlspecialchars($_POST['forumname'], ENT_QUOTES) .
                  '", "' . htmlspecialchars($_POST['forumdesc'], ENT_QUOTES) .
                  '", ' . $_POST['forummod'][0] . ')';
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      header('Location: frm_admin.php?option=fora');
      exit();
      break;

    case 'Upravit f�rum':
      if (isset($_POST['forumname']) && $_POST['forumname'] != '' &&
        isset($_POST['forumdesc']) && $_POST['forumdesc'] != '') {
        $sql = 'UPDATE frm_forum SET
                    forum_name = "' . $_POST['forumname'] . '",
                    forum_desc = "' . $_POST['forumdesc'] . '",
                    forum_moderator = ' . $_POST['forummod'][0] . '
                WHERE
                    id = ' . $_POST['forum_id'];
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      header('Location: frm_admin.php?option=fora');
      exit();
      break;

    case 'Upravit ��et':
      header('Location: frm_useraccount.php?user=' . $_POST['userlist'][0]);
      exit();
      break;

    case 'Aktualizovat':
      foreach ($_POST as $key => $value) {
        if ($key != 'action') {
          $sql = 'UPDATE frm_admin SET
                        value="' . $value . '"
                    WHERE
                        constant = "' . $key . '"';
          mysql_query($sql, $db) or die(mysql_error($db));
        }
      }
      header('Location: frm_admin.php');
      exit();
      break;

    case 'odstranitForum':
      $sql = 'DELETE FROM frm_forum WHERE id=' . $_GET['f'];
      mysql_query($sql, $db) or die(mysql_error($db));

      $sql = 'DELETE FROM frm_posts WHERE forum_id=' . $_GET['f'];
      mysql_query($sql, $db) or die(mysql_error($db));

      header('Location: frm_admin.php?option=fora');
      exit();
      break;

    case 'P�idat k�d':
      $sql = 'INSERT INTO frm_bbcode
                (id, template, replacement)
            VALUES
                (NULL, "' . htmlentities($_POST['bbcode-tnew'], ENT_QUOTES) . '",
                "' . htmlentities($_POST['bbcode-rnew'],ENT_QUOTES) . '")';
      mysql_query($sql, $db) or die(mysql_error($db));
      header('Location: frm_admin.php?option=kody');
      exit();
      break;

    case 'odstranitZnacku':
      if (isset($_GET['b'])) {
        $bbcodeid = $_GET['b'];
        $sql = 'DELETE FROM frm_bbcode WHERE id=' . $bbcodeid;
        mysql_query($sql, $db) or die(mysql_error($db));
      }
      header('Location: frm_admin.php?option=kody');
      exit();
      break;

    case 'Aktualizovat form�tovac� k�dy':
      foreach($_POST as $key => $value) {
        if (substr($key, 0, 7) == 'bbcode_') {
          $bbid = str_replace('bbcode_', '', $key);
          if (substr($bbid, 0, 1) == 't') {
            $col = 'template';
          } else {
            $col = 'replacement';
          }
          $id = substr($bbid, 1);
          $sql = 'UPDATE frm_bbcode SET ' .
          $col . ' = "' . htmlentities($value, ENT_QUOTES) . '"
                    WHERE
                        id = ' . $id;
          mysql_query($sql, $db) or die(mysql_error($db));
        }
      }
      header('Location: frm_admin.php?option=kody');
      exit();
      break;

    default:
      header('Location: frm_index.php');
    }
  } else {
    header('Location: frm_index.php');
  }
  ?>