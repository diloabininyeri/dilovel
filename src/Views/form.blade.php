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
        <div class="col p-15">

            @foreach ($errors as $error)
                <div class="alert alert-danger">{{($error)}}</div>
            @endforeach
            <form action="{{route('reg')}}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="form-group">
                    <input placeholder="captcha" class="form-control" name="_captcha" type="text">
                </div>

                <div class="form-group">
                    <input type="text" name="isim" value="{{old('isim')}}">
                </div>

                <div class="form-group">
                    <input type="file" name="image">
                </div>
                <div class="form-group">
                    <input class="form-control-file" type="file" name="images" multiple>
                </div>
                <div class="form-group">
                    <input class="form-control btn btn-info" type="submit" value="gonder">
                </div>

            </form>
        </div>
        <div class="col">
        </div>
        <div class="col">

        </div>
    </div>
</div>


<script>

</script>
</body>
</html>