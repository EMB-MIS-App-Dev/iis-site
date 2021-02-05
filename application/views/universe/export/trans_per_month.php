<style>
  table {
      border-collapse: collapse;
  }
  td {
    border: 1px solid black;
  }
</style>
<?php

  if(isset($_POST["univxport"]))
  {
    $result = mysql_query("SELECT nt.coid, nt.ecc AS 'c1', nt.cnc AS 'c2', nt.luc AS 'c3', nt.dp AS 'c4', nt.po AS 'c5', nt.hwid AS 'c6', nt.piccs AS 'c7', nt.sqi AS 'c8', nt.ccoreg AS 'c9', nt.ccoic AS 'c10', nt.memo AS 'c11', nt.so AS 'c12', nt.comm AS 'c13', nt.invtn AS 'c14', nt.cmplnt AS 'c15', co.coid, co.coname, co.addid, co.cocat, co.embid, ad.addid, ad.prov, ad.city, ad.brgy, ad.strt, ad.hsno, pr.provid, pr.provname, ct.ctid, ct.ctname, bg.brgyid, bg.brgyname FROM dms.ntyr nt JOIN dms.comp co ON co.coid = nt.coid JOIN dms.adrss ad ON co.addid = ad.addid JOIN dms.prov pr ON ad.prov = pr.provid JOIN dms.city ct ON ad.city = ct.ctid JOIN dms.brgy bg ON ad.brgy = bg.brgyid WHERE co.stat != '0' ORDER BY nt.coid");

    if(mysql_num_rows($result) != 0)
    {
       // 12 tr
      $output .= '
        <table>
          <tr>
            <th>IIS No.</th>
            <th>Comp/Proj Name</th>
            <th>EMB ID</th>
            <th>Subject</th>
            <th>Transaction Type</th>
            <th>Status</th>
            <th>Action Taken</th>
            <th>Sender</th>
            <th>DateTime Forwarded</th>
            <th>Receiver</th>
            <th>Remarks</th>
            <th>Action</th>
          </tr>
      ';

      while($row = mysql_fetch_assoc($result))
      {
        $sz = " St.";
        $space = " ";
        $comma = ",";

        $hs = $row['hsno'];
        $st = $row['strt'];
        $brgg = ucwords($row['brgyname']);
        $ctt = ucwords($row['ctname']);
        $provv = ucwords($row['provname']);
        $address = $hs .' ' . $st .=$sz .' Brgy. '. $brgg .', '. $ctt .', '.$provv;
        $output .= '
          <tr>
            <td>'.$row["embid"].'</td>
            <td>'.$row["coname"].'</td>
            <td>'.$address.'</td>  ';

            for($cntr = 1; $cntr < 16; $cntr++)
            {
              $dcnt = 'c'.$cntr;
              $finalout = $row[$dcnt];
              $erstatq = mysql_query("SELECT * FROM er2.erstat st WHERE st.statid = '$finalout' ");
              $erstat = mysql_fetch_assoc($erstatq);
              $output .= '<td>'.$erstat['statdesc'].'</td>';
            }
        $output .= '
          </tr> ';
      }
    }
    $output .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=IIS - Trans and Docs per Month.xls');
    echo $output;
  }
?>
