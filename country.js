// search player
$("#submit").on("click", function(event) {
    event.preventDefault();
    var option = $("#country-sort-option").val();
    var order = $("#country-sort-order").val();
    var str = String.raw`Not Implemented Yet
    
          ╱|、
        (˚ˎ 。7  
         |、˜〵          
        じしˍ,)ノ`
    alert(str);
});

// load the country selection
$(window).on("load", function() {
    $("#table-content").load("country_query.php?m=search");
    $("#default").remove();
})

// display profile
var players = document.getElementsByClassName("row");
var profile = document.getElementById("profile");
var profileContent = document.getElementById("profile-content");

// open profile
$("#table").on("click", ".row", function(row) {
    row.currentTarget.classList.add("select");
    // show profile
    profile.style.height = "100%";
    profile.style.opacity = "100%";
    profileContent.style.marginTop = "100px";
    profileContent.style.marginBottom = "50px";
    profileContent.style.opacity = "100%";
    // request query
    var player = this.cells[0].innerHTML;
    $("#test").load("country_query.php?m=profile");
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
        // clear profile
        document.getElementById("test").innerHTML = "";
    }
}