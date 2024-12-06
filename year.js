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

                $("#sport-option").empty().append('<option value="0">Select Sport</option>');
            },
            error: function () {
                alert("Failed to load years. Please check the server.");
            }
        });
    });

    $("#year-option").on("change", function () {
        var year = $(this).val();
        var type = $("#type-option").val();

        if (year !== "0" && type !== "0") {
            var url = "year_query.php?m=getSports&type=" + encodeURIComponent(type) + "&year=" + year;

            $.ajax({
                url: url,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    $("#sport-option").empty().append('<option value="0">Select Sport</option>');
                    if (data.length > 0) {
                        $.each(data, function (index, sport) {
                            $("#sport-option").append('<option value="' + sport + '">' + sport + '</option>');
                        });
                    } else {
                        $("#sport-option").append('<option value="0">No Available Sports</option>');
                    }
                },
                error: function () {
                    alert("Failed to load sports. Please check the server.");
                }
            });
        }
    });

    $("#submit").on("click", function (event) {
        event.preventDefault();
        var type = $("#type-option").val();
        var year = $("#year-option").val();
        var sport = $("#sport-option").val();

        if (type !== "0" && year !== "0" && sport !== "0") {
            var queryUrl = "year_query.php?m=getResults&type=" + encodeURIComponent(type) + "&year=" + year + "&sport=" + encodeURIComponent(sport);

            $("#table-content").load(queryUrl, function (response, status, xhr) {
                if (status === "error") {
                    alert("Error loading results: " + xhr.status + " " + xhr.statusText);
                }
            });
        } else {
            alert("Please select valid options for type, year, and sport.");
        }
    });
});
