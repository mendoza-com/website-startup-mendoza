function is_touch_device() {
    return !!('ontouchstart' in window) || !!('onmsgesturechange' in window);
}
jQuery.exists = function(selector) {
    return (jQuery(selector).length > 0);
};

jQuery.fn.hasAttr = function(name) {
    return this.attr(name) !== undefined;
};

if (!Function.prototype.bind) {
  Function.prototype.bind = function(oThis) {
    if (typeof this !== 'function') {
      // closest thing possible to the ECMAScript 5
      // internal IsCallable function
      throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
    }

    var aArgs   = Array.prototype.slice.call(arguments, 1),
        fToBind = this,
        fNOP    = function() {},
        fBound  = function() {
          return fToBind.apply(this instanceof fNOP && oThis
                 ? this
                 : oThis,
                 aArgs.concat(Array.prototype.slice.call(arguments)));
        };

    fNOP.prototype = this.prototype;
    fBound.prototype = new fNOP();

    return fBound;
  };
}

(function($) {

    "use strict";

/* Gets IE version */
/* -------------------------------------------------------------------- */

function mk_detect_ie() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf('MSIE ');
    var trident = ua.indexOf('Trident/');
    if (msie > 0) {
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }
    if (trident > 0) {
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }
    return false;
}


//////////////////////////////////////////////////////////////////////////
//
//   Defining global variables for cross app use
//
//////////////////////////////////////////////////////////////////////////

var scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop, // Updated in global event handler
    global_window_width = $(window).width(),
    global_window_height = $(window).height(),
    global_admin_bar,
    global_admin_bar_height = 0;


$(window).load(function() {
    if ($.exists("#wpadminbar")) {
        global_admin_bar = $("#wpadminbar");
        global_admin_bar_height = global_admin_bar.height();
    } 
});
        
function mk_update_globals() {
    global_window_width = $(window).width();
    global_window_height = $(window).height();
}

window.scroll = function() {
        scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
}

//////////////////////////////////////////////////////////////////////////
//
//   Global scroll handler
//
//////////////////////////////////////////////////////////////////////////


var animationThrottle = function(toThrottle, wait) {
    var lastTick = Date.now(),
        endTimeout = null;
    
    return function run() {
        if(Date.now() - lastTick > wait) {
            lastTick = Date.now();
            clearTimeout(endTimeout);
            window.requestAnimationFrame(toThrottle);
        }
        else {
            clearTimeout(endTimeout);
            endTimeout = setTimeout(run, wait);
        }
    };
};


var scrollAnimations = {
    sets: [],

    init: function() {
        this.update();
        this.attachEvents();
        // console.table(this.sets);
    },

    attachEvents: function() {
        window.addEventListener('scroll', animationThrottle(
            this.play.bind(this), 0
        ));
    },

    add: function(handler) {
        this.sets.push(handler);
    },

    play: function() {
        this.update();
        this.sets.forEach( function(animationSet) {
            animationSet(scrollY);
        }.bind(this));
    },

    update: function() {
        scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    },

};
scrollAnimations.init();


var debouncedScrollAnimations = {
    sets: [],

    init: function() {
        this.attachEvents();
    },

    attachEvents: function() {
        window.addEventListener('scroll', animationThrottle(
            this.play.bind(this), 200
        ));
    },

    add: function(handler) {
        this.sets.push(handler);
    },

    play: function() {
        this.sets.forEach( function(animationSet) {
            animationSet(scrollY);
        }.bind(this));
    },
};
debouncedScrollAnimations.init();


// RequestAnimationFrame polyfill for older browsers
var rafPolyfill = function() {
    var lastTime, vendors, x;
    lastTime = 0;
    vendors = ["webkit", "moz"];
    x = 0;
    while (x < vendors.length && !window.requestAnimationFrame) {
      window.requestAnimationFrame = window[vendors[x] + "RequestAnimationFrame"];
      window.cancelAnimationFrame = window[vendors[x] + "CancelAnimationFrame"] || window[vendors[x] + "CancelRequestAnimationFrame"];
      ++x;
    }
    if (!window.requestAnimationFrame) {
      window.requestAnimationFrame = function(callback, element) {
        var currTime, id, timeToCall;
        currTime = new Date().getTime();
        timeToCall = Math.max(0, 16 - (currTime - lastTime));
        id = window.setTimeout(function() {
          callback(currTime + timeToCall);
        }, timeToCall);
        lastTime = currTime + timeToCall;
        return id;
      };
    }
    if (!window.cancelAnimationFrame) {
      window.cancelAnimationFrame = function(id) {
        clearTimeout(id);
      };
    }
};
rafPolyfill();







/* Page Title Intro */
/* -------------------------------------------------------------------- */

function mk_page_title_intro() {

    "use strict";

    if (!is_touch_device()) {
        $('#mk-page-title').each(function() {
            var progressVal,
                currentPoint,
                $this = $(this),
                parentHeight = $this.outerHeight(),
                $fullHeight = $this.attr('data-fullHeight'),
                startPoint = 0,
                endPoint = $this.offset().top + parentHeight,
                effectLayer = $this.find('.mk-page-title-bg'),
                gradientLayer = $this.find('.mk-effect-gradient-layer'),
                animation = $this.attr('data-intro');

            var layout = function() {
                var $heading = $this.find('.mk-page-heading'),
                    $fullHeight = $this.attr('data-fullHeight'),
                    $header_height = 0,
                    $height = $this.attr('data-height'),
                    page_title_full_height = 0;

                if ($.exists('#mk-header.sticky-header') && !$('#mk-header').hasClass('transparent-header')) {
                    var $header_height = parseInt($('#mk-header.sticky-header').attr('data-sticky-height'));
                }

                if ($fullHeight === 'true') {
                    page_title_full_height = global_window_height - $header_height - global_admin_bar_height;
                } 
                else {
                    page_title_full_height = $height;
                }

                $this.css('height', page_title_full_height);

                if ($('#mk-header').hasClass('transparent-header') && $fullHeight == 'true') {
                    var header_height = parseInt($('#mk-header').attr('data-height'));
                    var padding = parseInt($this.css('padding-top'));
                    $this.css({ 
                        'padding' : 0
                    });
                    $heading.css({
                        'padding-top' : (page_title_full_height/2 - $heading.height()/2)+'px'
                    });
                }
            } 
            layout();

            if ($fullHeight == 'true') {
                $(window).on("debouncedresize", function() {
                    layout();
                })
            }

            if ($('#mk-header').hasClass('transparent-header') && $fullHeight != 'true' ) {
                var header_height = parseInt($('#mk-header').attr('data-height'));
                var padding = parseInt($this.css('padding-top'));
                $this.css({ 
                    'padding-top' : (padding + header_height)+'px'
                })
            }
        

            var parallaxSpeed = .7,
                zoomFactor = 1.4;

                if (animation == "parallax") {
                    var set = function() {
                        currentPoint = (startPoint + scrollY) * parallaxSpeed;
                        effectLayer.css({
                            'transform': 'translateY(' + currentPoint + 'px)'
                        });
                    }
                    set();
                    scrollAnimations.add(set);
                }

                if (animation == "parallaxZoomOut") {
                    var set = function() {
                        currentPoint = (startPoint + scrollY) * parallaxSpeed;
                        progressVal = (1 / (endPoint - startPoint) * (scrollY - startPoint));
                        var zoomCalc = zoomFactor - ((zoomFactor - 1.2) * progressVal);

                        effectLayer.css({
                            'transform': 'translateY(' + currentPoint + 'px), scale(' + zoomCalc + ')'
                        });
                    }
                    set();
                    scrollAnimations.add(set);
                }

                if (animation == "gradient") {
                    var set = function() {
                        progressVal = (1 / (endPoint - startPoint) * (scrollY - startPoint));
                        gradientLayer.css({
                            opacity: progressVal * 2
                        });
                    }
                    set();
                    scrollAnimations.add(set);
                }
        });
    }
}

/* Progress Button */
/* -------------------------------------------------------------------- */

var progressButton = {
    loader: function(form) {
        var $form = form,
            progressBar = $form.find(".mk-progress-button .mk-progress-inner"),
            buttonText = $form.find(".mk-progress-button .mk-progress-button-content"),
            progressButton = new TimelineLite();

        progressButton
            .to(progressBar, 0, {
                width: "100%",
                scaleX: 0,
                scaleY: 1
            })
            .to(buttonText, .3, {
                y: -5
            })
            .to(progressBar, 1.5, {
                scaleX: 1,
                ease: Power2.easeInOut
            }, "-=.1")
            .to(buttonText, .3, {
                y: 0
            })
            .to(progressBar, .3, {
                scaleY: 0
            });
    },

    success: function(form) {
        var $form = form,
            buttonText = $form.find(".mk-button .mk-progress-button-content, .mk-contact-button .mk-progress-button-content"),
            successIcon = $form.find(".mk-progress-button .state-success"),
            progressButtonSuccess = new TimelineLite({
                onComplete: hideSuccessMessage
            });

        progressButtonSuccess
            .to(buttonText, .3, {
                paddingRight: 20,
                ease: Power2.easeInOut
            }, "+=1")
            .to(successIcon, .3, {
                opacity: 1
            })
            .to(successIcon, 2, {
                opacity: 1
            });

        function hideSuccessMessage() {
            progressButtonSuccess.reverse()
        }
    },

    error: function(form) {
        var $form = form,
            buttonText = $form.find(".mk-button .mk-progress-button-content, .mk-contact-button .mk-progress-button-content"),
            errorIcon = $form.find(".mk-progress-button .state-error"),
            progressButtonError = new TimelineLite({
                onComplete: hideErrorMessage
            });

        progressButtonError
            .to(buttonText, .3, {
                paddingRight: 20
            }, "+=1")
            .to(errorIcon, .3, {
                opacity: 1
            })
            .to(errorIcon, 2, {
                opacity: 1
            });

        function hideErrorMessage() {
            progressButtonError.reverse()
        }
    }
}


/* Logo placement */
/* -------------------------------------------------------------------- */

function mk_logo_middle() {
    if($.exists('#mk-header.theme-main-header.header-align-center')) {
    var $menu = $('.theme-main-header .main-navigation-ul'),
        menuItems = $menu.find('> .menu-item'),
        $logo = $menu.find('.mk-header-logo'),
        menuWidthLeftFloor = 0,
        menuWidthLeftCeil = 0,
        menuWidthRightFloor = 0,
        menuWidthRightCeil = 0,
        halfFloor = Math.floor(menuItems.length/2),
        halfCeil = Math.ceil(menuItems.length/2);

    // Left widths 
    for (var i = 0; i < halfFloor; i++) {
        menuWidthLeftFloor += $(menuItems[i]).width();
    }
    for (var i = 0; i < halfCeil; i++) {
        menuWidthLeftCeil += $(menuItems[i]).width();
    }

    // Right wdths 
    for (var i = halfFloor-1; i < menuItems.length; i++) {
        menuWidthRightFloor += $(menuItems[i]).width();
    }
    for (var i = halfCeil-1; i < menuItems.length; i++) {
        menuWidthRightCeil += $(menuItems[i]).width();
    }

    if( menuWidthLeftCeil >= menuWidthRightCeil) {
        $logo.clone().addClass('mk-header-logo-center').insertAfter(menuItems[halfCeil-1]);
        $logo.remove();
    } else {
        $logo.clone().addClass('mk-header-logo-center').insertAfter(menuItems[halfFloor-1]);
        $logo.remove();
    }
}
}



;/* Window Scroller */
/* -------------------------------------------------------------------- */

function mk_window_scroller() {
    if (!$.exists('.mk-window-scroller')) {
        return false;
    }

    $('.mk-window-scroller').each(function() {
        var $this = $(this),
            $container_h = $this.attr('data-height'),
            $image = $this.find('img'),
            $speed = parseInt($this.attr('data-speed'));

        $this.stop(true, true).hoverIntent(function() {
            $image.animate({
                'top': -($image.height() - $container_h)
            }, $speed);

        }, function() {
            $image.animate({
                'top': 0
            }, $speed / 3);
        });
    });

};/* Header Section Sticky function */
/* -------------------------------------------------------------------- */

function sticky_header() {
    var $mk_header = $('#mk-header');
    if ($mk_header.hasClass('sticky-header') && global_window_width > mk_nav_res_width) {

            var header_structure = $mk_header.attr('data-header-structure');

            if(header_structure == 'vertical') {
                var mk_header_height = 100;
            } else {
                var mk_header_height = parseInt((mk_header_padding * 2) + mk_logo_height) + 30;
            }


        var chopScrollAnimation = function() {
            if (global_window_width > mk_nav_res_width) {
                if (scrollY > mk_header_height) {
                    $mk_header.addClass('sticky-trigger-header');
                } else {
                    $mk_header.removeClass('sticky-trigger-header');
                }
            }
            // setTimeout(function() {
            //     mk_main_navigation();
            // }, 200);
        }
        debouncedScrollAnimations.add(chopScrollAnimation);
    }

}



function transparent_header_sticky() {
    var $mk_header = $('#mk-header');
    if ($mk_header.hasClass('transparent-header') && global_window_width > mk_nav_res_width) {

        var trigger = false;

        var chopScrollAnimation = function() {
            var edge_active = $('.mk-edge-slider.first-el-true').find('.swiper-slide-active').attr('data-header-skin'),
                header_structure = $mk_header.attr('data-header-structure');
                if(header_structure == 'vertical') {
                    var mk_header_height = 100;
                } else {
                    var mk_header_height = parseInt((mk_header_padding * 2) + mk_logo_height) + 30;
                }

            mk_header_trans_offset = (mk_header_trans_offset == 0) ? global_window_height : mk_header_trans_offset;

                if (global_window_width > mk_nav_res_width) {
                    if (scrollY > mk_header_height || trigger) {
                        $mk_header.addClass('header-offset-passed');
                    } else {
                        $mk_header.removeClass('header-offset-passed');
                    }

                    if (scrollY > mk_header_trans_offset  || trigger) {
                        $mk_header.addClass('transparent-header-sticky sticky-trigger-header').removeClass('light-header-skin dark-header-skin');

                    } else {
                        if (edge_active != '' && typeof edge_active !== 'undefined') {
                            $mk_header.removeClass('transparent-header-sticky sticky-trigger-header').addClass(edge_active + '-header-skin');
                        } else {
                            $mk_header.removeClass('transparent-header-sticky sticky-trigger-header').addClass($mk_header.attr('data-transparent-skin') + '-header-skin');
                        }
                    }
                }

                // setTimeout(function() {
                //     mk_main_navigation();
                // }, 200);
        }
        debouncedScrollAnimations.add(chopScrollAnimation);

        $('body').on('page_intro', function() { 
            setTimeout(function() {
                trigger = true;
                chopScrollAnimation();
            }, 1000);
        });
        $('body').on('page_outro', function() { 
            setTimeout(function() {
                trigger = false;
                chopScrollAnimation();
            }, 500);
        });

    }

};/* Main Navigation Init */
/* -------------------------------------------------------------------- */

function mk_main_navigation_init() {

    // $(".main-navigation-ul").dcMegaMenu({
    //     rowItems: '6',
    //     speed: 200,
    //     effect: 'fade',
    //     fullWidth: true
    // });

  "use strict";

  var $body = $('body');

  if (!$body.hasClass('navigation-initialised')) {

    $(".main-navigation-ul").MegaMenu({
      type: "vertical",
      delay: 200
    });

    $('#mk-vm-menu').dlmenu();

    $body.addClass('navigation-initialised');

  }

  

}




/* Main Navigation mobile mode */
/* -------------------------------------------------------------------- */

function mk_main_navigation_functions() {

    if (global_window_width > mk_nav_res_width) {

        $('.mk-responsive-nav').hide();
        setTimeout(function() {
            mk_main_navigation_init();
            // mk_main_navigation();
        }, 200);

        if ($('#mk-header').attr('data-header-style') == 'transparent') {
            $('#mk-header').addClass('transparent-header ' + $('#mk-header').attr('data-transparent-skin') + '-header-skin');
        }



    } else {

            $('.main-navigation-ul, .mk-vertical-menu').each(function() {
                var $this = $(this),
                res_nav = $this.parents('#mk-header').next('.responsive-nav-container');
                if(!res_nav.hasClass('res-nav-appended')) {
                    $this.clone().attr({
                        "class": "mk-responsive-nav"
                    }).appendTo(res_nav);
                    res_nav.addClass('res-nav-appended')
                }

            });

            

            $('.mk-responsive-nav > li > ul').each(function() {
                $(this).siblings('a').append('<span class="mk-theme-icon-bottom-big mk-nav-arrow mk-nav-sub-closed"></span>');
            });

            $('.mk-responsive-nav').on('click', '.mk-nav-arrow', function(e) {
                    var $this = $(this);

                if ($this.hasClass('mk-nav-sub-closed')) {
                    $this.parent().siblings('ul').slideDown(300);
                    $this.removeClass('mk-nav-sub-closed').addClass('mk-nav-sub-opened');
                } else {
                    $this.parent().siblings('ul').slideUp(300);
                    $this.removeClass('mk-nav-sub-opened').addClass('mk-nav-sub-closed');
                }
                e.preventDefault();
            });
            $('.mk-responsive-nav').show();

        if ($('#mk-header').attr('data-header-style') == 'transparent') {
            $('#mk-header').removeClass('transparent-header ' + $('#mk-header').attr('data-transparent-skin') + '-header-skin');
        }

    }


    if (global_window_width < mk_grid_width) {
        $('.main-navigation-ul .sub-container.mega, .main-navigation-ul .sub-container.mega .row').each(function() {
            $(this).css('width', global_window_width - 40);
        });
    }



};/* Secondary Header Scripts */
/* -------------------------------------------------------------------- */

var secondary_header_offset;

function mk_secondary_header_res() {
    if ($.exists('.mk-secondary-header')) {
        secondary_header_offset = $('.mk-secondary-header').offset().top; // switched from position(). We need val relative to document.
        // console.log(secondary_header_offset);
    }
}

function secondary_header() {
    var $this = $('.mk-secondary-header');
    if ($this.length) {

        var mk_header = 0;

        if ($.exists("#mk-header.sticky-header")) {
            var mk_header = parseInt($("#mk-header.sticky-header").attr('data-sticky-height'));
        }

        var dsitance_from_top = secondary_header_offset - mk_header - global_admin_bar_height;

        var animationSet = function() {
            if (scrollY > dsitance_from_top) {
                $this.addClass('secondary-header-sticky').css('top', (mk_header + global_admin_bar_height));
                $('.secondary-header-space').addClass('secondary-space-sticky');
            } else {
                $this.removeClass('secondary-header-sticky').css('top', 'auto');
                $('.secondary-header-space').removeClass('secondary-space-sticky');
            }
        }
        debouncedScrollAnimations.add(animationSet);
    }
}
;
/* Retina compatible images */
/* -------------------------------------------------------------------- */
var mk_retina = function() {
    return {
        init: function() {
            var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
            if (pixelRatio > 1) {
                $("img").each(function(idx, el) {
                    el = $(el);
                    if (el.attr("data-retina-src")) {
                        el.attr("data-src-orig", el.attr("src"));
                        el.attr("src", el.attr("data-retina-src"));
                    }
                });
            }
        }
    };
}();
mk_retina.init();

;
$(window).load(function() {

    /* Milestone Number Shortcode */
    /* -------------------------------------------------------------------- */
    $('.mk-milestone').one('inview', function(event, visible) {
        if (visible == true) {

            var el_this = $(this),
                stop_number = el_this.find('.milestone-number').attr('data-stop'),
                animation_speed = parseInt(el_this.find('.milestone-number').attr('data-speed'));

            $({
                countNum: el_this.find('.milestone-number').text()
            }).animate({
                countNum: stop_number
            }, {
                duration: animation_speed,
                step: function() {
                    el_this.find('.milestone-number').text(Math.floor(this.countNum));
                },
                complete: function() {
                    el_this.find('.milestone-number').text(this.countNum);
                }
            });
        }
    });



    /* Skill Meter and Charts */
    /* -------------------------------------------------------------------- */
    $('.mk-skill-meter .progress-outer').one('inview', function(event, visible) {
        if (visible == true) {
            var $this = $(this);
            $this.animate({
                width: $(this).attr("data-width") + '%'
            }, 2000);
        }
    });



    $('.mk-chart').one('inview', function(event, visible) {
        if (visible == true) {
            var $this = $(this),
                $parent_width = $(this).parent().width(),
                $chart_size = $this.attr('data-barSize');

            if ($parent_width < $chart_size) {
                $chart_size = $parent_width;
                $this.css('line-height', $chart_size);
                $this.find('i').css({
                    'line-height': $chart_size + 'px',
                    'font-size': ($chart_size / 3)
                });
            }
            $this.easyPieChart({
                animate: 1300,
                lineCap: 'square',
                lineWidth: $this.attr('data-lineWidth'),
                size: $chart_size,
                barColor: $this.attr('data-barColor'),
                trackColor: $this.attr('data-trackColor'),
                scaleColor: 'transparent',
                onStep: function(value) {
                    this.$el.find('.chart-percent span').text(Math.ceil(value));
                }
            });
        }
    });



    /* Animated Contents */
    /* -------------------------------------------------------------------- */
    if (is_touch_device() || global_window_width < 800) {
        $('body').addClass('no-transform').find('.mk-animate-element').removeClass('mk-animate-element');
    }

    $('.mk-animate-element').one('inview', function(event, visible) {
        if (visible == true) {
            $(this).addClass('mk-in-viewport');
        }
    });


});
;/* Google Maps */
/* -------------------------------------------------------------------- */

function mk_google_maps() {


    "use strict";

    $('.mk-gmaps').each(function() {

        var $this = $(this),
            $id = $this.attr('id'),
            $zoom = parseInt($this.attr('data-zoom')),
            $latitude = $this.attr('data-latitude'),
            $longitude = $this.attr('data-longitude'),
            $address = $this.attr('data-address'),
            $latitude_2 = $this.attr('data-latitude2'),
            $longitude_2 = $this.attr('data-longitude2'),
            $address_2 = $this.attr('data-address2'),
            $latitude_3 = $this.attr('data-latitude3'),
            $longitude_3 = $this.attr('data-longitude3'),
            $address_3 = $this.attr('data-address3'),
            $pin_icon = $this.attr('data-pin-icon'),
            $pan_control = $this.attr('data-pan-control') === "true" ? true : false,
            $map_type_control = $this.attr('data-map-type-control') === "true" ? true : false,
            $scale_control = $this.attr('data-scale-control') === "true" ? true : false,
            $draggable = $this.attr('data-draggable') === "true" ? true : false,
            $zoom_control = $this.attr('data-zoom-control') === "true" ? true : false,
            $modify_coloring = $this.attr('data-modify-coloring') === "true" ? true : false,
            $saturation = $this.attr('data-saturation'),
            $hue = $this.attr('data-hue'),
            $lightness = $this.attr('data-lightness'),
            $fullHeight = $this.attr('data-fullHeight') === "true" ? true : false,
            map_height,
            $header_height = 0,
            $parent = $this.parent(),
            $height = $parent.height(),
            $styles;

        var mapDimensions = function() {
            if ($.exists('#mk-header') && !$('#mk-header').hasClass('transparent-header')) {
                if($('#mk-header').hasClass('sticky-header')) {
                    $header_height = parseInt($('#mk-header').attr('data-sticky-height'));
                } else {
                    $header_height = parseInt($('#mk-header').attr('data-height'));
                }
            }
            if ($fullHeight === true) {
                map_height = global_window_height - $header_height - global_admin_bar_height;

            } else {
                map_height = $height;
            }

            $parent.height(map_height);

            if($parent.hasClass('mk-gmaps-parallax')){
                $this.height(map_height+200);
            } else {
                $this.height(map_height);
            }
            // Reinit maps
        }


        if ($modify_coloring == true) {
            var $styles = [{
                stylers: [{
                    hue: $hue
                }, {
                    saturation: $saturation
                }, {
                    lightness: $lightness
                }, {
                    featureType: "landscape.man_made",
                    stylers: [{
                        visibility: "on"
                    }]
                }]
            }];
        }


        var map;

        function initialize() {

            var bounds = new google.maps.LatLngBounds();

            var mapOptions = {
                zoom: $zoom,
                panControl: $pan_control,
                zoomControl: $zoom_control,
                mapTypeControl: $map_type_control,
                scaleControl: $scale_control,
                draggable: $draggable,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: $styles
            };

            map = new google.maps.Map(document.getElementById($id), mapOptions);
            map.setTilt(45);

            // Multiple Markers

            var markers = [];
            var infoWindowContent = [];

            if ($latitude != '' && $longitude != '') {
                markers[0] = [$address, $latitude, $longitude];
                infoWindowContent[0] = ['<div class="info_content"><p>' + $address + '</p></div>'];
            }

            if ($latitude_2 != '' && $longitude_2 != '') {
                markers[1] = [$address_2, $latitude_2, $longitude_2];
                infoWindowContent[1] = ['<div class="info_content"><p>' + $address_2 + '</p></div>'];
            }

            if ($latitude_3 != '' && $longitude_3 != '') {
                markers[2] = [$address_3, $latitude_3, $longitude_3];
                infoWindowContent[3] = ['<div class="info_content"><p>' + $address_3 + '</p></div>'];
            }



            var infoWindow = new google.maps.InfoWindow(),
                marker, i;


            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0],
                    icon: $pin_icon
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);
                    }
                })(marker, i));

                map.fitBounds(bounds);

            }


            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom($zoom);
                google.maps.event.removeListener(boundsListener);
            });
        }



        $(window).load(function() {
            mapDimensions();
            setTimeout(function() {
                initialize();
            }, 500);
        });

        $(window).on('resize', function() {
            setTimeout(function() {
                mapDimensions();
                google.maps.event.trigger(map, 'resize');
            }, 500);
        });


    });

    $(window).load(function() {
        if ($.exists('.mk-gmaps-parallax')) {
            var mk_skrollr = skrollr.init({
                forceHeight: false
            });
            mk_skrollr.refresh($('.mk-page-section'));
        }
    });

};/* Header Search, Header Dashboard scripts */
/* -------------------------------------------------------------------- */

