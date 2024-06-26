/*!
 * Name: RootUI - Dashboards and Administration areas for React + Redux and HTML
 * Version: 1.1.2
 * Author: dexad, nK
 * Website: https://nkdev.info/
 * Purchase: https://themeforest.net/user/_nk/portfolio
 * Support: https://nk.ticksy.com/
 * License: You must have a valid license purchased only from ThemeForest (the above link) in order to legally use the theme for your project.
 * Copyright 2019.
 */
! function(t) {
    var e = {};

    function n(i) {
        if (e[i]) return e[i].exports;
        var a = e[i] = {
            i: i,
            l: !1,
            exports: {}
        };
        return t[i].call(a.exports, a, a.exports, n), a.l = !0, a.exports
    }
    n.m = t, n.c = e, n.d = function(t, e, i) {
        n.o(t, e) || Object.defineProperty(t, e, {
            enumerable: !0,
            get: i
        })
    }, n.r = function(t) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(t, "__esModule", {
            value: !0
        })
    }, n.t = function(t, e) {
        if (1 & e && (t = n(t)), 8 & e) return t;
        if (4 & e && "object" == typeof t && t && t.__esModule) return t;
        var i = Object.create(null);
        if (n.r(i), Object.defineProperty(i, "default", {
                enumerable: !0,
                value: t
            }), 2 & e && "string" != typeof t)
            for (var a in t) n.d(i, a, function(e) {
                return t[e]
            }.bind(null, a));
        return i
    }, n.n = function(t) {
        var e = t && t.__esModule ? function() {
            return t.default
        } : function() {
            return t
        };
        return n.d(e, "a", e), e
    }, n.o = function(t, e) {
        return Object.prototype.hasOwnProperty.call(t, e)
    }, n.p = "", n(n.s = 6)
}({
    0: function(t, e, n) {
        "use strict";
        n.d(e, "a", (function() {
            return i
        }));
        var i = {
            ajax: !0,
            events: {
                onBeforeAjax: function() {
                    return !1
                },
                onAfterAjax: function() {}
            }
        }
    },
    6: function(t, e, n) {
        "use strict";
        n.r(e);
        var i = n(0),
            a = window.jQuery,
            o = (window.TweenMax, /iPad|iPhone|iPod/.test(window.navigator.userAgent) && window.MSStream, /Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/g.test(window.navigator.userAgent || window.navigator.vendor || window.opera));
        "ontouchstart" in window || window.DocumentTouch && (document, window.DocumentTouch);
        a("html").addClass(o ? "is-mobile" : "is-desktop");
        var r = a(window),
            s = a(document),
            l = a("body"),
            u = 0,
            c = 0,
            d = 0;

        function h() {
            u = r.outerWidth(), c = r.height(), d = s.height()
        }
        h(), r.on("resize load orientationchange rui-ajax-loaded", h);
        var p, f = [];

        function g() {
            clearTimeout(p), p = setTimeout((function() {
                if (f.length)
                    for (var t = 0; t < f.length; t++) f[t]()
            }), 50)
        }

        function v(t) {
            "function" == typeof t ? f.push(t) : window.dispatchEvent(new window.Event("resize"))
        }
        r.on("ready load resize orientationchange", g), g();
        var m, w, y, b, k, C = [],
            x = 0;

        function P() {
            var t = r.scrollTop(),
                e = "";
            e = t > x ? "down" : t < x ? "up" : "none", 0 === t ? e = "start" : t >= d - c && (e = "end"), C.forEach((function(n) {
                "function" == typeof n && n(e, t, x, r)
            })), x = t
        }

        function S(t) {
            C.push(t)
        }

        function j() {
            var t = window.innerWidth;
            if (!t) {
                var e = document.documentElement.getBoundingClientRect();
                t = e.right - Math.abs(e.left)
            }
            y = l[0].clientWidth < t, b = function() {
                var t = document.createElement("div");
                t.className = "rui-body-scrollbar-measure", l[0].appendChild(t);
                var e = t.offsetWidth - t.clientWidth;
                return l[0].removeChild(t), e
            }()
        }

        function T(t) {
            t && !w ? (w = 1, j(), b && (void 0 === k && (k = l.css("padding-right") || ""), y && l.add(a(".rui-navbar-mobile")).css("paddingRight", "".concat(b, "px"))), l.css("overflow", "hidden")) : !t && w && (w = 0, l.css("overflow", ""), b && (l.css("paddingRight", k), a(".rui-navbar-mobile").css("paddingRight", "")))
        }

        function z(t, e) {
            var n = t[0].getBoundingClientRect(),
                i = 1;
            if (n.right <= 0 || n.left >= u) i = 0;
            else if (n.bottom < 0 && n.top <= c) i = 0;
            else {
                var a = Math.max(0, n.height + n.top),
                    o = Math.max(0, n.height - (n.top + n.height - c)),
                    r = Math.max(0, -n.top),
                    s = Math.max(0, n.top + n.height - c);
                n.height < c ? i = 1 - (r || s) / n.height : a <= c ? i = a / c : o <= c && (i = o / c), i = i < 0 ? 0 : i
            }
            return e ? [i, n] : i
        }

        function I(t) {
            var e = a.extend({}, this.options.templates, t && t.templates || {}),
                n = a.extend({}, this.options.events, t && t.events || {});
            this.options = a.extend({}, this.options, t), this.options.templates = e, this.options.events = n
        }

        function D() {
            var t = this,
                e = a(".rui-page-preloader"),
                n = null;
            if (t.setLoadingAnimation = function() {
                    var t = !(arguments.length > 0 && void 0 !== arguments[0]) || arguments[0];
                    clearTimeout(n), t ? (l.addClass("rui-page-loading-state"), e.addClass("rui-page-preloader-active")) : (l.removeClass("rui-page-loading-state"), n = setTimeout((function() {
                        e.removeClass("rui-page-preloader-active")
                    }), 300))
                }, t.options.ajax && void 0 !== window.history && u(s)) {
                var i = window.location.href,
                    o = {};
                s.on("click", 'a:not(.no-ajax):not([target="_blank"]):not([href^="#"]):not([href^="mailto"]):not([href^="javascript:"])', (function(e) {
                    var n = e.currentTarget;
                    e.which > 1 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || window.location.protocol === n.protocol && window.location.hostname === n.hostname && (n.href.indexOf("#") > -1 && c(n.href) === c(i) || "file:" !== window.location.protocol && (e.isDefaultPrevented() || void 0 !== t.options.events.onBeforeAjax && t.options.events.onBeforeAjax(e) || (e.preventDefault(), g(n.href))))
                })), window.onpopstate = function() {
                    g(window.location.href, !0)
                }
            }

            function u(t) {
                return t.find(".yaybar").length && t.find(".rui-page").length
            }

            function c(t) {
                return t.replace(/#.*/, "")
            }

            function d() {
                var t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0];
                return !(!t || !o[t]) && o[t]
            }

            function h(t, e) {
                ! function n() {
                    t.length ? function(t, e) {
                        switch (t.type) {
                            case "style":
                                var n = document.createElement("link");
                                n.setAttribute("rel", "stylesheet"), n.setAttribute("href", t.src);
                                var i = !!t.afterCSS && a('link[href="'.concat(t.afterCSS, '"]'));
                                i && i.length ? i.after(n) : a("head").append(n), e();
                                break;
                            case "script":
                                var o = document.createElement("script");
                                o.onload = o.onreadystatechange = function() {
                                    o.onload = o.onreadystatechange = null, e()
                                }, o.setAttribute("src", t.src), document.body.appendChild(o)
                        }
                    }(t.shift(), n) : e && e()
                }()
            }

            function p(e, n, o) {
                if (n) {
                    i = e, n = n.replace("<body", "<div data-ajax-body").replace("</body>", "</div>");
                    var s = a("<div>").html(n),
                        l = s.find("title:eq(0)").text() || document.title;
                    u(s) ? (o ? window.history.replaceState(null, l, e) : window.history.pushState(null, l, e), function() {
                        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "",
                            n = arguments.length > 1 ? arguments[1] : void 0,
                            i = arguments.length > 2 ? arguments[2] : void 0,
                            o = a(".rui-page"),
                            s = n.find(".rui-page"),
                            l = n.find(".rui-page-additional-js"),
                            u = a(".yaybar-wrap > ul"),
                            c = a(".rui-navbar-top, .rui-navbar-mobile, .rui-navbar-side-icons"),
                            d = [];
                        n.find('link[rel="stylesheet"]').each((function() {
                            var t = a(this),
                                e = t.attr("href");
                            a('link[href="'.concat(e, '"]')).length || d.push({
                                src: e,
                                afterCSS: t.prev("link").attr("href"),
                                type: "style"
                            })
                        })), n.find("script[src]").each((function() {
                            var t = a(this).attr("src");
                            a('script[src="'.concat(t, '"]')).length || d.push({
                                src: t,
                                type: "script"
                            })
                        })), h(d, (function() {
                            var d = n.find("title:eq(0)").text() || document.title;
                            a("title").html(d), u.find(".yay-item-active, .yay-submenu-open").each((function() {
                                var t = a(this),
                                    e = "yay-item-active";
                                t.children(".yay-submenu").length || (e += " yay-submenu-open"), t.removeClass(e)
                            })), u.find("li > a").each((function() {
                                var t = a(this);
                                this.href && this.href === e && t.add(t.closest(".yay-submenu")).parent("li").addClass("yay-item-active yay-submenu-open")
                            })), c.find(".nav-link, .dropdown-item").each((function() {
                                var t = a(this),
                                    e = "active";
                                t.children(".yay-submenu").length || (e += " yay-submenu-open"), t.removeClass(e)
                            })), c.find(".nav-link, .dropdown-item").each((function() {
                                var t = a(this);
                                this.href && this.href === e && t.addClass("active")
                            })), o.html(s.html()), a(".rui-page-additional-js-ajax").remove(), l.each((function() {
                                var t = a(this).clone();
                                t.addClass("rui-page-additional-js-ajax"), t.appendTo("body")
                            })), void 0 !== t.options.events.onAfterAjax && t.options.events.onAfterAjax(e, n), r.trigger("rui-ajax-loaded", e, n), window.scrollTo({
                                top: 0,
                                behavior: "smooth"
                            }), i()
                        }))
                    }(e, s, (function() {
                        s.remove(), s = null, t.setLoadingAnimation(!1)
                    }))) : window.location = e
                } else window.location = e
            }

            function f(e, n) {
                0 !== n.status ? (console.log("error", n), t.setLoadingAnimation(!1)) : window.location = e
            }

            function g() {
                var e = arguments.length > 0 && void 0 !== arguments[0] && arguments[0],
                    n = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                e && c(e) !== c(i) && a.ajax({
                    url: e,
                    beforeSend: function() {
                        var i = d(e);
                        return i ? (i.then((function(t) {
                            p(e, t, n)
                        }), (function(t) {
                            f(e, t)
                        })), !1) : (t.setLoadingAnimation(!0), function() {
                            var t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0],
                                e = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                            t && e && !o[t] && (o[t] = e)
                        }(e, a.Deferred()), !0)
                    },
                    success: function(t) {
                        var i = d(e);
                        i && i.resolve(t), p(e, t, n)
                    },
                    error: function(t) {
                        f(e, t)
                    }
                })
            }
        }

        function R() {
            var t = this,
                e = a("link.rui-nightmode-link");
            t.isNightMode = function() {
                return "(night)" !== e.attr("media")
            }, t.toggleNightMode = function() {
                var n = arguments.length > 0 && void 0 !== arguments[0] && arguments[0],
                    i = a("input.rui-nightmode-toggle");
                switch (n || (n = t.isNightMode() ? "day" : "night"), n) {
                    case "night":
                        e.attr("media", "all"), i.prop("checked", !0);
                        break;
                    case "day":
                        e.attr("media", "(night)"), i.prop("checked", !1)
                }
                a("[data-src-".concat(n, "]")).each((function() {
                    var t = a(this);
                    t.attr("src", t.attr("data-src-".concat(n)))
                }))
            };
            var n = t.isNightMode() ? "night" : "day";
            t.toggleNightMode(n), s.on("change", "input.rui-nightmode-toggle", (function() {
                t.toggleNightMode()
            }))
        }

        function A() {
            var t = this,
                e = a(".rui-navbar"),
                n = a(".rui-navbar-top"),
                i = l.filter(".rui-navbar-autohide");
            i.length && t.throttleScroll((function(t, e) {
                "down" === t && e > 400 ? i.removeClass("rui-navbar-show").addClass("rui-navbar-hide") : "up" !== t && "end" !== t && "start" !== t || i.removeClass("rui-navbar-hide").addClass("rui-navbar-show")
            }));
            var o = a(".rui-navbar-mobile"),
                r = o.find(".rui-navbar-collapse");

            function u() {
                if (!t.isNightMode()) {
                    a("input.rui-darkNavbar-toggle").prop("checked", e.hasClass("rui-navbar-dark"));
                    var n = "";
                    n = e.hasClass("rui-navbar-dark") ? "night" : "day", a(".rui-navbar [data-src-".concat(n, "]")).each((function() {
                        var t = a(this);
                        t.attr("src", t.attr("data-src-".concat(n)))
                    }))
                }
            }
            s.on("show.bs.collapse hide.bs.collapse", ".rui-navbar-collapse", (function(t) {
                "show" === t.type && (o.addClass("rui-navbar-show"), T(1)), "hide" === t.type && (o.removeClass("rui-navbar-show"), T(0))
            })), s.on("keyup", (function(t) {
                27 === t.keyCode && r.hasClass("show") && r.collapse && r.collapse("hide")
            })), s.on("click", ".rui-navbar-bg", (function() {
                r.collapse && r.collapse("hide")
            })), (n.hasClass("rui-navbar-fixed") || n.hasClass("rui-navbar-sticky")) && S((function(t, e) {
                e > 200 ? n.addClass("rui-navbar-scroll") : n.removeClass("rui-navbar-scroll")
            })), u(), s.on("change", "input.rui-darkNavbar-toggle", (function() {
                e.toggleClass("rui-navbar-dark"), u()
            }))
        }

        function M() {
            function t() {
                a(".dropdown:not(.rui-dropdown-triangle-ready)").addClass("rui-dropdown-triangle-ready").each((function() {
                    var t = a(this),
                        e = t.children(".dropdown-menu");
                    t.hasClass("dropdown-triangle") && e.append('<span class="dropdown-menu-triangle"></span>')
                }))
            }
            s.on("mouseenter mouseleave", ".dropdown.dropdown-hover", (function(t) {
                var e = a(this);
                "mouseenter" === t.type && (e.children(".dropdown-item").dropdown("toggle"), e.parents(".dropdown-hover").length && e.parents(".dropdown-menu").dropdown("show")), "mouseleave" === t.type && (e.children(".dropdown-item").dropdown("toggle"), e.parents(".dropdown-hover").length && e.parents(".dropdown-menu").dropdown("show"))
            })), s.on("show.bs.dropdown", ".dropdown", (function() {
                var t = a(this),
                    e = t.children(".dropdown-menu");
                t.hasClass("dropdown-hover") ? (t.addClass("hover"), e.addClass("hover")) : (t.addClass("focus"), e.addClass("focus"))
            })), s.on("hidden.bs.dropdown", ".dropdown", (function() {
                var t = a(this),
                    e = t.children(".dropdown-menu");
                t.hasClass("dropdown-hover") ? (t.removeClass("hover"), e.removeClass("hover")) : (t.removeClass("focus"), e.removeClass("focus")), t.hasClass("dropdown-autoposition") && (t.removeClass("dropdown-autoposition"), t.children(".dropdown-item").dropdown("dispose"))
            })), s.on("shown.bs.dropdown", ".dropdown", (function() {
                var t = a(this),
                    e = t.children(".dropdown-menu"),
                    n = t.children(".dropdown-item"),
                    i = e.children(".dropdown-menu-triangle");
                e.css("margin-left", ""), i.css("margin-left", ""), e.offset().left + e.outerWidth() > u && (t.addClass("dropdown-autoposition"), n.dropdown("update"), e.css("margin-left", (e.offset().left + e.outerWidth() - (u - 27)) / -1), i.length && i.css("margin-left", n.offset().left - i.offset().left + (n.outerWidth() / 2 - i.outerWidth() / 2))), setTimeout((function() {
                    t.parents(".dropdown-hover").length && (e.attr("x-placement", "right-start").css({
                        transform: "",
                        left: "",
                        top: ""
                    }), e.offset().top + e.outerHeight() > c && e.attr("x-placement", "right-end"), e.offset().left + e.outerWidth() > u && (e.attr("x-placement", "left-start"), e.offset().top + e.outerHeight() > c && e.attr("x-placement", "left-end")))
                }), 10)
            })), s.on("click", ".dropdown-keep-open .dropdown-menu", (function(t) {
                t.stopPropagation()
            })), t(), r.on("rui-ajax-loaded", t)
        }

        function _() {
            function t() {
                a(".rui-messenger:not(.rui-messenger-ready)").addClass("rui-messenger-ready").each((function() {
                    var t = a(this),
                        e = t.find(".rui-messenger-chat");

                    function n() {
                        var t = e.find(".rui-messenger-body"),
                            n = e.find(".os-viewport");
                        if (n.length) {
                            var i = n.find(".os-content").innerHeight() - n.innerHeight();
                            n.scrollTop(i)
                        } else {
                            var a = t.add("> div").innerHeight() - t.innerHeight();
                            t.scrollTop(a)
                        }
                    }

                    function i(t) {
                        void 0 !== window.emojione && t.each((function() {
                            var t = a(this);
                            t.html(window.emojione.toImage(t.html()))
                        }))
                    }

                    function o() {
                        var a = t.find(".rui-messenger-textarea").data("emojioneArea");
                        if (a) {
                            var o = e.find(".rui-messenger-message:last"),
                                r = o.find(".rui-messenger-message-time").text(),
                                s = e.find(".rui-messenger-message-structure"),
                                l = a.getText();
                            if (l && s.length) {
                                var u = new Date,
                                    c = u.getHours(),
                                    d = u.getMinutes();
                                c < 10 && (c = "0".concat(c)), d < 10 && (d = "0".concat(d));
                                var h = "".concat(c, ":").concat(d);
                                r === h ? o.find("ul > li:last").after("<li></li>").next() : (o.after(s.clone()), (o = e.find(".rui-messenger-message:last")).removeClass("rui-messenger-message-structure"), o.find(".rui-messenger-message-time").text(h));
                                var p = o.find("ul > li:last");
                                p.html(l), i(p), n(), a.setText("")
                            }
                        }
                    }
                    setTimeout((function() {
                        n()
                    }), 100), t.hasClass("rui-messenger-mini") && s.on("afterClose.fb", (function() {
                        t.removeClass("open show"), e.removeClass("open show")
                    })), i(t.find(".rui-messenger-message li")), e.find(".rui-messenger-send").on("click", (function(t) {
                        t.preventDefault(), o()
                    })), t.on("keyup", (function(t) {
                        13 === t.keyCode && o()
                    }))
                }))
            }
            t(), r.on("rui-ajax-loaded", t), s.on("click", ".rui-messenger-item, .rui-messenger-back", (function(t) {
                t.preventDefault();
                var e = a(this),
                    n = e.closest(".rui-messenger"),
                    i = n.find(".rui-messenger-chat");
                if (e.hasClass("rui-messenger-item")) {
                    var o = i.find(".rui-messenger-body"),
                        r = i.find(".os-viewport");
                    if (n.addClass("open show"), i.addClass("open show"), r.length) {
                        var s = r.find(".os-content"),
                            l = s.innerHeight() - r.innerHeight();
                        r.scrollTop(l), s.css("border-right") && r.find(".os-content").css("border-right", "")
                    } else {
                        var u = o.add("> div").innerHeight() - o.innerHeight();
                        o.scrollTop(u)
                    }
                }
                e.hasClass("rui-messenger-back") && (n.removeClass("open"), i.removeClass("open"), setTimeout((function() {
                    n.removeClass("show"), i.removeClass("show")
                }), 150))
            }))
        }

        function E() {
            s.on("click", ".rui-mailbox-item, .rui-mailbox-content-back", (function(t) {
                t.preventDefault();
                var e = a(this),
                    n = e.closest(".rui-mailbox"),
                    i = n.find(".rui-mailbox-content");
                e.hasClass("rui-mailbox-item") && (n.addClass("open show"), i.addClass("open show")), e.hasClass("rui-mailbox-content-back") && (n.removeClass("open"), i.removeClass("open"), setTimeout((function() {
                    n.removeClass("show"), i.removeClass("show")
                }), 150))
            }))
        }

        function U() {
            function t(t, e) {
                t.css({
                    width: e.innerWidth(),
                    height: e.outerHeight(),
                    transform: "translate(".concat(e.position().left, "px, ").concat(e.position().top, "px)")
                })
            }

            function e() {
                a(".rui-tabs-sliding:not(.rui-tabs-sliding-ready)").addClass("rui-tabs-sliding-ready").each((function() {
                    var e = a(this),
                        n = a('<li class="rui-tabs-slide"></li>'),
                        i = e.find(".rui-tabs-link.active");
                    e.prepend(n), i.length && t(n, i)
                }))
            }
            e(), r.on("rui-ajax-loaded", e), s.on("click", ".rui-tabs-link", (function(e) {
                e.preventDefault();
                var n = a(this),
                    i = n.closest(".rui-tabs-sliding").find(".rui-tabs-slide");
                n.length && t(i, n)
            }))
        }

        function O() {
            function t() {
                a("input.rui-spotlightmode-toggle").prop("checked", l.hasClass("rui-spotlightmode"))
            }
            t(), s.on("change", "input.rui-spotlightmode-toggle", (function() {
                l.toggleClass("rui-spotlightmode"), t()
            }))
        }

        function W() {
            function t() {
                a("input.rui-sectionLines-toggle").prop("checked", l.hasClass("rui-section-lines"))
            }
            t(), s.on("change", "input.rui-sectionLines-toggle", (function() {
                l.toggleClass("rui-section-lines"), t()
            }))
        }

        function F() {
            var t = a('<div class="rui-toast-container"></div>').appendTo(l);

            function e(e) {
                return e.clone().removeClass("hide").prependTo(t)
            }
            a(".rui-toast[data-toast-show-on-startup]").each((function() {
                e(a(this)).toast("show")
            })), s.on("click", ".rui-toast-show", (function(t) {
                t.preventDefault();
                var n = a(this),
                    i = a(n.attr("href"));
                i && i.length && e(i).toast("show")
            }))
        }
        r.on("scroll load resize orientationchange", (function() {
            C.length && (m = !0)
        })), setInterval((function() {
            m && (m = !1, window.requestAnimationFrame(P))
        }), 250);
        var H = {
            dropdown_toggle_transition: 200,
            sidebar_toggle_transition: 250,
            resizeWnd: 1200,
            resizeSmallWnd: 576,
            closeSiblings: !0,
            closeChilds: !0,
            gestures: !0,
            menuWrapSelector: ".yay-wrap-menu",
            contentSelector: ".content-wrap",
            toggleSelector: ".yay-toggle",
            submenuSelector: ".yay-submenu",
            submenuToggleSelector: ".yay-sub-toggle",
            htmlOverflowClass: "yay-html-overflow",
            rtlClass: "yay-rtl",
            hideClass: "yay-hide",
            effectOverlayClass: "yay-overlay",
            effectPushClass: "yay-push",
            effectShrinkClass: "yay-shrink",
            overlapContentClass: "yay-content-overlay",
            staticPositionClass: "yay-static",
            submenuOpenClass: "yay-submenu-open"
        };

        function Y() {
            if (void 0 !== window.YAYBAR) {
                var t = a(".yaybar"),
                    e = H.effectShrinkClass,
                    n = H.effectPushClass,
                    i = H.effectOverlayClass;
                t.each((function() {
                    var s = new window.YAYBAR,
                        c = a(this),
                        d = c.find(".yay-submenu");
                    c.data("yaybar", s), s.setOptions(H), s.init(c), d.hasClass("dropdown-triangle") && d.append('<span class="dropdown-menu-triangle"></span>'), l.hasClass("yay-hide") && o(), l.hasClass("rui-spotlightmode") && o(), c.on("show.yaybar hide.yaybar", (function(t) {
                        c.hasClass(i) ? ("show" === t.type && T(1), "hide" === t.type && T(0)) : T(0)
                    }));
                    var h = "",
                        p = !1;

                    function f() {
                        !p && u < H.resizeSmallWnd ? (c.removeClass("yay-hide-to-small"), p = !0, setTimeout(v, 100)) : p && u >= H.resizeSmallWnd && (c.addClass("yay-hide-to-small"), p = !1, setTimeout(v, 100)), u < H.resizeWnd ? h || (h = t.hasClass(e) ? e : t.hasClass(n) ? n : !t.hasClass(i) || i, c.removeClass("".concat(e, " ").concat(n)).addClass(i), o()) : h && (h !== i && (c.removeClass("".concat(e, " ").concat(n, " ").concat(i)).addClass(h), t.data("yaybar").showYay()), h = "")
                    }
                    u < H.resizeWnd && f(), r.on("ready load resize orientationchange", f), r.on("rui-ajax-loaded", (function() {
                        c.hasClass(i) && !l.hasClass("yay-hide") && o()
                    }))
                })), s.on("show.bs.collapse", ".rui-navbar-collapse", (function() {
                    o()
                })), s.on("change", "input.rui-spotlightmode-toggle", (function() {
                    l.hasClass("rui-spotlightmode") && o()
                })), s.on("click", ".rui-yaybar-bg", (function() {
                    o()
                })), s.on("change", "input.rui-darkSidebar-toggle", (function() {
                    t.toggleClass("rui-yaybar-dark")
                })), c(), s.on("change", "input.rui-staticSidebar-toggle", (function() {
                    t.toggleClass("yay-static"), c()
                }))
            }

            function o() {
                t.data("yaybar").hideYay()
            }

            function c() {
                a("input.rui-staticSidebar-toggle").prop("checked", t.hasClass("yay-static"))
            }
        }

        function N() {
            void 0 !== a.fn.overlayScrollbars && a(".rui-scrollbar:not(.rui-scrollbar-ready)").addClass("rui-scrollbar-ready").overlayScrollbars({
                scrollbars: {
                    clickScrolling: !0
                }
            })
        }

        function B() {
            if (void 0 !== a.fn.scrollspy) {
                var t = a(".rui-navbar-top");
                s.on("click", ".rui-page-sidebar .nav-link", (function(e) {
                    if (e.preventDefault(), "" !== a(this).attr("href")) {
                        var n = a("html, body");
                        t.length ? n.animate({
                            scrollTop: a(a.attr(this, "href")).offset().top - t.innerHeight()
                        }, 500) : n.animate({
                            scrollTop: a(a.attr(this, "href")).offset().top
                        }, 500)
                    }
                }))
            }
        }

        function q() {
            void 0 !== window.feather && window.feather.replace()
        }

        function L() {
            void 0 !== a.fn.ionRangeSlider && a(".rui-irs:not(.rui-irs-ready)").addClass("rui-irs-ready").each((function() {
                var t = a(this),
                    e = t.find("input"),
                    n = t.find(".rui-irs-value"),
                    i = parseInt(e.attr("min"), 10),
                    o = parseInt(e.attr("max"), 10),
                    r = parseInt(e.attr("step"), 10),
                    s = parseInt(e.attr("data-irs-from"), 10),
                    l = parseInt(e.attr("data-irs-to"), 10),
                    u = String(e.attr("data-irs-separator")),
                    c = {};

                function d() {
                    n.length && u.length && void 0 !== e.data("to") && n.text("".concat(e.data("from")).concat(u).concat(e.data("to"))), n.length && void 0 === e.data("to") && n.text(e.data("from"))
                }
                i && (c.min = i), o && (c.max = o), r && (c.step = r), s && (c.type = "single", c.from = s), l && (c.type = "double", c.to = l), u && (c.values_separator = u), c.grid = !1, c.drag_interval = !1, c.onStart = function() {
                    d()
                }, c.onChange = function() {
                    d(), t.addClass("rui-irs-change")
                }, c.onFinish = function() {
                    t.removeClass("rui-irs-change")
                }, e.ionRangeSlider(c)
            }))
        }

        function Q() {
            void 0 !== a.fn.TouchSpin && a(".rui-touchspin:not(.rui-touchspin-ready)").addClass("rui-touchspin-ready").each((function() {
                var t = a(this).find("input"),
                    e = t.attr("data-touchspin-btn"),
                    n = t.attr("min"),
                    i = t.attr("max"),
                    o = t.attr("step"),
                    r = t.attr("data-touchspin-vertical"),
                    s = {
                        boostat: 5,
                        maxboostedstep: 10,
                        forcestepdivisibility: "none"
                    };
                "true" === r && (s.verticalbuttons = r), n && (s.min = n), i && (s.max = i), o && (s.step = o), e ? (s.buttondown_class = "btn ".concat(e, " btn-uniform"), s.buttonup_class = "btn ".concat(e, " btn-uniform")) : (s.buttondown_class = "btn btn-grey-2 btn-uniform", s.buttonup_class = "btn btn-grey-2 btn-uniform"), t.TouchSpin(s)
            }))
        }

        function K() {
            if (void 0 !== a.fn.daterangepicker) {
                var t = this;
                a(".rui-daterange:not(.rui-daterange-ready)").addClass("rui-daterange-ready").each((function() {
                    var e = a(this),
                        n = e.attr("data-daterangepicker-format");
                    e.daterangepicker({
                        autoUpdateInput: !1,
                        locale: {
                            cancelLabel: "Clear"
                        }
                    }), e.on("apply.daterangepicker", (function(t, i) {
                        n ? e.val("".concat(i.startDate.format(n), " - ").concat(i.endDate.format(n))) : e.val("".concat(i.startDate.format("MM/DD/YYYY"), " - ").concat(i.endDate.format("MM/DD/YYYY")))
                    })), e.on("cancel.daterangepicker", (function() {
                        e.val("")
                    })), e.on("showCalendar.daterangepicker", (function() {
                        a('<span stroke-width="1.5" data-feather="chevron-left" class="rui-icon"></span>').appendTo(a(".daterangepicker").find(".prev, .next")), t.initPluginFeather()
                    }))
                }))
            }
        }

        function G() {
            if (void 0 !== a.fn.datetimepicker) {
                var t = this;
                a(".rui-datetimepicker:not(.rui-datetimepicker-ready)").addClass("rui-datetimepicker-ready").each((function() {
                    var e = a(this),
                        n = String(e.attr("data-datetimepicker-format")),
                        i = String(e.attr("data-datetimepicker-date")),
                        o = String(e.attr("data-datetimepicker-time")),
                        r = {};

                    function s(t) {
                        u < 576 && !t.parent(".rui-datetimepicker-wrap").length && t.wrap('<div class="rui-datetimepicker-wrap"></div>'), u > 576 && t.parent(".rui-datetimepicker-wrap").length && t.unwrap()
                    }
                    n && (r.format = n), "false" === i && (r.datepicker = !1), "false" === o && (r.timepicker = !1), r.onGenerate = function() {
                        var e = a(".xdsoft_datetimepicker");
                        e.hasClass("feather-complete") || (a('<span stroke-width="1.5" data-feather="chevron-left" class="rui-icon"></span>').appendTo(e.find(".xdsoft_prev, .xdsoft_next")), a('<span stroke-width="1.5" data-feather="home" class="rui-icon"></span>').appendTo(e.find(".xdsoft_today_button")), t.initPluginFeather(), e.addClass("feather-complete")), s(e), v((function() {
                            s(e)
                        }))
                    }, r.onShow = function(t, e, n) {
                        var i = a(n.target).parent(".rui-datetimepicker-wrap");
                        i.length && (i.addClass("show"), T(1))
                    }, r.onClose = function(t, e, n) {
                        var i = a(n.target).parent(".rui-datetimepicker-wrap");
                        i.length && (i.removeClass("show"), T(0))
                    }, e.datetimepicker(r)
                }))
            }
        }

        function J() {
            void 0 !== a.fn.dataTable && a(".rui-datatable:not(.rui-datatable-ready)").addClass("rui-datatable-ready").each((function() {
                var t = a(this),
                    e = t.attr("data-datatable-order"),
                    n = t.attr("data-datatable-search"),
                    i = t.attr("data-datatable-paging"),
                    o = t.attr("data-datatable-info"),
                    r = {};
                if (e) {
                    var s = e.split(",")[0],
                        l = e.split(",")[1];
                    s && l && (r.order = [
                        [parseInt(s.split(":")[0], 10), s.split(":")[1]],
                        [parseInt(l.split(":")[0], 10), l.split(":")[1]]
                    ]), s && !l && (r.order = [parseInt(s.split(":")[0], 10), s.split(":")[1]])
                }
                "false" === n && (r.searching = !1), "false" === i && (r.paging = !1), "false" === o && (r.info = !1), t.dataTable(r)
            }))
        }

        function V() {
            if (void 0 !== a.fn.jstree) {
                var t = this;
                a(".rui-jstree:not(.rui-jstree-ready)").addClass("rui-jstree-ready").each((function() {
                    var e = a(this);
                    e.jstree(), e.on("open_node.jstree", (function() {
                        t.initPluginFeather()
                    }))
                }))
            }
        }

        function X() {
            "undefined" != typeof Pickr && (a(".rui-colorpicker:not(.rui-colorpicker-ready)").addClass("rui-colorpicker-ready").each((function() {
                var t = a(this),
                    e = t.find(".rui-colorpicker-input"),
                    n = t.find(".rui-colorpicker-addon"),
                    i = t.find(".rui-colorpicker-result"),
                    o = t.attr("data-pickr-representation"),
                    r = {};
                n.length || (a('<div class="rui-colorpicker-addon"></div>').appendTo(t), t.addClass("rui-colorpicker-presence-addon")), e.length ? r.default = String(e.val()) : r.default = n.text(), r.defaultRepresentation = o || "HEX", r.el = t[0].querySelector(".rui-colorpicker-addon"), r.position = "bottom-end", r.components = {
                    preview: !0,
                    opacity: !0,
                    hue: !0,
                    interaction: {
                        hex: !0,
                        rgba: !0,
                        input: !0,
                        save: !0
                    }
                };
                var s = new Pickr(r);

                function l(t) {
                    var e = t.parent(".rui-colorpicker-wrap");
                    u < 576 && !e.length && t.wrap('<div class="rui-colorpicker-wrap"></div>'), u > 576 && e.length && t.unwrap()
                }(e.length || i.length) && (s.on("save", (function() {
                    e.val(s.getColor()["to".concat(s._representation)]().toString()), i.text(s.getColor()["to".concat(s._representation)]().toString())
                })), e.on("change", (function() {
                    s.setColor(e.val())
                })));
                var c = t.attr("data-pickr-offset");
                s.on("init", (function(t) {
                    var e = a(t.getRoot().app);
                    l(e), v((function() {
                        l(e)
                    })), void 0 === c || e.parents(".rui-colorpicker-wrap") || e.css({
                        "margin-top": parseInt(c.split(",")[1], 10),
                        "margin-left": parseInt(c.split(",")[0], 10)
                    })
                }))
            })), s.on("click", ".rui-colorpicker-input", (function() {
                var t = a(this).parent(".rui-colorpicker");
                t.hasClass("rui-colorpicker-presence-addon") && t.find(".pcr-button").click()
            })))
        }

        function Z() {
            a(".rui-popover:not(.rui-popover-ready)").addClass("rui-popover-ready").popover({
                container: "body"
            })
        }

        function $() {
            void 0 !== window.hljs && a("pre:not(.hljs) code").each((function() {
                window.hljs.highlightBlock(this)
            }))
        }

        function tt() {
            if (void 0 !== a.fn.emojioneArea) {
                var t = this;
                a(".rui-messenger:not(.rui-messenger-emojione-ready)").addClass("rui-messenger-emojione-ready").each((function() {
                    var e = a(this).find(".rui-messenger-textarea").emojioneArea({
                        tones: !1,
                        autocomplete: !0,
                        textcomplete: {
                            maxCount: 5,
                            placement: "top"
                        },
                        search: !1,
                        inline: !0,
                        hidePickerOnBlur: !0,
                        shortnames: !0,
                        pickerPosition: "top",
                        filtersPosition: "bottom",
                        tonesStyle: "bullet",
                        events: {
                            ready: function() {
                                a(".emojionearea-button-open").html('<span stroke-width="1.5" data-feather="smile" class="rui-icon"></span>'), a(".emojionearea-button-close").html('<span stroke-width="1.5" data-feather="x" class="rui-icon"></span>'), t.initPluginFeather()
                            }
                        }
                    }).data("emojioneArea");
                    e.on("picker.show", (function() {
                        var t = e.picker;
                        t.hasClass("rui-messenger-picker-complete") || (t.append('<span class="rui-messenger-picker-triangle"></span>'), t.find(".rui-messenger-picker-triangle").offset({
                            left: e.button.offset().left - e.button.width() / 2
                        }), t.addClass("rui-messenger-picker-complete"))
                    }))
                }))
            }
        }

        function et() {
            "undefined" != typeof Sortable && a(".rui-sortable:not(.rui-sortable-ready)").addClass("rui-sortable-ready").each((function() {
                var t = a(this),
                    e = t.get(0),
                    n = t.attr("data-sortable-classNameGroup"),
                    i = {};
                n && (i.group = t.closest(n).attr("class")), new Sortable(e, i)
            }))
        }

        function nt() {
            "undefined" != typeof EasyMDE && a(".rui-markdown:not(.rui-markdown-ready)").addClass("rui-markdown-ready").each((function() {
                new window.EasyMDE({
                    element: this
                }).codemirror.on("optionChange", (function(t) {
                    t.options.fullScreen ? l.addClass("rui-markdown-fullscreen") : l.removeClass("rui-markdown-fullscreen")
                }))
            }))
        }

        function it() {
            "undefined" != typeof swal && s.on("click", ".rui-sweetalert", (function() {
                var t = a(this),
                    e = t.attr("data-swal-type"),
                    n = t.attr("data-swal-title"),
                    i = t.attr("data-swal-content");
                window.swal.fire(n, i, e)
            }))
        }

        function at() {
            "undefined" != typeof Swiper && a(".rui-swiper:not(.rui-swiper-ready").addClass("rui-swiper-ready").each((function() {
                var t = a(this),
                    e = t.find(".swiper-container"),
                    n = t.find(".swiper-button-prev"),
                    i = t.find(".swiper-button-next"),
                    o = t.attr("data-swiper-initialSlide"),
                    r = "true" === t.attr("data-swiper-loop"),
                    s = "true" === t.attr("data-swiper-grabCursor"),
                    l = "true" === t.attr("data-swiper-center"),
                    c = t.attr("data-swiper-autoHeight"),
                    d = t.attr("data-swiper-breakpoints"),
                    h = parseInt(t.attr("data-swiper-autoplay"), 10),
                    p = parseInt(t.attr("data-swiper-speed"), 10),
                    f = t.attr("data-swiper-slides"),
                    g = parseInt(t.attr("data-swiper-gap"), 10),
                    v = {
                        keyboard: {
                            enabled: !0
                        }
                    };
                if (n.length && i.length && (v.navigation = {
                        nextEl: i[0],
                        prevEl: n[0]
                    }), o && (v.initialSlide = parseInt(o, 10) || 0), r && (v.loop = !0), s && (v.grabCursor = !0), l && (v.centeredSlides = !0), c && (v.autoHeight = !0), h && (v.autoplay = {
                        delay: h
                    }), p && (v.speed = p), v.slidesPerView = "auto" === f ? f : parseInt(f, 10), g && (v.spaceBetween = g), d) {
                    for (var m = 0, w = {}, y = d.split(","); m < d.split(",").length;) w[parseInt(y[m].split(":")[0], 10)] = {
                        slidesPerView: parseInt(y[m].split(":")[1], 10)
                    }, m++;
                    v.breakpoints = w
                }
                var b = new Swiper(e[0], v),
                    k = a(".yaybar"),
                    C = k.data("yaybar").options.resizeWnd;
                k.on("showed.yaybar hidden.yaybar", (function() {
                    u > C && b.update()
                })), u < C && k.one("showed.yaybar hidden.yaybar", (function() {
                    b.update()
                }))
            }))
        }

        function ot() {
            void 0 !== a.fn.inputmask && a(".rui-inputmask:not(.rui-inputmask-ready)").addClass("rui-inputmask-ready").inputmask({
                rightAlign: !1
            })
        }

        function rt() {
            if (void 0 !== a.fn.selectize) {
                var t = this;
                a(".rui-selectize:not(.rui-selectize-ready)").addClass("rui-selectize-ready").each((function() {
                    var e = a(this),
                        n = e.find(".rui-selectize-element"),
                        i = e.find(".rui-selectize-select-icon"),
                        o = {};
                    n.hasClass("rui-selectize-input") && (o.delimiter = ",", o.persist = !1, o.create = function(t) {
                        return {
                            value: t,
                            text: t
                        }
                    }), o.onInitialize = function() {
                        if (n.hasClass("rui-selectize-select")) {
                            var a = e.find(".selectize-input");
                            1 !== i.length || a.find(".rui-selectize-select-icon").length || i.appendTo(a.addClass("rui-selectize-select-icon"))
                        }
                        n.hasClass("rui-selectize-icon") && t.initPluginFeather()
                    }, o.onChange = o.onInitialize, n.hasClass("rui-selectize-icon") && (o.render = {
                        option: function(t) {
                            return t.selectize ? '<div class="option">'.concat(t.selectize, " ").concat(t.text, "</div>") : '<div class="option">'.concat(t.text, "</div>")
                        }
                    }, o.render.item = o.render.option, o.onDropdownOpen = function() {
                        t.initPluginFeather()
                    }), n.hasClass("rui-selectize-github") && (o.valueField = "url", o.labelField = "name", o.searchField = "name", o.option = [], o.create = !1, o.render = {
                        option: function(t, e) {
                            return '<div>\n                            <span class="title">\n                                <span class="name"><i class="icon '.concat(t.fork ? "fork" : "source", '"></i> ').concat(e(t.name), '</span>\n                                <span class="by">').concat(e(t.username), '</span>\n                            </span>\n                            <span class="description">').concat(e(t.description), '</span>\n                            <ul class="meta">\n                                ').concat(t.language ? '<li class="language">'.concat(e(t.language), "</li>") : "", '\n                                <li class="watchers"><span>').concat(e(t.watchers), '</span> watchers</li>\n                                <li class="forks"><span>').concat(e(t.forks), "</span> forks</li>\n                            </ul>\n                        </div>")
                        }
                    }, o.score = function(t) {
                        var e = this.getScoreFunction(t);
                        return function(t) {
                            return e(t) * (1 + Math.min(t.watchers / 100, 1))
                        }
                    }, o.load = function(t, e) {
                        t.length ? a.ajax({
                            url: "https://api.github.com/legacy/repos/search/".concat(encodeURIComponent(t)),
                            type: "GET",
                            error: function() {
                                e()
                            },
                            success: function(t) {
                                e(t.repositories.slice(0, 10))
                            }
                        }) : e()
                    }), n.selectize(o)
                }))
            }
        }

        function st() {
            "undefined" != typeof Quill && a(".rui-quill:not(.rui-quill-ready)").addClass("rui-quill-ready").each((function() {
                var t = a(this),
                    e = t.find(".rui-quill-select-icon"),
                    n = t.find(".rui-quill-editor"),
                    i = t.find(".rui-quill-toolbar");
                new Quill(n.get(0), {
                    modules: {
                        toolbar: i.get(0)
                    },
                    theme: "snow"
                });
                e.appendTo(t.find(".ql-picker"))
            }))
        }

        function lt() {
            if ("undefined" != typeof Dropzone) {
                var t = this;
                a(".rui-dropzone:not(.rui-dropzone-ready)").addClass("rui-dropzone-ready").each((function() {
                    var e = a(this),
                        n = e.find(".rui-dropzone-remove-icon")[0];
                    window.Dropzone.autoDiscover = !1, e.dropzone({
                        url: e.attr("data-dz-url"),
                        maxFiles: e.attr("data-dz-max-files"),
                        maxFilesize: e.attr("data-dz-max-mb"),
                        addRemoveLinks: e.attr("data-dz-remove-link"),
                        thumbnailWidth: 150,
                        thumbnailHeight: 150,
                        init: function() {
                            var i = this;
                            i.on("complete", (function() {
                                e.find(".dz-remove").html(n), t.initPluginFeather()
                            })), e.find(".rui-dropzone-images > img").each((function() {
                                var t = a(this);

                                function e(e) {
                                    a(e.previewElement).find(".dz-image").addClass("rui-dropzone-image").find("img").attr("src", t.attr("src"))
                                }
                                i.on("addedfile", (function(n) {
                                    var i = String(n.name.split(".").slice(-1));
                                    "empty" === t.attr("data-dz-type") && e(n), setTimeout((function() {
                                        t.attr("data-dz-type") === i && e(n)
                                    }), 100)
                                }))
                            }))
                        }
                    })
                }))
            }
        }

        function ut() {
            var t = 0,
                e = !1;
            r.on("init.yaybar", (function(t) {
                var n = a(t.target).data("yaybar"),
                    i = n.showYay,
                    o = n.hideYay;
                n.showYay = function() {
                    e = !0, i.call(n)
                }, n.hideYay = function() {
                    e = !0, o.call(n)
                }
            })), r.on("resize", (function() {
                e ? e = !1 : (t ? (clearTimeout(t), t = null) : l.addClass("rui-no-transition"), t = setTimeout((function() {
                    l.removeClass("rui-no-transition"), t = null
                }), 200))
            })), l.removeClass("rui-no-transition")
        }

        function ct(t, e) {
            for (var n = 0; n < e.length; n++) {
                var i = e[n];
                i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i)
            }
        }
        r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginOverlayScrollbars()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginFeather()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginIonRangeslider()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginTouchSpin()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginDateRangePicker()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginDateTimePicker()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginDataTable()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginJstree()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginPickr()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginPopover()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginHightlight()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginEmojioneArea()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginSortable()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginEasymde()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginSwiper()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginInputmask()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginSelectize()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginQuill()
        })), r.on("rui-ajax-loaded", (function() {
            window.RootUI.initPluginDropzone()
        }));
        var dt = function() {
            function t() {
                ! function(t, e) {
                    if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function")
                }(this, t), this.options = i.a
            }
            var e, n, a;
            return e = t, (n = [{
                key: "init",
                value: function() {
                    return this.initAjax(), this.initNightMode(), this.initNavbar(), this.initDropdown(), this.initMessenger(), this.initMailbox(), this.initTabsSliding(), this.initSpotlightMode(), this.initSectionLines(), this.initToasts(), this.initPluginIonRangeslider(), this.initPluginTouchSpin(), this.initPluginDateRangePicker(), this.initPluginDateTimePicker(), this.initPluginDataTable(), this.initPluginJstree(), this.initPluginPickr(), this.initPluginPopover(), this.initPluginYaybar(), this.initPluginOverlayScrollbars(), this.initPluginScrollspy(), this.initPluginFeather(), this.initPluginHightlight(), this.initPluginEmojioneArea(), this.initPluginSortable(), this.initPluginEasymde(), this.initPluginSweetalert(), this.initPluginSwiper(), this.initPluginInputmask(), this.initPluginSelectize(), this.initPluginQuill(), this.initPluginDropzone(), this.initTransitionFix(), this
                }
            }, {
                key: "setOptions",
                value: function(t) {
                    return I.call(this, t)
                }
            }, {
                key: "debounceResize",
                value: function(t) {
                    return v.call(this, t)
                }
            }, {
                key: "throttleScroll",
                value: function(t) {
                    return S.call(this, t)
                }
            }, {
                key: "bodyOverflow",
                value: function(t) {
                    return T.call(this, t)
                }
            }, {
                key: "isInViewport",
                value: function(t, e) {
                    return z.call(this, t, e)
                }
            }, {
                key: "initAjax",
                value: function() {
                    return D.call(this)
                }
            }, {
                key: "initNavbar",
                value: function() {
                    return A.call(this)
                }
            }, {
                key: "initDropdown",
                value: function() {
                    return M.call(this)
                }
            }, {
                key: "initMessenger",
                value: function() {
                    return _.call(this)
                }
            }, {
                key: "initMailbox",
                value: function() {
                    return E.call(this)
                }
            }, {
                key: "initTabsSliding",
                value: function() {
                    return U.call(this)
                }
            }, {
                key: "initNightMode",
                value: function() {
                    return R.call(this)
                }
            }, {
                key: "initSpotlightMode",
                value: function() {
                    return O.call(this)
                }
            }, {
                key: "initSectionLines",
                value: function() {
                    return W.call(this)
                }
            }, {
                key: "initToasts",
                value: function() {
                    return F.call(this)
                }
            }, {
                key: "initPluginYaybar",
                value: function() {
                    return Y.call(this)
                }
            }, {
                key: "initPluginOverlayScrollbars",
                value: function() {
                    return N.call(this)
                }
            }, {
                key: "initPluginScrollspy",
                value: function() {
                    return B.call(this)
                }
            }, {
                key: "initPluginFeather",
                value: function(t) {
                    return q.call(this, t)
                }
            }, {
                key: "initPluginIonRangeslider",
                value: function() {
                    return L.call(this)
                }
            }, {
                key: "initPluginTouchSpin",
                value: function() {
                    return Q.call(this)
                }
            }, {
                key: "initPluginDateRangePicker",
                value: function() {
                    return K.call(this)
                }
            }, {
                key: "initPluginDateTimePicker",
                value: function() {
                    return G.call(this)
                }
            }, {
                key: "initPluginDataTable",
                value: function() {
                    return J.call(this)
                }
            }, {
                key: "initPluginJstree",
                value: function() {
                    return V.call(this)
                }
            }, {
                key: "initPluginPickr",
                value: function() {
                    return X.call(this)
                }
            }, {
                key: "initPluginPopover",
                value: function() {
                    return Z.call(this)
                }
            }, {
                key: "initPluginHightlight",
                value: function() {
                    return $.call(this)
                }
            }, {
                key: "initPluginEmojioneArea",
                value: function() {
                    return tt.call(this)
                }
            }, {
                key: "initPluginSortable",
                value: function() {
                    return et.call(this)
                }
            }, {
                key: "initPluginEasymde",
                value: function() {
                    return nt.call(this)
                }
            }, {
                key: "initPluginSweetalert",
                value: function() {
                    return it.call(this)
                }
            }, {
                key: "initPluginSwiper",
                value: function() {
                    return at.call(this)
                }
            }, {
                key: "initPluginInputmask",
                value: function() {
                    return ot.call(this)
                }
            }, {
                key: "initPluginSelectize",
                value: function() {
                    return rt.call(this)
                }
            }, {
                key: "initPluginQuill",
                value: function() {
                    return st.call(this)
                }
            }, {
                key: "initPluginDropzone",
                value: function() {
                    return lt.call(this)
                }
            }, {
                key: "initTransitionFix",
                value: function() {
                    return ut.call(this)
                }
            }]) && ct(e.prototype, n), a && ct(e, a), t
        }();
        window.RootUI = new dt
    }
});