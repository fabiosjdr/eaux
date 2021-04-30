<form  name="form" id="form" method="post" action="<?= BASEURL ?>inicial/processar" >
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-1" >
      <div class="col-12">
        <div class="float-right  mr-4">
          <input type="button" class="btn btn-success" onclick="instalar()" value="Iniciar">
        </div>
      </div>
      
  </nav>
  
  <div class="col-lg-12 p-4 bg-secondary">
    
    <!--<div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Bem vindo a tela inicial do desafio EAUX</h1>
            <p class="lead">Vamos configurar o banco de dados, por favor preencha as informações abaixo.</p>
        </div>
    </div> -->
    <div class="row">
        
        <div class="col-lg-4">
          <label>Host </label>
          <input type="text" required class="form-control" value="" name="host" id="host" > 
        </div>   

        <div class="col-lg-2">
          <label>Usuário</label>
          <input type="text" required class="form-control" value="" name="user" id="user"> 
        </div>  

        <div class="col-lg-2">
          <label>Senha</label>
          <input type="text" required class="form-control" value="" name="pass" id="pass"> 
        </div>

        <div class="col-lg-2">
          <label>Nome do banco</label>
          <input type="text" required class="form-control" value="" name="dbname" id="dbname"> 
        </div>

    </div>        

    

  </div>

  <div class="row p-3 ">

        <div id="retorno" class="alert col-12 text-center" role="alert">
          
        </div>
    </div>
</form>

<script>

  function instalar(){
              
      $.post(ajaxpath + 'iniciar/ajax/processar',$('#form').serialize(),function(data){
          
          if(data.sucesso == true){
            
            $('#retorno').html(data.mensagem).removeClass('alert-warning').addClass('alert-success');
            
          }else{
           
            $('#retorno').html(data.mensagem).removeClass('alert-success').addClass('alert-warning');
          }

      },'JSON');
  }
  
</script>