<x-app-layout
    navcontent={{$leftnavactive}}>

    <style>

.btn {
    font-weight: 700;
    height: 36px;
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none;
    cursor: default;
}
.styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
   
}
.styled-table thead tr {
    
    text-align: left;
}
.styled-table th {
  background-color:#FAFAFA;
}
.styled-table td {
    padding: 12px 15px;
    
}
.form-control:focus {
  
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px green;
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 3px green;
}
.form-select:focus {
  
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px green;
  box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 3px green;
}
.btn.btn-signin:hover,
.btn.btn-signin:active,
.btn.btn-signin:focus {
 
  background-color:green;
}

    </style>

<div class="container">

  <div class="row mt-3">
    <div class="col-8"><h3>Cajero</h3></div>
    <div class="col-4 mt-2"><label id="status" ></label></div>
  </div>
</div>

    <main class="">
    
    <hr>


        
        <div id="divcuenta"class="row    m-1" >
            <div id="divselect">
          
            <select id="cuenta" class="form-select mb-3 bg-light border-0" style="height:40px;">
            <!-- Options for different accounts will be dynamically added here -->
            <option value="default">Selecciona</option>
            <option value="empleado">Empleado</option>
            <option value="paciente">Paciente</option>
            <option value="publico">Publico</option>          
            </select>

          
            <select id="nombre" class="form-select border-0 bg-light" style="height:40px;">
            <option value="default">Selecciona</option>
            </select>

          
        
       
        </div>
        </div>

        


        <div class="m-1  ">
       
        <div class="d-flex mt-4 m-2" >
       
            <input type="text" id="barcodeInput" class=" m-1 bg-light border-0 p2 text-center" style="width:300px;height:50px;" placeholder="codigo"></input>
            <input type="text" id="cantidad" class="m-1 bg-light border-0 text-center" style="width:50px;" placeholder="cant"></input>
            <button id="addProductButton" class="form-control  disabled m-1 "  >Agregar</button>
            <button id="authorizeBtn" class="form-control m-1" data-bs-target="#exampleModal">Huella</button>
            <button id="vtaDirectaBtn" class="form-control m-1 ">Directa</button>
        </div>
            
            <div class=" d-flex justify-content-center m-2 ">
             
            
        </div>
        </div>

        <div class=" m-2">
        <table class="styled-table table p-2 mt-3 rounded ">
        <thead class="border-bottom">
            <tr>
     
                <th scope="col" style="width:150px;">Codigo</th>
                <th scope="col" style="width:100px;">Cant</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
            </tr>
        </thead>
        <tbody id="productList">
            <!-- Product rows will be dynamically added here -->
        </tbody>
    </table>

    <div id="total" class="m-3" >
            
            <span id="creditoAmount" class="m-1 float-end" ></span> <!-- Total amount will be dynamically updated here -->
            <label class="m-2 ">Total: $</label> <span id="totalAmount" ></span> <!-- Total amount will be dynamically updated here -->
        </div>
</div>
   


</div>
</div>


</main>

  

</x-app-layout>
<script>
  
  

   
    var total=0
    cashierList=[]
    function renderTable(product) {

      
        const productList = document.getElementById('productList')
        const row = document.createElement('tr')
        productList.innerHTML = ""
        total=0
        
        for (let i = 0; i < cashierList.length; i++) {
            const element = cashierList[i];
            //console.log("i: "+i)
            row.innerHTML = `
                <td>${element.codigo}</td>
                <td>${element.cant}</td>
                <td>${element.nombre}</td> 
                <td>${element.precio}</td>
            `;

           
           total =  total + element.precio * element.cant
          // console.log("total:"+total)
            productList.innerHTML += row.innerHTML

           
            
        }
            
           
          //  total += product.pPub

            const totalspan = document.getElementById('totalAmount')
            totalspan.textContent = total

            var barcodeInput = document.getElementById("barcodeInput");
            barcodeInput.value=""
            var cantidadInput = document.getElementById("cantidad");
            cantidadInput.value=""
           
           
    }
    

/////////////////////////////////////////////////////////////////////////////////////////////////////

