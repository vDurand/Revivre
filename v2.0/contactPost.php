<?php  
    include('bandeau.php');
?>
    <div id="corps">
<?php
// Ajout contact
  $type=addslashes($_POST["Type"]);
  $nom=addslashes(mysqli_real_escape_string($db, formatUP($_POST["Nom"])));
  $prenom=addslashes(mysqli_real_escape_string($db, formatLOW($_POST["Prenom"])));
  $tel=addslashes(mysqli_real_escape_string($db, $_POST["Tel_Fixe"]));
  $port=addslashes(mysqli_real_escape_string($db, $_POST["Portable"]));
  $fax=addslashes(mysqli_real_escape_string($db, $_POST["Fax"]));
  $email=addslashes(mysqli_real_escape_string($db, $_POST["Email"]));
  $add=addslashes(mysqli_real_escape_string($db, formatLOW($_POST["Adresse"])));
  $cp=addslashes($_POST["Code_Postal"]);
  $ville=addslashes(mysqli_real_escape_string($db, formatUP($_POST["Ville"])));
  $partic=addslashes($_POST["Particulier"]);
  if($partic == "Particulier"){
      $struct = "";
  }
  else{
      $struct = addslashes(formatUP($_POST["Structure"]));
  }
  $fonct=addslashes(mysqli_real_escape_string($db, $_POST["Fonction"]));

  $query = "INSERT INTO Personnes (PER_Num, PER_Nom, PER_Prenom, PER_TelFixe, PER_TelPort, PER_Fax, PER_Email, PER_Adresse, PER_CodePostal, PER_Ville) VALUES (NULL, '$nom', '$prenom', '$tel', '$port', '$fax', '$email', '$add', '$cp', '$ville')";

  $sql = mysqli_query($db, $query);
  $errr=mysqli_error($db);

    if($sql){
      $numberQuery = mysqli_query($db, "SELECT * FROM Personnes WHERE PER_Nom='$nom' AND PER_Prenom='$prenom' AND PER_Adresse='$add' AND PER_Adresse='$add' AND PER_Ville='$ville'");
      $numberRep = mysqli_fetch_assoc($numberQuery);
      $realNumber = $numberRep['PER_Num'];

      if($type==0){
          if(empty($struct)){
              $query2 = "INSERT INTO Clients (CLI_NumClient, CLI_Structure, PER_Num) VALUES (NULL, NULL, '$realNumber')";
          }
          else{
              $query2 = "INSERT INTO Clients (CLI_NumClient, CLI_Structure, PER_Num) VALUES (NULL, '$struct', '$realNumber')";
          }
      }
      if($type==1){
        $query2 = "INSERT INTO Fournisseurs (FOU_NumFournisseur, FOU_Structure, PER_Num) VALUES (NULL, 'Structure', '$realNumber')";
      }
      if($type>1){
        $query2 = "INSERT INTO Salaries (SAL_NumSalarie, PER_Num, SAL_Fonction, TYP_Id) VALUES (NULL, '$realNumber', '$fonct', '$type')";
      }
      $sql2 = mysqli_query($db, $query2);
      $errr2 = mysqli_error($db);

      if($sql2){
        echo '<div id="good">     
            <label>Contact ajouté avec succès</label>
            </div>';
            if($type==0){
              $reponse = mysqli_query($db, "SELECT * FROM Clients cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num WHERE cl.PER_Num='$realNumber'");
              $donnees = mysqli_fetch_assoc($reponse);
              echo '<script language="Javascript">
              <!--
              document.location.replace("detailClient.php?NumC='.$donnees['CLI_NumClient'].'");
              // -->
              </script>';
            }
            if($type==1){
              $reponse = mysqli_query($db, "SELECT * FROM Fournisseurs cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num WHERE cl.PER_Num='$realNumber'");
              $donnees = mysqli_fetch_assoc($reponse);
              echo '<script language="Javascript">
              <!--
              document.location.replace("detailFournisseur.php?NumC='.$donnees['FOU_NumFournisseur'].'");
              // -->
              </script>';
            }
            if($type>1){
              $reponse = mysqli_query($db, "SELECT * FROM Salaries cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num WHERE cl.PER_Num='$realNumber'");
              $donnees = mysqli_fetch_assoc($reponse);
              echo '<script language="Javascript">
              <!--
              document.location.replace("detailSal.php?NumC='.$donnees['SAL_NumSalarie'].'");
              // -->
              </script>';
            }
?>
  <br>
  <table>
  <td>
  <table cellpadding="10" class="submitClients">
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Nom :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['PER_Nom']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Prénom :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['PER_Prenom']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Tél Fixe :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['PER_TelFixe']; ?></td>
    </tr>
  </table>
</td>
<td>
  <table cellpadding="10" class="submitClients">
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Email :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['PER_Email']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Adresse :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['PER_Adresse']; ?></td>
    </tr>
    <tr>
      <th style="text-align: left; width: 150px; white-space: normal;">Ville :</th>
      <td style="text-align: center; width: 200px;"><?php echo $donnees['PER_Ville']; ?>, <?php echo $donnees['PER_CodePostal']; ?></td>
    </tr>
  </table>
</td>
</table>
<?php
      }
      else{
        echo '<div id="bad">     
              <label>Le contact n\'a pas pu être ajouté</label>
              </div>';
            }
            mysqli_free_result($reponse);
    }
?>
  </div>
<?php  
    include('footer.php');
?>