<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/fonts/stylesheet.css">
    <link rel="stylesheet" href="/coming-soon/style.css">
    <title>Ведутся технические работы.</title>
</head>
<body>
    <div class="tech_works_container">
        <div class="logo_svg">
            <img src="/coming-soon/art.svg" class="artofall" data-wow-delay=".5s" alt="">
            <div class="agency_container">
                <img src="/coming-soon/ag.svg" class="agency" data-wow-delay=".5s" alt="">
                <span class="one">.</span><span class="two">.</span><span class="three">.</span>
            </div>
        </div>
        <div class="tech_description">
            <h1>Ведутся работы<br><span class="one">.</span><span class="two">.</span><span class="three">.</span></h1>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
        (function(w,d,u){
                var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn-ru.bitrix24.ru/b1610285/crm/site_button/loader_2_nootxt.js');
	</script>

    <script>
        $(document).ready(function () {
            var h = $(window).height(); // Высота экрана
            var w = $(window).width(); // Ширина экрана
            // $(".letters_1").html(h);
            // $(".letters_2").html(w);
            var w = window.innerWidth || document.documentElement.clientWidth;
            var h = window.innerHeight || document.documentElement.clientHeight;
            var x = document.getElementById("offer_outer");
            if (window.screen.width < 640) {
                $(".tech_works_container").css("height", h);
            }
        });
    </script>
</body>
</html>
