$(document).ready(function() {
	$('.nav-trigger').click(function() {
            $('.top-nav').toggleClass('visible');
	});
//========================================================//        
        $('.hide-btn').on('click', function(){
            var hide_id = $(this).data('id');
            $clicked_btn = $(this);
            if($clicked_btn.hasClass('fa-eye')){
                action1 = 'hidepost';
            } else if($clicked_btn.hasClass('fa-eye-slash')){
                action1 = 'showpost';
            }
            $.ajax({
                url: 'ideas_list.php',
                type: 'post',
                data: {
                    'action1': action1,
                    'hide_id': hide_id
                },
  	success: function(data){
//  		res = JSON.parse(data);
  		if (action1 == "hidepost") {
  			$clicked_btn.removeClass('fa-eye');
  			$clicked_btn.addClass('fa-eye-slash');
//                        document.getElementById('hide_text' + hide_id).innerHTML = 'Show this post';
  		} else if(action1 == "showpost") {
  			$clicked_btn.removeClass('fa-eye-slash');
  			$clicked_btn.addClass('fa-eye');
//                        document.getElementById('hide_text' + hide_id).innerHTML = 'Hide this post';
  		}
            } 
        });
    });
    $('.block-btn').on('click', function(){
            var block_id = $(this).data('id');
            $clicked_btn = $(this);
            if($clicked_btn.hasClass('fa-universal-access')){
                action2 = 'user_is_blocked';
            } else if($clicked_btn.hasClass('fa-ban')){
                action2 = 'user_have_access';
            }
            $.ajax({
                url: 'ideas_list.php',
                type: 'post',
                data: {
                    'action2': action2,
                    'block_id': block_id
                },
  	success: function(data){
////  		res = JSON.parse(data);
  		if (action2 == "user_is_blocked") {
  			$clicked_btn.removeClass('fa-universal-access');
  			$clicked_btn.addClass('fa-ban');
//                        document.getElementById('hide_text' + hide_id).innerHTML = 'Show this post';
  		} else if(action2 == "user_have_access") {
  			$clicked_btn.removeClass('fa-ban');
  			$clicked_btn.addClass('fa-universal-access');
//                        document.getElementById('hide_text' + hide_id).innerHTML = 'Hide this post';
  		}
            } 
        });
    });
});
