
function setDivHeights() {
if (document.all) {
var iLeftHeight = document.getElementById("innerleft").offsetHeight;
var iRightHeight = document.getElementById("innerright").offsetHeight;
}
else {
var iLeftHeight = document.getElementById("innerleft").clientHeight;
var iRightHeight = document.getElementById("innerright").clientHeight;
}
if (iLeftHeight > iRightHeight) {
document.getElementById("innerright").style.height = iLeftHeight + "px";
}
else {
document.getElementById("innerleft").style.height = iRightHeight + "px";
}
}
