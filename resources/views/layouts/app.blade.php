<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Campo Renacimiento</title>

        
        <link href="/bootstrap.min.css" rel="stylesheet" >
        <script src="/popper.min.js" ></script>
        <script src="/bootstrap.min.js" ></script>
        
        <script src="/jquery.min.js"></script>
        
        <link rel="stylesheet" href="/dataTables.dataTables.css" />
        <script src="/dataTables.js"></script>
        
  
        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>

<body class="" style="background-color:white;">
    
    <div class="container-fluid">

                        

        <div id="divLeft" class="row">

            <div class="col-md-2 vh-100 bg-light border-end" style="min-width:250px;" >

                    @include('layouts.navigation')

            </div>

            <div id="divRight" class="col vh-100 overflow-auto" >
            <form method="POST" action="{{ route('logout') }}" class="float-end mt-4 ">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <button class="border-0 bg-white" style="color:purple;">{{ __('Salir') }}</button>
                            </x-dropdown-link>
                        </form>
               
                
                    {{$slot}}
        
            </div>

        </div>

    </div>

</body>

</html>
