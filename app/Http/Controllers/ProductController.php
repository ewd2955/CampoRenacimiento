<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;

class ProductController extends Controller
{
    public function RegProduct(Request $request)
    {
        if($request->input('nombre') !== null &&  
        $request->input('scanID') !== null &&  
        $request->input('exs') !== null &&  
        $request->input('pUnit') !== null &&  
        $request->input('pPub') !== null &&  
        $request->input('pGan') !== null && 
        $request->input('utilidad') !== null)
        {
 
            $pattern = '/^[a-zA-Z0-9 ]+$/';
            $patternIntegers = '/^(0|[1-9][0-9]*)$/';
            $patternFloats = '/^[0-9]*(\.[0-9]+)?$/';


            if(preg_match($pattern, $request->input('nombre')) && 
            preg_match($patternIntegers, $request->input('scanID')) && 
            preg_match($patternIntegers, $request->input('exs')) && 
            preg_match($patternFloats, $request->input('pUnit')) && 
            preg_match($patternFloats, $request->input('pPub')) &&
            preg_match($patternFloats, $request->input('pGan')) && 
            preg_match($patternFloats, $request->input('utilidad')))
            { 
  
                
                $sql='select nombre from producto where nombre="'.$request->input('nombre').'"'; 
                $r = DB::select($sql);
                if(isset($r[0]->nombre))
                return view('regproduct',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);
                    
                $sql='select scanID from producto where scanID='.$request->input('scanID'); 
                $result = DB::select($sql);
                if(isset($result[0]->scanID))
                return view('regproduct',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);

                DB::table('producto')->insert([
                    'nombre' => $request->input('nombre'),
                    'scanID' => $request->input('scanID'),
                    'exs' => $request->input('exs'),
                    'pUnit' => $request->input('pUnit'),
                    'pPub' => $request->input('pPub'),
                    'pGan' => $request->input('pGan'),
                    'utilidad'=>$request->input('utilidad'),
                ]);
                return view('regproduct',['inserted'=>true,
                                          'leftnavactive'=>"alta"]);
            }
            else
            return view('regproduct',['inserted'=>false,
                                     'leftnavactive'=>"alta"]);           
        }
        

        return view('regproduct',['leftnavactive'=>"alta"]);
    }

    public function UpdProduct(Request $request)
    {
       
        if($request->input('nombre') !== null && 
        $request->input('scanID') !== null && 
        $request->input('exs') !== null && 
        $request->input('pUnit') !== null && 
        $request->input('pPub') !== null && 
        $request->input('merma') !== null &&
        $request->input('pGan') !== null &&
        $request->input('utilidad') !== null)
        {
            $pattern = '/^[a-zA-Z0-9 ]+$/';
            $patternIntegers = '/^(0|[1-9][0-9]*)$/';
            $patternFloats = '/^[0-9]*(\.[0-9]+)?$/';

            if(preg_match($pattern, $request->input('nombre')) &&
            preg_match($patternIntegers, $request->input('scanID')) && 
            preg_match($patternIntegers, $request->input('exs')) && 
            preg_match($patternIntegers, $request->input('merma')) && 
            preg_match($patternFloats, $request->input('pUnit')) && 
            preg_match($patternFloats, $request->input('pPub')) && 
            preg_match($patternFloats, $request->input('pGan')) && 
            preg_match($patternFloats, $request->input('utilidad')) )
            { 

                $sql='select proID,nombre from producto where nombre="'.$request->input('nombre').'"'; 
                $r = DB::select($sql);
                if(isset($r[0]->nombre))
                {
                    if($r[0]->proID !=  $request->input('id'))
                    return view('updproduct',['inserted'=>false,
                                     'leftnavactive'=>"actualizar"]);
                }
                
                    
                $sql='select proID,scanID from producto where scanID='.$request->input('scanID'); 
                $r = DB::select($sql);
                if(isset($r[0]->scanID))
                {
                    if($r[0]->proID !=  $request->input('id'))
                    return view('updproduct',['inserted'=>false,
                                     'leftnavactive'=>"actualizar"]);
                }
                           
                      DB::table('producto')
                      ->where('proID',$request->input('id'))
                      ->update([
                      'nombre' => $request->input('nombre'),
                      'scanID' => $request->input('scanID'),
                      'exs' => $request->input('exs'),
                      'pUnit' => $request->input('pUnit'),
                      'pPub' => $request->input('pPub'),
                      'pGan' => $request->input('pGan'),
                      'merma' => $request->input('merma'),
                      'utilidad' => $request->input('utilidad')
                      ]);
                      
                      return view('updproduct',['inserted'=>true,
                                                'leftnavactive'=>"actualizar"]);
               
            }
            else
            return view('updproduct',['inserted'=>false,
                      'leftnavactive'=>"actualizar"]); 
                                                   
        }
        else
        {
            //echo "index";    
            return view('updproduct',['leftnavactive'=>"actualizar"]);
        }
       
    }

}
