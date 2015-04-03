<?php
	$pageTitle = "Envoi de planning ACI/Insertion";
	$pwd='../../';
	include($pwd.'bandeau.php');
?>
<div id="corps">
  <?php
  	if(isset($_POST['Date']) && isset($_POST['Tableau']) && isset($_POST["Modify"]) && isset($_POST['typePL']))
  	{
  		$date=$_POST["Date"];
  		$typePL = $_POST['typePL'];
		$query = mysqli_query($db, "SELECT count(distinct ASSOC_date) as 'result' FROM pl_association WHERE ASSOC_date=date('".$date."') AND PL_id = 1 ORDER BY ASSOC_date DESC;");
  		$data = mysqli_fetch_assoc($query);
  		$tableau=$_POST["Tableau"];
		$array = json_decode($tableau);

		if($_POST["Modify"] == 'true')
		{
		  	$query = mysqli_query($db, 'DELETE FROM pl_association WHERE ASSOC_date=date("'.$date.'") AND PL_id = 1;');
	  		if($query)
			{
					$queryString = "INSERT INTO pl_association(SAL_NumSalarie, ENC_Num, CRE_id, PL_id, ASSOC_date) VALUES ";
					for($x=0; $x<sizeof($array); $x++)
					{
						$queryString = ($x==0) ? $queryString."(".$array[$x][0].",".$array[$x][1].",".$array[$x][2].", ".$typePL.", date('".$date."'))" : $queryString.",(".$array[$x][0].",".$array[$x][1].",".$array[$x][2].", ".$typePL.", date('".$date."'))";

					}
					$query = mysqli_query($db, $queryString.";");
					if(!$query)
	        		{
	        			echo '<div id="bad">
					      <label>Une erreur s\'est produite lors de la modification du planning !</label>
					      </div>';
	        		}
	        		else
	        		{
		        		echo '<div id="good">
			            <label>Le planning de la semaine du lundi '.date("d/m/Y", strtotime($date)).' a été modifié avec succès !</label>
			            </div>';
	        		}
	        }
		}
		elseif($data["result"] == 0)
		{
			$queryString = "INSERT INTO pl_association(SAL_NumSalarie, ENC_Num, CRE_id, PL_id, ASSOC_date) VALUES ";
			for($x=0; $x<sizeof($array); $x++)
			{
				$queryString = ($x==0) ? $queryString."(".$array[$x][0].",".$array[$x][1].",".$array[$x][2].", ".$typePL.", date('".$date."'))" : $queryString.",(".$array[$x][0].",".$array[$x][1].",".$array[$x][2].", ".$typePL.", date('".$date."'))";

			}
			$query = mysqli_query($db, $queryString.";");
			if(!$query)
    		{
    			echo '<div id="bad">
		              <label>Une erreur s\'est produite lors de la sauvegarde du planning !</label>
		              </div>';
    		}
    		else
    		{
				echo '<div id="good">
		            <label>Planning de la semaine du lundi '.date("d/m/Y", strtotime($date)).' ajouté avec succès !</label>
		            </div>';
    		}	        
		}
		else
		{
	        echo '<div id="bad">
	              <label>Une erreur s\'est produite lors de la sauvegarde du planning !</label>
	              </div>';
		}
	}
	else
	{	        
		echo '<div id="bad"> 
	              <label>Une erreur s\'est produite lors de la sauvegarde du planning !</label>
	              </div>';
	}
	if(isset($_POST['redirectPage']))
	{
		$locationPath = $_POST['redirectPage'];
	    echo '<script type="text/javascript">
		window.setTimeout("location=(\''.$locationPath.'\');",2500);
		</script>';
	}
	else
	{
		echo '<script type="text/javascript">
		window.setTimeout("location=(\''.$pwd.'home.php\');",2500);
		</script>';
	}

  ?>
</div>
<?php
  	include($pwd.'footer.php');
?>