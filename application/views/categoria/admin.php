<table id="table" style="width:100%;">
<thead> <tr>
            <th>id</th>
            <th style="min-width:300px;">Título</th>
            <th style="min-width:100px;">Vigente</th>
            <th style="min-width:70px;"></th>
        </tr>
	</thead>
<tbody>
<?php 
foreach($categorias as $categoria){ ?>
	
	<tr> <td><?php echo $categoria['id']; ?></td>
	<td><?php echo $categoria['nombre']; ?></td>
	<td><?php if($categoria["actual"]==0){ ?> 
	No hay marquesina vigente.
	<?php }else{ ?>
	<a target="_blank" href="<?php echo base_url(array("marquesina","view",$categoria["actual"])); ?>">Ver Marquesina vigente.</a>
	<?php } ?></td>
	<td class='btn-tablas'><a href='<?php echo base_url(array("categoria","view",$categoria['id'])); ?>'><span class='glyphicon glyphicon-file'></span> </a>
		<a href='<?php echo base_url(array("categoria","update",$categoria['id'])); ?>'><span class='glyphicon glyphicon-pencil'></span></a>
		<p class='delete' href='<?php echo base_url(array("categoria",'delete',$categoria['id'])); ?>'><span class='glyphicon glyphicon-trash'></span> </p>
	</td>
	</tr>
	<?php
}

?>
</tbody>
</table>

<script>
var table;
$(document).ready(function(){
    table=$('#table').DataTable({"columnDefs": [ {
"targets": 2,
"orderable": false
} ]});
	$("[type='search']").attr("placeholder","Busqueda");
});

jQuery(document).on('click','.delete',function() {
	if(!confirm('¿Seguro que desea borrar este elemento?')) return false;
	$(".loading").show();
	var row=this;
	
	$.post( $(this).attr('href'), function( data ) {
		console.log("borrado");
		 table
        .row( $(row).parents('tr') )
        .remove()
        .draw();
		$(".loading").hide();
		
	});
	
});

</script>