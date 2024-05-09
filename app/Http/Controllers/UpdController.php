<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;

class Updcontroller extends Controller
{
    public function UpdPatient(Request $request)
    {
        if($request->input("estado") == 2)
        {
            $sql ='delete from paciente where pacID='.$request->input('id');
            DB::select($sql);

            return view('updpatient',['inserted'=>true,
                                          'leftnavactive'=>"actualizar"]);
            
        }
        if($request->input('nombre') != null && $request->input('credito') != null)
        {
            $pattern = '/^[a-zA-ZñÑ\s\b]*[a-zA-ZñÑ]+[a-zA-ZñÑ\s\b]*$/';
            if(preg_match($pattern, $request->input('nombre')) &&
            preg_match('/^\d+(\.\d+)?$/', $request->input('credito')))
            { 
                $sql ='select nombre from paciente where pacID='.$request->input('id');
                $r = DB::select($sql);
                $lastName = $r[0]->nombre;

                if($lastName !== $request->input('nombre'))
                {
                    $sql ='select count(nombre) as count from paciente where nombre="'.$request->input('nombre').'"';
                    $r = DB::select($sql);
                                       
                    if(isset($r[0]->count))
                    {
                        if($r[0]->count > 0)
                        return view('updpatient',['inserted'=>false,
                        'leftnavactive'=>"actualizar"]);
                    }

                    $sql ='select count(nombre) as count from empleado where nombre="'.$request->input('nombre').'"';
                    $r = DB::select($sql);
                                       
                    if(isset($r[0]->count))
                    {
                        if($r[0]->count > 0)
                        return view('updpatient',['inserted'=>false,
                        'leftnavactive'=>"actualizar"]);
                    }
                }
                        $estado=1;
                       if($request->input('estado')== 1) 
                        $estado=true;
                        else
                        $estado=false;
                
                        $obs="";   
                        if($request->input('obs') !== null)
                        $obs = $request->input('obs');

                DB::table('paciente')
                ->where('pacID',$request->input('id'))
                ->update([
                    'nombre' => $request->input('nombre'),
                    'observaciones' => $obs,
                    'credito' => $request->input('credito'),
                    'defCred' => $request->input('credito'),
                    'estado' => $estado,                 
                    'fecha'=>now()
                        ]);
                        
                        
                return view('updpatient',['inserted'=>true,
                                          'leftnavactive'=>"actualizar"]);
            }
            else
            return view('updpatient',['inserted'=>false,
                                     'leftnavactive'=>"actualizar"]);           
        }      

        return view('updpatient',['leftnavactive'=>"actualizar"]);
    }
    public function UpdEmployee(Request $request)
    {
        if($request->input("estado") == 2)
        {
            $sql ='delete from empleado where empID='.$request->input('id');
            DB::select($sql);
            return view('updemployee',['inserted'=>true,'leftnavactive'=>"actualizar"]);
            
            
            
        }
        if($request->input('nombre') != null && $request->input('credito') != null)
        {
            $pattern = '/^[a-zA-ZñÑ\s\b]*[a-zA-ZñÑ]+[a-zA-ZñÑ\s\b]*$/';
            if(preg_match($pattern, $request->input('nombre')) &&
            preg_match('/^\d+(\.\d+)?$/', $request->input('credito')))
            {   

                $sql ='select nombre from empleado where empID='.$request->input('id');
                $r = DB::select($sql);
                $lastName = $r[0]->nombre;

                if($lastName !== $request->input('nombre'))
                {
                    $sql ='select count(nombre) as count from empleado where nombre="'.$request->input('nombre').'"';
                    $r = DB::select($sql);
                                       
                    if(isset($r[0]->count))
                    {
                        if($r[0]->count > 0)
                        return view('updemployee',['inserted'=>false,
                        'leftnavactive'=>"actualizar"]);
                    }

                    $sql ='select count(nombre) as count from paciente where nombre="'.$request->input('nombre').'"';
                    $r = DB::select($sql);
                                       
                    if(isset($r[0]->count))
                    {
                        if($r[0]->count > 0)
                        return view('updemployee',['inserted'=>false,
                        'leftnavactive'=>"actualizar"]);
                    }
                }

               
               
                $estado=1;
               if($request->input('estado')== 1) 
                $estado=true;
                else
                $estado=false;
                
                $obs="";
               if($request->input('obs') !== null) 
                $obs=$request->input('obs');
           
                DB::table('empleado')
                ->where('empID',$request->input('id'))
                ->update([
                'nombre' => $request->input('nombre'),
                'observaciones' => $obs,
                'credito' => $request->input('credito'),
                'defCred' => $request->input('credito'),
                'estado' => $estado,                 
                'fecha'=>now()
                ]);

                return view('updemployee',['inserted'=>true,'leftnavactive'=>"actualizar"]);
            }
            else
            return view('updemployee',['inserted'=>false,
                                     'leftnavactive'=>"actualizar"]);           
        }      

        return view('updemployee',['leftnavactive'=>"actualizar"]);
    }
 
}
