<!DOCTYPE>
<html>
	<head>
		<title>{{ $title }}</title>
		<link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}"> 
		<link rel="stylesheet" href="{{ URL::asset('assets/css/material.css') }}"> 
		<link rel="stylesheet" href="{{ URL::asset('assets/css/material-wfont.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('assets/css/ripples.css') }}"> 
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/font-awesome.css') }}">
		@yield('extra-css')
	</head>

	<body>