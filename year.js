$(document).ready(function () {
    $("#type-option").on("change", function () {
        var type = $(this).val(); 
        var url = "year_query.php?m=getYears&type=" + encodeURIComponent(type);

        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#year-option").empty().append('<option value="0">Select Year</option>');
                if (data.length > 0) {
                    $.each(data, function (index, year) {
                        $("#year-option").append('<option value="' + year + '">' + year + '</option>');
                    });
                } else {
                    $("#year-option").append('<option value="0">No Available Years</option>');
                }
            },
            error: function () {
                alert("Failed to load years. Please check the server.");
            }
        });
    });

    $("#submit").on("click", function (event) {
        event.preventDefault();
        var year = $("#year-option").val();
        var type = $("#type-option").val();

        if (year !== "0" && type !== "0") {
            var queryUrl = "year_query.php?m=getResults&y=" + year + "&type=" + encodeURIComponent(type);

            $("#table-content").load(queryUrl, function (response, status, xhr) {
                if (status === "error") {
                    alert("Error loading results: " + xhr.status + " " + xhr.statusText);
                }
            });
        } else {
            alert("Please select a valid type and year.");
        }
    });
});
