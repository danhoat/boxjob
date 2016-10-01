(function($){
	var JB = {};

	JB.post_job = Backbone.View.extend({

	  	el: '.post-job',

	  	initialize: function() {

			$('.payment-wizard li .wizard-heading').click(function(){
				if($(this).parent().hasClass('completed')){
					var this_li_ind = $(this).parent("li").index();
					var li_ind = $('.payment-wizard li.active').index();
					if(this_li_ind < li_ind){
						$('.payment-wizard li.active').addClass("jump-here");
					}
					$(this).parent().addClass('active').removeClass('completed');
					$(this).siblings('.wizard-content').slideDown();
				}
			});
			$(".chosen-multi").chosen({width: "95%"});
			/** update js */
			var view = this;

		        $(".plupload-upload-uic").each(function() {
		            var $this = $(this);
		            var id1 = $this.attr("id");
		            var imgId = 'img1';
		            view.plu_show_thumbs(imgId);
		            var pconfig = jb_global.pconfig;

		            pconfig["browse_button"] 	= "img1plupload-browse-button";
		            pconfig["container"] 		= imgId + jb_global.pconfig["container"];
		            pconfig["drop_element"] 	= imgId + jb_global.pconfig["drop_element"];
		            pconfig["file_data_name"] 	= imgId + jb_global.pconfig["file_data_name"];
		            pconfig["multipart_params"]["imgid"] = imgId;
		            pconfig["multipart_params"]["_ajax_nonce"] = $this.find(".ajaxnonceplu").attr("id").replace("ajaxnonceplu", "");

		            if ($this.hasClass("plupload-upload-uic-multiple")) {
		                pconfig["multi_selection"] = true;
		            }

		            var uploader = new plupload.Uploader(pconfig);

		            uploader.bind('Init', function(up) {
		            	console.log('init');
		            	// <i class="fa fa-spinner fa-spin"></i>

		            });

		            uploader.init();

		            // a file was added in the queue
		            uploader.bind('FilesAdded', function(up, files) {
		            	console.log('added 1');
		            	console.log();
		            	view.$el.find("i.loading").toggleClass("hide");

		                up.refresh();
		                up.start();
		            });

		            uploader.bind('UploadProgress', function(up, file) {
		            	console.log('progress');
		                // $('#' + file.id + " .fileprogress").width(file.percent + "%");
		                // $('#' + file.id + " span").html(plupload.formatSize(parseInt(file.size * file.percent / 100)));
		            });

		            // a file was uploaded
		            uploader.bind('FileUploaded', function(up, file, response) {
		            	response = $.parseJSON(response.response);
		            	view.$el.find("._thumbnail_id").val(response.file.id);
		            	view.$el.find(".filelist").html('<img src ="'+response.file.guid+'" />');
		            	view.$el.find(".btn-upload-process").addClass("disabled");
		            	view.$el.find("i.loading").toggleClass("hide");
		            });
		        });

			/** END upload */
	  	},
	  	events : {
			'click .btn-sign-up' 	: 'showSignUpForm',
			'submit form.form-login'  : 'submitLogin',
			//'click .heading-step' : 'toggleStepForm',
			'submit form.subit_job' : 'submitJob',
			'keyup input#full_address': 'geoLocation',
	  	},
	  	showSignUpForm : function(e){
	  		$("#signupbox").show();
	  	},
	  	render: function() {

	  	},
	  	plu_show_thumbs :function(imgId) {
		    var $ = jQuery;
		    var thumbsC = $("#" + imgId + "plupload-thumbs");
		    thumbsC.html("");
		    // get urls
		    var imagesS = $("#" + imgId).val();
		    var images = imagesS.split(",");
		    for (var i = 0; i < images.length; i++) {
		        if (images[i]) {
		            var thumb = $('<li class="thumb" id="thumb' + imgId + i + '"><img src="' + images[i] + '" alt="" /><div class="thumbi"><a id="thumbremovelink' + imgId + i + '" href="#">Remove</a></div></li>');
		            thumbsC.append(thumb);
		            thumb.find("a").click(function() {
		                var ki = $(this).attr("id").replace("thumbremovelink" + imgId, "");
		                ki = parseInt(ki);
		                var kimages = [];
		                imagesS = $("#" + imgId).val();
		                images = imagesS.split(",");
		                for (var j = 0; j < images.length; j++) {
		                    if (j != ki) {
		                        kimages[kimages.length] = images[j];
		                    }
		                }
		                $("#" + imgId).val(kimages.join());
		                this.plu_show_thumbs(imgId);
		                return false;
		            });
		        }
		    }
		    if (images.length > 1) {
		        thumbsC.sortable({
		            update: function(event, ui) {
		                var kimages = [];
		                thumbsC.find("img").each(function() {
		                    kimages[kimages.length] = $(this).attr("src");
		                    $("#" + imgId).val(kimages.join());
		                    this.plu_show_thumbs(imgId);
		                });
		            }
		        });
		        thumbsC.disableSelection();
		    }
		},
	  	submitLogin : function(e){
	  		e.preventDefault();
	  		console.log('submit login form');
	  		var _this 	= this;
	  		var form 	= $(e.currentTarget);
	  		var send   	= {};
            form.find( 'input' ).each( function() {
            	var key 	= $(this).attr('name');
                send[key] 	= $(this).val();
            });


	  		var $params = {
		        emulateJSON: true,
		        url : jb_global.ajax_url,
		        data: {
		                action: 'jb_signin',
		                request: send,
		        },
		        beforeSend  : function(event){
		        	console.log('bat dau login');
		        },
		        success : function(res){
		        	if ( res.success ){
		        		window.location.reload(true);
		        		//_this.nextStep(form);
			        	if( res.redirect_url ){
			        		//window.location.href = res.redirect_url;
			        	} else {
			        		//window.location.reload(true);
			        	}
			        } else {
			        	console.log('Can not login');
			        }
		        }
	        };
	        Backbone.sync( 'create', this, $params );
	  		return false;
	  	},

	  	submitJob : function (e) {
	  		var _this 	= this;
	  		var form 	= $(e.currentTarget);
	  		var data   	= {};
	  		var select = {};


            form.find('input:text,input:hidden,input:radio,select.meta-field,textarea').each(function() {
            	var key 	= $(this).attr('name');
                data[key] 	= $(this).val();
            });

            form.find('input:checked').each(function(key, element) {
            	var tem = $(this).attr('name');
            	if( typeof data[tem] == 'undefined'){
            		data[tem] = [];
            	}
            	data[tem].push($(this).val());
            });

            form.find( 'select.tax-field' ).each( function() {
            	var key 	= $(this).attr('name');
                select[key] 	= $(this).val();
            });
            data['tax_input'] = select;

	  		var $params = {
		        emulateJSON: true,
		        url : jb_global.ajax_url,
		        data: {
		                action: 'syn_post_job',
		                request: data,
		                method : 'insert',
		        },
		        beforeSend  : function(event){
		        	console.log('bat dau submit job');
		        },
		        success : function(res){
		        	if ( res.success ){
		        		if(jb_global.is_free_submit_job){
		        			window.location.href = res.data.guid;
		        			exit();
		        		} else {
			        		$("input#custom_field").val(res.data.ID);
			        		console.log('time wait');
			        		_this.nextStep(form);
				        	if( res.redirect_url ){
				        		//window.location.href = res.redirect_url;
				        	} else {
				        		//window.location.reload(true);
				        	}
				        }
			        } else {
			        	console.log('Can not logout');
			        }
		        }
	        };
	        Backbone.sync( 'create', this, $params );
	  		return false;
	  	},

	  	nextStep : function(e){

	  		var element 	= e;
	  		console.log(element);
	  		console.log('Next step');
	  		var current = $("ul.list-steps").find("li.active");
	  		current.removeClass("active").addClass("completed");
			current.find(".wizard-content").slideUp();
			current.next("li:not('.completed')").addClass('active').children('.wizard-content').slideDown();
	  	},

	  	geoLocation : function (e){
	  		var address 	= e.currentTarget.value;
	  		var geocoder 	= new google.maps.Geocoder();
	  		console.log('event keyup');
			geocoder.geocode( { 'address': address}, function(results, status) {

			  	if (status == google.maps.GeocoderStatus.OK) {
			    	var lat = results[0].geometry.location.lat();
			    	var long = results[0].geometry.location.lng();
			    	console.log(lat);
			    	$("#jb_lat").val(lat);
			    	$("#jb_lng").val(long);
			  	}
			});
	  	},
	  	toggleStepForm : function(e){
	  		e.preventDefault();
	  		var form 	= $(e.currentTarget);
	  		console.log(form);
	  		form.toggleClass('active');
	  		form.toggleClass('completed');
	  	}

	});

	new JB.post_job();
})(jQuery);