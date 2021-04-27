$(document).ready(function(){

	$('form#delete').submit(function(event){ 
		
		event.preventDefault(); //this will prevent the default submit

		var obj = $(this);

		var option = {
			botoes: '<button  id="confirm-exclusao" type="button" class="btn btn-danger">Confirmar</button>'
		};
	
		var msg = 'Tem certeza que deseja remover o registro?';
		
		showModal('Atenção',msg,'','',option);


		$('#area_mensagem_dinamica').on('shown.bs.modal', function(event) {
			//  store current modal reference
			//var modal = $(this);
			
			$('#confirm-exclusao').off().on('click', function() {
				fecharModal();
				
				$(obj).unbind('submit').submit();
			});
		});
		
		
		
	});

	//função para verificar o enter
	$("body").on('keydown','form',function (e) { 
		
		var elemento = document.activeElement;

		if (e.which == 13 && (!$(elemento).hasClass('ignoreenter') ) ) {
		
			e.preventDefault();
			
			if($(elemento).is(':button,:submit')){
				$(elemento).trigger('click');
			}else{ 

				//$(elemento).nextAll(':input:visible,:button:first:visible,:select:first:visible,:textarea:first:visible').focus();
				//console.log($(elemento));
				
				var indices = $(elemento).closest('form')[0].elements.length;
					
				for (var index in $(elemento).closest('form')[0].elements ){
				
					if ($(elemento).closest('form')[0].elements[index] == $(elemento)[0] ){
						
						var nextIndex = parseInt(index) + 1;
						
						if ($($(elemento).closest('form')[0].elements[nextIndex]).not('[tabindex="-1"]').is(':focusable') ){
							$(elemento).closest('form')[0].elements[nextIndex].focus();						
						} else if (nextIndex <= indices ){

							while (nextIndex <= indices){

								nextIndex = nextIndex + 1;							

								if ($($(elemento).closest('form')[0].elements[nextIndex]).not('[tabindex="-1"]').is(':focusable')) {
									$(elemento).closest('form')[0].elements[nextIndex].focus();
									return;
								}
							}
							console.log(nextIndex);
							// $(elemento).closest('form')[0].elements[0].focus();
							$('#btn-salvar-form').focus();
						}
							
						
					}
				}
				
			}		    
		}

	});
		
}); 
		
$('form').ready(function(){
	$(this).focus_first();
});


function alertaSuave(parametros){
	
	parametros.area.addClass('prelative');

	parametros.area.html("<div class='custom-alert " + parametros.classe + "' role='alert'>" + parametros.texto + "<div>").hide().fadeIn('slow');
	
	if(typeof parametros.focus !== 'undefined' ){
		parametros.focus.focus();
	}

	window.setTimeout(function (){		
		$(".custom-alert").fadeOut(1000, function () {
			$(this).remove();
		});
	}, parametros.tempo);
}

function fecharModal(){

	$("#area_mensagem_dinamica").modal("hide");
}

function showModal(Titulo, mensagem, url,parametros,options = false) { 
	//se tiver algum modal aberto ele será fechado
	if ($("#area_mensagem_dinamica").length == 1) {
		if ($("#area_mensagem_dinamica").attr('aria-hidden') == "false") {
			$('.close').trigger('click');
		} else {
			$("#area_mensagem_dinamica").remove();
		}
	}

	if(url){
		$.post(url,parametros,function(data){				
			$(".modal-body").html(data); 				
		}); 
	}
	
	if(options.botoes ){
		var botoes = options.botoes;
	}else{
		var botoes = '';
	}
	
	$('body').append('<div id="area_mensagem_dinamica"   class="modal fade lightbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> \
						<div class="modal-dialog '+options.tamanho+' '+options.alinhamento+'">\
							<div class="modal-content">\
											<div class="modal-header">\
												<h5 class="modal-title">' + Titulo + '</h5>\
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
										          <span aria-hidden="true">&times;</span>\
										        </button>\
										    </div>\
											<div class="modal-body">\
												<p>' + mensagem + '</p>\
											</div>\
											<div class="modal-footer">\
												'+botoes+'\
												<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>\
											</div>\
							</div>\
						</div>\
					  </div>');//fim do append

	$("#area_mensagem_dinamica").modal("show");
}

