<?php include 'frm_header.inc.php'; ?>
<h2>P�ipomenut� zapomenut�ho hesla</h2>
<p>Pokud jste zapomn�li heslo nebo je syst�m odm�t�, zadejte pros�m
svou elektronickou adresu, na kterou v�m je budeme moci zaslat!</p>
<form method="post" action="frm_transact_user.php">
  <div>
    <label for="email">Kontaktn� email:</label>
    <input type="text" id="email" name="email" maxlength="100"/>
    <input type="submit" name="action" value="P�ipomenout heslo"/>
  </div>
</form>
<?php include 'frm_footer.inc.php'; ?>