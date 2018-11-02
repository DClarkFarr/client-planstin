<!DOCTYPE html>
<html lang="{{\App::getLocale()}}" class="no-js">
<head prefix="{{\App\Utils\SocialMarkup::makeRegisteredPrefixes()}}">

    @include('includes.head')

</head>
<body>
@include('includes.header')
	<div id="content">
	        @yield('content')
	</div>
        @include('includes.footer-login')


    <pre class="hidden session-token">
        <?php echo 'level = ' . session('user.level') . "\n"; ?>
        <?php $token = session('token'); print_r($token ? $token->toArray() : 'no token'); ?>
        <?php print_r(session('salesforce.resources')); ?>
	</pre>
</body>
</html>

