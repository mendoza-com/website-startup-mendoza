<?php


function mk_add_icons_html() {

	$mk_icons_list = array(
		'' => '',
    "theme-icon-topnav" => "e66e",
    "theme-icon-rightsidebar" => "e66f",
    "theme-icon-leftsidebar" => "e66b",
    "theme-icon-dashboard-o" => "e671",
    "theme-icon-bottomnav" => "e672",
	"theme-icon-boxed" => "e66b",
    "theme-icon-wide" => "e66a",
    "theme-icon-singlepage" => "e66c",
    "theme-icon-multipage" => "e66d",
    "theme-icon-woman-bag" => "e600",
    "theme-icon-voicemessage"=> "e601",
    "theme-icon-trashcan"=> "e602",
    "theme-icon-thermostat"=> "e603",
    "theme-icon-tag"=> "e604",
    "theme-icon-sitemap"=> "e605",
    "theme-icon-shirt"=> "e606",
    "theme-icon-printer"=> "e607",
    "theme-icon-video"=> "e608",
    "theme-icon-user" => "e609",
    "theme-icon-top-small"=> "e60a",
    "theme-icon-top-bigger"=> "e60b",
    "theme-icon-top-big"=> "e60c",
    "theme-icon-tick"=> "e60d",
    "theme-icon-text"=> "e60e",
    "theme-icon-star"=> "e60f",
    "theme-icon-search"=> "e630",
    "theme-icon-quote"=> "e631",
    "theme-icon-prev-small"=> "e632",
    "theme-icon-prev-big"=> "e633",
    "theme-icon-portfolio"=> "e634",
    "theme-icon-plus"=> "e635",
    "theme-icon-phone"=> "e636",
    "theme-icon-permalink"=> "e637",
    "theme-icon-pause"=> "e638",
    "theme-icon-office"=> "e639",
    "theme-icon-next-small"=> "e63a",
    "theme-icon-next-bigger"=> "e63b",
    "theme-icon-next-big"=> "e63c",
    "theme-icon-love"=> "e644",
    "theme-icon-prev-bigger"=> "e645",
    "theme-icon-image"=> "e646",
    "theme-icon-home"=> "e648",
    "theme-icon-gallery"=> "e649",
    "theme-icon-fax"=> "e64a",
    "theme-icon-email"=> "e64b",
    "theme-icon-comment"=> "e64c",
    "theme-icon-cellphone"=> "e64d",
    "theme-icon-cart"=> "e64e",
    "theme-icon-cancel"=> "e64f",
    "theme-icon-bottom-small"=> "e650",
    "theme-icon-bottom-bigger"=> "e651",
    "theme-icon-bottom-big"=> "e652",
    "theme-icon-blog"=> "e653",
    "theme-icon-blog-share"=> "e654",
    "theme-icon-macbookair"=> "e655",
    "theme-icon-macbook"=> "e656",
    "theme-icon-layers"=> "e657",
    "theme-icon-lab"=> "e658",
    "theme-icon-ipad"=> "e659",
    "theme-icon-hamburger"=> "e65a",
    "theme-icon-folder-2"=> "e65b",
    "theme-icon-file"=> "e65c",
    "theme-icon-crop"=> "e65d",
    "theme-icon-commandconsole"=> "e65e",
    "theme-icon-chergerfull"=> "e65f",
    "theme-icon-chargerhalf"=> "e660",
    "theme-icon-chargerblank"=> "e661",
    "theme-icon-cassette"=> "e662",
    "theme-icon-card"=> "e663",
    "theme-icon-card-2"=> "e664",
    "theme-icon-camera"=> "e665",
    "theme-icon-calendar"=> "e666",
    "theme-icon-accordion"=> "e667",
    "icon-glass" => "f000",
    "icon-music" => "f001",
    "icon-search" => "f002",
    "icon-envelope-o" => "f003",
    "icon-heart" => "f004",
    "icon-star" => "f005",
    "icon-star-o" => "f006",
    "icon-user" => "f007",
    "icon-film" => "f008",
    "icon-th-large" => "f009",
    "icon-th" => "f00a",
    "icon-th-list" => "f00b",
    "icon-check" => "f00c",
    "icon-times" => "f00d",
    "icon-search-plus" => "f00e",
    "icon-search-minus" => "f010",
    "icon-power-off" => "f011",
    "icon-signal" => "f012",
    "icon-cog" => "f013",
    "icon-trash" => "f014",
    "icon-home" => "f015",
    "icon-file-o" => "f016",
    "icon-clock-o" => "f017",
    "icon-road" => "f018",
    "icon-download" => "f019",
    "icon-arrow-circle-o-down" => "f01a",
    "icon-arrow-circle-o-up" => "f01b",
    "icon-inbox" => "f01c",
    "icon-play-circle-o" => "f01d",
    "icon-repeat" => "f01e",
    "icon-refresh" => "f021",
    "icon-list-alt" => "f022",
    "icon-lock" => "f023",
    "icon-flag" => "f024",
    "icon-headphones" => "f025",
    "icon-volume-off" => "f026",
    "icon-volume-down" => "f027",
    "icon-volume-up" => "f028",
    "icon-qrcode" => "f029",
    "icon-barcode" => "f02a",
    "icon-tag" => "f02b",
    "icon-tags" => "f02c",
    "icon-book" => "f02d",
    "icon-bookmark" => "f02e",
    "icon-print" => "f02f",
    "icon-camera" => "f030",
    "icon-font" => "f031",
    "icon-bold" => "f032",
    "icon-italic" => "f033",
    "icon-text-height" => "f034",
    "icon-text-width" => "f035",
    "icon-align-left" => "f036",
    "icon-align-center" => "f037",
    "icon-align-right" => "f038",
    "icon-align-justify" => "f039",
    "icon-list" => "f03a",
    "icon-outdent" => "f03b",
    "icon-indent" => "f03c",
    "icon-video-camera" => "f03d",
    "icon-picture-o" => "f03e",
    "icon-pencil" => "f040",
    "icon-map-marker" => "f041",
    "icon-adjust" => "f042",
    "icon-tint" => "f043",
    "icon-pencil-square-o" => "f044",
    "icon-share-square-o" => "f045",
    "icon-check-square-o" => "f046",
    "icon-arrows" => "f047",
    "icon-step-backward" => "f048",
    "icon-fast-backward" => "f049",
    "icon-backward" => "f04a",
    "icon-play" => "f04b",
    "icon-pause" => "f04c",
    "icon-stop" => "f04d",
    "icon-forward" => "f04e",
    "icon-fast-forward" => "f050",
    "icon-step-forward" => "f051",
    "icon-eject" => "f052",
    "icon-chevron-left" => "f053",
    "icon-chevron-right" => "f054",
    "icon-plus-circle" => "f055",
    "icon-minus-circle" => "f056",
    "icon-times-circle" => "f057",
    "icon-check-circle" => "f058",
    "icon-question-circle" => "f059",
    "icon-info-circle" => "f05a",
    "icon-crosshairs" => "f05b",
    "icon-times-circle-o" => "f05c",
    "icon-check-circle-o" => "f05d",
    "icon-ban" => "f05e",
    "icon-arrow-left" => "f060",
    "icon-arrow-right" => "f061",
    "icon-arrow-up" => "f062",
    "icon-arrow-down" => "f063",
    "icon-share" => "f064",
    "icon-expand" => "f065",
    "icon-compress" => "f066",
    "icon-plus" => "f067",
    "icon-minus" => "f068",
    "icon-asterisk" => "f069",
    "icon-exclamation-circle" => "f06a",
    "icon-gift" => "f06b",
    "icon-leaf" => "f06c",
    "icon-fire" => "f06d",
    "icon-eye" => "f06e",
    "icon-eye-slash" => "f070",
    "icon-exclamation-triangle" => "f071",
    "icon-plane" => "f072",
    "icon-calendar" => "f073",
    "icon-random" => "f074",
    "icon-comment" => "f075",
    "icon-magnet" => "f076",
    "icon-chevron-up" => "f077",
    "icon-chevron-down" => "f078",
    "icon-retweet" => "f079",
    "icon-shopping-cart" => "f07a",
    "icon-folder" => "f07b",
    "icon-folder-open" => "f07c",
    "icon-arrows-v" => "f07d",
    "icon-arrows-h" => "f07e",
    "icon-bar-chart-o" => "f080",
    "icon-twitter-square" => "f081",
    "icon-facebook-square" => "f082",
    "icon-camera-retro" => "f083",
    "icon-key" => "f084",
    "icon-cogs" => "f085",
    "icon-comments" => "f086",
    "icon-thumbs-o-up" => "f087",
    "icon-thumbs-o-down" => "f088",
    "icon-star-half" => "f089",
    "icon-heart-o" => "f08a",
    "icon-sign-out" => "f08b",
    "icon-linkedin-square" => "f08c",
    "icon-thumb-tack" => "f08d",
    "icon-external-link" => "f08e",
    "icon-sign-in" => "f090",
    "icon-trophy" => "f091",
    "icon-github-square" => "f092",
    "icon-upload" => "f093",
    "icon-lemon-o" => "f094",
    "icon-phone" => "f095",
    "icon-square-o" => "f096",
    "icon-bookmark-o" => "f097",
    "icon-phone-square" => "f098",
    "icon-twitter" => "f099",
    "icon-facebook" => "f09a",
    "icon-github" => "f09b",
    "icon-unlock" => "f09c",
    "icon-credit-card" => "f09d",
    "icon-rss" => "f09e",
    "icon-hdd-o" => "f0a0",
    "icon-bullhorn" => "f0a1",
    "icon-bell" => "f0f3",
    "icon-certificate" => "f0a3",
    "icon-hand-o-right" => "f0a4",
    "icon-hand-o-left" => "f0a5",
    "icon-hand-o-up" => "f0a6",
    "icon-hand-o-down" => "f0a7",
    "icon-arrow-circle-left" => "f0a8",
    "icon-arrow-circle-right" => "f0a9",
    "icon-arrow-circle-up" => "f0aa",
    "icon-arrow-circle-down" => "f0ab",
    "icon-globe" => "f0ac",
    "icon-wrench" => "f0ad",
    "icon-tasks" => "f0ae",
    "icon-filter" => "f0b0",
    "icon-briefcase" => "f0b1",
    "icon-arrows-alt" => "f0b2",
    "icon-users" => "f0c0",
    "icon-link" => "f0c1",
    "icon-cloud" => "f0c2",
    "icon-flask" => "f0c3",
    "icon-scissors" => "f0c4",
    "icon-files-o" => "f0c5",
    "icon-paperclip" => "f0c6",
    "icon-floppy-o" => "f0c7",
    "icon-square" => "f0c8",
    "icon-bars" => "f0c9",
    "icon-list-ul" => "f0ca",
    "icon-list-ol" => "f0cb",
    "icon-strikethrough" => "f0cc",
    "icon-underline" => "f0cd",
    "icon-table" => "f0ce",
    "icon-magic" => "f0d0",
    "icon-truck" => "f0d1",
    "icon-pinterest" => "f0d2",
    "icon-pinterest-square" => "f0d3",
    "icon-google-plus-square" => "f0d4",
    "icon-google-plus" => "f0d5",
    "icon-money" => "f0d6",
    "icon-caret-down" => "f0d7",
    "icon-caret-up" => "f0d8",
    "icon-caret-left" => "f0d9",
    "icon-caret-right" => "f0da",
    "icon-columns" => "f0db",
    "icon-sort" => "f0dc",
    "icon-sort-asc" => "f0dd",
    "icon-sort-desc" => "f0de",
    "icon-envelope" => "f0e0",
    "icon-linkedin" => "f0e1",
    "icon-undo" => "f0e2",
    "icon-gavel" => "f0e3",
    "icon-tachometer" => "f0e4",
    "icon-comment-o" => "f0e5",
    "icon-comments-o" => "f0e6",
    "icon-bolt" => "f0e7",
    "icon-sitemap" => "f0e8",
    "icon-umbrella" => "f0e9",
    "icon-clipboard" => "f0ea",
    "icon-lightbulb-o" => "f0eb",
    "icon-exchange" => "f0ec",
    "icon-cloud-download" => "f0ed",
    "icon-cloud-upload" => "f0ee",
    "icon-user-md" => "f0f0",
    "icon-stethoscope" => "f0f1",
    "icon-suitcase" => "f0f2",
    "icon-bell-o" => "f0a2",
    "icon-coffee" => "f0f4",
    "icon-cutlery" => "f0f5",
    "icon-file-text-o" => "f0f6",
    "icon-building-o" => "f0f7",
    "icon-hospital-o" => "f0f8",
    "icon-ambulance" => "f0f9",
    "icon-medkit" => "f0fa",
    "icon-fighter-jet" => "f0fb",
    "icon-beer" => "f0fc",
    "icon-h-square" => "f0fd",
    "icon-plus-square" => "f0fe",
    "icon-angle-double-left" => "f100",
    "icon-angle-double-right" => "f101",
    "icon-angle-double-up" => "f102",
    "icon-angle-double-down" => "f103",
    "icon-angle-left" => "f104",
    "icon-angle-right" => "f105",
    "icon-angle-up" => "f106",
    "icon-angle-down" => "f107",
    "icon-desktop" => "f108",
    "icon-laptop" => "f109",
    "icon-tablet" => "f10a",
    "icon-mobile" => "f10b",
    "icon-circle-o" => "f10c",
    "icon-quote-left" => "f10d",
    "icon-quote-right" => "f10e",
    "icon-spinner" => "f110",
    "icon-circle" => "f111",
    "icon-reply" => "f112",
    "icon-github-alt" => "f113",
    "icon-folder-o" => "f114",
    "icon-folder-open-o" => "f115",
    "icon-smile-o" => "f118",
    "icon-frown-o" => "f119",
    "icon-meh-o" => "f11a",
    "icon-gamepad" => "f11b",
    "icon-keyboard-o" => "f11c",
    "icon-flag-o" => "f11d",
    "icon-flag-checkered" => "f11e",
    "icon-terminal" => "f120",
    "icon-code" => "f121",
    "icon-reply-all" => "f122",
    "icon-mail-reply-all" => "f122",
    "icon-star-half-o" => "f123",
    "icon-location-arrow" => "f124",
    "icon-crop" => "f125",
    "icon-code-fork" => "f126",
    "icon-chain-broken" => "f127",
    "icon-question" => "f128",
    "icon-info" => "f129",
    "icon-exclamation" => "f12a",
    "icon-superscript" => "f12b",
    "icon-subscript" => "f12c",
    "icon-eraser" => "f12d",
    "icon-puzzle-piece" => "f12e",
    "icon-microphone" => "f130",
    "icon-microphone-slash" => "f131",
    "icon-shield" => "f132",
    "icon-calendar-o" => "f133",
    "icon-fire-extinguisher" => "f134",
    "icon-rocket" => "f135",
    "icon-maxcdn" => "f136",
    "icon-chevron-circle-left" => "f137",
    "icon-chevron-circle-right" => "f138",
    "icon-chevron-circle-up" => "f139",
    "icon-chevron-circle-down" => "f13a",
    "icon-html5" => "f13b",
    "icon-css3" => "f13c",
    "icon-anchor" => "f13d",
    "icon-unlock-alt" => "f13e",
    "icon-bullseye" => "f140",
    "icon-ellipsis-h" => "f141",
    "icon-ellipsis-v" => "f142",
    "icon-rss-square" => "f143",
    "icon-play-circle" => "f144",
    "icon-ticket" => "f145",
    "icon-minus-square" => "f146",
    "icon-minus-square-o" => "f147",
    "icon-level-up" => "f148",
    "icon-level-down" => "f149",
    "icon-check-square" => "f14a",
    "icon-pencil-square" => "f14b",
    "icon-external-link-square" => "f14c",
    "icon-share-square" => "f14d",
    "icon-compass" => "f14e",
    "icon-caret-square-o-down" => "f150",
    "icon-caret-square-o-up" => "f151",
    "icon-caret-square-o-right" => "f152",
    "icon-eur" => "f153",
    "icon-gbp" => "f154",
    "icon-usd" => "f155",
    "icon-inr" => "f156",
    "icon-jpy" => "f157",
    "icon-rub" => "f158",
    "icon-krw" => "f159",
    "icon-btc" => "f15a",
    "icon-file" => "f15b",
    "icon-file-text" => "f15c",
    "icon-sort-alpha-asc" => "f15d",
    "icon-sort-alpha-desc" => "f15e",
    "icon-sort-amount-asc" => "f160",
    "icon-sort-amount-desc" => "f161",
    "icon-sort-numeric-asc" => "f162",
    "icon-sort-numeric-desc" => "f163",
    "icon-thumbs-up" => "f164",
    "icon-thumbs-down" => "f165",
    "icon-youtube-square" => "f166",
    "icon-youtube" => "f167",
    "icon-xing" => "f168",
    "icon-xing-square" => "f169",
    "icon-youtube-play" => "f16a",
    "icon-dropbox" => "f16b",
    "icon-stack-overflow" => "f16c",
    "icon-instagram" => "f16d",
    "icon-flickr" => "f16e",
    "icon-adn" => "f170",
    "icon-bitbucket" => "f171",
    "icon-bitbucket-square" => "f172",
    "icon-tumblr" => "f173",
    "icon-tumblr-square" => "f174",
    "icon-long-arrow-down" => "f175",
    "icon-long-arrow-up" => "f176",
    "icon-long-arrow-left" => "f177",
    "icon-long-arrow-right" => "f178",
    "icon-apple" => "f179",
    "icon-windows" => "f17a",
    "icon-android" => "f17b",
    "icon-linux" => "f17c",
    "icon-dribbble" => "f17d",
    "icon-skype" => "f17e",
    "icon-foursquare" => "f180",
    "icon-trello" => "f181",
    "icon-female" => "f182",
    "icon-male" => "f183",
    "icon-gittip" => "f184",
    "icon-sun-o" => "f185",
    "icon-moon-o" => "f186",
    "icon-archive" => "f187",
    "icon-bug" => "f188",
    "icon-vk" => "f189",
    "icon-weibo" => "f18a",
    "icon-renren" => "f18b",
    "icon-pagelines" => "f18c",
    "icon-stack-exchange" => "f18d",
    "icon-arrow-circle-o-right" => "f18e",
    "icon-arrow-circle-o-left" => "f190",
    "icon-caret-square-o-left" => "f191",
    "icon-dot-circle-o" => "f192",
    "icon-wheelchair" => "f193",
    "icon-vimeo-square" => "f194",
    "icon-try" => "f195",
    "icon-plus-square-o" => "f196",
	);

	echo '<div style="display:none;">
    <div id="mk-icon-holder-container">
     <div class="mk-visual-selector mk-font-icons-wrapper" style="height:90%;">';
     foreach ( $mk_icons_list as $key => $option ) {
		if ( $key ) {
			echo '<a href="#" title="class name : mk-'.$key.'" rel="mk-'.$key.'"><i class="mk-'.$key.'"></i></a>';
		} else {
			echo '<a class="mk-no-icon" href="#" rel="">r</a>';
		}
	}
        echo '<input name="mk-icon-value-holder" id="mk-icon-value-holder" type="hidden" value=""/>
     </div>
     <a href="#" class="mk-icon-use-this button-primary" style="color:#fff;margin:20px 0 0 10px;">'.__('Use Icon').'</a>
    </div>
    </div>';

    wp_enqueue_style( 'font-awesome', THEME_STYLES . '/font-awesome.css', false, false, false );
}





