<?php include 'cms_header.inc.php'; ?>
<h1>P�ipomenut� zapomenut�ho hesla</h1>
<p>Zapomn�li jste heslo? Zadejte adresu a my v�m za�leme nov�!</p>
<form method="post" action="cms_transact_user.php">
 <div>
  <label for="email">Elektronick� adresa:</label>
  <input type="text" id="email" name="email" maxlength="100"/>
  <input type="submit" name="action" value="Nov� heslo!"/>
 </div>
</form>
<?php include 'cms_footer.inc.php'; ?>