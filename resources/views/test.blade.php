<body class="antialiased">

    @foreach($users as $user)
        <p>
            {{$user->name}}
        </p>
    @endforeach
</body>