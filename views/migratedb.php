<div>
	<h4>Hemos detectado que no se ha creado la base de datos</h4>
	<p>Recuerde que debe configurar los datos de acceso en <b> config/database.php </b></p>
	<p>Actualmente los valores son:</p>
	<p class="code">
	$host = "<?php echo $host?>";<br>
	$username = "<?php echo $username?>";<br>
	$password = "<?php echo $password?>";<br>
	$database = "<?php echo $database?>";<br>
	</p>
	<p>¿Desea continuar?</p>
	<button class="btn" id="migrateDb">Crear base de datos y tabla</button>
	<span class="form-error hidden" id="error"></span>
</div>