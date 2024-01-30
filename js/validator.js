
// ##############################
function validate(callback) {
	const form = event.target
	// const validate_error = "rgba(240, 130, 240, 0.2)"
	const validate_error = "rgba(191, 64, 191, 1)"
	form.querySelectorAll("[data-validate]").forEach(function (element) {
		element.classList.remove("validate_error")
		// element.style.backgroundColor = "rgba(60, 80, 100, 1)"
		// element.style.backgroundColor = "white"
		element.style.border = "none"
	})
	form.querySelectorAll("[data-validate]").forEach(function (element) {
		switch (element.getAttribute("data-validate")) {
			case "str":
				if (element.value.length < parseInt(element.getAttribute("data-min")) ||
					element.value.length > parseInt(element.getAttribute("data-max"))
				) {
					element.classList.add("validate_error")
					// element.style.backgroundColor = validate_error
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "int":
				if (! /^\d+$/.test(element.value) ||
					parseInt(element.value) < parseInt(element.getAttribute("data-min")) ||
					parseInt(element.value) > parseInt(element.getAttribute("data-max"))
				) {
					element.classList.add("validate_error")
					// element.style.backgroundColor = validate_error
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "email":
				let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if (!re.test(element.value.toLowerCase())) {
					element.classList.add("validate_error")
					// element.style.backgroundColor = validate_error
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "regex":
				var regex = new RegExp(element.getAttribute("data-regex"))
				// var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
				if (!regex.test(element.value)) {
					console.log(element.value)
					console.log("regex error")
					element.classList.add("validate_error")
					// element.style.backgroundColor = validate_error
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "match":
				if (element.value != form.querySelector(`[name='${element.getAttribute("data-match-name")}']`).value) {
					console.log('Password dosent match')
					element.classList.add("validate_error")
					// element.style.backgroundColor = validate_error
					element.style.border = `4px solid ${validate_error}`
				}
				break;
		}
	})
	if (!form.querySelector(".validate_error")) { callback(); return }
	
  form.querySelector(".validate_error").focus()

}

// ##############################
function clear_validate_error() {
	// event.target.classList.remove("validate_error")
	// event.target.value = ""
}