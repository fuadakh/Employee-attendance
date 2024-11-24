<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to Dashboard</h1>
    @php
        $user = Auth()->user();
        dd($user);
    @endphp
    <button id="logout">Logout</button>

    <script>
        // document.getElementById('logout').addEventListener('click', function() {
        //     localStorage.removeItem('authToken'); // Hapus token
        //     window.location.href = '/login'; // Redirect ke login
        // });
    </script>
</body>
</html>