@extends('include.header')
@section('content')
<div class="page-header">
    <div class="page-title">
        <h4>General Settings</h4>
        <h6>(<span class='mandadory'>*</span>) indicates required field.</h6>
    </div>
</div>
<form action="{{ route('admin.submit.general-settings') }}" method="POST" enctype="multipart/form-data" id="mainForm">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>General Settings</h4>
                </div>
                <div class="card-body profile-body">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">App. Name<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="app_name" id="app_name" value="{{ isset($app_name) ? $app_name : '' }}" autofocus />
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">App. Email<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="app_email" id="app_email" value="{{ isset($app_email) ? $app_email : '' }}" autofocus />
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">App. Phone<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="app_phone" id="app_phone" value="{{ isset($app_phone) ? $app_phone : '' }}" autofocus />
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">App. Theme Color<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" name="app_theme_color" id="app_theme_color" value="{{ isset($app_theme_color) ? $app_theme_color : '' }}" autofocus />
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" id="backBtn">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
	var page_title = "General Settings";
    $(document).ready(function(){
        $("#mainForm").submit(function(e){
            e.preventDefault();

            if($("#mainForm").valid()) {
                $.ajax({
                    url: $("#mainForm").attr("action"),
                    type: $("#mainForm").attr("method"),
                    data: $(this).serialize(),
                    beforeSend:function(xhr){
                        xhr.setRequestHeader("csrf-token", $("input[name=_csrf]").val());
                        $("#mainForm button[type=submit]").html('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>').attr("disabled",true);
                    },
                    success:function(response){
                        if(response.success) {
                            setTimeout(function(){
                                window.location.href = $("#backBtn").attr("href");
                            },3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#mainForm button[type=submit]").html("SUBMIT").attr("disabled",false);
                        if (xhr.status === 400) {
                            const res = xhr.responseJSON;
                            show_toast("Oops!",res.message,"error");
                        } else {
                            show_toast("Oops!","Something went wrong","error");
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
