var calendarElem = $('#DatePicker').datepicker({
    changeMonth: true,
    changeYear: true,
    minDate: 0,
    //The calendar is recreated OnSelect for inline calendar
    onSelect: function (date, dp) {
        updateDatePickerCells( dp );
    },
    onChangeMonthYear: function(month, year, dp) {
        updateDatePickerCells( dp );
    },
    beforeShow: function(elem, dp) {
        updateDatePickerCells( dp );
    }
});

var datepicker = $.datepicker._getInst(calendarElem[0]);
updateDatePickerCells(datepicker);
function updateDatePickerCells(dp) {
    setTimeout(function () {

        var cellContents = {1: ' 543$',2: ' 543$',3: ' 543$',4: ' 403$', 5: ' 125$',6: ' 403$',7: ' 403$',8: ' 403$',9: ' 403$',10: ' 403$',11: ' 403$',12: ' 239$',13: ' 339$',14: ' 403$',15: ' 239$', 16: ' 125$', 17: ' 239$',18: ' 239$',19: ' 239$',20: ' 339$',21: ' 439$',22: ' 239$',23: ' 239$',24: ' 239$',25: ' 239$',26: ' 239$',27: ' 325$',28: ' 425$', 29: ' 125$', 30: ' 125$', 31: ' 125$'};
        $('.ui-datepicker td > *').each(function (idx) {
            var value = cellContents[idx + 1] ;

            $(this).attr('data-content', value);

        });
    }, 0);
}
