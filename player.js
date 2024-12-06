var hover = false;
var enterEdit = false;
var currentMonth;

// search player
$("#submit").on("click", function(event) {
    // load search query
    event.preventDefault();
    var name = $("#name").val();
    if (name.trim() != "") {
        // uncheck edit mode
        $("#edit-enable").prop("checked", false);
        $(".edit, .delete").css("display", "none").css("opacity", "0");
        
        // replace space with %20
        name = name.replaceAll(" ", "%20");
        var url = "player_query.php?m=search&p=" + name;
        $("#table-content").load(url);
        $("#default").remove();
    }
})

// open profile
$("#table").on("click", ".row", function() {
    $(this).addClass("select");
    if (!hover) {
        var playerId = this.dataset.value; // get player id
    
        // show profile animation
        $("#profile").css("height", "100%").css("opacity", "100%");
        $("#profile-content").css("marginTop", "100px").css("marginBottom", "50px").css("opacity", "100%");
    
        // load player profile from server
        $("#profile-req").load("player_query.php?m=profile&p=" + playerId);
    }
})

// close the profile
$("body").on("click", "#profile", function(event) {
    if (!$(event.target).parents().is("#profile")) {
        // unmark as selected
        $(".select").removeClass("select");
        // close animation
        $("#profile").css("height", "0").css("opacity", "0");
        $("#profile-content").css("marginTop", "130px").css("marginBottom", "20px").css("opacity", "0");
        // clear profile content
        $("#profile-req").html("");
    }
})

// open edit ui
$("#table").on("click", ".edit", function(event) {
    var playerId = $(event.target).parents(".row").attr("data-value");
    $("#edit-ui").css("height", "100%").css("opacity", "100%");
    $("#edit-ui-content").css("marginTop", "100px").css("marginButtom", "50px").css("opacity", "100%");
    // load autofill
    $("#edit-req").load("player_query.php?m=edit-ui&p=" + playerId);
})

// close the edit ui
$("body").on("click", "#edit-ui", function(event) {
    if (!$(event.target).parents().is("#edit-ui")) {
        enterEdit = false;
        // unmark as selected
        $(".select").removeClass("select");
        // close animation
        $("#edit-ui").css("height", "0").css("opacity", "0");
        $("#edit-ui-content").css("marginTop", "130px").css("marginBottom", "20px").css("opacity", "0");
        // clear content
        $("#edit-req").html("");
    }
})

$("#cancel").on("click", function() {
    enterEdit = false;
    // unmark as selected
    $(".select").removeClass("select");
    // close animation
    $("#edit-ui").css("height", "0").css("opacity", "0");
    $("#edit-ui-content").css("marginTop", "130px").css("marginBottom", "20px").css("opacity", "0");
    // clear content
    $("#edit-req").html("");
})

$(".slider").on("click", function() {
    if (!$("#edit-enable").prop("checked")) {
        $(".edit").css("right", "-45px").css("opacity", "100%");
        $(".delete").css("right", "-75px").css("opacity", "100%");
    }
    else {
        $(".edit, .delete").css("right", "-1000px").css("opacity", "0");
    }
})

$("#table").on("mouseenter", ".edit, .delete", function() {
    hover = true;
})

$("#table").on("mouseleave", ".edit, .delete", function() {
    hover = false;
})

// change days of month
$("#edit-ui-content").on("click", "#edit-bmonth", function() {
    if (!enterEdit) {
        currentMonth = $("#edit-bmonth").val();
        enterEdit = true;
    }
    var year = $("#edit-byear").val();
    var month = $(this).val();
    if (currentMonth != month) {
        $("#edit-bday").html(" ");
        for (var i = 1; i <= daysInMonth(month, year); i++) {
            $("#edit-bday").append($("<option>", {
                value: i,
                text: i
            }))
        }
        currentMonth = month;
    }
})

$("#edit-ui-content").on("mousedown", function() {
    maintainInput("#edit-byear");
    maintainInput("#edit-height");
    maintainInput("#edit-weight");
})

// send update request to database
$("#confirm").on("click", function() {
    var byear = $("#edit-byear").val();
    var bmonth = $("#edit-bmonth").val();
    var bday = $("#edit-bday").val();
    $.ajax(
        {
            url: "player_query.php?m=edit",
            type: "POST",
            data: {
                "id": $(".select").attr("data-value"),
                "name": $("#edit-name").val(),
                "sex": $("#edit-sex").val(),
                "birthday": byear + "-" + bmonth + "-" + bday,
                "height": $("#edit-height").val(),
                "weight": $("#edit-weight").val(),
                "country": $("#edit-country").val()
            },
            success: function(data) {

                enterEdit = false;
                // unmark as selected
                $(".select").removeClass("select");
                // close animation
                $("#edit-ui").css("height", "0").css("opacity", "0");
                $("#edit-ui-content").css("marginTop", "130px").css("marginBottom", "20px").css("opacity", "0");
                // clear content
                $("#edit-req").html("");

                if (data == "1") {
                    alert("update successfully!");
                }
                else {
                    alert("update failed.");
                }
            }
        }
    )
})


// FUNCTION //

function daysInMonth(month, year) {
    var y = Number(year);
    var m = Number(month);
    return new Date(y, m, 0).getDate();
}

// make sure that the text box is a positive whole number
function maintainInput(selector) {
    var val = Number($(selector).val());
    if (isNaN(val) || val % 1 != 0 || val <= 0) {
        $(selector).val("");
    }
    else {
        $(selector).val(val);
    }
}