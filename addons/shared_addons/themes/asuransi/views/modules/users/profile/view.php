<div class="page-header">
	<h1><span>{{ user:display_name user_id= _user:id }}</span></h1>
</div>


<!-- Container for the user's profile -->

<div class="col-xs-3">
	<?php echo gravatar($_user->email, 200);?>
</div>

<!-- Details about the user, such as role and when the user was registered -->
<div class="col-xs-9">

	{{# we use _user:id as that is the id passed to this view. Different than the logged in user's user:id #}}
	{{ user:profile_fields user_id= _user:id }}
		{{#   viewing own profile?    are they an admin?        ok it's a regular user, we'll show the non-sensitive items #}}
		{{ if user:id === _user:id or user:group === 'admin' or slug != 'email' and slug != 'first_name' and slug != 'last_name' and slug != 'username' and value }}
			<div class="entry-detail-row">
				<div class="entry-detail-name">{{ name }}</div>
				<div class="entry-detail-value">{{ value }}</div>
			</div>
		{{ endif }}

	{{ /user:profile_fields }}

</div>
	


