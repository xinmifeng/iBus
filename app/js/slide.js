window.onload=function(){
	$(function () {
		$("#slider").responsiveSlides({
		auto: true,
		pager: false,
		nav: true,
		speed: 500,
		// ??Ӧ????div??class : slide_container
		namespace: "slide"
		});
	});
}
