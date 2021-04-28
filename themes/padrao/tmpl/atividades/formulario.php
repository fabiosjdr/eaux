<form  name="form" id="nomodal" method="post" action="<?= BASEURL ?>atividades/salvar" >
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-1" >
      <div class="col-lg-6 col-sm-6 col-8">
        <div class="input-group">
          <h3 class="text-muted">Nova Atividade</h3> 
        </div>
      </div>
      <div class="text-right mr-4">
         <input class="btn btn-info" onclick="javascript:window.location.href= '<?= BASEURL ?>'" type="button" value="Home">
         <input type="submit" class="btn btn-success" value="Salvar">
      </div>
  </nav>
  
  <div class="col-lg-12 p-4 bg-secondary">
   
    <div class="row">
        <div class="col-lg-4">
          <label>Nome da atividade</label>
          <input type="text" required class="form-control" value="<?= @$dados->NM_ATVD; ?>" name="NM_ATVD" id="NM_PROJ" > 
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
          
            <label>Finalizado</label>
               
            <select class="form-control" name="LG_FIN" id="LG_FIN" >
                <option value="S"> Sim </option>
                <option selected value="N"> Não </option>
            </select>
        </div>

    </div>        
   
    <input name="INT_PROJ" type="hidden" id="INT_PROJ" value="<?= $INT_PROJ; ?>"/>  
    <input name="INT_PROJ_ATV" type="hidden" id="INT_PROJ_ATV" value="<?= @$dados->INT_PROJ_ATV; ?>"/>
    

  </div>
</form>

<script>

  $(document).ready(function(){
      
      $('#D_INI').on('change',function(){

        if( $('#D_FIM').val() != '' && $('#D_INI').val() > $('#D_FIM').val()  ){
          alert('A data inicial não pode ser maior que a data final');
          $('#D_INI').val('').focus();
        }

      });

      $('#D_FIM').on('change',function(){

        if( $('#D_INI').val() != '' && $('#D_FIM').val() < $('#D_INI').val()  ){
          alert('A data final não pode ser menor que a data inicial');
          $('#D_FIM').val('').focus();
        }

      });

  });
</script>