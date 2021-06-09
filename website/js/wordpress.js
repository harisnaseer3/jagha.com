/*!
   --------------------------------
   Infinite Scroll
   --------------------------------
   + https://github.com/paulirish/infinite-scroll
   + version 2.1.0
   + Copyright 2011/12 Paul Irish & Luke Shumard
   + Licensed under the MIT license

   + Documentation: http://infinite-scroll.com/
*/
;
(function(e) {
    if (typeof define === "function" && define.amd) {
        define(["jquery"], e)
    } else {
        e(jQuery)
    }
})(function(e, t) {
    "use strict";
    e.infinitescroll = function(n, r, i) {
        this.element = e(i);
        if (!this._create(n, r)) {
            this.failed = true
        }
    };
    e.infinitescroll.defaults = {
        loading: {
            finished: t,
            finishedMsg: "<em>Congratulations, you've reached the end of the internet.</em>",
            img: "data:image/gif;base64,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",
            msg: null,
            msgText: "<em>Loading the next set of posts...</em>",
            selector: null,
            speed: "fast",
            start: t
        },
        state: {
            isDuringAjax: false,
            isInvalidPage: false,
            isDestroyed: false,
            isDone: false,
            isPaused: false,
            isBeyondMaxPage: false,
            currPage: 1
        },
        debug: false,
        behavior: t,
        binder: e(window),
        nextSelector: "div.navigation a:first",
        navSelector: "div.navigation",
        contentSelector: null,
        extraScrollPx: 150,
        itemSelector: "div.post",
        animate: false,
        pathParse: t,
        dataType: "html",
        appendCallback: true,
        bufferPx: 40,
        errorCallback: function() {},
        infid: 0,
        pixelsFromNavToBottom: t,
        path: t,
        prefill: false,
        maxPage: t
    };
    e.infinitescroll.prototype = {
        _binding: function(n) {
            var r = this,
                i = r.options;
            i.v = "2.0b2.120520";
            if (!!i.behavior && this["_binding_" + i.behavior] !== t) {
                this["_binding_" + i.behavior].call(this);
                return
            }
            if (n !== "bind" && n !== "unbind") {
                this._debug("Binding value  " + n + " not valid");
                return false
            }
            if (n === "unbind") {
                this.options.binder.unbind("smartscroll.infscr." + r.options.infid)
            } else {
                this.options.binder[n]("smartscroll.infscr." + r.options.infid, function() {
                    r.scroll()
                })
            }
            this._debug("Binding", n)
        },
        _create: function(r, i) {
            var s = e.extend(true, {}, e.infinitescroll.defaults, r);
            this.options = s;
            var o = e(window);
            var u = this;
            if (!u._validate(r)) {
                return false
            }
            var a = e(s.nextSelector).attr("href");
            if (!a) {
                this._debug("Navigation selector not found");
                return false
            }
            s.path = s.path || this._determinepath(a);
            s.contentSelector = s.contentSelector || this.element;
            s.loading.selector = s.loading.selector || s.contentSelector;
            s.loading.msg = s.loading.msg || e('<div id="infscr-loading"><img alt="Loading..." src="' + s.loading.img + '" /><div>' + s.loading.msgText + "</div></div>");
            (new Image).src = s.loading.img;
            if (s.pixelsFromNavToBottom === t) {
                s.pixelsFromNavToBottom = e(document).height() - e(s.navSelector).offset().top;
                this._debug("pixelsFromNavToBottom: " + s.pixelsFromNavToBottom)
            }
            var f = this;
            s.loading.start = s.loading.start || function() {
                e(s.navSelector).hide();
                s.loading.msg.appendTo(s.loading.selector).show(s.loading.speed, e.proxy(function() {
                    this.beginAjax(s)
                }, f))
            };
            s.loading.finished = s.loading.finished || function() {
                if (!s.state.isBeyondMaxPage) s.loading.msg.fadeOut(s.loading.speed)
            };
            s.callback = function(n, r, u) {
                if (!!s.behavior && n["_callback_" + s.behavior] !== t) {
                    n["_callback_" + s.behavior].call(e(s.contentSelector)[0], r, u)
                }
                if (i) {
                    i.call(e(s.contentSelector)[0], r, s, u)
                }
                if (s.prefill) {
                    o.bind("resize.infinite-scroll", n._prefill)
                }
            };
            if (r.debug) {
                if (Function.prototype.bind && (typeof console === "object" || typeof console === "function") && typeof console.log === "object") {
                    ["log", "info", "warn", "error", "assert", "dir", "clear", "profile", "profileEnd"].forEach(function(e) {
                        console[e] = this.call(console[e], console)
                    }, Function.prototype.bind)
                }
            }
            this._setup();
            if (s.prefill) {
                this._prefill()
            }
            return true
        },
        _prefill: function() {
            function i() {
                return e(n.options.contentSelector).height() <= r.height()
            }
            var n = this;
            var r = e(window);
            this._prefill = function() {
                if (i()) {
                    n.scroll()
                }
                r.bind("resize.infinite-scroll", function() {
                    if (i()) {
                        r.unbind("resize.infinite-scroll");
                        n.scroll()
                    }
                })
            };
            this._prefill()
        },
        _debug: function() {
            if (true !== this.options.debug) {
                return
            }
            if (typeof console !== "undefined" && typeof console.log === "function") {
                if (Array.prototype.slice.call(arguments).length === 1 && typeof Array.prototype.slice.call(arguments)[0] === "string") {
                    console.log(Array.prototype.slice.call(arguments).toString())
                } else {
                    console.log(Array.prototype.slice.call(arguments))
                }
            } else if (!Function.prototype.bind && typeof console !== "undefined" && typeof console.log === "object") {
                Function.prototype.call.call(console.log, console, Array.prototype.slice.call(arguments))
            }
        },
        _determinepath: function(n) {
            var r = this.options;
            if (!!r.behavior && this["_determinepath_" + r.behavior] !== t) {
                return this["_determinepath_" + r.behavior].call(this, n)
            }
            if (!!r.pathParse) {
                this._debug("pathParse manual");
                return r.pathParse(n, this.options.state.currPage + 1)
            } else if (n.match(/^(.*?)\b2\b(.*?$)/)) {
                n = n.match(/^(.*?)\b2\b(.*?$)/).slice(1)
            } else if (n.match(/^(.*?)2(.*?$)/)) {
                if (n.match(/^(.*?page=)2(\/.*|$)/)) {
                    n = n.match(/^(.*?page=)2(\/.*|$)/).slice(1);
                    return n
                }
                n = n.match(/^(.*?)2(.*?$)/).slice(1)
            } else {
                if (n.match(/^(.*?page=)1(\/.*|$)/)) {
                    n = n.match(/^(.*?page=)1(\/.*|$)/).slice(1);
                    return n
                } else {
                    this._debug("Sorry, we couldn't parse your Next (Previous Posts) URL. Verify your the css selector points to the correct A tag. If you still get this error: yell, scream, and kindly ask for help at infinite-scroll.com.");
                    r.state.isInvalidPage = true
                }
            }
            this._debug("determinePath", n);
            return n
        },
        _error: function(n) {
            var r = this.options;
            if (!!r.behavior && this["_error_" + r.behavior] !== t) {
                this["_error_" + r.behavior].call(this, n);
                return
            }
            if (n !== "destroy" && n !== "end") {
                n = "unknown"
            }
            this._debug("Error", n);
            if (n === "end" || r.state.isBeyondMaxPage) {
                this._showdonemsg()
            }
            r.state.isDone = true;
            r.state.currPage = 1;
            r.state.isPaused = false;
            r.state.isBeyondMaxPage = false;
            this._binding("unbind")
        },
        _loadcallback: function(r, i, s) {
            var o = this.options,
                u = this.options.callback,
                a = o.state.isDone ? "done" : !o.appendCallback ? "no-append" : "append",
                f;
            if (!!o.behavior && this["_loadcallback_" + o.behavior] !== t) {
                this["_loadcallback_" + o.behavior].call(this, r, i);
                return
            }
            switch (a) {
                case "done":
                    this._showdonemsg();
                    return false;
                case "no-append":
                    if (o.dataType === "html") {
                        i = "<div>" + i + "</div>";
                        i = e(i).find(o.itemSelector)
                    }
                    if (i.length === 0) {
                        return this._error("end")
                    }
                    break;
                case "append":
                    var l = r.children();
                    if (l.length === 0) {
                        return this._error("end")
                    }
                    f = document.createDocumentFragment();
                    while (r[0].firstChild) {
                        f.appendChild(r[0].firstChild)
                    }
                    this._debug("contentSelector", e(o.contentSelector)[0]);
                    e(o.contentSelector)[0].appendChild(f);
                    i = l.get();
                    break
            }
            o.loading.finished.call(e(o.contentSelector)[0], o);
            if (o.animate) {
                var c = e(window).scrollTop() + e(o.loading.msg).height() + o.extraScrollPx + "px";
                e("html,body").animate({
                    scrollTop: c
                }, 800, function() {
                    o.state.isDuringAjax = false
                })
            }
            if (!o.animate) {
                o.state.isDuringAjax = false
            }
            u(this, i, s);
            if (o.prefill) {
                this._prefill()
            }
        },
        _nearbottom: function() {
            var r = this.options,
                i = 0 + e(document).height() - r.binder.scrollTop() - e(window).height();
            if (!!r.behavior && this["_nearbottom_" + r.behavior] !== t) {
                return this["_nearbottom_" + r.behavior].call(this)
            }
            this._debug("math:", i, r.pixelsFromNavToBottom);
            return i - r.bufferPx < r.pixelsFromNavToBottom
        },
        _pausing: function(n) {
            var r = this.options;
            if (!!r.behavior && this["_pausing_" + r.behavior] !== t) {
                this["_pausing_" + r.behavior].call(this, n);
                return
            }
            if (n !== "pause" && n !== "resume" && n !== null) {
                this._debug("Invalid argument. Toggling pause value instead")
            }
            n = n && (n === "pause" || n === "resume") ? n : "toggle";
            switch (n) {
                case "pause":
                    r.state.isPaused = true;
                    break;
                case "resume":
                    r.state.isPaused = false;
                    break;
                case "toggle":
                    r.state.isPaused = !r.state.isPaused;
                    break
            }
            this._debug("Paused", r.state.isPaused);
            return false
        },
        _setup: function() {
            var n = this.options;
            if (!!n.behavior && this["_setup_" + n.behavior] !== t) {
                this["_setup_" + n.behavior].call(this);
                return
            }
            this._binding("bind");
            return false
        },
        _showdonemsg: function() {
            var r = this.options;
            if (!!r.behavior && this["_showdonemsg_" + r.behavior] !== t) {
                this["_showdonemsg_" + r.behavior].call(this);
                return
            }
            r.loading.msg.find("img").hide().parent().find("div").html(r.loading.finishedMsg).animate({
                opacity: 1
            }, 2e3, function() {
                e(this).parent().fadeOut(r.loading.speed)
            });
            r.errorCallback.call(e(r.contentSelector)[0], "done")
        },
        _validate: function(n) {
            for (var r in n) {
                if (r.indexOf && r.indexOf("Selector") > -1 && e(n[r]).length === 0) {
                    this._debug("Your " + r + " found no elements.");
                    return false
                }
            }
            return true
        },
        bind: function() {
            this._binding("bind")
        },
        destroy: function() {
            this.options.state.isDestroyed = true;
            this.options.loading.finished();
            return this._error("destroy")
        },
        pause: function() {
            this._pausing("pause")
        },
        resume: function() {
            this._pausing("resume")
        },
        beginAjax: function(r) {
            var i = this,
                s = r.path,
                o, u, a, f;
            r.state.currPage++;
            if (r.maxPage !== t && r.state.currPage > r.maxPage) {
                r.state.isBeyondMaxPage = true;
                this.destroy();
                return
            }
            o = e(r.contentSelector).is("table, tbody") ? e("<tbody/>") : e("<div/>");
            u = typeof s === "function" ? s(r.state.currPage) : s.join(r.state.currPage);
            i._debug("heading into ajax", u);
            a = r.dataType === "html" || r.dataType === "json" ? r.dataType : "html+callback";
            if (r.appendCallback && r.dataType === "html") {
                a += "+callback"
            }
            switch (a) {
                case "html+callback":
                    i._debug("Using HTML via .load() method");
                    o.load(u + " " + r.itemSelector, t, function(t) {
                        i._loadcallback(o, t, u)
                    });
                    break;
                case "html":
                    i._debug("Using " + a.toUpperCase() + " via $.ajax() method");
                    e.ajax({
                        url: u,
                        dataType: r.dataType,
                        complete: function(t, n) {
                            f = typeof t.isResolved !== "undefined" ? t.isResolved() : n === "success" || n === "notmodified";
                            if (f) {
                                i._loadcallback(o, t.responseText, u)
                            } else {
                                i._error("end")
                            }
                        }
                    });
                    break;
                case "json":
                    i._debug("Using " + a.toUpperCase() + " via $.ajax() method");
                    e.ajax({
                        dataType: "json",
                        type: "GET",
                        url: u,
                        success: function(e, n, s) {
                            f = typeof s.isResolved !== "undefined" ? s.isResolved() : n === "success" || n === "notmodified";
                            if (r.appendCallback) {
                                if (r.template !== t) {
                                    var a = r.template(e);
                                    o.append(a);
                                    if (f) {
                                        i._loadcallback(o, a)
                                    } else {
                                        i._error("end")
                                    }
                                } else {
                                    i._debug("template must be defined.");
                                    i._error("end")
                                }
                            } else {
                                if (f) {
                                    i._loadcallback(o, e, u)
                                } else {
                                    i._error("end")
                                }
                            }
                        },
                        error: function() {
                            i._debug("JSON ajax request failed.");
                            i._error("end")
                        }
                    });
                    break
            }
        },
        retrieve: function(r) {
            r = r || null;
            var i = this,
                s = i.options;
            if (!!s.behavior && this["retrieve_" + s.behavior] !== t) {
                this["retrieve_" + s.behavior].call(this, r);
                return
            }
            if (s.state.isDestroyed) {
                this._debug("Instance is destroyed");
                return false
            }
            s.state.isDuringAjax = true;
            s.loading.start.call(e(s.contentSelector)[0], s)
        },
        scroll: function() {
            var n = this.options,
                r = n.state;
            if (!!n.behavior && this["scroll_" + n.behavior] !== t) {
                this["scroll_" + n.behavior].call(this);
                return
            }
            if (r.isDuringAjax || r.isInvalidPage || r.isDone || r.isDestroyed || r.isPaused) {
                return
            }
            if (!this._nearbottom()) {
                return
            }
            this.retrieve()
        },
        toggle: function() {
            this._pausing()
        },
        unbind: function() {
            this._binding("unbind")
        },
        update: function(n) {
            if (e.isPlainObject(n)) {
                this.options = e.extend(true, this.options, n)
            }
        }
    };
    e.fn.infinitescroll = function(n, r) {
        var i = typeof n;
        switch (i) {
            case "string":
                var s = Array.prototype.slice.call(arguments, 1);
                this.each(function() {
                    var t = e.data(this, "infinitescroll");
                    if (!t) {
                        return false
                    }
                    if (!e.isFunction(t[n]) || n.charAt(0) === "_") {
                        return false
                    }
                    t[n].apply(t, s)
                });
                break;
            case "object":
                this.each(function() {
                    var t = e.data(this, "infinitescroll");
                    if (t) {
                        t.update(n)
                    } else {
                        t = new e.infinitescroll(n, r, this);
                        if (!t.failed) {
                            e.data(this, "infinitescroll", t)
                        }
                    }
                });
                break
        }
        return this
    };
    var n = e.event,
        r;
    n.special.smartscroll = {
        setup: function() {
            e(this).bind("scroll", n.special.smartscroll.handler)
        },
        teardown: function() {
            e(this).unbind("scroll", n.special.smartscroll.handler)
        },
        handler: function(t, n) {
            var i = this,
                s = arguments;
            t.type = "smartscroll";
            if (r) {
                clearTimeout(r)
            }
            r = setTimeout(function() {
                e(i).trigger("smartscroll", s)
            }, n === "execAsap" ? 0 : 100)
        }
    };
    e.fn.smartscroll = function(e) {
        return e ? this.bind("smartscroll", e) : this.trigger("smartscroll", ["execAsap"])
    }
});

