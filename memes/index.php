<?php
    // Check for the _GET variable 'm' and set the memeID according to it else set it to null
    $memeID = $_GET['m'] ?? null;

    // Check via preg_match (regular expression matching) if the provided id is valid
    if (!preg_match('/([0-9]{5})/', $memeID)) {
        header('Location: /index.php?error=invalid');
        die();
    }

    // Set the directory thats getting scanned
    $glob = glob('./memes/*');
    // Create an 2D array in which the ID, the path, and the extension is getting saved
    $memeArray = array(
        'ID'=>array(),
        'path'=>array(),
        'extension'=>array()
    );

    // Scan the above directory set above
    foreach($glob as $file) {
        if(preg_match('/([0-9]{5})-/', $file)) {
            // get the ID, path, and extension
            $ID = substr($file, strrpos($file, '/') + 1, 5);
            $path = $file;
            $extension = substr($file, strrpos($file, '.') + 1);

            // push the information into the array
            array_push($memeArray['ID'], $ID);
            array_push($memeArray['path'], $path);
            array_push($memeArray['extension'], $extension);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>j3st3rs memes - Meme: <?php echo($memeArray['ID'][ltrim($memeID, '0') - 1]); ?></title>
    <link rel="stylesheet" href="./css/index.css">
    <?php
        $mime = mime_content_type($memeArray['path'][ltrim($memeID, '0') - 1]);
        switch (substr($mime, 0, strpos($mime, '/'))) {
            case 'video':
                echo '
                <meta property="og:title" content="memes.j3st3r.xyz">
                <meta property="og:description" content="For more funny memes visit meme.j3st3r.xyz">
                <meta property="og:type" content="video">
                <meta property="og:video" content="https://meme.j3st3r.xyz/memes' . ltrim($memeArray['path'][ltrim($memeID, '0') - 1], '.') . '">
                ';
                break;
            case 'image':
                echo '
		        <meta property="twitter:card" content="summary_large_image">
                <meta property="twitter:title" content="memes.j3st3r.xyz">
                <meta property="twitter:image" content="https://meme.j3st3r.xyz/memes' . ltrim($memeArray['path'][ltrim($memeID, '0') - 1], '.') . '">
                ';
                break;
        }
    ?>
</head>
<body>
    <script src='https://unpkg.com/trianglify@^4/dist/trianglify.bundle.js'></script>
    <script>
    const pattern = trianglify({
        width: window.innerWidth,
        height: window.innerHeight,
        xColors: ['#E6E6E9', '#9999A1', '#66666E', '#000000'],
        yColors: ['#E6E6E9', '#9999A1', '#66666E', '#000000'],
        seed: window.location.href.substring(window.location.href.length - 5)
    })
    document.body.appendChild(pattern.toCanvas())
    </script>
    <script>
        let currentId = window.location.href.substring(window.location.href.length - 5);
        function next() {
            if (currentId == <?php echo('"' . max($memeArray['ID']) . '"') ?>) {
                var newId = currentId;
            }else{
                var newId = Number(currentId) + 1;
            }
            window.location.href = "/memes/?m=" + String(newId).padStart(5, '0');
        }

        function previous() {
            if (currentId == <?php echo('"' . min($memeArray['ID']) . '"') ?>) {
                var newId = currentId;
            }else{
                var newId = Number(currentId) - 1;
            }
            window.location.href = "/memes/?m=" + String(newId).padStart(5, '0');
        }

        function random() {
            let min = <?php echo(ltrim(min($memeArray['ID']), '0')) ?>;
            let max = <?php echo(ltrim(max($memeArray['ID']), '0')) ?>;
            var randomElement = Math.floor(Math.random() * (max - min + 1) + min);
            if (randomElement != currentId) {
                window.location.href = "/memes/?m=" + String(randomElement).padStart(5, '0');
            }else{
                random();
            }
        }

        document.body.addEventListener('keypress', function(event) {
            const key = event.keyCode;
            switch (key) {
                case 65: // "A"
                    previous();
                    break;
                case 68: // "D"
                    next();
                    break;
                case 32: // " "
                    random();
                    break;
            }
        });

        var zoomed = false;
        function zoom() {
            if (zoomed) {
                // raus zoomen                
                document.getElementById('image').style.maxHeight = '90vh'
                document.getElementsByClassName('img-wrapper')[0].style.overflowY = ''
                zoomed = false;
            }else{
                // rein zoomen
                document.getElementById('image').style.maxHeight = '100%'
                document.getElementsByClassName('img-wrapper')[0].style.overflowY = 'scroll'
                document.getElementsByClassName('img-wrapper')[0].style.maxHeight = '90vh'
                document.getElementsByClassName('img-wrapper')[0].style.maxWidth = '90vw'
                zoomed = true;
            }
        }
    </script>
    <div class="wrapper">
        <div class="img-wrapper">
            <?php
                $mime = mime_content_type($memeArray['path'][ltrim($memeID, '0') - 1]);
                switch (substr($mime, 0, strpos($mime, '/'))) {
                    case 'video':
                        echo '<video src="' . $memeArray['path'][ltrim($memeID, '0') - 1] . '" alt="" id="image" controls loop>';
                        break;
                    case 'image':
                        echo '<img src="' . $memeArray['path'][ltrim($memeID, '0') - 1] . '" alt="" id="image" onclick="zoom()">';
                        break;
                }
            ?>
        </div>
        <div class="button-wrapper">
            <button class="random" id="random" onClick="random()" autofocus>
                random
            </button>
        </div>
    </div>
</body>
</html>