$(".mk-header-search, .mk-side-dashboard, .dashboard-trigger, .search-ajax-input, .mk-quick-contact-inset").click(function(event) {
    if (event.stopPropagation) {
        event.stopPropagation();
    } else if (window.event) {
        window.event.cancelBubble = true;
    }
});


$("html").click(function() {
    $('.header-search-icon').removeClass('search-clicked');
    $('form.header-searchform-input').fadeOut(250);
    $('#mk-header').removeClass('header-search-triggered');
    $('.dashboard-trigger').removeClass('dashboard-active');
    $('.theme-main-wrapper, .mk-side-dashboard').removeClass('dashboard-opened');

});


$('.header-search-icon').on('click', function(e) {
    $('form.header-searchform-input').fadeIn(250);
    $('#mk-header').addClass('header-search-triggered');
    $('form.header-searchform-input input[type=text]').focus();
    e.preventDefault();
});

$('.header-search-close').on('click', function(e) {
    $('form.header-searchform-input').fadeOut(250);
    $('#mk-header').removeClass('header-search-triggered');
    e.preventDefault();
});



$('.dashboard-trigger').on('click', function(e) {

    var $this = $(this);

    if (!$this.hasClass('dashboard-active')) {

        $this.addClass('dashboard-active');
        $('.theme-main-wrapper, .mk-side-dashboard').addClass('dashboard-opened');

    } else {

        $this.removeClass('dashboard-active');
        $('.theme-main-wrapper, .mk-side-dashboard').removeClass('dashboard-opened');
    }
    e.preventDefault();
});


$('.responsive-nav-link').on('click', function(e) {
    var $this = $(this),
        res_nav = $this.parents('#mk-header').next('.responsive-nav-container');

    if (!$this.hasClass('active-burger')) {

        $this.addClass('active-burger');
        res_nav.slideDown();

    } else {

        $this.removeClass('active-burger');
        res_nav.slideUp();
    }
    e.preventDefault();
});;/* jQuery Colorbox lightbox */
/* -------------------------------------------------------------------- */

function mk_lightbox_init() {

    jQuery(".mk-lightbox").each(function() {

        jQuery(this).fancybox({
            padding: 15,
            margin: 15,

            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1, // Set to 2 for retina display support

            autoSize: true,
            autoHeight: false,
            autoWidth: false,

            autoResize: true,
            fitToView: true,
            aspectRatio: false,
            topRatio: 0.5,
            leftRatio: 0.5,

            scrolling: 'auto', // 'auto', 'yes' or 'no'
            wrapCSS: '',

            arrows: true,
            closeBtn: true,
            closeClick: false,
            nextClick: false,
            mouseWheel: true,
            autoPlay: false,
            playSpeed: 3000,
            preload: 3,
            modal: false,
            loop: true,
            // Properties for each animation type
            // Opening fancyBox
            openEffect: 'elastic', // 'elastic', 'fade' or 'none'
            openSpeed: 250,
            openEasing: 'swing',
            openOpacity: true,
            openMethod: 'zoomIn',

            // Closing fancyBox
            closeEffect: 'elastic', // 'elastic', 'fade' or 'none'
            closeSpeed: 250,
            closeEasing: 'swing',
            closeOpacity: true,
            closeMethod: 'zoomOut',

            // Changing next gallery item
            nextEffect: 'fade', // 'elastic', 'fade' or 'none'
            nextSpeed: 350,
            nextEasing: 'swing',
            nextMethod: 'changeIn',

            // Changing previous gallery item
            prevEffect: 'fade', // 'elastic', 'fade' or 'none'
            prevSpeed: 350,
            prevEasing: 'swing',
            prevMethod: 'changeOut',

            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" />',
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"><i class="mk-icon-times"></i></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span><i class="mk-theme-icon-next-big"></i></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span><i class="mk-theme-icon-prev-big"></i></span></a>',
                loading: '<div id="fancybox-loading"><div></div></div>'
            },

        });
    });

};/* Edge Slideshow */
/* -------------------------------------------------------------------- */

function mk_edge_slider_init() {

    $('.mk-edge-slider').each(function(i, val) {
        var $slider_wrapper = $(this),
            $slider_holder = $slider_wrapper.find('.edge-slider-holder'),
            $nav = $('.mk-edge-nav'),
            $next_arrow = $slider_wrapper.find('.mk-edge-next'),
            $prev_arrow = $slider_wrapper.find('.mk-edge-prev'),
            $pause = $slider_wrapper.attr('data-pause'),
            $first_el = $slider_wrapper.attr('data-first'),
            $speed = $slider_wrapper.attr('data-speed'),
            $animation = $slider_wrapper.attr('data-animation'),
            $loop = $slider_wrapper.attr('data-loop'),
            $hash = $slider_wrapper.attr('data-hash') == "true" ? true : false,
            $height = $slider_wrapper.attr('data-height'),
            $fullHeight = $slider_wrapper.attr('data-fullHeight'),
            $header_height = 0,
            edge_height = 0,
            $pagination = $slider_wrapper.attr('data-pagination') == "true" ? true : false;


        if ($pagination === true) {
            var $pagination_class = '#' + $slider_wrapper.attr('id') + ' .swiper-pagination';

            $($pagination_class).on('click', 'span', function(){
              mk_swiper.swipeTo($(this).index(), 500);
            });

            $slider_wrapper.find('.edge-skip-slider').css('bottom', '14%');
            } else {
            var $pagination_class = false;
        }

        var animationDimensions = function() {
            if ($.exists('#mk-header') && !$('#mk-header').hasClass('transparent-header') && !$('#mk-header').hasClass('header-structure-vertical')) {
                $header_height = parseInt($('#mk-header').attr('data-sticky-height'));
            }
            if ($fullHeight === 'true') {
                edge_height = global_window_height - $header_height - global_admin_bar_height;
            } else {
                edge_height = $height;
            }
            
        }
        animationDimensions();

        $(window).on("debouncedresize", function(event) {
            setTimeout(function() {
                mk_edge_slider_resposnive();
                animationDimensions();
            }, 100);
        });

        // remove viewport animations from slider
        $slider_wrapper.find('.mk-animate-element').removeClass('mk-animate-element fade-in scale-up right-to-left left-to-right bottom-to-top top-to-bottom forthy-five-rotate');

        var mk_swiper = $slider_wrapper.swiper({
            mode: 'horizontal', 
            // loop: $loop === 'true' ? true : false,
            loop: true,
            grabCursor: true,
            useCSS3Transforms: true,
            mousewheelControl: false,
            pagination : $pagination_class,
            paginationClickable: true,
            freeModeFluid: true,
            speed: $speed,
            autoplay: $pause,
            progress: true,
            autoplayDisableOnInteraction: false,
            hashNav: $hash, 
            onSwiperCreated: function(swiper) {
                if (mk_detect_ie() == false) {
                    var prev_active_slide = $slider_wrapper.find('.swiper-slide').eq(0).find('.edge-slide-content .mk-edge-title').text(),
                        next_active_slide = $slider_wrapper.find('.swiper-slide').eq(2).find('.edge-slide-content .mk-edge-title').text();
                    //console.log(prev_active_slide + "---" + next_active_slide);
                    var prev_active_slide_bg = $slider_wrapper.find('.swiper-slide').eq(0).css('background-image'),
                        next_active_slide_bg = $slider_wrapper.find('.swiper-slide').eq(2).css('background-image');
                    // console.log(prev_active_slide_bg + "---" + next_active_slide_bg);
                    var prev_active_slide_bg_video = $slider_wrapper.find('.swiper-slide').eq(0).find('.mk-video-section-touch').css('background-image'),
                        next_active_slide_bg_video = $slider_wrapper.find('.swiper-slide').eq(2).find('.mk-video-section-touch').css('background-image');

                        // console.log(prev_active_slide_bg_video);
                        // console.log(next_active_slide_bg_video);

                    var prev_active_slide_bg_color = $slider_wrapper.find('.swiper-slide').eq(0).css('background-color'),
                        next_active_slide_bg_color = $slider_wrapper.find('.swiper-slide').eq(2).css('background-color');

                    if (prev_active_slide.length > 1) {
                        $prev_arrow.find('.prev-item-caption').show().text(prev_active_slide);
                        // console.log(prev_active_slide);
                    }

                    if (typeof prev_active_slide_bg !== 'undefined' && prev_active_slide_bg != "none") {
                      $prev_arrow.find('.edge-nav-bg').show().css({ 'background-image': prev_active_slide_bg });
                      // console.log(prev_active_slide_bg);
                    } 
                    else if (typeof prev_active_slide_bg_video !== 'undefined' && prev_active_slide_bg_video != "none") {
                      $prev_arrow.find('.edge-nav-bg').show().css({ 'background-image': prev_active_slide_bg_video });
                      // console.log(prev_active_slide_bg_video);
                    } 
                    else if (prev_active_slide_bg_color !== 'undefined') {
                      $prev_arrow.find('.edge-nav-bg').show().css({ 'background-color': prev_active_slide_bg_color });
                      // console.log(prev_active_slide_bg_color);
                    }

                    if (typeof next_active_slide !== 'undefined') {
                        $next_arrow.find('.next-item-caption').show().text(next_active_slide);
                    } 

                    if (typeof next_active_slide_bg !== 'undefined' && next_active_slide_bg != "none") {
                      $next_arrow.find('.edge-nav-bg').show().css({ 'background-image': next_active_slide_bg });
                    } 
                    else if (typeof next_active_slide_bg_video !== 'undefined' && next_active_slide_bg_video != "none") {
                      $next_arrow.find('.edge-nav-bg').show().css({ 'background-image': next_active_slide_bg_video });
                    } 
                    else if (typeof next_active_slide_bg_color !== 'undefined') {
                      $next_arrow.find('.edge-nav-bg').show().css({ 'background-color': next_active_slide_bg_color });
                    }

                    if (!$('#mk-header').hasClass('transparent-header-sticky')) {
                        if ($first_el == 'true') {
                            $('#mk-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($slider_wrapper.find('.swiper-slide').eq(1).attr('data-header-skin') + '-header-skin');
                        }
                    }

                    if ($pagination === true) {
                        var currentSkin = $slider_wrapper.find('.swiper-slide').eq(1).attr("data-header-skin");
                        $('#' + $slider_wrapper.attr('id') + ' .mk-edge-nav a').attr('data-skin', currentSkin);
                        $($pagination_class).attr('data-skin', currentSkin);
                        $('#' + $slider_wrapper.attr('id') + ' .edge-skip-slider').attr('data-skin', currentSkin);

                        $($pagination_class).find('span').append('<a href="#"></a>');
                    }

                    if($nav.hasClass('nav-flip')) {
                        var slideNextNr = $('.slide-next-nr'),
                            slidePrevNr = $('.slide-prev-nr'),
                            slidesAll = $('.slides-all'),
                            slidesAllNr = swiper.slides.length - 2,
                            slideNext, 
                            slidePrev;

                        slidesAll.text(slidesAllNr);
                        slidePrevNr.text(slidesAllNr);
                        slideNextNr.text('2');
                    }

                } else {
                    $next_arrow.find('.next-item-caption').css('display', 'none');
                    $prev_arrow.find('.prev-item-caption').css('display', 'none');
                }

            },
            onSlideChangeEnd: function(swiper) {

                if (mk_detect_ie() == false) {

                    var currentSlide = $(mk_swiper.activeSlide()),
                        currentSkin = currentSlide.attr("data-header-skin");
                        $('#' + $slider_wrapper.attr('id') + ' .mk-edge-nav a').attr('data-skin', currentSkin);
                        $('#' + $slider_wrapper.attr('id') + ' .edge-skip-slider').attr('data-skin', currentSkin);
                        $($pagination_class).attr('data-skin', currentSkin);


                        var prev_active_slide = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex)).find('.edge-slide-content .mk-edge-title').text(),
                            next_active_slide = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex + 2)).find('.edge-slide-content .mk-edge-title').text();

                        var prev_active_slide_bg = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex)).css('background-image'),
                            next_active_slide_bg = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex + 2)).css('background-image');

                        var prev_active_slide_bg_video = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex)).find('.mk-video-section-touch').css('background-image'),
                            next_active_slide_bg_video = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex + 2)).find('.mk-video-section-touch').css('background-image');

                        var prev_active_slide_bg_color = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex)).css('background-color'),
                            next_active_slide_bg_color = $(mk_swiper.getSlide(mk_swiper.activeLoopIndex + 2)).css('background-color');

                        if (typeof prev_active_slide !== 'undefined') {
                            $prev_arrow.find('.prev-item-caption').show().text(prev_active_slide);
                            // console.log(prev_active_slide);
                        }

                        if (typeof prev_active_slide_bg !== 'undefined' && prev_active_slide_bg != "none") {
                          $prev_arrow.find('.edge-nav-bg').show().css({ 'background-image': prev_active_slide_bg });
                          // console.log(prev_active_slide_bg);
                        } 
                        else if (typeof prev_active_slide_bg_video !== 'undefined' && prev_active_slide_bg_video != "none") {
                          $prev_arrow.find('.edge-nav-bg').show().css({ 'background-image': prev_active_slide_bg_video });
                          // console.log(prev_active_slide_bg_video);
                        } 
                        else if (typeof prev_active_slide_bg_color !== 'undefined') {
                          $prev_arrow.find('.edge-nav-bg').show().css({ 'background-color': prev_active_slide_bg_color });
                          // console.log(prev_active_slide_bg_color);
                        }

                        if (typeof next_active_slide !== 'undefined') {
                            $next_arrow.find('.next-item-caption').show().text(next_active_slide);
                        } 

                        if (typeof next_active_slide_bg !== 'undefined' && next_active_slide_bg != "none") {
                          $next_arrow.find('.edge-nav-bg').show().css({ 'background-image': next_active_slide_bg });
                        } 
                        else if (typeof next_active_slide_bg_video !== 'undefined' && next_active_slide_bg_video != "none") {
                          $next_arrow.find('.edge-nav-bg').show().css({ 'background-image': next_active_slide_bg_video });
                        } 
                        else if (typeof next_active_slide_bg_color !== 'undefined') {
                          $next_arrow.find('.edge-nav-bg').show().css({ 'background-color': next_active_slide_bg_color });
                        }

                        if (!$('#mk-header').hasClass('transparent-header-sticky')) {
                            if ($first_el == 'true') {
                                $('#mk-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($(mk_swiper.getSlide(mk_swiper.activeLoopIndex + 1)).attr('data-header-skin') + '-header-skin');
                            }
                        }

                    var slideNextNr = $('.slide-next-nr'),
                        slidePrevNr = $('.slide-prev-nr'),
                        slidesAll = $('.slides-all'),
                        slidesAllNr = swiper.slides.length -2,
                        slideNext, 
                        slidePrev;

                    if( mk_swiper.activeLoopIndex == 0) {
                        slidePrev = slidesAllNr;
                    } else {
                        slidePrev = mk_swiper.activeLoopIndex;
                    }

                    if( mk_swiper.activeLoopIndex == slidesAllNr - 1) {
                        slideNext = 1;
                    } else {
                        slideNext = mk_swiper.activeLoopIndex + 2;
                    }

                    // console.log(swiper.slides.activeLoopIndex)


                    slidesAll.text(slidesAllNr);
                    slidePrevNr.text(slidePrev);
                    slideNextNr.text(slideNext);


                } else {
                    $next_arrow.find('.next-item-caption').css('display', 'none');
                    $prev_arrow.find('.prev-item-caption').css('display', 'none');
                }
            },
            onProgressChange: function(swiper){
                for (var i = 0; i < swiper.slides.length; i++){

                    var slide = swiper.slides[i];
                    var progress = slide.progress;

                    // SLIDER ANIMATION EFFECTS

                    if($animation == "vertical_slide") {
                        var translateX, translateY;

                            translateX = progress*swiper.width;
                            translateY = progress*edge_height;

                        swiper.setTransform(slide,'translate3d('+translateX+'px,'+ (-translateY) +'px,0)');
                    }

                    if($animation == "zoom") {
                        var scale, scaleContent, translate, opacity, zIndex;

                        if (progress<=0) {
                            opacity = 1 - Math.min(Math.abs(progress),1);
                            scale = 1 - Math.min(Math.abs(progress/12),1);
                            scaleContent = 1;
                            translate = progress*swiper.width;
                        }
                        else {
                            opacity = 1 - Math.min(Math.abs(progress/2),1);
                            scale = 1 + Math.min(Math.abs(progress/6),1);
                            translate = progress*swiper.width;
                        }
                            zIndex = (1 - Math.min(Math.abs(progress),1))*10;

                        slide.style.opacity = opacity;
                        swiper.setTransform(slide,'translate3d('+translate+'px,0,0) scale('+scale+')');
                        slide.style.zIndex = zIndex;
                    }

                    if($animation == "zoom_out") {
                        var scale, translateX, translateY, opacity, zIndex;

                            translateX = progress*swiper.width;

                        if (progress<=0) {
                            opacity = 1;
                            scale = 1;
                            zIndex = 1;
                            translateY = progress*edge_height;
                        }
                        else if (progress>0){
                            opacity = (1 - Math.min(Math.abs(progress),1))/2;
                            scale = 1 - Math.min(Math.abs(progress/2),1);
                            zIndex = 0;
                            translateY = 0;
                        }

                        swiper.setTransform(slide,'translate3d('+translateX+'px,'+ -translateY +'px,0)  scale('+scale+')');
                        slide.style.opacity = opacity;
                        slide.style.zIndex = zIndex;
                    }

                    if($animation == "fade") {
                        var translateX, opacity, zIndex;

                            translateX = progress*swiper.width;
                            opacity = 1 - Math.min(Math.abs(progress),1);
                            zIndex = (1 - Math.min(Math.abs(progress),1))*10;

                        swiper.setTransform(slide,'translate3d('+translateX+'px,0,0)');
                        slide.style.opacity = opacity;
                        slide.style.zIndex = zIndex;

                    }

                    if($animation == "horizontal_curtain") {
                        var translateX, zIndex, transitionTiming;
                            translateX = progress*swiper.width;

                        if (progress<=0) {
                            zIndex = 1;
                            translateX = 0;
                            transitionTiming = 'ease';
                        }
                        else if (progress>0){
                            zIndex = 0;
                            translateX = (progress*swiper.width)/2;
                            transitionTiming = 'ease';
                        }

                        swiper.setTransform(slide,'translate3d('+(translateX/2)+'px,0,0)');
                        slide.style.webkitTransitionTimingFunction = transitionTiming;
                        slide.style.zIndex = zIndex;
                    }

                    if($animation == "perspective_flip") {
                        var translateX, translateY, rotateX;

                            translateX = progress*swiper.width;
                            translateY = progress*edge_height;

                        if (progress>=0) {
                            rotateX = 0;
                        }
                        else if (progress<0){
                            rotateX = 70;
                        }

                        swiper.setTransform(slide,'translate3d('+translateX+'px,'+ (-translateY) +'px,0) rotateX('+rotateX+'deg)');
                    }

                }
              },
              onTouchStart:function(swiper){
                for (var i = 0; i < swiper.slides.length; i++){
                  swiper.setTransition(swiper.slides[i], 0);
                }
              },
              onSetWrapperTransition: function(swiper, speed) {
                for (var i = 0; i < swiper.slides.length; i++){
                  swiper.setTransition(swiper.slides[i], speed);
                }
              }



        });

        $prev_arrow.click(function(e) {
            mk_swiper.swipePrev();
            e.preventDefault();
        });

        $next_arrow.click(function(e) {
            mk_swiper.swipeNext();
            e.preventDefault();
        });


        //
        // PARALLAX
        //
        //////////////////////////////////////////////


        if ($slider_wrapper.parent().hasClass('mk-parallax') && !is_touch_device()) {
            var offset, translateValue,
                $parent = $slider_wrapper.parent(),
                height = $parent.outerHeight();

            scrollAnimations.add(function(scrollY) {
                offset = $parent.offset().top;
                translateValue = ((scrollY - offset + global_admin_bar_height) * .7);
                $slider_wrapper.css({'transform' : 'translateY(' + translateValue + 'px)'});
            });
        }

    });


}



