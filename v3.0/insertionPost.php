<?php
include('bandeau.php');
?>
    <div id="corps">
        <?php
        // Ajout personne en insertion
        $type=addslashes($_POST["Type"]);
        $dateEntretien=addslashes($_POST["Entretien"]);
        $nom=addslashes(mysqli_real_escape_string($db, formatUP($_POST["Nom"])));
        $prenom=addslashes(mysqli_real_escape_string($db, formatLOW($_POST["Prenom"])));
        $dateN=addslashes($_POST["DateNai"]);
        $nation=addslashes(mysqli_real_escape_string($db, formatUP($_POST["Nationalite"])));
        $lieuN=addslashes(mysqli_real_escape_string($db, formatUP($_POST["LieuNai"])));
        $situationF=addslashes(mysqli_real_escape_string($db, formatUP($_POST["Situation"])));
        $tel=addslashes(mysqli_real_escape_string($db, $_POST["Tel_Fixe"]));
        $port=addslashes(mysqli_real_escape_string($db, $_POST["Portable"]));
        $fax=addslashes(mysqli_real_escape_string($db, $_POST["Fax"]));
        $email=addslashes(mysqli_real_escape_string($db, $_POST["Email"]));
        $add=addslashes(mysqli_real_escape_string($db, formatLOW($_POST["Adresse"])));
        $cp=addslashes($_POST["Code_Postal"]);
        $ville=addslashes(mysqli_real_escape_string($db, formatUP($_POST["Ville"])));
        $nPoleEmploi=addslashes($_POST["N_Pole"]);
        $nSecu=addslashes($_POST["N_Secu"]);
        $nCaf=addslashes($_POST["N_CAF"]);
        $numRef=addslashes($_POST["Ref"]);
        $prescripteur=addslashes($_POST["Prescipteur"]);
        $convention=addslashes($_POST["Convention"]);


        $queryPerMax = mysqli_query($db, "SELECT MAX(PER_Num) as maxi FROM Personnes");
        $resultPerMax = mysqli_fetch_assoc($queryPerMax);
        $perMax = $resultPerMax['maxi']+1;

        if($type==0){
            $queryCliMax = mysqli_query($db, "SELECT MAX(CLI_NumClient) as maxi FROM Clients");
            $resultCliMax = mysqli_fetch_assoc($queryCliMax);
            $cliMax = $resultCliMax['maxi']+1;

            if($partic == "Structure"){
                $insertClient = "INSERT INTO Clients (CLI_NumClient, CLI_Nom, CLI_Adresse, CLI_CodePostal, CLI_Ville, CLI_Telephone, CLI_Portable, CLI_Fax, CLI_Email) VALUES ($cliMax, '$nom', '$add', '$cp', '$ville', '$tel', '$port', '$fax', '$email')";
                $sql = mysqli_query($db, $insertClient);
                $errr = mysqli_error($db);
            }
            else if($partic == "Particulier"){
                $insertPersonne = "INSERT INTO Personnes (PER_Num, PER_Nom, PER_Prenom, PER_TelFixe, PER_TelPort, PER_Fax, PER_Email, PER_Adresse, PER_CodePostal, PER_Ville) VALUES ($perMax, '$nom', '$prenom', '$tel', '$port', '$fax', '$email', '$add', '$cp', '$ville')";
                $sql3 = mysqli_query($db, $insertPersonne);
                $errr3 = mysqli_error($db);

                if($sql3){
                    $insertClient = "INSERT INTO Clients (CLI_NumClient, CLI_Nom, CLI_Adresse, CLI_CodePostal, CLI_Ville, CLI_Telephone, CLI_Portable, CLI_Fax, CLI_Email) VALUES ($cliMax, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
                    $sql2 = mysqli_query($db, $insertClient);
                    $errr2 = mysqli_error($db);

                    if($sql2){
                        $insertEmployerClient = "INSERT INTO EmployerClient (CLI_NumClient, PER_Num, EMC_Fonction) VALUES ($cliMax, $perMax, NULL)";
                        $sql = mysqli_query($db, $insertEmployerClient);
                        $errr = mysqli_error($db);
                    }
                }
            }
        }

        if($type==1){
            $queryFouMax = mysqli_query($db, "SELECT MAX(FOU_NumFournisseur) as maxi FROM Fournisseurs");
            $resultFouMax = mysqli_fetch_assoc($queryFouMax);
            $fouMax = $resultFouMax['maxi']+1;

            $insertFourn = "INSERT INTO Fournisseurs (FOU_NumFournisseur, FOU_Nom, FOU_Adresse, FOU_CodePostal, FOU_Ville, FOU_Telephone, FOU_Portable, FOU_Fax, FOU_Email) VALUES ($fouMax, '$nom', '$add', '$cp', '$ville', '$tel', '$port', '$fax', '$email')";
            $sql = mysqli_query($db, $insertFourn);
            $errr = mysqli_error($db);
        }

        if($type==2){
            $insertPersonne = "INSERT INTO Personnes (PER_Num, PER_Nom, PER_Prenom, PER_TelFixe, PER_TelPort, PER_Fax, PER_Email, PER_Adresse, PER_CodePostal, PER_Ville) VALUES ($perMax, '$nom', '$prenom', '$tel', '$port', '$fax', '$email', '$add', '$cp', '$ville')";
            $sql2 = mysqli_query($db, $insertPersonne);
            $errr2 = mysqli_error($db);

            if($sql2){
                $queryRefMax = mysqli_query($db, "SELECT MAX(REF_NumRef) as maxi FROM Referents");
                $resultRefMax = mysqli_fetch_assoc($queryRefMax);
                $refMax = $resultRefMax['maxi']+1;

                $insertRef = "INSERT INTO Referents (REF_NumRef, PER_Num, REF_Prescripteur) VALUES ($refMax, $perMax, '$prescript')";
                $sql = mysqli_query($db, $insertRef);
                $errr = mysqli_error($db);
            }
        }

        if($type>2){
            $insertPersonne = "INSERT INTO Personnes (PER_Num, PER_Nom, PER_Prenom, PER_TelFixe, PER_TelPort, PER_Fax, PER_Email, PER_Adresse, PER_CodePostal, PER_Ville) VALUES ($perMax, '$nom', '$prenom', '$tel', '$port', '$fax', '$email', '$add', '$cp', '$ville')";
            $sql2 = mysqli_query($db, $insertPersonne);
            $errr2 = mysqli_error($db);

            if($sql2){
                $querySalMax = mysqli_query($db, "SELECT MAX(SAL_NumSalarie) as maxi FROM Salaries");
                $resultSalMax = mysqli_fetch_assoc($querySalMax);
                $salMax = $resultSalMax['maxi']+1;

                $insertSal = "INSERT INTO Salaries (SAL_NumSalarie, PER_Num, SAL_Fonction, TYP_Id) VALUES ($salMax, $perMax, '$fonct', '$type')";
                $sql = mysqli_query($db, $insertSal);
                $errr = mysqli_error($db);
            }
        }

        if($sql){
            echo '<div id="good">
        <label>Contact ajouté avec succès</label>
        </div>';
            if($type==0){
                echo '<script language="Javascript">
            <!--
            document.location.replace("detailClient.php?NumC='.$cliMax.'");
            // -->
            </script>';
            }
            if($type==1){
                echo '<script language="Javascript">
            <!--
            document.location.replace("detailFournisseur.php?NumC='.$fouMax.'");
            // -->
            </script>';
            }
            if($type==2){
                echo '<script language="Javascript">
            <!--
            document.location.replace("detailFournisseur.php?NumC='.$refMax.'");
            // -->
            </script>';
            }
            if($type>1){
                echo '<script language="Javascript">
            <!--
            document.location.replace("detailSal.php?NumC='.$salMax.'");
            // -->
            </script>';
            }
        }
        else{
            echo '<div id="bad">
          <label>Le contact n\'a pas pu être ajouté</label>
          </div>';

        }
        ?>
    </div>
<?php
include('footer.php');
?>