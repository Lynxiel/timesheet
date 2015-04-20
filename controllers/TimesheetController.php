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
            ->select(['name', 'surname', 'patronymic','dt', 'hours', 'worker_id'])
            ->from('workers')
            ->join('LEFT OUTER JOIN', 'timesheet', 'workers.id = timesheet.worker_id')
            ->join('LEFT OUTER JOIN', 'calendar', 'dt = timesheet.ts_date')
            ->where(['m' => $curMonth, 'y'=>$curYear])
            ->orderBy(['workers.id' => SORT_DESC, 'dt'=>SORT_ASC])
            ->all();

        $dates = (new \yii\db\Query())
            ->select([ 'dt', 'dayname'])
            ->from('calendar')
            ->where(['m' => $curMonth, 'y'=>$curYear])
            ->orderBy(['dt'=>SORT_ASC])
            ->all();


        $model = new Timesheet();

        return $this->render('director', [
            'mPicker' => date('Y-m-d'),
            'dates' => $dates,
            'timesheets'=>$timesheets,
            'model'=>$model
        ]);
    }

    public function actionWorkers()
    {
        return $this->render('workers');
    }

}
