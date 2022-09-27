/*
The CSS animation generator tool allows you to create over 50 different preset animations.

    Bounce
    Bounce In
    Bounce In Up
    Bounce In Down
    Bounce In Left
    Bounce In Right
    Bounce Out
    Bounce Out Up
    Bounce Out Down
    Bounce Out Left
    Bounce Out Right
    Fade In
    Fade In Up
    Fade In Down
    Fade In Left
    Fade In Right
    Fade In Up Big
    Fade In Down Big
    Fade In Left Big
    Fade In Right Big
    Fade Out
    Fade Out Up
    Fade Out Down
    Fade Out Left
    Fade Out Right
    Fade Out Up Big
    Fade Out Down Big
    Fade Out Left Big
    Fade Out Right Big
    Flash
    Flip
    Flip In X
    Flip Out X
    Flip In Y
    Flip Out Y
    Hinge
    Light Speed In
    Light Speed Out
    Pulse
    Rotate In
    Rotate In Up Left
    Rotate In Down Left
    Rotate In Up Right
    Rotate In Down Right
    Rotate Out
    Rotate Out Up Left
    Rotate Out Down Left
    Rotate Out Up Right
    Rotate Out Down Right
    Roll In
    Roll Out
    Shake
    Swing
    Tada
    Wiggle
    Wobble
*/
(function (d) {
    var p = {}, e, a, h = document,
        i = window,
        f = h.documentElement,
        j = d.expando;
    d.event.special.inview = {
        add: function (a) {
            p[a.guid + "-" + this[j]] = {
                data: a,
                jQueryelement: d(this)
            }
        },
        remove: function (a) {
            try {
                delete p[a.guid + "-" + this[j]]
            } catch (d) {}
        }
    };
    d(i).bind("scroll resize", function () {
        e = a = null
    });
    !f.addEventListener && f.attachEvent && f.attachEvent("onfocusin", function () {
        a = null
    });
    setInterval(function () {
        var k = d(),
            j, n = 0;
        d.each(p, function (a, b) {
            var c = b.data.selector,
                d = b.jQueryelement;
            k = k.add(c ? d.find(c) : d)
        });
        if (j = k.length) {
            var b;
            if (!(b = e)) {
                var g = {
                    height: i.innerHeight,
                    width: i.innerWidth
                };
                if (!g.height && ((b = h.compatMode) || !d.support.boxModel)) b = "CSS1Compat" === b ? f : h.body, g = {
                    height: b.clientHeight,
                    width: b.clientWidth
                };
                b = g
            }
            e = b;
            for (a = a || {
                top: i.pageYOffset || f.scrollTop || h.body.scrollTop,
                left: i.pageXOffset || f.scrollLeft || h.body.scrollLeft
            }; n < j; n++)
                if (d.contains(f, k[n])) {
                    b = d(k[n]);
                    var l = b.height(),
                        m = b.width(),
                        c = b.offset(),
                        g = b.data("inview");
                    if (!a || !e) break;
                    c.top + l > a.top && c.top < a.top + e.height && c.left + m > a.left && c.left < a.left + e.width ?
                        (m = a.left > c.left ? "right" : a.left + e.width < c.left + m ? "left" : "both", l = a.top > c.top ? "bottom" : a.top + e.height < c.top + l ? "top" : "both", c = m + "-" + l, (!g || g !== c) && b.data("inview", c).trigger("inview", [!0, m, l])) : g && b.data("inview", !1).trigger("inview", [!1])
                }
        }
    }, 1000)
})(jQuery);
/* ======= Animations ======= */
jQuery(document).ready(function(jQuery) {

    
    //Only animate elements when using non-mobile devices

        // Landinhg page animation start
        /*
        jQuery('.animate_home_intro_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_home_intro_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.landing_provide_title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUp delayp1');}
        });
        jQuery('.landing_provide_innerTitle_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeftBig delayp1');}
        });
        jQuery('.landing_provide_innerTitle_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRightBig delayp1');}
        });
        jQuery('.animate_provide_items_box_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp2');}
        });
        jQuery('.animate_provide_items_box_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp2');}
        });
        jQuery('.animate_provide_btn_wrap').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDownBig delayp1');}
        });
        jQuery('.animate_spotlight_box').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.animate_landing_spotlight_infoWrap').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.animate_product_video_wrap').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_product_video_infobox').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.animate_visit_studio').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUpBig delayp1');}
        });
        jQuery('.animate_sourcing_info_box_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_sourcing_info_box_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.animate-app-store').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUp delayp2');}
        });
        jQuery('.google-play-store').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp2');}
        });
        jQuery('.animate_landing_tools_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_landing_tools_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.animate_tools_button_box').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUp delayp1');}
        });
        jQuery('.landing_request_toptitle').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.landing_request_title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.animate_landing_request_img').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUp delayp1');}
        });
        jQuery('.animate_btn_border_black').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_btn_talk').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        */
        // Landinhg page animation end


        // How works page animation start
        jQuery('.animate_how_work').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
        jQuery('.animate_document_tab_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_document_tab_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.animate_title_and_tags').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
        jQuery('.animate_tag_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_tag_top').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.animate_tag_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });


        jQuery('.animate_icon_box_one').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp1');}
        });
        jQuery('.animate_icon_count_box_one').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp1');}
        });
        jQuery('.animate_icon_details_box_one').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.animate_icon_box_two').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp2');}
        });
        jQuery('.animate_icon_count_box_two').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp2');}
        });
        jQuery('.animate_icon_details_box_two').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp2');}
        });

        jQuery('.animate_icon_box_three').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp3');}
        });
        jQuery('.animate_icon_count_box_three').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp3');}
        });
        jQuery('.animate_icon_details_box_three').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp3');}
        });

        jQuery('.animate_icon_box_four').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp4');}
        });
        jQuery('.animate_icon_count_box_four').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp4');}
        });
        jQuery('.animate_icon_details_box_four').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp4');}
        });

        jQuery('.animate_icon_box_five').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp5');}
        });
        jQuery('.animate_icon_count_box_five').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp5');}
        });
        jQuery('.animate_icon_details_box_five').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp5');}
        });

        jQuery('.animate_icon_box_six').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp6');}
        });
        jQuery('.animate_icon_count_box_six').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp6');}
        });
        jQuery('.animate_icon_details_box_six').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp6');}
        });

        jQuery('.animate_icon_box_seven').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp6');}
        });
        jQuery('.animate_icon_count_box_seven').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp6');}
        });
        jQuery('.animate_icon_details_box_seven').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp6');}
        });

        jQuery('.animate_feature_box_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_feature_box_top').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.animate_feature_box_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });

        jQuery('.animate_box_img_1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp1');}
        });
        jQuery('.animate_box_description_1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });

        jQuery('.animate_box_img_2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp1');}
        });
        jQuery('.animate_box_description_2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });

        jQuery('.animate_box_img_3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp1');}
        });
        jQuery('.animate_box_description_3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });

        jQuery('.animate_request_quotation_title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.animate_request_btn_green').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUp delayp1');}
        });

        jQuery('.animate_how_work').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
        jQuery('.animate_why_us_title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });

        jQuery('.animate_manuf_title_and_tags').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });

        jQuery('.animate_manuf_tag_left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_manuf_tag_top').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.animate_manuf_tag_right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });

        jQuery('.animate_icon_box_1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp2');}
        });
        jQuery('.animate_icon_count_box_1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp2');}
        });
        jQuery('.animate_icon_details_box_1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.animate_icon_box_2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp2');}
        });
        jQuery('.animate_icon_count_box_2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp2');}
        });
        jQuery('.animate_icon_details_box_2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp2');}
        });
        jQuery('.animate_icon_box_3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp3');}
        });
        jQuery('.animate_icon_count_box_3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp3');}
        });
        jQuery('.animate_icon_details_box_3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp3');}
        });
        jQuery('.animate_icon_box_4').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp4');}
        });
        jQuery('.animate_icon_count_box_4').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp4');}
        });
        jQuery('.animate_icon_details_box_4').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp4');}
        });
        jQuery('.animate_icon_box_5').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateIn delayp5');}
        });
        jQuery('.animate_icon_count_box_5').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated rotateInUpRight delayp5');}
        });
        jQuery('.animate_icon_details_box_5').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp5');}
        });


        jQuery('.animate_why_us_box_6').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.animate_why_us_box_5').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp2');}
        });
        jQuery('.animate_why_us_box_4').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp3');}
        });
        jQuery('.animate_why_us_box_3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp4');}
        });
        jQuery('.animate_why_us_box_2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp5');}
        });
        jQuery('.animate_why_us_box_1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp6');}
        });
        

        jQuery('.animate_menuf_request_quotation').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDown delayp1');}
        });
        jQuery('.animate_menuf_btn_green').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUp delayp1');}
        });



        // How works page animation end


        // About Us page animation start
        jQuery('.about-section-title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
        jQuery('.about-content-left').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.about-content-right').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.yellow-box').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInUp delayp1');}
        });
        jQuery('.work-process-title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
		jQuery('.work_process-box-6').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.work_process-box-5').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp2');}
        });
        jQuery('.work_process-box-4').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp3');}
        });
        jQuery('.work_process-box-3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp4');}
        });
        jQuery('.work_process-box-2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp5');}
        });
        jQuery('.work_process-box-1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp6');}
        });
        jQuery('.how-we-work-btn').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDownBig delayp1');}
        });
        jQuery('.we-believe-img').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRightBig delayp1');}
        });
        jQuery('.we-believe-title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
        jQuery('.we_believe_container').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
        jQuery('.achieved-title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInDownBig delayp1');}
        });
        jQuery('.achivement-box-1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.achivement-box-2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.achivement-box-3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp2');}
        });
        jQuery('.achivement-box-4').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp2');}
        });
        jQuery('.achivement-box-5').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp3');}
        });
        jQuery('.achivement-box-6').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp3');}
        });
        jQuery('.vision-box').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.mission-box').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInRight delayp1');}
        });
        jQuery('.paths-title').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeIn delayp1');}
        });
        jQuery('.path-box-1').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp1');}
        });
        jQuery('.path-box-2').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp2');}
        });
        jQuery('.path-box-3').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp3');}
        });
        jQuery('.path-box-4').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp4');}
        });
        jQuery('.path-box-5').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp5');}
        });
        jQuery('.path-box-6').css('opacity', 0).one('inview', function(isInView) {
            if (isInView) {jQuery(this).addClass('animated fadeInLeft delayp6');}
        });
        // About Us page animation end
        
		

});