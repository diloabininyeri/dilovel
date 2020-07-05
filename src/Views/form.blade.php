<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">

        </div>
    </div>
    <div class="row">
        <div class="col">
            <h2>{{csrf()->generateToken()}}</h2>
            <h2>{{lang('home.notfound','default value')}}</h2>
            <h2>{{lang('home.say')}}</h2>
            <img class="img-thumbnail" src="{{assets('images/2020_05_11_file5eb8a286a5e531.84547494.png')}}" alt="">
            @foreach ($errors as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
            <form action="{{router('test')}}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="form-group">
                    <input placeholder="captcha" class="form-control" name="_captcha" type="text">
                </div>
                <div class="form-group">
                    <input class="form-control-file" type="file" name="images[]" multiple>
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-info" type="submit" value="gonder">
                </div>

            </form>
        </div>
        <div class="col">
        </div>
        <div class="col">
            @php $a=12; @endphp
           <h2>{{$a}}</h2>
        </div>
    </div>
</div>


<script>

</script>
</body>
</html>