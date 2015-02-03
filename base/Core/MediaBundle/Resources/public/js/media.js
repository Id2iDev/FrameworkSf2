$(function () {
    $("[data-button-id2i=media]").removeAttr('disabled');
    $(document).on("click", "[data-mediabundle-ajax='true']", function (ev) {

    });
    $("[data-mediabundle-ajax='true']").on('click', function (ev) {
        ev.preventDefault();

        var target = $(this).attr("href");
        var modal_id = $(this).attr('data-target')
        $(modal_id).modal("hide");
        $(modal_id + " .modal-content").html("");
        // load the url and show modal on success
        $(modal_id + " .modal-content").load(target, function () {
            $(modal_id).modal("show");
        });
    });
    $(document).on("click", "button[data-select-media]", function () {
        var id = $(this).attr("data-select-media");
        var count = 0;
        var copy = $("select#media_select_" + id).html();
        var multiple = $("select#media_select_" + id).attr('multiple');
        $("select#" + id + "").attr('multiple', multiple);
        $("select#" + id + "").html(copy);
        $("select#" + id + " option").each(function () {
            var value = $(this).attr("value");
            if ($("select#media_select_" + id + " option[value=" + value + "]").is(':checked')) {
                $(this).attr('selected', 'selected');
                count++;
            } else {
                $(this).removeAttr('selected');
            }
        });
        $("#count_" + id).html(count);
        $('#mediaBundlePopup' + id).modal('hide')
    })
    $(document).on("click", "button[data-close-media]", function () {
        var id = $(this).attr("data-close-media");
        $('#mediaBundlePopup' + id).modal('hide')
    });
});