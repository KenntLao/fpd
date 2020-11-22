var width = $(window).width();

$(document).ready(function() {
	set_banner_image(width, vertical_img, regular_img);

	$(window).resize(function() {
		width = $(window).width();
		set_banner_image(width, vertical_img, regular_img);
	});
});

function set_banner_image(width, vertical_img, regular_img) {
	if (width <= 500) {
		$(".main_home_banner").attr("src", vertical_img);
	} else {
		$(".main_home_banner").attr("src", regular_img);
	}
}

// function change_img_on_mouse_event
// Change the img src on mouse enter and mouse leave
// args 
// mouseEnterSrc = source or link of the image when the mouse enters the element
// mouseLeaveSrc = source or link of the image when the mouse leave the element
// element = the element to enter and and leave
function change_img_on_mouse_event(mouseEnterSrc, mouseLeaveSrc, element) {
	$(element).mouseenter(function() {
		$(this).closest("div").find("img").attr("src", mouseEnterSrc);
		$(this).find("a").css("opacity", "1");
	});

	$(element).mouseleave(function() {
		$(this).closest("div").find("img").attr("src", mouseLeaveSrc);
		$(this).find("a").css("opacity", "0");
	});
};