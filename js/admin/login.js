$(document).ready(function() {
	// Focus on email address field
	$('#email').select();

	// Initialize events
	$('#login_form').submit(function(e) {
		// Kill default behaviour
		e.preventDefault();
		doAjaxLogin();
	});

	$('#forgot_password_form').submit(function(e) {
		// Kill default behaviour
		e.preventDefault();
		doAjaxForgot();
	});

	$('.show-forgot-password').click(function(e) {
		// Kill default behaviour
		e.preventDefault();
		displayForgotPassword();
	});

	$('.show-login-form').click(function(e) {
		// Kill default behaviour
		e.preventDefault();
		displayLogin();
	});
});


function displayForgotPassword() {
	$('#error').addClass('hidden');
	$('#login_form').addClass('hidden');
	$("#forgot_password_form").removeClass('hidden');
}

function displayLogin() {
	$('#error').addClass('hidden');
	$('#login_form').removeClass('hidden');
	$("#forgot_password_form").addClass('hidden');
}

/**
 * Check user credentials
 *
 * @param string redirect name of the controller to redirect to after login (or null)
 */
function doAjaxLogin() {
	$('#error').addClass('hidden');
	$('#login_form .ajax-loader').removeClass("hidden");
	$.ajax({
		type: "POST",
		url: "public/ajax_aute.php",
		async: true,
		dataType: "json",
		data: {
			submitLogin: "1",
			passwd: $('#passwd').val(),
			email: $('#email').val()
		},
		success: function(jsonData) {
			if (jsonData.hasErrors) {
				displayErrors(jsonData.errors);
			} else {
				window.location.href = 'index.php';
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$('#error').html('<h3>TECHNICAL ERROR:</h3><p>Details: Error thrown: ' + XMLHttpRequest + '</p><p>Text status: ' + textStatus + '</p>').show();
			$('#login_form .ajax-loader').addClass('hidden');
		}
	});
}
function doAjaxForgot() {
	$('#error').addClass('hidden');
	$('#forgot_password_form .ajax-loader').fadeIn('slow', function() {
		$.ajax({
			type: "POST",
			url: "public/ajax-tab.php",
			async: true,
			dataType: "json",
			data: {
				ajax: "1",
				token: "",
				controller: "AdminLogin",
				submitForgot: "1",
				email_forgot: $('#email_forgot').val()
			},
			success: function(jsonData) {
				if (jsonData.hasErrors)
					displayErrors(jsonData.errors);
				else
				{
					alert(jsonData.confirm);
					$('#forgot_password_form .ajax-loader').hide();
					displayLogin();
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$('#error').html('<h3>TECHNICAL ERROR:</h3><p>Details: Error thrown: ' + XMLHttpRequest + '</p><p>Text status: ' + textStatus + '</p>').show();
				$('#forgot_password_form .ajax-loader').fadeOut('slow');
			}
		});
	});
}
function displayErrors(errors) {
	str_errors = '<b>有 ' + errors.length + ' 个错误！</b>';
	for (var error in errors) //IE6 bug fix
		if (error != 'indexOf') str_errors += '<p class="bg-danger">' + errors[error] + '</p>';
	$('#login_form .ajax-loader').addClass('hidden');
	$('#error').html(str_errors).removeClass("hidden");
}

