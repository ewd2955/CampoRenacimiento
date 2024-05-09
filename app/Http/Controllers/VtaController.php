<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;

class Vtacontroller extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard',['leftnavactive'=>"ventas"]);
    }
    
    public function GetDaily()
    {
        $sql='select sum(total) as dailyTotal from venta 
        where DATE(fecha)=DATE(now());';
             $result = DB::select($sql);

        return response()->json(['dailyTotal'=>$result[0]->dailyTotal]);
    }

    public function GetWeekly()
    {
        $sql='select sum(total) as weeklyTotal FROM venta
        WHERE WEEK(fecha) = WEEK(CURRENT_DATE())
        AND MONTH(fecha) = MONTH(CURRENT_DATE())';
             $result = DB::select($sql);

        return response()->json(['weeklyTotal'=>$result[0]->weeklyTotal]);
    }
    public function GetMonthly()
    {
        $sql='select sum(total) as monthlyTotal FROM venta
        WHERE MONTH(fecha) = MONTH(CURRENT_DATE())
        AND YEAR(fecha) = YEAR(CURRENT_DATE())';
             $result = DB::select($sql);

        return response()->json(['monthlyTotal'=>$result[0]->monthlyTotal]);
    }
    public function GetVtaPorCta(Request $request)
    {
       // $page = $request->input('page'); // Get the requested page number
       // $recordsPerPage = 1000000;
       // $offset = ($page - 1) * $recordsPerPage;

       //sql: LIMIT ' . $recordsPerPage . ' OFFSET ' . $offset;
       
        $start_date=$request->input('start');
        $end_date=$request->input('end');
        $cuenta=$request->input('cuenta');
      
       $sql = 'select vtaID,nombre,total,totalUnitario,fecha FROM venta WHERE cuenta="'.$cuenta.'" 
       AND date(fecha) BETWEEN date("'.$start_date.'") AND date("'.$end_date.'")';
        $r1 = DB::select($sql);
  /** 
        $sql = 'select vtaID,nombre,total,fecha FROM venta WHERE cuenta="'.$cuenta.'" 
       AND date(fecha) BETWEEN date("'.$start_date.'") AND date("'.$end_date.'")';
        $r1 = DB::select($sql);
*/
        $sql = 'select sum(total) as sumTotal, sum(totalUnitario) as sumTotalUnitario FROM venta WHERE cuenta="'.$cuenta.'" 
       AND date(fecha) BETWEEN date("'.$start_date.'") AND date("'.$end_date.'")';
        $r2 = DB::select($sql);
        if(isset($r2[0]))
        return response()->json(['get'=>collect($r1),'total'=>$r2[0]->sumTotal,'totalUnitario'=>$r2[0]->sumTotalUnitario]);
        else
        return response()->json(['get'=>collect($r1),'total'=>"0",'totalUnitario'=>"0"]);



       
    
    //  return response()->json(['get'=>"ok"]);
    }

    public function GetWeeklySalesPerUser()
    {
        $sql= 'select pacID,nombre from paciente where estado=true';
        $result = DB::select($sql);

        $k=0;
       $pacList = array();
        foreach ($result as $key => $value) 
        {

            $sql= 'select sum(total) as total from venta 
            where cuenta="paciente" and ctaID='.$result[$key]->pacID;
            $result1 = DB::select($sql);

            $pacList[$k] =$result[$k]->nombre;
            $totalList[$k] = $result1[0]->total;

           $k++;
         }

         return response()->json(['nombreList'=>$pacList,
                                  'totalList'=>$totalList]);
    }
    public function Restore()
    {
        $sql='select count(nombre) as size from paciente';
        $result = DB::select($sql);

        $sql='select pacID,defCred from paciente';
        $id= DB::select($sql);

        for ($i=0; $i < $result[0]->size ; $i++) { 

            $sql='update paciente set credito='.$id[$i]->defCred.' 
            where pacID='.$id[$i]->pacID;
            DB::select($sql);
            
        }

        $sql='select count(nombre) as size from empleado';
        $result = DB::select($sql);

        $sql='select empID,defCred from empleado';
        $id= DB::select($sql);

        for ($i=0; $i < $result[0]->size ; $i++) { 

            $sql='update empleado set credito='.$id[$i]->defCred.' 
            where empID='.$id[$i]->empID;
            DB::select($sql);
            
        }

        return view('updpatient',['leftnavactive'=>"corte",
                                  'corte'=>"Credito restablecido"]);
    }

    function getSaleProds(Request $request)
    {
        $sql = 'select producto.nombre,producto.pPub,prodPorVta.qty from prodPorVta 
        inner join venta on prodPorVta.vtaID=venta.vtaID 
        inner join producto on prodPorVta.proID = producto.proID 
        where venta.vtaID ='.$request->input("vtaID");
        $result = DB::select($sql);

        return response()->json(collect($result));
    }


}