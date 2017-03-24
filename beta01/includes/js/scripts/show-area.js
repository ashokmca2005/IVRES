function toggle() {
	var ele = document.getElementById("area-overview");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
                ele.style.display = "none";
	       text.innerHTML = "Show area overview";
        }
	else {
	       ele.style.display = "block";
	       text.innerHTML = "Hide area overview";
	}
} 