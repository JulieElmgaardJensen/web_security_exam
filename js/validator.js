// ##############################
// callback - validate forventer at tage imod en anden funktion
function validate(callback) {
	const form = event.target
	const validate_error = "rgba(191, 64, 191, 1)"
	//fjerner alle tidligere styling på validerings
	form.querySelectorAll("[data-validate]").forEach(function (element) {
		element.classList.remove("validate_error")
		element.style.border = "none"
	})
	//find alle elementer i loopet der har attributen data-validate
	form.querySelectorAll("[data-validate]").forEach(function (element) {
		//switch case fir at vælge hvilken type validering baseret på data-attributen
		switch (element.getAttribute("data-validate")) {
			case "str":
				//valider string lenght
				if (element.value.length < parseInt(element.getAttribute("data-min")) ||
					element.value.length > parseInt(element.getAttribute("data-max"))
				) {
					element.classList.add("validate_error")
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "int":
				//valider integers
				if (! /^\d+$/.test(element.value) ||
					parseInt(element.value) < parseInt(element.getAttribute("data-min")) ||
					parseInt(element.value) > parseInt(element.getAttribute("data-max"))
				) {
					element.classList.add("validate_error")
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "email":
				//Validate emailformat
				let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if (!re.test(element.value.toLowerCase())) {
					element.classList.add("validate_error")
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "regex":
				//valider mod et regex
				var regex = new RegExp(element.getAttribute("data-regex"))
				if (!regex.test(element.value)) {
					console.log(element.value)
					console.log("regex error")
					element.classList.add("validate_error")
					element.style.border = `4px solid ${validate_error}`
				}
				break;
			case "match":
				//valider om to input matcher
				if (element.value != form.querySelector(`[name='${element.getAttribute("data-match-name")}']`).value) {
					console.log('Password dosent match')
					element.classList.add("validate_error")
					alert('Password dosent match')
					element.style.border = `4px solid ${validate_error}`
				}
				break;
		}
	})
	//Hvis der ikke er nogle fejl, udføres functionen der gemmes i callback validate(callback)
	if (!form.querySelector(".validate_error")) { callback(); return }
	//Hvis der er fejl, sæt fokus på første fejl
  form.querySelector(".validate_error").focus()

}
