Run tailwindcss
cd into the tailwindcss folder
> npx tailwindcss -i ./input.css -o ../app.css --watch

Faker
https://github.com/fzaninotto/Faker

##############################
##############################
##############################
Snippet for PHP
Ctrl+Shit+P
> PHP 
Insert the snippet

{
	// Place your snippets for php here. Each snippet is defined under a snippet name and has a prefix, body and 
	// description. The prefix is what is used to trigger the snippet and the body will be expanded and inserted. Possible variables are:
	// $1, $2 for tab stops, $0 for the final cursor position, and ${1:label}, ${2:another} for placeholders. Placeholders with the 
	// same ids are connected.
	// Example:

	"API for PHP": {
		"prefix": "_api",
		"body": [
      "header('Content-Type: application/json');"
			"require_once __DIR__.'/../_.php';"
			"try{"
      ""
      "\t$1"
      ""
      "}catch(Exception $$e){"
      "\t\t$$status_code = !ctype_digit($$e->getCode()) ? 500 : $$e->getCode();"
      "\t\t$$message = strlen($$e->getMessage()) == 0 ? 'error - '.$$e->getLine() : $e->getMessage();"
      "\t\thttp_response_code($$status_code);"
      "\t\techo json_encode(['info'=>$$message]);"
      "}"
		],
		"description": "Create a basic API that supports exceptions"
	}

}
##############################
##############################
##############################










