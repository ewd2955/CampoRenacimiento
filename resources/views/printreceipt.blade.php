@props(['cashierList','nombre','cuenta','total'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title >Ticket de compra</title>

        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        
    
    </head>
    
<style>
.fonts {
    font-family: "Lucida Console", "Courier New", monospace;
    font-size: 14px;
}
@media print {
    a[href]:after {
        content: none !important;
    }
}
@page {
    size: auto;
    margin: 0mm; /* Set the margin to 0mm to hide the page title */
}
</style>

<script>
function main(){
    window.print()
}
    </script>
<body onload="main()" >




<div class="fonts m-3 p-2">
<label class="row fw-bold">Ticket de compra</label>
<label class="row">Sucursal: Campo Renacimiento</label>
<label class="row">Nombre: {{$nombre}}</label>
<label class="row">Cuenta: {{$cuenta}}</label>

</div>

<div class="m-2" >
<table class="fonts styled-table table  table-responsive " style="width:98.7%;">
        <thead class="border-bottom">
            <tr>
     
                <th scope="col" style="width:50px;">Cant</th>
                <th scope="col" >Nombre</th>
                <th scope="col" style="width:50px;">Precio</th>
            </tr>
        </thead>
        <tbody id="productList">
        <?php

            for ($i=0; $i < sizeof($cashierList) ; $i++) { 
                echo '<tr><td>'.$cashierList[$i]->cant.'</td> 
                          <td>'.$cashierList[$i]->nombre.'</td>
                          <td>$'.$cashierList[$i]->precio.'</td></tr>';
            }

        ?>
        </tbody>
    </table>

    <div class="row m-3" style="float:right;">  
<label class="fonts " >Total: ${{$total}}</label>
</div>
    
</div> 

</body>

</html>
<script>
   
</script>