if ( mk_theme_is_menus() ) {
	add_action( 'admin_head', 'mk_add_icons_html' );
}




add_action( 'admin_notices',  'mk_detect_check_post_limits' );

function mk_detect_check_post_limits(){

    $screen = get_current_screen();
    if( $screen->id != 'nav-menus' ) return;

    $currentPostVars_count = mk_detect_count_post_vars();
        

    $r = array(); //restrictors

    $r['suhosin_post_maxvars'] = ini_get( 'suhosin.post.max_vars' );
    $r['suhosin_request_maxvars'] = ini_get( 'suhosin.request.max_vars' );
    $r['max_input_vars'] = ini_get( 'max_input_vars' );

    if( $r['suhosin_post_maxvars'] != '' ||
        $r['suhosin_request_maxvars'] != '' ||
        $r['max_input_vars'] != '' ){

        if( ( $r['suhosin_post_maxvars'] != '' && $r['suhosin_post_maxvars'] < 1000 ) || 
            ( $r['suhosin_request_maxvars']!= '' && $r['suhosin_request_maxvars'] < 1000 ) ){
            $message[] = __( "Your server is running Suhosin, and your current maxvars settings may limit the number of menu items you can save." , 'mk_framework' );
        }

        //150 ~ 10 left
        foreach( $r as $key => $val ){
            if( $val > 0 ){
                if( $val - $currentPostVars_count < 150 ){
                    $message[] = __( "You are approaching the post variable limit imposed by your server configuration.  Exceeding this limit may automatically delete menu items when you save.  Please increase your <strong>$key</strong> directive in php.ini." , 'mk_framework' );
                }
            }
        }

        if( !empty( $message ) ): ?>
        <div class="error">
            <p>
            <h4><?php _e( 'Menu Item Limit Warning' , 'mk_framework' ); ?></h4>
            <ul>
            <?php foreach( $message as $m ): ?>
                <li><?php echo $m; ?></li>
            <?php endforeach; ?>
            </ul>

            <?php
            if( $r['max_input_vars'] != '' ) echo "<strong>max_input_vars</strong> :: ". 
                $r['max_input_vars']. " <br/>";
            if( $r['suhosin_post_maxvars'] != '' ) echo "<strong>suhosin.post.max_vars</strong> :: ".$r['suhosin_post_maxvars']. " <br/>";
            if( $r['suhosin_request_maxvars'] != '' ) echo "<strong>suhosin.request.max_vars</strong> :: ". $r['suhosin_request_maxvars'] ." <br/>";
            
            echo "<br/><strong>".__( 'Menu Item Post variable count on last save', 'mk_framework' )."</strong> :: ". $currentPostVars_count."<br/>";
            if( $r['max_input_vars'] != '' ){
                $estimate = ( $r['max_input_vars'] - $currentPostVars_count ) / 14;
                if( $estimate < 0 ) $estimate = 0;
                echo "<strong>".__( 'Approximate remaining menu items' , 'mk_framework' )."</strong> :: " . floor( $estimate );
            };

            ?>

            </p>
        </div>
        <?php endif; 

    }

}
function mk_detect_count_post_vars() {

    if( isset( $_POST['save_menu'] ) ){

        $count = 0;
        foreach( $_POST as $key => $arr ){
            $count+= count( $arr );
        }

        update_option( 'mk_detect-post-var-count' , $count );
    }
    else{
        $count = get_option( 'mk_detect-post-var-count' , 0 );
    }

    return $count;
}