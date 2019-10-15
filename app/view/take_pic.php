<?php
if (isset($_SESSION['username']))
    $results = get_lasts_images($_SESSION['username']);
else{
    header('Location: /index.php');
    exit();
}

?>

<div class="hero animate" onload="captureCam();">
    <div class="hero-body">
        <div style="padding-top: 0em;" class="container has-text-centered">
            <h1 id="title_top" >Take a pic !</h1>
        </div>
    </div>
</div>
<nav class="level animate">
    <div class="level-left">
            <div id="screenshot" class="montage" style="text-align:center;">
                <div id="video">
                    <video autoplay></video></br></br>
                    <div style="width: 100%;"class="select">
                        <select  id="photo-filter" style="width: 100%;">
                            <option value="" selected disabled hidden>Choose a filter</option>
                            <option value="none">No filter</option>
                            <option value="grayscale(100%">Grayscale</option>
                            <option value="sepia(100%)">Sepia</option>
                            <option value="invert(100%)">Invert</option>
                            <option value="hue-rotate(90deg)">Hue</option>
                            <option value="blur(10px)">Blur</option>
                            <option value="contrast(200%)">Contrast</option>
                        </select>
                    </div></br></br>
                    <button class="button is-success is-left" style="width: 100%;"id="screenshot-button">Take screenshot</button>
                    <!--<img id="img_pic" style="padding-bottom: 0.5em; border-radius: 20px;"src=""></br>-->
                    </br></br><canvas style="display:none" id="canvas"></canvas>
                    <div class="images">
                        <div id="1" class="filter filter1" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_1.jpg');"></div>
                        <div id="2" class="filter filter2" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_2.jpg');"></div>
                        <div id="3" class="filter filter3" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_3.jpg');"></div>
                        <div id="4" class="filter filter4" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_4.jpg');"></div>
                        <div id="5" class="filter filter5" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_5.jpg');"></div>
                        <div id="6" class="filter filter6" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_6.jpg');"></div></br>
                        <div id="7" class="filter filter7" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_7.jpg');"></div>
                        <div id="8" class="filter filter8" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_8.jpg');"></div>
                        <div id="9" class="filter filter9" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_9.jpg');"></div>
                        <div id="8" class="filter filter8" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/min_pingouin_8.jpg');"></div>
                        <div id="8" class="filter filter8" style="width: 150px; height: 150px; background-size:contain;background-image: url('/app/public/img/montage/min/flying-gold.png');"></div>

                    </div>
                    <div id="status"></div>
                    <button class="button is-success" style="width: 100%;"id="login_button submit-image">Submit image</button>
                </div>
            </div>
    </div>
    <div style="display:inline-block" class="level-right montage-right">
    <!-- Right side -->
            <div class="upload">
                    <p>Select image to upload:</p>
                    <input style="display: none" type="file" accept="image/jpeg, image/png, image/jpg" id="upload-file"/>
                    <button id="choose-button">Choose Image</button>
            </div>
        </br>
            <div id="js-container lasts_images">
                <h1 class="title">Lasts images</h1>
                <h1 style="font-size: 0.8em;"class="subtitle">After uploading your image, please reload the page if you want to delete one.</h1>
                </br>
                <div id="lasts_images"></br>
                    <?php
                    $i = 0;
                    foreach ($results as $value){
                        $img_filter = $value['img_filter'];
                        $img_link = $value['img_link'];
                        $img_id = $value['id'];
                        if($i == 2) {
                            echo "</div>";
                            $i = 0;
                        }
                        if ($i == 0) {
                            echo "<div class=\"columns\">";
                        }
                        echo "<div id=\"$img_id-img_id\" class=\"column\">
                                <figure class=\"image is-4by3 close\">
                                     <img style=\"filter:$img_filter\" src=\"$img_link\">
                                     <a id=\"$img_id\" class=\"button_close\"><i class=\"fas fa-minus-circle\"></i></a>
                                </figure></br>
                              </div>";
                        $i++;
                    }
                    ?>
                </div>
            </div>
    </div>
</nav>


<script src="/app/public/js/webcam.js"></script>