$("#table-content").load("record_query.php?m=all", function() {
    $("#default").remove();
});

$("#submit").on("click", function() {
    var event = $("#event-option").val();
    if (event) {
        $("#table-content").load("record_query.php?m=search&event=" + encodeURIComponent(event));
    } else {
        $("#table-content").load("record_query.php?m=all");
    }
});