function mk_edge_slider_resposnive() {


    $('.mk-edge-slider').each(function() {


        var $this = $(this),
            $containers = $this.find('.edge-slider-holder, .swiper-slide'),
            $height = $this.attr('data-height'),
            $fullHeight = $this.attr('data-fullHeight'),
            $header_height = 0,
            edge_full_height = 0;

        if ($.exists('#mk-header.sticky-header') && !$('#mk-header').hasClass('transparent-header') && !$('#mk-header').hasClass('header-structure-vertical') ) {
            var $header_height = parseInt($('#mk-header.sticky-header').attr('data-sticky-height'));
        }

        if ($fullHeight === 'true') {
            // global_window_height = global_window_height - $header_height - global_admin_bar_height; // after globalising it brought error probably because admin bar was not generated by here and was counted as 0
            edge_full_height = global_window_height - $header_height - global_admin_bar_height;
        } else {
            edge_full_height = $height;
        }


        $containers.css('height', edge_full_height);
        $this.css('height', edge_full_height);



        $this.find('.swiper-slide').each(function() {


            var $this = $(this),
                $content = $this.find('.edge-slide-content'),
                $holder = $this.find('.edge-content-holder');

            if ($this.hasClass('left_center') || $this.hasClass('center_center') || $this.hasClass('right_center')) {

                var $this_height_half = $content.outerHeight() / 2,
                    $window_half = edge_full_height / 2;

                $holder.css('marginTop', ($window_half - $this_height_half));
            }

            if ($this.hasClass('left_bottom') || $this.hasClass('center_bottom') || $this.hasClass('right_bottom')) {
                if(global_window_width > 960) {
                    var $distance_from_top = edge_full_height - $content.outerHeight() - 160;
                    $holder.css('marginTop', ($distance_from_top));    
                } else {
                    var $this_height_half = $content.outerHeight() / 2,
                    $window_half = edge_full_height / 2;

                    $holder.css('marginTop', ($window_half - $this_height_half));
                }
                
            }

        });

        $this.find('.edge-slider-loading').fadeOut();
    });

}



function mk_tab_slider() {

    $('.mk-tab-slider').each(function(i, val) {
        var $slider_wrapper = $(this),
            $slider_holder = $slider_wrapper.find('.edge-slider-holder'),
            $pause = $slider_wrapper.attr('data-pause'),
            $speed = $slider_wrapper.attr('data-speed'),
            $height = $slider_wrapper.attr('data-height'),
            $fullHeight = $slider_wrapper.attr('data-fullHeight'),
            content = $slider_wrapper.find('.mk-tab-slider-content')[0],
            $header_height = 0,
            edge_height = 0,
            content_height = $(content).height(),
            $pagination = $slider_wrapper.attr('data-pagination') == "true" ? true : false,
            $burger = $slider_wrapper.find('i'),
            $nav = $('.mk-tab-slider-pagination'),
            $menu_titles = $nav.find('.mk-tab-slider-menu-titles a');

        if ($pagination === true) {
            var $pagination_class = '#' + $slider_wrapper.attr('id') + ' .swiper-pagination';

            $($pagination_class).on('click', 'span', function(e){
              e.preventDefault();
              mk_swiper.swipeTo($(this).index(), 500);
            });

            } else {
            var $pagination_class = false;
        }

        // remove viewport animations from slider
        $slider_wrapper.find('.mk-animate-element').removeClass('mk-animate-element fade-in scale-up right-to-left left-to-right bottom-to-top top-to-bottom forthy-five-rotate');


        var animationDimensions = function() {
            if ($.exists('#mk-header') && !$('#mk-header').hasClass('header-structure-vertical')) {
                $header_height = parseInt($('#mk-header').attr('data-sticky-height'));
            }
            if ($fullHeight == 'true') {
                edge_height = global_window_height - $header_height - global_admin_bar_height;
            } else {
                edge_height = $height;
            }
            //console.log('edge_height: ' + edge_height);
        }
        animationDimensions();


        var dynamicHeight = true;
        function sliderHeight() {

            if($slider_wrapper.find('.swiper-slide-active').length) {
                content_height = $slider_wrapper.find('.swiper-slide-active').height();
            }

            var tab_content = $slider_wrapper.find('.mk-tab-slider-content')[0];
            //$tab_content_inner_height = $(tab_content).find('.mk-grid').height() - 300,
            

            $slider_wrapper.find('.mk-tab-slider-content').each(function() {
                var $this = $(this),
                $tab_holder_top_margin = ($slider_wrapper.height() - $this.height()) / 2;
                $this.css({
                    'paddingTop' : $tab_holder_top_margin
                });
            }); 


            if (global_window_width < 960) {
                $slider_wrapper.find('.mk-tab-slider-content').css({
                    'paddingTop' : 0,
                    'min-height' : 0
                });
            }
            
            if ($fullHeight == 'true') {
                $slider_wrapper.find('.mk-tab-slider-content').css({
                    'min-height' : edge_height + 'px'
                });
            }

            // console.log(content_height);
        } 
        

        var mk_swiper = $slider_wrapper.swiper({
            mode: 'horizontal',
            loop: true,
            grabCursor: false,
            useCSS3Transforms: true,
            mousewheelControl: false,
            pagination : $pagination_class,
            paginationClickable: true,
            freeModeFluid: true,
            calculateHeight: dynamicHeight, 
            speed: $speed,
            autoplay: $pause,
            simulateTouch: false,
            autoplayDisableOnInteraction: false,
            onSwiperCreated: function(swiper) {
                var currentSkin = $slider_wrapper.find('.swiper-slide').eq(1).attr("data-skin");
                $('.swiper-pagination').attr('data-skin', currentSkin);
                $($pagination_class).find('span').append('<a href="#"></a>');

                $slider_wrapper.find('.edge-slider-loading').fadeOut();
            },
            onSlideChangeEnd: function() {
                var currentSlide = $(mk_swiper.activeSlide()),
                    currentSkin = currentSlide.attr("data-skin");

                    $($pagination_class).attr('data-skin', currentSkin);
            }
        });

        sliderHeight();

        $(window).on('resize', function() {
            setTimeout(function() {
                sliderHeight();
                mk_swiper.reInit();
                // mk_swiper.params.calculateHeight = dynamicHeight;
            }, 200);
        });

    });
}
;
/* Swipe Slideshow */
/* -------------------------------------------------------------------- */


function mk_swipe_slider() {

    $('.mk-swiper-slider').each(function() {
        var $this = $(this);

        if(!(window.matchMedia("(max-width: 650px)").matches && $this.hasClass('mk-portfolio-scroller'))) {

            if($this.data('state') != 'init') {

                $this.data('state', 'init');
            

            var $thumbs = $this.parent().siblings('.gallery-thumbs-small'),
                $next_arrow = $this.find('.mk-swiper-next'),
                $prev_arrow = $this.find('.mk-swiper-prev'),
                $direction = $this.attr('data-direction'),
                $pagination = $this.attr('data-pagination') === "true" ? true : false,
                $slideshowSpeed = $this.attr('data-slideshowSpeed'),
                $animationSpeed = $this.attr('data-animationSpeed'),
                $animation = $this.attr('data-animation'),
                //$controlNav = $this.attr('data-controlNav') === "true" ? true : false,
                //$directionNav = $this.attr('data-directionNav') === "true" ? true : false,
                $freeModeFluid = $this.attr('data-freeModeFluid') === "true" ? true : false,
                $freeMode = $this.attr('data-freeMode') === "true" ? true : false,
                $mousewheelControl = $this.attr('data-mousewheelControl') === "true" ? true : false,
                $loop = $this.attr('data-loop') === "true" ? true : false,
                $autoplayStop = $this.attr('data-autoplayStop') === "false" ? false : true,
                $slidesPerView = $this.attr('data-slidesPerView');

            if ($pagination === true) {
                var $pagination_class = '#' + $this.attr('id') + ' .swiper-pagination';
            } else {
                var $pagination_class = false;
            }
            


            var mk_swiper = $(this).swiper({
                mode: $direction,
                loop: $loop,
                freeMode: $freeMode,
                pagination: $pagination_class,
                freeModeFluid: $freeModeFluid,
                autoplay: $slideshowSpeed,
                speed: $animationSpeed,
                calculateHeight: true,
                grabCursor: true,
                progress: true,
                //useCSS3Transforms: false,
                //mousewheelControl: $mousewheelControl,
                mousewheelControl: true,
                mousewheelControlForceToAxis: true,
                paginationClickable: true,
                slidesPerView: $slidesPerView,
                autoplayDisableOnInteraction: $autoplayStop,
                onSwiperCreated: function(swiper) {
                    mk_lightbox_init();
                },
                onSlideChangeStart: function() {
                    $thumbs.find('.active-item').removeClass('active-item');
                    $thumbs.find('a').eq(mk_swiper.activeIndex).addClass('active-item');
                },
                onProgressChange: function(swiper){
                    for (var i = 0; i < swiper.slides.length; i++){

                        var slide = swiper.slides[i];
                        var progress = slide.progress;

                        if($animation == "fade") {
                            var translateX, opacity, zIndex;

                                translateX = progress*swiper.width;
                                opacity = 1 - Math.min(Math.abs(progress),1);
                                zIndex = (1 - Math.min(Math.abs(progress),1))*10;

                            swiper.setTransform(slide,'translate3d('+translateX+'px,0,0)');
                            slide.style.opacity = opacity;
                            slide.style.zIndex = zIndex;

                        }

                    }
                  },
                  onTouchStart:function(swiper){
                    for (var i = 0; i < swiper.slides.length; i++){
                      swiper.setTransition(swiper.slides[i], 0);
                    }
                  },
                  onSetWrapperTransition: function(swiper, speed) {
                    for (var i = 0; i < swiper.slides.length; i++){
                      swiper.setTransition(swiper.slides[i], speed);
                    }
                  }
            });


            $prev_arrow.click(function(e) {
                mk_swiper.swipePrev();
                e.preventDefault();
            });

            $next_arrow.click(function(e) {
                mk_swiper.swipeNext();
                e.preventDefault();
            });



            $thumbs.find('a').on('touchstart mousedown', function(e) {
                e.preventDefault();
                $thumbs.find('.active-item').removeClass('active-item');
                $(this).addClass('active-item');
                mk_swiper.swipeTo($(this).index());
            });

            $thumbs.find('a').click(function(e) {
                e.preventDefault();
            });

            }

        } else {
            $this.addClass('scroller-disabled');
        }

    });

}


function mk_gallery_thumbs_width() {

    $('.mk-gallery.thumb-style .gallery-thumbs-small').each(function() {

        var $this = $(this),
            $thumbs_count = $this.children().length,
            $thumbs_width = $thumbs_count * $this.find('a').outerWidth(),
            $container_width = $this.siblings('.gallery-thumb-large').outerWidth();

        if ($thumbs_width > $container_width) {
            $this.find('a').css('width', 100 / $thumbs_count + '%');
        }
    });
};
/* Section Background Parallax Effects */
/* -------------------------------------------------------------------- */

function mk_section_parallax() {
    if (is_touch_device() || global_window_width < 800) {
        return false;
    }
    $('.mk-page-section.parallax-true').each(function() {

        var $this = $(this),
            $direction = $this.attr('data-direction'),
            $speedFactor = $this.attr('data-speedFactor');

        if ($direction === 'horizontal_mouse' || $direction === 'vertical_mouse' || $direction === 'both_axis_mouse') {

            var $yparallax = $this.attr('data-direction') === "vertical_mouse" ? true : false,
                $xparallax = $this.attr('data-direction') === "horizontal_mouse" ? true : false,
                $xyparallax = $this.attr('data-direction') === "both_axis_mouse" ? true : false;

            if ($xyparallax === true) {
                $xparallax = true;
                $yparallax = true;
            }


            $(this).find('.parallax-layer').parallax({
                mouseport: $this,
                yparallax: $yparallax,
                xparallax: $xparallax,
                decay: 0.8,
                frameDuration: 50
            });

        } else {

            // var mk_skrollr = skrollr.init({
            //     forceHeight: false,
            //     mobileCheck: function() {
            //         return false;
            //     }
            // });
            // mk_skrollr.refresh($('.mk-page-section')); 

            var $this = $(this),
                $offset = $this.offset(),
                $speed_factor = 0.16;

         
                if($offset.top > global_window_height) {
                    $speed_factor = 0.2;
                } else {
                    $speed_factor = -0.2;
                }

            if ($direction == 'vertical') $this.parallaxScroll("50%", $speed_factor, 'vertical');
            if ($direction == 'horizontal') $this.parallaxScroll("50%", 0.3, 'horizontal');
        }

    });

}


/*
function mk_image() {

    $('.mk-image').each(function() {
        var $this = $(this),
            width = $this.outerWidth(),
            caption_h = $this.find('.mk-image-hover').outerHeight(),
            caption_w = width - 40;

            //console.log(caption_h);

        $this.find('.mk-image-hover').css({
            'width': caption_w,
            'margin-top': -(caption_h / 2),
            'margin-left': -(caption_w / 2)
        });
    });
}
*/

function mk_center_caption() {
    $('.mk-parent-element').each(function() {
        var $this = $(this),
            width = $this.outerWidth(),
            caption_h = $this.find('.mk-caption-item').outerHeight(),
            caption_w = width - 120;

        $this.find('.mk-caption-item').css({
            'width': caption_w,
            'margin-top': -(caption_h / 2),
            'margin-left': -(caption_w / 2)
        });
    });
}



function mk_portfolio_image() {

    $('.mk-portfolio-item').each(function() {
        var $this = $(this),
            width = $this.outerWidth(),
            caption_h = $this.find('.portfolio-meta').outerHeight(),
            caption_w = (width > 300) ? (width - 100) : (width - 20);



        $this.find('.portfolio-meta').css({
            'width': caption_w,
            'margin-top': -(caption_h / 2),
            'margin-left': -(caption_w / 2)
        }); 
        // console.log("I'm centering .portfolio-meta from mk_portfolio_image()");

        var logo = $(this).find('.portfolio-entry-logo'),
            logo_width = logo.width(),
            logo_height = logo.height();

        logo.css({
            'margin-left': -logo_width / 2,
            'margin-top': -logo_height / 2
        });


    });

}


function mk_employees() {

    $('.mk-employees.grid-style .mk-employee-item').each(function() {
        var $this = $(this),
            height = $this.outerHeight();
        $this.find('.team-info-wrapper').css({
            'height': height
        });
    });

}


