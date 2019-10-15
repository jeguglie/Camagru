<div class="is-wall">
    <div class="wall animate">
<?php
    $results = get_pictures_wall();
    $new_row = array();
    $i = 0;
    foreach ($results as $value) {
        if ($i == 3){
            $i = 0;
            break;
        }
        $img_id = $value['id'];
        $likes = $value['likes'];
        $filter = $value['img_filter'];
        $img_link = $value['img_link'];
        $img_username = $value['username'];
        $comments = count(getNbComment($value['id']));
        $new_row[0] = "";
        $new_row[1] = "";
        if ($i == 0)
            $new_row[0] = "<div class=\"row columns\">";
        if ($i + 1 == 3)
            $new_row[1] = "</div>";

        echo "
                $new_row[0]
                <div id=\"wall_column\" class=\"column is-one-third\">
                    <div id=\"vignette\" class=\"card large\">
                        <div class=\"card-image\">
                            <figure class=\"image\">
                                <img id=\"img_share-$img_id\" style=\"filter:$filter\" src=\"$img_link\" alt=\"Image\">
                            </figure>
                        </div>
                        <div class=\"card-content\">
                            <div class=\"media $img_id-c\">
                                <div class=\"media-content\">
                                    <p class=\"title is-4 no-padding\">$img_username</p>
                                </div>
                                <div class=\"wall_icons\">
                                    <span id=\"$img_id\" class=\"icon is-medium is-right is-like\">
                                        <i class=\"fas fa-thumbs-up\"></i>
                                            <span class=\"badge\">$likes</span>
                                    </span>
                                    <span id=\"$img_id-c\" class=\"icon is-medium is-right is-comment\">
                                        <i class=\"fas fa-comment\"></i>
                                            <span class=\"badge\">$comments</span>
                                    </span>
                                </div>
                            </div>
                                <div class=\"share-button\">
                                    <div class=\"fb-share-button-custom\" data-href=\"https://www.jeguglie.tk\" data-layout=\"button\" data-size=\"large\">
                                        <a id=\"share-wall-fb\" class=\"button is-small is-info s-$img_id share\" target=\"_blank\" href=\"https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.jeguglie.tk%2F&amp;src=sdkpreparse\">
                                            <span class=\"icon\">
                                                <i class=\"fab fa-facebook\"></i>
                                            </span>
                                            <span>Partager</span>
                                          </a>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            $new_row[1]";
        $i++;
    }
        if (count($results) > 3) {
            echo "  <div id=\"is_load_more\" class=\"container has-text-centered is-load-more\">
                        <a id=\"load_more\" class=\"button\">Load more..</a><br><br>
                    </div>";
        }
        ?>
    </div>
</div>
<script>
    let session_user = '<?php echo $_SESSION['username'];?>';
    let username = '<?php echo $_SESSION['username'];?>';
</script>
<script src="/app/public/js/load_comments.js"></script>
<script src="/app/public/js/wall_actions.js"></script>

