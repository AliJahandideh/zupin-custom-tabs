// Easy Responsive Tabs Plugin
// Author: Samson.Onna <Email : samson3d@gmail.com> 
(function ($) {
    $.fn.extend({
        easyResponsiveTabs: function (options) {
            //Set the default values, use comma to separate the settings, example:
            var defaults = {
                type: 'default', //default, vertical, accordion;
                width: 'auto',
                fit: true,
                closed: false,
                tabidentify: '',
                activetab_bg: '#111',
                inactive_bg: '#fff',
                active_border_color: '#111',
                active_content_border_color: '#111',
                activate: function () {
                }
            }
            //Variables
            var options = $.extend(defaults, options);
            var opt = options, jtype = opt.type, jfit = opt.fit, jwidth = opt.width, vtabs = 'vertical', accord = 'accordion';
            var hash = window.location.hash;

            //Events
            $(this).bind('tabactivate', function (e, currentTab) {
                if (typeof options.activate === 'function') {
                    options.activate.call(currentTab, e)
                }
            });

            //Main function
            this.each(function () {
                var $respTabs = $(this);
                var $respTabsList = $respTabs.find('ul.zup-tabs-list.' + options.tabidentify);
                var respTabsId = $respTabs.attr('id');
                $respTabs.find('ul.zup-tabs-list.' + options.tabidentify + ' li').addClass('zup-tab-item').addClass('zup-tab').addClass(options.tabidentify);
                $respTabs.css({
                    'display': 'flex',
                    'width': jwidth
                });

                $respTabs.find('.zup-tabs-container.' + options.tabidentify).css('border-color', options.active_content_border_color);
                $respTabs.find('.zup-tabs-container.' + options.tabidentify + ' > div').addClass('zup-tab-content').addClass(options.tabidentify);
                jtab_options();
                //Properties Function
                function jtab_options() {
                    if (jtype == vtabs) {
                        $respTabs.addClass('zup-vertical-tabs').addClass(options.tabidentify);
                    }
                    if (jfit == true) {
                        $respTabs.css({ width: '100%', margin: '0px' });
                    }
                    if (jtype == accord) {
                        $respTabs.addClass('zup-easy-accordion').addClass(options.tabidentify);
                        $respTabs.find('.zup-tabs-list').css('display', 'none');
                    }
                }

                //Assigning the h2 markup to accordion title
                var $tabItemh2;
                $respTabs.find('.zup-tab-content.' + options.tabidentify).before("<h2 class='zup-accordion zup-tab " + options.tabidentify + "' role='tab'><span class='zup-arrow'></span></h2>");

                $respTabs.find('.zup-tab-content.' + options.tabidentify).prev("h2").css({
                    'background-color': options.inactive_bg,
                    'border-color': options.active_border_color
                });

                var itemCount = 0;
                $respTabs.find('.zup-accordion').each(function () {
                    $tabItemh2 = $(this);
                    var $tabItem = $respTabs.find('.zup-tab-item:eq(' + itemCount + ')');
                    var $accItem = $respTabs.find('.zup-accordion:eq(' + itemCount + ')');
                    $accItem.append($tabItem.html());
                    $accItem.data($tabItem.data());
                    $tabItemh2.attr('aria-controls', options.tabidentify + '_tab_item-' + (itemCount));
                    itemCount++;
                });

                //Assigning the 'aria-controls' to Tab items
                var count = 0,
                    $tabContent;
                $respTabs.find('.zup-tab-item').each(function () {
                    $tabItem = $(this);
                    $tabItem.attr('aria-controls', options.tabidentify + '_tab_item-' + (count));
                    $tabItem.attr('role', 'tab');
                    $tabItem.css({
                        'background-color': options.inactive_bg,
                        'border-color': 'none'
                    });

                    //Assigning the 'aria-labelledby' attr to tab-content
                    var tabcount = 0;
                    $respTabs.find('.zup-tab-content.' + options.tabidentify).each(function () {
                        $tabContent = $(this);
                        $tabContent.attr('aria-labelledby', options.tabidentify + '_tab_item-' + (tabcount)).css({
                            'border-color': options.active_border_color
                        });
                        tabcount++;
                    });
                    count++;
                });

                // Show correct content area
                var tabNum = 0;
                if (hash != '') {
                    var matches = hash.match(new RegExp(respTabsId + "([0-9]+)"));
                    if (matches !== null && matches.length === 2) {
                        tabNum = parseInt(matches[1], 10) - 1;
                        if (tabNum > count) {
                            tabNum = 0;
                        }
                    }
                }

                //Active correct tab
                $($respTabs.find('.zup-tab-item.' + options.tabidentify)[tabNum]).addClass('zup-tab-active').css({
                    'background-color': options.activetab_bg,
                    'border-color': options.active_border_color
                });

                //keep closed if option = 'closed' or option is 'accordion' and the element is in accordion mode
                if (options.closed !== true && !(options.closed === 'accordion' && !$respTabsList.is(':visible')) && !(options.closed === 'tabs' && $respTabsList.is(':visible'))) {
                    $($respTabs.find('.zup-accordion.' + options.tabidentify)[tabNum]).addClass('zup-tab-active').css({
                        'background-color': options.activetab_bg + ' !important',
                        'border-color': options.active_border_color,
                        'background': 'none'
                    });

                    $($respTabs.find('.zup-tab-content.' + options.tabidentify)[tabNum]).addClass('zup-tab-content-active').addClass(options.tabidentify).attr('style', 'display:block');
                }
                //assign proper classes for when tabs mode is activated before making a selection in accordion mode
                else {
                   // $($respTabs.find('.zup-tab-content.' + options.tabidentify)[tabNum]).addClass('zup-accordion-closed'); //removed zup-tab-content-active
                }

                //Tab Click action function
                $respTabs.find("[role=tab]").each(function () {

                    var $currentTab = $(this);
                    $currentTab.click(function () {

                        var $currentTab = $(this);
                        var $tabAria = $currentTab.attr('aria-controls');

                        if ($currentTab.hasClass('zup-accordion') && $currentTab.hasClass('zup-tab-active')) {
                            $respTabs.find('.zup-tab-content-active.' + options.tabidentify).slideUp('', function () {
                                $(this).addClass('zup-accordion-closed');
                            });
                            $currentTab.removeClass('zup-tab-active').css({
                                'background-color': options.inactive_bg,
                                'border-color': 'none'
                            });
                            return false;
                        }
                        if (!$currentTab.hasClass('zup-tab-active') && $currentTab.hasClass('zup-accordion')) {
                            $respTabs.find('.zup-tab-active.' + options.tabidentify).removeClass('zup-tab-active').css({
                                'background-color': options.inactive_bg,
                                'border-color': 'none'
                            });
                            $respTabs.find('.zup-tab-content-active.' + options.tabidentify).slideUp().removeClass('zup-tab-content-active zup-accordion-closed');
                            $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('zup-tab-active').css({
                                'background-color': options.activetab_bg,
                                'border-color': options.active_border_color
                            });

                            $respTabs.find('.zup-tab-content[aria-labelledby = ' + $tabAria + '].' + options.tabidentify).slideDown().addClass('zup-tab-content-active');
                        } else {
                            $respTabs.find('.zup-tab-active.' + options.tabidentify).removeClass('zup-tab-active').css({
                                'background-color': options.inactive_bg,
                                'border-color': 'none'
                            });

                            $respTabs.find('.zup-tab-content-active.' + options.tabidentify).removeAttr('style').removeClass('zup-tab-content-active').removeClass('zup-accordion-closed');

                            $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('zup-tab-active').css({
                                'background-color': options.activetab_bg,
                                'border-color': options.active_border_color
                            });

                            $respTabs.find('.zup-tab-content[aria-labelledby = ' + $tabAria + '].' + options.tabidentify).addClass('zup-tab-content-active').attr('style', 'display:block');
                        }
                        //Trigger tab activation event
                        $currentTab.trigger('tabactivate', $currentTab);

                    });

                });

                //Window resize function                   
                $(window).resize(function () {
                    $respTabs.find('.zup-accordion-closed').removeAttr('style');
                });
            });
        }
    });
})(jQuery);