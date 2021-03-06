<?php
$pageTitle = "Detail Client";
    include('bandeau.php');
?>
    <div id="corps">
<?php
  $num=intval($_GET["NumC"]);
  if (is_numeric($_GET["NumC"]))
  {

  $reponse = mysqli_query($db, "SELECT * FROM Clients cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num WHERE CLI_NumClient='$num'");
  $donnees = mysqli_fetch_assoc($reponse);
  if ($donnees) {
?>
      <div id="labelT">     
            <label>Detail du Client</label>
      </div>
      <br>
      <table id="fullTable" rules="all">
        <td>
          <table cellpadding="10" class="detailClients">
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Nom :</th>
              <td style="text-align: left; width: 300px;"><?php echo formatUP($donnees['PER_Nom']); ?></td>
            </tr>
            <?php if ($donnees['CLI_Structure'] != "Structure") { ?>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Prenom :</th>
              <td style="text-align: left; width: 300px;"><?php echo formatLOW($donnees['PER_Prenom']); ?></td>
            </tr>
            <?php } ?>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Telephone Fixe :</th>
              <td style="text-align: left; width: 300px;"><?php echo $donnees['PER_TelFixe']; ?></td>
            </tr>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Telephone Portable :</th>
              <td style="text-align: left; width: 300px;"><?php echo $donnees['PER_TelPort']; ?></td>
            </tr>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Fax :</th>
              <td style="text-align: left; width: 300px;"><?php echo $donnees['PER_Fax']; ?></td>
            </tr>
            <?php if ($donnees['CLI_Structure'] == "Structure") { ?>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">&nbsp;</th>
              <td style="text-align: left; width: 300px;">&nbsp;</td>
            </tr>
            <?php } ?>
          </table>
        </td>
        <td>
          <table cellpadding="10" class="detailClients">
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Email :</th>
              <td style="text-align: left; width: 300px;"> 	<A HREF="mailto:<?php echo $donnees['PER_Email'];?>"> <?php echo $donnees['PER_Email']; ?></A></td>
            </tr>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Adresse :</th>
              <td style="text-align: left; width: 300px;"><?php echo formatLOW($donnees['PER_Adresse']); ?></td>
            </tr>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Ville :</th>
              <td style="text-align: left; width: 300px;"><?php echo formatUP($donnees['PER_Ville']); ?></td>
            </tr>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Code Postal :</th>
              <td style="text-align: left; width: 300px;"><?php echo $donnees['PER_CodePostal']; ?></td>
            </tr>
            <tr>
              <th style="text-align: left; width: 200px; white-space: normal;">Structure :</th>
              <td style="text-align: left; width: 300px;"><?php echo $donnees['CLI_Structure']; ?></td>
            </tr>
          </table>
        </td>
      </table>
      <form method="post" action="editClient.php" name="EditClient">
        <input type="hidden" name="NumC" value="<?php echo $donnees['CLI_NumClient']; ?>">
        <table id="downT">
          <tr>
            <td>
              <span>
                <input name="submit" type="submit" value="Modifier" class="buttonC">
              </span>
            </td>
          </tr>
        </table>
      </form>
      <!-- List Chantiers -->
      <?php
      if (mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM Chantiers JOIN Commanditer USING(CHA_NumDevis) WHERE CLI_NumClient='$num'"))) {

          ?>
          <div id="labelCat">
              Liste des Chantiers
          </div>
          <div class="listeMembers" style="margin-bottom: 15px;">
          <table>
          <thead>
          <tr>
              <td class="firstCol" style="text-align: center; width: 30px;">
                  <a>#</a>
              </td>
              <td style="text-align: center;">
                  <a>Chantier</a>
              </td>
              <td style="text-align: center;">
                  <a>Adresse</a>
              </td>
              <td style="text-align: center;">
                  <a>Date de Début</a>
              </td>
              <td style="text-align: center;">
                  <a>Echeance</a>
              </td>
          </tr>
          </thead>
          <tbody>
          <?php
          $i = 0;
          $reponse5 = mysqli_query($db, "SELECT * FROM Chantiers JOIN Commanditer USING(CHA_NumDevis) WHERE CLI_NumClient='$num'");
          while ($donnees5 = mysqli_fetch_assoc($reponse5))
          {
              ?>
              <tr style="font-size: 14;">
                  <td><?php $i++; echo $i; ?></td>
                  <td><?php echo $donnees5['CHA_Intitule']; ?></td>
                  <td><?php echo $donnees5['CHA_Adresse']; ?></td>
                  <td><?php echo dater($donnees5['CHA_DateDebut']); ?></td>
                  <td><?php echo dater($donnees5['CHA_Echeance']); ?></td>
              </tr>
          <?php
          }
          mysqli_free_result($reponse5);
      }
      ?>
      </tbody>
      </table>
      </div>
<?php
  } else {
  	echo "<div id='error'>ERROR : WRONG NUMBER</div>";
  }
  } else {
  	echo "<div id='error'>ERROR : NUMBER ONLY</div>";
  }
  
  mysqli_free_result($reponse);
?>
</div>
<?php  
    include('footer.php');
?>