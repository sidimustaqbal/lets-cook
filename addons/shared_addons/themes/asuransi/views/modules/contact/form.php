{{ contact:form
	name = "text|required"
	email = "text|required|valid_email"
	subject = "dropdown|required|hello=Say Hello|support=Support Request|Something Else"
	message = "textarea|required"
	attachment = "file|jpg|png|zip"
	max_size = "10000"
	reply-to = "visitor@somewhere.com" * Read note below *
	button = "send"
	template = "contact"
	lang = "en"
	to = "contact@site.name"
	from = "server@site.name"
	sent = "Your message has been sent. Thank you for contacting us"
	error = "Sorry. Your message could not be sent. Please call us at 123-456-7890"
	success-redirect = "contact"
}}
	{{ name }}
	{{ email }}
	{{ subject }}
	{{ message }}
	{{ attachment }}
{{ /contact:form }}