function mk_gallery_image() {

    $('.mk-gallery-item').each(function() {
        var $this = $(this),
            width = $this.outerWidth(),
            caption_h = $this.find('.gallery-meta').outerHeight(),
            caption_w;

        if (width < 200) {
            caption_w = width;
        } else {
            caption_w = width - 100;
        }
        /*$this.find('.gallery-meta').css({
            'width': caption_w,
            'margin-top': -(caption_h / 2),
            'margin-left': -(caption_w / 2)
        });*/


    });

}

/*function mk_portfolio_masonry() {

    $('.masonry-portfolio-item').each(function() {

        var $this = $(this),
            item_height = $this.parent().find('.regular-entry').outerHeight();

        if ($this.hasClass('tall-entry') || $this.hasClass('wide-tall-entry')) {

            $this.css('height', item_height * 2 + 'px');
            $this.find('.featured-image').css('height', item_height * 2 + 'px');

        } else if ($this.hasClass('wide-entry')) {

            $this.css('height', item_height + 'px');
            $this.find('.featured-image').css('height', item_height + 'px');

        }

    });

}*/


function mk_portfolio_hovers() {

    $('.masonry-portfolio-item, .grid-portfolio-item, .mk-portfolio-scroller .mk-portfolio-item .item-holder').each(function() {
        var $this = $(this);

        $this.hover(function() {
            var bordersY = new TimelineLite();
                bordersY.set($this.find('.border-tb, .border-bt'), { opacity: 1 })
                        .to($this.find('.border-tb, .border-bt'), 1.2, { scaleY: 1, ease: Power4.easeInOut });
            var bordersX = new TimelineLite();
                bordersX.set($this.find('.border-bl, .border-tr'), { opacity: 1 })
                        .to($this.find('.border-bl, .border-tr'), 1.2, { scaleX: 1, ease: Power4.easeInOut });

        }, function() {
            var bordersY = new TimelineLite();
                bordersY.to($this.find('.border-tb, .border-bt'), .8, { scaleY: 0, ease: Power4.easeInOut })
                .set($this.find('.border-tb, .border-bt'), { opacity: 0 });
            var bordersX = new TimelineLite();
                bordersX.to($this.find('.border-bl, .border-tr'), .8, { scaleX: 0, ease: Power4.easeInOut })
                .set($this.find('.border-bl, .border-tr'), { opacity: 0 });
        });

    });


    /* Portfolio parallax */
    /* -------------------------------------------------------------------- */

    $('.mk-portfolio-item.parallax-hover .item-holder').each(function() {

        var $parallaxContainer = $(this); //our container
        var $parallaxItem = $parallaxContainer.find(".item-featured-image"); 
        var fixer = -0.004;     //experiment with the value
        var speedX = 50;                 
        var speedY = 50;

        $parallaxContainer.on("mousemove", function(event){  
            var position = $parallaxContainer.offset();                      
            var pageX =  (event.clientX - position.left) - ($parallaxContainer.width() * 0.5);  
            var pageY =  (event.pageY - position.top) - ($parallaxContainer.height() * 0.5); 
                
            TweenLite.to($parallaxItem, 1, { scale: 1.2 }); 
            TweenLite.to($parallaxItem, 1, {
                x: (pageX * speedX)*fixer,     
                y: (pageY * speedY)*fixer
              
            });  
        });     

        $parallaxContainer.on("mouseleave", function() {
            TweenLite.to($parallaxItem, .5, { x: 0, y: 0, scale: 1 });
        });

    });


};

/* Tabs */
/* -------------------------------------------------------------------- */

function mk_tabs() {
    if ($.exists('.mk-tabs')) {
        $(".mk-tabs").tabs();

        $('.mk-tabs').on('click', function () {
	      $('.mk-theme-loop').isotope('reLayout');
	    });

        $('.mk-tabs.vertical-style').each(function() {
            var $this = $(this),
                inner_pane = $this.find('.inner-box'),
                tabs_height = $(this).find('.mk-tabs-tabs').height() + 80;
            inner_pane.css('minHeight', tabs_height);
        });
    }
}
function mk_tabs_responsive(){
  if ($.exists('.mk-tabs')) {
    if (window.matchMedia('(max-width: 767px)').matches){
        $(".mk-tabs").tabs("destroy");
    }
  }
}
;/* Blog, Portfolio Audio */
/* -------------------------------------------------------------------- */

function loop_audio_init() {
    if ($.exists('.jp-jplayer')) {
        $('.jp-jplayer.mk-blog-audio').each(function() {
            var css_selector_ancestor = "#" + $(this).siblings('.jp-audio').attr('id');
            var ogg_file, mp3_file, mk_theme_js_path;
            ogg_file = $(this).attr('data-ogg');
            mp3_file = $(this).attr('data-mp3');
            $(this).jPlayer({
                ready: function() {
                    $(this).jPlayer("setMedia", {
                        mp3: mp3_file,
                        ogg: ogg_file
                    });
                },
                play: function() { // To avoid both jPlayers playing together.
                    $(this).jPlayer("pauseOthers");
                },
                swfPath: mk_theme_js_path,
                supplied: "mp3, ogg",
                cssSelectorAncestor: css_selector_ancestor,
                wmode: "window"
            });
        });
    }
}


/* Ajax portfolio */
/* -------------------------------------------------------------------- */
function mk_portfolio_ajax() {

    $('.portfolio-grid.portfolio-ajax-enabled').ajaxPortfolio();
};/* Initialize isiotop  */
/* -------------------------------------------------------------------- */

function loops_iosotop_init() {

    $('.loop-main-wrapper').each(function() {
        var $this = $(this),
            $mk_container = $this.find('.mk-theme-loop'),
            $mk_container_item = '.' + $mk_container.attr('data-style') + '-' + $mk_container.attr('data-uniqid'),
            $load_button = $this.find('.mk-loadmore-button'),
            $pagination_items = $this.find('.mk-pagination');

        if ($mk_container.hasClass('isotop-enabled')) {

            $mk_container.isotope({
                itemSelector: $mk_container_item,
                animationEngine: "best-available",
                masonry: {
                    columnWidth: 1
                }

            });
        }


        $('.mk-isotop-filter').on('click', 'a', function() {
            var $this;
            $this = $(this);

            /* Removes ajax container when filter items get triggered */
            // $this.parents('.portfolio-grid').find('.ajax-container').animate({
            //     'height': 0,
            //     opacity: 0
            // }, 500);
            TweenLite.to($this.parents('.portfolio-grid').find('.ajax-container'), .5, { height: 0, opacity: 0 });

            if ($this.hasClass('.current')) {
                return false;
            } 
            var $optionSet = $this.parents('.mk-isotop-filter ul');
            $optionSet.find('.current').removeClass('current');
            $this.addClass('current');

            var selector = $(this).attr('data-filter');

            $mk_container.isotope({
                filter: ''
            });
            $mk_container.isotope({
                filter: selector
            });


            return false;
        });



        $load_button.hide();

        if ($this.find('.mk-theme-loop').hasClass('scroll-load-style') || $this.find('.mk-theme-loop').hasClass('load-button-style')) {
            if ($pagination_items.length > 0) {
                $load_button.css('display', 'block');
            }
            $pagination_items.hide();


            $load_button.on('click', function() {
                if (!$(this).hasClass('pagination-loading')) {
                    $(this).addClass('pagination-loading');
                }

            });

            $mk_container.infinitescroll({
                    navSelector: $pagination_items,
                    nextSelector: $this.find('.mk-pagination a:first'),
                    itemSelector: $mk_container_item,
                    bufferPx: 70,
                    loading: {
                        finishedMsg: "",
                        msg: null,
                        msgText: "",
                        selector: $load_button,
                        speed: 300,
                        start: undefined
                    },
                    errorCallback: function() {

                        $load_button.html(mk_no_more_posts).addClass('disable-pagination');

                    },

                },

                function(newElements) {

                    var $newElems = $(newElements);
                    $newElems.imagesLoaded(function() {
                        $load_button.removeClass('pagination-loading');

                        $mk_container.isotope('appended', $newElems);
                        $mk_container.isotope({
                            filter: ''
                        });
                        var selected_item = $('.mk-isotop-filter ul').find('.current').attr('data-filter');
                        $mk_container.isotope({
                            filter: selected_item
                        });

                        $mk_container.isotope('reLayout');
                        loop_audio_init();
                        mk_lightbox_init();
                        mk_portfolio_image();
                        mk_gallery_image();
                        mk_swipe_slider();
                        mk_portfolio_ajax();
                        mk_center_caption();
                    });
                }

            );



            /* Loading elements based on scroll window */
            if ($this.find('.mk-theme-loop').hasClass('load-button-style')) {
                $(window).unbind('.infscr');
                $load_button.click(function() {

                    $mk_container.infinitescroll('retrieve');

                    return false;

                });
            }

        } else {
            $load_button.hide();
        }
    });
}
;
/* Fix isotop layout */
/* -------------------------------------------------------------------- */

function isotop_load_fix() {
    if ($.exists('.mk-blog-container') || $.exists('.mk-portfolio-container')) {
        $('.mk-blog-container>article, .mk-portfolio-container>article').each(function(i) {
            $(this).delay(i * 100).animate({
                'opacity': 1
            }, 100);

        }).promise().done(function() {
            $('.mk-theme-loop').isotope('reLayout');
        });
    }

}
;
/* Event Count Down */
/* -------------------------------------------------------------------- */

function mk_event_countdown() {
    if ($.exists('.mk-event-countdown')) {
        $('.mk-event-countdown').each(function() {
            var $this = $(this),
                $date = $this.attr('data-date'),
                $offset = $this.attr('data-offset');

            $this.downCount({
                date: $date,
                offset: $offset
            });
        });
    }
};
/* Instagram Feed */
/* -------------------------------------------------------------------- */

function mk_instagram() {
    if ($.exists('.mk-instagram-feeds')) {

        $('.mk-instagram-feeds').each(function() {
            var $this = $(this),
                $size = $this.attr('data-size'),
                $sort_by = $this.attr('data-sort'),
                $count = $this.attr('data-count'),
                $userid = parseInt($this.attr('data-userid')),
                $access_token = $this.attr('data-accesstoken'),
                $column = $this.attr('data-column'),
                $id = $this.attr('id');



            var feed = new Instafeed({
                get: "user",
                target: $id,
                resolution: $size,
                sortBy: $sort_by,
                limit: $count,
                userId: $userid,
                accessToken: $access_token,
                template: '<a class="featured-image ' + $column + '-columns" href="{{link}}"><div class="item-holder"><img src="{{image}}" /><div class="hover-overlay"></div></div></a>'
            });
            feed.run();
        });
    }
};/* Accordions */

function mk_accordion() {

    if ($.exists('.mk-accordion')) {
        $(".mk-accordion").each(function() {
            if (window.matchMedia('(max-width: 767px)').matches){

            }else{
                var $this = $(this),
                accordion_section = $this.find('.mk-accordion-single'),
                all_panes = $this.find('.mk-accordion-pane').hide();

                accordion_section.first().addClass('current-item').find('.mk-accordion-pane').slideDown(300);


                $this.find('.mk-accordion-tab').click(function() {
                    var $this = $(this),
                        $this_item = $this.parent();
                    if (!($this_item.hasClass('current-item'))) {
                        $this_item.siblings().removeClass('current-item').end().addClass('current-item');
                        all_panes.slideUp(300);
                        $this.parent().children('.mk-accordion-pane').slideDown(300);
                    }
                    return false;
                });
            }
        });
    }

    /* Toggles */

    if ($.exists('.mk-toggle-title')) {
        if (window.matchMedia('(max-width: 767px)').matches){
            $('.mk-toggle-title').next().css('display', 'block');
        }else{
            $(".mk-toggle-title").toggle(
                function() {
                    $(this).addClass('active-toggle');
                    $(this).siblings('.mk-toggle-pane').slideDown("fast");
                },

                function() {
                    $(this).removeClass('active-toggle');
                    $(this).siblings('.mk-toggle-pane').slideUp("fast");
                }
            );   
        }
    }
}
;/* Social Share */
/* -------------------------------------------------------------------- */