jQuery(document).ready(function(e) {
    "use strict";
    e(window).load(function() {
        var t = e("#head-main-top").outerHeight();
        e(window).scroll(function() {
            e(window).scrollTop() > t ? (e("#main-nav-wrap").addClass("fixed").css("top", "0"), e(".nav-logo-fade").addClass("nav-logo-show"), e(".nav-logo-out").addClass("nav-logo-out-fade"), e(".nav-logo-in").addClass("nav-logo-in-fade"), e(".nav-left-wrap").addClass("nav-left-width"), e("#wallpaper").addClass("wall-fixed"), e(".col-tabs-wrap").addClass("fixed-col").css("top", "50px"), e("#body-main-wrap").addClass("tabs-top-marg"), e("#body-main-wrap").addClass("body-top-pad"), e(".fly-to-top").addClass("to-top-trans")) : (e("#main-nav-wrap").removeClass("fixed"), e(".nav-logo-fade").removeClass("nav-logo-show"), e(".nav-logo-out").removeClass("nav-logo-out-fade"), e(".nav-logo-in").removeClass("nav-logo-in-fade"), e(".nav-left-wrap").removeClass("nav-left-width"), e("#wallpaper").removeClass("wall-fixed"), e(".col-tabs-wrap").removeClass("fixed-col").css("top", "0"), e("#body-main-wrap").removeClass("tabs-top-marg"), e("#body-main-wrap").removeClass("body-top-pad"), e(".fly-to-top").removeClass("to-top-trans"))
        })
    }), e(".fly-but-wrap").on("click", function() {
        e("#fly-wrap").toggleClass("fly-menu"), e("#head-main-top").toggleClass("fly-content"), e("#wallpaper").toggleClass("fly-content"), e(".col-tabs-wrap").toggleClass("fly-content"), e("#main-nav-wrap").toggleClass("main-nav-over"), e("#soc-nav-wrap").toggleClass("fly-content"), e("#body-main-wrap").toggleClass("fly-content"), e(".fly-but-wrap").toggleClass("fly-open"), e(".fly-fade").toggleClass("fly-fade-trans")
    });
    e(".back-to-top").on("click", function(t) {
        return t.preventDefault(), e("html, body").animate({
            scrollTop: 0
        }, 500), !1
    }), e(".nav-search-but").on("click", function() {
        e(".search-fly-wrap").slideToggle()
    }), e("#site-wrap").each(function() {
        e(this).find("ul.col-tabs li.feat-col-tab").addClass("active").show()
    }), e("ul.col-tabs li").on("click", function(t) {
        e(this).parents("#site-wrap").find("ul.col-tabs li").removeClass("active"), e(this).addClass("active"), e(this).parents("#site-wrap").find(".tab-col-cont").hide();
        var i = e(this).find("a").attr("href");
        return e(this).parents("#site-wrap").find(i).fadeIn(), e("html, body").animate({
            scrollTop: 0
        }, 500), !1
    }), e("ul.col-tabs li a").on("click", function(e) {
        e.preventDefault()
    }), e(".non-feat-tab").on("click", function(t) {
        e("#feat-top-wrap").hide(), e("#feat-wide-wrap").hide()
    }), e(".feat-col-tab").on("click", function(t) {
        e("#feat-top-wrap").fadeIn(), e("#feat-wide-wrap").fadeIn()
    })
}),
    function(e, t, i) {
        t.fn.touchwipe = function(e) {
            var i = {
                min_move_x: 20,
                min_move_y: 20,
                wipeLeft: function() {},
                wipeRight: function() {},
                wipeUp: function() {},
                wipeDown: function() {},
                preventDefaultEvents: !0
            };
            return e && t.extend(i, e), this.each(function() {
                var e, t, o = !1;

                function n() {
                    this.removeEventListener("touchmove", r), e = null, o = !1
                }

                function r(r) {
                    if (i.preventDefaultEvents && r.preventDefault(), o) {
                        var s = r.touches[0].pageX,
                            a = r.touches[0].pageY,
                            l = e - s,
                            c = t - a;
                        Math.abs(l) >= i.min_move_x ? (n(), l > 0 ? i.wipeLeft() : i.wipeRight()) : Math.abs(c) >= i.min_move_y && (n(), c > 0 ? i.wipeDown() : i.wipeUp())
                    }
                }
                "ontouchstart" in document.documentElement && this.addEventListener("touchstart", function(i) {
                    1 == i.touches.length && (e = i.touches[0].pageX, t = i.touches[0].pageY, o = !0, this.addEventListener("touchmove", r, !1))
                }, !1)
            }), this
        }, t.elastislide = function(e, i) {
            this.$el = t(i), this._init(e)
        }, t.elastislide.defaults = {
            speed: 450,
            easing: "",
            imageW: 190,
            margin: 0,
            border: 0,
            minItems: 1,
            current: 0,
            onClick: function() {
                return !1
            }
        }, t.elastislide.prototype = {
            _init: function(e) {
                this.options = t.extend(!0, {}, t.elastislide.defaults, e), this.$slider = this.$el.find("ul"), this.$items = this.$slider.children("li"), this.itemsCount = this.$items.length, this.$esCarousel = this.$slider.parent(), this._validateOptions(), this._configure(), this._addControls(), this._initEvents(), this.$slider.show(), this._slideToCurrent(!1)
            },
            _validateOptions: function() {
                this.options.speed < 0 && (this.options.speed = 450), this.options.margin < 0 && (this.options.margin = 4), this.options.border < 0 && (this.options.border = 1), (this.options.minItems < 1 || this.options.minItems > this.itemsCount) && (this.options.minItems = 1), this.options.current > this.itemsCount - 1 && (this.options.current = 0)
            },
            _configure: function() {
                this.current = this.options.current, this.visibleWidth = this.$esCarousel.width(), this.visibleWidth < this.options.minItems * (this.options.imageW + 2 * this.options.border) + (this.options.minItems - 1) * this.options.margin ? (this._setDim((this.visibleWidth - (this.options.minItems - 1) * this.options.margin) / this.options.minItems), this._setCurrentValues(), this.fitCount = this.options.minItems) : (this._setDim(), this._setCurrentValues()), this.$slider.css({
                    width: this.sliderW
                })
            },
            _setDim: function(e) {
                this.$items.css({
                    marginRight: this.options.margin,
                    width: e || this.options.imageW + 2 * this.options.border
                }).children("a").css({
                    borderWidth: this.options.border
                })
            },
            _setCurrentValues: function() {
                this.itemW = this.$items.outerWidth(!0), this.sliderW = this.itemW * this.itemsCount, this.visibleWidth = this.$esCarousel.width(), this.fitCount = Math.floor(this.visibleWidth / this.itemW)
            },
            _addControls: function() {
                this.$navNext = t('<span class="es-nav-next"><a>&gt;</a></span>'), this.$navPrev = t('<span class="es-nav-prev"><a>&lt;</a></span>'), t('<div class="es-nav"/>').append(this.$navPrev).append(this.$navNext).appendTo(this.$el)
            },
            _toggleControls: function(e, t) {
                e && t ? 1 === t ? "right" === e ? this.$navNext.show() : this.$navPrev.show() : "right" === e ? this.$navNext.hide() : this.$navPrev.hide() : (this.current === this.itemsCount - 1 || this.fitCount >= this.itemsCount) && this.$navNext.hide()
            },
            _initEvents: function() {
                var i = this;
                t(e).bind("resize.elastislide", function(e) {
                    i._setCurrentValues(), i.visibleWidth < i.options.minItems * (i.options.imageW + 2 * i.options.border) + (i.options.minItems - 1) * i.options.margin ? (i._setDim((i.visibleWidth - (i.options.minItems - 1) * i.options.margin) / i.options.minItems), i._setCurrentValues(), i.fitCount = i.options.minItems) : (i._setDim(), i._setCurrentValues()), i.$slider.css({
                        width: i.sliderW + 10
                    }), clearTimeout(i.resetTimeout), i.resetTimeout = setTimeout(function() {
                        i._slideToCurrent()
                    }, 200)
                }), this.$navNext.bind("click.elastislide", function(e) {
                    i._slide("right")
                }), this.$navPrev.bind("click.elastislide", function(e) {
                    i._slide("left")
                }), this.$items.bind("click.elastislide", function(e) {
                    i.options.onClick(t(this))
                }), i.$slider.touchwipe({
                    wipeLeft: function() {
                        i._slide("right")
                    },
                    wipeRight: function() {
                        i._slide("left")
                    }
                })
            },
            _slide: function(e, i, o, n) {
                if (this.$slider.is(":animated")) return !1;
                var r = parseFloat(this.$slider.css("margin-left"));
                if (void 0 === i) {
                    var s = this.fitCount * this.itemW;
                    if (s < 0) return !1;
                    if ("right" === e && this.sliderW - (Math.abs(r) + s) < this.visibleWidth) s = this.sliderW - (Math.abs(r) + this.visibleWidth) - this.options.margin, this._toggleControls("right", -1), this._toggleControls("left", 1);
                    else if ("left" === e && Math.abs(r) - s < 0) s = Math.abs(r), this._toggleControls("left", -1), this._toggleControls("right", 1);
                    else {
                        (a = "right" === e ? Math.abs(r) + this.options.margin + Math.abs(s) : Math.abs(r) - this.options.margin - Math.abs(s)) > 0 ? this._toggleControls("left", 1) : this._toggleControls("left", -1), a < this.sliderW - this.visibleWidth ? this._toggleControls("right", 1) : this._toggleControls("right", -1)
                    }
                    i = "right" === e ? "-=" + s : "+=" + s
                } else {
                    var a = Math.abs(i);
                    Math.max(this.sliderW, this.visibleWidth) - a < this.visibleWidth && (0 !== (i = -(Math.max(this.sliderW, this.visibleWidth) - this.visibleWidth)) && (i += this.options.margin), this._toggleControls("right", -1), a = Math.abs(i)), a > 0 ? this._toggleControls("left", 1) : this._toggleControls("left", -1), Math.max(this.sliderW, this.visibleWidth) - this.visibleWidth > a + this.options.margin ? this._toggleControls("right", 1) : this._toggleControls("right", -1)
                }
                t.fn.applyStyle = void 0 === o ? t.fn.animate : t.fn.css;
                var l = {
                    marginLeft: i
                };
                this.$slider.applyStyle(l, t.extend(!0, [], {
                    duration: this.options.speed,
                    easing: this.options.easing,
                    complete: function() {
                        n && n.call()
                    }
                }))
            },
            _slideToCurrent: function(e) {
                var t = this.current * this.itemW;
                this._slide("", -t, e)
            },
            add: function(e, t) {
                this.$items = this.$items.add(e), this.itemsCount = this.$items.length, this._setDim(), this._setCurrentValues(), this.$slider.css({
                    width: this.sliderW
                }), this._slideToCurrent(), t && t.call(e)
            },
            destroy: function(e) {
                this._destroy(e)
            },
            _destroy: function(i) {
                this.$el.unbind(".elastislide").removeData("elastislide"), t(e).unbind(".elastislide"), i && i.call()
            }
        };
        var o = function(e) {
            this.console && console.error(e)
        };
        t.fn.elastislide = function(e) {
            if ("string" == typeof e) {
                var i = Array.prototype.slice.call(arguments, 1);
                this.each(function() {
                    var n = t.data(this, "elastislide");
                    n ? t.isFunction(n[e]) && "_" !== e.charAt(0) ? n[e].apply(n, i) : o("no such method '" + e + "' for elastislide instance") : o("cannot call methods on elastislide prior to initialization; attempted to call method '" + e + "'")
                })
            } else this.each(function() {
                t.data(this, "elastislide") || t.data(this, "elastislide", new t.elastislide(e, this))
            });
            return this
        }
    }(window, jQuery),
    function(e) {
        var t = !1,
            i = !1,
            o = 5e3,
            n = 2e3,
            r = 0,
            s = e;
        var l, c, d = (l = document.getElementsByTagName("script"), (c = l[l.length - 1].src.split("?")[0]).split("/").length > 0 ? c.split("/").slice(0, -1).join("/") + "/" : ""),
            u = ["ms", "moz", "webkit", "o"],
            h = window.requestAnimationFrame || !1,
            p = window.cancelAnimationFrame || !1;
        if (!h)
            for (var m in u) {
                var f = u[m];
                h || (h = window[f + "RequestAnimationFrame"]), p || (p = window[f + "CancelAnimationFrame"] || window[f + "CancelRequestAnimationFrame"])
            }
        var v = window.MutationObserver || window.WebKitMutationObserver || !1,
            g = {
                zindex: "auto",
                cursoropacitymin: 0,
                cursoropacitymax: 1,
                cursorcolor: "#424242",
                cursorwidth: "5px",
                cursorborder: "1px solid #fff",
                cursorborderradius: "5px",
                scrollspeed: 60,
                mousescrollstep: 24,
                touchbehavior: !1,
                hwacceleration: !0,
                usetransition: !0,
                boxzoom: !1,
                dblclickzoom: !0,
                gesturezoom: !0,
                grabcursorenabled: !0,
                autohidemode: !0,
                background: "",
                iframeautoresize: !0,
                cursorminheight: 32,
                preservenativescrolling: !0,
                railoffset: !1,
                bouncescroll: !0,
                spacebarenabled: !0,
                railpadding: {
                    top: 0,
                    right: 0,
                    left: 0,
                    bottom: 0
                },
                disableoutline: !0,
                horizrailenabled: !0,
                railalign: "right",
                railvalign: "bottom",
                enabletranslate3d: !0,
                enablemousewheel: !0,
                enablekeyboard: !0,
                smoothscroll: !0,
                sensitiverail: !0,
                enablemouselockapi: !0,
                cursorfixedheight: !1,
                directionlockdeadzone: 6,
                hidecursordelay: 400,
                nativeparentscrolling: !0,
                enablescrollonselection: !0,
                overflowx: !0,
                overflowy: !0,
                cursordragspeed: .3,
                rtlmode: !1,
                cursordragontouch: !1,
                oneaxismousemode: "auto"
            },
            w = !1,
            b = function(e, a) {
                var l = this;
                if (this.version = "3.5.0 BETA5", this.name = "nicescroll", this.me = a, this.opt = {
                    doc: s("body"),
                    win: !1
                }, s.extend(this.opt, g), this.opt.snapbackspeed = 80, e)
                    for (var c in l.opt) void 0 !== e[c] && (l.opt[c] = e[c]);
                this.doc = l.opt.doc, this.iddoc = this.doc && this.doc[0] && this.doc[0].id || "", this.ispage = /BODY|HTML/.test(l.opt.win ? l.opt.win[0].nodeName : this.doc[0].nodeName), this.haswrapper = !1 !== l.opt.win, this.win = l.opt.win || (this.ispage ? s(window) : this.doc), this.docscroll = this.ispage && !this.haswrapper ? s(window) : this.win, this.body = s("body"), this.viewport = !1, this.isfixed = !1, this.iframe = !1, this.isiframe = "IFRAME" == this.doc[0].nodeName && "IFRAME" == this.win[0].nodeName, this.istextarea = "TEXTAREA" == this.win[0].nodeName, this.forcescreen = !1, this.canshowonmouseevent = "scroll" != l.opt.autohidemode, this.onmousedown = !1, this.onmouseup = !1, this.onmousemove = !1, this.onmousewheel = !1, this.onkeypress = !1, this.ongesturezoom = !1, this.onclick = !1, this.onscrollstart = !1, this.onscrollend = !1, this.onscrollcancel = !1, this.onzoomin = !1, this.onzoomout = !1, this.view = !1, this.page = !1, this.scroll = {
                    x: 0,
                    y: 0
                }, this.scrollratio = {
                    x: 0,
                    y: 0
                }, this.cursorheight = 20, this.scrollvaluemax = 0, this.checkrtlmode = !1, this.scrollrunning = !1, this.scrollmom = !1, this.observer = !1, this.observerremover = !1;
                do {
                    this.id = "ascrail" + n++
                } while (document.getElementById(this.id));
                this.rail = !1, this.cursor = !1, this.cursorfreezed = !1, this.selectiondrag = !1, this.zoom = !1, this.zoomactive = !1, this.hasfocus = !1, this.hasmousefocus = !1, this.visibility = !0, this.locked = !1, this.hidden = !1, this.cursoractive = !0, this.overflowx = l.opt.overflowx, this.overflowy = l.opt.overflowy, this.nativescrollingarea = !1, this.checkarea = 0, this.events = [], this.saved = {}, this.delaylist = {}, this.synclist = {}, this.lastdeltax = 0, this.lastdeltay = 0, this.detected = function() {
                    if (w) return w;
                    var e = document.createElement("DIV"),
                        t = {};
                    t.haspointerlock = "pointerLockElement" in document || "mozPointerLockElement" in document || "webkitPointerLockElement" in document, t.isopera = "opera" in window, t.isopera12 = t.isopera && "getUserMedia" in navigator, t.isoperamini = "[object OperaMini]" === Object.prototype.toString.call(window.operamini), t.isie = "all" in document && "attachEvent" in e && !t.isopera, t.isieold = t.isie && !("msInterpolationMode" in e.style), t.isie7 = t.isie && !t.isieold && (!("documentMode" in document) || 7 == document.documentMode), t.isie8 = t.isie && "documentMode" in document && 8 == document.documentMode, t.isie9 = t.isie && "performance" in window && document.documentMode >= 9, t.isie10 = t.isie && "performance" in window && document.documentMode >= 10, t.isie9mobile = /iemobile.9/i.test(navigator.userAgent), t.isie9mobile && (t.isie9 = !1), t.isie7mobile = !t.isie9mobile && t.isie7 && /iemobile/i.test(navigator.userAgent), t.ismozilla = "MozAppearance" in e.style, t.iswebkit = "WebkitAppearance" in e.style, t.ischrome = "chrome" in window, t.ischrome22 = t.ischrome && t.haspointerlock, t.ischrome26 = t.ischrome && "transition" in e.style, t.cantouch = "ontouchstart" in document.documentElement || "ontouchstart" in window, t.hasmstouch = window.navigator.msPointerEnabled || !1, t.ismac = /^mac$/i.test(navigator.platform), t.isios = t.cantouch && /iphone|ipad|ipod/i.test(navigator.platform), t.isios4 = t.isios && !("seal" in Object), t.isandroid = /android/i.test(navigator.userAgent), t.trstyle = !1, t.hastransform = !1, t.hastranslate3d = !1, t.transitionstyle = !1, t.hastransition = !1, t.transitionend = !1;
                    for (var i = ["transform", "msTransform", "webkitTransform", "MozTransform", "OTransform"], o = 0; o < i.length; o++)
                        if (void 0 !== e.style[i[o]]) {
                            t.trstyle = i[o];
                            break
                        } t.hastransform = 0 != t.trstyle, t.hastransform && (e.style[t.trstyle] = "translate3d(1px,2px,3px)", t.hastranslate3d = /translate3d/.test(e.style[t.trstyle])), t.transitionstyle = !1, t.prefixstyle = "", t.transitionend = !1;
                    i = ["transition", "webkitTransition", "MozTransition", "OTransition", "OTransition", "msTransition", "KhtmlTransition"];
                    var n = ["", "-webkit-", "-moz-", "-o-", "-o", "-ms-", "-khtml-"],
                        r = ["transitionend", "webkitTransitionEnd", "transitionend", "otransitionend", "oTransitionEnd", "msTransitionEnd", "KhtmlTransitionEnd"];
                    for (o = 0; o < i.length; o++)
                        if (i[o] in e.style) {
                            t.transitionstyle = i[o], t.prefixstyle = n[o], t.transitionend = r[o];
                            break
                        } return t.ischrome26 && (t.prefixstyle = n[1]), t.hastransition = t.transitionstyle, t.cursorgrabvalue = function() {
                        var i = ["-moz-grab", "-webkit-grab", "grab"];
                        (t.ischrome && !t.ischrome22 || t.isie) && (i = []);
                        for (var o = 0; o < i.length; o++) {
                            var n = i[o];
                            if (e.style.cursor = n, e.style.cursor == n) return n
                        }
                        return "url(http://www.google.com/intl/en_ALL/mapfiles/openhand.cur),n-resize"
                    }(), t.hasmousecapture = "setCapture" in e, t.hasMutationObserver = !1 !== v, e = null, w = t, t
                }();
                var u = s.extend({}, this.detected);
                if (this.canhwscroll = u.hastransform && l.opt.hwacceleration, this.ishwscroll = this.canhwscroll && l.haswrapper, this.istouchcapable = !1, u.cantouch && u.ischrome && !u.isios && !u.isandroid && (this.istouchcapable = !0, u.cantouch = !1), u.cantouch && u.ismozilla && !u.isios && !u.isandroid && (this.istouchcapable = !0, u.cantouch = !1), l.opt.enablemouselockapi || (u.hasmousecapture = !1, u.haspointerlock = !1), this.delayed = function(e, t, i, o) {
                    var n = l.delaylist[e],
                        r = (new Date).getTime();
                    if (!o && n && n.tt) return !1;
                    n && n.tt && clearTimeout(n.tt), n && n.last + i > r && !n.tt ? l.delaylist[e] = {
                        last: r + i,
                        tt: setTimeout(function() {
                            l.delaylist[e].tt = 0, t.call()
                        }, i)
                    } : n && n.tt || (l.delaylist[e] = {
                        last: r,
                        tt: 0
                    }, setTimeout(function() {
                        t.call()
                    }, 0))
                }, this.debounced = function(e, t, i) {
                    var o = l.delaylist[e];
                    (new Date).getTime();
                    l.delaylist[e] = t, o || setTimeout(function() {
                        var t = l.delaylist[e];
                        l.delaylist[e] = !1, t.call()
                    }, i)
                }, this.synched = function(e, t) {
                    return l.synclist[e] = t, l.onsync || (h(function() {
                        for (e in l.onsync = !1, l.synclist) {
                            var t = l.synclist[e];
                            t && t.call(l), l.synclist[e] = !1
                        }
                    }), l.onsync = !0), e
                }, this.unsynched = function(e) {
                    l.synclist[e] && (l.synclist[e] = !1)
                }, this.css = function(e, t) {
                    for (var i in t) l.saved.css.push([e, i, e.css(i)]), e.css(i, t[i])
                }, this.scrollTop = function(e) {
                    return void 0 === e ? l.getScrollTop() : l.setScrollTop(e)
                }, this.scrollLeft = function(e) {
                    return void 0 === e ? l.getScrollLeft() : l.setScrollLeft(e)
                }, BezierClass = function(e, t, i, o, n, r, s) {
                    this.st = e, this.ed = t, this.spd = i, this.p1 = o || 0, this.p2 = n || 1, this.p3 = r || 0, this.p4 = s || 1, this.ts = (new Date).getTime(), this.df = this.ed - this.st
                }, BezierClass.prototype = {
                    B2: function(e) {
                        return 3 * e * e * (1 - e)
                    },
                    B3: function(e) {
                        return 3 * e * (1 - e) * (1 - e)
                    },
                    B4: function(e) {
                        return (1 - e) * (1 - e) * (1 - e)
                    },
                    getNow: function() {
                        var e = 1 - ((new Date).getTime() - this.ts) / this.spd,
                            t = this.B2(e) + this.B3(e) + this.B4(e);
                        return e < 0 ? this.ed : this.st + Math.round(this.df * t)
                    },
                    update: function(e, t) {
                        return this.st = this.getNow(), this.ed = e, this.spd = t, this.ts = (new Date).getTime(), this.df = this.ed - this.st, this
                    }
                }, this.ishwscroll) {
                    function m() {
                        var e = l.doc.css(u.trstyle);
                        return !(!e || "matrix" != e.substr(0, 6)) && e.replace(/^.*\((.*)\)$/g, "$1").replace(/px/g, "").split(/, +/)
                    }
                    this.doc.translate = {
                        x: 0,
                        y: 0,
                        tx: "0px",
                        ty: "0px"
                    }, u.hastranslate3d && u.isios && this.doc.css("-webkit-backface-visibility", "hidden"), this.getScrollTop = function(e) {
                        if (!e) {
                            var t = m();
                            if (t) return 16 == t.length ? -t[13] : -t[5];
                            if (l.timerscroll && l.timerscroll.bz) return l.timerscroll.bz.getNow()
                        }
                        return l.doc.translate.y
                    }, this.getScrollLeft = function(e) {
                        if (!e) {
                            var t = m();
                            if (t) return 16 == t.length ? -t[12] : -t[4];
                            if (l.timerscroll && l.timerscroll.bh) return l.timerscroll.bh.getNow()
                        }
                        return l.doc.translate.x
                    }, document.createEvent ? this.notifyScrollEvent = function(e) {
                        var t = document.createEvent("UIEvents");
                        t.initUIEvent("scroll", !1, !0, window, 1), e.dispatchEvent(t)
                    } : document.fireEvent ? this.notifyScrollEvent = function(e) {
                        var t = document.createEventObject();
                        e.fireEvent("onscroll"), t.cancelBubble = !0
                    } : this.notifyScrollEvent = function(e, t) {}, u.hastranslate3d && l.opt.enabletranslate3d ? (this.setScrollTop = function(e, t) {
                        l.doc.translate.y = e, l.doc.translate.ty = -1 * e + "px", l.doc.css(u.trstyle, "translate3d(" + l.doc.translate.tx + "," + l.doc.translate.ty + ",0px)"), t || l.notifyScrollEvent(l.win[0])
                    }, this.setScrollLeft = function(e, t) {
                        l.doc.translate.x = e, l.doc.translate.tx = -1 * e + "px", l.doc.css(u.trstyle, "translate3d(" + l.doc.translate.tx + "," + l.doc.translate.ty + ",0px)"), t || l.notifyScrollEvent(l.win[0])
                    }) : (this.setScrollTop = function(e, t) {
                        l.doc.translate.y = e, l.doc.translate.ty = -1 * e + "px", l.doc.css(u.trstyle, "translate(" + l.doc.translate.tx + "," + l.doc.translate.ty + ")"), t || l.notifyScrollEvent(l.win[0])
                    }, this.setScrollLeft = function(e, t) {
                        l.doc.translate.x = e, l.doc.translate.tx = -1 * e + "px", l.doc.css(u.trstyle, "translate(" + l.doc.translate.tx + "," + l.doc.translate.ty + ")"), t || l.notifyScrollEvent(l.win[0])
                    })
                } else this.getScrollTop = function() {
                    return l.docscroll.scrollTop()
                }, this.setScrollTop = function(e) {
                    return l.docscroll.scrollTop(e)
                }, this.getScrollLeft = function() {
                    return l.docscroll.scrollLeft()
                }, this.setScrollLeft = function(e) {
                    return l.docscroll.scrollLeft(e)
                };
                this.getTarget = function(e) {
                    return !!e && (e.target ? e.target : !!e.srcElement && e.srcElement)
                }, this.hasParent = function(e, t) {
                    if (!e) return !1;
                    for (var i = e.target || e.srcElement || e || !1; i && i.id != t;) i = i.parentNode || !1;
                    return !1 !== i
                };
                var f = {
                    thin: 1,
                    medium: 3,
                    thick: 5
                };

                function b(e, t, i) {
                    var o = e.css(t),
                        n = parseFloat(o);
                    if (isNaN(n)) {
                        var r = 3 == (n = f[o] || 0) ? i ? l.win.outerHeight() - l.win.innerHeight() : l.win.outerWidth() - l.win.innerWidth() : 1;
                        return l.isie8 && n && (n += 1), r ? n : 0
                    }
                    return n
                }

                function x(e, t, i, o) {
                    l._bind(e, t, function(o) {
                        var n = {
                            original: o = o || window.event,
                            target: o.target || o.srcElement,
                            type: "wheel",
                            deltaMode: "MozMousePixelScroll" == o.type ? 0 : 1,
                            deltaX: 0,
                            deltaZ: 0,
                            preventDefault: function() {
                                return o.preventDefault ? o.preventDefault() : o.returnValue = !1, !1
                            },
                            stopImmediatePropagation: function() {
                                o.stopImmediatePropagation ? o.stopImmediatePropagation() : o.cancelBubble = !0
                            }
                        };
                        return "mousewheel" == t ? (n.deltaY = -.025 * o.wheelDelta, o.wheelDeltaX && (n.deltaX = -.025 * o.wheelDeltaX)) : n.deltaY = o.detail, i.call(e, n)
                    }, o)
                }

                function S(e, t, i) {
                    var o, n;
                    if (0 == e.deltaMode ? (o = -Math.floor(e.deltaX * (l.opt.mousescrollstep / 54)), n = -Math.floor(e.deltaY * (l.opt.mousescrollstep / 54))) : 1 == e.deltaMode && (o = -Math.floor(e.deltaX * l.opt.mousescrollstep), n = -Math.floor(e.deltaY * l.opt.mousescrollstep)), t && l.opt.oneaxismousemode && 0 == o && n && (o = n, n = 0), o && (l.scrollmom && l.scrollmom.stop(), l.lastdeltax += o, l.debounced("mousewheelx", function() {
                        var e = l.lastdeltax;
                        l.lastdeltax = 0, l.rail.drag || l.doScrollLeftBy(e)
                    }, 120)), n) {
                        if (l.opt.nativeparentscrolling && i && !l.ispage && !l.zoomactive)
                            if (n < 0) {
                                if (l.getScrollTop() >= l.page.maxh) return !0
                            } else if (l.getScrollTop() <= 0) return !0;
                        l.scrollmom && l.scrollmom.stop(), l.lastdeltay += n, l.debounced("mousewheely", function() {
                            var e = l.lastdeltay;
                            l.lastdeltay = 0, l.rail.drag || l.doScrollBy(e)
                        }, 120)
                    }
                    return e.stopImmediatePropagation(), e.preventDefault()
                }
                this.getOffset = function() {
                    if (l.isfixed) return {
                        top: parseFloat(l.win.css("top")),
                        left: parseFloat(l.win.css("left"))
                    };
                    if (!l.viewport) return l.win.offset();
                    var e = l.win.offset(),
                        t = l.viewport.offset();
                    return {
                        top: e.top - t.top + l.viewport.scrollTop(),
                        left: e.left - t.left + l.viewport.scrollLeft()
                    }
                }, this.updateScrollBar = function(e) {
                    if (l.ishwscroll) l.rail.css({
                        height: l.win.innerHeight()
                    }), l.railh && l.railh.css({
                        width: l.win.innerWidth()
                    });
                    else {
                        var t = l.getOffset();
                        (o = {
                            top: t.top,
                            left: t.left
                        }).top += b(l.win, "border-top-width", !0);
                        l.win.outerWidth(), l.win.innerWidth();
                        o.left += l.rail.align ? l.win.outerWidth() - b(l.win, "border-right-width") - l.rail.width : b(l.win, "border-left-width");
                        var i = l.opt.railoffset;
                        if (i && (i.top && (o.top += i.top), l.rail.align && i.left && (o.left += i.left)), l.locked || l.rail.css({
                            top: o.top,
                            left: o.left,
                            height: e ? e.h : l.win.innerHeight()
                        }), l.zoom && l.zoom.css({
                            top: o.top + 1,
                            left: 1 == l.rail.align ? o.left - 20 : o.left + l.rail.width + 4
                        }), l.railh && !l.locked) {
                            var o = {
                                    top: t.top,
                                    left: t.left
                                },
                                n = l.railh.align ? o.top + b(l.win, "border-top-width", !0) + l.win.innerHeight() - l.railh.height : o.top + b(l.win, "border-top-width", !0),
                                r = o.left + b(l.win, "border-left-width");
                            l.railh.css({
                                top: n,
                                left: r,
                                width: l.railh.width
                            })
                        }
                    }
                }, this.doRailClick = function(e, t, i) {
                    var o, n, r, s;
                    l.locked || (l.cancelEvent(e), t ? (o = i ? l.doScrollLeft : l.doScrollTop)(r = i ? (e.pageX - l.railh.offset().left - l.cursorwidth / 2) * l.scrollratio.x : (e.pageY - l.rail.offset().top - l.cursorheight / 2) * l.scrollratio.y) : (o = i ? l.doScrollLeftBy : l.doScrollBy, r = i ? l.scroll.x : l.scroll.y, s = i ? e.pageX - l.railh.offset().left : e.pageY - l.rail.offset().top, n = i ? l.view.w : l.view.h, o(r >= s ? n : -n)))
                }, l.hasanimationframe = h, l.hascancelanimationframe = p, l.hasanimationframe ? l.hascancelanimationframe || (p = function() {
                    l.cancelAnimationFrame = !0
                }) : (h = function(e) {
                    return setTimeout(e, 15 - Math.floor(+new Date / 1e3) % 16)
                }, p = clearInterval), this.init = function() {
                    if (l.saved.css = [], u.isie7mobile) return !0;
                    if (u.isoperamini) return !0;
                    if (u.hasmstouch && l.css(l.ispage ? s("html") : l.win, {
                        "-ms-touch-action": "none"
                    }), l.zindex = "auto", l.ispage || "auto" != l.opt.zindex ? l.zindex = l.opt.zindex : l.zindex = function() {
                        var e = l.win;
                        if ("zIndex" in e) return e.zIndex();
                        for (; e.length > 0;) {
                            if (9 == e[0].nodeType) return !1;
                            var t = e.css("zIndex");
                            if (!isNaN(t) && 0 != t) return parseInt(t);
                            e = e.parent()
                        }
                        return !1
                    }() || "auto", l.ispage || "auto" == l.zindex || l.zindex > r && (r = l.zindex), l.isie && 0 == l.zindex && "auto" == l.opt.zindex && (l.zindex = "auto"), !l.ispage || !u.cantouch && !u.isieold && !u.isie9mobile) {
                        var e = l.docscroll;
                        l.ispage && (e = l.haswrapper ? l.win : l.doc), u.isie9mobile || l.css(e, {
                            "overflow-y": "hidden"
                        }), l.ispage && u.isie7 && ("BODY" == l.doc[0].nodeName ? l.css(s("html"), {
                            "overflow-y": "hidden"
                        }) : "HTML" == l.doc[0].nodeName && l.css(s("body"), {
                            "overflow-y": "hidden"
                        })), !u.isios || l.ispage || l.haswrapper || l.css(s("body"), {
                            "-webkit-overflow-scrolling": "touch"
                        }), (f = s(document.createElement("div"))).css({
                            position: "relative",
                            top: 0,
                            float: "right",
                            width: l.opt.cursorwidth,
                            height: "0px",
                            "background-color": l.opt.cursorcolor,
                            border: l.opt.cursorborder,
                            "background-clip": "padding-box",
                            "-webkit-border-radius": l.opt.cursorborderradius,
                            "-moz-border-radius": l.opt.cursorborderradius,
                            "border-radius": l.opt.cursorborderradius
                        }), f.hborder = parseFloat(f.outerHeight() - f.innerHeight()), l.cursor = f;
                        var n = s(document.createElement("div"));
                        n.attr("id", l.id), n.addClass("nicescroll-rails");
                        var a, c, h = ["left", "right"];
                        for (var p in h) c = h[p], (a = l.opt.railpadding[c]) ? n.css("padding-" + c, a + "px") : l.opt.railpadding[c] = 0;
                        n.append(f), n.width = Math.max(parseFloat(l.opt.cursorwidth), f.outerWidth()) + l.opt.railpadding.left + l.opt.railpadding.right, n.css({
                            width: n.width + "px",
                            zIndex: l.zindex,
                            background: l.opt.background,
                            cursor: "default"
                        }), n.visibility = !0, n.scrollable = !0, n.align = "left" == l.opt.railalign ? 0 : 1, l.rail = n, l.rail.drag = !1;
                        var m = !1;
                        if (!l.opt.boxzoom || l.ispage || u.isieold || (m = document.createElement("div"), l.bind(m, "click", l.doZoom), l.zoom = s(m), l.zoom.css({
                            cursor: "pointer",
                            "z-index": l.zindex,
                            backgroundImage: "url(" + d + "zoomico.png)",
                            height: 18,
                            width: 18,
                            backgroundPosition: "0px 0px"
                        }), l.opt.dblclickzoom && l.bind(l.win, "dblclick", l.doZoom), u.cantouch && l.opt.gesturezoom && (l.ongesturezoom = function(e) {
                            return e.scale > 1.5 && l.doZoomIn(e), e.scale < .8 && l.doZoomOut(e), l.cancelEvent(e)
                        }, l.bind(l.win, "gestureend", l.ongesturezoom))), l.railh = !1, l.opt.horizrailenabled) {
                            var f;
                            l.css(e, {
                                "overflow-x": "hidden"
                            }), (f = s(document.createElement("div"))).css({
                                position: "relative",
                                top: 0,
                                height: l.opt.cursorwidth,
                                width: "0px",
                                "background-color": l.opt.cursorcolor,
                                border: l.opt.cursorborder,
                                "background-clip": "padding-box",
                                "-webkit-border-radius": l.opt.cursorborderradius,
                                "-moz-border-radius": l.opt.cursorborderradius,
                                "border-radius": l.opt.cursorborderradius
                            }), f.wborder = parseFloat(f.outerWidth() - f.innerWidth()), l.cursorh = f;
                            var g = s(document.createElement("div"));
                            g.attr("id", l.id + "-hr"), g.addClass("nicescroll-rails"), g.height = Math.max(parseFloat(l.opt.cursorwidth), f.outerHeight()), g.css({
                                height: g.height + "px",
                                zIndex: l.zindex,
                                background: l.opt.background
                            }), g.append(f), g.visibility = !0, g.scrollable = !0, g.align = "top" == l.opt.railvalign ? 0 : 1, l.railh = g, l.railh.drag = !1
                        }
                        if (l.ispage) n.css({
                            position: "fixed",
                            top: "0px",
                            height: "100%"
                        }), n.align ? n.css({
                            right: "0px"
                        }) : n.css({
                            left: "0px"
                        }), l.body.append(n), l.railh && (g.css({
                            position: "fixed",
                            left: "0px",
                            width: "100%"
                        }), g.align ? g.css({
                            bottom: "0px"
                        }) : g.css({
                            top: "0px"
                        }), l.body.append(g));
                        else {
                            if (l.ishwscroll) {
                                "static" == l.win.css("position") && l.css(l.win, {
                                    position: "relative"
                                });
                                var w = "HTML" == l.win[0].nodeName ? l.body : l.win;
                                l.zoom && (l.zoom.css({
                                    position: "absolute",
                                    top: 1,
                                    right: 0,
                                    "margin-right": n.width + 4
                                }), w.append(l.zoom)), n.css({
                                    position: "absolute",
                                    top: 0
                                }), n.align ? n.css({
                                    right: 0
                                }) : n.css({
                                    left: 0
                                }), w.append(n), g && (g.css({
                                    position: "absolute",
                                    left: 0,
                                    bottom: 0
                                }), g.align ? g.css({
                                    bottom: 0
                                }) : g.css({
                                    top: 0
                                }), w.append(g))
                            } else {
                                l.isfixed = "fixed" == l.win.css("position");
                                var b = l.isfixed ? "fixed" : "absolute";
                                l.isfixed || (l.viewport = l.getViewport(l.win[0])), l.viewport && (l.body = l.viewport, 0 == /relative|absolute/.test(l.viewport.css("position")) && l.css(l.viewport, {
                                    position: "relative"
                                })), n.css({
                                    position: b
                                }), l.zoom && l.zoom.css({
                                    position: b
                                }), l.updateScrollBar(), l.body.append(n), l.zoom && l.body.append(l.zoom), l.railh && (g.css({
                                    position: b
                                }), l.body.append(g))
                            }
                            u.isios && l.css(l.win, {
                                "-webkit-tap-highlight-color": "rgba(0,0,0,0)",
                                "-webkit-touch-callout": "none"
                            }), u.isie && l.opt.disableoutline && l.win.attr("hideFocus", "true"), u.iswebkit && l.opt.disableoutline && l.win.css({
                                outline: "none"
                            })
                        }
                        if (!1 === l.opt.autohidemode ? (l.autohidedom = !1, l.rail.css({
                            opacity: l.opt.cursoropacitymax
                        }), l.railh && l.railh.css({
                            opacity: l.opt.cursoropacitymax
                        })) : !0 === l.opt.autohidemode ? (l.autohidedom = s().add(l.rail), u.isie8 && (l.autohidedom = l.autohidedom.add(l.cursor)), l.railh && (l.autohidedom = l.autohidedom.add(l.railh)), l.railh && u.isie8 && (l.autohidedom = l.autohidedom.add(l.cursorh))) : "scroll" == l.opt.autohidemode ? (l.autohidedom = s().add(l.rail), l.railh && (l.autohidedom = l.autohidedom.add(l.railh))) : "cursor" == l.opt.autohidemode ? (l.autohidedom = s().add(l.cursor), l.railh && (l.autohidedom = l.autohidedom.add(l.cursorh))) : "hidden" == l.opt.autohidemode && (l.autohidedom = !1, l.hide(), l.locked = !1), u.isie9mobile) {
                            l.scrollmom = new y(l), l.onmangotouch = function(e) {
                                var t = l.getScrollTop(),
                                    i = l.getScrollLeft();
                                if (t == l.scrollmom.lastscrolly && i == l.scrollmom.lastscrollx) return !0;
                                var o = t - l.mangotouch.sy,
                                    n = i - l.mangotouch.sx;
                                if (0 != Math.round(Math.sqrt(Math.pow(n, 2) + Math.pow(o, 2)))) {
                                    var r = o < 0 ? -1 : 1,
                                        s = n < 0 ? -1 : 1,
                                        a = +new Date;
                                    if (l.mangotouch.lazy && clearTimeout(l.mangotouch.lazy), a - l.mangotouch.tm > 80 || l.mangotouch.dry != r || l.mangotouch.drx != s) l.scrollmom.stop(), l.scrollmom.reset(i, t), l.mangotouch.sy = t, l.mangotouch.ly = t, l.mangotouch.sx = i, l.mangotouch.lx = i, l.mangotouch.dry = r, l.mangotouch.drx = s, l.mangotouch.tm = a;
                                    else {
                                        l.scrollmom.stop(), l.scrollmom.update(l.mangotouch.sx - n, l.mangotouch.sy - o);
                                        l.mangotouch.tm;
                                        l.mangotouch.tm = a;
                                        var c = Math.max(Math.abs(l.mangotouch.ly - t), Math.abs(l.mangotouch.lx - i));
                                        l.mangotouch.ly = t, l.mangotouch.lx = i, c > 2 && (l.mangotouch.lazy = setTimeout(function() {
                                            l.mangotouch.lazy = !1, l.mangotouch.dry = 0, l.mangotouch.drx = 0, l.mangotouch.tm = 0, l.scrollmom.doMomentum(30)
                                        }, 100))
                                    }
                                }
                            };
                            var x = l.getScrollTop(),
                                S = l.getScrollLeft();
                            l.mangotouch = {
                                sy: x,
                                ly: x,
                                dry: 0,
                                sx: S,
                                lx: S,
                                drx: 0,
                                lazy: !1,
                                tm: 0
                            }, l.bind(l.docscroll, "scroll", l.onmangotouch)
                        } else {
                            if (u.cantouch || l.istouchcapable || l.opt.touchbehavior || u.hasmstouch) {
                                l.scrollmom = new y(l), l.ontouchstart = function(e) {
                                    if (e.pointerType && 2 != e.pointerType) return !1;
                                    if (!l.locked) {
                                        if (u.hasmstouch)
                                            for (var t = !!e.target && e.target; t;) {
                                                var i = s(t).getNiceScroll();
                                                if (i.length > 0 && i[0].me == l.me) break;
                                                if (i.length > 0) return !1;
                                                if ("DIV" == t.nodeName && t.id == l.id) break;
                                                t = !!t.parentNode && t.parentNode
                                            }
                                        if (l.cancelScroll(), t = l.getTarget(e))
                                            if (/INPUT/i.test(t.nodeName) && /range/i.test(t.type)) return l.stopPropagation(e);
                                        if (!("clientX" in e) && "changedTouches" in e && (e.clientX = e.changedTouches[0].clientX, e.clientY = e.changedTouches[0].clientY), l.forcescreen) {
                                            var o = e;
                                            (e = {
                                                original: e.original ? e.original : e
                                            }).clientX = o.screenX, e.clientY = o.screenY
                                        }
                                        if (l.rail.drag = {
                                            x: e.clientX,
                                            y: e.clientY,
                                            sx: l.scroll.x,
                                            sy: l.scroll.y,
                                            st: l.getScrollTop(),
                                            sl: l.getScrollLeft(),
                                            pt: 2,
                                            dl: !1
                                        }, l.ispage || !l.opt.directionlockdeadzone) l.rail.drag.dl = "f";
                                        else {
                                            var n = {
                                                    w: s(window).width(),
                                                    h: s(window).height()
                                                },
                                                r = {
                                                    w: Math.max(document.body.scrollWidth, document.documentElement.scrollWidth),
                                                    h: Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
                                                },
                                                a = Math.max(0, r.h - n.h),
                                                c = Math.max(0, r.w - n.w);
                                            !l.rail.scrollable && l.railh.scrollable ? l.rail.drag.ck = a > 0 && "v" : l.rail.scrollable && !l.railh.scrollable ? l.rail.drag.ck = c > 0 && "h" : l.rail.drag.ck = !1, l.rail.drag.ck || (l.rail.drag.dl = "f")
                                        }
                                        if (l.opt.touchbehavior && l.isiframe && u.isie) {
                                            var d = l.win.position();
                                            l.rail.drag.x += d.left, l.rail.drag.y += d.top
                                        }
                                        if (l.hasmoving = !1, l.lastmouseup = !1, l.scrollmom.reset(e.clientX, e.clientY), !u.cantouch && !this.istouchcapable && !u.hasmstouch) {
                                            if (!(!!t && /INPUT|SELECT|TEXTAREA/i.test(t.nodeName))) return !l.ispage && u.hasmousecapture && t.setCapture(), l.opt.touchbehavior ? l.cancelEvent(e) : l.stopPropagation(e);
                                            /SUBMIT|CANCEL|BUTTON/i.test(s(t).attr("type")) && (pc = {
                                                tg: t,
                                                click: !1
                                            }, l.preventclick = pc)
                                        }
                                    }
                                }, l.ontouchend = function(e) {
                                    return (!e.pointerType || 2 == e.pointerType) && (l.rail.drag && 2 == l.rail.drag.pt && (l.scrollmom.doMomentum(), l.rail.drag = !1, l.hasmoving && (l.hasmoving = !1, l.lastmouseup = !0, l.hideCursor(), u.hasmousecapture && document.releaseCapture(), !u.cantouch)) ? l.cancelEvent(e) : void 0)
                                };
                                var T = l.opt.touchbehavior && l.isiframe && !u.hasmousecapture;
                                l.ontouchmove = function(e, t) {
                                    if (e.pointerType && 2 != e.pointerType) return !1;
                                    if (l.rail.drag && 2 == l.rail.drag.pt) {
                                        if (u.cantouch && void 0 === e.original) return !0;
                                        if (l.hasmoving = !0, l.preventclick && !l.preventclick.click && (l.preventclick.click = l.preventclick.tg.onclick || !1, l.preventclick.tg.onclick = l.onpreventclick), "changedTouches" in (e = s.extend({
                                            original: e
                                        }, e)) && (e.clientX = e.changedTouches[0].clientX, e.clientY = e.changedTouches[0].clientY), l.forcescreen) {
                                            var i = e;
                                            (e = {
                                                original: e.original ? e.original : e
                                            }).clientX = i.screenX, e.clientY = i.screenY
                                        }
                                        var o = ofy = 0;
                                        if (T && !t) {
                                            var n = l.win.position();
                                            o = -n.left, ofy = -n.top
                                        }
                                        var r = e.clientY + ofy,
                                            a = r - l.rail.drag.y,
                                            c = e.clientX + o,
                                            d = c - l.rail.drag.x,
                                            h = l.rail.drag.st - a;
                                        if (l.ishwscroll && l.opt.bouncescroll ? h < 0 ? h = Math.round(h / 2) : h > l.page.maxh && (h = l.page.maxh + Math.round((h - l.page.maxh) / 2)) : (h < 0 && (h = 0, r = 0), h > l.page.maxh && (h = l.page.maxh, r = 0)), l.railh && l.railh.scrollable) {
                                            var p = l.rail.drag.sl - d;
                                            l.ishwscroll && l.opt.bouncescroll ? p < 0 ? p = Math.round(p / 2) : p > l.page.maxw && (p = l.page.maxw + Math.round((p - l.page.maxw) / 2)) : (p < 0 && (p = 0, c = 0), p > l.page.maxw && (p = l.page.maxw, c = 0))
                                        }
                                        var m = !1;
                                        if (l.rail.drag.dl) m = !0, "v" == l.rail.drag.dl ? p = l.rail.drag.sl : "h" == l.rail.drag.dl && (h = l.rail.drag.st);
                                        else {
                                            var f = Math.abs(a),
                                                v = Math.abs(d),
                                                g = l.opt.directionlockdeadzone;
                                            if ("v" == l.rail.drag.ck) {
                                                if (f > g && v <= .3 * f) return l.rail.drag = !1, !0;
                                                v > g && (l.rail.drag.dl = "f", s("body").scrollTop(s("body").scrollTop()))
                                            } else if ("h" == l.rail.drag.ck) {
                                                if (v > g && f <= .3 * v) return l.rail.drag = !1, !0;
                                                f > g && (l.rail.drag.dl = "f", s("body").scrollLeft(s("body").scrollLeft()))
                                            }
                                        }
                                        if (l.synched("touchmove", function() {
                                            l.rail.drag && 2 == l.rail.drag.pt && (l.prepareTransition && l.prepareTransition(0), l.rail.scrollable && l.setScrollTop(h), l.scrollmom.update(c, r), l.railh && l.railh.scrollable ? (l.setScrollLeft(p), l.showCursor(h, p)) : l.showCursor(h), u.isie10 && document.selection.clear())
                                        }), u.ischrome && l.istouchcapable && (m = !1), m) return l.cancelEvent(e)
                                    }
                                }
                            }
                            if (l.onmousedown = function(e, t) {
                                if (!l.rail.drag || 1 == l.rail.drag.pt) {
                                    if (l.locked) return l.cancelEvent(e);
                                    l.cancelScroll(), l.rail.drag = {
                                        x: e.clientX,
                                        y: e.clientY,
                                        sx: l.scroll.x,
                                        sy: l.scroll.y,
                                        pt: 1,
                                        hr: !!t
                                    };
                                    var i = l.getTarget(e);
                                    return !l.ispage && u.hasmousecapture && i.setCapture(), l.isiframe && !u.hasmousecapture && (l.saved.csspointerevents = l.doc.css("pointer-events"), l.css(l.doc, {
                                        "pointer-events": "none"
                                    })), l.cancelEvent(e)
                                }
                            }, l.onmouseup = function(e) {
                                if (l.rail.drag) {
                                    if (u.hasmousecapture && document.releaseCapture(), l.isiframe && !u.hasmousecapture && l.doc.css("pointer-events", l.saved.csspointerevents), 1 != l.rail.drag.pt) return;
                                    return l.rail.drag = !1, l.cancelEvent(e)
                                }
                            }, l.onmousemove = function(e) {
                                if (l.rail.drag) {
                                    if (1 != l.rail.drag.pt) return;
                                    if (u.ischrome && 0 == e.which) return l.onmouseup(e);
                                    if (l.cursorfreezed = !0, l.rail.drag.hr) {
                                        l.scroll.x = l.rail.drag.sx + (e.clientX - l.rail.drag.x), l.scroll.x < 0 && (l.scroll.x = 0);
                                        var t = l.scrollvaluemaxw;
                                        l.scroll.x > t && (l.scroll.x = t)
                                    } else {
                                        l.scroll.y = l.rail.drag.sy + (e.clientY - l.rail.drag.y), l.scroll.y < 0 && (l.scroll.y = 0);
                                        var i = l.scrollvaluemax;
                                        l.scroll.y > i && (l.scroll.y = i)
                                    }
                                    return l.synched("mousemove", function() {
                                        l.rail.drag && 1 == l.rail.drag.pt && (l.showCursor(), l.rail.drag.hr ? l.doScrollLeft(Math.round(l.scroll.x * l.scrollratio.x), l.opt.cursordragspeed) : l.doScrollTop(Math.round(l.scroll.y * l.scrollratio.y), l.opt.cursordragspeed))
                                    }), l.cancelEvent(e)
                                }
                            }, u.cantouch || l.opt.touchbehavior) l.onpreventclick = function(e) {
                                if (l.preventclick) return l.preventclick.tg.onclick = l.preventclick.click, l.preventclick = !1, l.cancelEvent(e)
                            }, l.bind(l.win, "mousedown", l.ontouchstart), l.onclick = !u.isios && function(e) {
                                return !l.lastmouseup || (l.lastmouseup = !1, l.cancelEvent(e))
                            }, l.opt.grabcursorenabled && u.cursorgrabvalue && (l.css(l.ispage ? l.doc : l.win, {
                                cursor: u.cursorgrabvalue
                            }), l.css(l.rail, {
                                cursor: u.cursorgrabvalue
                            }));
                            else {
                                "getSelection" in document ? l.hasTextSelected = function() {
                                    return document.getSelection().rangeCount > 0
                                } : "selection" in document ? l.hasTextSelected = function() {
                                    return "None" != document.selection.type
                                } : l.hasTextSelected = function() {
                                    return !1
                                }, l.onselectionstart = function(e) {
                                    l.ispage || (l.selectiondrag = l.win.offset())
                                }, l.onselectionend = function(e) {
                                    l.selectiondrag = !1
                                }, l.onselectiondrag = function(e) {
                                    l.selectiondrag && l.hasTextSelected() && l.debounced("selectionscroll", function() {
                                        ! function e(t) {
                                            if (l.selectiondrag) {
                                                if (t) {
                                                    var i = l.win.outerHeight(),
                                                        o = t.pageY - l.selectiondrag.top;
                                                    o > 0 && o < i && (o = 0), o >= i && (o -= i), l.selectiondrag.df = o
                                                }
                                                if (0 != l.selectiondrag.df) {
                                                    var n = 2 * -Math.floor(l.selectiondrag.df / 6);
                                                    l.doScrollBy(n), l.debounced("doselectionscroll", function() {
                                                        e()
                                                    }, 50)
                                                }
                                            }
                                        }(e)
                                    }, 250)
                                }
                            }
                            u.hasmstouch && (l.css(l.rail, {
                                "-ms-touch-action": "none"
                            }), l.css(l.cursor, {
                                "-ms-touch-action": "none"
                            }), l.bind(l.win, "MSPointerDown", l.ontouchstart), l.bind(document, "MSPointerUp", l.ontouchend), l.bind(document, "MSPointerMove", l.ontouchmove), l.bind(l.cursor, "MSGestureHold", function(e) {
                                e.preventDefault()
                            }), l.bind(l.cursor, "contextmenu", function(e) {
                                e.preventDefault()
                            })), this.istouchcapable && (l.bind(l.win, "touchstart", l.ontouchstart), l.bind(document, "touchend", l.ontouchend), l.bind(document, "touchcancel", l.ontouchend), l.bind(document, "touchmove", l.ontouchmove)), l.bind(l.cursor, "mousedown", l.onmousedown), l.bind(l.cursor, "mouseup", l.onmouseup), l.railh && (l.bind(l.cursorh, "mousedown", function(e) {
                                l.onmousedown(e, !0)
                            }), l.bind(l.cursorh, "mouseup", function(e) {
                                if (!l.rail.drag || 2 != l.rail.drag.pt) return l.rail.drag = !1, l.hasmoving = !1, l.hideCursor(), u.hasmousecapture && document.releaseCapture(), l.cancelEvent(e)
                            })), (l.opt.cursordragontouch || !u.cantouch && !l.opt.touchbehavior) && (l.rail.css({
                                cursor: "default"
                            }), l.railh && l.railh.css({
                                cursor: "default"
                            }), l.jqbind(l.rail, "mouseenter", function() {
                                l.canshowonmouseevent && l.showCursor(), l.rail.active = !0
                            }), l.jqbind(l.rail, "mouseleave", function() {
                                l.rail.active = !1, l.rail.drag || l.hideCursor()
                            }), l.opt.sensitiverail && (l.bind(l.rail, "click", function(e) {
                                l.doRailClick(e, !1, !1)
                            }), l.bind(l.rail, "dblclick", function(e) {
                                l.doRailClick(e, !0, !1)
                            }), l.bind(l.cursor, "click", function(e) {
                                l.cancelEvent(e)
                            }), l.bind(l.cursor, "dblclick", function(e) {
                                l.cancelEvent(e)
                            })), l.railh && (l.jqbind(l.railh, "mouseenter", function() {
                                l.canshowonmouseevent && l.showCursor(), l.rail.active = !0
                            }), l.jqbind(l.railh, "mouseleave", function() {
                                l.rail.active = !1, l.rail.drag || l.hideCursor()
                            }), l.opt.sensitiverail && (l.bind(l.railh, "click", function(e) {
                                l.doRailClick(e, !1, !0)
                            }), l.bind(l.railh, "dblclick", function(e) {
                                l.doRailClick(e, !0, !0)
                            }), l.bind(l.cursorh, "click", function(e) {
                                l.cancelEvent(e)
                            }), l.bind(l.cursorh, "dblclick", function(e) {
                                l.cancelEvent(e)
                            })))), u.cantouch || l.opt.touchbehavior ? (l.bind(u.hasmousecapture ? l.win : document, "mouseup", l.ontouchend), l.bind(document, "mousemove", l.ontouchmove), l.onclick && l.bind(document, "click", l.onclick), l.opt.cursordragontouch && (l.bind(l.cursor, "mousedown", l.onmousedown), l.bind(l.cursor, "mousemove", l.onmousemove), l.cursorh && l.bind(l.cursorh, "mousedown", l.onmousedown), l.cursorh && l.bind(l.cursorh, "mousemove", l.onmousemove))) : (l.bind(u.hasmousecapture ? l.win : document, "mouseup", l.onmouseup), l.bind(document, "mousemove", l.onmousemove), l.onclick && l.bind(document, "click", l.onclick), !l.ispage && l.opt.enablescrollonselection && (l.bind(l.win[0], "mousedown", l.onselectionstart), l.bind(document, "mouseup", l.onselectionend), l.bind(l.cursor, "mouseup", l.onselectionend), l.cursorh && l.bind(l.cursorh, "mouseup", l.onselectionend), l.bind(document, "mousemove", l.onselectiondrag)), l.zoom && (l.jqbind(l.zoom, "mouseenter", function() {
                                l.canshowonmouseevent && l.showCursor(), l.rail.active = !0
                            }), l.jqbind(l.zoom, "mouseleave", function() {
                                l.rail.active = !1, l.rail.drag || l.hideCursor()
                            }))), l.opt.enablemousewheel && (l.isiframe || l.bind(u.isie && l.ispage ? document : l.win, "mousewheel", l.onmousewheel), l.bind(l.rail, "mousewheel", l.onmousewheel), l.railh && l.bind(l.railh, "mousewheel", l.onmousewheelhr)), l.ispage || u.cantouch || /HTML|BODY/.test(l.win[0].nodeName) || (l.win.attr("tabindex") || l.win.attr({
                                tabindex: o++
                            }), l.jqbind(l.win, "focus", function(e) {
                                t = l.getTarget(e).id || !0, l.hasfocus = !0, l.canshowonmouseevent && l.noticeCursor()
                            }), l.jqbind(l.win, "blur", function(e) {
                                t = !1, l.hasfocus = !1
                            }), l.jqbind(l.win, "mouseenter", function(e) {
                                i = l.getTarget(e).id || !0, l.hasmousefocus = !0, l.canshowonmouseevent && l.noticeCursor()
                            }), l.jqbind(l.win, "mouseleave", function() {
                                i = !1, l.hasmousefocus = !1
                            }))
                        }
                        if (l.onkeypress = function(e) {
                            if (l.locked && 0 == l.page.maxh) return !0;
                            e = e || window.e;
                            var o = l.getTarget(e);
                            if (o && /INPUT|TEXTAREA|SELECT|OPTION/.test(o.nodeName) && (!(o.getAttribute("type") || o.type || !1) || !/submit|button|cancel/i.tp)) return !0;
                            if (l.hasfocus || l.hasmousefocus && !t || l.ispage && !t && !i) {
                                var n = e.keyCode;
                                if (l.locked && 27 != n) return l.cancelEvent(e);
                                var r = e.ctrlKey || !1,
                                    s = e.shiftKey || !1,
                                    a = !1;
                                switch (n) {
                                    case 38:
                                    case 63233:
                                        l.doScrollBy(72), a = !0;
                                        break;
                                    case 40:
                                    case 63235:
                                        l.doScrollBy(-72), a = !0;
                                        break;
                                    case 37:
                                    case 63232:
                                        l.railh && (r ? l.doScrollLeft(0) : l.doScrollLeftBy(72), a = !0);
                                        break;
                                    case 39:
                                    case 63234:
                                        l.railh && (r ? l.doScrollLeft(l.page.maxw) : l.doScrollLeftBy(-72), a = !0);
                                        break;
                                    case 33:
                                    case 63276:
                                        l.doScrollBy(l.view.h), a = !0;
                                        break;
                                    case 34:
                                    case 63277:
                                        l.doScrollBy(-l.view.h), a = !0;
                                        break;
                                    case 36:
                                    case 63273:
                                        l.railh && r ? l.doScrollPos(0, 0) : l.doScrollTo(0), a = !0;
                                        break;
                                    case 35:
                                    case 63275:
                                        l.railh && r ? l.doScrollPos(l.page.maxw, l.page.maxh) : l.doScrollTo(l.page.maxh), a = !0;
                                        break;
                                    case 32:
                                        l.opt.spacebarenabled && (s ? l.doScrollBy(l.view.h) : l.doScrollBy(-l.view.h), a = !0);
                                        break;
                                    case 27:
                                        l.zoomactive && (l.doZoom(), a = !0)
                                }
                                if (a) return l.cancelEvent(e)
                            }
                        }, l.opt.enablekeyboard && l.bind(document, u.isopera && !u.isopera12 ? "keypress" : "keydown", l.onkeypress), l.bind(window, "resize", l.lazyResize), l.bind(window, "orientationchange", l.lazyResize), l.bind(window, "load", l.lazyResize), u.ischrome && !l.ispage && !l.haswrapper) {
                            var k = l.win.attr("style"),
                                z = parseFloat(l.win.css("width")) + 1;
                            l.win.css("width", z), l.synched("chromefix", function() {
                                l.win.attr("style", k)
                            })
                        }
                        l.onAttributeChange = function(e) {
                            l.lazyResize(250)
                        }, l.ispage || l.haswrapper || (!1 !== v ? (l.observer = new v(function(e) {
                            e.forEach(l.onAttributeChange)
                        }), l.observer.observe(l.win[0], {
                            childList: !0,
                            characterData: !1,
                            attributes: !0,
                            subtree: !1
                        }), l.observerremover = new v(function(e) {
                            e.forEach(function(e) {
                                if (e.removedNodes.length > 0)
                                    for (var t in e.removedNodes)
                                        if (e.removedNodes[t] == l.win[0]) return l.remove()
                            })
                        }), l.observerremover.observe(l.win[0].parentNode, {
                            childList: !0,
                            characterData: !1,
                            attributes: !1,
                            subtree: !1
                        })) : (l.bind(l.win, u.isie && !u.isie9 ? "propertychange" : "DOMAttrModified", l.onAttributeChange), u.isie9 && l.win[0].attachEvent("onpropertychange", l.onAttributeChange), l.bind(l.win, "DOMNodeRemoved", function(e) {
                            e.target == l.win[0] && l.remove()
                        }))), !l.ispage && l.opt.boxzoom && l.bind(window, "resize", l.resizeZoom), l.istextarea && l.bind(l.win, "mouseup", l.lazyResize), l.checkrtlmode = !0, l.lazyResize(30)
                    }
                    if ("IFRAME" == this.doc[0].nodeName) {
                        function C(e) {
                            l.iframexd = !1;
                            try {
                                var t = "contentDocument" in this ? this.contentDocument : this.contentWindow.document;
                                t.domain
                            } catch (e) {
                                l.iframexd = !0, t = !1
                            }
                            if (l.iframexd) return "console" in window && console.log("NiceScroll error: policy restriced iframe"), !0;
                            if (l.forcescreen = !0, l.isiframe && (l.iframe = {
                                doc: s(t),
                                html: l.doc.contents().find("html")[0],
                                body: l.doc.contents().find("body")[0]
                            }, l.getContentSize = function() {
                                return {
                                    w: Math.max(l.iframe.html.scrollWidth, l.iframe.body.scrollWidth),
                                    h: Math.max(l.iframe.html.scrollHeight, l.iframe.body.scrollHeight)
                                }
                            }, l.docscroll = s(l.iframe.body)), !u.isios && l.opt.iframeautoresize && !l.isiframe) {
                                l.win.scrollTop(0), l.doc.height("");
                                var i = Math.max(t.getElementsByTagName("html")[0].scrollHeight, t.body.scrollHeight);
                                l.doc.height(i)
                            }
                            l.lazyResize(30), u.isie7 && l.css(s(l.iframe.html), {
                                "overflow-y": "hidden"
                            }), l.css(s(l.iframe.body), {
                                "overflow-y": "hidden"
                            }), u.isios && l.haswrapper && (l.css(s(t.body), {
                                "-webkit-transform": "translate3d(0,0,0)"
                            }), console.log(1)), "contentWindow" in this ? l.bind(this.contentWindow, "scroll", l.onscroll) : l.bind(t, "scroll", l.onscroll), l.opt.enablemousewheel && l.bind(t, "mousewheel", l.onmousewheel), l.opt.enablekeyboard && l.bind(t, u.isopera ? "keypress" : "keydown", l.onkeypress), (u.cantouch || l.opt.touchbehavior) && (l.bind(t, "mousedown", l.ontouchstart), l.bind(t, "mousemove", function(e) {
                                l.ontouchmove(e, !0)
                            }), l.opt.grabcursorenabled && u.cursorgrabvalue && l.css(s(t.body), {
                                cursor: u.cursorgrabvalue
                            })), l.bind(t, "mouseup", l.ontouchend), l.zoom && (l.opt.dblclickzoom && l.bind(t, "dblclick", l.doZoom), l.ongesturezoom && l.bind(t, "gestureend", l.ongesturezoom))
                        }
                        this.doc[0].readyState && "complete" == this.doc[0].readyState && setTimeout(function() {
                            C.call(l.doc[0], !1)
                        }, 500), l.bind(this.doc, "load", C)
                    }
                }, this.showCursor = function(e, t) {
                    l.cursortimeout && (clearTimeout(l.cursortimeout), l.cursortimeout = 0), l.rail && (l.autohidedom && (l.autohidedom.stop().css({
                        opacity: l.opt.cursoropacitymax
                    }), l.cursoractive = !0), l.rail.drag && 1 == l.rail.drag.pt || (void 0 !== e && !1 !== e && (l.scroll.y = Math.round(1 * e / l.scrollratio.y)), void 0 !== t && (l.scroll.x = Math.round(1 * t / l.scrollratio.x))), l.cursor.css({
                        height: l.cursorheight,
                        top: l.scroll.y
                    }), l.cursorh && (!l.rail.align && l.rail.visibility ? l.cursorh.css({
                        width: l.cursorwidth,
                        left: l.scroll.x + l.rail.width
                    }) : l.cursorh.css({
                        width: l.cursorwidth,
                        left: l.scroll.x
                    }), l.cursoractive = !0), l.zoom && l.zoom.stop().css({
                        opacity: l.opt.cursoropacitymax
                    }))
                }, this.hideCursor = function(e) {
                    l.cursortimeout || l.rail && l.autohidedom && (l.cursortimeout = setTimeout(function() {
                        l.rail.active && l.showonmouseevent || (l.autohidedom.stop().animate({
                            opacity: l.opt.cursoropacitymin
                        }), l.zoom && l.zoom.stop().animate({
                            opacity: l.opt.cursoropacitymin
                        }), l.cursoractive = !1), l.cursortimeout = 0
                    }, e || l.opt.hidecursordelay))
                }, this.noticeCursor = function(e, t, i) {
                    l.showCursor(t, i), l.rail.active || l.hideCursor(e)
                }, this.getContentSize = l.ispage ? function() {
                    return {
                        w: Math.max(document.body.scrollWidth, document.documentElement.scrollWidth),
                        h: Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
                    }
                } : l.haswrapper ? function() {
                    return {
                        w: l.doc.outerWidth() + parseInt(l.win.css("paddingLeft")) + parseInt(l.win.css("paddingRight")),
                        h: l.doc.outerHeight() + parseInt(l.win.css("paddingTop")) + parseInt(l.win.css("paddingBottom"))
                    }
                } : function() {
                    return {
                        w: l.docscroll[0].scrollWidth,
                        h: l.docscroll[0].scrollHeight
                    }
                }, this.onResize = function(e, t) {
                    if (!l.win) return !1;
                    if (!l.haswrapper && !l.ispage) {
                        if ("none" == l.win.css("display")) return l.visibility && l.hideRail().hideRailHr(), !1;
                        l.hidden || l.visibility || l.showRail().showRailHr()
                    }
                    var i = l.page.maxh,
                        o = l.page.maxw,
                        n = (l.view.h, l.view.w);
                    if (l.view = {
                        w: l.ispage ? l.win.width() : parseInt(l.win[0].clientWidth),
                        h: l.ispage ? l.win.height() : parseInt(l.win[0].clientHeight)
                    }, l.page = t || l.getContentSize(), l.page.maxh = Math.max(0, l.page.h - l.view.h), l.page.maxw = Math.max(0, l.page.w - l.view.w), l.page.maxh == i && l.page.maxw == o && l.view.w == n) {
                        if (l.ispage) return l;
                        var r = l.win.offset();
                        if (l.lastposition) {
                            var s = l.lastposition;
                            if (s.top == r.top && s.left == r.left) return l
                        }
                        l.lastposition = r
                    }
                    return 0 == l.page.maxh ? (l.hideRail(), l.scrollvaluemax = 0, l.scroll.y = 0, l.scrollratio.y = 0, l.cursorheight = 0, l.setScrollTop(0), l.rail.scrollable = !1) : l.rail.scrollable = !0, 0 == l.page.maxw ? (l.hideRailHr(), l.scrollvaluemaxw = 0, l.scroll.x = 0, l.scrollratio.x = 0, l.cursorwidth = 0, l.setScrollLeft(0), l.railh.scrollable = !1) : l.railh.scrollable = !0, l.locked = 0 == l.page.maxh && 0 == l.page.maxw, l.locked ? (l.ispage || l.updateScrollBar(l.view), !1) : (l.hidden || l.visibility ? l.hidden || l.railh.visibility || l.showRailHr() : l.showRail().showRailHr(), l.istextarea && l.win.css("resize") && "none" != l.win.css("resize") && (l.view.h -= 20), l.cursorheight = Math.min(l.view.h, Math.round(l.view.h * (l.view.h / l.page.h))), l.cursorheight = l.opt.cursorfixedheight ? l.opt.cursorfixedheight : Math.max(l.opt.cursorminheight, l.cursorheight), l.cursorwidth = Math.min(l.view.w, Math.round(l.view.w * (l.view.w / l.page.w))), l.cursorwidth = l.opt.cursorfixedheight ? l.opt.cursorfixedheight : Math.max(l.opt.cursorminheight, l.cursorwidth), l.scrollvaluemax = l.view.h - l.cursorheight - l.cursor.hborder, l.railh && (l.railh.width = l.page.maxh > 0 ? l.view.w - l.rail.width : l.view.w, l.scrollvaluemaxw = l.railh.width - l.cursorwidth - l.cursorh.wborder), l.checkrtlmode && l.railh && (l.checkrtlmode = !1, l.opt.rtlmode && 0 == l.scroll.x && l.setScrollLeft(l.page.maxw)), l.ispage || l.updateScrollBar(l.view), l.scrollratio = {
                        x: l.page.maxw / l.scrollvaluemaxw,
                        y: l.page.maxh / l.scrollvaluemax
                    }, l.getScrollTop() > l.page.maxh ? l.doScrollTop(l.page.maxh) : (l.scroll.y = Math.round(l.getScrollTop() * (1 / l.scrollratio.y)), l.scroll.x = Math.round(l.getScrollLeft() * (1 / l.scrollratio.x)), l.cursoractive && l.noticeCursor()), l.scroll.y && 0 == l.getScrollTop() && l.doScrollTo(Math.floor(l.scroll.y * l.scrollratio.y)), l)
                }, this.resize = l.onResize, this.lazyResize = function(e) {
                    return e = isNaN(e) ? 30 : e, l.delayed("resize", l.resize, e), l
                }, this._bind = function(e, t, i, o) {
                    l.events.push({
                        e: e,
                        n: t,
                        f: i,
                        b: o,
                        q: !1
                    }), e.addEventListener ? e.addEventListener(t, i, o || !1) : e.attachEvent ? e.attachEvent("on" + t, i) : e["on" + t] = i
                }, this.jqbind = function(e, t, i) {
                    l.events.push({
                        e: e,
                        n: t,
                        f: i,
                        q: !0
                    }), s(e).bind(t, i)
                }, this.bind = function(e, t, i, o) {
                    var n = "jquery" in e ? e[0] : e;
                    if ("mousewheel" == t)
                        if ("onwheel" in l.win) l._bind(n, "wheel", i, o || !1);
                        else {
                            var r = void 0 !== document.onmousewheel ? "mousewheel" : "DOMMouseScroll";
                            x(n, r, i, o || !1), "DOMMouseScroll" == r && x(n, "MozMousePixelScroll", i, o || !1)
                        }
                    else if (n.addEventListener) {
                        if (u.cantouch && /mouseup|mousedown|mousemove/.test(t)) {
                            var s = "mousedown" == t ? "touchstart" : "mouseup" == t ? "touchend" : "touchmove";
                            l._bind(n, s, function(e) {
                                if (e.touches) e.touches.length < 2 && ((t = e.touches.length ? e.touches[0] : e).original = e, i.call(this, t));
                                else if (e.changedTouches) {
                                    var t;
                                    (t = e.changedTouches[0]).original = e, i.call(this, t)
                                }
                            }, o || !1)
                        }
                        l._bind(n, t, i, o || !1), u.cantouch && "mouseup" == t && l._bind(n, "touchcancel", i, o || !1)
                    } else l._bind(n, t, function(e) {
                        return (e = e || window.event || !1) && e.srcElement && (e.target = e.srcElement), "pageY" in e || (e.pageX = e.clientX + document.documentElement.scrollLeft, e.pageY = e.clientY + document.documentElement.scrollTop), !1 !== i.call(n, e) && !1 !== o || l.cancelEvent(e)
                    })
                }, this._unbind = function(e, t, i, o) {
                    e.removeEventListener ? e.removeEventListener(t, i, o) : e.detachEvent ? e.detachEvent("on" + t, i) : e["on" + t] = !1
                }, this.unbindAll = function() {
                    for (var e = 0; e < l.events.length; e++) {
                        var t = l.events[e];
                        t.q ? t.e.unbind(t.n, t.f) : l._unbind(t.e, t.n, t.f, t.b)
                    }
                }, this.cancelEvent = function(e) {
                    return !!(e = e.original ? e.original : e || (window.event || !1)) && (e.preventDefault && e.preventDefault(), e.stopPropagation && e.stopPropagation(), e.preventManipulation && e.preventManipulation(), e.cancelBubble = !0, e.cancel = !0, e.returnValue = !1, !1)
                }, this.stopPropagation = function(e) {
                    return !!(e = e.original ? e.original : e || (window.event || !1)) && (e.stopPropagation ? e.stopPropagation() : (e.cancelBubble && (e.cancelBubble = !0), !1))
                }, this.showRail = function() {
                    return 0 == l.page.maxh || !l.ispage && "none" == l.win.css("display") || (l.visibility = !0, l.rail.visibility = !0, l.rail.css("display", "block")), l
                }, this.showRailHr = function() {
                    return l.railh ? (0 == l.page.maxw || !l.ispage && "none" == l.win.css("display") || (l.railh.visibility = !0, l.railh.css("display", "block")), l) : l
                }, this.hideRail = function() {
                    return l.visibility = !1, l.rail.visibility = !1, l.rail.css("display", "none"), l
                }, this.hideRailHr = function() {
                    return l.railh ? (l.railh.visibility = !1, l.railh.css("display", "none"), l) : l
                }, this.show = function() {
                    return l.hidden = !1, l.locked = !1, l.showRail().showRailHr()
                }, this.hide = function() {
                    return l.hidden = !0, l.locked = !0, l.hideRail().hideRailHr()
                }, this.toggle = function() {
                    return l.hidden ? l.show() : l.hide()
                }, this.remove = function() {
                    l.stop(), l.cursortimeout && clearTimeout(l.cursortimeout), l.doZoomOut(), l.unbindAll(), u.isie9 && l.win[0].detachEvent("onpropertychange", l.onAttributeChange), !1 !== l.observer && l.observer.disconnect(), !1 !== l.observerremover && l.observerremover.disconnect(), l.events = null, l.cursor && l.cursor.remove(), l.cursorh && l.cursorh.remove(), l.rail && l.rail.remove(), l.railh && l.railh.remove(), l.zoom && l.zoom.remove();
                    for (var e = 0; e < l.saved.css.length; e++) {
                        var t = l.saved.css[e];
                        t[0].css(t[1], void 0 === t[2] ? "" : t[2])
                    }
                    l.saved = !1, l.me.data("__nicescroll", "");
                    var i = s.nicescroll;
                    for (var o in i.each(function(e) {
                        if (this && this.id === l.id) {
                            delete i[e];
                            for (var t = ++e; t < i.length; t++, e++) i[e] = i[t];
                            i.length--, i.length && delete i[i.length]
                        }
                    }), l) l[o] = null, delete l[o];
                    l = null
                }, this.scrollstart = function(e) {
                    return this.onscrollstart = e, l
                }, this.scrollend = function(e) {
                    return this.onscrollend = e, l
                }, this.scrollcancel = function(e) {
                    return this.onscrollcancel = e, l
                }, this.zoomin = function(e) {
                    return this.onzoomin = e, l
                }, this.zoomout = function(e) {
                    return this.onzoomout = e, l
                }, this.isScrollable = function(e) {
                    var t = e.target ? e.target : e;
                    if ("OPTION" == t.nodeName) return !0;
                    for (; t && 1 == t.nodeType && !/BODY|HTML/.test(t.nodeName);) {
                        var i = s(t),
                            o = i.css("overflowY") || i.css("overflowX") || i.css("overflow") || "";
                        if (/scroll|auto/.test(o)) return t.clientHeight != t.scrollHeight;
                        t = !!t.parentNode && t.parentNode
                    }
                    return !1
                }, this.getViewport = function(e) {
                    for (var t = !(!e || !e.parentNode) && e.parentNode; t && 1 == t.nodeType && !/BODY|HTML/.test(t.nodeName);) {
                        var i = s(t),
                            o = i.css("overflowY") || i.css("overflowX") || i.css("overflow") || "";
                        if (/scroll|auto/.test(o) && t.clientHeight != t.scrollHeight) return i;
                        if (i.getNiceScroll().length > 0) return i;
                        t = !!t.parentNode && t.parentNode
                    }
                    return !1
                }, this.onmousewheel = function(e) {
                    if (l.locked) return l.debounced("checkunlock", l.resize, 250), !0;
                    if (l.rail.drag) return l.cancelEvent(e);
                    if ("auto" == l.opt.oneaxismousemode && 0 != e.deltaX && (l.opt.oneaxismousemode = !1), l.opt.oneaxismousemode && 0 == e.deltaX && !l.rail.scrollable) return !l.railh || !l.railh.scrollable || l.onmousewheelhr(e);
                    var t = +new Date,
                        i = !1;
                    if (l.opt.preservenativescrolling && l.checkarea + 600 < t && (l.nativescrollingarea = l.isScrollable(e), i = !0), l.checkarea = t, l.nativescrollingarea) return !0;
                    var o = S(e, !1, i);
                    return o && (l.checkarea = 0), o
                }, this.onmousewheelhr = function(e) {
                    if (l.locked || !l.railh.scrollable) return !0;
                    if (l.rail.drag) return l.cancelEvent(e);
                    var t = +new Date,
                        i = !1;
                    return l.opt.preservenativescrolling && l.checkarea + 600 < t && (l.nativescrollingarea = l.isScrollable(e), i = !0), l.checkarea = t, !!l.nativescrollingarea || (l.locked ? l.cancelEvent(e) : S(e, !0, i))
                }, this.stop = function() {
                    return l.cancelScroll(), l.scrollmon && l.scrollmon.stop(), l.cursorfreezed = !1, l.scroll.y = Math.round(l.getScrollTop() * (1 / l.scrollratio.y)), l.noticeCursor(), l
                }, this.getTransitionSpeed = function(e) {
                    var t = Math.round(10 * l.opt.scrollspeed),
                        i = Math.min(t, Math.round(e / 20 * l.opt.scrollspeed));
                    return i > 20 ? i : 0
                }, l.opt.smoothscroll ? l.ishwscroll && u.hastransition && l.opt.usetransition ? (this.prepareTransition = function(e, t) {
                    var i = t ? e > 20 ? e : 0 : l.getTransitionSpeed(e),
                        o = i ? u.prefixstyle + "transform " + i + "ms ease-out" : "";
                    return l.lasttransitionstyle && l.lasttransitionstyle == o || (l.lasttransitionstyle = o, l.doc.css(u.transitionstyle, o)), i
                }, this.doScrollLeft = function(e, t) {
                    var i = l.scrollrunning ? l.newscrolly : l.getScrollTop();
                    l.doScrollPos(e, i, t)
                }, this.doScrollTop = function(e, t) {
                    var i = l.scrollrunning ? l.newscrollx : l.getScrollLeft();
                    l.doScrollPos(i, e, t)
                }, this.doScrollPos = function(e, t, i) {
                    var o = l.getScrollTop(),
                        n = l.getScrollLeft();
                    return ((l.newscrolly - o) * (t - o) < 0 || (l.newscrollx - n) * (e - n) < 0) && l.cancelScroll(), 0 == l.opt.bouncescroll && (t < 0 ? t = 0 : t > l.page.maxh && (t = l.page.maxh), e < 0 ? e = 0 : e > l.page.maxw && (e = l.page.maxw)), (!l.scrollrunning || e != l.newscrollx || t != l.newscrolly) && (l.newscrolly = t, l.newscrollx = e, l.newscrollspeed = i || !1, !l.timer && void(l.timer = setTimeout(function() {
                        var i = l.getScrollTop(),
                            o = l.getScrollLeft(),
                            n = {};
                        n.x = e - o, n.y = t - i, n.px = o, n.py = i;
                        var r = Math.round(Math.sqrt(Math.pow(n.x, 2) + Math.pow(n.y, 2))),
                            s = l.newscrollspeed && l.newscrollspeed > 1 ? l.newscrollspeed : l.getTransitionSpeed(r);
                        if (l.newscrollspeed && l.newscrollspeed <= 1 && (s *= l.newscrollspeed), l.prepareTransition(s, !0), l.timerscroll && l.timerscroll.tm && clearInterval(l.timerscroll.tm), s > 0) {
                            if (!l.scrollrunning && l.onscrollstart) {
                                var a = {
                                    type: "scrollstart",
                                    current: {
                                        x: o,
                                        y: i
                                    },
                                    request: {
                                        x: e,
                                        y: t
                                    },
                                    end: {
                                        x: l.newscrollx,
                                        y: l.newscrolly
                                    },
                                    speed: s
                                };
                                l.onscrollstart.call(l, a)
                            }
                            u.transitionend ? l.scrollendtrapped || (l.scrollendtrapped = !0, l.bind(l.doc, u.transitionend, l.onScrollEnd, !1)) : (l.scrollendtrapped && clearTimeout(l.scrollendtrapped), l.scrollendtrapped = setTimeout(l.onScrollEnd, s));
                            var c = i,
                                d = o;
                            l.timerscroll = {
                                bz: new BezierClass(c, l.newscrolly, s, 0, 0, .58, 1),
                                bh: new BezierClass(d, l.newscrollx, s, 0, 0, .58, 1)
                            }, l.cursorfreezed || (l.timerscroll.tm = setInterval(function() {
                                l.showCursor(l.getScrollTop(), l.getScrollLeft())
                            }, 60))
                        }
                        l.synched("doScroll-set", function() {
                            l.timer = 0, l.scrollendtrapped && (l.scrollrunning = !0), l.setScrollTop(l.newscrolly), l.setScrollLeft(l.newscrollx), l.scrollendtrapped || l.onScrollEnd()
                        })
                    }, 50)))
                }, this.cancelScroll = function() {
                    if (!l.scrollendtrapped) return !0;
                    var e = l.getScrollTop(),
                        t = l.getScrollLeft();
                    return l.scrollrunning = !1, u.transitionend || clearTimeout(u.transitionend), l.scrollendtrapped = !1, l._unbind(l.doc, u.transitionend, l.onScrollEnd), l.prepareTransition(0), l.setScrollTop(e), l.railh && l.setScrollLeft(t), l.timerscroll && l.timerscroll.tm && clearInterval(l.timerscroll.tm), l.timerscroll = !1, l.cursorfreezed = !1, l.showCursor(e, t), l
                }, this.onScrollEnd = function() {
                    l.scrollendtrapped && l._unbind(l.doc, u.transitionend, l.onScrollEnd), l.scrollendtrapped = !1, l.prepareTransition(0), l.timerscroll && l.timerscroll.tm && clearInterval(l.timerscroll.tm), l.timerscroll = !1;
                    var e = l.getScrollTop(),
                        t = l.getScrollLeft();
                    if (l.setScrollTop(e), l.railh && l.setScrollLeft(t), l.noticeCursor(!1, e, t), l.cursorfreezed = !1, e < 0 ? e = 0 : e > l.page.maxh && (e = l.page.maxh), t < 0 ? t = 0 : t > l.page.maxw && (t = l.page.maxw), e != l.newscrolly || t != l.newscrollx) return l.doScrollPos(t, e, l.opt.snapbackspeed);
                    if (l.onscrollend && l.scrollrunning) {
                        var i = {
                            type: "scrollend",
                            current: {
                                x: t,
                                y: e
                            },
                            end: {
                                x: l.newscrollx,
                                y: l.newscrolly
                            }
                        };
                        l.onscrollend.call(l, i)
                    }
                    l.scrollrunning = !1
                }) : (this.doScrollLeft = function(e, t) {
                    var i = l.scrollrunning ? l.newscrolly : l.getScrollTop();
                    l.doScrollPos(e, i, t)
                }, this.doScrollTop = function(e, t) {
                    var i = l.scrollrunning ? l.newscrollx : l.getScrollLeft();
                    l.doScrollPos(i, e, t)
                }, this.doScrollPos = function(e, t, i) {
                    t = void 0 === t || !1 === t ? l.getScrollTop(!0) : t;
                    if (l.timer && l.newscrolly == t && l.newscrollx == e) return !0;
                    l.timer && p(l.timer), l.timer = 0;
                    var o = l.getScrollTop(),
                        n = l.getScrollLeft();
                    ((l.newscrolly - o) * (t - o) < 0 || (l.newscrollx - n) * (e - n) < 0) && l.cancelScroll(), l.newscrolly = t, l.newscrollx = e, l.bouncescroll && l.rail.visibility || (l.newscrolly < 0 ? l.newscrolly = 0 : l.newscrolly > l.page.maxh && (l.newscrolly = l.page.maxh)), l.bouncescroll && l.railh.visibility || (l.newscrollx < 0 ? l.newscrollx = 0 : l.newscrollx > l.page.maxw && (l.newscrollx = l.page.maxw)), l.dst = {}, l.dst.x = e - n, l.dst.y = t - o, l.dst.px = n, l.dst.py = o;
                    var r = Math.round(Math.sqrt(Math.pow(l.dst.x, 2) + Math.pow(l.dst.y, 2)));
                    l.dst.ax = l.dst.x / r, l.dst.ay = l.dst.y / r;
                    var s = 0,
                        a = r;
                    0 == l.dst.x ? (s = o, a = t, l.dst.ay = 1, l.dst.py = 0) : 0 == l.dst.y && (s = n, a = e, l.dst.ax = 1, l.dst.px = 0);
                    var c = l.getTransitionSpeed(r);
                    if (i && i <= 1 && (c *= i), l.bzscroll = c > 0 && (l.bzscroll ? l.bzscroll.update(a, c) : new BezierClass(s, a, c, 0, 1, 0, 1)), !l.timer) {
                        (o == l.page.maxh && t >= l.page.maxh || n == l.page.maxw && e >= l.page.maxw) && l.checkContentSize();
                        var d = 1;
                        if (l.cancelAnimationFrame = !1, l.timer = 1, l.onscrollstart && !l.scrollrunning) {
                            var u = {
                                type: "scrollstart",
                                current: {
                                    x: n,
                                    y: o
                                },
                                request: {
                                    x: e,
                                    y: t
                                },
                                end: {
                                    x: l.newscrollx,
                                    y: l.newscrolly
                                },
                                speed: c
                            };
                            l.onscrollstart.call(l, u)
                        }! function e() {
                            if (l.cancelAnimationFrame) return !0;
                            if (l.scrollrunning = !0, d = 1 - d) return l.timer = h(e) || 1;
                            var t = 0,
                                i = sy = l.getScrollTop();
                            l.dst.ay ? (((o = (i = l.bzscroll ? l.dst.py + l.bzscroll.getNow() * l.dst.ay : l.newscrolly) - sy) < 0 && i < l.newscrolly || o > 0 && i > l.newscrolly) && (i = l.newscrolly), l.setScrollTop(i), i == l.newscrolly && (t = 1)) : t = 1;
                            var o, n = sx = l.getScrollLeft();
                            l.dst.ax ? (((o = (n = l.bzscroll ? l.dst.px + l.bzscroll.getNow() * l.dst.ax : l.newscrollx) - sx) < 0 && n < l.newscrollx || o > 0 && n > l.newscrollx) && (n = l.newscrollx), l.setScrollLeft(n), n == l.newscrollx && (t += 1)) : t += 1;
                            if (2 == t) {
                                if (l.timer = 0, l.cursorfreezed = !1, l.bzscroll = !1, l.scrollrunning = !1, i < 0 ? i = 0 : i > l.page.maxh && (i = l.page.maxh), n < 0 ? n = 0 : n > l.page.maxw && (n = l.page.maxw), n != l.newscrollx || i != l.newscrolly) l.doScrollPos(n, i);
                                else if (l.onscrollend) {
                                    var r = {
                                        type: "scrollend",
                                        current: {
                                            x: sx,
                                            y: sy
                                        },
                                        end: {
                                            x: l.newscrollx,
                                            y: l.newscrolly
                                        }
                                    };
                                    l.onscrollend.call(l, r)
                                }
                            } else l.timer = h(e) || 1
                        }(), (o == l.page.maxh && t >= o || n == l.page.maxw && e >= n) && l.checkContentSize(), l.noticeCursor()
                    }
                }, this.cancelScroll = function() {
                    return l.timer && p(l.timer), l.timer = 0, l.bzscroll = !1, l.scrollrunning = !1, l
                }) : (this.doScrollLeft = function(e, t) {
                    var i = l.getScrollTop();
                    l.doScrollPos(e, i, t)
                }, this.doScrollTop = function(e, t) {
                    var i = l.getScrollLeft();
                    l.doScrollPos(i, e, t)
                }, this.doScrollPos = function(e, t, i) {
                    var o = e > l.page.maxw ? l.page.maxw : e;
                    o < 0 && (o = 0);
                    var n = t > l.page.maxh ? l.page.maxh : t;
                    n < 0 && (n = 0), l.synched("scroll", function() {
                        l.setScrollTop(n), l.setScrollLeft(o)
                    })
                }, this.cancelScroll = function() {}), this.doScrollBy = function(e, t) {
                    var i = 0;
                    t ? i = Math.floor((l.scroll.y - e) * l.scrollratio.y) : i = (l.timer ? l.newscrolly : l.getScrollTop(!0)) - e;
                    if (l.bouncescroll) {
                        var o = Math.round(l.view.h / 2);
                        i < -o ? i = -o : i > l.page.maxh + o && (i = l.page.maxh + o)
                    }
                    return l.cursorfreezed = !1, py = l.getScrollTop(!0), i < 0 && py <= 0 ? l.noticeCursor() : i > l.page.maxh && py >= l.page.maxh ? (l.checkContentSize(), l.noticeCursor()) : void l.doScrollTop(i)
                }, this.doScrollLeftBy = function(e, t) {
                    var i = 0;
                    t ? i = Math.floor((l.scroll.x - e) * l.scrollratio.x) : i = (l.timer ? l.newscrollx : l.getScrollLeft(!0)) - e;
                    if (l.bouncescroll) {
                        var o = Math.round(l.view.w / 2);
                        i < -o ? i = -o : i > l.page.maxw + o && (i = l.page.maxw + o)
                    }
                    return l.cursorfreezed = !1, px = l.getScrollLeft(!0), i < 0 && px <= 0 ? l.noticeCursor() : i > l.page.maxw && px >= l.page.maxw ? l.noticeCursor() : void l.doScrollLeft(i)
                }, this.doScrollTo = function(e, t) {
                    var i = t ? Math.round(e * l.scrollratio.y) : e;
                    i < 0 ? i = 0 : i > l.page.maxh && (i = l.page.maxh), l.cursorfreezed = !1, l.doScrollTop(e)
                }, this.checkContentSize = function() {
                    var e = l.getContentSize();
                    e.h == l.page.h && e.w == l.page.w || l.resize(!1, e)
                }, l.onscroll = function(e) {
                    l.rail.drag || l.cursorfreezed || l.synched("scroll", function() {
                        l.scroll.y = Math.round(l.getScrollTop() * (1 / l.scrollratio.y)), l.railh && (l.scroll.x = Math.round(l.getScrollLeft() * (1 / l.scrollratio.x))), l.noticeCursor()
                    })
                }, l.bind(l.docscroll, "scroll", l.onscroll), this.doZoomIn = function(e) {
                    if (!l.zoomactive) {
                        l.zoomactive = !0, l.zoomrestore = {
                            style: {}
                        };
                        var t = ["position", "top", "left", "zIndex", "backgroundColor", "marginTop", "marginBottom", "marginLeft", "marginRight"],
                            i = l.win[0].style;
                        for (var o in t) {
                            var n = t[o];
                            l.zoomrestore.style[n] = void 0 !== i[n] ? i[n] : ""
                        }
                        l.zoomrestore.style.width = l.win.css("width"), l.zoomrestore.style.height = l.win.css("height"), l.zoomrestore.padding = {
                            w: l.win.outerWidth() - l.win.width(),
                            h: l.win.outerHeight() - l.win.height()
                        }, u.isios4 && (l.zoomrestore.scrollTop = s(window).scrollTop(), s(window).scrollTop(0)), l.win.css({
                            position: u.isios4 ? "absolute" : "fixed",
                            top: 0,
                            left: 0,
                            "z-index": r + 100,
                            margin: "0px"
                        });
                        var a = l.win.css("backgroundColor");
                        return ("" == a || /transparent|rgba\(0, 0, 0, 0\)|rgba\(0,0,0,0\)/.test(a)) && l.win.css("backgroundColor", "#fff"), l.rail.css({
                            "z-index": r + 101
                        }), l.zoom.css({
                            "z-index": r + 102
                        }), l.zoom.css("backgroundPosition", "0px -18px"), l.resizeZoom(), l.onzoomin && l.onzoomin.call(l), l.cancelEvent(e)
                    }
                }, this.doZoomOut = function(e) {
                    if (l.zoomactive) return l.zoomactive = !1, l.win.css("margin", ""), l.win.css(l.zoomrestore.style), u.isios4 && s(window).scrollTop(l.zoomrestore.scrollTop), l.rail.css({
                        "z-index": l.zindex
                    }), l.zoom.css({
                        "z-index": l.zindex
                    }), l.zoomrestore = !1, l.zoom.css("backgroundPosition", "0px 0px"), l.onResize(), l.onzoomout && l.onzoomout.call(l), l.cancelEvent(e)
                }, this.doZoom = function(e) {
                    return l.zoomactive ? l.doZoomOut(e) : l.doZoomIn(e)
                }, this.resizeZoom = function() {
                    if (l.zoomactive) {
                        var e = l.getScrollTop();
                        l.win.css({
                            width: s(window).width() - l.zoomrestore.padding.w + "px",
                            height: s(window).height() - l.zoomrestore.padding.h + "px"
                        }), l.onResize(), l.setScrollTop(Math.min(l.page.maxh, e))
                    }
                }, this.init(), s.nicescroll.push(this)
            },
            y = function(e) {
                var t = this;
                this.nc = e, this.lastx = 0, this.lasty = 0, this.speedx = 0, this.speedy = 0, this.lasttime = 0, this.steptime = 0, this.snapx = !1, this.snapy = !1, this.demulx = 0, this.demuly = 0, this.lastscrollx = -1, this.lastscrolly = -1, this.chkx = 0, this.chky = 0, this.timer = 0, this.time = function() {
                    return +new Date
                }, this.reset = function(e, i) {
                    t.stop();
                    var o = t.time();
                    t.steptime = 0, t.lasttime = o, t.speedx = 0, t.speedy = 0, t.lastx = e, t.lasty = i, t.lastscrollx = -1, t.lastscrolly = -1
                }, this.update = function(e, i) {
                    var o = t.time();
                    t.steptime = o - t.lasttime, t.lasttime = o;
                    var n = i - t.lasty,
                        r = e - t.lastx,
                        s = t.nc.getScrollTop() + n,
                        a = t.nc.getScrollLeft() + r;
                    t.snapx = a < 0 || a > t.nc.page.maxw, t.snapy = s < 0 || s > t.nc.page.maxh, t.speedx = r, t.speedy = n, t.lastx = e, t.lasty = i
                }, this.stop = function() {
                    t.nc.unsynched("domomentum2d"), t.timer && clearTimeout(t.timer), t.timer = 0, t.lastscrollx = -1, t.lastscrolly = -1
                }, this.doSnapy = function(e, i) {
                    var o = !1;
                    i < 0 ? (i = 0, o = !0) : i > t.nc.page.maxh && (i = t.nc.page.maxh, o = !0), e < 0 ? (e = 0, o = !0) : e > t.nc.page.maxw && (e = t.nc.page.maxw, o = !0), o && t.nc.doScrollPos(e, i, t.nc.opt.snapbackspeed)
                }, this.doMomentum = function(e) {
                    var i = t.time(),
                        o = e ? i + e : t.lasttime,
                        n = t.nc.getScrollLeft(),
                        r = t.nc.getScrollTop(),
                        s = t.nc.page.maxh,
                        a = t.nc.page.maxw;
                    t.speedx = a > 0 ? Math.min(60, t.speedx) : 0, t.speedy = s > 0 ? Math.min(60, t.speedy) : 0;
                    var l = o && i - o <= 60;
                    (r < 0 || r > s || n < 0 || n > a) && (l = !1);
                    var c = !(!t.speedy || !l) && t.speedy,
                        d = !(!t.speedx || !l) && t.speedx;
                    if (c || d) {
                        var u = Math.max(16, t.steptime);
                        if (u > 50) {
                            var h = u / 50;
                            t.speedx *= h, t.speedy *= h, u = 50
                        }
                        t.demulxy = 0, t.lastscrollx = t.nc.getScrollLeft(), t.chkx = t.lastscrollx, t.lastscrolly = t.nc.getScrollTop(), t.chky = t.lastscrolly;
                        var p = t.lastscrollx,
                            m = t.lastscrolly,
                            f = function() {
                                var e = t.time() - i > 600 ? .04 : .02;
                                t.speedx && (p = Math.floor(t.lastscrollx - t.speedx * (1 - t.demulxy)), t.lastscrollx = p, (p < 0 || p > a) && (e = .1)), t.speedy && (m = Math.floor(t.lastscrolly - t.speedy * (1 - t.demulxy)), t.lastscrolly = m, (m < 0 || m > s) && (e = .1)), t.demulxy = Math.min(1, t.demulxy + e), t.nc.synched("domomentum2d", function() {
                                    t.speedx && (t.nc.getScrollLeft() != t.chkx && t.stop(), t.chkx = p, t.nc.setScrollLeft(p));
                                    t.speedy && (t.nc.getScrollTop() != t.chky && t.stop(), t.chky = m, t.nc.setScrollTop(m));
                                    t.timer || (t.nc.hideCursor(), t.doSnapy(p, m))
                                }), t.demulxy < 1 ? t.timer = setTimeout(f, u) : (t.stop(), t.nc.hideCursor(), t.doSnapy(p, m))
                            };
                        f()
                    } else t.doSnapy(t.nc.getScrollLeft(), t.nc.getScrollTop())
                }
            },
            x = e.fn.scrollTop;
        e.cssHooks.pageYOffset = {
            get: function(e, t, i) {
                var o = s.data(e, "__nicescroll") || !1;
                return o && o.ishwscroll ? o.getScrollTop() : x.call(e)
            },
            set: function(e, t) {
                var i = s.data(e, "__nicescroll") || !1;
                return i && i.ishwscroll ? i.setScrollTop(parseInt(t)) : x.call(e, t), this
            }
        }, e.fn.scrollTop = function(e) {
            if (void 0 === e) {
                var t = this[0] && s.data(this[0], "__nicescroll") || !1;
                return t && t.ishwscroll ? t.getScrollTop() : x.call(this)
            }
            return this.each(function() {
                var t = s.data(this, "__nicescroll") || !1;
                t && t.ishwscroll ? t.setScrollTop(parseInt(e)) : x.call(s(this), e)
            })
        };
        var S = e.fn.scrollLeft;
        s.cssHooks.pageXOffset = {
            get: function(e, t, i) {
                var o = s.data(e, "__nicescroll") || !1;
                return o && o.ishwscroll ? o.getScrollLeft() : S.call(e)
            },
            set: function(e, t) {
                var i = s.data(e, "__nicescroll") || !1;
                return i && i.ishwscroll ? i.setScrollLeft(parseInt(t)) : S.call(e, t), this
            }
        }, e.fn.scrollLeft = function(e) {
            if (void 0 === e) {
                var t = this[0] && s.data(this[0], "__nicescroll") || !1;
                return t && t.ishwscroll ? t.getScrollLeft() : S.call(this)
            }
            return this.each(function() {
                var t = s.data(this, "__nicescroll") || !1;
                t && t.ishwscroll ? t.setScrollLeft(parseInt(e)) : S.call(s(this), e)
            })
        };
        var T = function(e) {
            var t = this;
            if (this.length = 0, this.name = "nicescrollarray", this.each = function(e) {
                for (var i = 0, o = 0; i < t.length; i++) e.call(t[i], o++);
                return t
            }, this.push = function(e) {
                t[t.length] = e, t.length++
            }, this.eq = function(e) {
                return t[e]
            }, e)
                for (a = 0; a < e.length; a++) {
                    var i = s.data(e[a], "__nicescroll") || !1;
                    i && (this[this.length] = i, this.length++)
                }
            return this
        };
        ! function(e, t, i) {
            for (var o = 0; o < t.length; o++) i(e, t[o])
        }(T.prototype, ["show", "hide", "toggle", "onResize", "resize", "remove", "stop", "doScrollPos"], function(e, t) {
            e[t] = function() {
                var e = arguments;
                return this.each(function() {
                    this[t].apply(this, e)
                })
            }
        }), e.fn.getNiceScroll = function(e) {
            return void 0 === e ? new T(this) : this[e] && s.data(this[e], "__nicescroll") || !1
        }, e.extend(e.expr[":"], {
            nicescroll: function(e) {
                return !!s.data(e, "__nicescroll")
            }
        }), s.fn.niceScroll = function(e, t) {
            void 0 === t && ("object" != typeof e || "jquery" in e || (t = e, e = !1));
            var i = new T;
            void 0 === t && (t = {}), e && (t.doc = s(e), t.win = s(this));
            var o = !("doc" in t);
            return o || "win" in t || (t.win = s(this)), this.each(function() {
                var e = s(this).data("__nicescroll") || !1;
                e || (t.doc = o ? s(this) : t.doc, e = new b(t, s(this)), s(this).data("__nicescroll", e)), i.push(e)
            }), 1 == i.length ? i[0] : i
        }, window.NiceScroll = {
            getjQuery: function() {
                return e
            }
        }, s.nicescroll || (s.nicescroll = new T, s.nicescroll.options = g)
    }(jQuery),
    function(e) {
        e.flexslider = function(t, i) {
            var o = e(t);
            o.vars = e.extend({}, e.flexslider.defaults, i);
            var n, r = o.vars.namespace,
                s = window.navigator && window.navigator.msPointerEnabled && window.MSGesture,
                a = ("ontouchstart" in window || s || window.DocumentTouch && document instanceof DocumentTouch) && o.vars.touch,
                l = "click touchend MSPointerUp keyup",
                c = "",
                d = "vertical" === o.vars.direction,
                u = o.vars.reverse,
                h = o.vars.itemWidth > 0,
                p = "fade" === o.vars.animation,
                m = "" !== o.vars.asNavFor,
                f = {};
            e.data(t, "flexslider", o), f = {
                init: function() {
                    o.animating = !1, o.currentSlide = parseInt(o.vars.startAt ? o.vars.startAt : 0, 10), isNaN(o.currentSlide) && (o.currentSlide = 0), o.animatingTo = o.currentSlide, o.atEnd = 0 === o.currentSlide || o.currentSlide === o.last, o.containerSelector = o.vars.selector.substr(0, o.vars.selector.search(" ")), o.slides = e(o.vars.selector, o), o.container = e(o.containerSelector, o), o.count = o.slides.length, o.syncExists = e(o.vars.sync).length > 0, "slide" === o.vars.animation && (o.vars.animation = "swing"), o.prop = d ? "top" : "marginLeft", o.args = {}, o.manualPause = !1, o.stopped = !1, o.started = !1, o.startTimeout = null, o.transitions = !o.vars.video && !p && o.vars.useCSS && function() {
                        var e = document.createElement("div"),
                            t = ["perspectiveProperty", "WebkitPerspective", "MozPerspective", "OPerspective", "msPerspective"];
                        for (var i in t)
                            if (void 0 !== e.style[t[i]]) return o.pfx = t[i].replace("Perspective", "").toLowerCase(), o.prop = "-" + o.pfx + "-transform", !0;
                        return !1
                    }(), o.ensureAnimationEnd = "", "" !== o.vars.controlsContainer && (o.controlsContainer = e(o.vars.controlsContainer).length > 0 && e(o.vars.controlsContainer)), "" !== o.vars.manualControls && (o.manualControls = e(o.vars.manualControls).length > 0 && e(o.vars.manualControls)), "" !== o.vars.customDirectionNav && (o.customDirectionNav = 2 === e(o.vars.customDirectionNav).length && e(o.vars.customDirectionNav)), o.vars.randomize && (o.slides.sort(function() {
                        return Math.round(Math.random()) - .5
                    }), o.container.empty().append(o.slides)), o.doMath(), o.setup("init"), o.vars.controlNav && f.controlNav.setup(), o.vars.directionNav && f.directionNav.setup(), o.vars.keyboard && (1 === e(o.containerSelector).length || o.vars.multipleKeyboard) && e(document).bind("keyup", function(e) {
                        var t = e.keyCode;
                        if (!o.animating && (39 === t || 37 === t)) {
                            var i = 39 === t ? o.getTarget("next") : 37 === t && o.getTarget("prev");
                            o.flexAnimate(i, o.vars.pauseOnAction)
                        }
                    }), o.vars.mousewheel && o.bind("mousewheel", function(e, t, i, n) {
                        e.preventDefault();
                        var r = o.getTarget(0 > t ? "next" : "prev");
                        o.flexAnimate(r, o.vars.pauseOnAction)
                    }), o.vars.pausePlay && f.pausePlay.setup(), o.vars.slideshow && o.vars.pauseInvisible && f.pauseInvisible.init(), o.vars.slideshow && (o.vars.pauseOnHover && o.hover(function() {
                        o.manualPlay || o.manualPause || o.pause()
                    }, function() {
                        o.manualPause || o.manualPlay || o.stopped || o.play()
                    }), o.vars.pauseInvisible && f.pauseInvisible.isHidden() || (o.vars.initDelay > 0 ? o.startTimeout = setTimeout(o.play, o.vars.initDelay) : o.play())), m && f.asNav.setup(), a && o.vars.touch && f.touch(), (!p || p && o.vars.smoothHeight) && e(window).bind("resize orientationchange focus", f.resize), o.find("img").attr("draggable", "false"), setTimeout(function() {
                        o.vars.start(o)
                    }, 200)
                },
                asNav: {
                    setup: function() {
                        o.asNav = !0, o.animatingTo = Math.floor(o.currentSlide / o.move), o.currentItem = o.currentSlide, o.slides.removeClass(r + "active-slide").eq(o.currentItem).addClass(r + "active-slide"), s ? (t._slider = o, o.slides.each(function() {
                            var t = this;
                            t._gesture = new MSGesture, t._gesture.target = t, t.addEventListener("MSPointerDown", function(e) {
                                e.preventDefault(), e.currentTarget._gesture && e.currentTarget._gesture.addPointer(e.pointerId)
                            }, !1), t.addEventListener("MSGestureTap", function(t) {
                                t.preventDefault();
                                var i = e(this),
                                    n = i.index();
                                e(o.vars.asNavFor).data("flexslider").animating || i.hasClass("active") || (o.direction = o.currentItem < n ? "next" : "prev", o.flexAnimate(n, o.vars.pauseOnAction, !1, !0, !0))
                            })
                        })) : o.slides.on(l, function(t) {
                            t.preventDefault();
                            var i = e(this),
                                n = i.index();
                            0 >= i.offset().left - e(o).scrollLeft() && i.hasClass(r + "active-slide") ? o.flexAnimate(o.getTarget("prev"), !0) : e(o.vars.asNavFor).data("flexslider").animating || i.hasClass(r + "active-slide") || (o.direction = o.currentItem < n ? "next" : "prev", o.flexAnimate(n, o.vars.pauseOnAction, !1, !0, !0))
                        })
                    }
                },
                controlNav: {
                    setup: function() {
                        o.manualControls ? f.controlNav.setupManual() : f.controlNav.setupPaging()
                    },
                    setupPaging: function() {
                        var t, i, n = "thumbnails" === o.vars.controlNav ? "control-thumbs" : "control-paging",
                            s = 1;
                        if (o.controlNavScaffold = e('<ol class="' + r + "control-nav " + r + n + '"></ol>'), o.pagingCount > 1)
                            for (var a = 0; a < o.pagingCount; a++) {
                                if (i = o.slides.eq(a), t = "thumbnails" === o.vars.controlNav ? '<img src="' + i.attr("data-thumb") + '"/>' : "<a>" + s + "</a>", "thumbnails" === o.vars.controlNav && !0 === o.vars.thumbCaptions) {
                                    var d = i.attr("data-thumbcaption");
                                    "" !== d && void 0 !== d && (t += '<span class="' + r + 'caption">' + d + "</span>")
                                }
                                o.controlNavScaffold.append("<li>" + t + "</li>"), s++
                            }
                        o.controlsContainer ? e(o.controlsContainer).append(o.controlNavScaffold) : o.append(o.controlNavScaffold), f.controlNav.set(), f.controlNav.active(), o.controlNavScaffold.delegate("a, img", l, function(t) {
                            if (t.preventDefault(), "" === c || c === t.type) {
                                var i = e(this),
                                    n = o.controlNav.index(i);
                                i.hasClass(r + "active") || (o.direction = n > o.currentSlide ? "next" : "prev", o.flexAnimate(n, o.vars.pauseOnAction))
                            }
                            "" === c && (c = t.type), f.setToClearWatchedEvent()
                        })
                    },
                    setupManual: function() {
                        o.controlNav = o.manualControls, f.controlNav.active(), o.controlNav.bind(l, function(t) {
                            if (t.preventDefault(), "" === c || c === t.type) {
                                var i = e(this),
                                    n = o.controlNav.index(i);
                                i.hasClass(r + "active") || (o.direction = n > o.currentSlide ? "next" : "prev", o.flexAnimate(n, o.vars.pauseOnAction))
                            }
                            "" === c && (c = t.type), f.setToClearWatchedEvent()
                        })
                    },
                    set: function() {
                        var t = "thumbnails" === o.vars.controlNav ? "img" : "a";
                        o.controlNav = e("." + r + "control-nav li " + t, o.controlsContainer ? o.controlsContainer : o)
                    },
                    active: function() {
                        o.controlNav.removeClass(r + "active").eq(o.animatingTo).addClass(r + "active")
                    },
                    update: function(t, i) {
                        o.pagingCount > 1 && "add" === t ? o.controlNavScaffold.append(e("<li><a>" + o.count + "</a></li>")) : 1 === o.pagingCount ? o.controlNavScaffold.find("li").remove() : o.controlNav.eq(i).closest("li").remove(), f.controlNav.set(), o.pagingCount > 1 && o.pagingCount !== o.controlNav.length ? o.update(i, t) : f.controlNav.active()
                    }
                },
                directionNav: {
                    setup: function() {
                        var t = e('<ul class="' + r + 'direction-nav"><li class="' + r + 'nav-prev"><a class="' + r + 'prev" href="#">' + o.vars.prevText + '</a></li><li class="' + r + 'nav-next"><a class="' + r + 'next" href="#">' + o.vars.nextText + "</a></li></ul>");
                        o.customDirectionNav ? o.directionNav = o.customDirectionNav : o.controlsContainer ? (e(o.controlsContainer).append(t), o.directionNav = e("." + r + "direction-nav li a", o.controlsContainer)) : (o.append(t), o.directionNav = e("." + r + "direction-nav li a", o)), f.directionNav.update(), o.directionNav.bind(l, function(t) {
                            var i;
                            t.preventDefault(), ("" === c || c === t.type) && (i = o.getTarget(e(this).hasClass(r + "next") ? "next" : "prev"), o.flexAnimate(i, o.vars.pauseOnAction)), "" === c && (c = t.type), f.setToClearWatchedEvent()
                        })
                    },
                    update: function() {
                        var e = r + "disabled";
                        1 === o.pagingCount ? o.directionNav.addClass(e).attr("tabindex", "-1") : o.vars.animationLoop ? o.directionNav.removeClass(e).removeAttr("tabindex") : 0 === o.animatingTo ? o.directionNav.removeClass(e).filter("." + r + "prev").addClass(e).attr("tabindex", "-1") : o.animatingTo === o.last ? o.directionNav.removeClass(e).filter("." + r + "next").addClass(e).attr("tabindex", "-1") : o.directionNav.removeClass(e).removeAttr("tabindex")
                    }
                },
                pausePlay: {
                    setup: function() {
                        var t = e('<div class="' + r + 'pauseplay"><a></a></div>');
                        o.controlsContainer ? (o.controlsContainer.append(t), o.pausePlay = e("." + r + "pauseplay a", o.controlsContainer)) : (o.append(t), o.pausePlay = e("." + r + "pauseplay a", o)), f.pausePlay.update(o.vars.slideshow ? r + "pause" : r + "play"), o.pausePlay.bind(l, function(t) {
                            t.preventDefault(), ("" === c || c === t.type) && (e(this).hasClass(r + "pause") ? (o.manualPause = !0, o.manualPlay = !1, o.pause()) : (o.manualPause = !1, o.manualPlay = !0, o.play())), "" === c && (c = t.type), f.setToClearWatchedEvent()
                        })
                    },
                    update: function(e) {
                        "play" === e ? o.pausePlay.removeClass(r + "pause").addClass(r + "play").html(o.vars.playText) : o.pausePlay.removeClass(r + "play").addClass(r + "pause").html(o.vars.pauseText)
                    }
                },
                touch: function() {
                    var e, i, n, r, a, l, c, m, f, v = !1,
                        g = 0,
                        w = 0,
                        b = 0;
                    s ? (t.style.msTouchAction = "none", t._gesture = new MSGesture, t._gesture.target = t, t.addEventListener("MSPointerDown", function(e) {
                        e.stopPropagation(), o.animating ? e.preventDefault() : (o.pause(), t._gesture.addPointer(e.pointerId), b = 0, r = d ? o.h : o.w, l = Number(new Date), n = h && u && o.animatingTo === o.last ? 0 : h && u ? o.limit - (o.itemW + o.vars.itemMargin) * o.move * o.animatingTo : h && o.currentSlide === o.last ? o.limit : h ? (o.itemW + o.vars.itemMargin) * o.move * o.currentSlide : u ? (o.last - o.currentSlide + o.cloneOffset) * r : (o.currentSlide + o.cloneOffset) * r)
                    }, !1), t._slider = o, t.addEventListener("MSGestureChange", function(e) {
                        e.stopPropagation();
                        var i = e.target._slider;
                        if (i) {
                            var o = -e.translationX,
                                s = -e.translationY;
                            return a = b += d ? s : o, v = d ? Math.abs(b) < Math.abs(-o) : Math.abs(b) < Math.abs(-s), e.detail === e.MSGESTURE_FLAG_INERTIA ? void setImmediate(function() {
                                t._gesture.stop()
                            }) : void((!v || Number(new Date) - l > 500) && (e.preventDefault(), !p && i.transitions && (i.vars.animationLoop || (a = b / (0 === i.currentSlide && 0 > b || i.currentSlide === i.last && b > 0 ? Math.abs(b) / r + 2 : 1)), i.setProps(n + a, "setTouch"))))
                        }
                    }, !1), t.addEventListener("MSGestureEnd", function(t) {
                        t.stopPropagation();
                        var o = t.target._slider;
                        if (o) {
                            if (o.animatingTo === o.currentSlide && !v && null !== a) {
                                var s = u ? -a : a,
                                    c = o.getTarget(s > 0 ? "next" : "prev");
                                o.canAdvance(c) && (Number(new Date) - l < 550 && Math.abs(s) > 50 || Math.abs(s) > r / 2) ? o.flexAnimate(c, o.vars.pauseOnAction) : p || o.flexAnimate(o.currentSlide, o.vars.pauseOnAction, !0)
                            }
                            e = null, i = null, a = null, n = null, b = 0
                        }
                    }, !1)) : (c = function(s) {
                        o.animating ? s.preventDefault() : (window.navigator.msPointerEnabled || 1 === s.touches.length) && (o.pause(), r = d ? o.h : o.w, l = Number(new Date), g = s.touches[0].pageX, w = s.touches[0].pageY, n = h && u && o.animatingTo === o.last ? 0 : h && u ? o.limit - (o.itemW + o.vars.itemMargin) * o.move * o.animatingTo : h && o.currentSlide === o.last ? o.limit : h ? (o.itemW + o.vars.itemMargin) * o.move * o.currentSlide : u ? (o.last - o.currentSlide + o.cloneOffset) * r : (o.currentSlide + o.cloneOffset) * r, e = d ? w : g, i = d ? g : w, t.addEventListener("touchmove", m, !1), t.addEventListener("touchend", f, !1))
                    }, m = function(t) {
                        g = t.touches[0].pageX, w = t.touches[0].pageY, a = d ? e - w : e - g;
                        (!(v = d ? Math.abs(a) < Math.abs(g - i) : Math.abs(a) < Math.abs(w - i)) || Number(new Date) - l > 500) && (t.preventDefault(), !p && o.transitions && (o.vars.animationLoop || (a /= 0 === o.currentSlide && 0 > a || o.currentSlide === o.last && a > 0 ? Math.abs(a) / r + 2 : 1), o.setProps(n + a, "setTouch")))
                    }, f = function(s) {
                        if (t.removeEventListener("touchmove", m, !1), o.animatingTo === o.currentSlide && !v && null !== a) {
                            var c = u ? -a : a,
                                d = o.getTarget(c > 0 ? "next" : "prev");
                            o.canAdvance(d) && (Number(new Date) - l < 550 && Math.abs(c) > 50 || Math.abs(c) > r / 2) ? o.flexAnimate(d, o.vars.pauseOnAction) : p || o.flexAnimate(o.currentSlide, o.vars.pauseOnAction, !0)
                        }
                        t.removeEventListener("touchend", f, !1), e = null, i = null, a = null, n = null
                    }, t.addEventListener("touchstart", c, !1))
                },
                resize: function() {
                    !o.animating && o.is(":visible") && (h || o.doMath(), p ? f.smoothHeight() : h ? (o.slides.width(o.computedW), o.update(o.pagingCount), o.setProps()) : d ? (o.viewport.height(o.h), o.setProps(o.h, "setTotal")) : (o.vars.smoothHeight && f.smoothHeight(), o.newSlides.width(o.computedW), o.setProps(o.computedW, "setTotal")))
                },
                smoothHeight: function(e) {
                    if (!d || p) {
                        var t = p ? o : o.viewport;
                        e ? t.animate({
                            height: o.slides.eq(o.animatingTo).height()
                        }, e) : t.height(o.slides.eq(o.animatingTo).height())
                    }
                },
                sync: function(t) {
                    var i = e(o.vars.sync).data("flexslider"),
                        n = o.animatingTo;
                    switch (t) {
                        case "animate":
                            i.flexAnimate(n, o.vars.pauseOnAction, !1, !0);
                            break;
                        case "play":
                            i.playing || i.asNav || i.play();
                            break;
                        case "pause":
                            i.pause()
                    }
                },
                uniqueID: function(t) {
                    return t.filter("[id]").add(t.find("[id]")).each(function() {
                        var t = e(this);
                        t.attr("id", t.attr("id") + "_clone")
                    }), t
                },
                pauseInvisible: {
                    visProp: null,
                    init: function() {
                        var e = f.pauseInvisible.getHiddenProp();
                        if (e) {
                            var t = e.replace(/[H|h]idden/, "") + "visibilitychange";
                            document.addEventListener(t, function() {
                                f.pauseInvisible.isHidden() ? o.startTimeout ? clearTimeout(o.startTimeout) : o.pause() : o.started ? o.play() : o.vars.initDelay > 0 ? setTimeout(o.play, o.vars.initDelay) : o.play()
                            })
                        }
                    },
                    isHidden: function() {
                        var e = f.pauseInvisible.getHiddenProp();
                        return !!e && document[e]
                    },
                    getHiddenProp: function() {
                        var e = ["webkit", "moz", "ms", "o"];
                        if ("hidden" in document) return "hidden";
                        for (var t = 0; t < e.length; t++)
                            if (e[t] + "Hidden" in document) return e[t] + "Hidden";
                        return null
                    }
                },
                setToClearWatchedEvent: function() {
                    clearTimeout(n), n = setTimeout(function() {
                        c = ""
                    }, 3e3)
                }
            }, o.flexAnimate = function(t, i, n, s, l) {
                if (o.vars.animationLoop || t === o.currentSlide || (o.direction = t > o.currentSlide ? "next" : "prev"), m && 1 === o.pagingCount && (o.direction = o.currentItem < t ? "next" : "prev"), !o.animating && (o.canAdvance(t, l) || n) && o.is(":visible")) {
                    if (m && s) {
                        var c = e(o.vars.asNavFor).data("flexslider");
                        if (o.atEnd = 0 === t || t === o.count - 1, c.flexAnimate(t, !0, !1, !0, l), o.direction = o.currentItem < t ? "next" : "prev", c.direction = o.direction, Math.ceil((t + 1) / o.visible) - 1 === o.currentSlide || 0 === t) return o.currentItem = t, o.slides.removeClass(r + "active-slide").eq(t).addClass(r + "active-slide"), !1;
                        o.currentItem = t, o.slides.removeClass(r + "active-slide").eq(t).addClass(r + "active-slide"), t = Math.floor(t / o.visible)
                    }
                    if (o.animating = !0, o.animatingTo = t, i && o.pause(), o.vars.before(o), o.syncExists && !l && f.sync("animate"), o.vars.controlNav && f.controlNav.active(), h || o.slides.removeClass(r + "active-slide").eq(t).addClass(r + "active-slide"), o.atEnd = 0 === t || t === o.last, o.vars.directionNav && f.directionNav.update(), t === o.last && (o.vars.end(o), o.vars.animationLoop || o.pause()), p) a ? (o.slides.eq(o.currentSlide).css({
                        opacity: 0,
                        zIndex: 1
                    }), o.slides.eq(t).css({
                        opacity: 1,
                        zIndex: 2
                    }), o.wrapup(b)) : (o.slides.eq(o.currentSlide).css({
                        zIndex: 1
                    }).animate({
                        opacity: 0
                    }, o.vars.animationSpeed, o.vars.easing), o.slides.eq(t).css({
                        zIndex: 2
                    }).animate({
                        opacity: 1
                    }, o.vars.animationSpeed, o.vars.easing, o.wrapup));
                    else {
                        var v, g, w, b = d ? o.slides.filter(":first").height() : o.computedW;
                        h ? (v = o.vars.itemMargin, g = (w = (o.itemW + v) * o.move * o.animatingTo) > o.limit && 1 !== o.visible ? o.limit : w) : g = 0 === o.currentSlide && t === o.count - 1 && o.vars.animationLoop && "next" !== o.direction ? u ? (o.count + o.cloneOffset) * b : 0 : o.currentSlide === o.last && 0 === t && o.vars.animationLoop && "prev" !== o.direction ? u ? 0 : (o.count + 1) * b : u ? (o.count - 1 - t + o.cloneOffset) * b : (t + o.cloneOffset) * b, o.setProps(g, "", o.vars.animationSpeed), o.transitions ? (o.vars.animationLoop && o.atEnd || (o.animating = !1, o.currentSlide = o.animatingTo), o.container.unbind("webkitTransitionEnd transitionend"), o.container.bind("webkitTransitionEnd transitionend", function() {
                            clearTimeout(o.ensureAnimationEnd), o.wrapup(b)
                        }), clearTimeout(o.ensureAnimationEnd), o.ensureAnimationEnd = setTimeout(function() {
                            o.wrapup(b)
                        }, o.vars.animationSpeed + 100)) : o.container.animate(o.args, o.vars.animationSpeed, o.vars.easing, function() {
                            o.wrapup(b)
                        })
                    }
                    o.vars.smoothHeight && f.smoothHeight(o.vars.animationSpeed)
                }
            }, o.wrapup = function(e) {
                p || h || (0 === o.currentSlide && o.animatingTo === o.last && o.vars.animationLoop ? o.setProps(e, "jumpEnd") : o.currentSlide === o.last && 0 === o.animatingTo && o.vars.animationLoop && o.setProps(e, "jumpStart")), o.animating = !1, o.currentSlide = o.animatingTo, o.vars.after(o)
            }, o.animateSlides = function() {
                !o.animating && o.flexAnimate(o.getTarget("next"))
            }, o.pause = function() {
                clearInterval(o.animatedSlides), o.animatedSlides = null, o.playing = !1, o.vars.pausePlay && f.pausePlay.update("play"), o.syncExists && f.sync("pause")
            }, o.play = function() {
                o.playing && clearInterval(o.animatedSlides), o.animatedSlides = o.animatedSlides || setInterval(o.animateSlides, o.vars.slideshowSpeed), o.started = o.playing = !0, o.vars.pausePlay && f.pausePlay.update("pause"), o.syncExists && f.sync("play")
            }, o.stop = function() {
                o.pause(), o.stopped = !0
            }, o.canAdvance = function(e, t) {
                var i = m ? o.pagingCount - 1 : o.last;
                return !!t || (!(!m || o.currentItem !== o.count - 1 || 0 !== e || "prev" !== o.direction) || (!m || 0 !== o.currentItem || e !== o.pagingCount - 1 || "next" === o.direction) && (!(e === o.currentSlide && !m) && (!!o.vars.animationLoop || (!o.atEnd || 0 !== o.currentSlide || e !== i || "next" === o.direction) && (!o.atEnd || o.currentSlide !== i || 0 !== e || "next" !== o.direction))))
            }, o.getTarget = function(e) {
                return o.direction = e, "next" === e ? o.currentSlide === o.last ? 0 : o.currentSlide + 1 : 0 === o.currentSlide ? o.last : o.currentSlide - 1
            }, o.setProps = function(e, t, i) {
                var n = function() {
                    var i = e || (o.itemW + o.vars.itemMargin) * o.move * o.animatingTo;
                    return -1 * function() {
                        if (h) return "setTouch" === t ? e : u && o.animatingTo === o.last ? 0 : u ? o.limit - (o.itemW + o.vars.itemMargin) * o.move * o.animatingTo : o.animatingTo === o.last ? o.limit : i;
                        switch (t) {
                            case "setTotal":
                                return u ? (o.count - 1 - o.currentSlide + o.cloneOffset) * e : (o.currentSlide + o.cloneOffset) * e;
                            case "setTouch":
                                return e;
                            case "jumpEnd":
                                return u ? e : o.count * e;
                            case "jumpStart":
                                return u ? o.count * e : e;
                            default:
                                return e
                        }
                    }() + "px"
                }();
                o.transitions && (n = d ? "translate3d(0," + n + ",0)" : "translate3d(" + n + ",0,0)", i = void 0 !== i ? i / 1e3 + "s" : "0s", o.container.css("-" + o.pfx + "-transition-duration", i), o.container.css("transition-duration", i)), o.args[o.prop] = n, (o.transitions || void 0 === i) && o.container.css(o.args), o.container.css("transform", n)
            }, o.setup = function(t) {
                var i, n;
                p ? (o.slides.css({
                    width: "100%",
                    float: "left",
                    marginRight: "-100%",
                    position: "relative"
                }), "init" === t && (a ? o.slides.css({
                    opacity: 0,
                    display: "block",
                    webkitTransition: "opacity " + o.vars.animationSpeed / 1e3 + "s ease",
                    zIndex: 1
                }).eq(o.currentSlide).css({
                    opacity: 1,
                    zIndex: 2
                }) : 0 == o.vars.fadeFirstSlide ? o.slides.css({
                    opacity: 0,
                    display: "block",
                    zIndex: 1
                }).eq(o.currentSlide).css({
                    zIndex: 2
                }).css({
                    opacity: 1
                }) : o.slides.css({
                    opacity: 0,
                    display: "block",
                    zIndex: 1
                }).eq(o.currentSlide).css({
                    zIndex: 2
                }).animate({
                    opacity: 1
                }, o.vars.animationSpeed, o.vars.easing)), o.vars.smoothHeight && f.smoothHeight()) : ("init" === t && (o.viewport = e('<div class="' + r + 'viewport"></div>').css({
                    overflow: "hidden",
                    position: "relative"
                }).appendTo(o).append(o.container), o.cloneCount = 0, o.cloneOffset = 0, u && (n = e.makeArray(o.slides).reverse(), o.slides = e(n), o.container.empty().append(o.slides))), o.vars.animationLoop && !h && (o.cloneCount = 2, o.cloneOffset = 1, "init" !== t && o.container.find(".clone").remove(), o.container.append(f.uniqueID(o.slides.first().clone().addClass("clone")).attr("aria-hidden", "true")).prepend(f.uniqueID(o.slides.last().clone().addClass("clone")).attr("aria-hidden", "true"))), o.newSlides = e(o.vars.selector, o), i = u ? o.count - 1 - o.currentSlide + o.cloneOffset : o.currentSlide + o.cloneOffset, d && !h ? (o.container.height(200 * (o.count + o.cloneCount) + "%").css("position", "absolute").width("100%"), setTimeout(function() {
                    o.newSlides.css({
                        display: "block"
                    }), o.doMath(), o.viewport.height(o.h), o.setProps(i * o.h, "init")
                }, "init" === t ? 100 : 0)) : (o.container.width(200 * (o.count + o.cloneCount) + "%"), o.setProps(i * o.computedW, "init"), setTimeout(function() {
                    o.doMath(), o.newSlides.css({
                        width: o.computedW,
                        float: "left",
                        display: "block"
                    }), o.vars.smoothHeight && f.smoothHeight()
                }, "init" === t ? 100 : 0)));
                h || o.slides.removeClass(r + "active-slide").eq(o.currentSlide).addClass(r + "active-slide"), o.vars.init(o)
            }, o.doMath = function() {
                var e = o.slides.first(),
                    t = o.vars.itemMargin,
                    i = o.vars.minItems,
                    n = o.vars.maxItems;
                o.w = void 0 === o.viewport ? o.width() : o.viewport.width(), o.h = e.height(), o.boxPadding = e.outerWidth() - e.width(), h ? (o.itemT = o.vars.itemWidth + t, o.minW = i ? i * o.itemT : o.w, o.maxW = n ? n * o.itemT - t : o.w, o.itemW = o.minW > o.w ? (o.w - t * (i - 1)) / i : o.maxW < o.w ? (o.w - t * (n - 1)) / n : o.vars.itemWidth > o.w ? o.w : o.vars.itemWidth, o.visible = Math.floor(o.w / o.itemW), o.move = o.vars.move > 0 && o.vars.move < o.visible ? o.vars.move : o.visible, o.pagingCount = Math.ceil((o.count - o.visible) / o.move + 1), o.last = o.pagingCount - 1, o.limit = 1 === o.pagingCount ? 0 : o.vars.itemWidth > o.w ? o.itemW * (o.count - 1) + t * (o.count - 1) : (o.itemW + t) * o.count - o.w - t) : (o.itemW = o.w, o.pagingCount = o.count, o.last = o.count - 1), o.computedW = o.itemW - o.boxPadding
            }, o.update = function(e, t) {
                o.doMath(), h || (e < o.currentSlide ? o.currentSlide += 1 : e <= o.currentSlide && 0 !== e && (o.currentSlide -= 1), o.animatingTo = o.currentSlide), o.vars.controlNav && !o.manualControls && ("add" === t && !h || o.pagingCount > o.controlNav.length ? f.controlNav.update("add") : ("remove" === t && !h || o.pagingCount < o.controlNav.length) && (h && o.currentSlide > o.last && (o.currentSlide -= 1, o.animatingTo -= 1), f.controlNav.update("remove", o.last))), o.vars.directionNav && f.directionNav.update()
            }, o.addSlide = function(t, i) {
                var n = e(t);
                o.count += 1, o.last = o.count - 1, d && u ? void 0 !== i ? o.slides.eq(o.count - i).after(n) : o.container.prepend(n) : void 0 !== i ? o.slides.eq(i).before(n) : o.container.append(n), o.update(i, "add"), o.slides = e(o.vars.selector + ":not(.clone)", o), o.setup(), o.vars.added(o)
            }, o.removeSlide = function(t) {
                var i = isNaN(t) ? o.slides.index(e(t)) : t;
                o.count -= 1, o.last = o.count - 1, isNaN(t) ? e(t, o.slides).remove() : d && u ? o.slides.eq(o.last).remove() : o.slides.eq(t).remove(), o.doMath(), o.update(i, "remove"), o.slides = e(o.vars.selector + ":not(.clone)", o), o.setup(), o.vars.removed(o)
            }, f.init()
        }, e(window).blur(function(e) {
            focused = !1
        }).focus(function(e) {
            focused = !0
        }), e.flexslider.defaults = {
            namespace: "flex-",
            selector: ".slides > li",
            animation: "fade",
            easing: "swing",
            direction: "horizontal",
            reverse: !1,
            animationLoop: !0,
            smoothHeight: !1,
            startAt: 0,
            slideshow: !0,
            slideshowSpeed: 7e3,
            animationSpeed: 600,
            initDelay: 0,
            randomize: !1,
            fadeFirstSlide: !0,
            thumbCaptions: !1,
            pauseOnAction: !0,
            pauseOnHover: !1,
            pauseInvisible: !0,
            useCSS: !0,
            touch: !0,
            video: !1,
            controlNav: !0,
            directionNav: !0,
            prevText: "Previous",
            nextText: "Next",
            keyboard: !0,
            multipleKeyboard: !1,
            mousewheel: !1,
            pausePlay: !1,
            pauseText: "Pause",
            playText: "Play",
            controlsContainer: "",
            manualControls: "",
            customDirectionNav: "",
            sync: "",
            asNavFor: "",
            itemWidth: 0,
            itemMargin: 0,
            minItems: 1,
            maxItems: 0,
            move: 0,
            allowOneSlide: !0,
            start: function() {},
            before: function() {},
            after: function() {},
            end: function() {},
            added: function() {},
            removed: function() {},
            init: function() {}
        }, e.fn.flexslider = function(t) {
            if (void 0 === t && (t = {}), "object" == typeof t) return this.each(function() {
                var i = e(this),
                    o = t.selector ? t.selector : ".slides > li",
                    n = i.find(o);
                1 === n.length && !0 === t.allowOneSlide || 0 === n.length ? (n.fadeIn(400), t.start && t.start(i)) : void 0 === i.data("flexslider") && new e.flexslider(this, t)
            });
            var i = e(this).data("flexslider");
            switch (t) {
                case "play":
                    i.play();
                    break;
                case "pause":
                    i.pause();
                    break;
                case "stop":
                    i.stop();
                    break;
                case "next":
                    i.flexAnimate(i.getTarget("next"), !0);
                    break;
                case "prev":
                case "previous":
                    i.flexAnimate(i.getTarget("prev"), !0);
                    break;
                default:
                    "number" == typeof t && i.flexAnimate(t, !0)
            }
        }
    }(jQuery);
