<x-app-layout
    navcontent={{$leftnavactive}}>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    background-color:green;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px green;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 3px green;
}
.btn.btn-signin:hover,
.btn.btn-signin:active,
.btn.btn-signin:focus {
   
    background-color:green;
}
div.dataTables_filter > label > input {
  background-color:gray;
}
</style>
<div class="mb-4 m-4">

<div class="d-flex m-3" style="min-width:100px;">
<h3 class="ml-2" style="min-width:100px;">Ventas</h3> 
<label id="h5Util" class="m-2" style="color:green;"></label>       
<label id="h5TotalSales" class="m-2"></label>
<label id="h5TotalUnitSales" class="m-2"></label>

                        
</div>


<div class="row">


             

 
    <div class="d-flex mt-2">
        <div class=" text-center m-2">
        
          <select id="cuenta" name="cuenta" class="form-select form-control  bg-light border-0 " style="height:40px; min-width:110px;" aria-label=".form-select-lg example">
            <option value="0">Selecciona</option>
            <option value="paciente">Paciente</option>
            <option value="empleado">Empleado</option>
            <option value="publico">Directa</option>
          </select>
        </div>
        <div class="m-2">  
          <input type="text" id="start" class="border-0 text-center bg-light" style="height:40px; min-width:110px;" placeholder="Fecha inicial"></input>
        </div>

        <div class="m-2">
          <input type="text" id="end" class=" border-0 text-center bg-light" style="height:40px; min-width:110px;" placeholder="Fecha final"></input>
        </div>

        <div class=" m-2">
          <button id="btnvtaporcta" class="form-control bg-light" style="height:40px">Mostrar</button>
        </div>

        
                   
               

    </div>

          <div class="mt-2 ">
          <table id="ventaTable_" class="styled-table table hover w-100 shadow" hidden>
            <thead class="border-bottom">
                <tr  class="">
                  <th style ="text-align:left;width:150px;">Fecha</th>
                  <th style ="text-align:left;width:500px;">Nombre</th>
                  <th style ="text-align:left;width:100px;">Total Pub</th>
                  <th style ="text-align:left;width:100px;">Total Unit</th>
                  <th style ="text-align:left;">Acciones</th>
                </tr>
            </thead>
            <tbody id="table-body">  
            </tbody>
           </table>
        </div>

</div>

      

<script>


var table=null
var k =0;
document.getElementById('btnvtaporcta')
        .addEventListener('click', function() {
          
            var select = document.getElementById("cuenta")
             
           
            if(select.value !== "0")
            {
                //console.log("selected:"+select.value);

                var start = document.getElementById("start")
                var end = document.getElementById("end")

                var dateString = start.value;
                var parts = dateString.toString().split('/');
                var newDateString = parts[2] + "/" + parts[1] + "/" + parts[0];
                var startString = newDateString
          

                var dateString = end.value;
                var parts = dateString.toString().split('/');
                var newDateString = parts[2] + "/" + parts[1] + "/" + parts[0];
                var endString = newDateString
              
                var util = "";
                
                $.ajax('/ajaxvtaporcta?cuenta='+select.value+
                '&start='+startString+'&end='+endString, {
                type: 'get',
                success: function (data, status, xhr) {
                  
                  if(data.total != null)
                  {
                    var h3 = document.getElementById("h5TotalSales")
                  h3.innerHTML =""
                  if(data.total !== null)
                  h3.innerHTML = "Precio Pub: $ "+data.total.toFixed(2)
                  
                  var h3 = document.getElementById("h5TotalUnitSales")
                  h3.innerHTML =""
                  if(data.totalUnitario !== null)
                  h3.innerHTML = "Precio Unit: $ "+data.totalUnitario.toFixed(2)
                  
                  util = data.total.toFixed(2) - data.totalUnitario.toFixed(2)

                  var h3 = document.getElementById("h5Util")
                  h3.innerHTML =""
                  if(data.total !== null && data.totalUnitario !== null)
                    h3.innerHTML = "Utilidad: $ "+util.toFixed(2)

                  }
                  else
                  {
                    var h3 = document.getElementById("h5TotalSales")
                    h3.innerHTML =""
                    var h3 = document.getElementById("h5TotalUnitSales")
                    h3.innerHTML =""
                    var h3 = document.getElementById("h5Util")
                    h3.innerHTML =""
                    util = ""
                    
                  }
                  

                    k++
                    if(table != null)
                    {
                        table.destroy();
                       var t = document.getElementById("ventaTable_")
                       t.id = "ventaTable_"
                       // console.log("table id:"+table.id);
                    }   
                   
                    
                    var tbody = document.getElementById("table-body")
                    tbody.innerHTML = "";

                    data.get.forEach(element => {

                        tbody.innerHTML += '<tr><td style ="text-align:left">'+element.fecha+'</td>'+
                                                '<td style ="text-align:left">'+element.nombre+'</td>'+
                                                '<td style ="text-align:left"><label>$</label>'+element.total+'</td>'+
                                                '<td style ="text-align:left"><label>$</label>'+element.totalUnitario+'</td>'+
                                                '<td style ="text-align:left"><button class="border-0 " '+
                                                'onclick="openProductoModal('+element.vtaID+')"data-bs-target="productoModal" style="background-color: rgba(0, 0, 0, 0);color:purple;">'+
                                                'Productos</button></td></tr>'
                       // console.log(element);
                        
                    });

table = new DataTable('#ventaTable_',{
    
paginType : "full",
pageLength : 10 ,
language: {
      url: '//cdn.datatables.net/plug-ins/2.0.5/i18n/es-ES.json', // Traducción al español
    },

}); 
$('#ventaTable_').on('search.dt', function () {
    // Your logic here (e.g., retrieve filtered rows, update UI, etc.)
    console.log('Search event triggered');

    var filteredRows = table.rows({ filter: 'applied' });
    // Now you can work with the filtered rows (e.g., retrieve data, manipulate, etc.)
    console.log('Filtered rows:', filteredRows.data().toArray());
});

function selectOnlyFiltered() {
   
}

$('#next').on('click', function() {
  console.log("next")
    table.page('next').draw('page');
});


                 },
                 error: function (jqXhr, textStatus, errorMessage) {
          
            }
            }); 

            }else
            alert("No has seleccionado la cuenta")
            
            $('#ventaTable_').removeAttr('hidden');

         });

function openProductoModal(vtaID)
{
    $("#productoModal").modal('show')

    $.ajax('/ajaxprodporvta?vtaID='+vtaID, {
    type: 'get', 
    success: function (data, status, xhr) {
        var tbody = document.getElementById("tbody-modal")
        tbody.innerHTML = ""
       data.forEach(element => {

        tbody.innerHTML += '<td>'+element.nombre+'</td>'+
                            '<td>'+element.qty+'</td>'+
                            '<td>'+element.pPub+'</td>'
       
        
       });
      // console.log(data);
    },
    error: function (jqXhr, textStatus, errorMessage) {
          
    }
});
}
</script>


    <!-- Modal -->
    <div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="productoModalLabel">Productos vendidos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">


      <div class="">
          <table class="styled-table table hover mt-3 mb-2 w-100">
            <thead class="border-bottom">
                <tr  class="">
                  <th scope="col">Nombre</th>
                  <th scope="col">Cant</th>
                  <th scope="col">Precio</th>
                </tr>
            </thead>
            <tbody id="tbody-modal">  
            </tbody>
           </table>
        </div>
        
         
           
      </div>
      <div class="modal-footer">
      
      </div>
 
    </div>
  </div>
</div>
</x-app-layout>
