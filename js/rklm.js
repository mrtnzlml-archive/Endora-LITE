function scroll() {
	if(self != top) {
		var div = document.getElementById("rklm-wplugin");
		var rect = div.getBoundingClientRect();
		window.scrollBy(0, rect.top - 50);
	}
}