$(document).ready( function () {   
    document.getElementById('addProductButton')
        .addEventListener('click', function() {

            var productList = document.getElementById("productList")
            var barcodeInput = document.getElementById("barcodeInput");
            var cantidadInput = document.getElementById("cantidad");
            
            if(barcodeInput.value == "" || isNaN(barcodeInput.value))
            {
                alert("No se ha scaneado el codigo de barras.")
                return 1
            }
            if(cantidadInput.value == "" || cantidadInput.value == 0 
                || isNaN(cantidadInput.value))
            {
                alert("Falta la cantidad de productos por codigo de barras.")
                return 1

            }
           
            
            //check if barcode exists and return product data
            $.ajax( {
            url:'/ajaxbarcode?barcode='+barcodeInput.value,
            type: 'get', 
            data: {}, 
            success: function (data, status, xhr) {
               
                if(data.scanID == barcodeInput.value)
               {
                    console.log("bar code exist. Adding to cashierList...")
     
                  var producto = {proID:data.proID,codigo:data.scanID,nombre:data.nombre,cant:parseInt(cantidadInput.value),precio:data.pPub,precioUnitario:data.pUnit}
                  addProduct(producto,data.exs)
                  renderTable()
                   

               }
             
               else
                    alert("codigo de barras no encontrado")

                   

            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(errorMessage)      
            }
            });
    
            $('#addProductButton').prop("disabled", true);
        });

} );

function addProduct(producto,exs)
{
    var found=false
    cashierList.forEach(element => {
        if(element.codigo == producto.codigo)
        {
           qty = element.cant + producto.cant
           if(qty > exs)
           {
                found=true
                return alert("No hay existencias disponibles")
           }
            
            element.cant+=producto.cant
            found=true           
        }
        
    });
    if(!found)
    {
        if(producto.cant > exs)
        return alert("No hay exsitencias disponibles")

        cashierList.push(producto)

    }
}

function getQtyFromCashierList(scanID)
{
    var qty=0;
    cashierList.forEach(element => {
        if(element.scanID == scanID)
        {
           return parseInt(element.cant)
            
        }
        
    });

}
    document.getElementById('barcodeInput')
        .addEventListener('click', function() {       
            $("#addProductButton").removeAttr("disabled");
        });



