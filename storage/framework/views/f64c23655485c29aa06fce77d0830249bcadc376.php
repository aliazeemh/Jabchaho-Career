<div class="alert alert-danger"  id="img-error"   style="display:none"></div>
<div class="alert alert-success" id="img-success" style="display:none"></div>
<div id="timelineBackground">
    <?php if(!empty(Auth::guard('candidate')->user()->cover_image)): ?>
        <img src="<?php echo e(asset(config('constants.files.cover'))); ?>/<?php echo e(Auth::guard('candidate')->user()->cover_image); ?>" class="bgImage" style="margin-top: <?php echo e(Auth::guard('candidate')->user()->cover_image_position); ?>;">
    <?php else: ?>
        <img src="<?php echo e(asset('assets/uploads/cover/cover.jpg')); ?>" class="bgImage" style="margin-top: <?php echo e(Auth::guard('candidate')->user()->cover_image_position); ?>;">
    <?php endif; ?>                
</div>
<div id="timelineContainer" class="ff-gothambook">    
        
            <span id="coverImageHideButton">
                <div id="removeCoverImageDiv">
                    <?php if(!empty(Auth::guard('candidate')->user()->cover_image)): ?>
                        <a href="#_" class="cover-image-remove" title="Remove" id="cover-image-remove"></a>
                    <?php endif; ?>
                </div>
                <div id="dragCoverImageDiv">
                    <?php if(!empty(Auth::guard('candidate')->user()->cover_image)): ?>
                        <a href="#_" class="cover-image-drag" title="Drag" id="cover-image-drag"></a>
                    <?php endif; ?>    
                </div>
            </span>
      
		<div style="background:url(<?php echo e(asset('assets/images/timeline_shade.png')); ?>);" id="timelineShade">
			
   
            
		</div>
        <div class="mobile-center">
            <div id="timelineProfilePic" class='profileDiv'>
                <?php if(!empty(Auth::guard('candidate')->user()->profile_image)): ?>
                <img src="<?php echo e(asset(config('constants.files.profile'))); ?>/<?php echo e(Auth::guard('candidate')->user()->profile_image); ?>" class="center" >
                <?php else: ?>
                    <img src="<?php echo e(asset('assets/images/default/profile-large.jpg')); ?>"  class="center" >
                <?php endif; ?>

            </div>
            <div id="removeProfileImageDiv">
            <?php if(!empty(Auth::guard('candidate')->user()->profile_image)): ?>
                <a href="#_" class="profile-image-remove"  title="Remove" id="profile-image-remove"></a>
            <?php endif; ?>
            </div>
            <form id="profileImageForm" method="post" enctype="multipart/form-data" action="<?php echo e(route('profile.image.upload')); ?>">
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                    <div class="profile-upload">
                        <input type="file" name="profile_image" id="profile_image" class="custom-file-input" original-title="Change profile Picture">
                    </div>
            </form>
        </div>
        <div class="title-bar ff-gothambook">
            <div id="timelineTitle"><?php echo e(Auth::guard('candidate')->user()->full_name); ?></div>
            <div class="updateInfo timelineInfo">
                <a class="btn " href="<?php echo e(route('personal.details.show')); ?>" >Edit Profile</a>
            </div>
        </div>
	<div id="timelineNav">
            <ul >
    
                <li <?php if(Request::segment(1) == 'home'): ?> class="active" <?php endif; ?> >
                    
                    <a class="f-18px" href="<?php echo e(route('index')); ?>">Home</a>
                </li>
                <!--<li class="">
                    
                    <a class="" href="#">Alerts</a>
                </li>-->
                <li <?php if(Request::segment(1) == 'view-profile'): ?> class="active" <?php endif; ?> >
                    
                    <a class="f-18px" href="<?php echo e(route('view.profile')); ?>">Profile</a>
                </li>
                <!--<li class="<?php if(Request::segment(1) == 'tips-and-guides'): ?> active <?php endif; ?> hide" >
                    
                    <a class="f-18px" href="<?php echo e(route('tips-and-guides.index','')); ?>">Tips and Guides</a>
                </li>-->
                <li <?php if(Request::segment(1) == 'jobs'): ?> class="active" <?php endif; ?>>
                    
                    <a class="f-18px" href="<?php echo e(route('jobs.list')); ?>">Current Job Openings</a>
                </li>
                
            </ul>
    </div>

</div>






