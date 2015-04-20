<?php

namespace app\controllers;

use app\models\Timesheet;

class TimesheetController extends \yii\web\Controller
{
    public function actionDirector()
    {
        $curMonth = date("n");
        $curYear = date("Y");
        $timesheets = (new \yii\db\Query())
            ->select(['name', 'surname', 'patronymic','ts_date', 'hours'])
            ->from('timesheet')
            ->join('INNER JOIN', 'workers', 'workers.id = timesheet.worker_id')
            ->join('INNER JOIN', 'calendar', 'dt = timesheet.ts_date')
            ->where(['m' => $curMonth, 'y'=>$curYear])
            ->orderBy(['workers.id' => SORT_DESC])
            ->all();

        $dates = (new \yii\db\Query())
            ->select([ 'dt'])
            ->from('calendar')
            ->where(['m' => $curMonth, 'y'=>$curYear])
            ->orderBy(['dt'=>SORT_ASC])
            ->all();



        return $this->render('director', [
            'dates' => $dates,
            'timesheets'=>$timesheets,
        ]);
    }

    public function actionWorkers()
    {
        return $this->render('workers');
    }

}
