<?php
/**
 * Created by Valentin Durand
 * IUT Caen - DUT Informatique
 * Date: 22/11/14
 * Time: 18:34
 */
    $pageTitle = "Suivi Encadrants";
    include('bandeau.php');

    if(!empty($_POST['Encad'])){
        $numEnc = $_POST['Encad'];
    }
    else{
        $numEnc = 0;
    }
    if(!empty($_POST['Annee'])){
        $year = $_POST['Annee'];
    }
    else{
        $year = 0;
    }
    if(!empty($_POST['Mois'])){
        $month = $_POST['Mois'];
    }
    else{
        $month = 0;
    }

    $totMP = 0;
    $totAP = 0;
    $totAT = 0;
    $totEA = 0;
    $totHP = 0;
    $totHT = 0;
    $totEH = 0;
    $totNS = 0;
?>
    <script src="js/sorttable.js"></script>
    <link rel="stylesheet" href="css/print.css">
    <div id="corps">
        <div id="labelCat" style="padding-bottom: 15px;">
            <form method="post" action="suiviEnc.php" name="Encadrant">
                <table align="center">
                    <tr>
                        <td style="text-align: left; width: 100px;">
                            <label>Encadrant</label>
                        </td>
                        <td>
                            <div class="selectType">
                                <select name="Encad" onchange="this.form.submit()">
                                    <option <?php if($numEnc == 0){echo "selected";} ?> value="0">--</option>
                                    <?php
                                    $reponse = mysqli_query($db, "SELECT Distinct SAL_NumSalarie, PER_Nom, PER_Prenom FROM Encadrer JOIN Salaries USING (SAL_NumSalarie) JOIN Personnes USING (PER_Num) ORDER BY PER_Nom");
                                    while ($donnees = mysqli_fetch_assoc($reponse))
                                    {
                                        ?>
                                        <option <?php if($donnees['SAL_NumSalarie'] == $numEnc){echo "selected";} ?> value="<?php echo $donnees['SAL_NumSalarie']; ?>"><?php echo formatUP($donnees['PER_Nom'])." ".formatLOW($donnees['PER_Prenom']); ?></option>
                                        <?php
                                    }
                                    mysqli_free_result($reponse);
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td style="text-align: left; width: 100px;">
                            <label>Année</label>
                        </td>
                        <td>
                            <div class="selectType">
                                <select name="Annee" onchange="this.form.submit()">
                                    <option <?php if($year == 0){echo "selected";} ?> value="0">--</option>
                                    <?php
                                    for($annee=date("Y")+1;$annee>2000;$annee--)
                                    {
                                        ?>
                                        <option <?php if($annee == $year){echo "selected";} ?> value="<?php echo $annee; ?>"><?php echo $annee; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <td style="text-align: left; width: 100px;">
                            <label>Mois</label>
                        </td>
                        <td>
                            <div class="selectType">
                                <select name="Mois" onchange="this.form.submit()">
                                    <option <?php if($month == 0){echo "selected";} ?> value="0">--</option>
                                    <option <?php if($month == 1){echo "selected";} ?> value="1">Janvier</option>
                                    <option <?php if($month == 2){echo "selected";} ?> value="2">Février</option>
                                    <option <?php if($month == 3){echo "selected";} ?> value="3">Mars</option>
                                    <option <?php if($month == 4){echo "selected";} ?> value="4">Avril</option>
                                    <option <?php if($month == 5){echo "selected";} ?> value="5">Mai</option>
                                    <option <?php if($month == 6){echo "selected";} ?> value="6">Juin</option>
                                    <option <?php if($month == 7){echo "selected";} ?> value="7">Juillet</option>
                                    <option <?php if($month == 8){echo "selected";} ?> value="8">Août</option>
                                    <option <?php if($month == 9){echo "selected";} ?> value="9">Septembre</option>
                                    <option <?php if($month == 10){echo "selected";} ?> value="10">Octobre</option>
                                    <option <?php if($month == 11){echo "selected";} ?> value="11">Novembre</option>
                                    <option <?php if($month == 12){echo "selected";} ?> value="12">Décembre</option>
                                </select>
                            </div>
                        </td>
                        <td><input formtarget="_blank" class="printButton" type="button" onclick="window.print();"name="printer" value="Imprimer"/></td>
                    </tr>
                </table>
            </form>
        </div>
        <table class="tableContact">
            <thead>
            <tr>
                <td class="firstCol" style="text-align: center; width: 20%;">Intitulé</td>
                <td style="text-align: center; width: 10%;">Montant</td>
                <td style="text-align: center; width: 10%;">Achats Prévus</td>
                <td style="text-align: center; width: 10%;">Achats Totaux</td>
                <td style="text-align: center; width: 10%;">Ecart Achat</td>
                <td style="text-align: center; width: 10%;">Heures prévues</td>
                <td style="text-align: center; width: 10%;">Heures Tolales</td>
                <td style="text-align: center; width: 10%;">Ecart MO</td>
                <td style="text-align: center; width: 10%;">NB Salariés</td>
            </tr>
            </thead>
            <tbody>
<?php

    /*
     * VIEWS USED HERE :
     *
     * -- ChantierAchat --
     * create or replace view ChantierAchat as
     * select CHA_NumDevis, CHA_AchatsPrev,
     * ROUND(sum(ACH_Montant),2) as AchatTot,
     * ROUND((CHA_AchatsPrev-sum(ACH_Montant)),2) as EcartAch
     * from Chantiers
     * JOIN Acheter USING (CHA_NumDevis)
     * group by CHA_NumDevis;
     *
     * -- ChantierHeure --
     * create or replace view ChantierHeure as
     * select CHA_NumDevis, CHA_HeuresPrev,
     * sum(TRA_Duree) as HeureTot,
     * (CHA_HeuresPrev-sum(TRA_Duree)) as EcartHeure,
     * COUNT(DISTINCT SAL_NumSalarie) as NbSalarie
     * from Chantiers
     * JOIN TempsTravail USING (CHA_NumDevis)
     * group by CHA_NumDevis;
     *
     */

    if($numEnc == 0){
        if($year == 0){
            $query = "select CHA_Intitule, CHA_Echeance, CHA_MontantPrev, ch.CHA_AchatsPrev, AchatTot, EcartAch, he.CHA_HeuresPrev, HeureTot, EcartHeure, NbSalarie
            from Chantiers ch
            LEFT JOIN ChantierAchat ac ON ch.CHA_NumDevis=ac.CHA_NumDevis
            JOIN ChantierHeure he ON ch.CHA_NumDevis=he.CHA_NumDevis
            JOIN Encadrer en ON ch.CHA_NumDevis=en.CHA_NumDevis
            ORDER BY CHA_Intitule";
        }
        elseif($month == 0){
            $query = "select CHA_Intitule, CHA_Echeance, CHA_DateDebut, CHA_DateFinReel, CHA_MontantPrev, ch.CHA_AchatsPrev, AchatTot, EcartAch, he.CHA_HeuresPrev, HeureTot, EcartHeure, NbSalarie
            from Chantiers ch
            LEFT JOIN ChantierAchat ac ON ch.CHA_NumDevis=ac.CHA_NumDevis
            JOIN ChantierHeure he ON ch.CHA_NumDevis=he.CHA_NumDevis
            JOIN Encadrer en ON ch.CHA_NumDevis=en.CHA_NumDevis
            WHERE (CHA_Echeance >= '".$year."-"."01"."-01' OR CHA_DateFinReel >= '".$year."-"."01"."-01' OR CHA_DateFinReel is null)
            AND CHA_DateDebut <= '".$year."-"."12"."-31'
            ORDER BY CHA_Intitule";
        }
        else{
            $query = "select CHA_Intitule, CHA_Echeance, CHA_DateDebut, CHA_DateFinReel, CHA_MontantPrev, ch.CHA_AchatsPrev, AchatTot, EcartAch, he.CHA_HeuresPrev, HeureTot, EcartHeure, NbSalarie
            from Chantiers ch
            LEFT JOIN ChantierAchat ac ON ch.CHA_NumDevis=ac.CHA_NumDevis
            JOIN ChantierHeure he ON ch.CHA_NumDevis=he.CHA_NumDevis
            JOIN Encadrer en ON ch.CHA_NumDevis=en.CHA_NumDevis
            WHERE (CHA_Echeance >= '".$year."-".$month."-01' OR CHA_DateFinReel >= '".$year."-".$month."-01' OR CHA_DateFinReel is null)
            AND CHA_DateDebut <= '".$year."-".$month."-31'
            ORDER BY CHA_Intitule";
        }
    }
    elseif($year == 0){
        $query = "select CHA_Intitule, CHA_Echeance, CHA_DateDebut, CHA_DateFinReel, CHA_MontantPrev, ch.CHA_AchatsPrev, AchatTot, EcartAch, he.CHA_HeuresPrev, HeureTot, EcartHeure, NbSalarie
            from Chantiers ch
            LEFT JOIN ChantierAchat ac ON ch.CHA_NumDevis=ac.CHA_NumDevis
            JOIN ChantierHeure he ON ch.CHA_NumDevis=he.CHA_NumDevis
            JOIN Encadrer en ON ch.CHA_NumDevis=en.CHA_NumDevis
            WHERE en.SAL_NumSalarie = $numEnc
            ORDER BY CHA_Intitule";
    }
    elseif($month == 0){
        $query = "select CHA_Intitule, CHA_Echeance, CHA_DateDebut, CHA_DateFinReel, CHA_MontantPrev, ch.CHA_AchatsPrev, AchatTot, EcartAch, he.CHA_HeuresPrev, HeureTot, EcartHeure, NbSalarie
            from Chantiers ch
            LEFT JOIN ChantierAchat ac ON ch.CHA_NumDevis=ac.CHA_NumDevis
            JOIN ChantierHeure he ON ch.CHA_NumDevis=he.CHA_NumDevis
            JOIN Encadrer en ON ch.CHA_NumDevis=en.CHA_NumDevis
            WHERE en.SAL_NumSalarie = $numEnc
            AND (CHA_Echeance >= '".$year."-"."01"."-01' OR CHA_DateFinReel >= '".$year."-"."01"."-01' OR CHA_DateFinReel is null)
            AND CHA_DateDebut <= '".$year."-"."12"."-31'
            ORDER BY CHA_Intitule";
    }
    else{
        $query = "select CHA_Intitule, CHA_Echeance, CHA_DateDebut, CHA_DateFinReel, CHA_MontantPrev, ch.CHA_AchatsPrev, AchatTot, EcartAch, he.CHA_HeuresPrev, HeureTot, EcartHeure, NbSalarie
            from Chantiers ch
            LEFT JOIN ChantierAchat ac ON ch.CHA_NumDevis=ac.CHA_NumDevis
            JOIN ChantierHeure he ON ch.CHA_NumDevis=he.CHA_NumDevis
            JOIN Encadrer en ON ch.CHA_NumDevis=en.CHA_NumDevis
            WHERE en.SAL_NumSalarie = $numEnc
            AND (CHA_Echeance >= '".$year."-".$month."-01' OR CHA_DateFinReel >= '".$year."-".$month."-01' OR CHA_DateFinReel is null)
            AND CHA_DateDebut <= '".$year."-".$month."-31'
            ORDER BY CHA_Intitule";
    }

    $reponse = mysqli_query($db, $query);
    while ($donnees = mysqli_fetch_assoc($reponse)){
?>
            <tr>
                <td><?php echo formatLOW($donnees['CHA_Intitule']); ?></td>
                <td><?php echo $donnees['CHA_MontantPrev']." €"; $totMP += $donnees['CHA_MontantPrev']; ?></td>
                <td><?php echo $donnees['CHA_AchatsPrev']." €"; $totAP += $donnees['CHA_AchatsPrev']; ?></td>
                <td><?php if(!empty($donnees['AchatTot'])){ echo $donnees['AchatTot']." €"; $totAT += $donnees['AchatTot'];} else echo "0 €"; ?></td>
                <td><?php if(!empty($donnees['EcartAch'])){ echo $donnees['EcartAch']." €"; $totEA += $donnees['EcartAch'];} else echo "0 €"; ?></td>
                <td><?php echo $donnees['CHA_HeuresPrev']; $totHP += $donnees['CHA_HeuresPrev']; ?></td>
                <td><?php echo $donnees['HeureTot']; $totHT += $donnees['HeureTot']; ?></td>
                <td><?php echo $donnees['EcartHeure']; $totEH += $donnees['EcartHeure']; ?></td>
                <td><?php echo $donnees['NbSalarie']; $totNS += $donnees['NbSalarie']; ?></td>
            </tr>
<?php
    }
    mysqli_free_result($reponse);
?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="text-align: right; font-size: 14px;">TOTAL&nbsp;&nbsp;</th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totMP." €"; ?></th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totAP." €"; ?></th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totAT." €"; ?></th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totEA." €"; ?></th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totHP; ?></th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totHT; ?></th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totEH; ?></th>
                    <th style="text-align: left; font-size: 14px; padding-left: 5px;"><?php echo $totNS; ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
<?php
include('footer.php');
?>