
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-1" >
	<div class=" col-12 col-sm-12 col-md-4 col-lg-3">
		<div class="input-group">
			<h3 class="text-muted">Atividades (<?= @$NM_PROJ ?>)</h3>	
		</div>
	</div>	
	

	<div class="col-12 col-sm-6 col-md-4 col-lg-4">
		<form id="nomodal" method="get" action="<?= BASEURL.'atividades/busca/'.$INT_PROJ ?>">
			<div class="input-group">
                <input type="text" name="palavra" id="palavra" placeholder="palavra chave" class="busca form-control" value="<?= @$palavra ?>"/>
                <div class="input-group-append">
                  <input  type="submit" value="Buscar" class="btn btn-primary"/>
                </div>
            </div>
		</form>
	</div>
	
	<div class=" col-12 col-sm-6 col-md-4 col-lg-3 ">	
		
		<form id="nomodal"  method="get" action="<?= BASEURL.'atividades/novo/'.$INT_PROJ ?>"  >
			<input class="btn btn-info" onclick="javascript:window.location.href= '<?= BASEURL ?>'" type="button" value="Home">
			<input  type="submit" class="btn btn-success " value="Nova atividade" title="nova atividade">
		</form>
	</div>
    
</nav>

<div class="row">
	<div class="col-lg-12" style="overflow: auto;">
		<?= $render ;?>
	</div>
</div>