function mk_social_share() {


    $('.twitter-share').on('click', function() {
        var $url = $(this).attr('data-url'),
            $title = $(this).attr('data-title');

        window.open('http://twitter.com/intent/tweet?text=' + $title + ' ' + $url, "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.pinterest-share').on('click', function() {
        var $url = $(this).attr('data-url'),
            $title = $(this).attr('data-title'),
            $image = $(this).attr('data-image');
        window.open('http://pinterest.com/pin/create/button/?url=' + $url + '&media=' + $image + '&description=' + $title, "twitterWindow", "height=320,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.facebook-share').on('click', function() {
        var $url = $(this).attr('data-url');
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + $url, "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.googleplus-share').on('click', function() {
        var $url = $(this).attr('data-url');
        window.open('https://plus.google.com/share?url=' + $url, "googlePlusWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.linkedin-share').on('click', function() {
        var $url = $(this).attr('data-url');
        var $title = $(this).attr('data-title');
        window.open('http://www.linkedin.com/shareArticle?mini=true&url='+ $url +'&title=' + $title , "linkedinWindow", "height=520,width=570,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });
};/* Typer */
/* -------------------------------------------------------------------- */
function mk_text_typer() {
    $('[data-typer-targets]').each(function() {
        var $this = $(this),
            $first_string = [$this.text()],
            $rest_strings = $this.attr('data-typer-targets').split(','),
            $strings = $first_string.concat($rest_strings);

        $this.text('');

        $this.typed({
            strings: $strings,
            typeSpeed: 30, // typing speed
            backDelay: 1200, // pause before backspacing
            loop: true, // loop on or off (true or false)
            loopCount: false, // number of loops, false = infinite
        });
    });
}

;/* Process Steps */
/* -------------------------------------------------------------------- */

function mk_process_steps() {
    if ($.exists('.mk-process-steps.horizontal')) {

        $('.mk-process-steps.horizontal').each(function() {

            var $this = $(this),
                $tabs = $this.find('.step-items'),
                $panes = $this.find('.step-panes');

            $tabs.find('li').first().addClass('active-step-item');

            $panes.css('height', $panes.find('.mk-step').first().outerHeight() + 30);
            $panes.find('.mk-step').first().addClass('active-step');


            $tabs.find('span').hoverIntent(function() {
                var $this_id = $(this).attr('data-id'),
                    $this_pane = $panes.find('div[id^="' + $this_id + '"]'),
                    $pane_height = $this_pane.outerHeight() + 30;

                $(this).parent().siblings('li').removeClass('active-step-item').end().addClass('active-step-item');

                $panes.css('height', $pane_height);
                $panes.find('.mk-step').removeClass('active-step');
                $this_pane.addClass('active-step');
            });


        });

    }
}
;/* Page Section full height feature */
/* -------------------------------------------------------------------- */

function section_to_full_height() {

    $('.full-height-true.mk-page-section').each(function() {
        var $this = $(this),
            $content_height = $this.find('.page-section-content').outerHeight();

        if ($.exists("#mk-header") && !$('#mk-header').hasClass('header-structure-vertical') && !$('#mk-header').hasClass('transparent-header')) {
            if ($('#mk-header').hasClass('sticky-trigger-header')) {
                var mk_header = parseInt($("#mk-header").attr('data-sticky-height'));
            } else {
                var mk_header = parseInt($("#mk-header").attr('data-height'));
            }

        } else {
            var mk_header = 0;
        }
        //console.log(global_admin_bar_height + " " + mk_header);

        var window_height = global_window_height - global_admin_bar_height - mk_header;


        if ($content_height > global_window_height) {
            $this.css('height', 'auto');
            $this.find('.page-section-content').css({
                'padding-top': 30,
                'padding-bottom': 30
            });
        } else {
            $this.css('height', window_height);

            var $this_height_half = $this.find('.page-section-content').outerHeight() / 2,
                $window_half = window_height / 2;

            $this.find('.page-section-content').css('marginTop', ($window_half - $this_height_half));
        }

        $this.find('.mk-page-section-loader').fadeOut();

    });
   
}



/* Page Section Intro Effects */
/* -------------------------------------------------------------------- */

function mk_section_intro_effects() {
  if ( !is_touch_device() ) {
    if($.exists('.mk-page-section.intro-true')) {

      $('.mk-page-section.intro-true').each(function() {
          var $this = $(this),
              // pageCnt = $('.theme-page-wrapper'),
              $pageCnt = $this.nextAll('div'),
              windowHeight = $(window).height(),
              effectName = $this.attr('data-intro-effect'),
              $header = $('#mk-header'),
              header_height = 0;

          if ($header.length && !$('#mk-header').hasClass('header-structure-vertical')) {
              header_height += parseInt($header.attr('data-sticky-height')) + 50;
          }


          var effect = {
              fade :    new TimelineLite({paused: true})
                        .set($pageCnt, { opacity: 0, y: (windowHeight * 0.3) })
                        .set($pageCnt.first(), { paddingTop: header_height })
                        .to($this, 1, { opacity: 0, ease:Power2.easeInOut })
                        .set($this, { display: "none" })
                        .to($pageCnt, 1, { opacity: 1, y: 0, ease:Power2.easeInOut}, "-=.7"),

              zoom_out :  new TimelineLite({paused: true})
                        .set($pageCnt, { opacity: 0, y: (windowHeight * 0.3) })
                        .set($pageCnt.first(), { paddingTop: header_height })
                        .to($this, 1.5, { opacity: .8, scale: 0.8, y: -windowHeight - 100, ease:Strong.easeInOut })
                        .set($this, { display: "none" })
                        .to($pageCnt, 1.5, { opacity: 1, y: 0, ease:Strong.easeInOut}, "-=1.3"),

              shuffle : new TimelineLite({paused: true})
                        .to($this, 1.5, { y: -windowHeight/2, ease:Strong.easeInOut })
                        .to($this.nextAll('div').first(), 1.5, { paddingTop: windowHeight/2, ease:Strong.easeInOut }, "-=1.3")
          }

          $this.sectiontrans({
            effect : effectName,
          });

          $('body').on('page_intro', function() {
            effect[effectName].play();
          });

          $('body').on('page_outro', function() {
            effect[effectName].reverse();
          });

      });
    }
  } else {
    $('.mk-page-section.intro-true').each(function() {
      $(this).attr('data-intro-effect', '');
    });
  }
};
/* Expandable Page Sections */
/* -------------------------------------------------------------------- */

function mk_expandable_page_section() {



    $('.section-expandable-true').each(function() {

        var $container = $(this).find('.mk-padding-wrapper').hide();

        $(this).on('click', function() {
            var $this = $(this);
            if (!$this.hasClass('active-toggle')) {
                 $this.addClass('active-toggle');
                $container.slideDown(500);
            }
            setTimeout(function() {
                //mk_image();
                mk_lightbox_init();
            }, 1000);
        });

    });


    $(".section-expandable-true").on('click', function(event) {
        if (event.stopPropagation) {
          event.stopPropagation();
        } else if (window.event) {
          window.event.cancelBubble = true;
        }
    });

    $('body').on('click', function() {
        $('.section-expandable-true').removeClass('active-toggle');
        $('.section-expandable-true .mk-padding-wrapper').slideUp(400);
    });

}
;

/* Flickr Feeds */
/* -------------------------------------------------------------------- */

function mk_flickr_feeds() {

    $('.mk-flickr-feeds').each(function() {
        var $this = $(this),
            apiKey = $this.attr('data-key'),
            userId = $this.attr('data-userid'),
            perPage = $this.attr('data-count');

        jQuery.getJSON('https://api.flickr.com/services/rest/?format=json&method=' + 'flickr.photos.search&api_key=' + apiKey + '&user_id=' + userId + '&&per_page=' + perPage + '&jsoncallback=?', function(data) {

            jQuery.each(data.photos.photo, function(i, rPhoto) {
                var basePhotoURL = 'http://farm' + rPhoto.farm + '.static.flickr.com/' + rPhoto.server + '/' + rPhoto.id + '_' + rPhoto.secret;

                var thumbPhotoURL = basePhotoURL + '_q.jpg';
                var mediumPhotoURL = basePhotoURL + '.jpg';

                var photoStringStart = '<a ';
                var photoStringEnd = 'title="' + rPhoto.title + '" rel="flickr-feeds" class="mk-lightbox featured-image" href="' + mediumPhotoURL + '"><img src="' + thumbPhotoURL + '" alt="' + rPhoto.title + '"/><div class="hover-overlay"></div></a>;';
                var photoString = (i < perPage) ? photoStringStart + photoStringEnd : photoStringStart + photoStringEnd;

                jQuery(photoString).appendTo($this);
            });
        });
    });

}
mk_flickr_feeds();
;
/* Flexslider init */
/* -------------------------------------------------------------------- */

function mk_flexslider_init() {


    $('.mk-flexslider.mk-script-call').each(function() {

        if ($(this).parents('.mk-tabs').length || $(this).parents('.mk-accordion').length) {
            $(this).removeData("flexslider");
        }


        var $this = $(this),
            $selector = $this.attr('data-selector'),
            $animation = $this.attr('data-animation'),
            $easing = $this.attr('data-easing'),
            $direction = $this.attr('data-direction'),
            $smoothHeight = $this.attr('data-smoothHeight') == "true" ? true : false,
            $slideshowSpeed = $this.attr('data-slideshowSpeed'),
            $animationSpeed = $this.attr('data-animationSpeed'),
            $controlNav = $this.attr('data-controlNav') == "true" ? true : false,
            $directionNav = $this.attr('data-directionNav') == "true" ? true : false,
            $pauseOnHover = $this.attr('data-pauseOnHover') == "true" ? true : false,
            $isCarousel = $this.attr('data-isCarousel') == "true" ? true : false;

        if ($selector != undefined) {
            var $selector_class = $selector;
        } else {
            var $selector_class = ".mk-flex-slides > li";
        }

        if ($isCarousel == true) {
            var $itemWidth = parseInt($this.attr('data-itemWidth')),
                $itemMargin = parseInt($this.attr('data-itemMargin')),
                $minItems = parseInt($this.attr('data-minItems')),
                $maxItems = parseInt($this.attr('data-maxItems')),
                $move = parseInt($this.attr('data-move'));
        } else {
            var $itemWidth = $itemMargin = $minItems = $maxItems = $move = 0;
        }

        $this.flexslider({
            selector: $selector_class,
            animation: $animation,
            easing: $easing,
            direction: $direction,
            smoothHeight: $smoothHeight,
            slideshow: true,
            slideshowSpeed: $slideshowSpeed,
            animationSpeed: $animationSpeed,
            controlNav: $controlNav,
            directionNav: $directionNav,
            pauseOnHover: $pauseOnHover,
            prevText: "",
            nextText: "",

            itemWidth: $itemWidth,
            itemMargin: $itemMargin,
            minItems: $minItems,
            maxItems: $maxItems,
            move: $move,
        });

    });

}

function mk_fade_onload() {

    $(".mk-mobile-image").fadeIn();
    $(".mk-tablet-image").fadeIn();
}
;/* Edge One Pager */
/* -------------------------------------------------------------------- */
function mk_one_page_scroller() {
    $('.mk-edge-one-pager').each(function() {

        var $this = $(this),
            $tooltip_txt = [],
            $navigation = $this.attr('data-navigation') == "true" ? true : false;


        $this.find('.section').each(function() {
            $tooltip_txt.push($(this).attr('data-title'));
        });

        $this.fullpage({
            verticalCentered: false,
            resize: true,
            slidesColor: ['#ccc', '#fff'],
            anchors: $tooltip_txt,
            scrollingSpeed: 600,
            easing: 'easeInQuart',
            menu: false,
            navigation: $navigation,
            navigationPosition: 'right',
            navigationTooltips: false,
            slidesNavigation: true,
            slidesNavPosition: 'bottom',
            loopBottom: false,
            loopTop: false,
            loopHorizontal: true,
            autoScrolling: true,
            scrollOverflow: false,
            css3: true,
            paddingTop: 0,
            paddingBottom: 0,
            fixedElements: '#element1, .element2',
            normalScrollElements: '#element1, .element2',
            normalScrollElementTouchThreshold: 5,
            keyboardScrolling: true,
            touchSensitivity: 15,
            continuousVertical: false,
            animateAnchor: true,

            //events
            onLeave: function(index, nextIndex, direction) {
                //console.log(nextIndex - 1);
                //console.log($this.find('.one-pager-slide').eq(nextIndex - 1).attr('data-header-skin'));

                if (!$('#mk-header').hasClass('transparent-header-sticky')) {
                    $('#mk-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($this.find('.one-pager-slide').eq(nextIndex - 1).attr('data-header-skin') + '-header-skin');

                    $('#fullPage-nav').removeClass('light-skin dark-skin').addClass($this.find('.one-pager-slide').eq(nextIndex - 1).attr('data-header-skin') + '-skin');
                }

            },
            afterLoad: function(anchorLink, index) {

            },
            afterRender: function() {
                if (!$('#mk-header').hasClass('transparent-header-sticky')) {
                    setTimeout(function() {
                        $('#mk-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($this.find('.one-pager-slide').eq(0).attr('data-header-skin') + '-header-skin');
                        $('#fullPage-nav').removeClass('light-skin dark-skin').addClass($this.find('.one-pager-slide').eq(nextIndex - 1).attr('data-header-skin') + '-skin');
                    }, 300);
                }

            },
            afterResize: function() {},
            afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex) {



            },
            onSlideLeave: function(anchorLink, index, slideIndex, direction) {

            } // You can now define the direction of the One Page Scroll animation. Options available are "vertical" and "horizontal". The default value is "vertical".  
        });
    });
}


function mk_one_pager_resposnive() {


    $('.mk-edge-one-pager').each(function() {
        var $this = $(this),
            $header_height = 0;

        if ($.exists('#mk-header.sticky-header') && !$('#mk-header').hasClass('transparent-header')) {
            var $header_height = parseInt($('#mk-header.sticky-header').attr('data-sticky-height'));
        }

        var global_window_height = $(window).height() - $header_height - global_admin_bar_height;


        $this.find('.one-pager-slide').each(function() {
            var $this = $(this),
                $content = $this.find('.edge-slide-content');

            if ($this.hasClass('left_center') || $this.hasClass('center_center') || $this.hasClass('right_center')) {

                var $this_height_half = $content.outerHeight() / 2,
                    $window_half = global_window_height / 2;

                $content.css('marginTop', ($window_half - $this_height_half));
            }

            if ($this.hasClass('left_bottom') || $this.hasClass('center_bottom') || $this.hasClass('right_bottom')) {

                var $distance_from_top = global_window_height - $content.outerHeight() - 90;

                $content.css('marginTop', ($distance_from_top));
            }

        });
    });

}
;
var equalheight = function(container){ 

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPosition = $el.position().top;

   if (currentRowStart != topPosition) {
     for (var currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPosition;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

/* Animated Columns */
    /* -------------------------------------------------------------------- */
    function mk_animated_columns() {

        function prepareCols() {

            equalheight('.vc_row .animated-column-title');
            equalheight('.vc_row .animated-column-desc');

            $('.mk-animated-columns').each(function() {
                var $this = $(this);

                if ($this.hasClass('full-style')) {
                    $this.find('.animated-column-item').each(function() {
                        var $this = $(this),
                            contentHeight = $this.find('.animated-column-icon').innerHeight() + $this.find('.animated-column-title').innerHeight() + $this.find('.animated-column-desc').innerHeight() + $this.find('.animated-column-btn').innerHeight();

                        $this.height(contentHeight * 1.5 + 50);

                        var $box_height = $this.outerHeight(true),
                            $icon_height = $this.find('.animated-column-icon').height();

                        $this.find('.animated-column-holder').css({
                            'paddingTop': $box_height / 2 - ($icon_height)
                        });


                        $this.animate({opacity:1}, 300);
                    });
                } else {
                    $this.find('.animated-column-item').each(function() {
                        var $this = $(this),
                            $half_box_height = $this.outerHeight(true) / 2,
                            $icon_height = $this.find('.animated-column-icon').outerHeight(true)/2,
                            $title_height = $this.find('.animated-column-simple-title').outerHeight(true)/2;

                        $this.find('.animated-column-holder').css({
                            'paddingTop': $half_box_height - $icon_height
                        });
                        $this.find('.animated-column-title').css({
                            'paddingTop': $half_box_height - $title_height
                        });

                        $this.animate({opacity:1}, 300);

                    });
                }

            });
        }
        prepareCols();

        $(window).on("resize", function() {
            prepareCols();
        });

        $(".mk-animated-columns.full-style .animated-column-item").hover(
            function() {
                TweenLite.to($(this).find(".animated-column-holder"), 0.5, {
                    top: '-15%',
                    ease: Back.easeOut
                });
                TweenLite.to($(this).find(".animated-column-desc"), 0.5, {
                    top: '-50%',
                    ease: Expo.easeOut
                }, 0.4);
                TweenLite.to($(this).find(".animated-column-btn"), 0.3, {
                    top: '-50%',
                    ease: Expo.easeOut
                }, 0.6);
            },
            function() {

                TweenLite.to($(this).find(".animated-column-holder"), 0.5, {
                    top: '0%',
                    ease: Back.easeOut, easeParams:[3]
                });
                TweenLite.to($(this).find(".animated-column-desc"), 0.5, {
                    top: '100%',
                    ease: Back.easeOut
                }, 0.4);
                TweenLite.to($(this).find(".animated-column-btn"), 0.5, {
                    top: '100%',
                    ease: Back.easeOut
                }, 0.2);
            }
        );

        $(".mk-animated-columns.simple-style .animated-column-item, .mk-animated-columns.simple_text-style .animated-column-item").hover(
            function() {
                var colHolderHeight = $(this).height(); 
                TweenLite.to($(this).find(".animated-column-holder"), 0.7, {
                    y: colHolderHeight,
                    ease: Expo.easeOut
                });
                TweenLite.to($(this).find(".animated-column-title"), 0.7, {
                    y: colHolderHeight,
                    ease: Back.easeOut
                }, 0.2);
            },
            function() {
                TweenLite.to($(this).find(".animated-column-holder"), 0.7, {
                    y: 0,
                    ease: Expo.easeOut
                });
                TweenLite.to($(this).find(".animated-column-title"), 0.7, {
                    y: 0,
                    ease: Back.easeOut
                }, 0.2);
            }
        );

    }
    ;$(document).ready(function() {

    if (!$.exists('.mk-edge-one-pager') && typeof webkit_smoothscroll == 'function') {
        webkit_smoothscroll();
    }
    mk_go_to_top();
    mk_instagram();
    mk_main_navigation_functions();
    // mk_main_navigation();
    sticky_header();
    transparent_header_sticky();
    loop_audio_init();
    mk_header_margin_style();
    mk_social_share();
    mk_google_maps();
    mk_event_countdown();
    mk_portfolio_ajax();
    mk_text_typer();
    mk_flexslider_init();
    mk_one_page_scroller();
    mk_one_pager_resposnive();
    mk_child_ul_toggle_event();
    

    $(window).load(function() {
        mk_update_globals();
        mk_animated_columns();
        mk_fade_onload();
        mk_lightbox_init();
        //mk_portfolio_masonry();
        //mk_image();
        mk_portfolio_image();
        mk_gallery_image();
        mk_window_scroller();
        mk_main_nav_scroll();
        section_to_full_height();
        mk_expandable_page_section();
        mk_accordion();
        mk_employees();
        mk_process_steps();
        mk_gallery_thumbs_width();
        mk_edge_slider_init();
        mk_edge_slider_resposnive();
        mk_tab_slider();
        mk_swipe_slider();
        mk_hash_scroll();
        mk_center_caption();
        mk_logo_middle();
        loops_iosotop_init();
        isotop_load_fix();
        mk_page_title_intro();
        mk_section_intro_effects();
        mk_secondary_header_res();
        mk_tabs();
        secondary_header();
        mk_portfolio_hovers();
        //scrollAnimations(); 
        mk_theatre_responsive_calculator();
        mk_mobile_tablet_responsive_calculator();
        mk_button_animation();
        mk_tabs_responsive();
        mk_header_wpml();
        mk_vertical_menu_submenu();
        mk_theatre_autoplay_freeze();
        mk_imagebox_autoplay_freeze();
        mk_section_parallax();
        shop_isotop_init();
    });



    $(window).on("debouncedresize", function() {
        mk_update_globals();
        mk_portfolio_image();
        //mk_portfolio_masonry();
        //mk_image();
        section_to_full_height();
        mk_main_navigation_functions();
        mk_employees();
        mk_window_scroller();
        mk_section_parallax();
        mk_section_intro_effects();
        // mk_page_title_intro();
        mk_secondary_header_res();
        secondary_header();
        mk_center_caption();
        mk_one_pager_resposnive();
        mk_theatre_responsive_calculator();
        mk_mobile_tablet_responsive_calculator();
        transparent_header_sticky();
        sticky_header();
        mk_tabs_responsive();
    });


    /* Floating Go to top Link */
    /* -------------------------------------------------------------------- */
    $('.mk-go-top, .mk-back-top-link').click(function() {
        TweenLite.to(window, .8, {
            scrollTo: {
                y: 0
            },
            ease: Expo.easeInOut
        });
        return false;
    });

    function mk_go_to_top() {
        var mk_go_top = $('.mk-go-top');
        var animationSet = function() {
            if (scrollY > 700) {
                mk_go_top.removeClass('off').addClass('on');
            } else {
                mk_go_top.removeClass('on').addClass('off');
            }
        }
        debouncedScrollAnimations.add(animationSet);
    }



    /* Love This */
    /* -------------------------------------------------------------------- */

    function mk_love_post() {

        $('body').on('click', '.mk-love-this', function() {
            var $this = $(this),
                $id = $this.attr('id');

            if ($this.hasClass('item-loved')) {
                return false;
            }

            if ($this.hasClass('item-inactive')) {
                return false;
            }

            var $sentdata = {
                action: 'mk_love_post',
                post_id: $id
            };

            $.post(ajaxurl, $sentdata, function(data) {
                $this.find('span').html(data);
                $this.addClass('item-loved');
            });

            $this.addClass('item-inactive');
            return false;
        });


    }

    mk_love_post();



    /* Element Click Events */
    /* -------------------------------------------------------------------- */
    function mobilecheck() {
        var check = false;
        (function(a) {
            if (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    }


    /* Margin Header Style */
    /* -------------------------------------------------------------------- */


    function mk_header_margin_style() {

        var eventtype = mobilecheck() ? 'touchstart' : 'click';


        $('.mk-margin-header-burger').on(eventtype, function() {
            var $this = $(this),
                $mainNav = $('#mk-main-navigation');
            if (!$this.hasClass('active-burger')) {
                $this.addClass('active-burger');
                $mainNav.addClass('show-menu');
            } else {
                $this.removeClass('active-burger');
                $mainNav.removeClass('show-menu');
            }

        });

    }


    /* Product Category Accordion */
    /* -------------------------------------------------------------------- */
    function mk_child_ul_toggle_event() {
        $('.widget_product_categories ul > .cat-item').each(function() {

            var $this = $(this),
                $subLevel = $this.find('ul');

            if ($this.hasClass('cat-parent')) {
                $this.hoverIntent({
                    over: function() {
                        $subLevel.slideDown(500);
                    },
                    out: function() {
                        $subLevel.slideUp(500);
                    },
                    timeout: 1000
                });
            }

        });
    }

    /* Fancy Link Button Hover Animation */
    /* -------------------------------------------------------------------- */
    function mk_button_animation() {
        $('.fancy_link-button').each(function() {

            var $this = $(this),
                $line = $this.find('.line');

            $this.hoverIntent({
                over: function() {
                    $line.css({
                        'width': '100%',
                        'right': 'auto',
                        'left': '0',
                    });
                },
                out: function() {
                    $line.css({
                        'width': '0',
                        'right': '0',
                        'left': 'auto',
                    });
                },
                timeout: 100
            });

        });
    }



    /* Theatre Slider Autoplay freeze */
    /* -------------------------------------------------------------------- */

    function mk_theatre_autoplay_freeze() {
        $(".theatre-slider-container.autoplay-true").each(function() {
            var $container = $(this),
                $source = $container.data('source'),
                player;


            if ($source == 'self_hosted') {
                player = $container.find('video')[0];
            }
            if ($source == 'youtube') {
                var youtube = $container.find('iframe')[0];
                player = new YT.Player(youtube);
            }
            if ($source == 'vimeo') {
                var vimeo = $container.find('iframe')[0];
                player = $f(vimeo);
            }


            $container.on('inview', function(event, visible) {
                if (visible == true) {
                    if ($source == 'self_hosted') {
                        player.play();
                    }
                    if ($source == 'youtube') {
                        player.playVideo();
                    }
                    if ($source == 'vimeo') {
                        player.api('play');
                    }
                } else {
                    if ($source == 'self_hosted') {
                        player.pause();
                    }
                    if ($source == 'youtube') {
                        player.pauseVideo();
                    }
                    if ($source == 'vimeo') {
                        player.api('pause');
                    }
                }
            });
        });
    }

    /* Theatre Slider Responsive Calculator */
    /* -------------------------------------------------------------------- */

    function mk_theatre_responsive_calculator() {
        var $laptopContainer = $(".laptop-theatre-slider");
        var $computerContainer = $(".computer-theatre-slider");

        if ($.exists('.laptop-theatre-slider')) {
            $laptopContainer.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 32,
                    $paddingRight = 110,
                    $paddingBottom = 47,
                    $paddingLeft = 110;

                var $player = $this.find('.player-container');

                if ($windowWidth > $width) {
                    $player.css({
                        'padding-left': ($width * $paddingLeft) / 920,
                        'padding-right': ($width * $paddingRight) / 920,
                        'padding-top': ($height * $paddingTop) / 536,
                        'padding-bottom': ($height * $paddingBottom) / 536,
                    });
                }

            });
        }

        if ($.exists('.computer-theatre-slider')) {
            $computerContainer.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 37,
                    $paddingRight = 35,
                    $paddingBottom = 190,
                    $paddingLeft = 38;

                var $player = $this.find('.player-container');

                if ($windowWidth > $width) {
                    $player.css({
                        'padding-left': ($width * $paddingLeft) / 920,
                        'padding-right': ($width * $paddingRight) / 920,
                        'padding-top': ($height * $paddingTop) / 705,
                        'padding-bottom': ($height * $paddingBottom) / 705,
                    });
                }

            });
        }

    }

    /* Mobile and Tablet Slideshow Responsive Calculator */
    /* -------------------------------------------------------------------- */
    function mk_mobile_tablet_responsive_calculator() {
        var $mobilePortrait = $(".mk-mobile-slideshow.portrait-style");
        var $mobileLandscape = $(".mk-mobile-slideshow.landscape-style");
        var $tabletPortrait = $(".mk-tablet-slideshow");

        if ($.exists(".mk-mobile-slideshow.portrait-style")) {
            $mobilePortrait.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 106,
                    $paddingRight = 25,
                    $paddingBottom = 100,
                    $paddingLeft = 30;

                var $player = $this.find(".slideshow-container");

                $player.css({
                    "padding-left": ($width * $paddingLeft) / 357,
                    "padding-right": ($width * $paddingRight) / 357,
                    "padding-top": ($height * $paddingTop) / 741,
                    "padding-bottom": ($height * $paddingBottom) / 735,
                });

            });
        }

        if ($.exists(".mk-mobile-slideshow.landscape-style")) {
            $mobileLandscape.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 40,
                    $paddingRight = 125,
                    $paddingBottom = 40,
                    $paddingLeft = 135;

                var $player = $this.find(".slideshow-container");
                $player.css({
                    "padding-left": ($width * $paddingLeft) / 902,
                    "padding-right": ($width * $paddingRight) / 902,
                    "padding-top": ($height * $paddingTop) / 436,
                    "padding-bottom": ($height * $paddingBottom) / 436,
                });
            });
        }

        if ($.exists(".mk-tablet-slideshow")) {
            $tabletPortrait.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 78,
                    $paddingRight = 36,
                    $paddingBottom = 83,
                    $paddingLeft = 30;

                var $player = $this.find(".slideshow-container");
                $player.css({
                    "padding-left": ($width * $paddingLeft) / 501,
                    "padding-right": ($width * $paddingRight) / 501,
                    "padding-top": ($height * $paddingTop) / 739,
                    "padding-bottom": ($height * $paddingBottom) / 739,
                });
            });
        }
    }

    /* Imagebox Video Player Autoplay Freeze
    /* -------------------------------------------------------------------- */

    function mk_imagebox_autoplay_freeze() {
        $(".mk-image-box.autoplay-true").each(function() {
            var $container = $(this),
                $source = $container.data('source'),
                player;


            if ($source == 'self_hosted') {
                player = $container.find('video')[0];
            }
            if ($source == 'youtube') {
                var youtube = $container.find('iframe')[0];
                player = new YT.Player(youtube);
            }
            if ($source == 'vimeo') {
                var vimeo = $container.find('iframe')[0];
                player = $f(vimeo);
            }


            $container.on('inview', function(event, visible) {
                if (visible == true) {
                    if ($source == 'self_hosted') {
                        player.play();
                    }
                    if ($source == 'youtube') {
                        player.playVideo();
                        player.mute();
                    }
                    if ($source == 'vimeo') {
                        player.api('play');
                        player.api('setVolume', 0);
                    }
                } else {
                    if ($source == 'self_hosted') {
                        player.pause();
                    }
                    if ($source == 'youtube') {
                        player.pauseVideo();
                    }
                    if ($source == 'vimeo') {
                        player.api('pause');
                    }
                }
            });
        });
    }

    function shop_isotop_init() {
        if ($.exists('.products') && !$('.products').hasClass('related')) {
            $('.products').each(function() {
                console.log('shop_isotop_init_inside');
                if (!$(this).parents('.mk-woocommerce-carousel').length) {
                    var $woo_container = $(this),
                        $container_item = '.products .product';

                    $woo_container.isotope({
                        itemSelector: $container_item,
                        masonry: {
                            columnWidth: 1
                        }
                    });
                }
            });
        }
    }



    /* Vertical Menu Accordion */
    /* -------------------------------------------------------------------- */
    function mk_vertical_menu_submenu() {
        if ($.exists(".vertical-header")) {
            $('.mk-vertical-menu .menu-item').hoverIntent({
                over: function() {
                    if ($(this).is('.menu-item-has-children')) {
                        $(this).find('> .sub-menu').slideToggle();
                    }
                },
                out: function() {
                    if ($(this).is('.menu-item-has-children')) {
                        $(this).find('> .sub-menu').slideToggle();
                    }
                },
                timeout: 300
            });
        }
    }


    /* WPML Language Selector */
    /* -------------------------------------------------------------------- */
    function mk_header_wpml() {
        $('.mk-header-wpml-ls').hoverIntent({
            over: function() {
                $('.language-selector-box').fadeIn(200);
            },
            out: function() {
                $('.language-selector-box').fadeOut(200);
            },
            timeout: 500
        });
    }




    /* Woocmmerce Header Checkout */
    /* -------------------------------------------------------------------- */

    function mk_header_checkout() {
        $('.mk-shopping-cart').hoverIntent(function() {
            $('.mk-shopping-box').fadeIn(200);
        }, function() {
            $('.mk-shopping-box').delay(500).fadeOut(200);
        });
    }


    setTimeout(function() {
        mk_header_checkout();
    }, 500);



    /* Woocommerce Scripts */
    /* -------------------------------------------------------------------- */

    function product_loop_add_cart() {
        var $body = $('body');

        $body.on('click', '.add_to_cart_button', function() {
            var product = $(this).parents('.product:eq(0)').addClass('adding-to-cart').removeClass('added-to-cart');
        });

        $body.bind('added_to_cart', function() {
            $('.adding-to-cart').removeClass('adding-to-cart').addClass('added-to-cart');
            mk_header_checkout();
        });
    }
    product_loop_add_cart();


    /* Table Responsive */
    /* -------------------------------------------------------------------- */
   /* var switched = false;
    var updateTables = function() {
        if ((global_window_width < 767) && !switched) {
            switched = true;
            $("table.shop_table").each(function(i, element) {
                splitTable($(element));
            });
            return true;
        } else if (switched && (global_window_width > 767)) {
            switched = false;
            $("table.shop_table").each(function(i, element) {
                unsplitTable($(element));
            });
        }
    };

    $(window).load(updateTables);
    $(window).on("redraw", function() {
        switched = false;
        updateTables();
    }); // An event to listen for
    $(window).on("resize", updateTables);


    function splitTable(original) {
        original.wrap("<div class='table-wrapper' />");

        var copy = original.clone();
        copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
        copy.removeClass("shop_table");

        original.closest(".table-wrapper").append(copy);
        copy.wrap("<div class='pinned' />");
        original.wrap("<div class='scrollable' />");

        setCellHeights(original, copy);
    }

    function unsplitTable(original) {
        original.closest(".table-wrapper").find(".pinned").remove();
        original.unwrap();
        original.unwrap();
    }

    function setCellHeights(original, copy) {
        var tr = original.find('tr'),
            tr_copy = copy.find('tr'),
            heights = [];

        tr.each(function(index) {
            var self = $(this),
                tx = self.find('th, td');

            tx.each(function() {
                var height = $(this).outerHeight(true);
                heights[index] = heights[index] || 0;
                if (height > heights[index]) heights[index] = height;
            });

        });

        tr_copy.each(function(index) {
            $(this).height(heights[index]);
        });
    }*/


    /* Ajax Search */
    /* -------------------------------------------------------------------- */

    function mk_ajax_search() {
        if ($.exists('.search-ajax-input')) {
            $(".search-ajax-input").autocomplete({
                delay: 50,
                minLength: 2,
                messages: {
                    noResults: '',
                    results: function() {}
                },
                appendTo: $(".header-searchform-input"),
                source: function(req, response) {
                    $.getJSON(ajaxurl + '?callback=?&action=mk_ajax_search', req, response);
                },
                select: function(event, ui) {
                    window.location.href = ui.item.link;
                }

            }).data("ui-autocomplete")._renderItem = function(ul, item) {


                return $("<li>").append("<a>" + item.image + "<span class='search-title'>" + item.label + "</span><span class='search-date'>" + item.date + "</span></a>").appendTo(ul);

            };
        }
    }

    mk_ajax_search();



    /* Contact Form */
    /* -------------------------------------------------------------------- */

    function mk_contact_form() {

        if ($.tools.validator != undefined) {
            $.tools.validator.addEffect("contact_form", function(errors) {
                $.each(errors, function(index, error) {
                    var input = error.input;

                    input.addClass('mk-invalid');
                });
            }, function(inputs) {
                inputs.removeClass('mk-invalid');
            });


            $(".captcha-change-image").on("click", function(e) {
                e.preventDefault();
                changeCaptcha();
            });

            $(".captcha-form").each(function() {
              $(this).on("focus", function() {
                $(this).attr("placeholder", mk_captcha_placeholder).removeClass('contact-captcha-invalid contact-captcha-valid');
              });
            });

            var changeCaptcha = function() {
                $(".captcha-image").attr("src", mk_theme_dir + "/captcha/captcha.php?" + Math.random());
            }

            var sendForm;
            var checkCaptcha = function(form, enteredCaptcha) {
                $.get(mk_theme_dir + "/captcha/captcha-check.php", {
                    captcha: enteredCaptcha
                }).done(function(data) {
                    if (data != "ok") {
                        changeCaptcha();
                        form.find(".captcha-form").val("").addClass('contact-captcha-invalid').attr("placeholder",mk_captcha_invalid_txt);
                    } else {
                        sendForm();
                        changeCaptcha();
                        form.find(".captcha-form").val("").addClass('contact-captcha-valid').attr("placeholder", mk_captcha_correct_txt);
                    }
                });
            }

            $('.mk-contact-form').validator({
                effect: 'contact_form'
            }).submit(function(e) {
                var form = $(this);
                if (!e.isDefaultPrevented()) {
                    // progressButton.loader(form);
                    // $(this).find('.mk-contact-loading').fadeIn('slow');

                    var data = {
                        action: 'mk_contact_form',
                        to: form.find('input[name="contact_to"]').val().replace("*", "@"),
                        name: form.find('input[name="contact_name"]').val(),
                        phone: form.find('input[name="contact_phone"]').val(),
                        email: form.find('input[name="contact_email"]').val(),
                        content: form.find('textarea[name="contact_content"]').val()
                    };

                    // $.post(ajaxurl, data, function(response) {
                    //     // form.find('.mk-contact-loading').fadeOut('slow');
                    //     // form.find('.mk-contact-success').delay(2000).fadeIn('slow').delay(8000).fadeOut();
                    //     // form.find('input#contact_email, input#contact_name, textarea').val("");

                    //     form.find('.mk-contact-loading').fadeOut('slow');
                    //     form.find('input#contact_email, input#contact_name, textarea').val("");
                    //     progressButton.success(form);

                    // });

                    sendForm = function() {
                        progressButton.loader(form);
                        $.post(ajaxurl, data, function(response) {
                            form.find('.mk-contact-loading').fadeOut('slow');
                            form.find('input').val("");
                            progressButton.success(form);
                        });
                    };

                    var enteredCaptcha = form.find('input[name="captcha"]').val();
                    if (form.find('.captcha-form').length) {
                        checkCaptcha(form, enteredCaptcha);
                    } else {
                        sendForm();
                    }

                    e.preventDefault();
                }
            });

        }
    }

    mk_contact_form();


    $(this).find('.mk-form-row input, .comment-form-row input, .mk-login-form input').each(function() {

        $(this).focusin(function() {
            $(this).siblings('i').addClass('input-focused');
        });
        $(this).focusout(function() {
            $(this).siblings('i').removeClass('input-focused');
        });

    });



    /* Ajax Login Form */
    /* -------------------------------------------------------------------- */

    function mk_login_form() {

        $('form.mk-login-form').each(function() {
            var $this = $(this);
            $this.on('submit', function(e) {
                $('p.mk-login-status', $this).show().text(ajax_login_object.loadingmessage);
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_login_object.ajaxurl,
                    data: {
                        'action': 'ajaxlogin',
                        //calls wp_ajax_nopriv_ajaxlogin
                        'username': $('#username', $this).val(),
                        'password': $('#password', $this).val(),
                        'security': $('#security', $this).val()
                    },
                    success: function(data) {
                        $('p.mk-login-status', $this).text(data.message);
                        if (data.loggedin === true) {
                            document.location.href = ajax_login_object.redirecturl;
                        }
                    }
                });
                e.preventDefault();
            });
        });
    }

    mk_login_form();

    /* quick contact form function */
    /* -------------------------------------------------------------------- */
    var eventtype = mobilecheck() ? 'touchstart' : 'click';
    jQuery('.mk-quick-contact-link').on(eventtype, function() {
        var $this = jQuery(this),
            $quickContact = jQuery('.mk-quick-contact-overlay'),
            $quickContactInner = $quickContact.find('.mk-quick-contact-inset');

        $quickContact.addClass('mk-quick-contact-visible');

        return false;
    });
    jQuery('.mk-quick-contact-overlay').on(eventtype, function() {
        $(this).removeClass('mk-quick-contact-visible');
    });

    /* message box close function */
    /* -------------------------------------------------------------------- */

    $('.box-close-btn').on(eventtype, function() {
        $(this).parent().fadeOut(300);
        return false;
    });



    /* Smooth scroll using hash */
    /* -------------------------------------------------------------------- */
    function mk_hash_scroll() {
        $(".mk-smooth, .blog-comments").on('click', function(e) {
            var secondary_header_height = 0,
                header_height = 0;


            // if ($.exists('#mk-header') && !$('#mk-header').hasClass('transparent-header')) { // this won't pass. Make the condition as in mk_main_nav_scroll() 
            if ($.exists('#mk-header')) {
                var header_height = parseInt($('#mk-header').attr('data-sticky-height'));
            }

            if ($.exists('.mk-secondary-header')) {
                var secondary_header_height = parseInt($('.mk-secondary-header').attr('data-sticky-height'));
            }

            TweenLite.to(window, 1.2, {
                scrollTo: {
                    y: $($(this).attr("href")).offset().top - (header_height + secondary_header_height + global_admin_bar_height + 2)
                },
                ease: Expo.easeInOut
            });

            e.preventDefault();
        });
    }


    /* Scroll function for main navigation on one page concept */
    /* -------------------------------------------------------------------- */



    function mk_main_nav_scroll() {

        var lastId, topMenu = $(".main-navigation-ul"),
            menuItems = topMenu.find(".menu-item a"),
            secondary_header_height = 0,
            header_height = 0;

        menuItems.each(function() {
            if (typeof href_attr !== 'undefined' && href_attr !== false) {
                var href = $(this).attr("href").split('#')[0];
                $(this).addClass("one-page-nav-item");
            } else {
                href = "";
            }


            if (href === window.location.href.split('#')[0] && (typeof $(this).attr("href").split('#')[1] !== 'undefined') && href !== "") {

                $(this).attr("href", "#" + $(this).attr("href").split('#')[1]);
                $(this).parent().removeClass("current-menu-item");
            }
        });

        var onePageMenuItems = $('.one-page-nav-item');

        var scrollItems = onePageMenuItems.map(function() {
            var item = $(this).attr("href");

            if (/^#\w/.test(item) && $(item).length) {
                return $(item);
            }
        });

        if ($.exists('#mk-header')) {
            header_height = parseInt($('#mk-header').attr('data-sticky-height'));
        }
        if ($.exists('.mk-secondary-header')) {
            secondary_header_height = parseInt($('.mk-secondary-header').attr('data-sticky-height'));
        }

        onePageMenuItems.click(function(e) {
            var href = $(this).attr("href");
            if (typeof $(href).offset() !== 'undefined') {
                var href_top = $(href).offset().top;
            } else {
                var href_top = 0;
            }
            //console.log(href_top);
            var offsetTop = href === "#" ? 0 : href_top - (header_height + secondary_header_height + global_admin_bar_height + 2);

            TweenLite.to(window, 1.2, {
                scrollTo: {
                    y: offsetTop
                },
                ease: Expo.easeInOut
            });
            e.preventDefault();
        });


        var fromTop;
        var animationSet = function() {

            if (!scrollItems.length) {
                return false;
            }

            fromTop = scrollY + (header_height + secondary_header_height + global_admin_bar_height - 1);

            var cur = scrollItems.map(function() {
                if ($(this).offset().top - 200 < fromTop) { // This is purely empirical - we don't look at the top of screen but a little bit lower, so lets switch section at this point.
                    return this;
                }
            });
            //console.log(cur);
            cur = cur[cur.length - 1];
            var id = cur && cur.length ? cur[0].id : "";

            if (lastId !== id) {
                lastId = id;

                onePageMenuItems.parent().removeClass("current-menu-item");
                //console.log(id);
                if (id.length) {
                    onePageMenuItems.filter("[href=#" + id + "]").parent().addClass("current-menu-item");
                    //console.log(id);
                }
            }
        };
        debouncedScrollAnimations.add(animationSet);
    }

});


function mk_ajax_portfolio() {
    var pluginName = "ajaxPortfolio",
        defaults = {
            propertyName: "value"
        };

    function Plugin(element, options) {
        this.element = $(element);
        this.settings = $.extend({}, defaults, options);
        this.init();

    }
    Plugin.prototype = {
        init: function() {
            var obj = this;
            this.grid = this.element.find('.mk-portfolio-container'), this.items = this.grid.children();

            if (this.items.length < 1) {
                return false;
            } //If no items was found then exit
            this.ajaxDiv = this.element.find('div.ajax-container'), this.filter = this.element.find('#mk-filter-portfolio'), this.loader = this.element.find('.portfolio-loader'), this.triggers = this.items.find('.project-load'), this.closeBtn = this.ajaxDiv.find('.close-ajax'), this.nextBtn = this.ajaxDiv.find('.next-ajax'), this.prevBtn = this.ajaxDiv.find('.prev-ajax'), this.api = {}, this.id = null, this.win = $(window), this.current = 0, this.breakpointT = 989, this.breakpointP = 767, this.columns = this.grid.data('columns'), this.real_col = this.columns;
            this.loader.fadeIn();
            if (this.items.length === 1) {
                this.nextBtn.remove();
                this.prevBtn.remove();
            }
            this.grid.waitForImages(function() {
                obj.loader.fadeOut();
                obj.bind_handler();
            });

        },

        bind_handler: function() {
            var obj = this; // Temp instance of this object
            // Bind the filters with isotope
            obj.filter.find('a').click(function() {
                obj.triggers.removeClass('active');
                obj.grid.removeClass('grid-open');
                obj.close_project();
                obj.filter.find('a').removeClass('active_sort');
                $(this).addClass('active_sort');
                var selector = $(this).attr('data-filter');
                obj.grid.isotope({
                    filter: selector
                });
                return false;
            });

            obj.triggers.on('click', function() {

                var clicked = $(this),
                    clickedParent = clicked.parents('.portfolio-ajax-item');

                obj.current = clickedParent.index();

                if (clicked.hasClass('active')) {
                    return false;
                }

                obj.close_project();

                obj.triggers.removeClass('active');
                clicked.addClass('active');
                obj.grid.addClass('grid-open');
                obj.loader.fadeIn();

                obj.id = clicked.data('post-id');

                obj.load_project();

                return false;

            });

            obj.nextBtn.on('click', function() {
                if (obj.current === obj.triggers.length - 1) {
                    obj.triggers.eq(0).trigger('click');
                    return false;
                } else {
                    obj.triggers.eq(obj.current + 1).trigger('click');
                    return false;
                }

            });

            obj.prevBtn.on('click', function() {
                if (obj.current === 0) {
                    obj.triggers.eq(obj.triggers.length - 1).trigger('click');
                    return false;
                } else {
                    obj.triggers.eq(obj.current - 1).trigger('click');
                    return false;
                }

            });

            // Bind close button
            obj.closeBtn.on('click', function() {
                obj.close_project();
                obj.triggers.removeClass('active');
                obj.grid.removeClass('grid-open');
                return false;
            });


        },
        // Function to close the ajax container div
        close_project: function() {
            var obj = this,
                // Temp instance of this object
                project = obj.ajaxDiv.find('.ajax_project'),
                newH = project.actual('outerHeight');



            if (obj.ajaxDiv.height() > 0) {
                obj.ajaxDiv.css('height', newH + 'px').transition({
                    height: 0,
                    opacity: 0
                }, 600);
            } else {
                obj.ajaxDiv.transition({
                    height: 0,
                    opacity: 0
                }, 600);
            }
        },
        load_project: function() {
            var obj = this;
            $.post(ajaxurl, {
                action: 'mk_ajax_portfolio',
                id: obj.id
            }, function(response) {
                obj.ajaxDiv.find('.ajax_project').remove();
                obj.ajaxDiv.find('.portfolio-ajax-holder').append(response);
                obj.project_factory();
                mk_lightbox_init();
                mk_tabs();
                mk_swipe_slider();
                mk_portfolio_image();
                mk_gallery_image();
                mk_accordion();
                mk_social_share();

            });
        },
        project_factory: function() {
            var obj = this,
                project = this.ajaxDiv.find('.ajax_project');



            project.waitForImages(function() {
                $('html:not(:animated),body:not(:animated)').animate({
                    scrollTop: obj.ajaxDiv.offset().top - 160
                }, 700);
                obj.loader.fadeOut(function() {
                    var newH = project.actual('outerHeight');
                    obj.ajaxDiv.transition({
                        opacity: 1,
                        height: newH
                    }, 400, function() {
                        obj.ajaxDiv.css({
                            height: 'auto'
                        });
                    });
                });

            });

        },

    };
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            $.data(this, "plugin_" + pluginName, new Plugin(this, options));
        });
    };


}

