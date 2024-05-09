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
  text-align: left;
}
.styled-table td {
    padding: 12px 15px;
}

  </style>
<div class="">
    <ul class="nav m-3 d-flex flex-nowrap overflow-auto justify-content-center rounded p-2">
    <li class="nav-item">
    <a class="nav-link " style="color:gray;" href="/actualizar_paciente">Paciente</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" style="color:purple;" aria-current="page" 
          href="/actualizar_empleado">Empleado</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " style="color:gray;" href="/actualizar_producto">Producto</a>
  </li>
</ul>
</div>


 <div class="m-3">  
 <?php

if(isset($inserted) && $inserted == true || isset($corte))
{
  echo '<div id="div-success">
  <div class="row mt-2 w-100" style="width:400px">
  <div class="alert alert-success" role="alert">
  Empleado actualizado</div>
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
 
      <table id="empTable" class="styled-table table hover mt-3 mb-2" style="width:100%;">
                    <thead class="">
                      <tr  class="">
                        <th style ="text-align:left"scope="col">Estado</th>
                        <th style ="text-align:left"scope="col">Nombre</th>
                        <th style ="text-align:left"scope="col">Credito</th>
                        <th style ="text-align:left"scope="col">Huella</th>
                        <th style ="text-align:left"scope="col">Notas</th>
                        <th style ="text-align:left"scope="col">Accion</th>
                      </tr>
                    </thead>
                    <tbody id="tbodypac" >
                     
                      
                    </tbody>
                  </table>
</div> 
                

  <!-- Modal -->
  <div class="modal fade" id="hueModal" tabindex="-1" aria-labelledby="hueModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de huella</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div id="modal-body-hue" class="modal-body">

      <div id="spinner" class="spinner-border m-2 " role="status">
            <span class="visually-hidden"></span>
          </div>

            <label id="labelstatus" class="m-5">Cierra y vuelve a abrir la aplicacion de huellas y despues actualiza esta pagina.</label>
          


        
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>
    

   <!-- Modal -->
   <div class="modal fade" id="obsModal" tabindex="-1" aria-labelledby="updModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Observaciones</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="modal-body-obs" class="modal-body">
        
      </div>
      <div class="modal-footer">
       

      </div>
    </div>
  </div>
</div>
    
    <!-- Modal -->
<div class="modal fade" id="updModal" tabindex="-1" aria-labelledby="updModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title ml-5" id="exampleModalLabel">Actualizar paciente</h5>
        <button type="button" class="btn-close" 
        data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div id="modal-body-upd" class="modal-body">

      
      <div class="">
      <form action="/actualizar_empleado" method="get">

      <input type="text" id="modal-id" name="id" hidden>

      <div class="mb-3">
        <label class="form-label" for="estado">Estado</label>
          <select id="modal-estado" name="estado" class="form-select form-select-sm mb-3 w-50" aria-label=".form-select-lg example">
            <option value="1">Activo</option>
            <option value="2">Inactivo</option>
          </select>
      </div>

      <div class="mb-3">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" id="modal-nombre" name="nombre" class="form-control" style="width:400px"/>  
      </div>

      <div class="mb-3">
        <label class="form-label" for="credito">Credito</label>
        <input type="text" id="modal-credito" name="credito" class="form-control" style="width:400px"/>  
      </div>

      <div class="mb-3">
        <label class="form-label" for="obs">Observaciones</label>
        <textarea  id="modal-obs" rows="4" name="obs" style="width:400px" class="form-control"  /> </textarea> 
      </div>
        
      </div>
      <div class="modal-footer float-start">
        <button type="submit" class="form-control"  >Actualizar</button>

      </div>
      </form>
    </div>
    </div>
  </div>
</div>
   

</x-app-layout>
<style>
  .color-green {
  color:#70DAA5;
  }
  .color-gray {
  color:#4D4D4D;
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

<script type="text/javascript">
  
  

k=0;
$.ajax('/ajaxempget', {
    type: 'GET', 

    success: function (data, status, xhr) {
     

      
      data.forEach(element => {

        var estado="";
      if(element.estado)
        estado= '<td style ="text-align:left">Activo</td>';
      else
        estado= '<td style ="text-align:left">Inactivo</td>';
          

      var nombre= '<td style ="text-align:left">'+element.nombre+'</td>';
      var credito= '<td style ="text-align:left">$'+parseFloat(element.credito)+'</td>';
 
      var huebtn = '<td style ="text-align:left"><button id="'+element.empID+'" '+
                      'class="border-0" '+
                      'onclick=updFinger(this) '+
                      'value="'+element.observaciones+'" '+
                      'style="background-color: rgba(0, 0, 0, 0); color:purple;">'+
                      'Activar'+
                      '</button></td>'; 
        
           

      var obsbtn = '<td style ="text-align:left"><button id="btnModal" '+
                      'class="border-0" '+
                      'onclick=obspatient(this) '+
                      'value="'+element.observaciones+'" '+
                      'style="background-color: rgba(0, 0, 0, 0); color:purple;">'+
                      'Detalles'+
                      '</button></td>'; 


    const splitarray =   element.empID+','+
                         element.estado+','+
                         element.nombre+','+
                         element.credito+','+
                         element.observaciones;


      var updbtn = '<td style ="text-align:left"><button id="btnModal" '+
                      'class="border-0" '+
                      'name="jsonArray" '+
                      'value="'+splitarray+'" '+
                      'onclick=updpatient(this) '+
                      'style="background-color: rgba(0, 0, 0, 0); color:purple;">'+
                      'Actualizar'+
                      '</button></td>';
      

      $("#tbodypac").append('<tr>'+estado+nombre+credito+huebtn+obsbtn+updbtn+'</tr>')
        
      });


 new DataTable('#empTable',{
paginType : "full",
pageLength : 10 ,
language: {
  url: 'https://camporenacimiento.shop/es-ES.json', // Traducción al español
    },
});
      
    },
    error: function (jqXhr, textStatus, errorMessage) {
      console.log(errorMessage)
    }
});


var empid;
var accType;
var ws = null;
var wsReady = false

const poll = async function (fn, fnCondition, ms) {
    let result = await fn();
    while (fnCondition(result)) {
         await wait(ms); // Wait for the specified interval
        result =  fn(); // Call the function again
    }
   
    return result;
};

const wait = function (ms = 1000) {
    return new Promise(resolve => {
        setTimeout(resolve, ms);
    });
};
const validate = result => true; 
const response =  poll(ping, validate, 3000);
      

async function ping()
{
  if(!wsReady)
  {
    ws = new WebSocket("ws://localhost:8080")
ws.onopen = function () {
    console.log("WebSocket connection established.");

    wsReady = true
   
}
ws.onclose = function(event) {
    ws.close()
    wsReady = false
  if (event.wasClean) {
    alert(`[close] Connection closed cleanly, code=${event.code} reason=${event.reason}`);
  } else {
        console.log("connection closed...")

  }
};

ws.onerror = function(error) {
  console.log(`[error] ${error}`);
};

        ws.onmessage = function(event) {

          if(event.data == "ping") 
          {
            console.log("recieved: "+event.data)
          }
          
          if(event.data == "error_window_ec") 
          {
            console.log("error_window_ec")
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "No tienes abierta ventana de autorizacion de huellas.Cierra la ventana y dale click an activar nuevamente"
          }
          if(event.data == "waiting_for_user") 
          {
            console.log("waiting_for_user")
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "Esperando la huella de usuario"
          }

          if(event.data == "completed") 
          {
            console.log("completed")
            location.reload()
           // updateFinger()
            
          }
          
          if(event.data == "mysql_connect_error") 
          {
            console.log("mysql_connect_error");
          }
               
            };
  }
  else
  {
    console.log("sent ping")
    ws.send("ping")
  }

  return true
}

function updateFinger()
{
$.post({
                url: "/ajaxupdatefingerdata",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                data: {acctype:accType,ctaid:empid},
                success: function(data) {
                    $("#spinner").remove()
                    var labelStatus = document.getElementById("labelstatus")
                    labelStatus.textContent = "Listo, ya puedes cerrar la ventana"
                    console.log("DATA:"+data);
                   
                },
                dataType: "json",
                error: function (jqXhr, textStatus, errorMessage) {
                    console.log(textStatus+errorMessage)
                    alert("Algo salio mal vuelve a intentar hacer la compra.")
                }
                });
                
                
 
}

function updFinger(elem)
{
  empid = elem.id
  accType ='empleado'

  if(isOpenWS())
  {
    
  
    var data = { action: "update_or_register",accType: "empleado",ctaID:  elem.id }
    const jsonString = JSON.stringify(data)
    ws.send(jsonString)

    $("#hueModal").modal('show')

  }
}

function isOpenWS()
{
  if (ws.readyState !== WebSocket.OPEN)
  {
    alert("Error. Abre primero la aplicacion de huellas y despues actualiza la pagina.");
    return false
  }
    return true   
}

function obspatient(button)
{
  $("#obsModal").modal('show')
  var n = document.getElementById("modal-body-obs")
  n.innerHTML = button.value
  
  console.log("obspatient: "+button.value)
}

function updpatient(button)
{
 var vars =  button.value.split(',')

  $("#updModal").modal('show')

  var n = document.getElementById("modal-id")
  if(vars[0] != null)
  n.value = vars[0]


  var n = document.getElementById("modal-estado")
  if(vars[1] != null)
  {
    if(vars[1]==1)
    n.value = 1;
    else
    n.value=2;

  }

  var n = document.getElementById("modal-nombre")
  if(vars[2] != null)
  n.value = vars[2]

  var n = document.getElementById("modal-credito")
  if(vars[3] != null)
  n.value = vars[3]

  var n = document.getElementById("modal-obs")
  if(vars[4] == null)
  n.value = ""
  else
  n.value = vars[4]

 
  
}
</script>