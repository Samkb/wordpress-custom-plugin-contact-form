(function($){

    $('.htd-dpkr').datepicker();
    
    $(document).on( 'click', '.htd-cf-frontend-submit', function(e){

        e.preventDefault();

        // validate all input filed

        var isvalid =true;
        var parent = $(this).parents('.htd-frontend-form');

        $('.htd-frontend-form input').each(function(){
            if ($(this).parsley().validate() !== true) isvalid = false;
        });

        if (isvalid){

            var form_fields= $('.htd-frontend-form').serialize();
            console.log(form_fields);

        }


    } )
    }(jQuery));