<div class="repertoire-bloc">
	<fieldset>
		<legend>Personne à contacter en cas d'urgence</legend>
		<table class="form_table">
			<tr>
				<td><label for="INS_UrgNom">Nom :</label></td>
				<td><input class="inputC" type="text" id="INS_UrgNom" name="INS_UrgNom" <?php echo isset($personne["INS_UrgNom"]) ? 'value="'.stripslashes($personne["INS_UrgNom"]).'"' : "";?>/></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="INS_UrgPrenom">Prénom :</label></td>
				<td><input class="inputC" type="text" id="INS_UrgPrenom" name="INS_UrgPrenom" <?php echo isset($personne["INS_UrgPrenom"]) ? 'value="'.stripslashes($personne["INS_UrgPrenom"]).'"' : "";?>/></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="INS_UrgTel">Téléphone :</label></td>
				<td><input class="inputC" type="text" id="INS_UrgTel" name="INS_UrgTel" maxlength="10" <?php echo isset($personne["INS_UrgTel"]) ? 'value="'.$personne["INS_UrgTel"].'"' : "";?>/></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</fieldset>
</div>