<script>
$(document).ready(function() {
    $('body').on('change', '#bgphotoimg', function() {
        $('#img-error').hide();
		$('#img-error').html('');
        $('#uX1').remove();
        $('#timelineBGload').remove();
        $(".bgImage").show();
        $("#timelineBGload").addClass("headerimage");
        $("#bgimageform").ajaxForm({
            target: '#timelineBackground',
            beforeSubmit: function() {},
            success: function() {
               //code goes here
            },
            error: function(){
                $('#img-error').show();
                $('#img-error').html('Unable to process request. Please refresh the page and try again!!');
                 
            }
        }).submit();
        
    });
    $("body").on('mouseover', '.headerimage', function() {
        var y1 = $('#timelineBackground').height();
        var y2 = $('.headerimage').height();
        $(this).draggable({
            scroll: false,
            axis: "y",
            drag: function(event, ui) {
                if (ui.position.top >= 0) {
                    ui.position.top = 0;
                } else if (ui.position.top <= y1 - y2) {
                    ui.position.top = y1 - y2;
                }
            },
            stop: function(event, ui) {}
        });
    });
    $("body").on('click', '.bgSave', function() {
        var id = $(this).attr("id");
        var p = $("#timelineBGload").attr("style");
        var Y = p.split("top:");
        var Z = Y[1].split(";");
        var dataString = 'position=' + Z[0];
        $.ajax({
            type: "POST",
            url: "<?php echo e(route('cover.image.position.update')); ?>", //'update cover image position
            data: dataString,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {},
            success: function(html) {
                if (html) {
                    $(".bgImage").fadeOut('slow');
                    $(".bgSave").fadeOut('slow');
                    $("#timelineShade").fadeIn("slow");
                    $("#timelineBGload").removeClass("headerimage");
                    $("#timelineBGload").css({
                        'margin-top': html
                    });
                    
                    $("#timelineShade").show();
                    $("#bgimageform").show();
                    $('#bgphotoimg').val('');
                    $('#removeCoverImageDiv').html('<a href="#_" class="cover-image-remove" title="Remove" id="cover-image-remove"></a>');
                    $('#dragCoverImageDiv').html('<a href="#_" class="cover-image-drag"  title="Drag" id="cover-image-drag"></a>');
                    return false;
                }
            },
            error: function(){
                $('#img-error').show();
                $('#img-error').html('Unable to process request. Please refresh the page and try again!!');
                 
            }
        });
        return false;
    });

    //Profile image from
    $('#profileImageForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $('#img-error').hide();
        $('#img-error').html('');
        $(".loader").addClass("show");
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                $(".loader").removeClass("show");
                if(data.errors){
                    jQuery.each(data.errors, function(key, value){
					$('#img-error').show();
					$('#img-error').append('<li>'+value+'</li>');
                    setTimeout(() => {
                        $('#img-error').hide(); 
                    }, 4000);
				});
                }else{
                    //$(".profileDiv").html(data);
                    $('.profileDiv img').attr('src', data);
                    $("#removeProfileImageDiv").html('<a href="#_" class="profile-image-remove"  id="profile-image-remove"></a>');
                }
                
            },
            error: function(data){
                $('#img-error').show();
                $('#img-error').html('Unable to process request. Please refresh the page and try again!!');
                 
            }
        });
    }));

    $("#profile_image").on("change", function() {
        $("#profileImageForm").submit();
    });

    //// remove profile image
    $("body").on('click', '#profile-image-remove', function() {
        var userselection = confirm("Do you wish to remove your Profile image permanently?");
        
        if (userselection == true){
            var url = "<?php echo e(route('profile.image.remove')); ?>";
            removeImage(url);
        }else{
            return false;
        }

    });  
    

    //// remove profile image
    $("body").on('click', '#cover-image-remove', function() {
        var userselection = confirm("Do you wish to remove your Cover image permanently?");
        
        if (userselection == true){
            var url = "<?php echo e(route('cover.image.remove')); ?>";
            removeImage(url);
        }else{
            return false;
        }

    });  
    

        
    //Remove Image
    function removeImage(url)
    {
        $(".loader").addClass("show");
        $.ajax({
            type:'POST',
            url: url,
            cache:false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data){
                $(".loader").removeClass("show");
                if(data.errors){
                    $('#img-error').show();
                    $('#img-error').html(data.errors);
                    setTimeout(() => {
                        $('#img-error').hide(); 
                    }, 4000);
                }else{
                    location.reload();
                }
                
            },
            error: function(data){
                    $('#img-error').show();
                    $('#img-error').html('Unable to process request. Please refresh the page and try again!!');
                    
            }
        });
    }

    $("body").on('click', '#cover-image-drag', function() {
            var imageUrl = $('#timelineBackground img').attr('src');
            var imageStyle = $('#timelineBackground img').attr('style');
            
            var style = '0px';
            var splitedStyle = imageStyle.split(':');
            if(splitedStyle)
            {
                style = splitedStyle[splitedStyle.length-1];
            }    

            if(imageUrl)
            {
                $('#bgimageform').hide();
                $('#removeCoverImageDiv').html('');
                $('#dragCoverImageDiv').html('');
                $('#timelineBackground').html('<div id="uX1" class="bgSave wallbutton blackButton">Save Cover</div><img  src="'+imageUrl+'" id="timelineBGload" class="headerimage ui-corner-all" style="top:'+style+'" />');
                
            }
    });


    

});
</script><?php /**PATH C:\wamp\www\career\resources\views/frontend/layouts/header.blade.php ENDPATH**/ ?>