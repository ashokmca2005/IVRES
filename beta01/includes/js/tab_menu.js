function open_div(mainDiv, sourceDiv){
	if (document.getElementById(mainDiv) && document.getElementById(sourceDiv))
	{
		document.getElementById(mainDiv).innerHTML = document.getElementById(sourceDiv).innerHTML;
	}
}