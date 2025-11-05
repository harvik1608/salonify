$(document).ready(function(){
	if($("#flashMsg").length) {
	    show_toast("success",$("#flashMsg").text());
	}
	$("a.userset").click(function(){
	    if($(this).hasClass("show")) {
	        $(this).removeClass("show");
	        $(this).attr("aria-expanded",false);
	        $(".menu-drop-user").removeClass("show");
	    } else {
	        $(this).addClass("show");
	        $(this).attr("aria-expanded",true);
	        $(".menu-drop-user").addClass("show");
	        $(".menu-drop-user").css({
	            position: "absolute",
	            inset: "0px 0px auto auto",
	            margin: "0px",
	            transform: "translate(0px, 34px)"
	        });
	    }
	});
	$("li.submenu-open").each(function(){
	    if($(this).find("ul li").length == 0) {
	        $(this).remove();
	    }
	});
	// if($('.summernote').length > 0) {
	//     $('.summernote').summernote({
	//         placeholder: 'Type here...',
	//         tabsize: 2,
	//         height: "auto"
	//     });
	// }
	$("#main_menu_list li").each(function(){
	    if($.trim($(this).text()) == page_title) {
	        $(this).addClass("active");
	    }
	});
});
function show_toast(type,message)
{
	ButterPop.show({
		message: message,
		type: type,
		position: "top-right",
		theme: "default",
		duration: 50000,
		progress: true,
		closable: true,
		pauseOnHover: true,
		closeOnClick: false
	});
}