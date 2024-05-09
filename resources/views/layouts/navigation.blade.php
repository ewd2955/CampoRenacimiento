
@props(['navcontent'])
<style>
  .bgc-purple{
   
    color:purple  ;
  }
  .ahover:hover{
    color:gray;
  }
</style>

  <div class="d-flex flex-column p-3" >
    <div class="d-flex flex-row">
    <img src="./logo.jpg" style="width:50px;height:50px;"></img>
   
  <label class="m-2">Punto de venta</label> 
  </div>
 
    <ul class="nav flex-column mt-5">
      <li class="nav-item">
        <a href="/dashboard" class=" nav-link {{ $navcontent == 'ventas' ? ' :active ahover bgc-purple' :'text-dark ' }}" aria-current="page">
        
          Ventas
        </a>
      </li>
      <li>
        <a href="/alta_paciente" class=" nav-link {{ $navcontent == 'alta' ? ':active ahover bgc-purple' :'text-dark ' }}">
         
          Registrar
        </a>
      </li>
      <li>
        <a href="/actualizar_paciente" class="nav-link {{ $navcontent == 'actualizar' ? ':active ahover bgc-purple' :'text-dark ' }}">
       
          Actualizar
        </a>
      </li>
      <li>
        <a href="/corte_de_caja" class="nav-link {{ $navcontent == 'corte' ? ':active ahover bgc-purple' :'text-dark ' }}">
        
          Restablecer
        </a>
      </li>
     
      <li>
        <a href="/cajero" class="nav-link {{ $navcontent == 'cajero' ? ':active  ahover bgc-purple' :'text-dark ' }}">
   
          Terminal
        </a>
      </li>   
    </ul>
  </div>





