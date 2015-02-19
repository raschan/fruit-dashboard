<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Testing page for Rashan</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Page Content -->
    <div class="container">
        <h1>Hello {{ $name }}</h1>
        <p>I saved {{ $count }} events.
        <br/>It took {{ date('i:s',$timeItTakes) }} to finish.
        <br/>You're welcome.</p>
    </div>
</body>
</html>
