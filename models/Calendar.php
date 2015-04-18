<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property string $dt
 * @property integer $y
 * @property integer $q
 * @property integer $m
 * @property integer $d
 * @property integer $dw
 * @property string $monthName
 * @property string $dayName
 * @property integer $w
 * @property string $isWeekday
 * @property string $isHoliday
 * @property string $holidayDescr
 * @property string $isPayday
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dt'], 'required'],
            [['dt'], 'safe'],
            [['y', 'q', 'm', 'd', 'dw', 'w'], 'integer'],
            [['monthName', 'dayName'], 'string', 'max' => 9],
            [['isWeekday', 'isHoliday', 'isPayday'], 'string', 'max' => 1],
            [['holidayDescr'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dt' => 'Dt',
            'y' => 'Y',
            'q' => 'Q',
            'm' => 'M',
            'd' => 'D',
            'dw' => 'Dw',
            'monthName' => 'Month Name',
            'dayName' => 'Day Name',
            'w' => 'W',
            'isWeekday' => 'Is Weekday',
            'isHoliday' => 'Is Holiday',
            'holidayDescr' => 'Holiday Descr',
            'isPayday' => 'Is Payday',
        ];
    }


    public static function getMonthInterval($nMonthID, $nYearID)
    {
        return (new \yii\db\Query())
            ->select([ 'dt', 'dayname'])
            ->from('calendar')
            ->where(['m' => $nMonthID, 'y'=>$nYearID])
            ->orderBy(['dt'=>SORT_ASC])
            ->all();
    }
}