//chcar que valide bien el credito
        balance = 0;
    function GetBalance(accType,ctaID)
    {
        console.log("hasBalance")
        $.ajax('/cajero/credito?ctaID='+ctaID+"&accType="+accType, {
            type: 'get',
            success: function (data, status, xhr) {
                console.log("hasBalance response: "+data.balance);

                balance = data.balance;

       
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });

        return balance;
    }
        

    var pacList=[]
    var empList=[]
        document.getElementById('cuenta')
        .addEventListener('change', function() {

        const selectedAccount = this.value;

        if(selectedAccount == "empleado")
        {
            $("#divnombre").show()

            var select = document.getElementById('nombre');
            select.innerHTML=""
            
            var option = document.createElement('option');
                    option.value = "default";
                    option.text = "selecciona";
                    select.appendChild(option);

            $.ajax('/ajaxactiveempget', {
            type: 'get',  
            success: function (data, status, xhr) {
                
                //console.log(data)
                
                for (var i = 0; i < data.length; i++) 
                {
                    var jdata = {empID:data[i].empID,huella:data[i].huella}
                    pacList.push(jdata)
                    var option = document.createElement('option');
                    option.id = "empleado"
                    option.value = data[i].empID;
                    option.text = data[i].nombre;
                    select.appendChild(option);
                }
                
         
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(textStatus)      
            }
            });

        }
        if(selectedAccount == "paciente")
        {
            $("#divnombre").show()

            
            var select = document.getElementById('nombre');
            select.innerHTML=""
            var option = document.createElement('option');
                    option.value = "default";
                    option.text = "selecciona";
                    select.appendChild(option);

            $.ajax('/ajaxactivepacget', {
            type: 'get',  
            success: function (data, status, xhr) {
                
                
                for (var i = 0; i < data.length; i++) 
                {     
                    var jdata = {pacID:data[i].pacID,huella:data[i].huella}
                    pacList.push(jdata)              
                    var option = document.createElement('option');
                    option.id = "paciente"
                    option.value = data[i].pacID;
                    option.text = data[i].nombre;
                    select.appendChild(option);

  
                }
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(textStatus)
            }
            });
        }
        if(selectedAccount == "publico")
        {
            var divCuenta = document.getElementById("divcuenta")
            var div = document.createElement("div")
            div.innerHTML = '<input id="inputPublico" type="text" class="form-control" placeholder="Nombre publico"></input>'
            divCuenta.appendChild(div)
            $('#divnombre').hide();
            $('#divselect').hide();

            ctaID=0;
            accType="publico"
        }
        //console.log('Selected Account:', selectedAccount);
    });



    var ws =null;
    var wsReady = false
    var error = false
    var status = ""


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
const response =  poll(ping, validate, 1000);
      
async function ping()

{  
   
    if(wsReady)
    {
       
        console.log("wsReady:"+wsReady);
        
        console.log("sent ping")
    ws.send("ping")
    }
    else
    {
        ws = new WebSocket("ws://localhost:8080")
ws.onopen = function () {
    console.log("WebSocket connection established.");
    var labelStatus = document.getElementById("labelstatus")
    labelStatus.textContent = "Coneccion establecida."
    var status = document.getElementById("status")
    status.textContent = "Coneccion establecida."

    wsReady = true
    
}
ws.onclose = function(event) {
    
   ws.close()
    wsReady = false
  if (event.wasClean) {
    alert(`[close] Connection closed cleanly, code=${event.code} reason=${event.reason}`);
  } else {
    var status = document.getElementById("status")
    status.textContent = "No hay coneccion."
  
    status.class = "mt-2"
  }
};

ws.onerror = function(error) {
  console.log(`[error] ${error}`);
};

//ws.readyState !== WebSocket.OPEN
    ws.onmessage = function(event) {
/**
        if(event.data == "error_window_ec")
        {
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "Error. No tienes abierta la ventana de Registro de huellas"

        }
   **/
  
        if(event.data == "ping")
        {
            console.log("recieved: "+event.data)
        }
        if(event.data == "error_window_v")
        {
            status = "error"
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "Error. Abre la app de autorizacion,cierra esta ventana y da click de nuevo en huella."
         
           
        }
        if(event.data == "error_")
        {
            status = "error"
 
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "No se reconocio la huella. Cierra esta ventana y dale click de nuevo en huella y si persiste el problema registra de nuevo la huella."
        }
        if(event.data == "waiting_for_user")
        {
            console.log("waiting_for_user")
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "Esperando huella de usuario. Posicionate con un click en la app de autenticacion y despues pide al usuario que ponga su huella en el lector."
            

        }
        if(event.data == 'authenticated')
        {
            status = "authenticated"
            $('#MyButton').prop('disabled', true);
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "Usuario autenticado. Esperando autorizacion"
            console.log("authenticated")
            commitTransaction()
    
        }

        if(event.data == "rejected")
        {
            $('#btn_print').hide()
            console.log("rejected")
            var labelStatus = document.getElementById("labelstatus")
            labelStatus.textContent = "No se reconocio la huella. Intentalo de nuevo y si persiste el problema registra de nuevo la huella."
        }
        };


    }
   
    
    return true
}
  
   




        


var vtaID=0
var completed=false
function commitTransaction()
{
    
$.post({
                url: "/ajaxsale",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                data: {data:cashierList,account:accType,id:ctaID,nombre:ctaNombre},
                success: function(data) {
                    console.log("sale aproved vtaID:"+data.vtaID);
                    var labelStatus = document.getElementById("labelstatus")
                    labelStatus.textContent = "Venta aprobada."
                    vtaID = data.vtaID
                    var jsonString = JSON.stringify(cashierList);
                    console.log(isDirect+","+isPublic)
                    if(isDirect == false && isPublic == false)
                    {
                        $("#spinner").hide()
                        console.log("huella")
                        var btn_print = document.getElementById("btn_print")
   
                   btn_print.addEventListener("click",function f(){
                    window.open('/recibo?vtaID='+vtaID+'&cuenta='+accType+'&nombre='+ctaNombre+'&total='+total+'&cashierList='+jsonString.toString(), 'popup', 'height=794,width=1123');
                   location.reload()
                   
                });

                    }
                    else
                    {
                        window.open('/recibo?vtaID='+vtaID+'&cuenta='+accType+'&nombre='+ctaNombre+'&total='+total+'&cashierList='+jsonString.toString(), 'popup', 'height=794,width=1123');
                     location.reload()

                    }
                  
                  
                    
                   
                    
                    
   
                },
                dataType: "json",
                error: function (jqXhr, textStatus, errorMessage) {
                    console.log(textStatus+errorMessage)
                   // alert("Algo salio mal vuelve a intentar hacer la compra.")
                    $("#labelstatus").text = "Algo salio mal vuelve a intentar hacer la compra."
                }
                });
                console.log("return from ajax jquery");
                
 
}

function print()
{

}


function reset()
{
    var totalspan = document.getElementById('totalAmount')
    k=0
    total=0
    ctaID=""
    accType=""
    balance =0
    productList.innerHTML=""
    totalspan.textContent = ""

    cashierList.splice(0, cashierList.length)
}










    ctaID=""
    ctaNombre=""
    accType=""
    error = []
$(document).ready(function() {
    document.getElementById('authorizeBtn')
    .addEventListener('click', function() {  
      
            var selectCuenta = document.getElementById("cuenta");
            var selectNombre = document.getElementById("nombre");
            var productList = document.getElementById('productList')
            var totalspan = document.getElementById('totalAmount')

            accType = selectCuenta.value
            ctaNombre = selectNombre.selectedOptions[0].text
            console.log("accType:"+accType)

           
            if(verify())
            {
                accType = selectCuenta.value           
                ctaID = selectNombre.value

                var data = { action: "authenticate",
                             accType: accType,
                             ctaID: ctaID }

                ws.send(JSON.stringify(data))
                $("#exampleModal").modal('show')
                    status = "waiting"
                console.log("Authenticate sent...")
            }
            
        });
 });
    isDirect = false
    isPublic = false
    $(document).ready(function() {

        document.getElementById('vtaDirectaBtn')
        .addEventListener('click', function() {  
           
            var selectCuenta = document.getElementById("cuenta");
            var selectNombre = document.getElementById("nombre");
            var productList = document.getElementById('productList')
            var totalspan = document.getElementById('totalAmount')

            accType = selectCuenta.value
            ctaNombre = selectNombre.selectedOptions[0].text

            if(accType == "publico")
            {
       
                var inputPublico = document.getElementById("inputPublico")

                if(inputPublico.value == "" )
                    return alert("Escibe un nombre para la venta publica.")
                if(!hasItemsCashier())
                return 

                ctaNombre = inputPublico.value;
                isPublic = true
                commitTransaction()
                return
            }

            

            if(verifyWithoutFinger())
            {
                accType = selectCuenta.value           
                ctaID = selectNombre.value

                var data = { action: "authenticate",
                             accType: accType,
                             ctaID: ctaID }
                isDirect = true;
                commitTransaction()
            }
            
        });
    });



        document.getElementById('cuenta')
        .addEventListener('change', function() {       
         // console.log("cuenta:"+this.value);
            //send type

          accType = this.value
          

        });

        
        document.getElementById('nombre')
        .addEventListener('change', function() { 
            ctaID = this.value
            ctaNombre = this.selectedOptions[0].text
 
        console.log("hasBalance")
        $.ajax('/cajero/credito?ctaID='+ctaID+"&accType="+accType, {
            type: 'get',
            success: function (data, status, xhr) {
                console.log("hasBalance: "+data.balance);

                balance = data.balance;
                var balanceSpan = document.getElementById("creditoAmount")
                balanceSpan.innerHTML = "Credito: $"+data.balance

       
            },
            error: function (jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
       
          

         

        });

    function verify()
    {
        if(accType !== "publico")
         {
            if(isOpenWS() && isValidated() &&
                hasBalance() && hasItemsCashier())               
            {
                console.log("verificado");

                return true
            }
            else{
                console.log("verificar errores");
                return false
            }
                
        }
            
        alert("La venta publica se hace con el boton de venta directa.")
           

    } 
    function verifyWithoutFinger()
    {
        if(accType !== "publico")
         {
            if(isValidated() && hasBalance() && hasItemsCashier())               
            {
                console.log("verificado");

                return true
            }
            else{
                console.log("verificar errores");
                return false
            }
                
        }
            
            if(hasItemsCashier()) 
            {
                return true
            }
            else
            return false
           

    }     
            
  
        
    function isValidated()
    {
        
        if(ctaID == "" && accType == "")
        {
            alert("No has seleccionado el tipo de cuenta o nombre");
            return false;
        }
        return true
            
     
    }
    
    function hasBalance()
    {
        if(balance < total )
        {
            alert("credito insuficiente");
            return false;
        }

        return true;
    }

    function hasItemsCashier()
    {
        
        if(cashierList.length <= 0)
        {
            alert("No se han agregado productos")
            return false
        }
        
        return true
    }

  

    wsReady=false;
    function isOpenWS()
    {
      
        if (ws.readyState !== WebSocket.OPEN)
        {
            alert("No tienes abierta la aplicacion de autorizacion de huellas");
            return false

        }
      
       // alert("isopenwws");
        return true   
    }

    $(document).ready(function() {
    const closeIcon = document.getElementById('btn-close');
closeIcon.addEventListener('click', () => {
  //document.getElementById('exampleModal').style.display = 'none';

  if(status == "authenticated")
    location.reload()

  $('#MyButton').prop('disabled', true);
}); 


document.addEventListener('click', (event) => {
  const modal = document.getElementById('exampleModal');
  if (event.target === modal) {
   modal.style.display = 'none';
   

   if(status == "authenticated")
    location.reload()
  }

  $('#MyButton').prop('disabled', true);
});

    });
</script>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Esperando Autorizacion</h1>
        <button id="btn-close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
          <div id="spinner" class="spinner-border m-2 " role="status">
            <span class="visually-hidden"></span>
          </div>

            <label class="m-5" id="labelstatus"></label>
            <button id="btn_print" class="form-control">Imprimit ticket</button>

      </div>
      <div class="modal-footer">
      <label class="m-5"></label>
      </div>
 
    </div>
  </div>
</div>
