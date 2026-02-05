<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #ffffff;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e0e0e0;
        }

        .user-name {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <!-- You can add your logo here -->
        </div>
        
        <div class="user-profile">
            <img src="https://via.placeholder.com/40" alt="User Profile" class="profile-image">
            <span class="user-name">John Doe</span>
        </div>
    </header>

    <main>
        <?=  $slot ?> 
    </main>
</body>
</html>