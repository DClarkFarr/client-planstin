<!DOCTYPE html>
<html lang="{{\App::getLocale()}}" class="no-js">
<head prefix="{{\App\Utils\SocialMarkup::makeRegisteredPrefixes()}}">

	@include($includes->head)
	@yield('head')
	
</head>
<body class="body-main">
	@include($includes->header)
	<div id="container">	
		<div class="d-flex">
			<div class="sidebar bg-gray-2 align-self-stretch">
				@include($includes->sidebar)
			</div>
			<div class="content align-self-stretch">
				@yield('content')
			</div>
		</div>


		@include($includes->footer)	
	</div>
	<pre class="hidden session-token">
		<?php print_r(session('token')); ?>
        <?php print_r(session('salesforce.resources')); ?>
	</pre>
</body>
</html>

