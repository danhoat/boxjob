(function($){
	JB.profile =  Backbone.View.extend({
		el: '.profile-container',
	  	events : {
			'click .btn-edit' : 'editSummary',
			'click .add-one-more-section' : 'editSummary',
			'click .btn-cancel': 'editSummary',
			'submit .frm-profile-edit': 'updateProfile',
	  	},
	  	initialize: function() {
	  		console.log('profile ok');
	  		$(".chosen-skill").chosen({
	  						width: "50%",
	  						enable_split_word_search : true,
	  						disable_search : false,
	  					});
	  	},
	  	editSummary: function(event){
	  		console.log('123');
	  		var $button  = $(event.currentTarget),
	  			$form 	 = $button.closest("form"),
	  			$static 	= $form.find(".view-control");
	  			$content = $form.find('.edit-field');
	  			console.log($form);
	  		//$static.toggleClass('hide');
	  		$content.slideToggle(600, function () {});
	  	},
	  	updateProfile : function(event){
	  		var form 	= $(event.currentTarget),
                $button = form.find(".btn-submit"),
                view 	= this;
            var data = {};
            form.find('input:text,input:hidden,input:radio,select,textarea').each(function() {
                    data[$(this).attr('name')] = $(this).val();
            });
            form.find('input:checked').each(function(key, element) {
            	var tem = $(this).attr('name');
            	if( typeof data[tem] == 'undefined'){
            		data[tem] = [];
            	}
            	data[tem].push($(this).val());
            });
            data['action'] = 'sync_profile';
            data['method'] = 'update';
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
			        } else {
			        	console.log('fail');
			        	$("#show_warning").html(res.msg);
			        }
		        }
			});
	  		return false;
	  		return false;
	  	}
	});
	$(document).ready(function() {
		new JB.profile();
	});
})(jQuery);