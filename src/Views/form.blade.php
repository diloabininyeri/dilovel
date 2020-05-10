<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
grger
@foreach ($errors as $error)
    <h2>{{$error}}</h2>
@endforeach
<form action="{{router('form.post')}}" enctype="multipart/form-data" method="post">
    <input type="file" name="file">
    <input type="submit" value="gonder">
</form>
</body>
</html>