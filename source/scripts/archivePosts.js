function toggleChildren(id) {
	var elem = document.getElementById(id);

	if(elem) {
		if(elem.style.display == "block") {
			elem.style.display = "none";
		}
		else {
			elem.style.display = "block";
		}
	}
}