var bliss_loadmore_params = {
    ajaxurl: window.location.protocol + "//" + location.hostname + "//blog/wp-admin/admin-ajax.php/",
    posts: '{"error":"","m":"","p":"179","post_parent":"","subpost":"","subpost_id":"","attachment":"","attachment_id":0,"name":"","pagename":"","page_id":"179","second":"","minute":"","hour":"","day":0,"monthnum":0,"year":0,"w":0,"category_name":"","tag":"","cat":"","tag_id":"","author":"","author_name":"","feed":"","tb":"","paged":0,"meta_key":"","meta_value":"","preview":"","s":"","sentence":"","title":"","fields":"","menu_order":"","embed":"","category__in":[],"category__not_in":[],"category__and":[],"post__in":[],"post__not_in":[],"post_name__in":[],"tag__in":[],"tag__not_in":[],"tag__and":[],"tag_slug__in":[],"tag_slug__and":[],"post_parent__in":[],"post_parent__not_in":[],"author__in":[],"author__not_in":[],"ignore_sticky_posts":false,"suppress_filters":false,"cache_results":true,"update_post_term_cache":true,"lazy_load_term_meta":true,"update_post_meta_cache":true,"post_type":"","posts_per_page":200,"nopaging":false,"comments_per_page":"50","no_found_rows":false,"order":"DESC"}',
    current_page: "1",
    max_page: "0",
    maindiv: ".post-container",
    innerdiv: ".post",
    loadmore_image: window.location.protocol + "//" + location.hostname + "/blog/wp-content/plugins/infinite-scroll-and-ajax-load-more/public/images/ajax-loader.gif"
};
jQuery(function(e) {
    var t = !0,
        i = bliss_loadmore_params.maindiv,
        o = bliss_loadmore_params.innerdiv,
        n = bliss_loadmore_params.loadmore_image;
    e(window).scroll(function() {
        var r = {
            action: "loadmore",
            query: bliss_loadmore_params.posts,
            page: bliss_loadmore_params.current_page
        };
        e(document).scrollTop() > e(document).height() - 2e3 && !0 === t && e.ajax({
            url: bliss_loadmore_params.ajaxurl,
            data: r,
            type: "POST",
            beforeSend: function(o) {
                e(i).parent().append('<span class="bliss-loading"><img src="' + n + '"></span>'), t = !1
            },
            success: function(n) {
                n ? (e(i).find(o + ":last-of-type").after(n), e(i).parent().find(".bliss-loading").remove(), t = !0, bliss_loadmore_params.current_page++) : e(i).parent().find(".bliss-loading").remove()
            }
        })
    })
}), jQuery(document).ready(function(e) {
    "use strict";
    e(".carousel").elastislide({
        imageW: 130,
        minItems: 1,
        margin: 2
    }), e(".tabber-container").each(function() {
        e(this).find(".tabber-content").hide(), e(this).find(".tabber-content:first").show()
    }), e(".score-nav-menu select").change(function(t) {
        e(this).parents(".tabber-container").find(".tabber-content").hide();
        var i = e(this).find("option:selected").val();
        e(this).parents(".tabber-container").find(i).fadeIn(), t.preventDefault()
    }), e("select.tabs option a").change(function(e) {
        e.preventDefault()
    })
}),
    function() {
        var e = function(t, i) {
            function o() {
                var e, t;
                this.q = [], this.add = function(e) {
                    this.q.push(e)
                }, this.call = function() {
                    for (e = 0, t = this.q.length; e < t; e++) this.q[e].call()
                }
            }

            function n(e, t) {
                if (e.resizedAttached) {
                    if (e.resizedAttached) return void e.resizedAttached.add(t)
                } else e.resizedAttached = new o, e.resizedAttached.add(t);
                e.resizeSensor = document.createElement("div"), e.resizeSensor.className = "resize-sensor";
                var i = "position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;",
                    n = "position: absolute; left: 0; top: 0; transition: 0s;";
                e.resizeSensor.style.cssText = i, e.resizeSensor.innerHTML = '<div class="resize-sensor-expand" style="' + i + '"><div style="' + n + '"></div></div><div class="resize-sensor-shrink" style="' + i + '"><div style="' + n + ' width: 200%; height: 200%"></div></div>', e.appendChild(e.resizeSensor), {
                    fixed: 1,
                    absolute: 1
                } [function(e, t) {
                    return e.currentStyle ? e.currentStyle[t] : window.getComputedStyle ? window.getComputedStyle(e, null).getPropertyValue(t) : e.style[t]
                }(e, "position")] || (e.style.position = "relative");
                var r, s, a = e.resizeSensor.childNodes[0],
                    l = a.childNodes[0],
                    c = e.resizeSensor.childNodes[1],
                    d = (c.childNodes[0], function() {
                        l.style.width = a.offsetWidth + 10 + "px", l.style.height = a.offsetHeight + 10 + "px", a.scrollLeft = a.scrollWidth, a.scrollTop = a.scrollHeight, c.scrollLeft = c.scrollWidth, c.scrollTop = c.scrollHeight, r = e.offsetWidth, s = e.offsetHeight
                    });
                d();
                var u = function(e, t, i) {
                        e.attachEvent ? e.attachEvent("on" + t, i) : e.addEventListener(t, i)
                    },
                    h = function() {
                        e.offsetWidth == r && e.offsetHeight == s || e.resizedAttached && e.resizedAttached.call(), d()
                    };
                u(a, "scroll", h), u(c, "scroll", h)
            }
            var r = Object.prototype.toString.call(t),
                s = "[object Array]" === r || "[object NodeList]" === r || "[object HTMLCollection]" === r || "undefined" != typeof jQuery && t instanceof jQuery || "undefined" != typeof Elements && t instanceof Elements;
            if (s)
                for (var a = 0, l = t.length; a < l; a++) n(t[a], i);
            else n(t, i);
            this.detach = function() {
                if (s)
                    for (var i = 0, o = t.length; i < o; i++) e.detach(t[i]);
                else e.detach(t)
            }
        };
        e.detach = function(e) {
            e.resizeSensor && (e.removeChild(e.resizeSensor), delete e.resizeSensor, delete e.resizedAttached)
        }, "undefined" != typeof module && void 0 !== module.exports ? module.exports = e : window.ResizeSensor = e
    }(),
    function(e) {
        e.fn.theiaStickySidebar = function(t) {
            function i(t, i) {
                return !0 === t.initialized || !(e("body").width() < t.minWidth) && (function(t, i) {
                    t.initialized = !0, e("head").append(e('<style>.theiaStickySidebar:after {content: ""; display: table; clear: both;}</style>')), i.each(function() {
                        var i = {};
                        if (i.sidebar = e(this), i.options = t || {}, i.container = e(i.options.containerSelector), 0 == i.container.length && (i.container = i.sidebar.parent()), i.sidebar.parents().css("-webkit-transform", "none"), i.sidebar.css({
                            position: "relative",
                            overflow: "visible",
                            "-webkit-box-sizing": "border-box",
                            "-moz-box-sizing": "border-box",
                            "box-sizing": "border-box"
                        }), i.stickySidebar = i.sidebar.find(".theiaStickySidebar"), 0 == i.stickySidebar.length) {
                            var n = /(?:text|application)\/(?:x-)?(?:javascript|ecmascript)/i;
                            i.sidebar.find("script").filter(function(e, t) {
                                return 0 === t.type.length || t.type.match(n)
                            }).remove(), i.stickySidebar = e("<div>").addClass("theiaStickySidebar").append(i.sidebar.children()), i.sidebar.append(i.stickySidebar)
                        }
                        i.marginBottom = parseInt(i.sidebar.css("margin-bottom")), i.paddingTop = parseInt(i.sidebar.css("padding-top")), i.paddingBottom = parseInt(i.sidebar.css("padding-bottom"));
                        var r = i.stickySidebar.offset().top,
                            s = i.stickySidebar.outerHeight();

                        function a() {
                            i.fixedScrollTop = 0, i.sidebar.css({
                                "min-height": "1px"
                            }), i.stickySidebar.css({
                                position: "static",
                                width: "",
                                transform: "none"
                            })
                        }
                        i.stickySidebar.css("padding-top", 1), i.stickySidebar.css("padding-bottom", 1), r -= i.stickySidebar.offset().top, s = i.stickySidebar.outerHeight() - s - r, 0 == r ? (i.stickySidebar.css("padding-top", 0), i.stickySidebarPaddingTop = 0) : i.stickySidebarPaddingTop = 1, 0 == s ? (i.stickySidebar.css("padding-bottom", 0), i.stickySidebarPaddingBottom = 0) : i.stickySidebarPaddingBottom = 1, i.previousScrollTop = null, i.fixedScrollTop = 0, a(), i.onScroll = function(i) {
                            if (i.stickySidebar.is(":visible"))
                                if (e("body").width() < i.options.minWidth) a();
                                else {
                                    if (i.options.disableOnResponsiveLayouts) {
                                        var n = i.sidebar.outerWidth("none" == i.sidebar.css("float"));
                                        if (n + 50 > i.container.width()) return void a()
                                    }
                                    var r, s, l = e(document).scrollTop(),
                                        c = "static";
                                    if (l >= i.sidebar.offset().top + (i.paddingTop - i.options.additionalMarginTop)) {
                                        var d, u = i.paddingTop + t.additionalMarginTop,
                                            h = i.paddingBottom + i.marginBottom + t.additionalMarginBottom,
                                            p = i.sidebar.offset().top,
                                            m = i.sidebar.offset().top + (r = i.container, s = r.height(), r.children().each(function() {
                                                s = Math.max(s, e(this).height())
                                            }), s),
                                            f = 0 + t.additionalMarginTop,
                                            v = i.stickySidebar.outerHeight() + u + h < e(window).height();
                                        d = v ? f + i.stickySidebar.outerHeight() : e(window).height() - i.marginBottom - i.paddingBottom - t.additionalMarginBottom;
                                        var g = p - l + i.paddingTop,
                                            w = m - l - i.paddingBottom - i.marginBottom,
                                            b = i.stickySidebar.offset().top - l,
                                            y = i.previousScrollTop - l;
                                        "fixed" == i.stickySidebar.css("position") && "modern" == i.options.sidebarBehavior && (b += y), "stick-to-top" == i.options.sidebarBehavior && (b = t.additionalMarginTop), "stick-to-bottom" == i.options.sidebarBehavior && (b = d - i.stickySidebar.outerHeight()), b = y > 0 ? Math.min(b, f) : Math.max(b, d - i.stickySidebar.outerHeight()), b = Math.max(b, g), b = Math.min(b, w - i.stickySidebar.outerHeight());
                                        var x = i.container.height() == i.stickySidebar.outerHeight();
                                        c = (x || b != f) && (x || b != d - i.stickySidebar.outerHeight()) ? l + b - i.sidebar.offset().top - i.paddingTop <= t.additionalMarginTop ? "static" : "absolute" : "fixed"
                                    }
                                    if ("fixed" == c) {
                                        var S = e(document).scrollLeft();
                                        i.stickySidebar.css({
                                            position: "fixed",
                                            width: o(i.stickySidebar) + "px",
                                            transform: "translateY(" + b + "px)",
                                            left: i.sidebar.offset().left + parseInt(i.sidebar.css("padding-left")) - S + "px",
                                            top: "0px"
                                        })
                                    } else if ("absolute" == c) {
                                        var T = {};
                                        "absolute" != i.stickySidebar.css("position") && (T.position = "absolute", T.transform = "translateY(" + (l + b - i.sidebar.offset().top - i.stickySidebarPaddingTop - i.stickySidebarPaddingBottom) + "px)", T.top = "0px"), T.width = o(i.stickySidebar) + "px", T.left = "", i.stickySidebar.css(T)
                                    } else "static" == c && a();
                                    "static" != c && 1 == i.options.updateSidebarHeight && i.sidebar.css({
                                        "min-height": i.stickySidebar.outerHeight() + i.stickySidebar.offset().top - i.sidebar.offset().top + i.paddingBottom
                                    }), i.previousScrollTop = l
                                }
                        }, i.onScroll(i), e(document).scroll(function(e) {
                            return function() {
                                e.onScroll(e)
                            }
                        }(i)), e(window).resize(function(e) {
                            return function() {
                                e.stickySidebar.css({
                                    position: "static"
                                }), e.onScroll(e)
                            }
                        }(i)), "undefined" != typeof ResizeSensor && new ResizeSensor(i.stickySidebar[0], function(e) {
                            return function() {
                                e.onScroll(e)
                            }
                        }(i))
                    })
                }(t, i), !0)
            }

            function o(e) {
                var t;
                try {
                    t = e[0].getBoundingClientRect().width
                } catch (e) {}
                return void 0 === t && (t = e.width()), t
            }(t = e.extend({
                containerSelector: "",
                additionalMarginTop: 0,
                additionalMarginBottom: 0,
                updateSidebarHeight: !0,
                minWidth: 0,
                disableOnResponsiveLayouts: !0,
                sidebarBehavior: "modern"
            }, t)).additionalMarginTop = parseInt(t.additionalMarginTop) || 0, t.additionalMarginBottom = parseInt(t.additionalMarginBottom) || 0,
                function(t, o) {
                    i(t, o) || (console.log("TSS: Body width smaller than options.minWidth. Init is delayed."), e(document).scroll(function(t, o) {
                        return function(n) {
                            var r = i(t, o);
                            r && e(this).unbind(n)
                        }
                    }(t, o)), e(window).resize(function(t, o) {
                        return function(n) {
                            var r = i(t, o);
                            r && e(this).unbind(n)
                        }
                    }(t, o)))
                }(t, this)
        }
    }(jQuery),
    function(e) {
        e(".back-to-top").click(function(t) {
            return t.preventDefault(), e("html, body").animate({
                scrollTop: 0
            }, 500), !1
        }), e(".menu-item-has-children a").click(function(e) {
            e.stopPropagation(), location.href = this.href
        }),e(".menu-item-has-children input").click(function(e) {
            e.stopPropagation();
        }),e(".menu-item-has-children button").click(function(e) {
            e.stopPropagation();
        }),e(".menu-item-has-children").click(function() {
            return e(this).addClass("toggled"), e(".menu-item-has-children").hasClass("toggled") && (e(this).children("ul").toggle(), e(".fly-nav-menu").getNiceScroll().resize()), e(this).toggleClass("tog-minus"), !1
        }), e(window).load(function() {
            e(".fly-nav-menu").niceScroll({
                cursorcolor: "#888",
                cursorwidth: 7,
                cursorborder: 0,
                zindex: 999999
            })
        }), e(".infinite-content").infinitescroll({
            navSelector: ".nav-links",
            nextSelector: ".nav-links a:first",
            itemSelector: ".infinite-post",
            loading: {
                msgText: "Loading more posts...",
                finishedMsg: "Sorry, no more posts"
            },
            errorCallback: function() {
                e(".inf-more-but").css("display", "none")
            }
        }), e(window).unbind(".infscr"), e(".inf-more-but").click(function() {
            return e(".infinite-content").infinitescroll("retrieve"), !1
        }), e(window).load(function() {
            e(".nav-links a").length ? e(".inf-more-but").css("display", "inline-block") : e(".inf-more-but").css("display", "none")
        }), e(window).load(function() {
            e(".post-gallery-bot").flexslider({
                animation: "slide",
                controlNav: !1,
                animationLoop: !0,
                slideshow: !1,
                itemWidth: 80,
                itemMargin: 10,
                asNavFor: ".post-gallery-top"
            }), e(".post-gallery-top").flexslider({
                animation: "fade",
                controlNav: !1,
                animationLoop: !0,
                slideshow: !1,
                prevText: "&lt;",
                nextText: "&gt;",
                sync: ".post-gallery-bot"
            })
        })
    }(jQuery);
