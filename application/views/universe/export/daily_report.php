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
    $output .= '
      <table>
          <thead>
              <th>ENVIRONMENTAL MANAGEMENT BUREAU</th>
          </thead>
          <tbody>
              <tr>
                  <td>DAILY MONITORING REPORT</td>
              </tr>
              <tr> <td> </td> </tr>
              <tr>
                  <td>TOTAL TRANSACTIONS TO DATE(IIS Data)</td>
              </tr>
              <tr>
                  <td>TOTAL DAILY NEW TRANSACTION CREATED</td>
              </tr>
              <tr>
                  <td>TOTAL DAILY TRANSACTIONS ACTED(IIS Data) as of date:__</td>
              </tr>
              <tr> <td> </td> </tr>
              <tr>
                  <td>PERMITTING OPERATIONS ( From Online Permitting System data)</td>
              </tr>
              <tr>
                  <td>NUMBER OF</td>
              </tr>
              <tr> <td> </td> </tr>
              <tr>
                  <td>PERMIT APPLICATIONS TO DATE</td>
              </tr>
              <tr>
                  <td>DAILY APPLICATIONS RECEIVED</td>
              </tr>
              <tr> <td> </td> </tr>
              <tr>
                  <td>TOTAL</td>
              </tr>
              <tr>
                  <td>TOTAL</td>
              </tr>
          </tbody>
    ';

    $output .= '</table>';
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=IIS- Daily Report.xls');
    echo $output;
  }
?>
