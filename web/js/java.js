$( document ).ready(function() {
    // TIMESHEET
    if  ($('.directors-form').length!=0)
    {
        TimesheetLoad();

        $('.timepicker').on('hide.timepicker', function(inst) {

            var DomThis = $(this);
            SaveHours(DomThis,inst);
        });
    }


});

function SaveHours(DomThis, time)
{
    var cTime = time.time.value;
    var cRecordId  = DomThis.attr('record_id');
    var cIdentify = DomThis.attr('name');
    $.post('',
        {
            cTime: cTime,
            action: 'save_time',
            cRecordId: cRecordId,
            cIdentify: cIdentify

        },function(response)
        {
            console.log(response);
        } );
}

function TimesheetLoad()
{

    $('[name="mPicker"]').datepicker({
        onClose : function(cData, inst){
            $.post('',
                {
                    cSelectedDate: cData,
                    action: 'load_timesheet'
                },function(response)
                {
                    $('.directors-form').remove();
                    $('.main-content').append($(response).find('.directors-form'));
                } );
        }
    });
}