$(document).ready(function() {
    $("#table-content").load("record_query.php?m=all");

    $.ajax({
        url: "record_query.php",
        type: "GET",
        data: { m: "get_events" },
        success: function(response) {
            $("#event-option").html(response);
        }
    });

    $("#submit").on("click", function() {
        var event = $("#event-option").val();
        if (event) {
            $("#table-content").load("record_query.php?m=search&event=" + encodeURIComponent(event));
        } else {
            $("#table-content").load("record_query.php?m=all");
        }
    });
});