mk_ajax_portfolio();


})(jQuery);;
/*! fancyBox v2.1.5 fancyapps.com | fancyapps.com/fancybox/#license */
(function(s, H, f, w) {
    var K = f("html"),
        q = f(s),
        p = f(H),
        b = f.fancybox = function() {
            b.open.apply(this, arguments)
        },
        J = navigator.userAgent.match(/msie/i),
        C = null,
        t = H.createTouch !== w,
        u = function(a) {
            return a && a.hasOwnProperty && a instanceof f
        },
        r = function(a) {
            return a && "string" === f.type(a)
        },
        F = function(a) {
            return r(a) && 0 < a.indexOf("%")
        },
        m = function(a, d) {
            var e = parseInt(a, 10) || 0;
            d && F(a) && (e *= b.getViewport()[d] / 100);
            return Math.ceil(e)
        },
        x = function(a, b) {
            return m(a, b) + "px"
        };
    f.extend(b, {
        version: "2.1.5",
        defaults: {
            padding: 15,
            margin: 20,
            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1,
            autoSize: !0,
            autoHeight: !1,
            autoWidth: !1,
            autoResize: !0,
            autoCenter: !t,
            fitToView: !0,
            aspectRatio: !1,
            topRatio: 0.5,
            leftRatio: 0.5,
            scrolling: "auto",
            wrapCSS: "",
            arrows: !0,
            closeBtn: !0,
            closeClick: !1,
            nextClick: !1,
            mouseWheel: !0,
            autoPlay: !1,
            playSpeed: 3E3,
            preload: 3,
            modal: !1,
            loop: !0,
            ajax: {
                dataType: "html",
                headers: {
                    "X-fancyBox": !0
                }
            },
            iframe: {
                scrolling: "auto",
                preload: !0
            },
            swf: {
                wmode: "transparent",
                allowfullscreen: "true",
                allowscriptaccess: "always"
            },
            keys: {
                next: {
                    13: "left",
                    34: "up",
                    39: "left",
                    40: "up"
                },
                prev: {
                    8: "right",
                    33: "down",
                    37: "right",
                    38: "down"
                },
                close: [27],
                play: [32],
                toggle: [70]
            },
            direction: {
                next: "left",
                prev: "right"
            },
            scrollOutside: !0,
            index: 0,
            type: null,
            href: null,
            content: null,
            title: null,
            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" />',
                iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' +
                    (J ? ' allowtransparency="true"' : "") + "></iframe>",
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
            },
            openEffect: "fade",
            openSpeed: 250,
            openEasing: "swing",
            openOpacity: !0,
            openMethod: "zoomIn",
            closeEffect: "fade",
            closeSpeed: 250,
            closeEasing: "swing",
            closeOpacity: !0,
            closeMethod: "zoomOut",
            nextEffect: "elastic",
            nextSpeed: 250,
            nextEasing: "swing",
            nextMethod: "changeIn",
            prevEffect: "elastic",
            prevSpeed: 250,
            prevEasing: "swing",
            prevMethod: "changeOut",
            helpers: {
                overlay: !0,
                title: !0
            },
            onCancel: f.noop,
            beforeLoad: f.noop,
            afterLoad: f.noop,
            beforeShow: f.noop,
            afterShow: f.noop,
            beforeChange: f.noop,
            beforeClose: f.noop,
            afterClose: f.noop
        },
        group: {},
        opts: {},
        previous: null,
        coming: null,
        current: null,
        isActive: !1,
        isOpen: !1,
        isOpened: !1,
        wrap: null,
        skin: null,
        outer: null,
        inner: null,
        player: {
            timer: null,
            isActive: !1
        },
        ajaxLoad: null,
        imgPreload: null,
        transitions: {},
        helpers: {},
        open: function(a, d) {
            if (a && (f.isPlainObject(d) || (d = {}), !1 !== b.close(!0))) return f.isArray(a) || (a = u(a) ? f(a).get() : [a]), f.each(a, function(e, c) {
                var l = {},
                    g, h, k, n, m;
                "object" === f.type(c) && (c.nodeType && (c = f(c)), u(c) ? (l = {
                        href: c.data("fancybox-href") || c.attr("href"),
                        title: f("<div/>").text(c.data("fancybox-title") || c.attr("title")).html(),
                        isDom: !0,
                        element: c
                    },
                    f.metadata && f.extend(!0, l, c.metadata())) : l = c);
                g = d.href || l.href || (r(c) ? c : null);
                h = d.title !== w ? d.title : l.title || "";
                n = (k = d.content || l.content) ? "html" : d.type || l.type;
                !n && l.isDom && (n = c.data("fancybox-type"), n || (n = (n = c.prop("class").match(/fancybox\.(\w+)/)) ? n[1] : null));
                r(g) && (n || (b.isImage(g) ? n = "image" : b.isSWF(g) ? n = "swf" : "#" === g.charAt(0) ? n = "inline" : r(c) && (n = "html", k = c)), "ajax" === n && (m = g.split(/\s+/, 2), g = m.shift(), m = m.shift()));
                k || ("inline" === n ? g ? k = f(r(g) ? g.replace(/.*(?=#[^\s]+$)/, "") : g) : l.isDom && (k = c) :
                    "html" === n ? k = g : n || g || !l.isDom || (n = "inline", k = c));
                f.extend(l, {
                    href: g,
                    type: n,
                    content: k,
                    title: h,
                    selector: m
                });
                a[e] = l
            }), b.opts = f.extend(!0, {}, b.defaults, d), d.keys !== w && (b.opts.keys = d.keys ? f.extend({}, b.defaults.keys, d.keys) : !1), b.group = a, b._start(b.opts.index)
        },
        cancel: function() {
            var a = b.coming;
            a && !1 === b.trigger("onCancel") || (b.hideLoading(), a && (b.ajaxLoad && b.ajaxLoad.abort(), b.ajaxLoad = null, b.imgPreload && (b.imgPreload.onload = b.imgPreload.onerror = null), a.wrap && a.wrap.stop(!0, !0).trigger("onReset").remove(),
                b.coming = null, b.current || b._afterZoomOut(a)))
        },
        close: function(a) {
            b.cancel();
            !1 !== b.trigger("beforeClose") && (b.unbindEvents(), b.isActive && (b.isOpen && !0 !== a ? (b.isOpen = b.isOpened = !1, b.isClosing = !0, f(".fancybox-item, .fancybox-nav").remove(), b.wrap.stop(!0, !0).removeClass("fancybox-opened"), b.transitions[b.current.closeMethod]()) : (f(".fancybox-wrap").stop(!0).trigger("onReset").remove(), b._afterZoomOut())))
        },
        play: function(a) {
            var d = function() {
                    clearTimeout(b.player.timer)
                },
                e = function() {
                    d();
                    b.current && b.player.isActive &&
                        (b.player.timer = setTimeout(b.next, b.current.playSpeed))
                },
                c = function() {
                    d();
                    p.unbind(".player");
                    b.player.isActive = !1;
                    b.trigger("onPlayEnd")
                };
            !0 === a || !b.player.isActive && !1 !== a ? b.current && (b.current.loop || b.current.index < b.group.length - 1) && (b.player.isActive = !0, p.bind({
                "onCancel.player beforeClose.player": c,
                "onUpdate.player": e,
                "beforeLoad.player": d
            }), e(), b.trigger("onPlayStart")) : c()
        },
        next: function(a) {
            var d = b.current;
            d && (r(a) || (a = d.direction.next), b.jumpto(d.index + 1, a, "next"))
        },
        prev: function(a) {
            var d =
                b.current;
            d && (r(a) || (a = d.direction.prev), b.jumpto(d.index - 1, a, "prev"))
        },
        jumpto: function(a, d, e) {
            var c = b.current;
            c && (a = m(a), b.direction = d || c.direction[a >= c.index ? "next" : "prev"], b.router = e || "jumpto", c.loop && (0 > a && (a = c.group.length + a % c.group.length), a %= c.group.length), c.group[a] !== w && (b.cancel(), b._start(a)))
        },
        reposition: function(a, d) {
            var e = b.current,
                c = e ? e.wrap : null,
                l;
            c && (l = b._getPosition(d), a && "scroll" === a.type ? (delete l.position, c.stop(!0, !0).animate(l, 200)) : (c.css(l), e.pos = f.extend({}, e.dim, l)))
        },
        update: function(a) {
            var d = a && a.originalEvent && a.originalEvent.type,
                e = !d || "orientationchange" === d;
            e && (clearTimeout(C), C = null);
            b.isOpen && !C && (C = setTimeout(function() {
                var c = b.current;
                c && !b.isClosing && (b.wrap.removeClass("fancybox-tmp"), (e || "load" === d || "resize" === d && c.autoResize) && b._setDimension(), "scroll" === d && c.canShrink || b.reposition(a), b.trigger("onUpdate"), C = null)
            }, e && !t ? 0 : 300))
        },
        toggle: function(a) {
            b.isOpen && (b.current.fitToView = "boolean" === f.type(a) ? a : !b.current.fitToView, t && (b.wrap.removeAttr("style").addClass("fancybox-tmp"),
                b.trigger("onUpdate")), b.update())
        },
        hideLoading: function() {
            p.unbind(".loading");
            f("#fancybox-loading").remove()
        },
        showLoading: function() {
            var a, d;
            b.hideLoading();
            a = f('<div id="fancybox-loading"><div></div></div>').click(b.cancel).appendTo("body");
            p.bind("keydown.loading", function(a) {
                27 === (a.which || a.keyCode) && (a.preventDefault(), b.cancel())
            });
            b.defaults.fixed || (d = b.getViewport(), a.css({
                position: "absolute",
                top: 0.5 * d.h + d.y,
                left: 0.5 * d.w + d.x
            }));
            b.trigger("onLoading")
        },
        getViewport: function() {
            var a = b.current &&
                b.current.locked || !1,
                d = {
                    x: q.scrollLeft(),
                    y: q.scrollTop()
                };
            a && a.length ? (d.w = a[0].clientWidth, d.h = a[0].clientHeight) : (d.w = t && s.innerWidth ? s.innerWidth : q.width(), d.h = t && s.innerHeight ? s.innerHeight : q.height());
            return d
        },
        unbindEvents: function() {
            b.wrap && u(b.wrap) && b.wrap.unbind(".fb");
            p.unbind(".fb");
            q.unbind(".fb")
        },
        bindEvents: function() {
            var a = b.current,
                d;
            a && (q.bind("orientationchange.fb" + (t ? "" : " resize.fb") + (a.autoCenter && !a.locked ? " scroll.fb" : ""), b.update), (d = a.keys) && p.bind("keydown.fb", function(e) {
                var c =
                    e.which || e.keyCode,
                    l = e.target || e.srcElement;
                if (27 === c && b.coming) return !1;
                e.ctrlKey || e.altKey || e.shiftKey || e.metaKey || l && (l.type || f(l).is("[contenteditable]")) || f.each(d, function(d, l) {
                    if (1 < a.group.length && l[c] !== w) return b[d](l[c]), e.preventDefault(), !1;
                    if (-1 < f.inArray(c, l)) return b[d](), e.preventDefault(), !1
                })
            }), f.fn.mousewheel && a.mouseWheel && b.wrap.bind("mousewheel.fb", function(d, c, l, g) {
                for (var h = f(d.target || null), k = !1; h.length && !(k || h.is(".fancybox-skin") || h.is(".fancybox-wrap"));) k = h[0] && !(h[0].style.overflow &&
                    "hidden" === h[0].style.overflow) && (h[0].clientWidth && h[0].scrollWidth > h[0].clientWidth || h[0].clientHeight && h[0].scrollHeight > h[0].clientHeight), h = f(h).parent();
                0 !== c && !k && 1 < b.group.length && !a.canShrink && (0 < g || 0 < l ? b.prev(0 < g ? "down" : "left") : (0 > g || 0 > l) && b.next(0 > g ? "up" : "right"), d.preventDefault())
            }))
        },
        trigger: function(a, d) {
            var e, c = d || b.coming || b.current;
            if (c) {
                f.isFunction(c[a]) && (e = c[a].apply(c, Array.prototype.slice.call(arguments, 1)));
                if (!1 === e) return !1;
                c.helpers && f.each(c.helpers, function(d, e) {
                    if (e &&
                        b.helpers[d] && f.isFunction(b.helpers[d][a])) b.helpers[d][a](f.extend(!0, {}, b.helpers[d].defaults, e), c)
                })
            }
            p.trigger(a)
        },
        isImage: function(a) {
            return r(a) && a.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)
        },
        isSWF: function(a) {
            return r(a) && a.match(/\.(swf)((\?|#).*)?$/i)
        },
        _start: function(a) {
            var d = {},
                e, c;
            a = m(a);
            e = b.group[a] || null;
            if (!e) return !1;
            d = f.extend(!0, {}, b.opts, e);
            e = d.margin;
            c = d.padding;
            "number" === f.type(e) && (d.margin = [e, e, e, e]);
            "number" === f.type(c) && (d.padding = [c, c,
                c, c
            ]);
            d.modal && f.extend(!0, d, {
                closeBtn: !1,
                closeClick: !1,
                nextClick: !1,
                arrows: !1,
                mouseWheel: !1,
                keys: null,
                helpers: {
                    overlay: {
                        closeClick: !1
                    }
                }
            });
            d.autoSize && (d.autoWidth = d.autoHeight = !0);
            "auto" === d.width && (d.autoWidth = !0);
            "auto" === d.height && (d.autoHeight = !0);
            d.group = b.group;
            d.index = a;
            b.coming = d;
            if (!1 === b.trigger("beforeLoad")) b.coming = null;
            else {
                c = d.type;
                e = d.href;
                if (!c) return b.coming = null, b.current && b.router && "jumpto" !== b.router ? (b.current.index = a, b[b.router](b.direction)) : !1;
                b.isActive = !0;
                if ("image" ===
                    c || "swf" === c) d.autoHeight = d.autoWidth = !1, d.scrolling = "visible";
                "image" === c && (d.aspectRatio = !0);
                "iframe" === c && t && (d.scrolling = "scroll");
                d.wrap = f(d.tpl.wrap).addClass("fancybox-" + (t ? "mobile" : "desktop") + " fancybox-type-" + c + " fancybox-tmp " + d.wrapCSS).appendTo(d.parent || "body");
                f.extend(d, {
                    skin: f(".fancybox-skin", d.wrap),
                    outer: f(".fancybox-outer", d.wrap),
                    inner: f(".fancybox-inner", d.wrap)
                });
                f.each(["Top", "Right", "Bottom", "Left"], function(a, b) {
                    d.skin.css("padding" + b, x(d.padding[a]))
                });
                b.trigger("onReady");
                if ("inline" === c || "html" === c) {
                    if (!d.content || !d.content.length) return b._error("content")
                } else if (!e) return b._error("href");
                "image" === c ? b._loadImage() : "ajax" === c ? b._loadAjax() : "iframe" === c ? b._loadIframe() : b._afterLoad()
            }
        },
        _error: function(a) {
            f.extend(b.coming, {
                type: "html",
                autoWidth: !0,
                autoHeight: !0,
                minWidth: 0,
                minHeight: 0,
                scrolling: "no",
                hasError: a,
                content: b.coming.tpl.error
            });
            b._afterLoad()
        },
        _loadImage: function() {
            var a = b.imgPreload = new Image;
            a.onload = function() {
                this.onload = this.onerror = null;
                b.coming.width =
                    this.width / b.opts.pixelRatio;
                b.coming.height = this.height / b.opts.pixelRatio;
                b._afterLoad()
            };
            a.onerror = function() {
                this.onload = this.onerror = null;
                b._error("image")
            };
            a.src = b.coming.href;
            !0 !== a.complete && b.showLoading()
        },
        _loadAjax: function() {
            var a = b.coming;
            b.showLoading();
            b.ajaxLoad = f.ajax(f.extend({}, a.ajax, {
                url: a.href,
                error: function(a, e) {
                    b.coming && "abort" !== e ? b._error("ajax", a) : b.hideLoading()
                },
                success: function(d, e) {
                    "success" === e && (a.content = d, b._afterLoad())
                }
            }))
        },
        _loadIframe: function() {
            var a = b.coming,
                d = f(a.tpl.iframe.replace(/\{rnd\}/g, (new Date).getTime())).attr("scrolling", t ? "auto" : a.iframe.scrolling).attr("src", a.href);
            f(a.wrap).bind("onReset", function() {
                try {
                    f(this).find("iframe").hide().attr("src", "//about:blank").end().empty()
                } catch (a) {}
            });
            a.iframe.preload && (b.showLoading(), d.one("load", function() {
                f(this).data("ready", 1);
                t || f(this).bind("load.fb", b.update);
                f(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show();
                b._afterLoad()
            }));
            a.content = d.appendTo(a.inner);
            a.iframe.preload ||
                b._afterLoad()
        },
        _preloadImages: function() {
            var a = b.group,
                d = b.current,
                e = a.length,
                c = d.preload ? Math.min(d.preload, e - 1) : 0,
                f, g;
            for (g = 1; g <= c; g += 1) f = a[(d.index + g) % e], "image" === f.type && f.href && ((new Image).src = f.href)
        },
        _afterLoad: function() {
            var a = b.coming,
                d = b.current,
                e, c, l, g, h;
            b.hideLoading();
            if (a && !1 !== b.isActive)
                if (!1 === b.trigger("afterLoad", a, d)) a.wrap.stop(!0).trigger("onReset").remove(), b.coming = null;
                else {
                    d && (b.trigger("beforeChange", d), d.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove());
                    b.unbindEvents();
                    e = a.content;
                    c = a.type;
                    l = a.scrolling;
                    f.extend(b, {
                        wrap: a.wrap,
                        skin: a.skin,
                        outer: a.outer,
                        inner: a.inner,
                        current: a,
                        previous: d
                    });
                    g = a.href;
                    switch (c) {
                        case "inline":
                        case "ajax":
                        case "html":
                            a.selector ? e = f("<div>").html(e).find(a.selector) : u(e) && (e.data("fancybox-placeholder") || e.data("fancybox-placeholder", f('<div class="fancybox-placeholder"></div>').insertAfter(e).hide()), e = e.show().detach(), a.wrap.bind("onReset", function() {
                                f(this).find(e).length && e.hide().replaceAll(e.data("fancybox-placeholder")).data("fancybox-placeholder", !1)
                            }));
                            break;
                        case "image":
                            e = a.tpl.image.replace(/\{href\}/g, g);
                            break;
                        case "swf":
                            e = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + g + '"></param>', h = "", f.each(a.swf, function(a, b) {
                                e += '<param name="' + a + '" value="' + b + '"></param>';
                                h += " " + a + '="' + b + '"'
                            }), e += '<embed src="' + g + '" type="application/x-shockwave-flash" width="100%" height="100%"' + h + "></embed></object>"
                    }
                    u(e) && e.parent().is(a.inner) || a.inner.append(e);
                    b.trigger("beforeShow");
                    a.inner.css("overflow", "yes" === l ? "scroll" : "no" === l ? "hidden" : l);
                    b._setDimension();
                    b.reposition();
                    b.isOpen = !1;
                    b.coming = null;
                    b.bindEvents();
                    if (!b.isOpened) f(".fancybox-wrap").not(a.wrap).stop(!0).trigger("onReset").remove();
                    else if (d.prevMethod) b.transitions[d.prevMethod]();
                    b.transitions[b.isOpened ? a.nextMethod : a.openMethod]();
                    b._preloadImages()
                }
        },
        _setDimension: function() {
            var a = b.getViewport(),
                d = 0,
                e = !1,
                c = !1,
                e = b.wrap,
                l = b.skin,
                g = b.inner,
                h = b.current,
                c = h.width,
                k = h.height,
                n = h.minWidth,
                v = h.minHeight,
                p = h.maxWidth,
                q = h.maxHeight,
                t = h.scrolling,
                r = h.scrollOutside ? h.scrollbarWidth : 0,
                y = h.margin,
                z = m(y[1] + y[3]),
                s = m(y[0] + y[2]),
                w, A, u, D, B, G, C, E, I;
            e.add(l).add(g).width("auto").height("auto").removeClass("fancybox-tmp");
            y = m(l.outerWidth(!0) - l.width());
            w = m(l.outerHeight(!0) - l.height());
            A = z + y;
            u = s + w;
            D = F(c) ? (a.w - A) * m(c) / 100 : c;
            B = F(k) ? (a.h - u) * m(k) / 100 : k;
            if ("iframe" === h.type) {
                if (I = h.content, h.autoHeight && 1 === I.data("ready")) try {
                    I[0].contentWindow.document.location && (g.width(D).height(9999), G = I.contents().find("body"), r && G.css("overflow-x",
                        "hidden"), B = G.outerHeight(!0))
                } catch (H) {}
            } else if (h.autoWidth || h.autoHeight) g.addClass("fancybox-tmp"), h.autoWidth || g.width(D), h.autoHeight || g.height(B), h.autoWidth && (D = g.width()), h.autoHeight && (B = g.height()), g.removeClass("fancybox-tmp");
            c = m(D);
            k = m(B);
            E = D / B;
            n = m(F(n) ? m(n, "w") - A : n);
            p = m(F(p) ? m(p, "w") - A : p);
            v = m(F(v) ? m(v, "h") - u : v);
            q = m(F(q) ? m(q, "h") - u : q);
            G = p;
            C = q;
            h.fitToView && (p = Math.min(a.w - A, p), q = Math.min(a.h - u, q));
            A = a.w - z;
            s = a.h - s;
            h.aspectRatio ? (c > p && (c = p, k = m(c / E)), k > q && (k = q, c = m(k * E)), c < n && (c = n, k = m(c /
                E)), k < v && (k = v, c = m(k * E))) : (c = Math.max(n, Math.min(c, p)), h.autoHeight && "iframe" !== h.type && (g.width(c), k = g.height()), k = Math.max(v, Math.min(k, q)));
            if (h.fitToView)
                if (g.width(c).height(k), e.width(c + y), a = e.width(), z = e.height(), h.aspectRatio)
                    for (;
                        (a > A || z > s) && c > n && k > v && !(19 < d++);) k = Math.max(v, Math.min(q, k - 10)), c = m(k * E), c < n && (c = n, k = m(c / E)), c > p && (c = p, k = m(c / E)), g.width(c).height(k), e.width(c + y), a = e.width(), z = e.height();
                else c = Math.max(n, Math.min(c, c - (a - A))), k = Math.max(v, Math.min(k, k - (z - s)));
            r && "auto" === t && k < B &&
                c + y + r < A && (c += r);
            g.width(c).height(k);
            e.width(c + y);
            a = e.width();
            z = e.height();
            e = (a > A || z > s) && c > n && k > v;
            c = h.aspectRatio ? c < G && k < C && c < D && k < B : (c < G || k < C) && (c < D || k < B);
            f.extend(h, {
                dim: {
                    width: x(a),
                    height: x(z)
                },
                origWidth: D,
                origHeight: B,
                canShrink: e,
                canExpand: c,
                wPadding: y,
                hPadding: w,
                wrapSpace: z - l.outerHeight(!0),
                skinSpace: l.height() - k
            });
            !I && h.autoHeight && k > v && k < q && !c && g.height("auto")
        },
        _getPosition: function(a) {
            var d = b.current,
                e = b.getViewport(),
                c = d.margin,
                f = b.wrap.width() + c[1] + c[3],
                g = b.wrap.height() + c[0] + c[2],
                c = {
                    position: "absolute",
                    top: c[0],
                    left: c[3]
                };
            d.autoCenter && d.fixed && !a && g <= e.h && f <= e.w ? c.position = "fixed" : d.locked || (c.top += e.y, c.left += e.x);
            c.top = x(Math.max(c.top, c.top + (e.h - g) * d.topRatio));
            c.left = x(Math.max(c.left, c.left + (e.w - f) * d.leftRatio));
            return c
        },
        _afterZoomIn: function() {
            var a = b.current;
            a && ((b.isOpen = b.isOpened = !0, b.wrap.css("overflow", "visible").addClass("fancybox-opened"), b.update(), (a.closeClick || a.nextClick && 1 < b.group.length) && b.inner.css("cursor", "pointer").bind("click.fb", function(d) {
                f(d.target).is("a") || f(d.target).parent().is("a") ||
                    (d.preventDefault(), b[a.closeClick ? "close" : "next"]())
            }), a.closeBtn && f(a.tpl.closeBtn).appendTo(b.skin).bind("click.fb", function(a) {
                a.preventDefault();
                b.close()
            }), a.arrows && 1 < b.group.length && ((a.loop || 0 < a.index) && f(a.tpl.prev).appendTo(b.outer).bind("click.fb", b.prev), (a.loop || a.index < b.group.length - 1) && f(a.tpl.next).appendTo(b.outer).bind("click.fb", b.next)), b.trigger("afterShow"), a.loop || a.index !== a.group.length - 1) ? b.opts.autoPlay && !b.player.isActive && (b.opts.autoPlay = !1, b.play(!0)) : b.play(!1))
        },
        _afterZoomOut: function(a) {
            a = a || b.current;
            f(".fancybox-wrap").trigger("onReset").remove();
            f.extend(b, {
                group: {},
                opts: {},
                router: !1,
                current: null,
                isActive: !1,
                isOpened: !1,
                isOpen: !1,
                isClosing: !1,
                wrap: null,
                skin: null,
                outer: null,
                inner: null
            });
            b.trigger("afterClose", a)
        }
    });
    b.transitions = {
        getOrigPosition: function() {
            var a = b.current,
                d = a.element,
                e = a.orig,
                c = {},
                f = 50,
                g = 50,
                h = a.hPadding,
                k = a.wPadding,
                n = b.getViewport();
            !e && a.isDom && d.is(":visible") && (e = d.find("img:first"), e.length || (e = d));
            u(e) ? (c = e.offset(), e.is("img") &&
                (f = e.outerWidth(), g = e.outerHeight())) : (c.top = n.y + (n.h - g) * a.topRatio, c.left = n.x + (n.w - f) * a.leftRatio);
            if ("fixed" === b.wrap.css("position") || a.locked) c.top -= n.y, c.left -= n.x;
            return c = {
                top: x(c.top - h * a.topRatio),
                left: x(c.left - k * a.leftRatio),
                width: x(f + k),
                height: x(g + h)
            }
        },
        step: function(a, d) {
            var e, c, f = d.prop;
            c = b.current;
            var g = c.wrapSpace,
                h = c.skinSpace;
            if ("width" === f || "height" === f) e = d.end === d.start ? 1 : (a - d.start) / (d.end - d.start), b.isClosing && (e = 1 - e), c = "width" === f ? c.wPadding : c.hPadding, c = a - c, b.skin[f](m("width" ===
                f ? c : c - g * e)), b.inner[f](m("width" === f ? c : c - g * e - h * e))
        },
        zoomIn: function() {
            var a = b.current,
                d = a.pos,
                e = a.openEffect,
                c = "elastic" === e,
                l = f.extend({
                    opacity: 1
                }, d);
            delete l.position;
            c ? (d = this.getOrigPosition(), a.openOpacity && (d.opacity = 0.1)) : "fade" === e && (d.opacity = 0.1);
            b.wrap.css(d).animate(l, {
                duration: "none" === e ? 0 : a.openSpeed,
                easing: a.openEasing,
                step: c ? this.step : null,
                complete: b._afterZoomIn
            })
        },
        zoomOut: function() {
            var a = b.current,
                d = a.closeEffect,
                e = "elastic" === d,
                c = {
                    opacity: 0.1
                };
            e && (c = this.getOrigPosition(), a.closeOpacity &&
                (c.opacity = 0.1));
            b.wrap.animate(c, {
                duration: "none" === d ? 0 : a.closeSpeed,
                easing: a.closeEasing,
                step: e ? this.step : null,
                complete: b._afterZoomOut
            })
        },
        changeIn: function() {
            var a = b.current,
                d = a.nextEffect,
                e = a.pos,
                c = {
                    opacity: 1
                },
                f = b.direction,
                g;
            e.opacity = 0.1;
            "elastic" === d && (g = "down" === f || "up" === f ? "top" : "left", "down" === f || "right" === f ? (e[g] = x(m(e[g]) - 200), c[g] = "+=200px") : (e[g] = x(m(e[g]) + 200), c[g] = "-=200px"));
            "none" === d ? b._afterZoomIn() : b.wrap.css(e).animate(c, {
                duration: a.nextSpeed,
                easing: a.nextEasing,
                complete: b._afterZoomIn
            })
        },
        changeOut: function() {
            var a = b.previous,
                d = a.prevEffect,
                e = {
                    opacity: 0.1
                },
                c = b.direction;
            "elastic" === d && (e["down" === c || "up" === c ? "top" : "left"] = ("up" === c || "left" === c ? "-" : "+") + "=200px");
            a.wrap.animate(e, {
                duration: "none" === d ? 0 : a.prevSpeed,
                easing: a.prevEasing,
                complete: function() {
                    f(this).trigger("onReset").remove()
                }
            })
        }
    };
    b.helpers.overlay = {
        defaults: {
            closeClick: !0,
            speedOut: 200,
            showEarly: !0,
            css: {},
            locked: !t,
            fixed: !0
        },
        overlay: null,
        fixed: !1,
        el: f("html"),
        create: function(a) {
            var d;
            a = f.extend({}, this.defaults, a);
            this.overlay &&
                this.close();
            d = b.coming ? b.coming.parent : a.parent;
            this.overlay = f('<div class="fancybox-overlay"></div>').appendTo(d && d.lenth ? d : "body");
            this.fixed = !1;
            a.fixed && b.defaults.fixed && (this.overlay.addClass("fancybox-overlay-fixed"), this.fixed = !0)
        },
        open: function(a) {
            var d = this;
            a = f.extend({}, this.defaults, a);
            this.overlay ? this.overlay.unbind(".overlay").width("auto").height("auto") : this.create(a);
            this.fixed || (q.bind("resize.overlay", f.proxy(this.update, this)), this.update());
            a.closeClick && this.overlay.bind("click.overlay",
                function(a) {
                    if (f(a.target).hasClass("fancybox-overlay")) return b.isActive ? b.close() : d.close(), !1
                });
            this.overlay.css(a.css).show()
        },
        close: function() {
            q.unbind("resize.overlay");
            this.el.hasClass("fancybox-lock") && (f(".fancybox-margin").removeClass("fancybox-margin"), this.el.removeClass("fancybox-lock"), q.scrollTop(this.scrollV).scrollLeft(this.scrollH));
            f(".fancybox-overlay").remove().hide();
            f.extend(this, {
                overlay: null,
                fixed: !1
            })
        },
        update: function() {
            var a = "100%",
                b;
            this.overlay.width(a).height("100%");
            J ? (b = Math.max(H.documentElement.offsetWidth, H.body.offsetWidth), p.width() > b && (a = p.width())) : p.width() > q.width() && (a = p.width());
            this.overlay.width(a).height(p.height())
        },
        onReady: function(a, b) {
            var e = this.overlay;
            f(".fancybox-overlay").stop(!0, !0);
            e || this.create(a);
            a.locked && this.fixed && b.fixed && (b.locked = this.overlay.append(b.wrap), b.fixed = !1);
            !0 === a.showEarly && this.beforeShow.apply(this, arguments)
        },
        beforeShow: function(a, b) {
            b.locked && !this.el.hasClass("fancybox-lock") && (!1 !== this.fixPosition && f("*").filter(function() {
                return "fixed" ===
                    f(this).css("position") && !f(this).hasClass("fancybox-overlay") && !f(this).hasClass("fancybox-wrap")
            }).addClass("fancybox-margin"), this.el.addClass("fancybox-margin"), this.scrollV = q.scrollTop(), this.scrollH = q.scrollLeft(), this.el.addClass("fancybox-lock"), q.scrollTop(this.scrollV).scrollLeft(this.scrollH));
            this.open(a)
        },
        onUpdate: function() {
            this.fixed || this.update()
        },
        afterClose: function(a) {
            this.overlay && !b.coming && this.overlay.fadeOut(a.speedOut, f.proxy(this.close, this))
        }
    };
    b.helpers.title = {
        defaults: {
            type: "float",
            position: "bottom"
        },
        beforeShow: function(a) {
            var d = b.current,
                e = d.title,
                c = a.type;
            f.isFunction(e) && (e = e.call(d.element, d));
            if (r(e) && "" !== f.trim(e)) {
                d = f('<div class="fancybox-title fancybox-title-' + c + '-wrap">' + e + "</div>");
                switch (c) {
                    case "inside":
                        c = b.skin;
                        break;
                    case "outside":
                        c = b.wrap;
                        break;
                    case "over":
                        c = b.inner;
                        break;
                    default:
                        c = b.skin, d.appendTo("body"), J && d.width(d.width()), d.wrapInner('<span class="child"></span>'), b.current.margin[2] += Math.abs(m(d.css("margin-bottom")))
                }
                d["top" === a.position ? "prependTo" :
                    "appendTo"](c)
            }
        }
    };
    f.fn.fancybox = function(a) {
        var d, e = f(this),
            c = this.selector || "",
            l = function(g) {
                var h = f(this).blur(),
                    k = d,
                    l, m;
                g.ctrlKey || g.altKey || g.shiftKey || g.metaKey || h.is(".fancybox-wrap") || (l = a.groupAttr || "data-fancybox-group", m = h.attr(l), m || (l = "rel", m = h.get(0)[l]), m && "" !== m && "nofollow" !== m && (h = c.length ? f(c) : e, h = h.filter("[" + l + '="' + m + '"]'), k = h.index(this)), a.index = k, !1 !== b.open(h, a) && g.preventDefault())
            };
        a = a || {};
        d = a.index || 0;
        c && !1 !== a.live ? p.undelegate(c, "click.fb-start").delegate(c + ":not('.fancybox-item, .fancybox-nav')",
            "click.fb-start", l) : e.unbind("click.fb-start").bind("click.fb-start", l);
        this.filter("[data-fancybox-start=1]").trigger("click");
        return this
    };
    p.ready(function() {
        var a, d;
        f.scrollbarWidth === w && (f.scrollbarWidth = function() {
            var a = f('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"),
                b = a.children(),
                b = b.innerWidth() - b.height(99).innerWidth();
            a.remove();
            return b
        });
        f.support.fixedPosition === w && (f.support.fixedPosition = function() {
            var a = f('<div style="position:fixed;top:20px;"></div>').appendTo("body"),
                b = 20 === a[0].offsetTop || 15 === a[0].offsetTop;
            a.remove();
            return b
        }());
        f.extend(b.defaults, {
            scrollbarWidth: f.scrollbarWidth(),
            fixed: f.support.fixedPosition,
            parent: f("body")
        });
        a = f(s).width();
        K.addClass("fancybox-lock-test");
        d = f(s).width();
        K.removeClass("fancybox-lock-test");
        f("<style type='text/css'>.fancybox-margin{margin-right:" + (d - a) + "px;}</style>").appendTo("head")
    })
})(window, document, jQuery);






/*!
 * Media helper for fancyBox
 * version: 1.0.6 (Fri, 14 Jun 2013)
 * @requires fancyBox v2.0 or later
 *
 * Usage:
 *     $(".fancybox").fancybox({
 *         helpers : {
 *             media: true
 *         }
 *     });
 *
 * Set custom URL parameters:
 *     $(".fancybox").fancybox({
 *         helpers : {
 *             media: {
 *                 youtube : {
 *                     params : {
 *                         autoplay : 0
 *                     }
 *                 }
 *             }
 *         }
 *     });
 *
 * Or:
 *     $(".fancybox").fancybox({,
 *         helpers : {
 *             media: true
 *         },
 *         youtube : {
 *             autoplay: 0
 *         }
 *     });
 *
 *  Supports:
 *
 *      Youtube
 *          http://www.youtube.com/watch?v=opj24KnzrWo
 *          http://www.youtube.com/embed/opj24KnzrWo
 *          http://youtu.be/opj24KnzrWo
 *          http://www.youtube-nocookie.com/embed/opj24KnzrWo
 *      Vimeo
 *          http://vimeo.com/40648169
 *          http://vimeo.com/channels/staffpicks/38843628
 *          http://vimeo.com/groups/surrealism/videos/36516384
 *          http://player.vimeo.com/video/45074303
 *      Metacafe
 *          http://www.metacafe.com/watch/7635964/dr_seuss_the_lorax_movie_trailer/
 *          http://www.metacafe.com/watch/7635964/
 *      Dailymotion
 *          http://www.dailymotion.com/video/xoytqh_dr-seuss-the-lorax-premiere_people
 *      Twitvid
 *          http://twitvid.com/QY7MD
 *      Twitpic
 *          http://twitpic.com/7p93st
 *      Instagram
 *          http://instagr.am/p/IejkuUGxQn/
 *          http://instagram.com/p/IejkuUGxQn/
 *      Google maps
 *          http://maps.google.com/maps?q=Eiffel+Tower,+Avenue+Gustave+Eiffel,+Paris,+France&t=h&z=17
 *          http://maps.google.com/?ll=48.857995,2.294297&spn=0.007666,0.021136&t=m&z=16
 *          http://maps.google.com/?ll=48.859463,2.292626&spn=0.000965,0.002642&t=m&z=19&layer=c&cbll=48.859524,2.292532&panoid=YJ0lq28OOy3VT2IqIuVY0g&cbp=12,151.58,,0,-15.56
 */
(function ($) {
    "use strict";

    //Shortcut for fancyBox object
    var F = $.fancybox,
        format = function( url, rez, params ) {
            params = params || '';

            if ( $.type( params ) === "object" ) {
                params = $.param(params, true);
            }

            $.each(rez, function(key, value) {
                url = url.replace( '$' + key, value || '' );
            });

            if (params.length) {
                url += ( url.indexOf('?') > 0 ? '&' : '?' ) + params;
            }

            return url;
        };

    //Add helper object
    F.helpers.media = {
        defaults : {
            youtube : {
                matcher : /(youtube\.com|youtu\.be|youtube-nocookie\.com)\/(watch\?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*)).*/i,
                params  : {
                    autoplay    : 1,
                    autohide    : 1,
                    fs          : 1,
                    rel         : 0,
                    hd          : 1,
                    wmode       : 'opaque',
                    enablejsapi : 1
                },
                type : 'iframe',
                url  : '//www.youtube.com/embed/$3'
            },
            vimeo : {
                matcher : /(?:vimeo(?:pro)?.com)\/(?:[^\d]+)?(\d+)(?:.*)/,
                params  : {
                    autoplay      : 1,
                    hd            : 1,
                    show_title    : 1,
                    show_byline   : 1,
                    show_portrait : 0,
                    fullscreen    : 1
                },
                type : 'iframe',
                url  : '//player.vimeo.com/video/$1'
            },
            metacafe : {
                matcher : /metacafe.com\/(?:watch|fplayer)\/([\w\-]{1,10})/,
                params  : {
                    autoPlay : 'yes'
                },
                type : 'swf',
                url  : function( rez, params, obj ) {
                    obj.swf.flashVars = 'playerVars=' + $.param( params, true );

                    return '//www.metacafe.com/fplayer/' + rez[1] + '/.swf';
                }
            },
            dailymotion : {
                matcher : /dailymotion.com\/video\/(.*)\/?(.*)/,
                params  : {
                    additionalInfos : 0,
                    autoStart : 1
                },
                type : 'swf',
                url  : '//www.dailymotion.com/swf/video/$1'
            },
            twitvid : {
                matcher : /twitvid\.com\/([a-zA-Z0-9_\-\?\=]+)/i,
                params  : {
                    autoplay : 0
                },
                type : 'iframe',
                url  : '//www.twitvid.com/embed.php?guid=$1'
            },
            twitpic : {
                matcher : /twitpic\.com\/(?!(?:place|photos|events)\/)([a-zA-Z0-9\?\=\-]+)/i,
                type : 'image',
                url  : '//twitpic.com/show/full/$1/'
            },
            instagram : {
                matcher : /(instagr\.am|instagram\.com)\/p\/([a-zA-Z0-9_\-]+)\/?/i,
                type : 'image',
                url  : '//$1/p/$2/media/?size=l'
            },
            google_maps : {
                matcher : /maps\.google\.([a-z]{2,3}(\.[a-z]{2})?)\/(\?ll=|maps\?)(.*)/i,
                type : 'iframe',
                url  : function( rez ) {
                    return '//maps.google.' + rez[1] + '/' + rez[3] + '' + rez[4] + '&output=' + (rez[4].indexOf('layer=c') > 0 ? 'svembed' : 'embed');
                }
            } 
        },

        beforeLoad : function(opts, obj) {
            var url   = obj.href || '',
                type  = false,
                what,
                item,
                rez,
                params;

            for (what in opts) {
                if (opts.hasOwnProperty(what)) {
                    item = opts[ what ];
                    rez  = url.match( item.matcher );

                    if (rez) {
                        type   = item.type;
                        params = $.extend(true, {}, item.params, obj[ what ] || ($.isPlainObject(opts[ what ]) ? opts[ what ].params : null));

                        url = $.type( item.url ) === "function" ? item.url.call( this, rez, params, obj ) : format( item.url, rez, params );

                        break;
                    }
                }
            }

            if (type) {
                obj.href = url;
                obj.type = type;

                obj.autoHeight = false;
            }
        }
    };

}(jQuery));