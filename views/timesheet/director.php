<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
?>
<h1>Отчет по часам (директор)</h1>

<div class="directors-form">
    <div class="row">
        <div class="col-md-6">
            <?php
            echo DatePicker::widget([
                 'name'  => 'mPicker',
                 'value'  => date('Y-m-d', strtotime('- 1 day')),
                 'language' => 'ru',
                 'dateFormat' => 'yyyy-MM-dd',
             ]);
            ?>
        </div>
    </div>
    <br>
   <?php
if  ($timesheets!=false)
{
    echo '<div class="table-responsive">';
        echo '<table class="director-timesheet table-hover table-striped">';

        echo '<tr>';
        // draw header
        echo '<th width="7%">ФИО</th>';
        foreach ($dates as $key=>$date)
        {
            if (isset($dates[$key+1]) && $dates[$key+1]['dt']==$date['dt']) continue;
            echo '<th width="3%"  class="text-center">'.date('d',strtotime($date['dt'])).'</th>';
        }
        echo '</tr>';

        // manipulation to show array in table
        reset($dates);
        foreach ($timesheets as $key=>$row)
        {

            if (!isset($timesheets[$key-1]) ||  $timesheets[$key-1]['worker_id']!=$row['worker_id'] )
            {
                echo '<tr>';
                echo '<td>'.$row['surname']. ' '. '</td>';
                reset($dates);
            }


            for ($i=0; $i<count($dates); $i++)
            {
                $elem = current($dates);
                if ($elem['dt']==$row['dt'])
                {
                    echo '<td  class="text-center '. ($elem['dayname']=='sunday'?'danger':'') .'">'.$row['hours'].'</td>';
                    next($dates);
                    $elem=(current($dates));
                    if ((!isset($timesheets[$key+1]) ||  $timesheets[$key+1]['worker_id']!=$row['worker_id']) && key($dates)<count($dates)  )
                    {
                        while(key($dates)!=null)
                        {echo '<td  class="text-center">-</td>'; next($dates);}
                    }
                    break;
                }
                else echo '<td  class="text-center">-</td>';
                next($dates);
            }
            if (!isset($timesheets[$key+1]) ||  $timesheets[$key+1]['worker_id']!=$row['worker_id'] )
            {
                echo '</tr>';
                reset($dates);
            }
        }
        echo '</table>';
    echo '</div>';
}
else echo '<h3>Ничего нет!</h3>';

   ?>

</div>
