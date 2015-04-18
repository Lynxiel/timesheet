<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Электрика</h2>
        <br>

        <?php
        // Редирект в зависимости от того, кто зашел - директор или простой работник
        if (Yii::$app->user->identity->username=='admin')
        {
            echo '<div class="row text-center">';
                echo '<div class="col-md-6">';
                    echo Html::a('Сотрудники',array('/workers/index'), array('class'=>'btn   btn-lg btn-success'));
                echo '</div>';
                echo '<div class="col-md-6">';
                    echo Html::a('Отчет по часам',array('/timesheet/director'), array('class'=>'btn btn-lg btn-success'));
                echo '</div>';
            echo '</div>';
        }
        else {
            echo Html::a('Отчет по часам',array('/timesheet/workers'), array('class'=>'btn btn-lg btn-success'));
        }
        ?>
    </div>

    <div class="body-content">



    </div>
</div>
