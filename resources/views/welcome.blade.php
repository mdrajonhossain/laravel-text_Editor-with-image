<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title> 
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bangla:wght@400&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Noto Sans Bangla', sans-serif;
    }
</style>
    </head>    
    <body>
         <h1>Posts</h1>
    
@if($data)
    <h2>{{ $data->title }}</h2>
    <div>{!! $data->content !!}</div>
@else
    <p>No posts available.</p>
@endif

    </body>
</html>
