<?php include 'cms_header.inc.php'; ?>
<h1>P�ihl�en� �lena</h1>
<form method="post" action="cms_transact_user.php">
  <table>
    <tr>
      <td><label for="email">Elektronick� adresa:</label></td>
      <td><input type="text" id="email" name="email" maxlength="100"/></td>
    </tr><tr>
      <td><label for="password">Heslo:</label></td>
      <td><input type="password" id="password" name="password"
                 maxlength="20"/></td>
    </tr><tr>
      <td> </td>
      <td><input type="submit" name="action" value="P�ihl�sit"/></td>
    </tr>
  </table>
</form>
<p>Nejste �lenem? <a href="cms_user_account.php">Vytvo�te nov� ��et!</a></p>
<p><a href="cms_forgot_password.php">Zapomn�li jste heslo?</a></p>
<?php include 'cms_footer.inc.php'; ?>
