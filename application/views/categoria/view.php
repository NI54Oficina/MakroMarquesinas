<?php
if($categoria["actual"]==0){
	?> <h3>No hay marquesina vigente.</h3> <?php 
}else{ ?>
	<h3><a href="<?php echo base_url(array("marquesina","view",$categoria["actual"])); ?>">Ver Marquesina vigente.</a></h3>
<?php } ?>

<?php if($marquesinas==null){ ?>
	<h3>No hay marquesinas con esta categoria</h3>
<?php }else{ ?>
<table id="table" style="width:100%;">
<thead> <tr>
            <th style="min-width:50px;">id</th>
            <th style="min-width:300px;">Fecha inicio</th>
            <th style="min-width:300px;">Título</th>
            <th style="min-width:70px;"></th>
        </tr>
	</thead>
<tbody>
<?php 
foreach($marquesinas as $marquesina){ ?>
	
	<tr> <td><?php echo $marquesina['id']; ?></td>
	<td><span style="display:none;"><?php echo strtotime($marquesina['inicio']); ?></span><?php echo date('d/m/Y H:i', strtotime($marquesina['inicio'])); ?></td>
	<td><?php echo $marquesina['nombre']; ?></td>
	<td class='btn-tablas'><a href='<?php echo base_url(array("marquesina","view",$marquesina['id'])); ?>'><span class='glyphicon glyphicon-file'></span> </a>
		<a href='<?php echo base_url(array("marquesina","update",$marquesina['id'])); ?>'><span class='glyphicon glyphicon-pencil'></span></a>
		<p class='delete' href='<?php echo base_url(array("marquesina",'delete',$marquesina['id'])); ?>'><span class='glyphicon glyphicon-trash'></span> </p>
	</td></tr>
	<?php
}

?>
</tbody>
</table>

<script>
var table;
$(document).ready(function(){
    table=$('#table').DataTable({"columnDefs": [ {
"targets": 3,
"orderable": false
} ],"order": [[ 1, "desc" ]]});
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

<?php } ?>

<style>
#table thead th{border-right:1px solid white}
</style>