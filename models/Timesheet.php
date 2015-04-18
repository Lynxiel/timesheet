<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timesheet".
 *
 * @property integer $id
 * @property integer $worker_id
 * @property string $ts_date
 * @property string $hours
 *
 * @property Calendar $tsDate
 * @property Workers $worker
 */
class Timesheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timesheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id'], 'integer'],
            [['ts_date', 'hours'], 'safe'],
            [['worker_id', 'ts_date'], 'unique', 'targetAttribute' => ['worker_id', 'ts_date'], 'message' => 'The combination of Worker ID and Ts Date has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'worker_id' => 'Worker ID',
            'ts_date' => 'Ts Date',
            'hours' => 'Hours',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTsDate()
    {
        return $this->hasOne(Calendar::className(), ['dt' => 'ts_date']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorker()
    {
        return $this->hasOne(Workers::className(), ['id' => 'worker_id']);
    }


    public static function GetMonthSheet($month, $year)
    {
        return  (new \yii\db\Query())
            ->select(['dt', 'hours', 'worker_id', 'timesheet.id'])
            ->from('calendar')
            ->join('LEFT OUTER JOIN', 'timesheet', 'dt = timesheet.ts_date')
            ->where(['m' => $month, 'y'=>$year])
            ->orderBy(['timesheet.worker_id' => SORT_DESC, 'dt'=>SORT_ASC])
            ->all();
    }
}
