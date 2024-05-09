<x-app-layout
    navcontent={{$leftnavactive}}>

    <style>
       .styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
}
.styled-table thead tr {
    
    text-align: left;
}
.styled-table th {
  background-color:#FAFAFA;
}
.styled-table td {
    padding: 12px 15px;
    margin: 4px;
}

</style>
<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    // Your code here
    $("#div-success").fadeTo(1000, 0.00, function() {
        $(this).slideUp(200, function() {
            $(this).remove();
        });
    });
    $("#div-error").fadeTo(1000, 0.00, function() {
        $(this).slideUp(200, function() {
            $(this).remove();
        });
    });
});
</script>
<div class="">
    <ul class="nav m-3 d-flex flex-nowrap overflow-auto justify-content-center rounded p-2">
    <li class="nav-item">
    <a class="nav-link " style="color:gray;" href="/actualizar_paciente">Paciente</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" style="color:gray;" aria-current="page" 
          href="/actualizar_empleado">Empleado</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" style="color:purple;" href="/actualizar_producto">Producto</a>
  </li>
</ul>
</div>

<div class="m-3"> 

<?php
if(isset($inserted) && $inserted == true)
{
  echo '<div id="div-success">
  <div class="row mt-2 w-100" style="width:400px">
  <div class="alert alert-success" role="alert">
  Producto actualizado</div>
  </div></div>';
}

if(isset($inserted) && $inserted == false)
{
  echo '<div id="div-error">
  <div class="row mt-2 w-100" style="width:400px">
  <div class="alert alert-danger" role="alert">Error. 
  Verifica los datos</div>
  </div></div>';
}
?>
<div class="">
 
      <table id="productTable" class="styled-table table hover mt-3 mb-2" style="width:100%;">
                    <thead class="border-bottom">
                      <tr  style="text-align:left;" class="">
                        <th style="text-align:left;" scope="col">Nombre</th>
                        <th style="text-align:left;" scope="col">Exs</th>
                        <th style="text-align:left;" scope="col">Codigo</th>
                        <th style="text-align:left;" scope="col">M</th>
                        <th style="text-align:left;" scope="col">Unit</th>
                        <th style="text-align:left;" scope="col">Pub</th>
                        <th style="text-align:left;" scope="col">Gan</th>
                        
                        <th style="text-align:left;" scope="col">Util</th>
                        
                        <th style="text-align:left;" scope="col">Accion</th>

                      </tr>
                    </thead>
                    <tbody id="table-body">
                     
                      
                    </tbody>
                  </table>
</div> 
<br>
<label style="color:purple;">
Para que se te haga mas facil hacer el inventario ya puedes poner el precio unitario y despues precio al publico<br>
sin necesidad de tener el porcentaje de ganancia, ya lo calcula automaticamente en registro y actualizacion de producto.
</label>

</div>                

  
  
    
    <!-- Modal -->
<div class="modal fade" id="updModal" tabindex="-1" aria-labelledby="updModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title ml-5" id="exampleModalLabel">Actualizar producto</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="modal-body-upd" class="modal-body">

    
    <form id="prodform" action="/actualizar_producto" method="get" class="form-signin ">

    <input type="text" id="id" name="id" hidden>

      <div class="mb-4">
        <label class="form-label" for="nombre">Nombre de producto</label>
        <input type="text" id="nombre" name="nombre" class="form-control form-signin" />  
      </div>

      <div class="form-group row">
      <div class="col mb-4">
        <label class="form-label" for="nombre">Codigo de barras</label>
        <input type="text" id="scanID" name="scanID" class="form-control form-signin" />  
      </div>

      <div class="col mb-4">
        <label class="form-label" for="nombre">Existencias</label>
        <input type="text" id="exs" name="exs" class="form-control form-signin" />  
      </div>
    </div>

      <div class="mb-4">
        <label class="form-label" for="nombre">Merma</label>
        <input type="text" id="merma" name="merma" class="form-control form-signin" />  
      </div>



      <div class="mb-4">
        <label class="form-label" for="pUnit">Precio unitario</label>
        <input  id="pUnit" rows="4" name="pUnit"  class="form-control"  /> </input> 
      </div>

      <div class="col mb-4">
        <label class="form-label" for="pGan">Ganancia con punto decimal</label>
        <input  id="pGan" rows="4" name="pGan"  class="form-control" /> </input> 
      </div>

      
      <div class="form-group row">
      <div class="col mb-4">
        <label class="form-label" for="pPub">Precio al publico</label>
        <input  id="pPub" rows="4" name="pPub" class="form-control bg-light"/> </input> 
      </div>


      <div class="col mb-5">
        <label class="form-label" for="utilidad" >Utilidad</label>
        <input  id="utilidad" rows="4" name="utilidad"  class="form-control bg-light"  readonly/> </input> 
      </div>

