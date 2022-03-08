 /*

* Custom Easy Pagination plugin

* Update on 26 agust 2019

* Version 1.1.4

* original Repo : https://st3ph.github.io/jquery.easyPaginate/

* Licensed under GPL <http://en.wikipedia.org/wiki/GNU_General_Public_License>

* Copyright (c) 2019

* All rights reserved.

*

    This program is free software: you can redistribute it and/or modify

    it under the terms of the GNU General Public License as published by

    the Free Software Foundation, either version 3 of the License, or

    (at your option) any later version.



    This program is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.



    You should have received a copy of the GNU General Public License

    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/



(function($) {

    $.fn.easyPaginate = function(options) {

        var defaults = {

            paginateElement: "li",

            hashPage: "page",

            elementsPerPage: 10,

            effect: "default",

            slideOffset: 200,

            firstButton: true,

            firstButtonText: "<<",

            lastButton: true,

            lastButtonText: ">>",

            prevButton: true,

            prevButtonText: "<",

            nextButton: true,

            nextButtonText: ">",

            position: "bottom",

            doublePagination:true



        };



        return this.each(function(instance) {

            var plugin = {};

            plugin.el = $(this);

            plugin.el.addClass("easyPaginateList");



            plugin.settings = {

                pages: 0,

                objElements: Object,

                currentPage: 1

            };



            var getNbOfPages = function() {

                return Math.ceil(

                    plugin.settings.objElements.length /

                    plugin.settings.elementsPerPage

                );

            };



            var displayNav = function() {

                var htmlNav = '<nav aria-label="Page navigation"><div class="easyPaginateNav pagination pg-blue justify-content-center"><div class="elements_in_class"></div>';



                if (plugin.settings.firstButton) {

                    htmlNav += '<li class="page-item"><a href="#' + plugin.settings.hashPage + ':1" title="First page" rel="1" class="first page-link">' + plugin.settings.firstButtonText + "</a></li>";

                }



                if (plugin.settings.prevButton) {

                    htmlNav += '<li class="page-item"><a href="" title="Previous" rel="" class="prev page-link">' + plugin.settings.prevButtonText + "</a></li>";

                }



                for (var i = 1; i <= plugin.settings.pages; i++) {

                    htmlNav += '<li class="page-item"><a href="#' + plugin.settings.hashPage + ":" + i + '" title="Page ' + i + '" rel="' + i + '" class="page page-link">' + i + "</a></li>";

                }



                if (plugin.settings.nextButton) {

                    htmlNav += '<li class="page-item"><a href="" title="Next" rel="" class="next page-link">' + plugin.settings.nextButtonText + "</a></li>";

                }



                if (plugin.settings.lastButton) {

                    htmlNav += '<li class="page-item"><a href="#' + plugin.settings.hashPage + ":" + plugin.settings.pages + '" title="Last page" rel="' +

                        plugin.settings.pages + '" class="last page-link">' + plugin.settings.lastButtonText + "</a></li>";

                }



                htmlNav += "</div></nav>";

                plugin.nav = $(htmlNav);

                plugin.nav.css({

                    //  'width': plugin.el.width()

                });

                plugin.el.after(plugin.nav);



                var elSelector = ".easyPaginateNav";



                setTimeout(function() {

                    if(plugin.settings.doublePagination){

                      $(".easyPaginateNav")

                      .clone()

                      .prependTo("#paginationNav");

                    }

                    $(elSelector + " a.page," + elSelector + " a.first," + elSelector + " a.last").on("click", function(e) {

                        e.preventDefault();

                        displayPage($(this).attr("rel"));

                    });



                    $(elSelector + " a.prev").on("click", function(e) {

                        e.preventDefault();

                        page = plugin.settings.currentPage > 1 ? parseInt(plugin.settings.currentPage) - 1 : 1;

                        displayPage(page);

                    });



                    $(elSelector + " a.next").on("click", function(e) {

                        e.preventDefault();

                        page = plugin.settings.currentPage < plugin.settings.pages ? parseInt(plugin.settings.currentPage) + 1 : plugin.settings.pages;

                        displayPage(page);



                    });

                }, 01);

            };



            var displayPage = function(page, forceEffect) {



                if (plugin.settings.currentPage != page) {

                    plugin.settings.currentPage = parseInt(page);

                    offsetStart = (page - 1) * plugin.settings.elementsPerPage;

                    offsetEnd = page * plugin.settings.elementsPerPage;

                    if (typeof forceEffect != "undefined") {

                        eval("transition_" + forceEffect + "(" + offsetStart + ", " + offsetEnd + ")");

                    } else {

                        eval("transition_" + plugin.settings.effect + "(" + offsetStart + ", " + offsetEnd + ")");

                    }



                    plugin.nav.find(".current").removeClass("current").parent().removeClass('active');

                    plugin.nav.find("a.page:eq(" + (page - 1) + ")").addClass("current").parent().addClass('active');



                    if(plugin.settings.doublePagination){

                      $('.easyPaginateNav').find(".current").removeClass("current").parent().removeClass('active');

                      $('.easyPaginateNav').find("a.page:eq(" + (page - 1) + ")").addClass("current").parent().addClass('active');

                    }



                    switch (plugin.settings.currentPage) {

                        case 1:

                            $(".easyPaginateNav a").removeClass("disabled").parent().removeClass('disabled');

                            $(".easyPaginateNav a.first, .easyPaginateNav a.prev").addClass("disabled").parent().addClass('disabled');

                            break;

                        case plugin.settings.pages:

                            $(".easyPaginateNav a").removeClass("disabled").parent().removeClass('disabled');

                            $(".easyPaginateNav a.last, .easyPaginateNav a.next").addClass("disabled").parent().addClass('disabled');

                            break;

                        default:

                            $(".easyPaginateNav a").removeClass("disabled").parent().removeClass('disabled');

                            break;

                    }

                }

                //$(".elements_in_class").empty().text("1 - " + $(".full_card").size() + " de " + plugin.settings.objElements.length + " resultados");

            };



            var transition_default = function(offsetStart, offsetEnd) {

                plugin.currentElements.hide();

                plugin.currentElements = plugin.settings.objElements

                    .slice(offsetStart, offsetEnd)

                    .clone();

                plugin.el.html(plugin.currentElements);

                plugin.currentElements.show();

            };



            var transition_fade = function(offsetStart, offsetEnd) {

                plugin.currentElements.fadeOut();

                plugin.currentElements = plugin.settings.objElements

                    .slice(offsetStart, offsetEnd)

                    .clone();

                plugin.el.html(plugin.currentElements);

                plugin.currentElements.fadeIn();

            };



            var transition_slide = function(offsetStart, offsetEnd) {

                plugin.currentElements.animate({

                        "margin-left": plugin.settings.slideOffset * -1,

                        opacity: 0

                    },

                    function() {

                        $(this).remove();

                    }

                );



                plugin.currentElements = plugin.settings.objElements

                    .slice(offsetStart, offsetEnd)

                    .clone();

                plugin.currentElements.css({

                    "margin-left": plugin.settings.slideOffset,

                    display: "block",

                    opacity: 0,

                    "min-width": plugin.el.width() / 2

                });

                plugin.el.html(plugin.currentElements);

                plugin.currentElements.animate({

                    "margin-left": 0,

                    opacity: 1

                });

            };



            var transition_climb = function(offsetStart, offsetEnd) {

                plugin.currentElements.each(function(i) {

                    var $objThis = $(this);

                    setTimeout(function() {

                        $objThis.animate({

                                "margin-left": plugin.settings.slideOffset * -1,

                                opacity: 0

                            },

                            function() {

                                $(this).remove();

                            }

                        );

                    }, i * 200);

                });



                plugin.currentElements = plugin.settings.objElements

                    .slice(offsetStart, offsetEnd)

                    .clone();

                plugin.currentElements.css({

                    "margin-left": plugin.settings.slideOffset,

                    display: "block",

                    opacity: 0,

                    "min-width": plugin.el.width() / 2

                });

                plugin.el.html(plugin.currentElements);

                plugin.currentElements.each(function(i) {

                    var $objThis = $(this);

                    setTimeout(function() {

                        $objThis.animate({

                            "margin-left": 0,

                            opacity: 1

                        });

                    }, i * 200);

                });

            };



            plugin.settings = $.extend({}, defaults, options);



            plugin.currentElements = $([]);

            plugin.settings.objElements = plugin.el.find(

                plugin.settings.paginateElement

            );

            plugin.settings.pages = getNbOfPages();

            if (plugin.settings.pages > 1) {

                plugin.el.html();



                // Here we go

                displayNav();



                page = 1;

                if (

                    document.location.hash.indexOf("#" + plugin.settings.hashPage + ":") != -1

                ) {

                    page = parseInt(

                        document.location.hash.replace( "#" + plugin.settings.hashPage + ":", "" )

                    );

                    if (

                        page.length <= 0 ||

                        page < 1 ||

                        page > plugin.settings.pages

                    ) {

                        page = 1;

                    }

                }



                displayPage(page, "default");

            }

        });

    };

})(jQuery);



