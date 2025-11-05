function next_step()
{
	if ($('.step-1').is(':visible')) {
		if($("#name").val().trim() == "") {
			show_toast("Enter your name","Oops!");
		} else if ($("#email").val().trim() != "" && !isValidEmail($("#email").val().trim())) {
	        show_toast("Enter your valid email", "Oops!");
	    } else {
	    	$('.step-1').hide();
	    	$('.step-2').show();
	    }
	} else if ($('.step-2').is(':visible')) {
		if($("#gender").val().trim() == "") {
			show_toast("Choose your gender","Oops!");
		} else if ($("#dob").val().trim() == "") {
	        show_toast("Choose your DOB", "Oops!");
	    } else {
	    	$('.step-2').hide();
	    	$('.step-3').show();
	    }
	} else if ($('.step-3').is(':visible')) {
		if($("#phone").val().trim() == "") {
			show_toast("Enter your mobile no.","Oops!");
		} else if($("#phone").val().trim().length != 10) {
			show_toast("Enter your 10 digit mobile no.","Oops!");
		} else if ($("#password").val().trim() == "") {
	        show_toast("Enter your password", "Oops!");
	    } else {
	    	$("#mainForm").trigger("submit");
	    }
	}

	$("#mainForm").submit(function(e){
		e.preventDefault();

		if($("#submitBtn").text() == "Submit") {
			$.ajax({
	            url: $("#mainForm").attr("action"),
	            type: $("#mainForm").attr("method"),
	            data: new FormData(this),
	            processData: false,
	            contentType: false,
	            cache: false,
	            beforeSend:function(xhr){
	                xhr.setRequestHeader("csrf-token", $("input[name=_csrf]").val());
	                $("#submitBtn").html("submitting");
	                fill_text("#nextBtn",'<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>');
	            },
	            success:function(response){
	                if(response.success) {
	                	show_toast(response.message,"Success!");
	                    setTimeout(function(){
	                        window.location.href = response.url;
	                    },3000);
	                } else {
	                	show_toast(response.message,"Oops!");
	                	$("#submitBtn").html("Submit");
	                	fill_text("#nextBtn","Next",1);
	                }
	            },
	            error: function(xhr, status, error) {
	                $("#mainForm button[type=submit]").html("SUBMIT").attr("disabled",false);
	                if (xhr.status === 400) {
	                    const res = xhr.responseJSON;
	                    show_toast(res.message,"Oops!");
	                } else {
	                    show_toast("Something went wrong","Oops!");
	                }
	            }
	        });
		}
	});
}
function previous_step(backUrl)
{
	if($('.step-1').is(':visible')) {
		window.location.href = backUrl;
	} else if($('.step-2').is(':visible')) {
		$('.step-1').show();
	    $('.step-2').hide();
	} else if($('.step-3').is(':visible')) {
		$('.step-2').show();
	    $('.step-3').hide();
	}
}
function fill_text(selector,html,isComplete = 0)
{
	if(isComplete == 0) {
		$(selector).html(html).attr("disabled",true);
	} else {
		$(selector).html(html).attr("disabled",false);
	}
}
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}
function show_toast(msg,title)
{
	$.toast({
	    text: msg,
	    heading: title,
	    showHideTransition: 'slide'
	})
}