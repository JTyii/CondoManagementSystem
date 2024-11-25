<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BEEKINEE Loading</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('img/bg.jpg'); 
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Hide overflow until content is loaded */
        }
        .loading-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }
        .loading-video {
            display: block;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            margin-top: 3rem;
            border: none;
            outline: none;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            object-fit: cover;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="loading-container">
        <video id="logo-vid" class="loading-video" autoplay muted>
            <source src="vid/logovid.mp4" type="video/mp4">
        </video>
    </div>
    <script type="text/javascript">
        var video = document.getElementById('logo-vid');
        video.addEventListener('loadeddata', function() {
            var loadingContainer = document.querySelector('.loading-container');
            loadingContainer.style.opacity = 1;

            video.addEventListener('ended', function() {
                setTimeout(function() {
                    location.href = 'index.php';
                }, 1000);
            });
        });
    </script>
</body>
</html>
