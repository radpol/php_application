<html>
  <head>
    <title>Odesl�n� pohlednice</title>
    <style type="text/css">
     td { vertical-align: top; }
    </style>
  </head>
  <body>
    <form method="post" action="sendmail.php">
      <table>
        <tr>
          <td>Komu:</td>
          <td><input type="text" name="to_address" size="40"/></td>
        </tr><tr>
          <td>Od:</td>
          <td><input type="text" name="from_address" size="40"/></td>
        </tr><tr>
          <td>P�edm�t:</td>
          <td><input type="text" name="subject" size="40"/></td>
        </tr><tr>
          <td valign="top">Zpr�va:</td>
          <td>
            <textarea cols="60" rows="10"
              name="message">Sem vlo�te text zpr�vy.</textarea>
          </td>
        </tr><tr>
          <td></td>
          <td>
            <input type="submit" value="Odeslat"/>
            <input type="reset" value="Vypr�zdnit"/>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
