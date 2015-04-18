<?php

namespace app\controllers;

use app\models\Calendar;
use app\models\Timesheet;
use app\models\Workers;

class TimesheetController extends \yii\web\Controller
{
    public function actionDirector()
    {
        if (isset($_POST['action']) && $_POST['action']=='load_timesheet')
        {
            $curMonth = date("n", strtotime($_POST['cSelectedDate']));
            $curYear = date("Y", strtotime($_POST['cSelectedDate']));
        }
        else
        {
            $curMonth = date("n");
            $curYear = date("Y");
        }

        if (isset($_POST['action']) && $_POST['action']=='save_time')
        {
            $this->SaveHours();
            return;
        }


        $timesheets =Timesheet::GetMonthSheet($curMonth, $curYear);
        $dates = Calendar::getMonthInterval($curMonth, $curYear);
        $workers = Workers::getAllWorkers();
        $model = new Timesheet();
        return $this->render('director', [
            'mPicker' => date('Y-m-d'),
            'dates' => $dates,
            'workers'=>$workers,
            'timesheets'=>$timesheets,
            'model'=>$model
        ]);
    }


    public function actionWorkers()
    {
        if (isset($_POST['action']) && $_POST['action']=='load_timesheet')
        {
            $curMonth = date("n", strtotime($_POST['cSelectedDate']));
            $curYear = date("Y", strtotime($_POST['cSelectedDate']));
        }
        else
        {
            $curMonth = date("n");
            $curYear = date("Y");
        }

        if (isset($_POST['action']) && $_POST['action']=='save_time')
        {
            $this->SaveHours();
            return;
        }


        $timesheets =Timesheet::GetMonthSheet($curMonth, $curYear);
        $dates = Calendar::getMonthInterval($curMonth, $curYear);
        $workers = Workers::getAllWorkers();
        $model = new Timesheet();
        return $this->render('workers', [
            'mPicker' => date('Y-m-d'),
            'dates' => $dates,
            'workers'=>$workers,
            'timesheets'=>$timesheets,
            'model'=>$model
        ]);
    }


    public function SaveHours()
    {
        if (isset($_POST['cRecordId']))
        {
            $timesheet=Timesheet::findOne($_POST['cRecordId']);
            $timesheet->hours=$_POST['cTime'];
            $timesheet->save(); // сохраняем изменения
        }
        else
        {
            $timesheet=new Timesheet();
            $data = explode('/',$_POST['cIdentify']);
            $timesheet->worker_id=$data[0];
            $timesheet->ts_date=$data[1];
            $timesheet->hours=$_POST['cTime'];
            $timesheet->save();
        }
        echo 'OK';
        return;
    }

}
