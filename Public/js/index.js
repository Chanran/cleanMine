$(function() {

	function checkLoginName(){
		var name = $("#loginName").val();
		$.ajax({
			type: "post",
			url: 'index.php/Home/Index/loginNameCheck',
			data: {
				name:name,
			},
			dataType: "json",
			success: function(result) {
				if (result.login_code === 1) {
					//alert(result.msg);
				} else if (result.login_code === 0) {
					alert(result.error_msg);
				}
			},
			error:function(){
				alert("服务器出错！");
			}
		});
	}

	function loginCheck(){
		var name = $("#loginName").val();
		var pwd    = $('#pwd').val();
		$.ajax({
			type: "post",
			url: 'index.php/Home/Index/loginCheck',
			data: {
				name:name,
				pwd:pwd,
			},		
			dataType: "json",
			success: function(result) {
				if (result.login_code === 1) {
					alert(result.msg);
					window.location.href = result.url;
				} else if (result.login_code === 0) {
					alert(result.error_msg);
				}	
			},
			error:function(){
				alert("服务器出错！");
			}
		});
	}

	function checkRegisterName(){
		var name = $("#registerName").val();
		$.ajax({
			type: "post",
			url: 'index.php/Home/Index/registerNameCheck',
			data: {
				name:name,
			},
			dataType: "json",
			success: function(result) {
				if (result.register_code === 1) {
					
				} else if (result.register_code === 0) {
					alert(result.error_msg);
				}
			},
			error:function(){
				alert("服务器出错！");
			}
		});
	}

	function registerCheck(){
		var name = $('#registerName').val();
		var pwd1 = $('#pwd1').val();
		var pwd2 = $('#pwd2').val();
		if (pwd1 != pwd2){
			alert("两次密码不相同");
		}else{
			$.ajax({
				type: "post",
				url: 'index.php/Home/Index/registerCheck',
				data: {
					name:name,
					pwd:pwd1,
				},
				dataType: "json",
				success: function(result) {
					if (result.register_code === 1) {
						alert(result.msg);
						window.location.href = result.url;
					} else if (result.register_code === 0) {
						alert(result.error_msg);
					}
				},
				error:function(){
					alert("服务器出错！");
				}
			});
		}
	}

	function isSamePwd(){
		var name = $('#registerName').val();
		var pwd1 = $('#pwd1').val();
		var pwd2 = $('#pwd2').val();
		if (pwd1 != pwd2){
			alert("两次密码不相同");
		}
	}

	$(document).on("blur","#loginName",checkLoginName);
	$(document).on("click","#login",loginCheck);
	$(document).on("blur","#registerName",checkRegisterName);
	$(document).on("blur","#pwd2",isSamePwd);
	$(document).on("click","#register",registerCheck);
	
})
