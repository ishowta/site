//http://codepen.io/clintioo/pen/FKymj

// Custom validation messages
// Set msg on 'data-validation-msg' input attribute
// -------------------------------------------------
$(function () {
	var inputs = document.getElementsByTagName('input'),
			inputsLen = inputs.length,
			input,
			inputMsg,
			inputValidationMsg,
			label,
			button = document.getElementsByTagName('button')[0],
			form = document.getElementsByTagName('form')[0],
			input_type = document.getElementById('type'),
			register_button = document.getElementById('signup_button');

	// Let's hide the default validation msg as
	// -webkit-validation-bubble no longer works in Chrome 28+. Booooooo!
	form.addEventListener('invalid', function (e) {
		if(input_type.value == 'signup'){
			e.preventDefault();
		}
	}, true);

	// Validate form on submit - display tooltip if input has no value
	//button.onclick = function () {
		//form.submit();
	//}

	function hashed(name){
		// input
		var raw_password = $('#login_form [name="pre_'+name+'"]').val();
		// convert
		var sha256 = new jsSHA('SHA-256','TEXT');
		sha256.update(raw_password);
		var password = sha256.getHash('HEX');
		// output
		$('#login_form [name="'+name+'"]').val(password);
		$('#login_form [name="pre_'+name+'"]').val('');
	}

	$('#login_form').submit(function () {
		if(input_type.value == 'signin'){
			/*Sign in*/
			// サーバーに送る前にもハッシュ化
			hashed('password');
		}else{
			/*Sing up*/
			// サーバーに送る前にもハッシュ化
			hashed('password');
			hashed('repassword');
		}
		$('#login_form [name="referer"]').val(window.location.href);
	})

	while (inputsLen--) {
		input = inputs[inputsLen];
		label = next(input);

		if (input.hasAttribute('data-validation-msg')) {
			// Create span element for our validation msg
			inputValidationMsg = input.getAttribute('data-validation-msg');
			inputMsg = document.createElement('span');
			inputMsg.innerHTML = inputValidationMsg;

			// Add our own validation msg element so we can style it
			label.parentNode.insertBefore(inputMsg, label.nextSibling);

			input.onblur = function (e) {
				// If value does not exist or is invalid, toggle validation msg
				e.target.classList.add('blur');
				next(e.target).nextSibling.style.display = (!this.value || this.validity.valid === false) ? 'block' : 'none';
			}
		}
	}

	input_type.value = 'signin';
	document.getElementById('register').style.display = 'none';
	register_button.onclick = function(){
		input_type.value = 'signup';
		document.getElementById('register').style.display = 'block';
		register_button.style.display = 'none';
	}
});

// Credit to John Resig for this function taken from Pro JavaScript techniques
function next(elem) {
	do {
		elem = elem.nextSibling;
	}
	while (elem && elem.nodeType !== 1);
	return elem;
}
