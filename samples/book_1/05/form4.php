<html>
  <head>
    <title>V�ce��elov� formul��</title>
    <style type="text/css">
      <!--
      td {vertical-align: top;}
      -->
    </style>
  </head>
  <body>
    <form action="form4a.php" method="post">
      <table>
        <tr>
          <td>N�zev nebo jm�no</td>
          <td><input type="text" name="name" /></td>
        </tr><tr>
          <td>Typ z�znamu</td>
          <td>
            <input type="radio" name="type" value="movie" checked="checked" />
             Film<br/>
            <input type="radio" name="type" value="actor" /> Herec<br/>
            <input type="radio" name="type" value="director"/> Re�is�r<br/>
          </td>
        </tr><tr>
          <td>Filmov� ��nr<br/><small>(hod�-li se)</small></td>
          <td>
            <select name="movie_type">
              <option value="">Vyberte ��nr...</option>
              <option value="Action">Ak�n�</option>
              <option value="Drama">Drama</option>
              <option value="Comedy">Komedie</option>
              <option value="Sci-Fi">Sci-Fi</option>
              <option value="War">V�le�n�</option>
              <option value="Other">Jin�...</option>
            </select>
          </td>
        </tr><tr>
          <td> </td>
          <td><input type="checkbox" name="debug" checked="checked" />
            Zobrazit ladic� informace
          </td>
        </tr><tr>
          <td colspan="2" style="text-align: center;">
            <input type="submit" name="submit" value="Vyhledat" />
            <input type="submit" name="submit" value="P�idat" />
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>