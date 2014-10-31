$(document).ready(function () {
    $('#supplementary_offer').show();
    $('#discount').hide();

    $('#contract_type').change(function () {
        var choice = $(this).val();
        if ( choice == 'postpaid' )
        {
            $('#supplementary_offer').hide();
            $('#discount').show();
        } else
        {
            $('#supplementary_offer').show();
            $('#discount').hide();
        }
    });
});
