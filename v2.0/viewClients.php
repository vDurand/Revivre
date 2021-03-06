<?php
$pageTitle = "Clients";
	include('bandeau.php');
?>
		<script src="js/sorttable.js"></script>
		<script>
        $(document).ready(function() {
            $('.tooltip').tooltipster();
        });
    	</script>
		<div id="corps">
			<div id="labelT">     
				<label>Liste des Clients</label>
			</div><br>
				<div class="listeClients">
					<table class="sortable" cellpadding="5">
						<thead>
							<tr>
								<td class="premierCol" style="text-align: center; width: 150px;">
									Structure
								</td>
                                <td style="text-align: center; width: 150px;">
                                    Nom
                                </td>
								<td style="text-align: center; width: 150px;">
									Prénom
								</td>
								<td class="sorttable_nosort tooltip" style="text-align: center; width: 150px; cursor: help;" title="Vous ne pouvez pas classer par telephone fixe.">
									Tél Fixe
								</td>
								<td class="sorttable_nosort tooltip" style="text-align: center; width: 150px; cursor: help;" title="Vous ne pouvez pas classer par telephone portable.">
									Tél Portable
								</td>
								<td style="text-align: center; width: 150px;">
									Email
								</td>
								<td style="text-align: center; width: 150px;">
									Adresse
								</td>
							</tr>
						</thead>
						<tbody>
<?php
	$reponse = mysqli_query($db, 'SELECT * FROM Clients cl JOIN Personnes pe ON cl.PER_Num=pe.PER_Num ORDER BY CLI_Structure');
	while ($donnees = mysqli_fetch_assoc($reponse))
	{
?>
							<form method="get" action="detailClient.php" name="detailClient">
								<input type="hidden" name="NumC" value="">
									<tr onclick="javascript:submitViewDetail('<?php echo $donnees['CLI_NumClient']; ?>', 'detailClient');" style="font-size: 14;">
                                        <td><?php echo formatUP($donnees['CLI_Structure']); ?></td>
										<td><?php echo formatUP($donnees['PER_Nom']); ?></td>
										<td><?php echo formatLOW($donnees['PER_Prenom']); ?></td>
										<td><?php echo $donnees['PER_TelFixe']; ?></td>
										<td><?php echo $donnees['PER_TelPort']; ?></td>
										<td><a href="mailto:<?php echo $donnees['PER_Email'];?>"><?php echo $donnees['PER_Email']; ?></a></td>
										<td>
										<?php
											if(!empty($donnees['PER_Adresse'])){
												echo formatLOW($donnees['PER_Adresse']).", "; 
											}
											if(!empty($donnees['PER_Ville'])){
												echo formatUP($donnees['PER_Ville'])." "; 
											}
											if(!empty($donnees['PER_CodePostal'])){
												echo $donnees['PER_CodePostal']; 
											}
											?>
										  </td>
									</tr>
							</form>
<?php
	}
	mysqli_free_result($reponse);
?>
						</tbody>
					</table>
				</div>
		</div>
<?php  
	include('footer.php');
?>