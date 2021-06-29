<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Core - Create user</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="m-12">
        <div class="w-1/3 mx-auto p-6 border rounded-md">
            <h2 class="text-xl"><?php e($user->username) ?></h2>
            <p class="text-gray-700 py-2"><?php e($user->email) ?></p>
        </div>
    </div>

</body>

</html>