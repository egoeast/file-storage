<html>
<head></head>
<body >
<h1>Hi {{$user->name}}</h1>
<p>Here is your activation link :</p>
<p>
    <a href=" {{ url('/activation')}}/{{$user->activation_code }}">{{ url('/activation')}}/{{$user->activation_code }}</a>
</p>
</body>
</html>