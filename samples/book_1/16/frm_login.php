<?php include 'frm_header.inc.php'; ?>
<h1>P�ihl�en� registrovan�ho u�ivatele</h1>
<form method="post" action="frm_transact_user.php">
  <table>
    <tr>
      <td><label for="email">Elektronick� adresa:</label></td>
      <td><input type="text" id="email" name="email" maxlength="100"/></td>
    </tr><tr>
      <td><label for="passwd">Heslo:</label></td>
      <td><input type="password" id="passwd" name="passwd" maxlength="20"/></td>
    </tr><tr>
      <td> </td>
      <td><input type="submit" class="submit" name="action" value="P�ihl�sit"/>
      </td>
    </tr>
  </table>
</form>
<p>Nem�te ��et na na�em serveru?
<a href="frm_useraccount.php">Zalo�te si ho!</a></p>
<p><a href="frm_forgot_pass.php">Z�skat zapomenut� heslo</a></p>
<?php include 'frm_footer.inc.php'; ?>