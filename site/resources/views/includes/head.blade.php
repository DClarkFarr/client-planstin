<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
{{--<title>{{\App\Utils\SocialMarkup::$registered_tags['title'][0]}}</title>--}}
<?php if(!empty(\App\Utils\SocialMarkup::$registered_tags['description'])){ ?>
	<meta name="description" content="{{\App\Utils\SocialMarkup::$registered_tags['description'][0]}}">
<?php } ?>
<?php echo \App\Utils\SocialMarkup::makeRegisteredTags(); ?>
<link rel='alternate' href='{{url()->current()}}' hreflang="{{\Config::get('app.hreflang')}}">
<link rel="canonical" href="{{ url()->current() }}"/>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Style -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/bootstrap-patch.css">

<link rel="stylesheet" href="/css/animate.css">
<link rel="stylesheet" href="/css/style.css">

<!-- Scripts --> 
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery-extension.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/popper.min.js"></script>
<script type="text/javascript" src="/js/script.js"></script>
