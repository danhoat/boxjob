(function($, Chosen) {
	JB.auth =  Backbone.View.extend({
	  	el: '.page-auth',
	  	events : {
			'submit .frm-jobseekr-signup' : 'submitJobseekerSignup',
	  	},
	  	submitJobseekerSignup: function(event){
	  		// console.log('register submit');
	  		event.preventDefault();
	  		var form 	= $(event.currentTarget),
                $button = form.find(".btn-submit"),
                view 	= this;
            var data = {};
            form.find('input:text,input:hidden,input:radio,select').each(function() {
                    data[$(this).attr('name')] = $(this).val();
            });
            form.find('input:checked').each(function(key, element) {
            	var tem = $(this).attr('name');
            	if( typeof data[tem] == 'undefined'){
            		data[tem] = [];
            	}
            	data[tem].push($(this).val());
            });
            data['action'] = 'bx_signup';
            $.ajax({
		        url : jb_global.ajax_url,
		        type 	: 'post',
				data: data,
				beforeSend  : function(event){
		        	console.log('bat dau');
		        },
		        success : function(res){
		        	if ( res.success){

			        	console.log(' thanh cong');
			        	window.location.href = res.redirect_url;
			        } else {
			        	console.log('fail');
			        	$("#show_warning").html(res.msg);
			        }
		        }
			});
	  		return false;

	  	},
	  	initialize: function() {
	  		console.log('register ok');
	  	}
	});
	$(document).ready(function() {
		new JB.auth();
	});
})(jQuery)