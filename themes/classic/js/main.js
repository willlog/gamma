//require('jquery.min.js');
$(function() {

	var app_id = '1150189221726761';
	var scopes = 'email, user_friends';
	var div_session = "<div id='facebook-session'>"+
					  "<strong></strong>"+			  
					  "</div>";
	
	window.fbAsyncInit = function() {

	  	FB.init({
	    	appId      : app_id,
	    	status     : true,
	    	cookie     : true, 
	    	xfbml      : true, 
	    	version    : 'v2.8'
	  	});


	  	FB.getLoginStatus(function(response) {
	    	statusChangeCallback(response, function() {});
	  	});
  	};

  	var statusChangeCallback = function(response, callback) {
  		console.log(response);
   		
    	if (response.status === 'connected') {
      		getFacebookData();
    	} else {
     		callback(false);
    	}
  	}

  	var checkLoginState = function(callback) {
    	FB.getLoginStatus(function(response) {
      		callback(response);
    	});
  	}

  	var getFacebookData =  function() {
  		FB.api('/me?fields=id,name,email, gender, first_name, last_name, link, permissions', function(response) {
	  		
	  		$.ajax({	  			
	                type: "POST",
	                data:{'provider':'facebook', 'uid':response.id, 'name':response.name, response, 'gender':response.gender, 'email':response.email,'firstname':response.first_name, 'lastname':response.last_name, 'profileUrl':response.link},
	                //url: "/redsocial/user/adduserfacebook",
	                url: "/gamma/site/loginfacebook",
	                
	                success: function(res, status) {
	                	
	                	if(res==='0')
	                	{		                		
	  						$('#prueba').addClass("alert alert-danger alert-dismissable");
	  						$('#prueba').html('Debe registrarse en SIGMA para acceder por facebook a GAMMA'); 			
		        				        			    
	        			}
	                	
	                	if(res==='1')
	                	{  		                		
 	 			
		        			$('#prueba').html('Su cuenta esta esperando activación por el administrador');
	  						$('#prueba').addClass('alert alert-danger alert-dismissable');		        				
		        				        			    
	        			}
	                	
	                	if(res==='2')
	                	{
	                		//Redireccionar la pagina 
		                	document.location.target = "_blank";
		        			document.location.href="/gamma/site/";		        			 							  			
		        					        			    
	        			}
	        				                	
	                	if(res==='3')
	                	{
		                	$('#prueba').html('Su cuenta ha sido cancelada por el administrador');
	  						$('#prueba').addClass('alert alert-danger alert-dismissable'); 				        			    
	        			}       			
	        			
	        			facebookLogout();         	
	                	
	                	//alert(res);
	                    
	                    
	                },
	                error: function (res, status) {
	                        alert(res);
	                },
	            });  		
	  	});	  	
  	}

  	var facebookLogin = function() {
  		checkLoginState(function(data) {
  			if (data.status !== 'connected') {
  				FB.login(function(response) {
  					if (response.status === 'connected')
  					{
  						getFacebookData();  						
  					}
  				}, {scope: scopes});
  			}
  		})
  	}

  	var facebookLogout = function() {
  		checkLoginState(function(data) {
  			if (data.status === 'connected') {
				FB.logout(function(response) {
					
				})
			}
  		})
  	}

  	$(document).on('click', '#login', function(e) {
  		e.preventDefault();

  		facebookLogin();
  	})

  	

})