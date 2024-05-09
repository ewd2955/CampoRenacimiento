<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashier',['leftnavactive'=>"cajero"]);
    }

    public function GetProductFromCode(Request $request)
    {
        //seacrh for the barcode
        $result = DB::select("select * from producto where scanID=".$request->input("barcode"));

        if(isset($result[0]))
            return response()->json(collect($result[0]));

            return response()->json(["scanID"=>""]);
    }
  



    
    public function RegisterSale(Request $request)
    {
       // return response()->json(['msg'=>$request->input('data')]);
        $data =$request->input('data');
        $accType =$request->input('account');
        $ctaID =$request->input('id');
        $ctaNombre =$request->input('nombre');

        $dateTime = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s")) - 6 * 3600);

            DB::table('venta')->insert(
            ['ctaID'=>$ctaID,
            'cuenta'=>$accType,
            'nombre'=>$ctaNombre,
            'fecha'=> $dateTime]
            );
           
            $total=0;
            $totalUnitario = 0;
            $len = sizeof($data);
            $lastVentaID = DB::getPdo()->lastInsertId();
            //return response()->json(['get'=>$data,'lenght'=>$len]);

           // $pPub = $data[0];
          
            
            for ($i=0; $i < $len ; $i++) 
            { 
               
                $sql='insert into prodPorVta(vtaID,proID,qty) 
                values('.$lastVentaID.','.$data[$i]['proID'].','.$data[$i]['cant'].')';
                 $result = DB::select($sql);
                 
                 $pUnit = $data[$i]['precioUnitario'];
                 $pPub = $data[$i]['precio'];
                 $qty = $data[$i]['cant'];

                 $total = $total + doubleval($pPub) * doubleval($qty);
                 $totalUnitario = $totalUnitario + doubleval($pUnit) * doubleval($qty);
                
                 $sql='select exs from producto where proID='.$data[$i]['proID'];
                 $result = DB::select($sql);
                 $exs= intVal($result[0]->exs);

                 $exs = $exs - $qty;

                
                 DB::table('producto')
                ->where('proID',$data[$i]['proID'])
                ->update([
                'exs' => $exs
                ]);

                
            }
        
            DB::table('venta')
                ->where('vtaID',$lastVentaID)
                ->update([
                'total' => $total,
                'totalUnitario' =>$totalUnitario
                ]);
            
        if($accType == "paciente")
        {
            $sql= 'select credito from paciente where pacID='.$ctaID;
            $result = DB::select($sql);     
            $newBalance = $result[0]->credito - $total;            
            $sql= 'update paciente set credito='.$newBalance.' where pacID='.$ctaID;
            DB::select($sql);
        }

        if($accType == "empleado")
        {
            $sql= 'select credito from empleado where empID='.$ctaID;
            $result = DB::select($sql);     
            $newBalance = $result[0]->credito - $total;            
            $sql= 'update empleado set credito='.$newBalance.' where empID='.$ctaID;
            DB::select($sql);
        }

      
       
            
       return response()->json(['vtaID'=>$lastVentaID]);
    }
    function getPrintReceipt(Request $request)
    {
        $list =json_decode($request->input("cashierList"));
    
        return view('printreceipt',['cashierList'=>$list,
                                    'nombre'=>$request->input("nombre"),
                                    'cuenta'=>$request->input("cuenta"),
                                    'total'=>$request->input("total"),
                                    'cant'=>$request->input("cant")]);
    }

 

}
