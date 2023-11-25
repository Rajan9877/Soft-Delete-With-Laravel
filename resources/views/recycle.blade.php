<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Performing Soft Delete In Laravel</title>
    <style>
        .para a{
            text-decoration: none;
            color: red;
        }
        .permanent-delete{
            margin-left: 5px;
        }
        .message{
            position: absolute;
            background-color: red;
            color: white;
            padding: 15px;
            border-radius: 50px;
            right: 5px;
            top: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <p class="message"></p>
    <h3 class="text-center my-2">Restore Users</h3>
    <p class="para text-center"><a href="/">Home</a></p>
    <table class="table container">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td><button type="button" data-datac="{{$user->id}}" class="restore btn btn-success btn-sm">Restore User</button><button type="button" data-datac="{{$user->id}}" class="permanent-delete btn btn-danger btn-sm">Permanent Delete User</button></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        $(document).on('click', '.restore', function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var id = $(this).attr("data-datac");

    $.ajax({
        type: "POST",
        url: "/restore-user",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            id: id
        },
        success: function(data) {
            $('.message').html(data.success);
            $('.message').fadeIn();
            setTimeout(() => {
                $('.message').fadeOut();
            }, 3000);
            fetchUsers();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

function fetchUsers() {
    $.ajax({
        type: "GET",
        url: "/tem-del-users",
        dataType: "json",
        success: function(data) {
            $('tbody').html('');
            for (var i = 0; i < data.users.length; i++) {
                $('tbody').append('<tr><td>' + data.users[i].name + '</td><td>' + data.users[i].email + '</td><td><button type="button" data-datac="' + data.users[i].id + '" class="restore btn btn-success btn-sm">Restore User</button><button type="button" data-datac="' + data.users[i].id + '" class="btn-danger btn-sm permanent-delete">Permanent Delete User</button></td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

$(document).on('click', '.permanent-delete', function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var id = $(this).attr("data-datac");

    $.ajax({
        type: "POST",
        url: "/permanent-delete-user",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {
            id: id
        },
        success: function(data) {
            $('.message').html(data.success);
            $('.message').fadeIn();
            setTimeout(() => {
                $('.message').fadeOut();
            }, 3000);
            fetchUsers();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

</script>
</body>
</html>