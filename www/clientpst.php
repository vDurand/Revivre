<?php  
    include('bandeau.php');
    ?>
    <div id="corps">
<?php
	if($db = MySQLi_connect("localhost","Kepha",'pfudor', 'Revivre', 0, '/media/sds1/home/alx22/private/mysql/socket'))
		echo '';
	else
		echo 'Erreur';

  $nom=addslashes($_POST["Nom"]);
  $prenom=addslashes($_POST["Prenom"]);
  $tel=addslashes($_POST["Tel_Fixe"]);
  $port=addslashes($_POST["Portable"]);
  $fax=addslashes($_POST["Fax"]);
  $email=addslashes($_POST["Email"]);
  $add=addslashes($_POST["Adresse"]);
  $cp=$_POST["Code_Postal"]);
  $ville=addslashes($_POST["Ville"]);

	$query = "INSERT INTO Personnes (PER_Num, PER_Nom, PER_Prenom, PER_TelFixe, PER_TelPort, PER_Fax, PER_Email, PER_Adresse, PER_CodePostal, PER_Ville) VALUES (NULL, '$nom', '$prenom', '$tel', '$port', '$fax', '$email', '$add', '$cp', '$ville')";

  $sql = mysqli_query($db, $query);
  $errr=mysqli_error($db);

    if($sql)                  
      {$query2 = "INSERT INTO Clients (CLI_NumClient, CLI_Structure, PER_Num) VALUES (NULL, )";

        echo '<div id="good">     
            <label>Client ajoute avec succes</label>
            </div>';
            $reponse = mysqli_query($db, "SELECT * FROM Clients WHERE CLI_Nom='$nom' AND CLI_Prenom='$prenom'");
            $donnees = mysqli_fetch_assoc($reponse);
	?>
  <br>
  <table>
  <td>
  <table cellpadding="10" class="submitClients">
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Nom :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['CLI_Nom']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Prenom :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['CLI_Prenom']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Tel Fixe :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['CLI_TelFixe']; ?></td>
    </tr>
  </table>
</td>
<td>
  <table cellpadding="10" class="submitClients">
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Email :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['CLI_Email']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Adresse :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['CLI_Adresse']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Ville :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['CLI_Ville']; ?>, <?php echo $donnees['CLI_CodePostal']; ?></td>
    </tr>
  </table>
</td>
</table>
  <?php
  }
    else
      {echo '<div id="bad">     
            <label>Le client n a pas pu etre ajoute</label>
            </div>';}

  mysqli_free_result($reponse);
  ?>
  </div>
  <?php  
    include('footer.php');
    ?>