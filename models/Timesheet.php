<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timesheet".
 *
 * @property integer $id
 * @property integer $worker_id
 * @property string $ts_date
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
            [['ts_date'], 'safe']
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
}
