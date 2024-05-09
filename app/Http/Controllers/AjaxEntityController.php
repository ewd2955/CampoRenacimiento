<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class AjaxEntityController extends Controller
{
    public function GetPatitent()
    {
        $sql='select * from paciente ORDER BY nombre ASC';
        $result = DB::select($sql);

        return response()->json(collect($result));
    }
    public function GetEmployee()
    {
        $sql='select * from empleado order by nombre asc'; 
        $result = DB::select($sql);

        return response()->json(collect($result));
    }
    public function GetProduct()
    {
        $sql='select * from producto order by nombre asc'; 
        $result = DB::select($sql);

        return response()->json(collect($result));

    }
    public function GetActivePatients()
    {
        //si no funciona haya ni hablandole a omar para que de de alta sus ips
        //se necesita where huella="activa , la funcion que esta abajo de estas dos
        // se manda llamar cuando status=complete desde c#. Esto para que
        //los resultados del select del cashier sean puras cuentas con huella activa.
        
        $sql='select * from paciente where huella like "%<%" order by nombre asc'; 
        $result = DB::select($sql);

        return response()->json($result); 
    }
    public function GetActiveEmployees()
    {
        $sql='select * from empleado where huella like "%<%" order by nombre asc'; 
        $result = DB::select($sql);

        return response()->json($result); 

    }
    public function UpdateFingerData(Request $request)
    {
        $ctaID = $request->input("ctaid");
        $accType = $request->input("acctype");
     
        if($accType == "empleado")
        {
            $sql = 'update empleado set huella="activa" where empID='.$ctaID;
           
            $result = DB::select($sql);
            return response()->json(["msg"=>"finger updated"]); 

        }
        if($accType == "paciente")
        {
            $sql = 'update paciente set huella="activa" where pacID='.$ctaID;
            $result = DB::select($sql);
            return response()->json(["msg"=>"finger updated"]); 
           
        }
        return response()->json(["msg"=>"error"]); 
    }
    public function GetBalance(Request $request)
    {
        $accType =$request->input('accType');
        $ctaID =$request->input('ctaID');
        $result="";
        if($accType == "paciente")
        {
            $sql='select credito from paciente where pacID='.$ctaID;
            $result = DB::select($sql);

        }
        if($accType == "empleado")
        {
            $sql='select credito from empleado where empID='.$ctaID;
            $result = DB::select($sql);

        }
        
   
        return response()->json(['balance'=>$result[0]->credito]);
       
    }
    
}
