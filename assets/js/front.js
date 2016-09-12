(function($, Chosen) {
	$(document).ready(function() {
		var selected = jb_global.selected_local;
		selected = '"'+selected+'"';
		$(".is_location").chosen({width: "95%",});
		$(".is_cat").chosen({width: "95%",});
		new JB.Hearth();
	});
	JB.Hearth = Backbone.View.extend({
	  	el: 'body',
	  	initialize: function() {
	  	},
	  	events : {
			'click .btn-sign-up' : 'show_sign_up_forum',
			'click .btn-signin'  : 'show_modal_login',
			'click .btn-sign-out': 'doLogOut',
	  	},
	  	show_sign_up_forum : function(e){
	  		//$("#signupbox").show();
	  	},
	  	show_modal_login : function (e){
	  		e.preventDefault();
	  		console.log('init click event');
	  		new JB.Modal.login();
	  		return false;
	  	},
	  	render: function() {

	  	},
	  	doLogOut : function (e){

	  		e.preventDefault();
	  		var $params = {
		        emulateJSON: true,
		        url : jb_global.ajax_url,
		        data: {
		                action: 'jb_signout',
		        },
		        beforeSend  : function(event){
		        	console.log('bat dau');
		        },
		        success : function(res){
		        	console.log(res);
		        	if ( res.success ){
			        	if( res.redirect_url ){
			        		window.location.href = res.redirect_url;
			        	} else {
			        		window.location.reload(true);
			        	}
			        } else {
			        	console.log(' login loi');
			        }
		        }

	        };
	    	return Backbone.sync( 'create', this, $params );
	  	}
	});

	JB.Modal.login = Backbone.View.extend({
		el: '.modal-login',
	  	initialize: function() {
	  		_.bindAll(this, 'checkLogin');
	  		$(this.el).modal('show');
	  		console.log('show modal');
	  		//this.listenTo( this.model, 'change', this.render );
	  	},
	  	events : {
			'submit form.form-login' : 'checkLogin',
	  	},
	  	checkLogin : function (event) {
	  		event.preventDefault();
	  		var form 	= $(event.currentTarget);
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
		        	console.log('bat dau');
		        },
		        success : function(res){
		        	if ( res.success ){
			        	if( res.redirect_url ){
			        		window.location.href = res.redirect_url;
			        	} else {
			        		window.location.reload(true);
			        	}
			        } else {
			        	console.log('Can not logout');
			        }
		        }
	        };
	    	//return $.post(this.url, $params, null);
	    	return Backbone.sync( 'create', this, $params );
	  	},
	  	render: function() {

	  	}
	});

})(jQuery)