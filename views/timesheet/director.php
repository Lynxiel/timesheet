<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>
<h1>Отчет по часам (директор)</h1>

<div class="directors-form">

   <?php
   if ($timesheets!=false && $dates!=false)
   {
       echo '<table>';
       // header part
       echo '<tr>';
           echo '<th width="20%">ФИО</th>';
            foreach ($dates as $key=>$date)
            {
                if (isset($dates[$key+1]) && $dates[$key+1]['dt']==$date['dt']) continue;
                echo '<th width="30">'.date('d',strtotime($date['dt'])).'</th>';
            }
       echo '</tr>';

       // body part
       $nLastIndex = 0;
       foreach ($timesheets as $key1=>$row)
       {

           if (!isset($timesheets[$key1-1]) || $timesheets[$key1-1]['surname']!=$row['surname'])
           {
               echo '<tr>';
               echo '<td>'.$row['surname']. $row['name'].'</td>';
           }

//           $key2 = 0;
//           foreach ($dates as $key2=>$date)
//           {
//               if ($row['ts_date']==$date['dt'])
//               {
//                   echo '<td>';
//                     echo $row['hours'];
//                   echo '</td>';
//                   $nLastIndex=$key2;
//                   break;
//               }
//               else echo '<td>0</td>';
//           }

           for ($i=0;$i<count($dates)-$nLastIndex;$i++)
           {
               $nStart = $i+$nLastIndex;
               if ($row['ts_date']==$dates[$nStart]['dt'])
               {
                   echo '<td>';
                     echo $row['hours'];
                   echo '</td>';
                   $nLastIndex=$nStart;
                   break;
               }
               else echo '<td>0</td>';
           }

           if (isset($timesheets[$key1+1]) && $timesheets[$key1+1]['surname']!=$row['surname'])
           {
               echo '</tr>';
           }
       }

//       foreach ($dates as $key2=>$date)
//       {
//           echo '<tr>';
//           foreach ($timesheets as $key1=>$row)
//           {
//               if (!isset($timesheets[$key1-1]) || $timesheets[$key1-1]['surname']!=$row['surname'])
//               {
//                   echo '<td>'.$row['surname']. $row['name'].'</td>';
//               }
//               if ($row['ts_date'] == $date['dt']) {
//                   echo '<td>';
//                   echo $row['hours'];
//                   echo '</td>';
//               } else echo '<td>0</td>';
//           }
//
//
//           echo '</tr>';
//       }

       echo '</table>';
   }
   ?>

</div>
