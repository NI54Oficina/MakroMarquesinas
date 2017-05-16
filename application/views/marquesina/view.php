
<h4><strong>Categoria:</strong> <?php echo $marquesina["categoria_nombre"];  ?></h4>
<h5><strong>Fecha de inicio:</strong> <?php if(isset($marquesina['inicio'])) {echo date('d/m/Y H:i', strtotime($marquesina['inicio'])); }; 
?></h5>



<form id="uploader" action="<?php echo site_url(array('marquesina','upload')); ?>" style="width:90%;" class="dropzone"></form>

<button id="reordenar" type="button">Reordenar elementos</button>
<button id="save" style="display:none;" type="button">Guardar Orden</button>
<h3 id="saving" style="display:none;">Guardando...</h3>
<div id="imagenesMarquesina">
<?php 
$lastOrden=0;
foreach($marquesina["imagenes"] as $imagen){ ?>
<div class="preview" imageId='<?php echo $imagen['id']; ?>' orden='<?php echo $imagen['orden']; ?>'>
	<div class="dz-image">
		<img src="<?php echo base_url().'uploads/'.$imagen['marquesina'].'/'.$imagen['id'].$imagen['formato']; ?>" />
	</div><br>
	<div class="delete" >Borrar</div>
</div>
<?php $lastOrden=$imagen["orden"]; } ?>
</div>


<script>
var lastOrden=<?php echo ++$lastOrden; ?>;
var uploading=false;
Dropzone.options.uploader = {
  addRemoveLinks: true,
  init: function() {
	this.on("sending", function(file, xhr, formData){
						try{
						$("#imagenesMarquesina").sortable( "disable" );
						}catch(error){}
						uploading=true;
						$("#reordenar").hide();
						$("#save").hide();
                        formData.append("marquesina", "<?php echo $marquesina['id']; ?>");
                        formData.append("orden", lastOrden);
						lastOrden++;


                });
	this.on("success", function(file,response,event){
		console.log(response);
		//agregar a todos los complete un attr con time
		//en interval se va disminuyendo en 1
		//comienza en 3
		//en 0 borra elementos
		//console.log(file.previewElement.innerHTML);
		response=JSON.parse(response);
		$("#imagenesMarquesina").append("<div class='preview' imageId='"+response.id+"' orden='"+response.orden+"' >"+file.previewElement.innerHTML+"<br><div class='delete' >Borrar</div></div>");

		AddTimer();
	});
	
	 this.on("complete", function (file) {
      if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
        console.log("queue terminado");
		uploading=false;
		$("#reordenar").show();
		
      }
    });
	
  }

  

};

 $( function() {
  
  } );

function AddTimer(){
	$(".dz-success").each(function(){
		//console.log($(this).attr("timer"));
		if($(this).attr("timer")==null){
			$(this).attr("timer",4);
		}
	});
}

setInterval(function(){CheckCompletes();},1000);

function CheckCompletes(){
	$(".dz-success").each(function(){
		//console.log($(this).attr("timer"));
		if($(this).attr("timer")==null){
			$(this).attr("timer",4);
		}else{
			$(this).attr("timer",$(this).attr('timer')-1);
		}
		if($(this).attr("timer")==0){
			$(this).remove();
		}
	});
}

$("body").on("click","#reordenar",function(){
	if(!uploading){
		$(".delete").hide();
	  $( "#imagenesMarquesina" ).sortable();
	   $( "#imagenesMarquesina" ).sortable( "option", "disabled", false );
		$( "#imagenesMarquesina" ).disableSelection();
		$("#uploader").hide();
		$("#save").show();
		$("#reordenar").hide();
	}
});

$("body").on("click",".delete",function(){
	var auxId=$(this).parent().attr('imageId');
	var auxParent= $(this).parent();
	$(auxParent).css("opacity",0.5);
	$(auxParent).append("<div class='deleting'>Borrando...</div>")
	$(this).hide();
	$.post('<?php echo base_url(); ?>marquesina/deleteImagen/'+auxId,function(){
		$(auxParent).remove();
	});
});

$("body").on("click","#save",function(){
	var auxOrden=1;
	var auxIds= {};
	$("#imagenesMarquesina > .preview").each(function(){
		//console.log($(this).attr("imageId"));
		$(this).attr("orden",auxOrden);
		auxIds[$(this).attr("imageId")]=auxOrden;
		auxOrden++;
	});
	var auxJson={marquesina:<?php echo $marquesina["id"]; ?>};
	auxJson["ids"]= auxIds;
	$("#imagenesMarquesina").sortable( "disable" );
	$("#save").hide();
	$("#saving").show();
	
	$.post('<?php echo base_url(); ?>marquesina/orden',{json:JSON.stringify(auxJson)},function(response,data){
		$("#saving").hide();
		console.log(response);
		$("#reordenar").show();
		
		$("#uploader").show();
		$(".delete").show();
	});
	  
	  
});


</Script>



<style>
#imagenesMarquesina .preview > div,#imagenesMarquesina .preview > .dz-remove{display:none;}
#imagenesMarquesina .preview > .dz-image,#imagenesMarquesina .preview > .left-arrow,#imagenesMarquesina .preview > .right-arrow{display:inline-block;}
#imagenesMarquesina .preview{display:inline-block;padding:5px;}
#imagenesMarquesina .preview img{max-width:100px;}
#imagenesMarquesina .preview .deleting{color:red;display: block !important;}
#imagenesMarquesina .preview .delete{color:red;display: block;cursor:pointer;}
</style>