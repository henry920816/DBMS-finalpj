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
    maintainInput(".edit-event-year-textbox");
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

$("#edit-ui-content").on("click", "#edit-new-event-btn", function() {
    // backslash used for format purpose
    var rowString = "\
    <tr>\
        <td>\
            <button class='remove-new-event'>\
                <span class='material-symbols-outlined'>\
                    close\
                </span>\
            </button>\
        </td>\
        <td>\
            <select class='edit-new-event-season left' style='width: 95px'>\
                <option class='empty'>(Season)</option>\
                <option value='summer'>Summer</option>\
                <option value='winter'>Winter</option>\
            </select>\
            <span class='edit-event-container'>\
                <select class='edit-new-event-year' style='width: 85px'>\
                    <option class='empty'>(Year)</option>\
                </select>\
                <input type='text' class='edit-event-year-textbox bottom' style='width: 85px'>\
            </span>\
            <span class='edit-event-container'>\
                <select class='edit-new-event-sport' style='width: 200px'>\
                    <option class='empty'>(Sport)</option>\
                </select>\
                <input type='text' class='edit-event-sport-textbox bottom' style='width: 200px'>\
            </span>\
            <span class='edit-event-container'>\
                <select class='edit-new-event-event right' style='width: 320px'>\
                    <option class='empty'>(Event)</option>\
                </select>\
                <input type='text' class='edit-event-event-textbox bottom' style='width: 320px'>\
            </span>\
        </td>\
    </tr>";

    $("#edit-events-table tbody").prepend(rowString);
})

// dynamically create selection
// * change event listener won't give a damn when the value is changed by jquery load so i have to do it manually *
$("#edit-ui-content").on("change", ".edit-new-event-season", function() {
    var row = $(this).parents("td");
    var season = $(this).val();
    $(this).children(".empty").remove();
    row.find(".edit-new-event-year").load("options_query.php?m=year&s=" + season, function() {
        var year = $(this).val();
        row.find(".edit-new-event-sport").load("options_query.php?m=sport&s=" + season + "&y=" + year, function() {
            var sport = $(this).val();
            row.find(".edit-new-event-event").load("options_query.php?m=event", {
                "season": season,
                "year": year,
                "sport": sport,
                "sex": $("#edit-sex").val()
            }, function() {
                newInstance($(this), row.find(".edit-event-event-textbox"));
            });
            newInstance($(this), row.find(".edit-event-sport-textbox"));
        });
        newInstance($(this), row.find(".edit-event-year-textbox"));
    });
})

$("#edit-ui-content").on("change", ".edit-new-event-year", function() {
    var row = $(this).parents("td");
    var season = row.find(".edit-new-event-season").val();
    var year = $(this).val();
    row.find(".edit-new-event-sport").load("options_query.php?m=sport&s=" + season + "&y=" + year, function() {
        var sport = $(this).val();
        row.find(".edit-new-event-event").load("options_query.php?m=event", {
            "season": season,
            "year": year,
            "sport": sport,
            "sex": $("#edit-sex").val()
        }, function() {
            newInstance($(this), row.find(".edit-event-event-textbox"));
        });
        newInstance($(this), row.find(".edit-event-sport-textbox"));
    });
    newInstance($(this), row.find(".edit-event-year-textbox"));
})

$("#edit-ui-content").on("change", ".edit-new-event-sport", function() {
    var row = $(this).parents("td");
    var season = row.find(".edit-new-event-season").val();
    var year = row.find(".edit-new-event-year").val();
    var sport = $(this).val();
    row.find(".edit-new-event-event").load("options_query.php?m=event", {
        "season": season,
        "year": year,
        "sport": sport,
        "sex": $("#edit-sex").val()
    }, function() {
        newInstance($(this), row.find(".edit-event-event-textbox"));
    })
    newInstance($(this), row.find(".edit-event-sport-textbox"));
})

$("#edit-ui-content").on("change", ".edit-new-event-event", function() {
    newInstance($(this), $(this).parents("td").find(".edit-event-event-textbox"));
})

$("#edit-ui-content").on("click", ".remove-new-event", function() {
    $(this).parents("tr").remove();
})

// FUNCTION //

function daysInMonth(month, year) {
    var y = Number(year);
    var m = Number(month);
    return new Date(y, m, 0).getDate();
}

// make sure that the text box is a positive whole number
function maintainInput(selector) {
    $(selector).each(function() {
        var val = Number($(this).val());
        if (isNaN(val) || val % 1 != 0 || val <= 0) {
            $(this).val("");
        }
        else {
            $(this).val(val);
        }
    })
}

// if a selection value=new, display the text box for user to type in the new option
// element - <jQuery selector> - the select box
/**
 * @param {JQuery<any>} checkElement 
 * @param {JQuery<any>} targetElement
 */
function newInstance(checkElement, targetElement) {
    var row = checkElement.parents("tr");
    if (checkElement.val() == "new") {
        targetElement.css("display", "block");
    }
    else {
        targetElement.css("display", "none");
    }

    // check if all three possible textboxes are open
    if (row.find(".edit-new-event-year").val() == "new" || row.find(".edit-new-event-sport").val() == "new" || row.find(".edit-new-event-event").val() == "new") {
        row.css("border-bottom", "32px solid transparent");
    }
    else {
        row.css("border-bottom", "0");
    }
}