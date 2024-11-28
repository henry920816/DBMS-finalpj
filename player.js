// search player
$("#submit").on("click", function(event) {
    event.preventDefault();
    var name = $("#name").val();
    if (name.trim() != "") {
        var url = "player_query.php?m=search&p=" + name;
        $("#table-content").load(url);
        $("#default").remove();
    }
})

// display profile
var players = document.getElementsByClassName("row");
var profile = document.getElementById("profile");
var profileContent = document.getElementById("profile-content");

// open profile
$("#table").on("click", ".row", function(event) {
    event.currentTarget.classList.add("select");
    var playerId = this.dataset.value; // get player id

    // show profile animation
    profile.style.height = "100%";
    profile.style.opacity = "100%";
    profileContent.style.marginTop = "100px";
    profileContent.style.marginBottom = "50px";
    profileContent.style.opacity = "100%";

    // load player profile from server
    $("#test").load("player_query.php?m=profile&p=" + playerId);
})

// close the profile
window.onclick = function(event) {
    if (event.target == profile) {
        // unmark as selected
        document.getElementsByClassName("select")[0].classList.remove("select");
        // close animation
        profile.style.height = "0";
        profile.style.opacity = "0";
        profileContent.style.marginTop = "130px";
        profileContent.style.marginBottom = "20px";
        profileContent.style.opacity = "0";
        // clear profile content
        document.getElementById("test").innerHTML = "";
    }
}
