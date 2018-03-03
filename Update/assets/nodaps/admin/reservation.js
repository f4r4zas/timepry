/**
 * Created by Mojtaba on 9/24/2016.
 */

// Public actions plugin
(function ( $ ) {
    $.actionsOnAppointments = function( url, options ) {

        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.
            commandCode: null,
            id: "",
            statusIcons: [],
            statusOptions: {
                0: {
                    iconClass: "fa-times font-yellow"
                },
                1: {
                    iconClass: "fa-check font-green"
                }
            },
            toggleButtons: [],
            toggleOptions: {
                0: {
                    btnText: "",
                    btnIcon: "",
                    btnCommand: ""
                },
                1: {
                    btnText: "",
                    btnIcon: "",
                    btnCommand: ""
                }
            },
            loadingElement: "",
            successMessage: "Your command was successfull",
            successMessageTitle: "Success",
            errorMessage: "There is some system errors! Please report it.",
            errorMessageTitle: "Error"
        }, options );


        if(settings.commandCode != null) {
            var commandIndex = settings.commandCode;
            var newCommandIndex = 0;
            if(commandIndex == 0)
                newCommandIndex = 1;
            $.ajax({
                url: url + settings.id + '/' + settings.toggleOptions[commandIndex].btnCommand,
                beforeSend: function(){
                    if($(settings.loadingElement).length > 0){
                        Metronic.blockUI({
                            target: $(settings.loadingElement),
                            animate: true
                        });
                    }
                },
                complete: function(){
                    if($(settings.loadingElement).length > 0){
                        Metronic.unblockUI($(settings.loadingElement));
                    }
                }
            }).done(function(data) {
                data = JSON.parse(data);
                if(data.status == 'success'){
                    $.each(settings.statusIcons, function(key, item){
                        item.removeClass(settings.statusOptions[commandIndex].iconClass)
                            .addClass(settings.statusOptions[newCommandIndex].iconClass);
                    });
                    $.each(settings.toggleButtons, function(key, item){
                        item.data("value", newCommandIndex);
                        item.find('i').attr('class',settings.toggleOptions[newCommandIndex].btnIcon);
                        item.find('span').text(settings.toggleOptions[newCommandIndex].btnText);
                    });
                    // Refresh Calendar if it exists
                    if($("#calendar").length > 0){
                        $("#calendar").fullCalendar( 'refetchEvents' );
                    }
                    toastr['success'](settings.successMessage, settings.successMessageTitle);
                }else{
                    toastr['error'](data.error, settings.errorMessageTitle);
                }
            }).fail(function(){
                toastr['error'](settings.errorMessage, settings.errorMessageTitle);
            });
        }
        return this;
    };
}( jQuery ));

// Search row scripts for reservation list
var SearchReservationRow = function(URL, TIME_FORMAT){
    $("#filters").select2({
        placeholder: "Filters"
    });

    var formatLanguages = function (opt) {
        if (!opt.id) { return opt.text; }
        var optimage = $(opt.element).data('image');
        if(!optimage){
            return opt.text;
        } else {
            var $opt = $(
                '<img style="width: 16px;" src="' + optimage + '" alt="' + $(opt.element).text() + '" title = "' + $(opt.element).text() + '"/>'
            );
            return $opt;
        }
    };
    var formatLanguagesSelection = function (opt) {
        if (!opt.id) { return opt.text; }
        var optimage = $(opt.element).data('image');
        if(!optimage){
            return opt.text;
        } else {
            return '<img style="width: 16px;" src="' + optimage + '" alt="' + $(opt.element).text() + '" title = "' + $(opt.element).text() + '"/>';
        }
    };
    $("#language").select2({
        placeholder: "Languages",
        formatResult: formatLanguages,
        formatSelection: formatLanguagesSelection,
        minimumResultsForSearch: Infinity
    });


    $(".my-datepicker").datepicker({
        autoclose: true,
        format: TIME_FORMAT,
        clearBtn: true,
        todayHighlight: true
    });

    var make_query_stting = function(print_view){
        var query_string = "?";
        if(print_view!=0){
            query_string += 'print=1&';
        }
        if($("#search-name").val()!=''){
            query_string += 'search_name=' + $("#search-name").val() + '&';
        }
        if($("#reservation-id").val()!=''){
            query_string += 'id=' + $("#reservation-id").val() + '&';
        }
        if($("#min-date").val()!=''){
            query_string += 'min_date=' + $("#min-date").val() + '&';
        }
        if($("#max-date").val()!=''){
            query_string += 'max_date=' + $("#max-date").val() + '&';
        }
        if($("#min-app-date").val()!=''){
            query_string += 'min_app_date=' + $("#min-app-date").val() + '&';
        }
        if($("#max-app-date").val()!=''){
            query_string += 'max_app_date=' + $("#max-app-date").val() + '&';
        }
        if($("#service").val()!=0){
            query_string += 'service=' + $("#service").val() + '&';
        }
        if($("#language").val() != 0 && $("#language").val() != null){
            query_string += 'language=' + $("#language").val() + '&';
        }
        if($("#filters").val() != 0 && $("#filters").val() != null){
            query_string += 'filters=' + $("#filters").val() + '&';
        }
        return query_string;
    };

    $("#submit-search").click(function(){
        var query_string = make_query_stting(0);
        window.location = URL + encodeURI(query_string);
    });

    $("#submit-print").click(function(){
        var query_string = make_query_stting(1);
        window.open(URL + encodeURI(query_string), "_blank");
    });
};