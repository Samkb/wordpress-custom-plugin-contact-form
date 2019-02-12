(function($){
//Add data row

$('#add_field').click(function(e){
    e.preventDefault();
    var template = wp.template('htd-contact-form-field');
    var rand = Math.floor(Math.random() * (999 - 10 + 1)) + 10;
    $('#htd-form-field-wrap').append(template({ random: rand }));

});

    $(document).on('click', '.remove-group', function(e) {

    e.preventDefault();

    $(this).parents('.f-options-group').remove();

});

$('#htd-form-field-wrap').sortable();



}(jQuery));