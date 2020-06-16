<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>hmvc framework</title>
    <link rel="stylesheet" href="<?= assets('css/style.css') ?>">
</head>
<body>
<h2> {{flash('name','danger')}}</h2>
<div class="container">
    <div class="row">
        <div class="col">
            <ul>
                @foreach($users as $user)
                <li>{{$user->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col">
            {!! $users->render() !!}
        </div>
    </div>
    </div>
</div>
</body>
</html>
