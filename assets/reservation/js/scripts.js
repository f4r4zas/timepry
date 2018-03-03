(function( $ ) {
    $.fn.numeric = function(){
        this.keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||
                    // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        return this;
    };
})( jQuery );
$(function(){
    $(".number-input").numeric();
    $("button[data-toggle=modal]").click(function(){
        $($(this).attr("data-target")).find(".modal-title").text($(this).attr("data-whatever"));
    });
    $.askModal = function(msg){
        $("<div/>",{
            html: $("<div/>",{
                html: $("<div/>",{
                    html: $("<div/>",{
                        html: $("<button/>",{
                            type: "button",
                            html: $("<span/>",{html: "&times;"}).attr("aria-hidden","true")
                        }).addClass("close").attr("data-dismiss","modal").attr("aria-label","Close")
                    }).addClass("modal-header").append($("<div/>").addClass("modal-title text-warning"))
                }).addClass("modal-content").append(
                    $("<div/>",{html: msg}).addClass("modal-body")
                ).append(
                    $("<div/>",{html: msg}).addClass("modal-footer")
                )
            }).addClass("modal-dialog modal-sm")
        }).addClass("").appendTo("body");
    }
    $(".btn-ask").each(function () {
        var hr = $(this).attr("href");
        $(this).attr("href","javascript:;")
            .click(function(){
                $("#askStaticModal").modal("show").find(".modal-body").text($(this).attr("data-msg"))
                    .next().find(".btn-accept").attr("href",hr);
            });
    });
});