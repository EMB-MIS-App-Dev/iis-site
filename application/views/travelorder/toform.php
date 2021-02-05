<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <img class="head" src="'.base_url().'/uploads/templates/headCO.gif">
        <br><br>
        <table style="width:100%;font-family:times;text-align:center;">
          <tr style="font-weight:bold;font-size:13px;">
            <td>TRAVEL ORDER</td>
          </tr>
          <tr>
            <td style="font-size:12px;">('.$query[0]['toid'].')</td>
          </tr>
        </table>
        <br><br><br>

        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;">Name</td>
            <td style="width:2%;">:</td>
            <td style="width:43%;font-weight:bold;">'.$name.'</td>
            <td style="width:15%;">Division</td>
            <td style="width:2%;">:</td>
            <td style="width:22%;font-weight:bold;">'.$divcode.'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Position</td>
            <td style="width:2%;">:</td>
            <td style="width:43%;font-weight:bold;">'.$position.'</td>
            <td style="width:15%;">Section</td>
            <td style="width:2%;">:</td>
            <td style="width:22%;font-weight:bold;">'.$section.'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:15%;">Departure Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['departure_date'])).'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Arrival Date</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['arrival_date'])).'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Official Station</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.$query[0]['official_station'].'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:15%;">Destination</td>
            <td style="width:2%;">:</td>
            <td style="width:82%;font-weight:bold;">'.$destination.'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;font-weight:bold;">Purpose of Travel</td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:98%;"><br></td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:98%;height:70px;text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$query[0]['travel_purpose'].'</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:30%;">Per diems/Expenses Allowed</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$per_diem.'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:30%;">Assistant or Laborers Allowed</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$assistant.'</td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;font-weight:bold;">Appropriations to which travel should be charge</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:30%;">Remarks of Special Instruction</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.$query[0]['remarks'].'</td>
          </tr>
          <tr style="font-size:11px;line-height: 1.6;">
            <td style="width:30%;">Date of Submission</td>
            <td style="width:2%;">:</td>
            <td style="width:66%;font-weight:bold;">'.date("M d, Y", strtotime($query[0]['report_submission'])).'</td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;font-weight:bold;">Certification:</td>
          </tr>
          <tr style="font-size:11px;">
            <td style="width:98%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is to certify that the travel is necessary and is connected with the functions of the official/Employee and this Division/Section/Unit.</td>
          </tr>
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:11px;">
            <td style="width:98%;">Approved:</td>
          </tr>
        </table>
        <br>
        <table>
          <tr>
            <td style="text-align:center;top:100%;"><img class="head" src="'.base_url().'/uploads/templates/directoresig.PNG" style="width:150px;"></td>
            <td style="text-align:center;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http%3A%2F%2F'.$query[0]['toid'].'%2F&choe=UTF-8" style="width:100px;"></td>
          </tr>
        </table>
        <br><br>
        <table style="font-family:times;">
          <tr style="font-size:12px;line-height: 20%;">
            <td style="width:99%;"> <hr style="line-height: 80%;"></td>
          </tr>
          <tr style="font-size:8px;text-align:justify;font-weight:bold;">
            <td style="width:98%;">Subject to the condition that (1)official/employee concerned has no outstanding cash advance on previous travel, (2)he/she shall settle the cash advance that may be given him/her present hereto within thirty (30) Days after date of return to permanent station and, (3)other applicable provisions of COA Circular N0.96-004,dated April 19,1996.</td>
          </tr>
        </table>

</body>
</html>