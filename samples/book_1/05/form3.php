<html>
  <head>
    <title>P�id�v�n� a vyhled�v�n�</title>
    <style type="text/css">
      <!--
      td {vertical-align: top;}
      -->
    </style>
  </head>
  <body>
    <form action="zpracovat3.php" method="post">
      <table>
        <tr>
          <td>N�zev nebo jm�no</td>
          <td><input type="text" name="name"/></td>
        </tr><tr>
          <td>��nr</td>
          <td>
            <select name="movie_type">
              <option value="">Vyberte ��nr...</option>
              <option value="ak�n�">Ak�n�</option>
              <option value="dramatick�">Drama</option>
              <option value="komedi�ln�">Komedie</option>
              <option value="Sci-Fi">Sci-Fi</option>
              <option value="v�le�n�">V�le�n�</option>
              <option value="neza�azen�">Jin�...</option>
            </select>
          </td>
        </tr><tr>
          <td>Typ z�znamu</td>
          <td>
            <input type="radio" name="type" value="movie" checked="checked" />
              Film<br/>
            <input type="radio" name="type" value="actor" /> Herec<br/>
            <input type="radio" name="type" value="director"/> Re�is�r<br/>
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