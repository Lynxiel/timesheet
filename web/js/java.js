$( document ).ready(function() {
    console.log( "ready!" );


    // TIMESHEET
    $('.hasDatepicker[name="mPicker"]').datepicker({
        onSelect : function(cData, inst){
            console.log( "setDate ", cData  );
        }
    });

    console.log( "over!!" );

});