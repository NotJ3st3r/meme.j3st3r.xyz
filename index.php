<?php
    $glob = glob('./memes/memes/*');
    $memeArray = array();
    foreach($glob as $file) {
        if(preg_match('/([0-9]{5})-/', $file)) {
            // Valid match
            $file = substr($file, 14, 5);
            array_push($memeArray, $file);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>J3st3rs meme collection</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="./konami.js"></script>
    
    <meta name="title" content="j3st3rs meme collection">
    <meta name="description" content="The ever-growing collection of various memes I collected over the time.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://meme.j3st3r.xyz/">
    <meta property="og:title" content="j3st3rs meme collection">
    <meta property="og:description" content="The ever-growing collection of various memes I collected over the time.">
    <meta property="og:image" content="https://meme.j3st3r.xyz/banner.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://meme.j3st3r.xyz/">
    <meta property="twitter:title" content="j3st3rs meme collection">
    <meta property="twitter:description" content="The ever-growing collection of various memes I collected over the time.">
    <meta property="twitter:image" content="https://meme.j3st3r.xyz/banner.jpg">

    <script>
        var memes = <?php echo json_encode($memeArray); ?>;

        function random() {
            let min = <?php echo(ltrim(min($memeArray), '0')) ?>;
            let max = <?php echo(ltrim(max($memeArray), '0')) ?>;
            let randomElement = Math.floor(Math.random() * (max - min + 1) + min);
            window.location.href = "/memes/?m=" + String(randomElement).padStart(5, '0');
        }
    </script>
</head>
<body>
    <!-- Background Pepe -->
    <div class="img-wrapper"> 
        <img src="./img/good memes man.png" alt="">
    </div>

    <h1 class="top-line">Welcome to <a href="https://j3st3r.xyz">j3st3rs</a></h1>
    <h1 class="bottom-line">meme collection</h1>
    <span>
    This is an ever-growing collection of various memes (in german and english) that I (or friends) have collected over time. <br>
    These memes do not necessarily reflect my opinion/attitude towards various topics or groups of people.
    It is your right to find the memes offensive, distasteful, or just bad. But I don't care. <br>
    If I would care about your opinion I would have added a comment section but I haven't.
    </span><br>
    <button onclick="random()" id="test" class="block">Go to the<br>memes</button>
</body>
</html>