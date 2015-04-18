<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */


?>
<h1>Отчет по часам</h1>



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


<div class="directors-form">

    <br>
    <?php
    $aTotalHours = array();
    echo '<div class="directors-form">';
    echo '<table class="director-timesheet table-responsive">';
    echo '<th>ФИО</th>';
    foreach ($dates as $key=>$date)
    {
        if (isset($dates[$key+1]) && $dates[$key+1]['dt']==$date['dt']) continue;
        echo '<th width="40" class="text-center">'.date('d',strtotime($date['dt'])).'</th>';
    }
    echo '</tr>';


    foreach ($workers as $key1=>$worker)
    {
        $aTotalHours[$key1]['surname']=$worker['surname'];
        $aTotalHours[$key1]['tariff']=$worker['tariff'];
        echo '<tr>';
        echo '<td class="warning">'.$worker['surname'].'</td>';
        foreach ($dates as $key2=>$date)
        {
            echo '<td ' .(($date['dayname']=='Sunday' || $date['dayname']=='Saturday')?' class="holiday" ':'') . '>';
            foreach ($timesheets as $keyt=>$timesheet)
            {
                if ($timesheet['dt']==$date['dt'] &&  $worker['id']==$timesheet['worker_id'])
                {
                    // split hours and minutes
                    $aTime = explode( ':',$timesheet['hours']);
                    $aTotalHours[$key1]['hours']+=$aTime[0];
                    $aTotalHours[$key1]['minutes']+=$aTime[1];
                    echo TimePicker::widget([
                        'name' => $worker['id'] . '/' . $date['dt'],
                        'value' => $timesheet['hours'],
                        'disabled' => ((date('Y-m-d')==$date['dt'])?false:true),
                        'pluginOptions' => [
                            'showSeconds' => false,
                            'showMeridian' => false,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                        ],
                        'options' => ['class' => 'timepicker','record_id'=>$timesheet['id']]
                    ]);
                    break;
                }
                elseif ( ($keyt+1)==count($timesheets) )
                {
                    echo TimePicker::widget([
                        'name' => $worker['id'] . '/' . $date['dt'],
                        'value' => '0:00',
                        'disabled' => ((date('Y-m-d')==$date['dt'])?false:true),
                        'pluginOptions' => [
                            'showSeconds' => false,
                            'showMeridian' => false,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                        ],
                        'options' => ['class' => 'timepicker']
                    ]);
                }

            }


            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    //   }

    echo '<br><hr>';

    echo '<table>';
    echo '<th width="100">ФИО</th>';
    echo '<th width="100">Ставка</th>';
    echo '<th width="100">Часов всего</th>';
    echo '<th width="100">Сумма</th>';
    foreach ($aTotalHours as $row)
    {
        echo '<tr>';

        $nHourAdd = floor($row['minutes']/60);
        $fSumm = $row['tariff'] *( $row['hours'] + ($row['minutes']/60) );
        $row['minutes'] = ($row['minutes']%60);
        echo '<td>'.$row['surname'] . '</td>
             <td>'.$row['tariff'] . '</td>
             <td>' . ($row['hours']+$nHourAdd) . ':' , $row['minutes'] . '</td>';
        echo '<td>'.sprintf('%01.2f',$fSumm).'</td>';

        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';

    ?>

</div>
