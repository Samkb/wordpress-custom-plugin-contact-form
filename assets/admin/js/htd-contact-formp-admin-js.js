(function($){
//Add data row

$('#add_field').click(function(e){
    e.preventDefault();
    var template = wp.template('htd-contact-form-field');
    var rand = Math.floor(Math.random() * (999 - 10 + 1)) + 10;
    $('#htd-form-field-wrap').append(template({ random: rand }));

});



}(jQuery));