</div>
        <!-- Submit button -->
        <button data-mdb-ripple-init id="submit" type="submit"  class="form-control">Actualizar</button>
    </form>

    </div>
  </div>
</div>
   

</x-app-layout>

<script type="text/javascript">

  
$(document).ready( function () {
        
} );

$.ajax('/ajaxprodget', {
    type: 'GET', 

    success: function (data, status, xhr) {
      
      var tableBody = document.getElementById("table-body")
      tableBody.removeChild(tableBody.firstChild)
      
      data.forEach(element => {

  
      var nombre= '<td style="text-align:left;">'+element.nombre+'</td>';

      if(element.exs == null)
       exs1=0;
      else
      exs1=element.exs

      if(element.merma == null)
       merma1=0;
      else
      merma1=element.merma

      var exs= '<td style="text-align:left;"><label>'+element.exs.toString()+'</label></td>';
      var scanID= '<td style="text-align:left;">'+element.scanID+'</td>';
      var pUnit= '<td style="text-align:left;"><label>$</label><label>'+element.pUnit.toFixed(2)+'</label></td>';
      var pPub= '<td style="text-align:left;">$'+element.pPub.toFixed(2)+'</td>';
      var pGan= '<td style="text-align:left;">'+parseFloat(element.pGan*100).toFixed(2)+' %</td>';
      var merma= '<td style="text-align:left;">'+merma1+'</td>';
      var utilidad= '<td style="text-align:left;">$'+element.utilidad.toFixed(2)+'</td>';

      var prodString = element.nombre+","+
                        +element.scanID+","+
                        +element.exs+","+
                        +element.merma+","+
                       +element.pUnit+","+
                       +element.pPub+","+
                       +element.pGan+","+
                       
                       +element.utilidad;



      var accion = '<td style="text-align:left;"><button id="'+element.proID+'" value="'+prodString+'"  class="border-0" style="background-color: rgba(0, 0, 0, 0);color:purple;" onclick=ShowModalUpd(this)>Actualizar</button></td>';

   

      $("#table-body").append('<tr>'+nombre+exs+scanID+merma+pUnit+pPub+pGan+utilidad+accion+'</tr>')

   

        
      });
      

new DataTable('#productTable',{
 paginType : "full",
pageLength : 10 ,
language: {
      url: '/es-ES.json', // Traducción al español
    },
});
      

    },
    error: function (jqXhr, textStatus, errorMessage) {
      console.log(errorMessage)
    }
});
function refreshDataTable() {
    var table = $('#productTable').DataTable();
    table.clear().draw(); // Clear existing data and redraw
}
function ShowModalUpd(button)
{
  $("#updModal").modal('show')
  var vars =  button.value.split(',')
  console.log(vars);
  $("#id").val(button.id)
  $("#nombre").val(vars[0])
  $("#scanID").val(vars[1])
  $("#exs").val(vars[2])
  $("#merma").val(vars[3])
  $("#pUnit").val(vars[4])
  $("#pPub").val(vars[5])
  $("#pGan").val(vars[6]) 
  $("#utilidad").val(vars[7])
}

$( "#pGan" ).on( "change", function() {
    var pUnit = parseFloat($("#pUnit").val());
    var pGan = parseFloat($( this ).val());

      var pPub = pUnit + pUnit * pGan;
      var utilidad = pPub - pUnit;

      if(!isNaN(pPub) || !isNaN(utilidad))
      {
        $("#pPub").val(pPub.toFixed(2));
        $("#utilidad").val(utilidad.toFixed(2));
      }
      

} );

$( "#pPub" ).on( "change", function() {
    var pUnit = parseFloat($("#pUnit").val());
    var pPub = parseFloat($( this ).val());

  if(pUnit !== 0 && pPub !== 0)
  {
    var pGan = (pPub - pUnit) / pUnit
      var utilidad = pPub - pUnit;

      if(!isNaN(pGan) || !isNaN(utilidad))
      {
        $("#pGan").val(pGan.toFixed(2));
        $("#utilidad").val(utilidad.toFixed(2));
      }

  }
  

} );

$( "#pUnit" ).on( "change", function() {
    var pUnit = parseFloat($(this).val());
    var pGan = parseFloat($("#pGan").val());

      var pPub = pUnit + pUnit * pGan;
      var utilidad = pPub - pUnit;

      if(!isNaN(pPub) || !isNaN(utilidad))
      {
        $("#pPub").val(pPub.toFixed(2));
        $("#utilidad").val(utilidad.toFixed(2));
      }
} );


</script>