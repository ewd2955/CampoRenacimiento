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
.styled-nav {
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  
}
/*
 * Card component
 */
.card {
   
    /* just in case there no content*/
    padding: 20px 25px 30px;
    margin: 0 auto 25px;
    margin-top: 50px;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.form-signin input[type=email],
.form-signin input[type=password],
.form-signin input[type=text],
.form-signin button {
    width: 100%;
    display: block;
    margin-bottom: 10px;
    z-index: 1;
    position: relative;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;

}

.form-signin .form-control:focus {
    border-color: green;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
}

.btn.btn-signin {
    /*background-color: #4d90fe; */
    background-color: green;
    /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
    padding: 0px;
    font-weight: 700;
    font-size: 14px;
    height: 36px;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    border: none;
    -o-transition: all 0.218s;
    -moz-transition: all 0.218s;
    -webkit-transition: all 0.218s;
    transition: all 0.218s;
}

.btn.btn-signin:hover,
.btn.btn-signin:active,
.btn.btn-signin:focus {
    background-color: purple;
}
.color-green {
  color:#70DAA5;
  }
  .color-gray {
  color:#4D4D4D;
  }
  .shadoww{
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
  }
    </style>
  <script>
      document.addEventListener('DOMContentLoaded', (event) => {
    // Your code here
    $("#div-success").fadeTo(2000, 0.00, function() {
        $(this).slideUp(300, function() {
            $(this).remove();
        });
    });
    $("#div-error").fadeTo(2000, 0.00, function() {
        $(this).slideUp(300, function() {
            $(this).remove();
        });
    });
});
  </script>  
    <div class="">
    <ul class="nav  m-3 d-flex flex-nowrap overflow-auto justify-content-center rounded p-2">
    <li class="nav-item ">
    <a class="nav-link active" style="color:purple;"href="/alta_paciente">Paciente</a>
  </li>
  <li class="nav-item ">
    <a class="nav-link " style="color:gray;" href="/alta_empleado">Empleado</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " style="color:gray;"aria-current="page" 
    href="/alta_producto">Producto</a>
  </li>
</ul>
</div>





<div class="row m-4 ">
    <form action="/alta_paciente" method="get" class="form-signin ">

<?php
if(isset($inserted) && $inserted == true)
{
  echo '<div id="div-success">
  <div class="row mt-2 w-100" style="width:400px">
  <div class="alert alert-success" role="alert">
  Paciente registrado</div>
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
      <div >
      
      <div class="mb-3">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="p-2 border-0 bg-light" style="height:40px;"/>  
      </div>

      <div class="mb-3">
        <label class="form-label" for="credito" >Credito</label>
        <input type="text" id="credito" name="credito"class="p-2 border-0 bg-light" style="height:40px;"/>  
      </div>

      <div class="mb-3">
        <label class="form-label" for="obs" >Observaciones</label>
        <textarea  id="obs" rows="4" name="obs"  class="p-2 border-0 bg-light w-100" placeholder="Notas medicas" /> </textarea> 
      </div>
      <button data-mdb-ripple-init type="submit"  class="form-control bg-light p-3" >Registrar paciente</button>
</div>

        <!-- Submit button -->
       
    </form>
</div>
</x-app-layout>