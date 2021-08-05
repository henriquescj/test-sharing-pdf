<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <title>PDF.js Example</title>
</head>
<body>
    <button id="share-button">
        Share aqui
    </button>

    <h1>Isso vai ser um PDF qualquer</h1>

    <canvas id="the-canvas"></canvas>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js" integrity="sha512-UqYzmySEh6DXh20njgxWoxDvuA4qqM8FmKWTkRvkYsg7LjzjscbMHj06zbt3oC6kP2Oa7Qow6v/lGLeMywbvQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var shareButton = document.getElementById('share-button');
        // shareButton.addEventListener('click', event => {
        //     if (navigator.share) {
        //         console.log('uhul can share');
        //         navigator.share({ title: "Example Page", url: "https://www.google.com/search?q=vacina+covid+perto+de+mim&oi=ddle&ct=194964869&hl=pt-BR&source=doodle-ntp&ved=0ahUKEwj2t_3knZjyAhWgqpUCHcSACqcQPQgB" });
        //     } else {
        //         console.log('ops cant share');
        //     }
        // });
        var baseUrl = "<?php
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $url = "https://";
            } else {
                $url = "http://";
            }
            // Append the host(domain name, ip) to the URL.
            $url.= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            // $url.= "/files/certificadoMEIHenrique.pdf";

            echo $url;
        ?>";
        console.log(baseUrl);
        // shareButton.onclick = async () => {
        //     if (navigator.canShare) {
        //         const response = await fetch(pdfUrl);
        //         const buffer = await response.arrayBuffer();

        //         const pdf = new File([buffer], "hello.pdf", { type: "application/pdf" });
        //         const files = [pdf];

        //         // Share PDF file if supported.
        //         if (navigator.canShare({ files })) await navigator.share({ files });
        //     }
        // };

        if ('canShare' in navigator) {
            const share = async function(shareimg, shareurl, sharetitle, sharetext) {
                try {
                    const response = await fetch(shareimg);
                    const blob = await response.blob();
                    const file = new File([blob], 'rick.jpg', {type: blob.type});

                    await navigator.share({
                        url: shareurl,
                        title: sharetitle,
                        text: sharetext,
                        files: [file]
                    });
                } catch (err) {
                    console.log(err.name, err.message);
                }
            };

            shareButton.addEventListener('click', () => {
                share(
                    baseUrl + "/files/foundation-light-excercise.pdf",
                    baseUrl,
                    'Teste pdf local',
                    'Um teste de pdf'
                );
            });  
        }

        var loadingTask = pdfjsLib.getDocument('files/foundation-light-excercise.pdf');
        loadingTask.promise.then(function(pdf) {
            pdf.getPage(1).then(function(page) {
                var scale = 1.5;
                var viewport = page.getViewport({ scale: scale, });

                var canvas = document.getElementById('the-canvas');
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                canvasContext: context,
                viewport: viewport
                };
                page.render(renderContext);
            });
        });
    </script>
</body>
</html>
