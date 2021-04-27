<form  name="form" id="nomodal" method="post" action="<?= BASEURL ?>projetos/salvar" >
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-1" >
      <div class="col-lg-6 col-sm-6 col-8">
        <div class="input-group">
          <h3 class="text-muted">Nova Atividade</h3> 
        </div>
      </div>
      <div class="text-right mr-4">
         <input type="submit" class="btn btn-success" value="Salvar">
      </div>
  </nav>
  
  <div class="col-lg-12 p-4 bg-secondary">
   
    <div class="row">
        <div class="col-lg-4">
          <label>Nome da atividade</label>
          <input type="text" required class="form-control" value="<?= @$dados->NM_PROJ; ?>" name="NM_ATVD" id="NM_PROJ" > 
        </div>   


        <div class="col-lg-2">
          <label>Data de início</label>
          <input type="date" required class="form-control" value="<?= @$dados->D_INI; ?>" name="D_INI" id="D_INI"> 
        </div>  

        <div class="col-lg-2">
          <label>Data de término</label>
          <input type="date" required class="form-control" value="<?= @$dados->D_FIM; ?>" name="D_FIM" id="D_FIM"> 
        </div>

        <div class="col-lg-2">
          
            <label>Data de término</label>
               
            <div class="custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                <label class="custom-control-label" for="customSwitch1">Finalizado</label>
            </div>
          
        </div>

    </div>        
   
    <input name="INT_PROJ" type="hidden" id="INT_PROJ" value="<?= @$dados->INT_PROJ; ?>"/>  
    <input name="INT_PROJ_ATVD" type="hidden" id="INT_PROJ_ATVD" value="<?= @$dados->INT_PROJ_ATVD; ?>"/>
    

  </div>
</form>

<script>

  $(document).ready(function(){
      
  });
</script>