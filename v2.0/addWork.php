<?php
$pageTitle = "Ajouter Chantier";
include('bandeau.php');
?>
    <div id="corps">
        <div id="labelT">
            <label>Ajouter un Chantier</label>
        </div>
        <br>

        <form method="post" action="chantierPost.php" name="Chantier">
            <div id="labelCat">
                <table align="center">
                    <tr>
                        <td style="text-align: left; width: 150px;">
                            <label for="Client">Client</label>
                        </td>
                        <td>
                            <div class="selectType2">
                                <select id="Client" name="Client">
                                    <optgroup label="Particuliers">
                                        <?php
                                        $i = 2;
                                        $reponse = mysqli_query($db, "SELECT * FROM Clients cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num WHERE CLI_Structure IS NULL ORDER BY PER_Nom");
                                        while ($donnees = mysqli_fetch_assoc($reponse)) {
                                            ?>
                                            <option value="<?php echo $donnees['CLI_NumClient']; ?>"><?php
                                                if (!empty($donnees['PER_Nom'])) {
                                                    echo formatUP($donnees['PER_Nom']);
                                                    if (!empty($donnees['PER_Prenom'])) {
                                                        echo " " . formatLOW($donnees['PER_Prenom']);
                                                    }
                                                }
                                                ?>
                                            </option>
                                            <?php
                                            $i++;
                                        }
                                        mysqli_free_result($reponse);
                                        ?>                                        </optgroup>
                                    <optgroup label="Structures">
                                        <?php
                                        $i = 2;
                                        $reponse = mysqli_query($db, "SELECT * FROM Clients cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num WHERE CLI_Structure IS NOT NULL ORDER BY CLI_Structure");
                                        while ($donnees = mysqli_fetch_assoc($reponse)) {
                                            ?>
                                            <option value="<?php echo $donnees['CLI_NumClient']; ?>"><?php
                                                echo formatUP($donnees['CLI_Structure']);
                                                if (!empty($donnees['PER_Nom'])) {
                                                    echo " (" . formatUP($donnees['PER_Nom']);
                                                    if (!empty($donnees['PER_Prenom'])) {
                                                        echo " " . formatLOW($donnees['PER_Prenom']);
                                                    }
                                                    echo ")";
                                                }
                                                ?></option>
                                            <?php
                                            $i++;
                                        }
                                        mysqli_free_result($reponse);
                                        ?>
                                    </optgroup>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <br/>

            <div>
                <table align="left">
                    <tr>
                        <td>
                            <table id="leftT" cellpadding="10">
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Nom">Nom du Chantier* :</label>
                                    </td>
                                    <td>
                                        <input id="Nom" required maxlength="255" name="Nom" type="text" class="inputC"
                                               autofocus="autofocus">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Debut">Date de Début* :</label>
                                    </td>
                                    <td>
                                        <input id="Debut" required maxlength="255" name="Debut" type="date"
                                               class="inputC">
                                    </td>

                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Fin_Max">Echéance* :</label>
                                    </td>
                                    <td>
                                        <input id="Fin_Max" required maxlength="255" name="Fin_Max" type="date" class="inputC">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Add">Adresse Chantier* :</label>
                                    </td>
                                    <td>
                                        <input id="Add" required maxlength="255" name="Add" type="text" class="inputC">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="tva">TVA (en %)* :</label>
                                    </td>
                                    <td>
                                        <input id="tva" required name="tva" type="number" step="0.01" class="inputC">
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table id="rightT" cellpadding="10">
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Montant_Prev">Montant :</label>
                                    </td>
                                    <td>
                                        <input id="Montant_Prev" maxlength="255" name="Montant_Prev" type="text"
                                               class="inputC" placeholder="&euro;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Achats_Prev">Achats Prévus :</label>
                                    </td>
                                    <td>
                                        <input id="Achats_Prev" maxlength="255" name="Achats_Prev" type="text"
                                               class="inputC" placeholder="&euro;">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Heures_Prev">Heures Prévues :</label>
                                    </td>
                                    <td>
                                        <input id="Heures_Prev" maxlength="255" name="Heures_Prev" type="text"
                                               class="inputC">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="Resp">Responsable :</label>
                                    </td>
                                    <td>
                                        <div class="selectType">
                                            <select id="Resp" name="Resp">
                                                <option value=""></option>
                                                <?php
                                                $reponseType = mysqli_query($db, "SELECT * FROM Type");
                                                while ($donneesType = mysqli_fetch_assoc($reponseType)) {
                                                    $typeNOM = $donneesType['TYP_Nom'];
                                                    $typeID = $donneesType['TYP_Id'];
                                                    ?>
                                                    <optgroup label="<?php echo $typeNOM; ?>">
                                                        <?php
                                                        $reponse = mysqli_query($db, "SELECT * FROM Salaries cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num WHERE TYP_Id=$typeID ORDER BY PER_Nom");
                                                        while ($donnees = mysqli_fetch_assoc($reponse)) {
                                                            ?>
                                                            <option
                                                                value="<?php echo $donnees['SAL_NumSalarie']; ?>"><?php echo formatUP($donnees['PER_Nom']); ?> <?php echo formatLOW($donnees['PER_Prenom']); ?></option>
                                                        <?php
                                                        }
                                                        mysqli_free_result($reponse);
                                                        ?>
                                                    </optgroup>
                                                <?php
                                                }
                                                mysqli_free_result($reponseType);
                                                ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left; width: 150px; white-space: normal;">
                                        <label for="TxH">Taux Horaire* :</label>
                                    </td>
                                    <td>
                                        <input id="TxH" required step="0.01" name="TxH" type="number" class="inputC">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <table id="downT">
                <tr>
                    <td>
							<span>
								<input name="submit" type="submit" value="Ajouter" class="buttonC">&nbsp;&nbsp; 
								<input name="reset" type="reset" value="Annuler" class="buttonC">
							</span>
                    </td>
                </tr>
            </table>
            <br/><br/>
            * : Champs obligatoires.
        </form>
    </div>
<?php
include('footer.php');
?>