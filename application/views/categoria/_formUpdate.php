	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input class="form-control" name="nombre" value="<?php if(isset($categoria['nombre'])){echo $categoria['nombre'];} ?>" />
	</div>
	
	
	
	<div class="form-group">
		<label for="activa">Estado</label>
		<select class="form-control" name="activa">
			<option value="1" <?php if(isset($categoria['categoria'])&&$categoria['categoria']==$categoria['id']){?>selected<?php } ?>>Activa</option>
			<option value="0" <?php if(isset($categoria['categoria'])&&$categoria['categoria']==$categoria['id']){?>selected<?php } ?>>Inactiva</option>
		</select>
	</div>
	

	
	<button>Guardar</button>
