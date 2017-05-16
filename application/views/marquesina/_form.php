

	<div class="form-group">
		<label for="nombre">Nombre</label>
		<input class="form-control" name="nombre" value="<?php if(isset($marquesina['nombre'])){echo $marquesina['nombre'];} ?>"/>
	</div>
	
	<div class="form-group">
		<label for="inicio">Fecha de inicio</label>
		<div class="input-group date form_date col-md-6" data-date="<?php echo date('d/m/Y H:i', time()) ?>" data-date-format="dd/mm/yyyy hh:ii" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd-hh-ii">
			<input class="form-control" placeholder="Elegí Fecha" size="16" type="text" value="<?php if(isset($marquesina['inicio'])) {echo date('d/m/Y H:i', strtotime($marquesina['inicio'])); }?>" readonly >
			<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
			<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
		</div>
		<input type="hidden" id="dtp_input2" value="<?php if(isset($marquesina['inicio'])) {echo $marquesina['inicio']; }?>"  name="inicio" />
		<script>
			jQuery('.form_date').datetimepicker({
			language:  'ar',
			weekStart: 0,
			todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			minView: 0,
			forceParse: 0
			});
		</script>
    </div>
		
	<div class="form-group">
		<label for="categoria">Categoria</label>
		<select class="form-control" name="categoria">
			<option disabled <?php if(!isset($marquesina["categoria"])){ ?>selected<?php } ?> >Seleccionar Categoria</option>
			<?php foreach($categorias as $categoria){ ?>
			<option value="<?php echo $categoria['id']; ?>" <?php if(isset($marquesina['categoria'])&&$marquesina['categoria']==$categoria['id']){?>selected<?php } ?>><?php echo $categoria["nombre"]; ?></option>
			<?php } ?>
			
		</select>
	</div>

	
	<button>Guardar</button>

	
	
	
