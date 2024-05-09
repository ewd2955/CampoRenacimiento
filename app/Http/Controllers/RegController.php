<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;

class RegController extends Controller
{
    public function RegPatient(Request $request)
    {
        if($request->input('nombre') != null && $request->input('credito') != null)
        {
            $pattern = '/^[a-zA-ZñÑ\s\b]*[a-zA-ZñÑ]+[a-zA-ZñÑ\s\b]*$/';
            if(preg_match( $pattern, $request->input('nombre')) &&
            preg_match('/^[0-9.]+$/', $request->input('credito')))
            { 
                $sql ='select count(nombre) as count from empleado where nombre="'.$request->input('nombre').'"';
                $result = DB::select($sql);
                if($result[0]->count > 0)
                {                   
                    return view('regpatient',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);
                }
                $sql ='select count(nombre) as count from paciente where nombre="'.$request->input('nombre').'"';
                $result = DB::select($sql);
                if($result[0]->count > 0)
                {               
                    return view('regpatient',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);                  
                }    
                $obs="no hay observaciones";   
                if($request->input('obs') !== null)
                $obs = $request->input('obs');
                     
                DB::table('paciente')->insert([
                    'nombre' => $request->input('nombre'),
                    'observaciones' => $obs,
                    'huella'=>0101,
                    'credito' => $request->input('credito'),
                    'defCred' => $request->input('credito'),
                    'estado' => true,
                    'fecha'=>now()
                ]);
                return view('regpatient',['inserted'=>true,
                                          'leftnavactive'=>"alta"]);
            }
            else
            return view('regpatient',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);           
        }      
        return view('regpatient',['leftnavactive'=>"alta"]);
    }
    
    public function Regemployee(Request $request)
    {
        if($request->input('nombre') != null && $request->input('credito') != null)
        {
            $pattern = '/^[a-zA-ZñÑ\s\b]*[a-zA-ZñÑ]+[a-zA-ZñÑ\s\b]*$/';
            if(preg_match($pattern, $request->input('nombre')) &&
            preg_match('/^[0-9.]{1,8}$/', $request->input('credito')))
            { 
                $sql ='select count(nombre) as count from paciente where nombre="'.$request->input('nombre').'"';
                $result = DB::select($sql);
                if($result[0]->count > 0)
                {
                    return view('regemployee',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);
                   
                }
                $sql ='select count(nombre) as count from empleado where nombre="'.$request->input('nombre').'"';
                $result = DB::select($sql);
                if($result[0]->count > 0)
                {
                    return view('regemployee',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);
                   
                }
                
                $obs="no hay observaciones";    
                if($request->input('obs') !== null)
                $obs = $request->input('obs');

                DB::table('empleado')->insert([
                    'nombre' => $request->input('nombre'),
                    'observaciones' => $obs,
                    'huella'=>0101,
                    'credito' => $request->input('credito'),
                    'defCred' => $request->input('credito'),
                    'estado' => true,
                    'fecha'=>now()
                ]);
                return view('regemployee',['inserted'=>true,
                                          'leftnavactive'=>"alta"]);
            }
            else
            return view('regemployee',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);           
        }      
        return view('regemployee',['leftnavactive'=>"alta"]);
    }
    public function RegProduct()
    {
        return view('RegProduct');
    }
   
}