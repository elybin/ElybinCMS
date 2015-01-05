function FastClick(a) {
	"use strict";
	var b, c = this;
	if (this.trackingClick = !1, this.trackingClickStart = 0, this.targetElement = null, this.touchStartX = 0, this.touchStartY = 0, this.lastTouchIdentifier = 0, this.touchBoundary = 10, this.layer = a, !a || !a.nodeType) throw new TypeError("Layer must be a document node");
	this.onClick = function () {
		return FastClick.prototype.onClick.apply(c, arguments)
	}, this.onMouse = function () {
		return FastClick.prototype.onMouse.apply(c, arguments)
	}, this.onTouchStart = function () {
		return FastClick.prototype.onTouchStart.apply(c, arguments)
	}, this.onTouchMove = function () {
		return FastClick.prototype.onTouchMove.apply(c, arguments)
	}, this.onTouchEnd = function () {
		return FastClick.prototype.onTouchEnd.apply(c, arguments)
	}, this.onTouchCancel = function () {
		return FastClick.prototype.onTouchCancel.apply(c, arguments)
	}, FastClick.notNeeded(a) || (this.deviceIsAndroid && (a.addEventListener("mouseover", this.onMouse, !0), a.addEventListener("mousedown", this.onMouse, !0), a.addEventListener("mouseup", this.onMouse, !0)), a.addEventListener("click", this.onClick, !0), a.addEventListener("touchstart", this.onTouchStart, !1), a.addEventListener("touchmove", this.onTouchMove, !1), a.addEventListener("touchend", this.onTouchEnd, !1), a.addEventListener("touchcancel", this.onTouchCancel, !1), Event.prototype.stopImmediatePropagation || (a.removeEventListener = function (b, c, d) {
		var e = Node.prototype.removeEventListener;
		"click" === b ? e.call(a, b, c.hijacked || c, d) : e.call(a, b, c, d)
	}, a.addEventListener = function (b, c, d) {
		var e = Node.prototype.addEventListener;
		"click" === b ? e.call(a, b, c.hijacked || (c.hijacked = function (a) {
			a.propagationStopped || c(a)
		}), d) : e.call(a, b, c, d)
	}), "function" == typeof a.onclick && (b = a.onclick, a.addEventListener("click", function (a) {
		b(a)
	}, !1), a.onclick = null))
}
function Emitter(a) {
	return a ? mixin(a) : void 0
}
function mixin(a) {
	for (var b in Emitter.prototype) a[b] = Emitter.prototype[b];
	return a
}(function () {
	String.prototype.endsWith || (String.prototype.endsWith = function (a) {
		return -1 !== this.indexOf(a, this.length - a.length)
	}), String.prototype.trim || (String.prototype.trim = function () {
		return this.replace(/^\s+|\s+$/g, "")
	}), Array.prototype.indexOf || (Array.prototype.indexOf = function (a, b) {
		var c, d, e;
		if (void 0 === this || null === this) throw new TypeError('"this" is null or not defined');
		for (d = this.length >>> 0, b = +b || 0, 1 / 0 === Math.abs(b) && (b = 0), 0 > b && (b += d, 0 > b && (b = 0)), c = e = b; d >= b ? d > e : e > d; c = d >= b ? ++e : --e) if (this[c] === a) return c;
		return -1
	}), Function.prototype.bind || (Function.prototype.bind = function (a) {
		var b, c, d, e;
		if ("function" != typeof this) throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
		return b = Array.prototype.slice.call(arguments, 1), e = this, d = function () {}, c = function () {
			return e.apply(this instanceof d && a ? this : a, b.concat(Array.prototype.slice.call(arguments)))
		}, d.prototype = this.prototype, c.prototype = new d, c
	}), Object.keys || (Object.keys = function () {
		"use strict";
		var a, b, c;
		return c = Object.prototype.hasOwnProperty, b = {
			"toString": null
		}.propertyIsEnumerable("toString") ? !1 : !0, a = ["toString", "toLocaleString", "valueOf", "hasOwnProperty", "isPrototypeOf", "propertyIsEnumerable", "constructor"], function (d) {
			var e, f, g, h, i, j, k;
			if ("object" != typeof d && ("function" != typeof d || null === d)) throw new TypeError("Object.keys called on non-object");
			for (g = [], h = 0, j = d.length; j > h; h++) f = d[h], c.call(d, f) && g.push(f);
			if (b) for (i = 0, k = a.length; k > i; i++) e = a[i], c.call(d, e) && g.push(e);
			return g
		}
	}.call(this)), window.getScreenSize = function (a, b) {
		return a.is(":visible") ? "small" : b.is(":visible") ? "tablet" : "desktop"
	}, window.elHasClass = function (a, b) {
		return (" " + a.className + " ").indexOf(" " + b + " ") > -1
	}, window.elRemoveClass = function (a, b) {
		return a.className = (" " + a.className + " ").replace(" " + b + " ", " ").trim()
	}
}).call(this), 

function () {
	var a, b;
	b = {
		"is_mobile": !1,
		"resize_delay": 400,
		"stored_values_prefix": "pa_",
		"main_menu": {
			"accordion": !0,
			"animation_speed": 250,
			"store_state": !0,
			"store_state_key": "mmstate",
			"disable_animation_on": [],
			"dropdown_close_delay": 300,
			"detect_active": !0,
			"detect_active_predicate": function (a, b) {
				return a === b
			}
		},
		"consts": {
			"COLORS": ["#71c73e", "#77b7c5", "#d54848", "#6c42e5", "#e8e64e", "#dd56e6", "#ecad3f", "#618b9d", "#b68b68", "#36a766", "#3156be", "#00b3ff", "#646464", "#a946e8", "#9d9d9d"]
		}
	}, a = function () {
		return this.init = [], this.plugins = {}, this.settings = {}, this.localStorageSupported = "undefined" != typeof window.Storage ? !0 : !1, this
	}, a.prototype.start = function (a, c) {
		return null == a && (a = []), null == c && (c = {}), window.onload = function (d) {
			return function () {
				var e, f, g, h;
				for ($("html").addClass("pxajs"), a.length > 0 && $.merge(d.init, a), d.settings = $.extend(!0, {}, b, c || {}), d.settings.is_mobile = /iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()), d.settings.is_mobile && FastClick && FastClick.attach(document.body), h = d.init, f = 0, g = h.length; g > f; f++) e = h[f], $.proxy(e, d)();
				return $(window).trigger("pa.loaded"), $(window).resize()
			}
		}(this), this
	}, a.prototype.addInitializer = function (a) {
		return this.init.push(a)
	}, a.prototype.initPlugin = function (a, b) {
		return this.plugins[a] = b, b.init ? b.init() : void 0
	}, a.prototype.storeValue = function (a, b, c) {
		var d;
		if (null == c && (c = !1), this.localStorageSupported && !c) try {
			return void window.localStorage.setItem(this.settings.stored_values_prefix + a, b)
		} catch (e) {
			d = e
		}
		return document.cookie = this.settings.stored_values_prefix + a + "=" + escape(b)
	}, a.prototype.storeValues = function (a, b) {
		var c, d, e, f;
		if (null == b && (b = !1), this.localStorageSupported && !b) try {
			for (d in a) e = a[d], window.localStorage.setItem(this.settings.stored_values_prefix + d, e);
			return
		} catch (g) {
			c = g
		}
		f = [];
		for (d in a) e = a[d], f.push(document.cookie = this.settings.stored_values_prefix + d + "=" + escape(e));
		return f
	}, a.prototype.getStoredValue = function (a, b, c) {
		var d, e, f, g, h, i, j, k, l;
		if (null == b && (b = !1), null == c && (c = null), this.localStorageSupported && !b) try {
			return i = window.localStorage.getItem(this.settings.stored_values_prefix + a), i ? i : c
		} catch (m) {
			f = m
		}
		for (e = document.cookie.split(";"), k = 0, l = e.length; l > k; k++) if (d = e[k], h = d.indexOf("="), g = d.substr(0, h).replace(/^\s+|\s+$/g, ""), j = d.substr(h + 1).replace(/^\s+|\s+$/g, ""), g === this.settings.stored_values_prefix + a) return j;
		return c
	}, a.prototype.getStoredValues = function (a, b, c) {
		var d, e, f, g, h, i, j, k, l, m, n, o, p, q, r;
		for (null == b && (b = !1), null == c && (c = null), k = {}, m = 0, p = a.length; p > m; m++) h = a[m], k[h] = c;
		if (this.localStorageSupported && !b) try {
			for (n = 0, q = a.length; q > n; n++) h = a[n], j = window.localStorage.getItem(this.settings.stored_values_prefix + h), j && (k[h] = j);
			return k
		} catch (s) {
			f = s
		}
		for (e = document.cookie.split(";"), o = 0, r = e.length; r > o; o++) d = e[o], i = d.indexOf("="), g = d.substr(0, i).replace(/^\s+|\s+$/g, ""), l = d.substr(i + 1).replace(/^\s+|\s+$/g, ""), g === this.settings.stored_values_prefix + h && (k[h] = l);
		return k
	}, a.Constructor = a, window.PixelAdmin = new a
}.call(this), 
function () {
	/* PixelAdmin.settings */
	var a;
	a = function (a) {
		var b;
		return b = null, function () {
			return b && clearTimeout(b), b = setTimeout(function () {
				return b = null, a.call(this)
			}, PixelAdmin.settings.resize_delay)
		}
	}, PixelAdmin.addInitializer(function () {
		var b, c, d, e;
		return e = null, d = $(window), b = $('<div id="small-screen-width-point" style="position:absolute;top:-10000px;width:10px;height:10px;background:#fff;"></div>'), c = $('<div id="tablet-screen-width-point" style="position:absolute;top:-10000px;width:10px;height:10px;background:#fff;"></div>'), $("body").append(b).append(c), d.on("resize", a(function () {
			return d.trigger("pa.resize"), b.is(":visible") ? ("small" !== e && d.trigger("pa.screen.small"), e = "small") : c.is(":visible") ? ("tablet" !== e && d.trigger("pa.screen.tablet"), e = "tablet") : ("desktop" !== e && d.trigger("pa.screen.desktop"), e = "desktop")
		}))
	})
}.call(this), FastClick.prototype.deviceIsAndroid = navigator.userAgent.indexOf("Android") > 0, FastClick.prototype.deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent), FastClick.prototype.deviceIsIOS4 = FastClick.prototype.deviceIsIOS && /OS 4_\d(_\d)?/.test(navigator.userAgent), FastClick.prototype.deviceIsIOSWithBadTarget = FastClick.prototype.deviceIsIOS && /OS ([6-9]|\d{2})_\d/.test(navigator.userAgent), FastClick.prototype.needsClick = function (a) {
	"use strict";
	switch (a.nodeName.toLowerCase()) {
	case "button":
	case "select":
	case "textarea":
		if (a.disabled) return !0;
		break;
	case "input":
		if (this.deviceIsIOS && "file" === a.type || a.disabled) return !0;
		break;
	case "label":
	case "video":
		return !0
	}
	return /\bneedsclick\b/.test(a.className)
}, FastClick.prototype.needsFocus = function (a) {
	"use strict";
	switch (a.nodeName.toLowerCase()) {
	case "textarea":
		return !0;
	case "select":
		return !this.deviceIsAndroid;
	case "input":
		switch (a.type) {
		case "button":
		case "checkbox":
		case "file":
		case "image":
		case "radio":
		case "submit":
			return !1
		}
		return !a.disabled && !a.readOnly;
	default:
		return /\bneedsfocus\b/.test(a.className)
	}
}, FastClick.prototype.sendClick = function (a, b) {
	"use strict";
	var c, d;
	document.activeElement && document.activeElement !== a && document.activeElement.blur(), d = b.changedTouches[0], c = document.createEvent("MouseEvents"), c.initMouseEvent(this.determineEventType(a), !0, !0, window, 1, d.screenX, d.screenY, d.clientX, d.clientY, !1, !1, !1, !1, 0, null), c.forwardedTouchEvent = !0, a.dispatchEvent(c)
}, FastClick.prototype.determineEventType = function (a) {
	"use strict";
	return this.deviceIsAndroid && "select" === a.tagName.toLowerCase() ? "mousedown" : "click"
}, FastClick.prototype.focus = function (a) {
	"use strict";
	var b;
	this.deviceIsIOS && a.setSelectionRange && 0 !== a.type.indexOf("date") && "time" !== a.type ? (b = a.value.length, a.setSelectionRange(b, b)) : a.focus()
}, FastClick.prototype.updateScrollParent = function (a) {
	"use strict";
	var b, c;
	if (b = a.fastClickScrollParent, !b || !b.contains(a)) {
		c = a;
		do {
			if (c.scrollHeight > c.offsetHeight) {
				b = c, a.fastClickScrollParent = c;
				break
			}
			c = c.parentElement
		} while (c)
	}
	b && (b.fastClickLastScrollTop = b.scrollTop)
}, FastClick.prototype.getTargetElementFromEventTarget = function (a) {
	"use strict";
	return a.nodeType === Node.TEXT_NODE ? a.parentNode : a
}, FastClick.prototype.onTouchStart = function (a) {
	"use strict";
	var b, c, d;
	if (a.targetTouches.length > 1) return !0;
	if (b = this.getTargetElementFromEventTarget(a.target), c = a.targetTouches[0], this.deviceIsIOS) {
		if (d = window.getSelection(), d.rangeCount && !d.isCollapsed) return !0;
		if (!this.deviceIsIOS4) {
			if (c.identifier === this.lastTouchIdentifier) return a.preventDefault(), !1;
			this.lastTouchIdentifier = c.identifier, this.updateScrollParent(b)
		}
	}
	return this.trackingClick = !0, this.trackingClickStart = a.timeStamp, this.targetElement = b, this.touchStartX = c.pageX, this.touchStartY = c.pageY, a.timeStamp - this.lastClickTime < 200 && a.preventDefault(), !0
}, FastClick.prototype.touchHasMoved = function (a) {
	"use strict";
	var b = a.changedTouches[0],
		c = this.touchBoundary;
	return Math.abs(b.pageX - this.touchStartX) > c || Math.abs(b.pageY - this.touchStartY) > c ? !0 : !1
}, FastClick.prototype.onTouchMove = function (a) {
	"use strict";
	return this.trackingClick ? ((this.targetElement !== this.getTargetElementFromEventTarget(a.target) || this.touchHasMoved(a)) && (this.trackingClick = !1, this.targetElement = null), !0) : !0
}, FastClick.prototype.findControl = function (a) {
	"use strict";
	return void 0 !== a.control ? a.control : a.htmlFor ? document.getElementById(a.htmlFor) : a.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")
}, FastClick.prototype.onTouchEnd = function (a) {
	"use strict";
	var b, c, d, e, f, g = this.targetElement;
	if (!this.trackingClick) return !0;
	if (a.timeStamp - this.lastClickTime < 200) return this.cancelNextClick = !0, !0;
	if (this.cancelNextClick = !1, this.lastClickTime = a.timeStamp, c = this.trackingClickStart, this.trackingClick = !1, this.trackingClickStart = 0, this.deviceIsIOSWithBadTarget && (f = a.changedTouches[0], g = document.elementFromPoint(f.pageX - window.pageXOffset, f.pageY - window.pageYOffset) || g, g.fastClickScrollParent = this.targetElement.fastClickScrollParent), d = g.tagName.toLowerCase(), "label" === d) {
		if (b = this.findControl(g)) {
			if (this.focus(g), this.deviceIsAndroid) return !1;
			g = b
		}
	} else if (this.needsFocus(g)) return a.timeStamp - c > 100 || this.deviceIsIOS && window.top !== window && "input" === d ? (this.targetElement = null, !1) : (this.focus(g), this.deviceIsIOS4 && "select" === d || (this.targetElement = null, a.preventDefault()), !1);
	return this.deviceIsIOS && !this.deviceIsIOS4 && (e = g.fastClickScrollParent, e && e.fastClickLastScrollTop !== e.scrollTop) ? !0 : (this.needsClick(g) || (a.preventDefault(), this.sendClick(g, a)), !1)
}, FastClick.prototype.onTouchCancel = function () {
	"use strict";
	this.trackingClick = !1, this.targetElement = null
}, FastClick.prototype.onMouse = function (a) {
	"use strict";
	return this.targetElement ? a.forwardedTouchEvent ? !0 : a.cancelable && (!this.needsClick(this.targetElement) || this.cancelNextClick) ? (a.stopImmediatePropagation ? a.stopImmediatePropagation() : a.propagationStopped = !0, a.stopPropagation(), a.preventDefault(), !1) : !0 : !0
}, FastClick.prototype.onClick = function (a) {
	"use strict";
	var b;
	return this.trackingClick ? (this.targetElement = null, this.trackingClick = !1, !0) : "submit" === a.target.type && 0 === a.detail ? !0 : (b = this.onMouse(a), b || (this.targetElement = null), b)
}, FastClick.prototype.destroy = function () {
	"use strict";
	var a = this.layer;
	this.deviceIsAndroid && (a.removeEventListener("mouseover", this.onMouse, !0), a.removeEventListener("mousedown", this.onMouse, !0), a.removeEventListener("mouseup", this.onMouse, !0)), a.removeEventListener("click", this.onClick, !0), a.removeEventListener("touchstart", this.onTouchStart, !1), a.removeEventListener("touchmove", this.onTouchMove, !1), a.removeEventListener("touchend", this.onTouchEnd, !1), a.removeEventListener("touchcancel", this.onTouchCancel, !1)
}, FastClick.notNeeded = function (a) {
	"use strict";
	var b, c;
	if ("undefined" == typeof window.ontouchstart) return !0;
	if (c = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1]) {
		if (!FastClick.prototype.deviceIsAndroid) return !0;
		if (b = document.querySelector("meta[name=viewport]")) {
			if (-1 !== b.content.indexOf("user-scalable=no")) return !0;
			if (c > 31 && window.innerWidth <= window.screen.width) return !0
		}
	}
	return "none" === a.style.msTouchAction ? !0 : !1
}, FastClick.attach = function (a) {
	"use strict";
	return new FastClick(a)
}, "undefined" != typeof define && define.amd ? define(function () {
	"use strict";
	return FastClick
}) : "undefined" != typeof module && module.exports ? (module.exports = FastClick.attach, module.exports.FastClick = FastClick) : window.FastClick = FastClick, function (a, b, c) {
	"use strict";
	var d = {
		"filterId": 0
	},
		e = function (e, f) {
			var g = {
				"intensity": 5,
				"forceSVGUrl": !1
			},
				h = c.extend(g, f);
			this.$elm = e instanceof c ? e : c(e);
			var i = !1,
				j = " -webkit- -moz- -o- -ms- ".split(" "),
				k = {},
				l = function (a) {
					if (k[a] || "" === k[a]) return k[a] + a;
					var c = b.createElement("div"),
						d = ["", "Moz", "Webkit", "O", "ms", "Khtml"];
					for (var e in d) if ("undefined" != typeof c.style[d[e] + a]) return k[a] = d[e], d[e] + a;
					return a.toLowerCase()
				},
				m = function () {
					var a = b.createElement("div");
					return a.style.cssText = j.join("filter:blur(2px); "), !! a.style.length && (void 0 === b.documentMode || b.documentMode > 9)
				}(),
				n = function () {
					var a = !1;
					try {
						a = void 0 !== typeof SVGFEColorMatrixElement && 2 == SVGFEColorMatrixElement.SVG_FECOLORMATRIX_TYPE_SATURATE
					} catch (b) {}
					return a
				}(),
				o = function () {
					var a = "<svg id='vague-svg-blur' style='position:absolute;' width='0' height='0' ><filter id='blur-effect-id-" + d.filterId + "'><feGaussianBlur stdDeviation='" + h.intensity + "' /></filter></svg>";
					c("body").append(a)
				};
			return this.init = function () {
				n && o(), this.$elm.data("vague-filter-id", d.filterId), d.filterId++
			}, this.blur = function () {
				var b, c = a.location,
					d = h.forceSVGUrl ? c.protocol + "//" + c.host + c.pathname : "",
					e = this.$elm.data("vague-filter-id"),
					f = {};
				b = m ? "blur(" + h.intensity + "px)" : n ? "url(" + d + "#blur-effect-id-" + e + ")" : "progid:DXImageTransform.Microsoft.Blur(pixelradius=" + h.intensity + ")", f[l("Filter")] = b, this.$elm.css(f), i = !0
			}, this.unblur = function () {
				var a = {};
				a[l("Filter")] = "none", this.$elm.css(a), i = !1
			}, this.toggleblur = function () {
				i ? this.unblur() : this.blur()
			}, this.destroy = function () {
				n && c("filter#blur-effect-id-" + this.$elm.data("vague-filter-id")).parent().remove(), this.unblur()
			}, this.init()
		};
	c.fn.Vague = function (a) {
		return new e(this, a)
	}, a.Vague = e
}(window, document, jQuery), function (a) {
	"undefined" == typeof a.fn.each2 && a.extend(a.fn, {
		"each2": function (b) {
			for (var c = a([0]), d = -1, e = this.length; ++d < e && (c.context = c[0] = this[d]) && b.call(c[0], d, c) !== !1;);
			return this
		}
	})
}(jQuery), function (a, b) {}(jQuery), 
function (a, b) {
	function c(b, c) {
		var e, f, g, h = b.nodeName.toLowerCase();
		return "area" === h ? (e = b.parentNode, f = e.name, b.href && f && "map" === e.nodeName.toLowerCase() ? (g = a("img[usemap=#" + f + "]")[0], !! g && d(g)) : !1) : (/input|select|textarea|button|object/.test(h) ? !b.disabled : "a" === h ? b.href || c : c) && d(b)
	}
	function d(b) {
		return a.expr.filters.visible(b) && !a(b).parents().addBack().filter(function () {
			return "hidden" === a.css(this, "visibility")
		}).length
	}
	var e = 0,
		f = /^ui-id-\d+$/;
	a.ui = a.ui || {}, a.extend(a.ui, {
		"version": "1.10.4",
		"keyCode": {
			"BACKSPACE": 8,
			"COMMA": 188,
			"DELETE": 46,
			"DOWN": 40,
			"END": 35,
			"ENTER": 13,
			"ESCAPE": 27,
			"HOME": 36,
			"LEFT": 37,
			"NUMPAD_ADD": 107,
			"NUMPAD_DECIMAL": 110,
			"NUMPAD_DIVIDE": 111,
			"NUMPAD_ENTER": 108,
			"NUMPAD_MULTIPLY": 106,
			"NUMPAD_SUBTRACT": 109,
			"PAGE_DOWN": 34,
			"PAGE_UP": 33,
			"PERIOD": 190,
			"RIGHT": 39,
			"SPACE": 32,
			"TAB": 9,
			"UP": 38
		}
	}), a.fn.extend({
		"focus": function (b) {
			return function (c, d) {
				return "number" == typeof c ? this.each(function () {
					var b = this;
					setTimeout(function () {
						a(b).focus(), d && d.call(b)
					}, c)
				}) : b.apply(this, arguments)
			}
		}(a.fn.focus),
		"scrollParent": function () {
			var b;
			return b = a.ui.ie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? this.parents().filter(function () {
				return /(relative|absolute|fixed)/.test(a.css(this, "position")) && /(auto|scroll)/.test(a.css(this, "overflow") + a.css(this, "overflow-y") + a.css(this, "overflow-x"))
			}).eq(0) : this.parents().filter(function () {
				return /(auto|scroll)/.test(a.css(this, "overflow") + a.css(this, "overflow-y") + a.css(this, "overflow-x"))
			}).eq(0), /fixed/.test(this.css("position")) || !b.length ? a(document) : b
		},
		"zIndex": function (c) {
			if (c !== b) return this.css("zIndex", c);
			if (this.length) for (var d, e, f = a(this[0]); f.length && f[0] !== document;) {
				if (d = f.css("position"), ("absolute" === d || "relative" === d || "fixed" === d) && (e = parseInt(f.css("zIndex"), 10), !isNaN(e) && 0 !== e)) return e;
				f = f.parent()
			}
			return 0
		},
		"uniqueId": function () {
			return this.each(function () {
				this.id || (this.id = "ui-id-" + ++e)
			})
		},
		"removeUniqueId": function () {
			return this.each(function () {
				f.test(this.id) && a(this).removeAttr("id")
			})
		}
	}), a.extend(a.expr[":"], {
		"data": a.expr.createPseudo ? a.expr.createPseudo(function (b) {
			return function (c) {
				return !!a.data(c, b)
			}
		}) : function (b, c, d) {
			return !!a.data(b, d[3])
		},
		"focusable": function (b) {
			return c(b, !isNaN(a.attr(b, "tabindex")))
		},
		"tabbable": function (b) {
			var d = a.attr(b, "tabindex"),
				e = isNaN(d);
			return (e || d >= 0) && c(b, !e)
		}
	}), a("<a>").outerWidth(1).jquery || a.each(["Width", "Height"], function (c, d) {
		function e(b, c, d, e) {
			return a.each(f, function () {
				c -= parseFloat(a.css(b, "padding" + this)) || 0, d && (c -= parseFloat(a.css(b, "border" + this + "Width")) || 0), e && (c -= parseFloat(a.css(b, "margin" + this)) || 0)
			}), c
		}
		var f = "Width" === d ? ["Left", "Right"] : ["Top", "Bottom"],
			g = d.toLowerCase(),
			h = {
				"innerWidth": a.fn.innerWidth,
				"innerHeight": a.fn.innerHeight,
				"outerWidth": a.fn.outerWidth,
				"outerHeight": a.fn.outerHeight
			};
		a.fn["inner" + d] = function (c) {
			return c === b ? h["inner" + d].call(this) : this.each(function () {
				a(this).css(g, e(this, c) + "px")
			})
		}, a.fn["outer" + d] = function (b, c) {
			return "number" != typeof b ? h["outer" + d].call(this, b) : this.each(function () {
				a(this).css(g, e(this, b, !0, c) + "px")
			})
		}
	}), a.fn.addBack || (a.fn.addBack = function (a) {
		return this.add(null == a ? this.prevObject : this.prevObject.filter(a))
	}), a("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (a.fn.removeData = function (b) {
		return function (c) {
			return arguments.length ? b.call(this, a.camelCase(c)) : b.call(this)
		}
	}(a.fn.removeData)), a.ui.ie = !! /msie [\w.]+/.exec(navigator.userAgent.toLowerCase()), a.support.selectstart = "onselectstart" in document.createElement("div"), a.fn.extend({
		"disableSelection": function () {
			return this.bind((a.support.selectstart ? "selectstart" : "mousedown") + ".ui-disableSelection", function (a) {
				a.preventDefault()
			})
		},
		"enableSelection": function () {
			return this.unbind(".ui-disableSelection")
		}
	}), a.extend(a.ui, {
		"plugin": {
			"add": function (b, c, d) {
				var e, f = a.ui[b].prototype;
				for (e in d) f.plugins[e] = f.plugins[e] || [], f.plugins[e].push([c, d[e]])
			},
			"call": function (a, b, c) {
				var d, e = a.plugins[b];
				if (e && a.element[0].parentNode && 11 !== a.element[0].parentNode.nodeType) for (d = 0; d < e.length; d++) a.options[e[d][0]] && e[d][1].apply(a.element, c)
			}
		},
		"hasScroll": function (b, c) {
			if ("hidden" === a(b).css("overflow")) return !1;
			var d = c && "left" === c ? "scrollLeft" : "scrollTop",
				e = !1;
			return b[d] > 0 ? !0 : (b[d] = 1, e = b[d] > 0, b[d] = 0, e)
		}
	})
}(jQuery), function (a, b) {
	var c = 0,
		d = Array.prototype.slice,
		e = a.cleanData;
	a.cleanData = function (b) {
		for (var c, d = 0; null != (c = b[d]); d++) try {
			a(c).triggerHandler("remove")
		} catch (f) {}
		e(b)
	}, a.widget = function (b, c, d) {
		var e, f, g, h, i = {},
			j = b.split(".")[0];
		b = b.split(".")[1], e = j + "-" + b, d || (d = c, c = a.Widget), a.expr[":"][e.toLowerCase()] = function (b) {
			return !!a.data(b, e)
		}, a[j] = a[j] || {}, f = a[j][b], g = a[j][b] = function (a, b) {
			return this._createWidget ? void(arguments.length && this._createWidget(a, b)) : new g(a, b)
		}, a.extend(g, f, {
			"version": d.version,
			"_proto": a.extend({}, d),
			"_childConstructors": []
		}), h = new c, h.options = a.widget.extend({}, h.options), a.each(d, function (b, d) {
			return a.isFunction(d) ? void(i[b] = function () {
				var a = function () {
					return c.prototype[b].apply(this, arguments)
				},
					e = function (a) {
						return c.prototype[b].apply(this, a)
					};
				return function () {
					var b, c = this._super,
						f = this._superApply;
					return this._super = a, this._superApply = e, b = d.apply(this, arguments), this._super = c, this._superApply = f, b
				}
			}()) : void(i[b] = d)
		}), g.prototype = a.widget.extend(h, {
			"widgetEventPrefix": f ? h.widgetEventPrefix || b : b
		}, i, {
			"constructor": g,
			"namespace": j,
			"widgetName": b,
			"widgetFullName": e
		}), f ? (a.each(f._childConstructors, function (b, c) {
			var d = c.prototype;
			a.widget(d.namespace + "." + d.widgetName, g, c._proto)
		}), delete f._childConstructors) : c._childConstructors.push(g), a.widget.bridge(b, g)
	}, a.widget.extend = function (c) {
		for (var e, f, g = d.call(arguments, 1), h = 0, i = g.length; i > h; h++) for (e in g[h]) f = g[h][e], g[h].hasOwnProperty(e) && f !== b && (c[e] = a.isPlainObject(f) ? a.isPlainObject(c[e]) ? a.widget.extend({}, c[e], f) : a.widget.extend({}, f) : f);
		return c
	}, a.widget.bridge = function (c, e) {
		var f = e.prototype.widgetFullName || c;
		a.fn[c] = function (g) {
			var h = "string" == typeof g,
				i = d.call(arguments, 1),
				j = this;
			return g = !h && i.length ? a.widget.extend.apply(null, [g].concat(i)) : g, this.each(h ?
			function () {
				var d, e = a.data(this, f);
				return e ? a.isFunction(e[g]) && "_" !== g.charAt(0) ? (d = e[g].apply(e, i), d !== e && d !== b ? (j = d && d.jquery ? j.pushStack(d.get()) : d, !1) : void 0) : a.error("no such method '" + g + "' for " + c + " widget instance") : a.error("cannot call methods on " + c + " prior to initialization; attempted to call method '" + g + "'")
			} : function () {
				var b = a.data(this, f);
				b ? b.option(g || {})._init() : a.data(this, f, new e(g, this))
			}), j
		}
	}, a.Widget = function () {}, a.Widget._childConstructors = [], a.Widget.prototype = {
		"widgetName": "widget",
		"widgetEventPrefix": "",
		"defaultElement": "<div>",
		"options": {
			"disabled": !1,
			"create": null
		},
		"_createWidget": function (b, d) {
			d = a(d || this.defaultElement || this)[0], this.element = a(d), this.uuid = c++, this.eventNamespace = "." + this.widgetName + this.uuid, this.options = a.widget.extend({}, this.options, this._getCreateOptions(), b), this.bindings = a(), this.hoverable = a(), this.focusable = a(), d !== this && (a.data(d, this.widgetFullName, this), this._on(!0, this.element, {
				"remove": function (a) {
					a.target === d && this.destroy()
				}
			}), this.document = a(d.style ? d.ownerDocument : d.document || d), this.window = a(this.document[0].defaultView || this.document[0].parentWindow)), this._create(), this._trigger("create", null, this._getCreateEventData()), this._init()
		},
		"_getCreateOptions": a.noop,
		"_getCreateEventData": a.noop,
		"_create": a.noop,
		"_init": a.noop,
		"destroy": function () {
			this._destroy(), this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(a.camelCase(this.widgetFullName)), this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled ui-state-disabled"), this.bindings.unbind(this.eventNamespace), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")
		},
		"_destroy": a.noop,
		"widget": function () {
			return this.element
		},
		"option": function (c, d) {
			var e, f, g, h = c;
			if (0 === arguments.length) return a.widget.extend({}, this.options);
			if ("string" == typeof c) if (h = {}, e = c.split("."), c = e.shift(), e.length) {
				for (f = h[c] = a.widget.extend({}, this.options[c]), g = 0; g < e.length - 1; g++) f[e[g]] = f[e[g]] || {}, f = f[e[g]];
				if (c = e.pop(), 1 === arguments.length) return f[c] === b ? null : f[c];
				f[c] = d
			} else {
				if (1 === arguments.length) return this.options[c] === b ? null : this.options[c];
				h[c] = d
			}
			return this._setOptions(h), this
		},
		"_setOptions": function (a) {
			var b;
			for (b in a) this._setOption(b, a[b]);
			return this
		},
		"_setOption": function (a, b) {
			return this.options[a] = b, "disabled" === a && (this.widget().toggleClass(this.widgetFullName + "-disabled ui-state-disabled", !! b).attr("aria-disabled", b), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")), this
		},
		"enable": function () {
			return this._setOption("disabled", !1)
		},
		"disable": function () {
			return this._setOption("disabled", !0)
		},
		"_on": function (b, c, d) {
			var e, f = this;
			"boolean" != typeof b && (d = c, c = b, b = !1), d ? (c = e = a(c), this.bindings = this.bindings.add(c)) : (d = c, c = this.element, e = this.widget()), a.each(d, function (d, g) {
				function h() {
					return b || f.options.disabled !== !0 && !a(this).hasClass("ui-state-disabled") ? ("string" == typeof g ? f[g] : g).apply(f, arguments) : void 0
				}
				"string" != typeof g && (h.guid = g.guid = g.guid || h.guid || a.guid++);
				var i = d.match(/^(\w+)\s*(.*)$/),
					j = i[1] + f.eventNamespace,
					k = i[2];
				k ? e.delegate(k, j, h) : c.bind(j, h)
			})
		},
		"_off": function (a, b) {
			b = (b || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace, a.unbind(b).undelegate(b)
		},
		"_delay": function (a, b) {
			function c() {
				return ("string" == typeof a ? d[a] : a).apply(d, arguments)
			}
			var d = this;
			return setTimeout(c, b || 0)
		},
		"_hoverable": function (b) {
			this.hoverable = this.hoverable.add(b), this._on(b, {
				"mouseenter": function (b) {
					a(b.currentTarget).addClass("ui-state-hover")
				},
				"mouseleave": function (b) {
					a(b.currentTarget).removeClass("ui-state-hover")
				}
			})
		},
		"_focusable": function (b) {
			this.focusable = this.focusable.add(b), this._on(b, {
				"focusin": function (b) {
					a(b.currentTarget).addClass("ui-state-focus")
				},
				"focusout": function (b) {
					a(b.currentTarget).removeClass("ui-state-focus")
				}
			})
		},
		"_trigger": function (b, c, d) {
			var e, f, g = this.options[b];
			if (d = d || {}, c = a.Event(c), c.type = (b === this.widgetEventPrefix ? b : this.widgetEventPrefix + b).toLowerCase(), c.target = this.element[0], f = c.originalEvent) for (e in f) e in c || (c[e] = f[e]);
			return this.element.trigger(c, d), !(a.isFunction(g) && g.apply(this.element[0], [c].concat(d)) === !1 || c.isDefaultPrevented())
		}
	}, a.each({
		"show": "fadeIn",
		"hide": "fadeOut"
	}, function (b, c) {
		a.Widget.prototype["_" + b] = function (d, e, f) {
			"string" == typeof e && (e = {
				"effect": e
			});
			var g, h = e ? e === !0 || "number" == typeof e ? c : e.effect || c : b;
			e = e || {}, "number" == typeof e && (e = {
				"duration": e
			}), g = !a.isEmptyObject(e), e.complete = f, e.delay && d.delay(e.delay), g && a.effects && a.effects.effect[h] ? d[b](e) : h !== b && d[h] ? d[h](e.duration, e.easing, f) : d.queue(function (c) {
				a(this)[b](), f && f.call(d[0]), c()
			})
		}
	})
}(jQuery), function (a) {
	var b = !1;
	a(document).mouseup(function () {
		b = !1
	}), a.widget("ui.mouse", {
		"version": "1.10.4",
		"options": {
			"cancel": "input,textarea,button,select,option",
			"distance": 1,
			"delay": 0
		},
		"_mouseInit": function () {
			var b = this;
			this.element.bind("mousedown." + this.widgetName, function (a) {
				return b._mouseDown(a)
			}).bind("click." + this.widgetName, function (c) {
				return !0 === a.data(c.target, b.widgetName + ".preventClickEvent") ? (a.removeData(c.target, b.widgetName + ".preventClickEvent"), c.stopImmediatePropagation(), !1) : void 0
			}), this.started = !1
		},
		"_mouseDestroy": function () {
			this.element.unbind("." + this.widgetName), this._mouseMoveDelegate && a(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
		},
		"_mouseDown": function (c) {
			if (!b) {
				this._mouseStarted && this._mouseUp(c), this._mouseDownEvent = c;
				var d = this,
					e = 1 === c.which,
					f = "string" == typeof this.options.cancel && c.target.nodeName ? a(c.target).closest(this.options.cancel).length : !1;
				return e && !f && this._mouseCapture(c) ? (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
					d.mouseDelayMet = !0
				}, this.options.delay)), this._mouseDistanceMet(c) && this._mouseDelayMet(c) && (this._mouseStarted = this._mouseStart(c) !== !1, !this._mouseStarted) ? (c.preventDefault(), !0) : (!0 === a.data(c.target, this.widgetName + ".preventClickEvent") && a.removeData(c.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (a) {
					return d._mouseMove(a)
				}, this._mouseUpDelegate = function (a) {
					return d._mouseUp(a)
				}, a(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), c.preventDefault(), b = !0, !0)) : !0
			}
		},
		"_mouseMove": function (b) {
			return a.ui.ie && (!document.documentMode || document.documentMode < 9) && !b.button ? this._mouseUp(b) : this._mouseStarted ? (this._mouseDrag(b), b.preventDefault()) : (this._mouseDistanceMet(b) && this._mouseDelayMet(b) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, b) !== !1, this._mouseStarted ? this._mouseDrag(b) : this._mouseUp(b)), !this._mouseStarted)
		},
		"_mouseUp": function (b) {
			return a(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, b.target === this._mouseDownEvent.target && a.data(b.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(b)), !1
		},
		"_mouseDistanceMet": function (a) {
			return Math.max(Math.abs(this._mouseDownEvent.pageX - a.pageX), Math.abs(this._mouseDownEvent.pageY - a.pageY)) >= this.options.distance
		},
		"_mouseDelayMet": function () {
			return this.mouseDelayMet
		},
		"_mouseStart": function () {},
		"_mouseDrag": function () {},
		"_mouseStop": function () {},
		"_mouseCapture": function () {
			return !0
		}
	})
}(jQuery), function (a, b) {
	function c(a, b, c) {
		return [parseFloat(a[0]) * (n.test(a[0]) ? b / 100 : 1), parseFloat(a[1]) * (n.test(a[1]) ? c / 100 : 1)]
	}
	function d(b, c) {
		return parseInt(a.css(b, c), 10) || 0
	}
	function e(b) {
		var c = b[0];
		return 9 === c.nodeType ? {
			"width": b.width(),
			"height": b.height(),
			"offset": {
				"top": 0,
				"left": 0
			}
		} : a.isWindow(c) ? {
			"width": b.width(),
			"height": b.height(),
			"offset": {
				"top": b.scrollTop(),
				"left": b.scrollLeft()
			}
		} : c.preventDefault ? {
			"width": 0,
			"height": 0,
			"offset": {
				"top": c.pageY,
				"left": c.pageX
			}
		} : {
			"width": b.outerWidth(),
			"height": b.outerHeight(),
			"offset": b.offset()
		}
	}
	a.ui = a.ui || {};
	var f, g = Math.max,
		h = Math.abs,
		i = Math.round,
		j = /left|center|right/,
		k = /top|center|bottom/,
		l = /[\+\-]\d+(\.[\d]+)?%?/,
		m = /^\w+/,
		n = /%$/,
		o = a.fn.position;
	a.position = {
		"scrollbarWidth": function () {
			if (f !== b) return f;
			var c, d, e = a("<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"),
				g = e.children()[0];
			return a("body").append(e), c = g.offsetWidth, e.css("overflow", "scroll"), d = g.offsetWidth, c === d && (d = e[0].clientWidth), e.remove(), f = c - d
		},
		"getScrollInfo": function (b) {
			var c = b.isWindow || b.isDocument ? "" : b.element.css("overflow-x"),
				d = b.isWindow || b.isDocument ? "" : b.element.css("overflow-y"),
				e = "scroll" === c || "auto" === c && b.width < b.element[0].scrollWidth,
				f = "scroll" === d || "auto" === d && b.height < b.element[0].scrollHeight;
			return {
				"width": f ? a.position.scrollbarWidth() : 0,
				"height": e ? a.position.scrollbarWidth() : 0
			}
		},
		"getWithinInfo": function (b) {
			var c = a(b || window),
				d = a.isWindow(c[0]),
				e = !! c[0] && 9 === c[0].nodeType;
			return {
				"element": c,
				"isWindow": d,
				"isDocument": e,
				"offset": c.offset() || {
					"left": 0,
					"top": 0
				},
				"scrollLeft": c.scrollLeft(),
				"scrollTop": c.scrollTop(),
				"width": d ? c.width() : c.outerWidth(),
				"height": d ? c.height() : c.outerHeight()
			}
		}
	}, a.fn.position = function (b) {
		if (!b || !b.of) return o.apply(this, arguments);
		b = a.extend({}, b);
		var f, n, p, q, r, s, t = a(b.of),
			u = a.position.getWithinInfo(b.within),
			v = a.position.getScrollInfo(u),
			w = (b.collision || "flip").split(" "),
			x = {};
		return s = e(t), t[0].preventDefault && (b.at = "left top"), n = s.width, p = s.height, q = s.offset, r = a.extend({}, q), a.each(["my", "at"], function () {
			var a, c, d = (b[this] || "").split(" ");
			1 === d.length && (d = j.test(d[0]) ? d.concat(["center"]) : k.test(d[0]) ? ["center"].concat(d) : ["center", "center"]), d[0] = j.test(d[0]) ? d[0] : "center", d[1] = k.test(d[1]) ? d[1] : "center", a = l.exec(d[0]), c = l.exec(d[1]), x[this] = [a ? a[0] : 0, c ? c[0] : 0], b[this] = [m.exec(d[0])[0], m.exec(d[1])[0]]
		}), 1 === w.length && (w[1] = w[0]), "right" === b.at[0] ? r.left += n : "center" === b.at[0] && (r.left += n / 2), "bottom" === b.at[1] ? r.top += p : "center" === b.at[1] && (r.top += p / 2), f = c(x.at, n, p), r.left += f[0], r.top += f[1], this.each(function () {
			var e, j, k = a(this),
				l = k.outerWidth(),
				m = k.outerHeight(),
				o = d(this, "marginLeft"),
				s = d(this, "marginTop"),
				y = l + o + d(this, "marginRight") + v.width,
				z = m + s + d(this, "marginBottom") + v.height,
				A = a.extend({}, r),
				B = c(x.my, k.outerWidth(), k.outerHeight());
			"right" === b.my[0] ? A.left -= l : "center" === b.my[0] && (A.left -= l / 2), "bottom" === b.my[1] ? A.top -= m : "center" === b.my[1] && (A.top -= m / 2), A.left += B[0], A.top += B[1], a.support.offsetFractions || (A.left = i(A.left), A.top = i(A.top)), e = {
				"marginLeft": o,
				"marginTop": s
			}, a.each(["left", "top"], function (c, d) {
				a.ui.position[w[c]] && a.ui.position[w[c]][d](A, {
					"targetWidth": n,
					"targetHeight": p,
					"elemWidth": l,
					"elemHeight": m,
					"collisionPosition": e,
					"collisionWidth": y,
					"collisionHeight": z,
					"offset": [f[0] + B[0], f[1] + B[1]],
					"my": b.my,
					"at": b.at,
					"within": u,
					"elem": k
				})
			}), b.using && (j = function (a) {
				var c = q.left - A.left,
					d = c + n - l,
					e = q.top - A.top,
					f = e + p - m,
					i = {
						"target": {
							"element": t,
							"left": q.left,
							"top": q.top,
							"width": n,
							"height": p
						},
						"element": {
							"element": k,
							"left": A.left,
							"top": A.top,
							"width": l,
							"height": m
						},
						"horizontal": 0 > d ? "left" : c > 0 ? "right" : "center",
						"vertical": 0 > f ? "top" : e > 0 ? "bottom" : "middle"
					};
				l > n && h(c + d) < n && (i.horizontal = "center"), m > p && h(e + f) < p && (i.vertical = "middle"), i.important = g(h(c), h(d)) > g(h(e), h(f)) ? "horizontal" : "vertical", b.using.call(this, a, i)
			}), k.offset(a.extend(A, {
				"using": j
			}))
		})
	}, a.ui.position = {
		"fit": {
			"left": function (a, b) {
				var c, d = b.within,
					e = d.isWindow ? d.scrollLeft : d.offset.left,
					f = d.width,
					h = a.left - b.collisionPosition.marginLeft,
					i = e - h,
					j = h + b.collisionWidth - f - e;
				b.collisionWidth > f ? i > 0 && 0 >= j ? (c = a.left + i + b.collisionWidth - f - e, a.left += i - c) : a.left = j > 0 && 0 >= i ? e : i > j ? e + f - b.collisionWidth : e : i > 0 ? a.left += i : j > 0 ? a.left -= j : a.left = g(a.left - h, a.left)
			},
			"top": function (a, b) {
				var c, d = b.within,
					e = d.isWindow ? d.scrollTop : d.offset.top,
					f = b.within.height,
					h = a.top - b.collisionPosition.marginTop,
					i = e - h,
					j = h + b.collisionHeight - f - e;
				b.collisionHeight > f ? i > 0 && 0 >= j ? (c = a.top + i + b.collisionHeight - f - e, a.top += i - c) : a.top = j > 0 && 0 >= i ? e : i > j ? e + f - b.collisionHeight : e : i > 0 ? a.top += i : j > 0 ? a.top -= j : a.top = g(a.top - h, a.top)
			}
		},
		"flip": {
			"left": function (a, b) {
				var c, d, e = b.within,
					f = e.offset.left + e.scrollLeft,
					g = e.width,
					i = e.isWindow ? e.scrollLeft : e.offset.left,
					j = a.left - b.collisionPosition.marginLeft,
					k = j - i,
					l = j + b.collisionWidth - g - i,
					m = "left" === b.my[0] ? -b.elemWidth : "right" === b.my[0] ? b.elemWidth : 0,
					n = "left" === b.at[0] ? b.targetWidth : "right" === b.at[0] ? -b.targetWidth : 0,
					o = -2 * b.offset[0];
				0 > k ? (c = a.left + m + n + o + b.collisionWidth - g - f, (0 > c || c < h(k)) && (a.left += m + n + o)) : l > 0 && (d = a.left - b.collisionPosition.marginLeft + m + n + o - i, (d > 0 || h(d) < l) && (a.left += m + n + o))
			},
			"top": function (a, b) {
				var c, d, e = b.within,
					f = e.offset.top + e.scrollTop,
					g = e.height,
					i = e.isWindow ? e.scrollTop : e.offset.top,
					j = a.top - b.collisionPosition.marginTop,
					k = j - i,
					l = j + b.collisionHeight - g - i,
					m = "top" === b.my[1],
					n = m ? -b.elemHeight : "bottom" === b.my[1] ? b.elemHeight : 0,
					o = "top" === b.at[1] ? b.targetHeight : "bottom" === b.at[1] ? -b.targetHeight : 0,
					p = -2 * b.offset[1];
				0 > k ? (d = a.top + n + o + p + b.collisionHeight - g - f, a.top + n + o + p > k && (0 > d || d < h(k)) && (a.top += n + o + p)) : l > 0 && (c = a.top - b.collisionPosition.marginTop + n + o + p - i, a.top + n + o + p > l && (c > 0 || h(c) < l) && (a.top += n + o + p))
			}
		},
		"flipfit": {
			"left": function () {
				a.ui.position.flip.left.apply(this, arguments), a.ui.position.fit.left.apply(this, arguments)
			},
			"top": function () {
				a.ui.position.flip.top.apply(this, arguments), a.ui.position.fit.top.apply(this, arguments)
			}
		}
	}, function () {
		var b, c, d, e, f, g = document.getElementsByTagName("body")[0],
			h = document.createElement("div");
		b = document.createElement(g ? "div" : "body"), d = {
			"visibility": "hidden",
			"width": 0,
			"height": 0,
			"border": 0,
			"margin": 0,
			"background": "none"
		}, g && a.extend(d, {
			"position": "absolute",
			"left": "-1000px",
			"top": "-1000px"
		});
		for (f in d) b.style[f] = d[f];
		b.appendChild(h), c = g || document.documentElement, c.insertBefore(b, c.firstChild), h.style.cssText = "position: absolute; left: 10.7432222px;", e = a(h).offset().left, a.support.offsetFractions = e > 10 && 11 > e, b.innerHTML = "", c.removeChild(b)
	}()
}(jQuery), 

function (a) {
	/* ui.menu */
	a.widget("ui.menu", {
		"version": "1.10.4",
		"defaultElement": "<ul>",
		"delay": 300,
		"options": {
			"icons": {
				"submenu": "ui-icon-carat-1-e"
			},
			"menus": "ul",
			"position": {
				"my": "left top",
				"at": "right top"
			},
			"role": "menu",
			"blur": null,
			"focus": null,
			"select": null
		},
		"_create": function () {
			this.activeMenu = this.element, this.mouseHandled = !1, this.element.uniqueId().addClass("ui-menu ui-widget ui-widget-content ui-corner-all").toggleClass("ui-menu-icons", !! this.element.find(".ui-icon").length).attr({
				"role": this.options.role,
				"tabIndex": 0
			}).bind("click" + this.eventNamespace, a.proxy(function (a) {
				this.options.disabled && a.preventDefault()
			}, this)), this.options.disabled && this.element.addClass("ui-state-disabled").attr("aria-disabled", "true"), this._on({
				"mousedown .ui-menu-item > a": function (a) {
					a.preventDefault()
				},
				"click .ui-state-disabled > a": function (a) {
					a.preventDefault()
				},
				"click .ui-menu-item:has(a)": function (b) {
					var c = a(b.target).closest(".ui-menu-item");
					!this.mouseHandled && c.not(".ui-state-disabled").length && (this.select(b), b.isPropagationStopped() || (this.mouseHandled = !0), c.has(".ui-menu").length ? this.expand(b) : !this.element.is(":focus") && a(this.document[0].activeElement).closest(".ui-menu").length && (this.element.trigger("focus", [!0]), this.active && 1 === this.active.parents(".ui-menu").length && clearTimeout(this.timer)))
				},
				"mouseenter .ui-menu-item": function (b) {
					var c = a(b.currentTarget);
					c.siblings().children(".ui-state-active").removeClass("ui-state-active"), this.focus(b, c)
				},
				"mouseleave": "collapseAll",
				"mouseleave .ui-menu": "collapseAll",
				"focus": function (a, b) {
					var c = this.active || this.element.children(".ui-menu-item").eq(0);
					b || this.focus(a, c)
				},
				"blur": function (b) {
					this._delay(function () {
						a.contains(this.element[0], this.document[0].activeElement) || this.collapseAll(b)
					})
				},
				"keydown": "_keydown"
			}), this.refresh(), this._on(this.document, {
				"click": function (b) {
					a(b.target).closest(".ui-menu").length || this.collapseAll(b), this.mouseHandled = !1
				}
			})
		},
		"_destroy": function () {
			this.element.removeAttr("aria-activedescendant").find(".ui-menu").addBack().removeClass("ui-menu ui-widget ui-widget-content ui-corner-all ui-menu-icons").removeAttr("role").removeAttr("tabIndex").removeAttr("aria-labelledby").removeAttr("aria-expanded").removeAttr("aria-hidden").removeAttr("aria-disabled").removeUniqueId().show(), this.element.find(".ui-menu-item").removeClass("ui-menu-item").removeAttr("role").removeAttr("aria-disabled").children("a").removeUniqueId().removeClass("ui-corner-all ui-state-hover").removeAttr("tabIndex").removeAttr("role").removeAttr("aria-haspopup").children().each(function () {
				var b = a(this);
				b.data("ui-menu-submenu-carat") && b.remove()
			}), this.element.find(".ui-menu-divider").removeClass("ui-menu-divider ui-widget-content")
		},
		"_keydown": function (b) {
			function c(a) {
				return a.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
			}
			var d, e, f, g, h, i = !0;
			switch (b.keyCode) {
			case a.ui.keyCode.PAGE_UP:
				this.previousPage(b);
				break;
			case a.ui.keyCode.PAGE_DOWN:
				this.nextPage(b);
				break;
			case a.ui.keyCode.HOME:
				this._move("first", "first", b);
				break;
			case a.ui.keyCode.END:
				this._move("last", "last", b);
				break;
			case a.ui.keyCode.UP:
				this.previous(b);
				break;
			case a.ui.keyCode.DOWN:
				this.next(b);
				break;
			case a.ui.keyCode.LEFT:
				this.collapse(b);
				break;
			case a.ui.keyCode.RIGHT:
				this.active && !this.active.is(".ui-state-disabled") && this.expand(b);
				break;
			case a.ui.keyCode.ENTER:
			case a.ui.keyCode.SPACE:
				this._activate(b);
				break;
			case a.ui.keyCode.ESCAPE:
				this.collapse(b);
				break;
			default:
				i = !1, e = this.previousFilter || "", f = String.fromCharCode(b.keyCode), g = !1, clearTimeout(this.filterTimer), f === e ? g = !0 : f = e + f, h = new RegExp("^" + c(f), "i"), d = this.activeMenu.children(".ui-menu-item").filter(function () {
					return h.test(a(this).children("a").text())
				}), d = g && -1 !== d.index(this.active.next()) ? this.active.nextAll(".ui-menu-item") : d, d.length || (f = String.fromCharCode(b.keyCode), h = new RegExp("^" + c(f), "i"), d = this.activeMenu.children(".ui-menu-item").filter(function () {
					return h.test(a(this).children("a").text())
				})), d.length ? (this.focus(b, d), d.length > 1 ? (this.previousFilter = f, this.filterTimer = this._delay(function () {
					delete this.previousFilter
				}, 1e3)) : delete this.previousFilter) : delete this.previousFilter
			}
			i && b.preventDefault()
		},
		"_activate": function (a) {
			this.active.is(".ui-state-disabled") || (this.active.children("a[aria-haspopup='true']").length ? this.expand(a) : this.select(a))
		},
		"refresh": function () {
			var b, c = this.options.icons.submenu,
				d = this.element.find(this.options.menus);
			this.element.toggleClass("ui-menu-icons", !! this.element.find(".ui-icon").length), d.filter(":not(.ui-menu)").addClass("ui-menu ui-widget ui-widget-content ui-corner-all").hide().attr({
				"role": this.options.role,
				"aria-hidden": "true",
				"aria-expanded": "false"
			}).each(function () {
				var b = a(this),
					d = b.prev("a"),
					e = a("<span>").addClass("ui-menu-icon ui-icon " + c).data("ui-menu-submenu-carat", !0);
				d.attr("aria-haspopup", "true").prepend(e), b.attr("aria-labelledby", d.attr("id"))
			}), b = d.add(this.element), b.children(":not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role", "presentation").children("a").uniqueId().addClass("ui-corner-all").attr({
				"tabIndex": -1,
				"role": this._itemRole()
			}), b.children(":not(.ui-menu-item)").each(function () {
				var b = a(this);
				/[^\-\u2014\u2013\s]/.test(b.text()) || b.addClass("ui-widget-content ui-menu-divider")
			}), b.children(".ui-state-disabled").attr("aria-disabled", "true"), this.active && !a.contains(this.element[0], this.active[0]) && this.blur()
		},
		"_itemRole": function () {
			return {
				"menu": "menuitem",
				"listbox": "option"
			}[this.options.role]
		},
		"_setOption": function (a, b) {
			"icons" === a && this.element.find(".ui-menu-icon").removeClass(this.options.icons.submenu).addClass(b.submenu), this._super(a, b)
		},
		"focus": function (a, b) {
			var c, d;
			this.blur(a, a && "focus" === a.type), this._scrollIntoView(b), this.active = b.first(), d = this.active.children("a").addClass("ui-state-focus"), this.options.role && this.element.attr("aria-activedescendant", d.attr("id")), this.active.parent().closest(".ui-menu-item").children("a:first").addClass("ui-state-active"), a && "keydown" === a.type ? this._close() : this.timer = this._delay(function () {
				this._close()
			}, this.delay), c = b.children(".ui-menu"), c.length && a && /^mouse/.test(a.type) && this._startOpening(c), this.activeMenu = b.parent(), this._trigger("focus", a, {
				"item": b
			})
		},
		"_scrollIntoView": function (b) {
			var c, d, e, f, g, h;
			this._hasScroll() && (c = parseFloat(a.css(this.activeMenu[0], "borderTopWidth")) || 0, d = parseFloat(a.css(this.activeMenu[0], "paddingTop")) || 0, e = b.offset().top - this.activeMenu.offset().top - c - d, f = this.activeMenu.scrollTop(), g = this.activeMenu.height(), h = b.height(), 0 > e ? this.activeMenu.scrollTop(f + e) : e + h > g && this.activeMenu.scrollTop(f + e - g + h))
		},
		"blur": function (a, b) {
			b || clearTimeout(this.timer), this.active && (this.active.children("a").removeClass("ui-state-focus"), this.active = null, this._trigger("blur", a, {
				"item": this.active
			}))
		},
		"_startOpening": function (a) {
			clearTimeout(this.timer), "true" === a.attr("aria-hidden") && (this.timer = this._delay(function () {
				this._close(), this._open(a)
			}, this.delay))
		},
		"_open": function (b) {
			var c = a.extend({
				"of": this.active
			}, this.options.position);
			clearTimeout(this.timer), this.element.find(".ui-menu").not(b.parents(".ui-menu")).hide().attr("aria-hidden", "true"), b.show().removeAttr("aria-hidden").attr("aria-expanded", "true").position(c)
		},
		"collapseAll": function (b, c) {
			clearTimeout(this.timer), this.timer = this._delay(function () {
				var d = c ? this.element : a(b && b.target).closest(this.element.find(".ui-menu"));
				d.length || (d = this.element), this._close(d), this.blur(b), this.activeMenu = d
			}, this.delay)
		},
		"_close": function (a) {
			a || (a = this.active ? this.active.parent() : this.element), a.find(".ui-menu").hide().attr("aria-hidden", "true").attr("aria-expanded", "false").end().find("a.ui-state-active").removeClass("ui-state-active")
		},
		"collapse": function (a) {
			var b = this.active && this.active.parent().closest(".ui-menu-item", this.element);
			b && b.length && (this._close(), this.focus(a, b))
		},
		"expand": function (a) {
			var b = this.active && this.active.children(".ui-menu ").children(".ui-menu-item").first();
			b && b.length && (this._open(b.parent()), this._delay(function () {
				this.focus(a, b)
			}))
		},
		"next": function (a) {
			this._move("next", "first", a)
		},
		"previous": function (a) {
			this._move("prev", "last", a)
		},
		"isFirstItem": function () {
			return this.active && !this.active.prevAll(".ui-menu-item").length
		},
		"isLastItem": function () {
			return this.active && !this.active.nextAll(".ui-menu-item").length
		},
		"_move": function (a, b, c) {
			var d;
			this.active && (d = "first" === a || "last" === a ? this.active["first" === a ? "prevAll" : "nextAll"](".ui-menu-item").eq(-1) : this.active[a + "All"](".ui-menu-item").eq(0)), d && d.length && this.active || (d = this.activeMenu.children(".ui-menu-item")[b]()), this.focus(c, d)
		},
		"nextPage": function (b) {
			var c, d, e;
			return this.active ? void(this.isLastItem() || (this._hasScroll() ? (d = this.active.offset().top, e = this.element.height(), this.active.nextAll(".ui-menu-item").each(function () {
				return c = a(this), c.offset().top - d - e < 0
			}), this.focus(b, c)) : this.focus(b, this.activeMenu.children(".ui-menu-item")[this.active ? "last" : "first"]()))) : void this.next(b)
		},
		"previousPage": function (b) {
			var c, d, e;
			return this.active ? void(this.isFirstItem() || (this._hasScroll() ? (d = this.active.offset().top, e = this.element.height(), this.active.prevAll(".ui-menu-item").each(function () {
				return c = a(this), c.offset().top - d + e > 0
			}), this.focus(b, c)) : this.focus(b, this.activeMenu.children(".ui-menu-item").first()))) : void this.next(b)
		},
		"_hasScroll": function () {
			return this.element.outerHeight() < this.element.prop("scrollHeight")
		},
		"select": function (b) {
			this.active = this.active || a(b.target).closest(".ui-menu-item");
			var c = {
				"item": this.active
			};
			this.active.has(".ui-menu").length || this.collapseAll(b, !0), this._trigger("select", b, c)
		}
	})
}(jQuery), 
 
function (a, b) {
	/* ui.progressbar */
	a.widget("ui.progressbar", {
		"version": "1.10.4",
		"options": {
			"max": 100,
			"value": 0,
			"change": null,
			"complete": null
		},
		"min": 0,
		"_create": function () {
			this.oldValue = this.options.value = this._constrainedValue(), this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({
				"role": "progressbar",
				"aria-valuemin": this.min
			}), this.valueDiv = a("<div class='ui-progressbar-value ui-widget-header ui-corner-left'></div>").appendTo(this.element), this._refreshValue()
		},
		"_destroy": function () {
			this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"), this.valueDiv.remove()
		},
		"value": function (a) {
			return a === b ? this.options.value : (this.options.value = this._constrainedValue(a), void this._refreshValue())
		},
		"_constrainedValue": function (a) {
			return a === b && (a = this.options.value), this.indeterminate = a === !1, "number" != typeof a && (a = 0), this.indeterminate ? !1 : Math.min(this.options.max, Math.max(this.min, a))
		},
		"_setOptions": function (a) {
			var b = a.value;
			delete a.value, this._super(a), this.options.value = this._constrainedValue(b), this._refreshValue()
		},
		"_setOption": function (a, b) {
			"max" === a && (b = Math.max(this.min, b)), this._super(a, b)
		},
		"_percentage": function () {
			return this.indeterminate ? 100 : 100 * (this.options.value - this.min) / (this.options.max - this.min)
		},
		"_refreshValue": function () {
			var b = this.options.value,
				c = this._percentage();
			this.valueDiv.toggle(this.indeterminate || b > this.min).toggleClass("ui-corner-right", b === this.options.max).width(c.toFixed(0) + "%"), this.element.toggleClass("ui-progressbar-indeterminate", this.indeterminate), this.indeterminate ? (this.element.removeAttr("aria-valuenow"), this.overlayDiv || (this.overlayDiv = a("<div class='ui-progressbar-overlay'></div>").appendTo(this.valueDiv))) : (this.element.attr({
				"aria-valuemax": this.options.max,
				"aria-valuenow": b
			}), this.overlayDiv && (this.overlayDiv.remove(), this.overlayDiv = null)), this.oldValue !== b && (this.oldValue = b, this._trigger("change")), b === this.options.max && this._trigger("complete")
		}
	})
}(jQuery), 

function (a, b) {
	function c() {
		return ++e
	}
	function d(a) {
		return a = a.cloneNode(!1), a.hash.length > 1 && decodeURIComponent(a.href.replace(f, "")) === decodeURIComponent(location.href.replace(f, ""))
	}
	var e = 0,
		f = /#.*$/;
	a.widget("ui.tabs", {
		"version": "1.10.4",
		"delay": 300,
		"options": {
			"active": null,
			"collapsible": !1,
			"event": "click",
			"heightStyle": "content",
			"hide": null,
			"show": null,
			"activate": null,
			"beforeActivate": null,
			"beforeLoad": null,
			"load": null
		},
		"_create": function () {
			var b = this,
				c = this.options;
			this.running = !1, this.element.addClass("ui-tabs ui-widget ui-widget-content ui-corner-all").toggleClass("ui-tabs-collapsible", c.collapsible).delegate(".ui-tabs-nav > li", "mousedown" + this.eventNamespace, function (b) {
				a(this).is(".ui-state-disabled") && b.preventDefault()
			}).delegate(".ui-tabs-anchor", "focus" + this.eventNamespace, function () {
				a(this).closest("li").is(".ui-state-disabled") && this.blur()
			}), this._processTabs(), c.active = this._initialActive(), a.isArray(c.disabled) && (c.disabled = a.unique(c.disabled.concat(a.map(this.tabs.filter(".ui-state-disabled"), function (a) {
				return b.tabs.index(a)
			}))).sort()), this.active = this.options.active !== !1 && this.anchors.length ? this._findActive(c.active) : a(), this._refresh(), this.active.length && this.load(c.active)
		},
		"_initialActive": function () {
			var b = this.options.active,
				c = this.options.collapsible,
				d = location.hash.substring(1);
			return null === b && (d && this.tabs.each(function (c, e) {
				return a(e).attr("aria-controls") === d ? (b = c, !1) : void 0
			}), null === b && (b = this.tabs.index(this.tabs.filter(".ui-tabs-active"))), (null === b || -1 === b) && (b = this.tabs.length ? 0 : !1)), b !== !1 && (b = this.tabs.index(this.tabs.eq(b)), -1 === b && (b = c ? !1 : 0)), !c && b === !1 && this.anchors.length && (b = 0), b
		},
		"_getCreateEventData": function () {
			return {
				"tab": this.active,
				"panel": this.active.length ? this._getPanelForTab(this.active) : a()
			}
		},
		"_tabKeydown": function (b) {
			var c = a(this.document[0].activeElement).closest("li"),
				d = this.tabs.index(c),
				e = !0;
			if (!this._handlePageNav(b)) {
				switch (b.keyCode) {
				case a.ui.keyCode.RIGHT:
				case a.ui.keyCode.DOWN:
					d++;
					break;
				case a.ui.keyCode.UP:
				case a.ui.keyCode.LEFT:
					e = !1, d--;
					break;
				case a.ui.keyCode.END:
					d = this.anchors.length - 1;
					break;
				case a.ui.keyCode.HOME:
					d = 0;
					break;
				case a.ui.keyCode.SPACE:
					return b.preventDefault(), clearTimeout(this.activating), void this._activate(d);
				case a.ui.keyCode.ENTER:
					return b.preventDefault(), clearTimeout(this.activating), void this._activate(d === this.options.active ? !1 : d);
				default:
					return
				}
				b.preventDefault(), clearTimeout(this.activating), d = this._focusNextTab(d, e), b.ctrlKey || (c.attr("aria-selected", "false"), this.tabs.eq(d).attr("aria-selected", "true"), this.activating = this._delay(function () {
					this.option("active", d)
				}, this.delay))
			}
		},
		"_panelKeydown": function (b) {
			this._handlePageNav(b) || b.ctrlKey && b.keyCode === a.ui.keyCode.UP && (b.preventDefault(), this.active.focus())
		},
		"_handlePageNav": function (b) {
			return b.altKey && b.keyCode === a.ui.keyCode.PAGE_UP ? (this._activate(this._focusNextTab(this.options.active - 1, !1)), !0) : b.altKey && b.keyCode === a.ui.keyCode.PAGE_DOWN ? (this._activate(this._focusNextTab(this.options.active + 1, !0)), !0) : void 0
		},
		"_findNextTab": function (b, c) {
			function d() {
				return b > e && (b = 0), 0 > b && (b = e), b
			}
			for (var e = this.tabs.length - 1; - 1 !== a.inArray(d(), this.options.disabled);) b = c ? b + 1 : b - 1;
			return b
		},
		"_focusNextTab": function (a, b) {
			return a = this._findNextTab(a, b), this.tabs.eq(a).focus(), a
		},
		"_setOption": function (a, b) {
			return "active" === a ? void this._activate(b) : "disabled" === a ? void this._setupDisabled(b) : (this._super(a, b), "collapsible" === a && (this.element.toggleClass("ui-tabs-collapsible", b), b || this.options.active !== !1 || this._activate(0)), "event" === a && this._setupEvents(b), void("heightStyle" === a && this._setupHeightStyle(b)))
		},
		"_tabId": function (a) {
			return a.attr("aria-controls") || "ui-tabs-" + c()
		},
		"_sanitizeSelector": function (a) {
			return a ? a.replace(/[!"$%&'()*+,.\/:;<=>?@\[\]\^`{|}~]/g, "\\$&") : ""
		},
		"refresh": function () {
			var b = this.options,
				c = this.tablist.children(":has(a[href])");
			b.disabled = a.map(c.filter(".ui-state-disabled"), function (a) {
				return c.index(a)
			}), this._processTabs(), b.active !== !1 && this.anchors.length ? this.active.length && !a.contains(this.tablist[0], this.active[0]) ? this.tabs.length === b.disabled.length ? (b.active = !1, this.active = a()) : this._activate(this._findNextTab(Math.max(0, b.active - 1), !1)) : b.active = this.tabs.index(this.active) : (b.active = !1, this.active = a()), this._refresh()
		},
		"_refresh": function () {
			this._setupDisabled(this.options.disabled), this._setupEvents(this.options.event), this._setupHeightStyle(this.options.heightStyle), this.tabs.not(this.active).attr({
				"aria-selected": "false",
				"tabIndex": -1
			}), this.panels.not(this._getPanelForTab(this.active)).hide().attr({
				"aria-expanded": "false",
				"aria-hidden": "true"
			}), this.active.length ? (this.active.addClass("ui-tabs-active ui-state-active").attr({
				"aria-selected": "true",
				"tabIndex": 0
			}), this._getPanelForTab(this.active).show().attr({
				"aria-expanded": "true",
				"aria-hidden": "false"
			})) : this.tabs.eq(0).attr("tabIndex", 0)
		},
		"_processTabs": function () {
			var b = this;
			this.tablist = this._getList().addClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").attr("role", "tablist"), this.tabs = this.tablist.find("> li:has(a[href])").addClass("ui-state-default ui-corner-top").attr({
				"role": "tab",
				"tabIndex": -1
			}), this.anchors = this.tabs.map(function () {
				return a("a", this)[0]
			}).addClass("ui-tabs-anchor").attr({
				"role": "presentation",
				"tabIndex": -1
			}), this.panels = a(), this.anchors.each(function (c, e) {
				var f, g, h, i = a(e).uniqueId().attr("id"),
					j = a(e).closest("li"),
					k = j.attr("aria-controls");
				d(e) ? (f = e.hash, g = b.element.find(b._sanitizeSelector(f))) : (h = b._tabId(j), f = "#" + h, g = b.element.find(f), g.length || (g = b._createPanel(h), g.insertAfter(b.panels[c - 1] || b.tablist)), g.attr("aria-live", "polite")), g.length && (b.panels = b.panels.add(g)), k && j.data("ui-tabs-aria-controls", k), j.attr({
					"aria-controls": f.substring(1),
					"aria-labelledby": i
				}), g.attr("aria-labelledby", i)
			}), this.panels.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").attr("role", "tabpanel")
		},
		"_getList": function () {
			return this.tablist || this.element.find("ol,ul").eq(0)
		},
		"_createPanel": function (b) {
			return a("<div>").attr("id", b).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").data("ui-tabs-destroy", !0)
		},
		"_setupDisabled": function (b) {
			a.isArray(b) && (b.length ? b.length === this.anchors.length && (b = !0) : b = !1);
			for (var c, d = 0; c = this.tabs[d]; d++) b === !0 || -1 !== a.inArray(d, b) ? a(c).addClass("ui-state-disabled").attr("aria-disabled", "true") : a(c).removeClass("ui-state-disabled").removeAttr("aria-disabled");
			this.options.disabled = b
		},
		"_setupEvents": function (b) {
			var c = {
				"click": function (a) {
					a.preventDefault()
				}
			};
			b && a.each(b.split(" "), function (a, b) {
				c[b] = "_eventHandler"
			}), this._off(this.anchors.add(this.tabs).add(this.panels)), this._on(this.anchors, c), this._on(this.tabs, {
				"keydown": "_tabKeydown"
			}), this._on(this.panels, {
				"keydown": "_panelKeydown"
			}), this._focusable(this.tabs), this._hoverable(this.tabs)
		},
		"_setupHeightStyle": function (b) {
			var c, d = this.element.parent();
			"fill" === b ? (c = d.height(), c -= this.element.outerHeight() - this.element.height(), this.element.siblings(":visible").each(function () {
				var b = a(this),
					d = b.css("position");
				"absolute" !== d && "fixed" !== d && (c -= b.outerHeight(!0))
			}), this.element.children().not(this.panels).each(function () {
				c -= a(this).outerHeight(!0)
			}), this.panels.each(function () {
				a(this).height(Math.max(0, c - a(this).innerHeight() + a(this).height()))
			}).css("overflow", "auto")) : "auto" === b && (c = 0, this.panels.each(function () {
				c = Math.max(c, a(this).height("").height())
			}).height(c))
		},
		"_eventHandler": function (b) {
			var c = this.options,
				d = this.active,
				e = a(b.currentTarget),
				f = e.closest("li"),
				g = f[0] === d[0],
				h = g && c.collapsible,
				i = h ? a() : this._getPanelForTab(f),
				j = d.length ? this._getPanelForTab(d) : a(),
				k = {
					"oldTab": d,
					"oldPanel": j,
					"newTab": h ? a() : f,
					"newPanel": i
				};
			b.preventDefault(), f.hasClass("ui-state-disabled") || f.hasClass("ui-tabs-loading") || this.running || g && !c.collapsible || this._trigger("beforeActivate", b, k) === !1 || (c.active = h ? !1 : this.tabs.index(f), this.active = g ? a() : f, this.xhr && this.xhr.abort(), j.length || i.length || a.error("jQuery UI Tabs: Mismatching fragment identifier."), i.length && this.load(this.tabs.index(f), b), this._toggle(b, k))
		},
		"_toggle": function (b, c) {
			function d() {
				f.running = !1, f._trigger("activate", b, c)
			}
			function e() {
				c.newTab.closest("li").addClass("ui-tabs-active ui-state-active"), g.length && f.options.show ? f._show(g, f.options.show, d) : (g.show(), d())
			}
			var f = this,
				g = c.newPanel,
				h = c.oldPanel;
			this.running = !0, h.length && this.options.hide ? this._hide(h, this.options.hide, function () {
				c.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), e()
			}) : (c.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), h.hide(), e()), h.attr({
				"aria-expanded": "false",
				"aria-hidden": "true"
			}), c.oldTab.attr("aria-selected", "false"), g.length && h.length ? c.oldTab.attr("tabIndex", -1) : g.length && this.tabs.filter(function () {
				return 0 === a(this).attr("tabIndex")
			}).attr("tabIndex", -1), g.attr({
				"aria-expanded": "true",
				"aria-hidden": "false"
			}), c.newTab.attr({
				"aria-selected": "true",
				"tabIndex": 0
			})
		},
		"_activate": function (b) {
			var c, d = this._findActive(b);
			d[0] !== this.active[0] && (d.length || (d = this.active), c = d.find(".ui-tabs-anchor")[0], this._eventHandler({
				"target": c,
				"currentTarget": c,
				"preventDefault": a.noop
			}))
		},
		"_findActive": function (b) {
			return b === !1 ? a() : this.tabs.eq(b)
		},
		"_getIndex": function (a) {
			return "string" == typeof a && (a = this.anchors.index(this.anchors.filter("[href$='" + a + "']"))), a
		},
		"_destroy": function () {
			this.xhr && this.xhr.abort(), this.element.removeClass("ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible"), this.tablist.removeClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").removeAttr("role"), this.anchors.removeClass("ui-tabs-anchor").removeAttr("role").removeAttr("tabIndex").removeUniqueId(), this.tabs.add(this.panels).each(function () {
				a.data(this, "ui-tabs-destroy") ? a(this).remove() : a(this).removeClass("ui-state-default ui-state-active ui-state-disabled ui-corner-top ui-corner-bottom ui-widget-content ui-tabs-active ui-tabs-panel").removeAttr("tabIndex").removeAttr("aria-live").removeAttr("aria-busy").removeAttr("aria-selected").removeAttr("aria-labelledby").removeAttr("aria-hidden").removeAttr("aria-expanded").removeAttr("role")
			}), this.tabs.each(function () {
				var b = a(this),
					c = b.data("ui-tabs-aria-controls");
				c ? b.attr("aria-controls", c).removeData("ui-tabs-aria-controls") : b.removeAttr("aria-controls")
			}), this.panels.show(), "content" !== this.options.heightStyle && this.panels.css("height", "")
		},
		"enable": function (c) {
			var d = this.options.disabled;
			d !== !1 && (c === b ? d = !1 : (c = this._getIndex(c), d = a.isArray(d) ? a.map(d, function (a) {
				return a !== c ? a : null
			}) : a.map(this.tabs, function (a, b) {
				return b !== c ? b : null
			})), this._setupDisabled(d))
		},
		"disable": function (c) {
			var d = this.options.disabled;
			if (d !== !0) {
				if (c === b) d = !0;
				else {
					if (c = this._getIndex(c), -1 !== a.inArray(c, d)) return;
					d = a.isArray(d) ? a.merge([c], d).sort() : [c]
				}
				this._setupDisabled(d)
			}
		},
		"load": function (b, c) {
			b = this._getIndex(b);
			var e = this,
				f = this.tabs.eq(b),
				g = f.find(".ui-tabs-anchor"),
				h = this._getPanelForTab(f),
				i = {
					"tab": f,
					"panel": h
				};
			d(g[0]) || (this.xhr = a.ajax(this._ajaxSettings(g, c, i)), this.xhr && "canceled" !== this.xhr.statusText && (f.addClass("ui-tabs-loading"), h.attr("aria-busy", "true"), this.xhr.success(function (a) {
				setTimeout(function () {
					h.html(a), e._trigger("load", c, i)
				}, 1)
			}).complete(function (a, b) {
				setTimeout(function () {
					"abort" === b && e.panels.stop(!1, !0), f.removeClass("ui-tabs-loading"), h.removeAttr("aria-busy"), a === e.xhr && delete e.xhr
				}, 1)
			})))
		},
		"_ajaxSettings": function (b, c, d) {
			var e = this;
			return {
				"url": b.attr("href"),
				"beforeSend": function (b, f) {
					return e._trigger("beforeLoad", c, a.extend({
						"jqXHR": b,
						"ajaxSettings": f
					}, d))
				}
			}
		},
		"_getPanelForTab": function (b) {
			var c = a(b).attr("aria-controls");
			return this.element.find(this._sanitizeSelector("#" + c))
		}
	})
}(jQuery), 

function () {
	/* PixelAdmin.MainNavbar */
	PixelAdmin.MainNavbar = function () {
		return this._scroller = !1, this._wheight = null, this.scroll_pos = 0, this
	}, PixelAdmin.MainNavbar.prototype.init = function () {
		var a;
		return this.$navbar = $("#main-navbar"), this.$header = this.$navbar.find(".navbar-header"), this.$toggle = this.$navbar.find(".navbar-toggle:first"), this.$collapse = $("#main-navbar-collapse"), this.$collapse_div = this.$collapse.find("> div"), a = !1, $(window).on("pa.screen.small pa.screen.tablet", function (b) {
			return function () {
				return "fixed" === b.$navbar.css("position") && b._setupScroller(), a = !0
			}
		}(this)).on("pa.screen.desktop", function (b) {
			return function () {
				return b._removeScroller(), a = !1
			}
		}(this)), this.$navbar.on("click", ".nav-icon-btn.dropdown > .dropdown-toggle", function (b) {
			return a ? (b.preventDefault(), b.stopPropagation(), document.location.href = $(this).attr("href"), !1) : void 0
		})
	}, PixelAdmin.MainNavbar.prototype._setupScroller = function () {
		return this._scroller ? void 0 : (this._scroller = !0, this.$collapse_div.pixelSlimScroll({}), this.$navbar.on("shown.bs.collapse.mn_collapse", $.proxy(function (a) {
			return function () {
				return a._updateCollapseHeight(), a._watchWindowHeight()
			}
		}(this), this)).on("hidden.bs.collapse.mn_collapse", $.proxy(function (a) {
			return function () {
				return a._wheight = null, a.$collapse_div.pixelSlimScroll({
					"scrollTo": "0px"
				})
			}
		}(this), this)).on("shown.bs.dropdown.mn_collapse", $.proxy(this._updateCollapseHeight, this)).on("hidden.bs.dropdown.mn_collapse", $.proxy(this._updateCollapseHeight, this)), this._updateCollapseHeight())
	}, PixelAdmin.MainNavbar.prototype._removeScroller = function () {
		return this._scroller ? (this._wheight = null, this._scroller = !1, this.$collapse_div.pixelSlimScroll({
			"destroy": "destroy"
		}), this.$navbar.off("shown.bs.collapse.mn_collapse"), this.$navbar.off("hidden.bs.collapse.mn_collapse"), this.$navbar.off("shown.bs.dropdown.mn_collapse"), this.$navbar.off("hidden.bs.dropdown.mn_collapse"), this.$collapse.attr("style", "")) : void 0
	}, PixelAdmin.MainNavbar.prototype._updateCollapseHeight = function () {
		var a, b, c;
		if (this._scroller) return c = $(window).innerHeight(), a = this.$header.outerHeight(), b = this.$collapse_div.scrollTop(), this.$collapse_div.css(a + this.$collapse_div.css({
			"max-height": "none"
		}).outerHeight() > c ? {
			"max-height": c - a
		} : {
			"max-height": "none"
		}), this.$collapse_div.pixelSlimScroll({
			"scrollTo": b + "px"
		})
	}, PixelAdmin.MainNavbar.prototype._watchWindowHeight = function () {
		var a;
		return this._wheight = $(window).innerHeight(), a = function (b) {
			return function () {
				return null !== b._wheight ? (b._wheight !== $(window).innerHeight() && b._updateCollapseHeight(), b._wheight = $(window).innerHeight(), setTimeout(a, 100)) : void 0
			}
		}(this), window.setTimeout(a, 100)
	}, PixelAdmin.MainNavbar.Constructor = PixelAdmin.MainNavbar, PixelAdmin.addInitializer(function () {
		return PixelAdmin.initPlugin("main_navbar", new PixelAdmin.MainNavbar)
	})
}.call(this), 

function () {
	/* PixelAdmin.MainMenu */
	PixelAdmin.MainMenu = function () {
		return this._screen = null, this._last_screen = null, this._animate = !1, this._close_timer = null, this._dropdown_li = null, this._dropdown = null, this
	}, PixelAdmin.MainMenu.prototype.init = function () {
		var a, b;
		return this.$menu = $("#main-menu"), this.$menu.length ? (this.$body = $("body"), this.menu = this.$menu[0], this.$ssw_point = $("#small-screen-width-point"), this.$tsw_point = $("#tablet-screen-width-point"), a = this, PixelAdmin.settings.main_menu.store_state && (b = this._getMenuState(), document.body.className += " disable-mm-animation", null !== b && this.$body["collapsed" === b ? "addClass" : "removeClass"]("mmc"), setTimeout(function () {
			return function () {
				return elRemoveClass(document.body, "disable-mm-animation")
			}
		}(this), 20)), this.setupAnimation(), $(window).on("resize.pa.mm", $.proxy(this.onResize, this)), this.onResize(), this.$menu.find(".navigation > .mm-dropdown").addClass("mm-dropdown-root"), PixelAdmin.settings.main_menu.detect_active && this.detectActiveItem(), $.support.transition && this.$menu.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", $.proxy(this._onAnimationEnd, this)), $("#main-menu-toggle").on("click", $.proxy(this.toggle, this)), $("#main-menu-inner").slimScroll({
			"height": "100%"
		}).on("slimscrolling", function (a) {
			return function () {
				return a.closeCurrentDropdown(!0)
			}
		}(this)), this.$menu.on("click", ".mm-dropdown > a", function () {
			var b;
			return b = this.parentNode, elHasClass(b, "mm-dropdown-root") && a._collapsed() ? elHasClass(b, "mmc-dropdown-open") ? elHasClass(b, "freeze") ? a.closeCurrentDropdown(!0) : a.freezeDropdown(b) : a.openDropdown(b, !0) : a.toggleSubmenu(b), !1
		}), this.$menu.find(".navigation").on("mouseenter.pa.mm-dropdown", ".mm-dropdown-root", function () {
			return a.clearCloseTimer(), a._dropdown_li !== this ? !a._collapsed() || a._dropdown_li && elHasClass(a._dropdown_li, "freeze") ? void 0 : a.openDropdown(this) : void 0
		}).on("mouseleave.pa.mm-dropdown", ".mm-dropdown-root", function () {
			return a._close_timer = setTimeout(function () {
				return a.closeCurrentDropdown()
			}, PixelAdmin.settings.main_menu.dropdown_close_delay)
		}), this) : void 0
	}, PixelAdmin.MainMenu.prototype._collapsed = function () {
		return "desktop" === this._screen && elHasClass(document.body, "mmc") || "desktop" !== this._screen && !elHasClass(document.body, "mme")
	}, PixelAdmin.MainMenu.prototype.onResize = function () {
		return this._screen = getScreenSize(this.$ssw_point, this.$tsw_point), this._animate = -1 === PixelAdmin.settings.main_menu.disable_animation_on.indexOf(screen), this._dropdown_li && this.closeCurrentDropdown(!0), ("small" === this._screen && this._last_screen !== this._screen || "tablet" === this._screen && "small" === this._last_screen) && (document.body.className += " disable-mm-animation", setTimeout(function () {
			return function () {
				return elRemoveClass(document.body, "disable-mm-animation")
			}
		}(this), 20)), this._last_screen = this._screen
	}, PixelAdmin.MainMenu.prototype.clearCloseTimer = function () {
		return this._close_timer ? (clearTimeout(this._close_timer), this._close_timer = null) : void 0
	}, PixelAdmin.MainMenu.prototype._onAnimationEnd = function (a) {
		return "desktop" === this._screen && "main-menu" === a.target.id ? $(window).trigger("resize") : void 0
	}, PixelAdmin.MainMenu.prototype.toggle = function () {
		var a, b;
		return a = "small" === this._screen || "tablet" === this._screen ? "mme" : "mmc", elHasClass(document.body, a) ? elRemoveClass(document.body, a) : document.body.className += " " + a, "mmc" !== a ? (b = document.getElementById(""), $("#main-navbar-collapse").stop().removeClass("in collapsing").addClass("collapse")[0].style.height = "0px", $("#main-navbar .navbar-toggle").addClass("collapsed")) : (PixelAdmin.settings.main_menu.store_state && this._storeMenuState(elHasClass(document.body, "mmc")), $.support.transition ? void 0 : $(window).trigger("resize"))
	}, PixelAdmin.MainMenu.prototype.toggleSubmenu = function (a) {
		return this[elHasClass(a, "open") ? "collapseSubmenu" : "expandSubmenu"](a), !1
	}, PixelAdmin.MainMenu.prototype.collapseSubmenu = function (a) {
		var b, c;
		return b = $(a), c = b.find("> ul"), this._animate ? c.animate({
			"height": 0
		}, PixelAdmin.settings.main_menu.animation_speed, function () {
			return function () {
				return elRemoveClass(a, "open"), c.attr("style", ""), b.find(".mm-dropdown.open").removeClass("open").find("> ul").attr("style", "")
			}
		}(this)) : elRemoveClass(a, "open"), !1
	}, PixelAdmin.MainMenu.prototype.expandSubmenu = function (a) {
		var b, c, d, e;
		return b = $(a), PixelAdmin.settings.main_menu.accordion && this.collapseAllSubmenus(a), this._animate ? (c = b.find("> ul"), e = c[0], e.className += " get-height", d = c.height(), elRemoveClass(e, "get-height"), e.style.display = "block", e.style.height = "0px", a.className += " open", c.animate({
			"height": d
		}, PixelAdmin.settings.main_menu.animation_speed, function () {
			return function () {
				return c.attr("style", "")
			}
		}(this))) : a.className += " open"
	}, PixelAdmin.MainMenu.prototype.collapseAllSubmenus = function (a) {
		var b;
		return b = this, $(a).parent().find("> .mm-dropdown.open").each(function () {
			return b.collapseSubmenu(this)
		})
	}, PixelAdmin.MainMenu.prototype.openDropdown = function (a, b) {
		var c, d, e, f, g, h, i, j, k, l, m;
		return null == b && (b = !1), this._dropdown_li && this.closeCurrentDropdown(b), c = $(a), e = c.find("> ul"), k = e[0], this._dropdown_li = a, this._dropdown = k, d = e.find("> .mmc-title"), d.length || (d = $('<div class="mmc-title"></div>').text(c.find("> a > .mm-text").text()), k.insertBefore(d[0], k.firstChild)), a.className += " mmc-dropdown-open", k.className += " mmc-dropdown-open-ul", j = c.position().top, elHasClass(document.body, "main-menu-fixed") ? (f = e.find(".mmc-wrapper"), f.length || (m = document.createElement("div"), m.className = "mmc-wrapper", m.style.overflow = "hidden", m.style.position = "relative", f = $(m), f.append(e.find("> li")), k.appendChild(m)), l = $(window).innerHeight(), i = d.outerHeight(), h = i + 3 * e.find(".mmc-wrapper > li").first().outerHeight(), j + h > l ? (g = j - $("#main-navbar").outerHeight(), k.className += " top", k.style.bottom = l - j - i + "px") : (g = l - j - i, k.style.top = j + "px"), elHasClass(k, "top") ? k.appendChild(d[0]) : k.insertBefore(d[0], k.firstChild), a.className += " slimscroll-attached", f[0].style.maxHeight = g - 10 + "px", f.pixelSlimScroll({})) : k.style.top = j + "px", b && this.freezeDropdown(a), b || e.on("mouseenter", function (a) {
			return function () {
				return a.clearCloseTimer()
			}
		}(this)).on("mouseleave", function (a) {
			return function () {
				return a._close_timer = setTimeout(function () {
					return a.closeCurrentDropdown()
				}, PixelAdmin.settings.main_menu.dropdown_close_delay)
			}
		}(this)), this.menu.appendChild(k)
	}, PixelAdmin.MainMenu.prototype.closeCurrentDropdown = function (a) {
		var b, c;
		return null == a && (a = !1), !this._dropdown_li || elHasClass(this._dropdown_li, "freeze") && !a ? void 0 : (this.clearCloseTimer(), b = $(this._dropdown), elHasClass(this._dropdown_li, "slimscroll-attached") && (elRemoveClass(this._dropdown_li, "slimscroll-attached"), c = b.find(".mmc-wrapper"), c.pixelSlimScroll({
			"destroy": "destroy"
		}).find("> *").appendTo(b), c.remove()), this._dropdown_li.appendChild(this._dropdown), elRemoveClass(this._dropdown, "mmc-dropdown-open-ul"), elRemoveClass(this._dropdown, "top"), elRemoveClass(this._dropdown_li, "mmc-dropdown-open"), elRemoveClass(this._dropdown_li, "freeze"), $(this._dropdown_li).attr("style", ""), b.attr("style", "").off("mouseenter").off("mouseleave"), this._dropdown = null, this._dropdown_li = null)
	}, PixelAdmin.MainMenu.prototype.freezeDropdown = function (a) {
		return a.className += " freeze"
	}, PixelAdmin.MainMenu.prototype.setupAnimation = function () {
		var a, b, c, d;
		return c = document.body, d = PixelAdmin.settings.main_menu.disable_animation_on, c.className += " dont-animate-mm-content", a = $("#main-menu"), b = a.find(".navigation"), b.find("> .mm-dropdown > ul").addClass("mmc-dropdown-delay animated"), b.find("> li > a > .mm-text").addClass("mmc-dropdown-delay animated fadeIn"), a.find(".menu-content").addClass("animated fadeIn"), b.find("> .mm-dropdown > ul").addClass(elHasClass(c, "main-menu-right") || elHasClass(c, "right-to-left") && !elHasClass(c, "main-menu-right") ? "fadeInRight" : "fadeInLeft"), c.className += -1 === d.indexOf("small") ? " animate-mm-sm" : " dont-animate-mm-content-sm", c.className += -1 === d.indexOf("tablet") ? " animate-mm-md" : " dont-animate-mm-content-md", c.className += -1 === d.indexOf("desktop") ? " animate-mm-lg" : " dont-animate-mm-content-lg", window.setTimeout(function () {
			return elRemoveClass(c, "dont-animate-mm-content")
		}, 500)
	}, PixelAdmin.MainMenu.prototype.detectActiveItem = function () {
		var a, b, c, d, e, f, g, h, i;
		for (f = (document.location + "").replace(/\#.*?$/, ""), e = PixelAdmin.settings.main_menu.detect_active_predicate, d = $("#main-menu .navigation"), d.find("li").removeClass("open active"), c = d[0].getElementsByTagName("a"), b = function () {
			return function (a) {
				return a.className += " active", elHasClass(a.parentNode, "navigation") ? void 0 : (a = a.parentNode.parentNode, a.className += " open", b(a))
			}
		}(this), i = [], g = 0, h = c.length; h > g; g++) {
			if (a = c[g], -1 === a.href.indexOf("#") && e(a.href, f)) {
				b(a.parentNode);
				break
			}
			i.push(void 0)
		}
		return i
	}, PixelAdmin.MainMenu.prototype._getMenuState = function () {
		return PixelAdmin.getStoredValue(PixelAdmin.settings.main_menu.store_state_key, null)
	}, PixelAdmin.MainMenu.prototype._storeMenuState = function (a) {
		return PixelAdmin.settings.main_menu.store_state ? PixelAdmin.storeValue(PixelAdmin.settings.main_menu.store_state_key, a ? "collapsed" : "expanded") : void 0
	}, PixelAdmin.MainMenu.Constructor = PixelAdmin.MainMenu, PixelAdmin.addInitializer(function () {
		return PixelAdmin.initPlugin("main_menu", new PixelAdmin.MainMenu)
	})
}.call(this), 

function () {
	/* alert */
	var a, b;
	a = "pa-page-alerts-box", b = function () {
		return this
	}, b.DEFAULTS = {
		"type": "warning",
		"close_btn": !0,
		"classes": !1,
		"namespace": "pa_page_alerts",
		"animate": !0,
		"auto_close": !1
	}, b.TYPES_HASH = {
		"warning": "",
		"danger": "alert-danger",
		"success": "alert-success",
		"info": "alert-info"
	}, b.prototype.init = function () {
		var b;
		return b = this, $("#main-wrapper").on("click.pa.alerts", "#" + a + " .close", function () {
			return b.close($(this).parents(".alert")), !1
		})
	}, b.prototype.add = function (c, d) {
		var e, f, g, h, i, j;
		return d = $.extend({}, b.DEFAULTS, d || {}), e = $('<div class="alert alert-page ' + d.namespace + " " + b.TYPES_HASH[d.type] + '" />').html(c), d.classes && e.addClass(d.classes), d.close_btn && e.prepend($('<button type="button" class="close" />').html("&times;")), d.animate && e.attr("data-animate", "true"), g = $("#" + a), g.length || (g = $('<div id="' + a + '" />').prependTo($("#content-wrapper"))), f = $("#" + a + " ." + d.namespace), h = e.css({
			"visibility": "hidden",
			"position": "absolute",
			"width": "100%"
		}).appendTo("body").outerHeight(), j = e.css("padding-top"), i = e.css("padding-bottom"), d.animate && e.attr("style", "").css({
			"overflow": "hidden",
			"height": 0,
			"padding-top": 0,
			"padding-bottom": 0
		}), f.length ? f.last().after(e) : g.append(e), d.animate ? e.animate({
			"height": h,
			"padding-top": j,
			"padding-bottom": i
		}, 500, function (a) {
			return function () {
				return e.attr("style", ""), d.auto_close ? $.data(e, "timer", setTimeout(function () {
					return a.close(e)
				}, 1e3 * d.auto_close)) : void 0
			}
		}(this)) : e.attr("style", "")
	}, b.prototype.close = function (a) {
		return "true" === a.attr("data-animate") ? a.animate({
			"height": 0,
			"padding-top": 0,
			"padding-bottom": 0
		}, 500, function () {
			return $.data(a, "timer") && clearTimeout($.data(a, "timer")), a.remove()
		}) : ($.data(a, "timer") && clearTimeout($.data(a, "timer")), a.remove())
	}, b.prototype.clear = function (b, c) {
		var d, e;
		return null == b && (b = !0), null == c && (c = "pa_page_alerts"), d = $("#" + a + " ." + c), d.length ? (e = this, b ? d.each(function () {
			return e.close($(this))
		}) : d.remove()) : void 0
	}, b.prototype.clearAll = function (b) {
		var c;
		return null == b && (b = !0), b ? (c = this, $("#" + a + " .alert").each(function () {
			return c.close($(this))
		})) : $("#" + a).remove()
	}, b.prototype.getContainerId = function () {
		return a
	}, b.Constructor = b, PixelAdmin.addInitializer(function () {
		return PixelAdmin.initPlugin("alerts", new b)
	})
}.call(this), 

function () {
	/* switcher */
	var a;
	a = function (b, c) {
		var d;
		return null == c && (c = {}), this.options = $.extend({}, a.DEFAULTS, c), this.$checkbox = null, this.$box = null, b.is('input[type="checkbox"]') ? (d = b.attr("data-class"), this.$checkbox = b, this.$box = $('<div class="switcher"><div class="switcher-toggler"></div><div class="switcher-inner"><div class="switcher-state-on">' + this.options.on_state_content + '</div><div class="switcher-state-off">' + this.options.off_state_content + "</div></div></div>"), this.options.theme && this.$box.addClass("switcher-theme-" + this.options.theme), d && this.$box.addClass(d), this.$box.insertAfter(this.$checkbox).prepend(this.$checkbox)) : (this.$box = b, this.$checkbox = $('input[type="checkbox"]', this.$box)), this.$checkbox.prop("disabled") && this.$box.addClass("disabled"), this.$checkbox.is(":checked") && this.$box.addClass("checked"), this.$checkbox.on("click", function (a) {
			return a.stopPropagation()
		}), this.$box.on("touchend click", function (a) {
			return function (b) {
				return b.stopPropagation(), b.preventDefault(), a.toggle()
			}
		}(this)), this
	}, a.prototype.enable = function () {
		return this.$checkbox.prop("disabled", !1), this.$box.removeClass("disabled")
	}, a.prototype.disable = function () {
		return this.$checkbox.prop("disabled", !0), this.$box.addClass("disabled")
	}, a.prototype.on = function () {
		return this.$checkbox.is(":checked") ? void 0 : (this.$checkbox.click(), this.$box.addClass("checked"))
	}, a.prototype.off = function () {
		return this.$checkbox.is(":checked") ? (this.$checkbox.click(), this.$box.removeClass("checked")) : void 0
	}, a.prototype.toggle = function () {
		return this.$checkbox.click().is(":checked") ? this.$box.addClass("checked") : this.$box.removeClass("checked")
	}, a.DEFAULTS = {
		"theme": null,
		"on_state_content": "ON",
		"off_state_content": "OFF"
	}, $.fn.switcher = function (b) {
		return $(this).each(function () {
			var c, d;
			return c = $(this), d = $.data(this, "Switcher"), d ? "enable" === b ? d.enable() : "disable" === b ? d.disable() : "on" === b ? d.on() : "off" === b ? d.off() : "toggle" === b ? d.toggle() : void 0 : $.data(this, "Switcher", new a(c, b))
		})
	}, $.fn.switcher.Constructor = a
}.call(this), 

function () {
	/* pixelWizard */
	var a, b;
	b = function (a, b) {
		return a.css({
			"width": b,
			"max-width": b,
			"min-width": b
		})
	}, a = function (b, c) {
		var d, e;
		return null == c && (c = {}), this.options = $.extend({}, a.DEFAULTS, c || {}), this.$element = b, this.$wrapper = $(".wizard-wrapper", this.$element), this.$steps = $(".wizard-steps", this.$wrapper), this.$step_items = $("> li", this.$steps), this.steps_count = this.$step_items.length, this.$content = $(".wizard-content", this.$element), this.current_step = null, this.$current_item = null, this.isFreeze = !1, this.isRtl = $("body").hasClass("right-to-left"), this.resizeStepItems(), d = $("> li.active", this.$steps), 0 === d.length && (d = $("> li:first-child", this.$steps)), this.$current_item = d.addClass("active"), this.current_step = d.index() + 1, $(d.attr("data-target"), this.$content).css({
			"display": "block"
		}), this.placeStepItems(), this._setPrevItemStates(this.current_step - 1), $(window).on("pa.resize.wizard", function (a) {
			return function () {
				return $.proxy(a.resizeStepItems, a)(), $.proxy(a.placeStepItems, a)()
			}
		}(this)), e = this, this.$steps.on("click", "> li", function () {
			var a;
			return a = $(this), a.hasClass("completed") ? e.setCurrentStep(a.index() + 1) : void 0
		}), this
	}, a.DEFAULTS = {
		"step_item_min_width": 200,
		"onChange": null,
		"onFinish": null
	}, a.prototype.resizeStepItems = function () {
		var c;
		return c = this.$element.width() > a.DEFAULTS.step_item_min_width * this.$step_items.length ? Math.floor(this.$element.width() / this.$step_items.length) : a.DEFAULTS.step_item_min_width, this.$step_items.each(function () {
			return b($(this), c)
		})
	}, a.prototype.placeStepItems = function () {
		var a, b, c, d, e, f, g;
		return f = 0, d = this.$current_item.position(), c = this.$element.outerWidth(), g = this.$steps.outerWidth(), a = this.$current_item.outerWidth(), b = (c - a) / 2, this.isRtl ? (e = g - d.left - a, g > c && e > b && (f = -1 * e + b, c > g + f && (f = -1 * g + c)), this.$steps.css({
			"right": f
		})) : (g > c && d.left > b && (f = -1 * d.left + b, c > g + f && (f = -1 * g + c)), this.$steps.css({
			"left": f
		}))
	}, a.prototype.setCurrentStep = function (a) {
		return this.isFreeze ? void 0 : $(this.$current_item.attr("data-target"), this.$content).css({
			"opacity": 1
		}).animate({
			"opacity": 0
		}, 200, function (b) {
			return function () {
				return $(b.$current_item.attr("data-target"), b.$content).attr("style", ""), b._clearItemStates(a - 1), b.$current_item = b.$step_items.eq(a - 1).addClass("active"), b.current_step = a, b._setPrevItemStates(a - 1), $(b.$current_item.attr("data-target"), b.$content).css({
					"display": "block",
					"opacity": 0
				}).animate({
					"opacity": 1
				}, 200, function () {
					return b.options.onChange && $.proxy(b.options.onChange, b)(), b.placeStepItems()
				})
			}
		}(this))
	}, a.prototype.nextStep = function () {
		return this.isFreeze ? void 0 : this.current_step >= this.steps_count ? void(this.options.onFinish && $.proxy(this.options.onFinish, this)()) : (this.$current_item.removeClass("active").addClass("completed"), this.setCurrentStep(this.current_step + 1))
	}, a.prototype.prevStep = function () {
		return this.isFreeze || this.current_step <= 1 ? void 0 : this.setCurrentStep(this.current_step - 1)
	}, a.prototype.currentStep = function () {
		return this.current_step
	}, a.prototype._clearItemStates = function (a) {
		var b, c, d, e;
		for (e = [], b = c = a, d = this.steps_count; d >= a ? d > c : c > d; b = d >= a ? ++c : --c) e.push(this.$step_items.eq(b).removeClass("active").removeClass("completed"));
		return e
	}, a.prototype._setPrevItemStates = function (a) {
		var b, c, d;
		for (d = [], b = c = 0; a >= 0 ? a > c : c > a; b = a >= 0 ? ++c : --c) d.push(this.$step_items.eq(b).addClass("completed"));
		return d
	}, a.prototype.freeze = function () {
		return this.isFreeze = !0, this.$element.addClass("freeze")
	}, a.prototype.unfreeze = function () {
		return this.isFreeze = !1, this.$element.removeClass("freeze")
	}, $.fn.pixelWizard = function (b, c) {
		var d, e;
		return e = void 0, d = this.each(function () {
			var d, f;
			if (d = $(this), !$.data(this, "pixelWizard")) return $.data(this, "pixelWizard", new a(d, b));
			if (b && "string" == typeof b) {
				if (f = $.data(this, "pixelWizard"), "setCurrentStep" === b) return f.setCurrentStep(c);
				if ("currentStep" === b) return e = f.currentStep();
				if ("nextStep" === b) return f.nextStep();
				if ("prevStep" === b) return f.prevStep();
				if ("freeze" === b) return f.freeze();
				if ("unfreeze" === b) return f.unfreeze();
				if ("resizeSteps" === b) return f.resizeStepItems()
			}
		}), void 0 === e ? d : e
	}, $.fn.pixelWizard.Constructor = a
}.call(this), 

function () {
	/* pixelFileInput */
	var a;
	a = function (b, c) {
		return null == c && (c = {}), this.options = $.extend({}, a.DEFAULTS, c || {}), this.$input = b, this.$el = $('<div class="pixel-file-input"><span class="pfi-filename"></span><div class="pfi-actions"></div></div>').insertAfter(b).append(b), this.$filename = $(".pfi-filename", this.$el), this.$clear_btn = $(this.options.clear_btn_tmpl).addClass("pfi-clear").appendTo($(".pfi-actions", this.$el)), this.$choose_btn = $(this.options.choose_btn_tmpl).addClass("pfi-choose").appendTo($(".pfi-actions", this.$el)), this.onChange(), b.on("change", function (a) {
			return function () {
				return $.proxy(a.onChange, a)()
			}
		}(this)).on("click", function (a) {
			return a.stopPropagation()
		}), this.$el.on("click", function () {
			return b.click()
		}), this.$choose_btn.on("click", function (a) {
			return a.preventDefault()
		}), this.$clear_btn.on("click", function (a) {
			return function (c) {
				return b.wrap("<form>").parent("form").trigger("reset"), b.unwrap(), $.proxy(a.onChange, a)(), c.stopPropagation(), c.preventDefault()
			}
		}(this))
	}, a.DEFAULTS = {
		"choose_btn_tmpl": '<a href="#" class="btn btn-xs btn-primary">Choose</a>',
		"clear_btn_tmpl": '<a href="#" class="btn btn-xs"><i class="fa fa-times"></i> Clear</a>',
		"placeholder": null
	}, a.prototype.onChange = function () {
		var a;
		return a = this.$input.val().replace(/\\/g, "/"), "" !== a ? (this.$clear_btn.css("display", "inline-block"), this.$filename.removeClass("pfi-placeholder"), this.$filename.text(a.split("/").pop())) : (this.$clear_btn.css("display", "none"), this.options.placeholder ? (this.$filename.addClass("pfi-placeholder"), this.$filename.text(this.options.placeholder)) : this.$filename.text(""))
	}, $.fn.pixelFileInput = function (b) {
		return this.each(function () {
			return $.data(this, "pixelFileInput") ? void 0 : $.data(this, "pixelFileInput", new a($(this), b))
		})
	}, $.fn.pixelFileInput.Constructor = a
}.call(this),  

function () {
	/* rating */
	var a;
	a = function (b, c) {
		var d, e, f, g;
		for (null == c && (c = {}), this.options = $.extend({}, a.DEFAULTS, c), this.$container = $('<ul class="widget-rating"></ul>'), d = f = 0, g = this.options.stars_count; g >= 0 ? g > f : f > g; d = g >= 0 ? ++f : --f) this.$container.append($('<li><a href="#" title="" class="widget-rating-item"></a></li>'));
		return b.append(this.$container), e = this, this.$container.find("a").on("mouseenter", function () {
			return e.$container.find("li").removeClass(e.options.class_active), $(this).parents("li").addClass(e.options.class_active).prevAll("li").addClass(e.options.class_active)
		}).on("mouseleave", function () {
			return e.setRating(e.options.rating)
		}).on("click", function () {
			return e.options.onRatingChange.call(e, $(this).parents("li").prevAll("li").length + 1), !1
		}), this.setRating(this.options.rating), this
	}, a.prototype.setRating = function (a) {
		return this.options.rating = a, a = a - Math.floor(a) > this.options.lower_limit ? Math.ceil(a) : Math.floor(a), this.$container.find("li").removeClass(this.options.class_active).slice(0, a).addClass(this.options.class_active)
	}, a.DEFAULTS = {
		"stars_count": 5,
		"rating": 0,
		"class_active": "active",
		"lower_limit": .35,
		"onRatingChange": function () {}
	}, $.fn.pixelRating = function (b, c) {
		return $(this).each(function () {
			var d, e;
			return d = $(this), e = $.data(this, "pixelRating"), e ? "setRating" === b ? e.setRating(c) : void 0 : $.data(this, "pixelRating", new a(d, b))
		})
	}, $.fn.pixelRating.Constructor = a
}.call(this), 

function (a) {
/* pixelslimscroll */
	jQuery.fn.extend({
		"pixelSlimScroll": function (b) {
			var c = {
				"width": "auto",
				"size": "2px",
				"color": "#000",
				"distance": "1px",
				"start": "top",
				"opacity": .4,
				"railColor": "#333",
				"railOpacity": .2,
				"railClass": "slimScrollRail",
				"barClass": "slimScrollBar",
				"wrapperClass": "slimScrollDiv",
				"allowPageScroll": !1,
				"wheelStep": 20,
				"touchScrollStep": 200,
				"borderRadius": "0px",
				"railBorderRadius": "0px"
			},
				d = a.extend(c, b);
			return this.each(function () {
				function c(b) {
					if (j) {
						var b = b || window.event,
							c = 0;
						b.wheelDelta && (c = -b.wheelDelta / 120), b.detail && (c = b.detail / 3);
						var f = b.target || b.srcTarget || b.srcElement;
						a(f).closest("." + d.wrapperClass).is(v.parent()) && e(c, !0), b.preventDefault && !u && b.preventDefault(), u || (b.returnValue = !1)
					}
				}
				function e(a, b, c) {
					u = !1;
					var e = a,
						f = v.outerHeight() - z.outerHeight();
					if (b && (e = parseInt(z.css("top")) + a * parseInt(d.wheelStep) / 100 * z.outerHeight(), e = Math.min(Math.max(e, 0), f), e = a > 0 ? Math.ceil(e) : Math.floor(e), z.css({
						"top": e + "px"
					})), p = parseInt(z.css("top")) / (v.outerHeight() - z.outerHeight()), e = p * (v[0].scrollHeight - v.outerHeight()), c) {
						e = a;
						var g = e / v[0].scrollHeight * v.outerHeight();
						g = Math.min(Math.max(g, 0), f), z.css({
							"top": g + "px"
						})
					}
					v.scrollTop(e), v.trigger("slimscrolling", ~~e), h(), i()
				}
				function f() {
					window.addEventListener ? (this.addEventListener("DOMMouseScroll", c, !1), this.addEventListener("mousewheel", c, !1)) : document.attachEvent("onmousewheel", c)
				}
				function g() {
					o = Math.max(v.outerHeight() / v[0].scrollHeight * v.outerHeight(), s), z.css({
						"height": o + "px"
					});
					var a = o == v.outerHeight() ? "none" : "block";
					z.css({
						"display": a
					})
				}
				function h() {
					if (g(), clearTimeout(m), p == ~~p) {
						if (u = d.allowPageScroll, q != p) {
							var a = 0 == ~~p ? "top" : "bottom";
							v.trigger("slimscroll", a)
						}
					} else u = !1;
					return q = p, o >= v.outerHeight() ? void(u = !0) : void z.stop(!0, !0).fadeIn("fast")
				}
				function i() {}
				var j, k, l, m, n, o, p, q, r = "<div></div>",
					s = 30,
					u = !1,
					v = a(this);
				if (v.parent().hasClass(d.wrapperClass)) {
					var w = v.scrollTop();
					if (z = v.parent().find("." + d.barClass), y = v.parent().find("." + d.railClass), g(), a.isPlainObject(b)) {
						if ("scrollTo" in b) w = parseInt(d.scrollTo);
						else if ("scrollBy" in b) w += parseInt(d.scrollBy);
						else if ("destroy" in b) return z.remove(), y.remove(), void v.unwrap();
						e(w, !1, !0)
					}
				} else {
					var x = a(r).addClass(d.wrapperClass).css({
						"position": "relative",
						"overflow": "hidden",
						"width": d.width
					});
					v.css({
						"overflow": "hidden",
						"width": d.width
					});
					var y = a(r).addClass(d.railClass).css({
						"width": d.size,
						"height": "100%",
						"position": "absolute",
						"top": 0,
						"display": "none",
						"border-radius": d.railBorderRadius,
						"background": d.railColor,
						"opacity": d.railOpacity,
						"zIndex": 90
					}),
						z = a(r).addClass(d.barClass).css({
							"background": d.color,
							"width": d.size,
							"position": "absolute",
							"top": 0,
							"opacity": d.opacity,
							"display": "block",
							"border-radius": d.borderRadius,
							"BorderRadius": d.borderRadius,
							"MozBorderRadius": d.borderRadius,
							"WebkitBorderRadius": d.borderRadius,
							"zIndex": 99
						});
					y.css({
						"right": d.distance
					}), z.css({
						"right": d.distance
					}), v.wrap(x), v.parent().append(z), v.parent().append(y), z.bind("mousedown", function (b) {
						var c = a(document);
						return l = !0, t = parseFloat(z.css("top")), pageY = b.pageY, c.bind("mousemove.slimscroll", function (a) {
							currTop = t + a.pageY - pageY, z.css("top", currTop), e(0, z.position().top, !1)
						}), c.bind("mouseup.slimscroll", function () {
							l = !1, i(), c.unbind(".slimscroll")
						}), !1
					}).bind("selectstart.slimscroll", function (a) {
						return a.stopPropagation(), a.preventDefault(), !1
					}), y.hover(function () {
						h()
					}, function () {
						i()
					}), z.hover(function () {
						k = !0
					}, function () {
						k = !1
					}), v.hover(function () {
						j = !0, h(), i()
					}, function () {
						j = !1, i()
					}), v.bind("touchstart", function (a) {
						a.originalEvent.touches.length && (n = a.originalEvent.touches[0].pageY)
					}), v.bind("touchmove", function (a) {
						if (u || a.originalEvent.preventDefault(), a.originalEvent.touches.length) {
							var b = (n - a.originalEvent.touches[0].pageY) / d.touchScrollStep;
							e(b, !0), n = a.originalEvent.touches[0].pageY
						}
					}), g(), f()
				}
			}), this
		}
	}), jQuery.fn.extend({
		"pixelslimscroll": jQuery.fn.pixelSlimScroll
	})
}(jQuery), 
function (a, b) {}(window.jQuery), 
function (a, b, c) {}(jQuery, window, document), !
function (a) {}(window.jQuery), (jQuery), !
function (a) {}(jQuery), 
function (a) {}(window.jQuery || window.$), !
function (a, b) {}, 
/* growl */
function () {
	"use strict";
	var a, b, c, d = function (a, b) {
		return function () {
			return a.apply(b, arguments)
		}
	};
	a = jQuery, b = function () {
		function a() {}
		return a.transitions = {
			"webkitTransition": "webkitTransitionEnd",
			"mozTransition": "mozTransitionEnd",
			"oTransition": "oTransitionEnd",
			"transition": "transitionend"
		}, a.transition = function (a) {
			var b, c, d, e;
			b = a[0], e = this.transitions;
			for (d in e) if (c = e[d], null != b.style[d]) return c
		}, a
	}(), c = function () {
		function c(b) {
			null == b && (b = {}), this.html = d(this.html, this), this.$growl = d(this.$growl, this), this.$growls = d(this.$growls, this), this.animate = d(this.animate, this), this.remove = d(this.remove, this), this.dismiss = d(this.dismiss, this), this.present = d(this.present, this), this.close = d(this.close, this), this.cycle = d(this.cycle, this), this.unbind = d(this.unbind, this), this.bind = d(this.bind, this), this.render = d(this.render, this), this.settings = a.extend({}, c.settings, b), this.$growls().attr("class", this.settings.location), this.render()
		}
		return c.settings = {
			"namespace": "growl",
			"duration": 3200,
			"close": "&times;",
			"location": "default",
			"style": "default",
			"size": "medium"
		}, c.growl = function (a) {
			return null == a && (a = {}), this.initialize(), new c(a)
		}, c.initialize = function () {
			return a("body:not(:has(#growls))").append('<div id="growls" />')
		}, c.prototype.render = function () {
			var a;
			a = this.$growl(), this.$growls().append(a), this.cycle(a)
		}, c.prototype.bind = function (a) {
			return null == a && (a = this.$growl()), a.find("." + this.settings.namespace + "-close").on("click", this.close)
		}, c.prototype.unbind = function (a) {
			return null == a && (a = this.$growl()), a.find("." + (this.settings.namespace - close)).off("click", this.close)
		}, c.prototype.cycle = function (a) {
			return null == a && (a = this.$growl()), a.queue(this.present).delay(this.settings.duration).queue(this.dismiss).queue(this.remove)
		}, c.prototype.close = function (a) {
			var b;
			return a.preventDefault(), a.stopPropagation(), b = this.$growl(), b.stop().queue(this.dismiss).queue(this.remove)
		}, c.prototype.present = function (a) {
			var b;
			return b = this.$growl(), this.bind(b), this.animate(b, "" + this.settings.namespace + "-incoming", "out", a)
		}, c.prototype.dismiss = function (a) {
			var b;
			return b = this.$growl(), this.unbind(b), this.animate(b, "" + this.settings.namespace + "-outgoing", "in", a)
		}, c.prototype.remove = function (a) {
			return this.$growl().remove(), a()
		}, c.prototype.animate = function (a, c, d, e) {
			var f;
			null == d && (d = "in"), f = b.transition(a), a["in" === d ? "removeClass" : "addClass"](c), a.offset().position, a["in" === d ? "addClass" : "removeClass"](c), null != e && (null != f ? a.one(f, e) : e())
		}, c.prototype.$growls = function () {
			return null != this.$_growls ? this.$_growls : this.$_growls = a("#growls")
		}, c.prototype.$growl = function () {
			return null != this.$_growl ? this.$_growl : this.$_growl = a(this.html())
		}, c.prototype.html = function () {
			return "<div class='" + this.settings.namespace + " " + this.settings.namespace + "-" + this.settings.style + " " + this.settings.namespace + "-" + this.settings.size + "'>\n  <div class='" + this.settings.namespace + "-close'>" + this.settings.close + "</div>\n  <div class='" + this.settings.namespace + "-title'>" + this.settings.title + "</div>\n  <div class='" + this.settings.namespace + "-message'>" + this.settings.message + "</div>\n</div>"
		}, c
	}(), a.growl = function (a) {
		return null == a && (a = {}), c.growl(a)
	}, a.growl.error = function (b) {
		var c;
		return null == b && (b = {}), c = {
			"title": "Error!",
			"style": "error"
		}, a.growl(a.extend(c, b))
	}, a.growl.notice = function (b) {
		var c;
		return null == b && (b = {}), c = {
			"title": "Notice!",
			"style": "notice"
		}, a.growl(a.extend(c, b))
	}, a.growl.warning = function (b) {
		var c;
		return null == b && (b = {}), c = {
			"title": "Warning!",
			"style": "warning"
		}, a.growl(a.extend(c, b))
	}
}.call(this), function (a) {}(jQuery), function (a, b, c) {

}(document, Math), function (a, b) {
	"object" == typeof exports ? module.exports = b(require("jquery")) : "function" == typeof define && define.amd ? define(["jquery"], b) : b(a.jQuery)
}(this, function (a) {
/* slimscroll */
}), function (a) {
	jQuery.fn.extend({
		"slimScroll": function (b) {
			var c = {
				"width": "auto",
				"height": "250px",
				"size": "7px",
				"color": "#000",
				"position": "right",
				"distance": "1px",
				"start": "top",
				"opacity": .4,
				"alwaysVisible": !1,
				"disableFadeOut": !1,
				"railVisible": !1,
				"railColor": "#333",
				"railOpacity": .2,
				"railDraggable": !0,
				"railClass": "slimScrollRail",
				"barClass": "slimScrollBar",
				"wrapperClass": "slimScrollDiv",
				"allowPageScroll": !1,
				"wheelStep": 20,
				"touchScrollStep": 200,
				"borderRadius": "7px",
				"railBorderRadius": "7px"
			},
				d = a.extend(c, b);
			return this.each(function () {
				function c(b) {
					if (j) {
						var b = b || window.event,
							c = 0;
						b.wheelDelta && (c = -b.wheelDelta / 120), b.detail && (c = b.detail / 3);
						var f = b.target || b.srcTarget || b.srcElement;
						a(f).closest("." + d.wrapperClass).is(v.parent()) && e(c, !0), b.preventDefault && !u && b.preventDefault(), u || (b.returnValue = !1)
					}
				}
				function e(a, b, c) {
					u = !1;
					var e = a,
						f = v.outerHeight() - A.outerHeight();
					if (b && (e = parseInt(A.css("top")) + a * parseInt(d.wheelStep) / 100 * A.outerHeight(), e = Math.min(Math.max(e, 0), f), e = a > 0 ? Math.ceil(e) : Math.floor(e), A.css({
						"top": e + "px"
					})), p = parseInt(A.css("top")) / (v.outerHeight() - A.outerHeight()), e = p * (v[0].scrollHeight - v.outerHeight()), c) {
						e = a;
						var g = e / v[0].scrollHeight * v.outerHeight();
						g = Math.min(Math.max(g, 0), f), A.css({
							"top": g + "px"
						})
					}
					v.scrollTop(e), v.trigger("slimscrolling", ~~e), h(), i()
				}
				function f() {
					window.addEventListener ? (this.addEventListener("DOMMouseScroll", c, !1), this.addEventListener("mousewheel", c, !1)) : document.attachEvent("onmousewheel", c)
				}
				function g() {
					o = Math.max(v.outerHeight() / v[0].scrollHeight * v.outerHeight(), s), A.css({
						"height": o + "px"
					});
					var a = o == v.outerHeight() ? "none" : "block";
					A.css({
						"display": a
					})
				}
				function h() {
					if (g(), clearTimeout(m), p == ~~p) {
						if (u = d.allowPageScroll, q != p) {
							var a = 0 == ~~p ? "top" : "bottom";
							v.trigger("slimscroll", a)
						}
					} else u = !1;
					return q = p, o >= v.outerHeight() ? void(u = !0) : (A.stop(!0, !0).fadeIn("fast"), void(d.railVisible && z.stop(!0, !0).fadeIn("fast")))
				}
				function i() {
					d.alwaysVisible || (m = setTimeout(function () {
						d.disableFadeOut && j || k || l || (A.fadeOut("slow"), z.fadeOut("slow"))
					}, 1e3))
				}
				var j, k, l, m, n, o, p, q, r = "<div></div>",
					s = 30,
					u = !1,
					v = a(this);
				if (v.parent().hasClass(d.wrapperClass)) {
					var w = v.scrollTop();
					if (A = v.parent().find("." + d.barClass), z = v.parent().find("." + d.railClass), g(), a.isPlainObject(b)) {
						if ("height" in b && "auto" == b.height) {
							v.parent().css("height", "auto"), v.css("height", "auto");
							var x = v.parent().parent().height();
							v.parent().css("height", x), v.css("height", x)
						}
						if ("scrollTo" in b) w = parseInt(d.scrollTo);
						else if ("scrollBy" in b) w += parseInt(d.scrollBy);
						else if ("destroy" in b) return A.remove(), z.remove(), void v.unwrap();
						e(w, !1, !0)
					}
				} else {
					d.height = "auto" == b.height ? v.parent().height() : b.height;
					var y = a(r).addClass(d.wrapperClass).css({
						"position": "relative",
						"overflow": "hidden",
						"width": d.width,
						"height": d.height
					});
					v.css({
						"overflow": "hidden",
						"width": d.width,
						"height": d.height
					});
					var z = a(r).addClass(d.railClass).css({
						"width": d.size,
						"height": "100%",
						"position": "absolute",
						"top": 0,
						"display": d.alwaysVisible && d.railVisible ? "block" : "none",
						"border-radius": d.railBorderRadius,
						"background": d.railColor,
						"opacity": d.railOpacity,
						"zIndex": 90
					}),
						A = a(r).addClass(d.barClass).css({
							"background": d.color,
							"width": d.size,
							"position": "absolute",
							"top": 0,
							"opacity": d.opacity,
							"display": d.alwaysVisible ? "block" : "none",
							"border-radius": d.borderRadius,
							"BorderRadius": d.borderRadius,
							"MozBorderRadius": d.borderRadius,
							"WebkitBorderRadius": d.borderRadius,
							"zIndex": 99
						}),
						B = "right" == d.position ? {
							"right": d.distance
						} : {
							"left": d.distance
						};
					z.css(B), A.css(B), v.wrap(y), v.parent().append(A), v.parent().append(z), d.railDraggable && A.bind("mousedown", function (b) {
						var c = a(document);
						return l = !0, t = parseFloat(A.css("top")), pageY = b.pageY, c.bind("mousemove.slimscroll", function (a) {
							currTop = t + a.pageY - pageY, A.css("top", currTop), e(0, A.position().top, !1)
						}), c.bind("mouseup.slimscroll", function () {
							l = !1, i(), c.unbind(".slimscroll")
						}), !1
					}).bind("selectstart.slimscroll", function (a) {
						return a.stopPropagation(), a.preventDefault(), !1
					}), z.hover(function () {
						h()
					}, function () {
						i()
					}), A.hover(function () {
						k = !0
					}, function () {
						k = !1
					}), v.hover(function () {
						j = !0, h(), i()
					}, function () {
						j = !1, i()
					}), v.bind("touchstart", function (a) {
						a.originalEvent.touches.length && (n = a.originalEvent.touches[0].pageY)
					}), v.bind("touchmove", function (a) {
						if (u || a.originalEvent.preventDefault(), a.originalEvent.touches.length) {
							var b = (n - a.originalEvent.touches[0].pageY) / d.touchScrollStep;
							e(b, !0), n = a.originalEvent.touches[0].pageY
						}
					}), g(), "bottom" === d.start ? (A.css({
						"top": v.outerHeight() - A.outerHeight()
					}), e(0, !0)) : "top" !== d.start && (e(a(d.start).position().top, null, !0), d.alwaysVisible || A.hide()), f()
				}
			}), this
		}
	}), jQuery.fn.extend({
		"slimscroll": jQuery.fn.slimScroll
	})
}
(jQuery), function (a) {}.call(this), 
/* dropdown */
(window.jQuery), function (a) {
	var b = "0.9.3",
		c = {
			"isMsie": function () {
				var a = /(msie) ([\w.]+)/i.exec(navigator.userAgent);
				return a ? parseInt(a[2], 10) : !1
			},
			"isBlankString": function (a) {
				return !a || /^\s*$/.test(a)
			},
			"escapeRegExChars": function (a) {
				return a.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&")
			},
			"isString": function (a) {
				return "string" == typeof a
			},
			"isNumber": function (a) {
				return "number" == typeof a
			},
			"isArray": a.isArray,
			"isFunction": a.isFunction,
			"isObject": a.isPlainObject,
			"isUndefined": function (a) {
				return "undefined" == typeof a
			},
			"bind": a.proxy,
			"bindAll": function (b) {
				var c;
				for (var d in b) a.isFunction(c = b[d]) && (b[d] = a.proxy(c, b))
			},
			"indexOf": function (a, b) {
				for (var c = 0; c < a.length; c++) if (a[c] === b) return c;
				return -1
			},
			"each": a.each,
			"map": a.map,
			"filter": a.grep,
			"every": function (b, c) {
				var d = !0;
				return b ? (a.each(b, function (a, e) {
					return (d = c.call(null, e, a, b)) ? void 0 : !1
				}), !! d) : d
			},
			"some": function (b, c) {
				var d = !1;
				return b ? (a.each(b, function (a, e) {
					return (d = c.call(null, e, a, b)) ? !1 : void 0
				}), !! d) : d
			},
			"mixin": a.extend,
			"getUniqueId": function () {
				var a = 0;
				return function () {
					return a++
				}
			}(),
			"defer": function (a) {
				setTimeout(a, 0)
			},
			"debounce": function (a, b, c) {
				var d, e;
				return function () {
					var f, g, h = this,
						i = arguments;
					return f = function () {
						d = null, c || (e = a.apply(h, i))
					}, g = c && !d, clearTimeout(d), d = setTimeout(f, b), g && (e = a.apply(h, i)), e
				}
			},
			"throttle": function (a, b) {
				var c, d, e, f, g, h;
				return g = 0, h = function () {
					g = new Date, e = null, f = a.apply(c, d)
				}, function () {
					var i = new Date,
						j = b - (i - g);
					return c = this, d = arguments, 0 >= j ? (clearTimeout(e), e = null, g = i, f = a.apply(c, d)) : e || (e = setTimeout(h, j)), f
				}
			},
			"tokenizeQuery": function (b) {
				return a.trim(b).toLowerCase().split(/[\s]+/)
			},
			"tokenizeText": function (b) {
				return a.trim(b).toLowerCase().split(/[\s\-_]+/)
			},
			"getProtocol": function () {
				return location.protocol
			},
			"noop": function () {}
		},
		d = function () {
			var a = /\s+/;
			return {
				"on": function (b, c) {
					var d;
					if (!c) return this;
					for (this._callbacks = this._callbacks || {}, b = b.split(a); d = b.shift();) this._callbacks[d] = this._callbacks[d] || [], this._callbacks[d].push(c);
					return this
				},
				"trigger": function (b, c) {
					var d, e;
					if (!this._callbacks) return this;
					for (b = b.split(a); d = b.shift();) if (e = this._callbacks[d]) for (var f = 0; f < e.length; f += 1) e[f].call(this, {
						"type": d,
						"data": c
					});
					return this
				}
			}
		}(),
		e = function () {
			function b(b) {
				b && b.el || a.error("EventBus initialized without el"), this.$el = a(b.el)
			}
			var d = "typeahead:";
			return c.mixin(b.prototype, {
				"trigger": function (a) {
					var b = [].slice.call(arguments, 1);
					this.$el.trigger(d + a, b)
				}
			}), b
		}(),
		f = function () {
			function a(a) {
				this.prefix = ["__", a, "__"].join(""), this.ttlKey = "__ttl__", this.keyMatcher = new RegExp("^" + this.prefix)
			}
			function b() {
				return (new Date).getTime()
			}
			function d(a) {
				return JSON.stringify(c.isUndefined(a) ? null : a)
			}
			function e(a) {
				return JSON.parse(a)
			}
			var f, g;
			try {
				f = window.localStorage, f.setItem("~~~", "!"), f.removeItem("~~~")
			} catch (h) {
				f = null
			}
			return g = f && window.JSON ? {
				"_prefix": function (a) {
					return this.prefix + a
				},
				"_ttlKey": function (a) {
					return this._prefix(a) + this.ttlKey
				},
				"get": function (a) {
					return this.isExpired(a) && this.remove(a), e(f.getItem(this._prefix(a)))
				},
				"set": function (a, e, g) {
					return c.isNumber(g) ? f.setItem(this._ttlKey(a), d(b() + g)) : f.removeItem(this._ttlKey(a)), f.setItem(this._prefix(a), d(e))
				},
				"remove": function (a) {
					return f.removeItem(this._ttlKey(a)), f.removeItem(this._prefix(a)), this
				},
				"clear": function () {
					var a, b, c = [],
						d = f.length;
					for (a = 0; d > a; a++)(b = f.key(a)).match(this.keyMatcher) && c.push(b.replace(this.keyMatcher, ""));
					for (a = c.length; a--;) this.remove(c[a]);
					return this
				},
				"isExpired": function (a) {
					var d = e(f.getItem(this._ttlKey(a)));
					return c.isNumber(d) && b() > d ? !0 : !1
				}
			} : {
				"get": c.noop,
				"set": c.noop,
				"remove": c.noop,
				"clear": c.noop,
				"isExpired": c.noop
			}, c.mixin(a.prototype, g), a
		}(),
		g = function () {
			function a(a) {
				c.bindAll(this), a = a || {}, this.sizeLimit = a.sizeLimit || 10, this.cache = {}, this.cachedKeysByAge = []
			}
			return c.mixin(a.prototype, {
				"get": function (a) {
					return this.cache[a]
				},
				"set": function (a, b) {
					var c;
					this.cachedKeysByAge.length === this.sizeLimit && (c = this.cachedKeysByAge.shift(), delete this.cache[c]), this.cache[a] = b, this.cachedKeysByAge.push(a)
				}
			}), a
		}(),
		h = function () {
			function b(a) {
				c.bindAll(this), a = c.isString(a) ? {
					"url": a
				} : a, i = i || new g, h = c.isNumber(a.maxParallelRequests) ? a.maxParallelRequests : h || 6, this.url = a.url, this.wildcard = a.wildcard || "%QUERY", this.filter = a.filter, this.replace = a.replace, this.ajaxSettings = {
					"type": "get",
					"cache": a.cache,
					"timeout": a.timeout,
					"dataType": a.dataType || "json",
					"beforeSend": a.beforeSend
				}, this._get = (/^throttle$/i.test(a.rateLimitFn) ? c.throttle : c.debounce)(this._get, a.rateLimitWait || 300)
			}
			function d() {
				j++
			}
			function e() {
				j--
			}
			function f() {
				return h > j
			}
			var h, i, j = 0,
				k = {};
			return c.mixin(b.prototype, {
				"_get": function (a, b) {
					function c(c) {
						var e = d.filter ? d.filter(c) : c;
						b && b(e), i.set(a, c)
					}
					var d = this;
					f() ? this._sendRequest(a).done(c) : this.onDeckRequestArgs = [].slice.call(arguments, 0)
				},
				"_sendRequest": function (b) {
					function c() {
						e(), k[b] = null, f.onDeckRequestArgs && (f._get.apply(f, f.onDeckRequestArgs), f.onDeckRequestArgs = null)
					}
					var f = this,
						g = k[b];
					return g || (d(), g = k[b] = a.ajax(b, this.ajaxSettings).always(c)), g
				},
				"get": function (a, b) {
					var d, e, f = this,
						g = encodeURIComponent(a || "");
					return b = b || c.noop, d = this.replace ? this.replace(this.url, g) : this.url.replace(this.wildcard, g), (e = i.get(d)) ? c.defer(function () {
						b(f.filter ? f.filter(e) : e)
					}) : this._get(d, b), !! e
				}
			}), b
		}(),
		i = function () {
			function d(b) {
				c.bindAll(this), c.isString(b.template) && !b.engine && a.error("no template engine specified"), b.local || b.prefetch || b.remote || a.error("one of local, prefetch, or remote is required"), this.name = b.name || c.getUniqueId(), this.limit = b.limit || 5, this.minLength = b.minLength || 1, this.header = b.header, this.footer = b.footer, this.valueKey = b.valueKey || "value", this.template = e(b.template, b.engine, this.valueKey), this.local = b.local, this.prefetch = b.prefetch, this.remote = b.remote, this.itemHash = {}, this.adjacencyList = {}, this.storage = b.name ? new f(b.name) : null
			}
			function e(a, b, d) {
				var e, f;
				return c.isFunction(a) ? e = a : c.isString(a) ? (f = b.compile(a), e = c.bind(f.render, f)) : e = function (a) {
					return "<p>" + a[d] + "</p>"
				}, e
			}
			var g = {
				"thumbprint": "thumbprint",
				"protocol": "protocol",
				"itemHash": "itemHash",
				"adjacencyList": "adjacencyList"
			};
			return c.mixin(d.prototype, {
				"_processLocalData": function (a) {
					this._mergeProcessedData(this._processData(a))
				},
				"_loadPrefetchData": function (d) {
					function e(a) {
						var b = d.filter ? d.filter(a) : a,
							e = m._processData(b),
							f = e.itemHash,
							h = e.adjacencyList;
						m.storage && (m.storage.set(g.itemHash, f, d.ttl), m.storage.set(g.adjacencyList, h, d.ttl), m.storage.set(g.thumbprint, n, d.ttl), m.storage.set(g.protocol, c.getProtocol(), d.ttl)), m._mergeProcessedData(e)
					}
					var f, h, i, j, k, l, m = this,
						n = b + (d.thumbprint || "");
					return this.storage && (f = this.storage.get(g.thumbprint), h = this.storage.get(g.protocol), i = this.storage.get(g.itemHash), j = this.storage.get(g.adjacencyList)), k = f !== n || h !== c.getProtocol(), d = c.isString(d) ? {
						"url": d
					} : d, d.ttl = c.isNumber(d.ttl) ? d.ttl : 864e5, i && j && !k ? (this._mergeProcessedData({
						"itemHash": i,
						"adjacencyList": j
					}), l = a.Deferred().resolve()) : l = a.getJSON(d.url).done(e), l
				},
				"_transformDatum": function (a) {
					var b = c.isString(a) ? a : a[this.valueKey],
						d = a.tokens || c.tokenizeText(b),
						e = {
							"value": b,
							"tokens": d
						};
					return c.isString(a) ? (e.datum = {}, e.datum[this.valueKey] = a) : e.datum = a, e.tokens = c.filter(e.tokens, function (a) {
						return !c.isBlankString(a)
					}), e.tokens = c.map(e.tokens, function (a) {
						return a.toLowerCase()
					}), e
				},
				"_processData": function (a) {
					var b = this,
						d = {},
						e = {};
					return c.each(a, function (a, f) {
						var g = b._transformDatum(f),
							h = c.getUniqueId(g.value);
						d[h] = g, c.each(g.tokens, function (a, b) {
							var d = b.charAt(0),
								f = e[d] || (e[d] = [h]);
							!~c.indexOf(f, h) && f.push(h)
						})
					}), {
						"itemHash": d,
						"adjacencyList": e
					}
				},
				"_mergeProcessedData": function (a) {
					var b = this;
					c.mixin(this.itemHash, a.itemHash), c.each(a.adjacencyList, function (a, c) {
						var d = b.adjacencyList[a];
						b.adjacencyList[a] = d ? d.concat(c) : c
					})
				},
				"_getLocalSuggestions": function (a) {
					var b, d = this,
						e = [],
						f = [],
						g = [];
					return c.each(a, function (a, b) {
						var d = b.charAt(0);
						!~c.indexOf(e, d) && e.push(d)
					}), c.each(e, function (a, c) {
						var e = d.adjacencyList[c];
						return e ? (f.push(e), void((!b || e.length < b.length) && (b = e))) : !1
					}), f.length < e.length ? [] : (c.each(b, function (b, e) {
						var h, i, j = d.itemHash[e];
						h = c.every(f, function (a) {
							return~c.indexOf(a, e)
						}), i = h && c.every(a, function (a) {
							return c.some(j.tokens, function (b) {
								return 0 === b.indexOf(a)
							})
						}), i && g.push(j)
					}), g)
				},
				"initialize": function () {
					var b;
					return this.local && this._processLocalData(this.local), this.transport = this.remote ? new h(this.remote) : null, b = this.prefetch ? this._loadPrefetchData(this.prefetch) : a.Deferred().resolve(), this.local = this.prefetch = this.remote = null, this.initialize = function () {
						return b
					}, b
				},
				"getSuggestions": function (a, b) {
					function d(a) {
						f = f.slice(0), c.each(a, function (a, b) {
							var d, e = g._transformDatum(b);
							return d = c.some(f, function (a) {
								return e.value === a.value
							}), !d && f.push(e), f.length < g.limit
						}), b && b(f)
					}
					var e, f, g = this,
						h = !1;
					a.length < this.minLength || (e = c.tokenizeQuery(a), f = this._getLocalSuggestions(e).slice(0, this.limit), f.length < this.limit && this.transport && (h = this.transport.get(a, d)), !h && b && b(f))
				}
			}), d
		}(),
		j = function () {
			function b(b) {
				var d = this;
				c.bindAll(this), this.specialKeyCodeMap = {
					"9": "tab",
					"27": "esc",
					"37": "left",
					"39": "right",
					"13": "enter",
					"38": "up",
					"40": "down"
				}, this.$hint = a(b.hint), this.$input = a(b.input).on("blur.tt", this._handleBlur).on("focus.tt", this._handleFocus).on("keydown.tt", this._handleSpecialKeyEvent), c.isMsie() ? this.$input.on("keydown.tt keypress.tt cut.tt paste.tt", function (a) {
					d.specialKeyCodeMap[a.which || a.keyCode] || c.defer(d._compareQueryToInputValue)
				}) : this.$input.on("input.tt", this._compareQueryToInputValue), this.query = this.$input.val(), this.$overflowHelper = e(this.$input)
			}
			function e(b) {
				return a("<span></span>").css({
					"position": "absolute",
					"left": "-9999px",
					"visibility": "hidden",
					"whiteSpace": "nowrap",
					"fontFamily": b.css("font-family"),
					"fontSize": b.css("font-size"),
					"fontStyle": b.css("font-style"),
					"fontVariant": b.css("font-variant"),
					"fontWeight": b.css("font-weight"),
					"wordSpacing": b.css("word-spacing"),
					"letterSpacing": b.css("letter-spacing"),
					"textIndent": b.css("text-indent"),
					"textRendering": b.css("text-rendering"),
					"textTransform": b.css("text-transform")
				}).insertAfter(b)
			}
			function f(a, b) {
				return a = (a || "").replace(/^\s*/g, "").replace(/\s{2,}/g, " "), b = (b || "").replace(/^\s*/g, "").replace(/\s{2,}/g, " "), a === b
			}
			return c.mixin(b.prototype, d, {
				"_handleFocus": function () {
					this.trigger("focused")
				},
				"_handleBlur": function () {
					this.trigger("blured")
				},
				"_handleSpecialKeyEvent": function (a) {
					var b = this.specialKeyCodeMap[a.which || a.keyCode];
					b && this.trigger(b + "Keyed", a)
				},
				"_compareQueryToInputValue": function () {
					var a = this.getInputValue(),
						b = f(this.query, a),
						c = b ? this.query.length !== a.length : !1;
					c ? this.trigger("whitespaceChanged", {
						"value": this.query
					}) : b || this.trigger("queryChanged", {
						"value": this.query = a
					})
				},
				"destroy": function () {
					this.$hint.off(".tt"), this.$input.off(".tt"), this.$hint = this.$input = this.$overflowHelper = null
				},
				"focus": function () {
					this.$input.focus()
				},
				"blur": function () {
					this.$input.blur()
				},
				"getQuery": function () {
					return this.query
				},
				"setQuery": function (a) {
					this.query = a
				},
				"getInputValue": function () {
					return this.$input.val()
				},
				"setInputValue": function (a, b) {
					this.$input.val(a), !b && this._compareQueryToInputValue()
				},
				"getHintValue": function () {
					return this.$hint.val()
				},
				"setHintValue": function (a) {
					this.$hint.val(a)
				},
				"getLanguageDirection": function () {
					return (this.$input.css("direction") || "ltr").toLowerCase()
				},
				"isOverflow": function () {
					return this.$overflowHelper.text(this.getInputValue()), this.$overflowHelper.width() > this.$input.width()
				},
				"isCursorAtEnd": function () {
					var a, b = this.$input.val().length,
						d = this.$input[0].selectionStart;
					return c.isNumber(d) ? d === b : document.selection ? (a = document.selection.createRange(), a.moveStart("character", -b), b === a.text.length) : !0
				}
			}), b
		}(),
		k = function () {
			function b(b) {
				c.bindAll(this), this.isOpen = !1, this.isEmpty = !0, this.isMouseOverDropdown = !1, this.$menu = a(b.menu).on("mouseenter.tt", this._handleMouseenter).on("mouseleave.tt", this._handleMouseleave).on("click.tt", ".tt-suggestion", this._handleSelection).on("mouseover.tt", ".tt-suggestion", this._handleMouseover)
			}
			function e(a) {
				return a.data("suggestion")
			}
			var f = {
				"suggestionsList": '<span class="tt-suggestions"></span>'
			},
				g = {
					"suggestionsList": {
						"display": "block"
					},
					"suggestion": {
						"whiteSpace": "nowrap",
						"cursor": "pointer"
					},
					"suggestionChild": {
						"whiteSpace": "normal"
					}
				};
			return c.mixin(b.prototype, d, {
				"_handleMouseenter": function () {
					this.isMouseOverDropdown = !0
				},
				"_handleMouseleave": function () {
					this.isMouseOverDropdown = !1
				},
				"_handleMouseover": function (b) {
					var c = a(b.currentTarget);
					this._getSuggestions().removeClass("tt-is-under-cursor"), c.addClass("tt-is-under-cursor")
				},
				"_handleSelection": function (b) {
					var c = a(b.currentTarget);
					this.trigger("suggestionSelected", e(c))
				},
				"_show": function () {
					this.$menu.css("display", "block")
				},
				"_hide": function () {
					this.$menu.hide()
				},
				"_moveCursor": function (a) {
					var b, c, d, f;
					if (this.isVisible()) {
						if (b = this._getSuggestions(), c = b.filter(".tt-is-under-cursor"), c.removeClass("tt-is-under-cursor"), d = b.index(c) + a, d = (d + 1) % (b.length + 1) - 1, -1 === d) return void this.trigger("cursorRemoved"); - 1 > d && (d = b.length - 1), f = b.eq(d).addClass("tt-is-under-cursor"), this._ensureVisibility(f), this.trigger("cursorMoved", e(f))
					}
				},
				"_getSuggestions": function () {
					return this.$menu.find(".tt-suggestions > .tt-suggestion")
				},
				"_ensureVisibility": function (a) {
					var b = this.$menu.height() + parseInt(this.$menu.css("paddingTop"), 10) + parseInt(this.$menu.css("paddingBottom"), 10),
						c = this.$menu.scrollTop(),
						d = a.position().top,
						e = d + a.outerHeight(!0);
					0 > d ? this.$menu.scrollTop(c + d) : e > b && this.$menu.scrollTop(c + (e - b))
				},
				"destroy": function () {
					this.$menu.off(".tt"), this.$menu = null
				},
				"isVisible": function () {
					return this.isOpen && !this.isEmpty
				},
				"closeUnlessMouseIsOverDropdown": function () {
					this.isMouseOverDropdown || this.close()
				},
				"close": function () {
					this.isOpen && (this.isOpen = !1, this.isMouseOverDropdown = !1, this._hide(), this.$menu.find(".tt-suggestions > .tt-suggestion").removeClass("tt-is-under-cursor"), this.trigger("closed"))
				},
				"open": function () {
					this.isOpen || (this.isOpen = !0, !this.isEmpty && this._show(), this.trigger("opened"))
				},
				"setLanguageDirection": function (a) {
					var b = {
						"left": "0",
						"right": "auto"
					},
						c = {
							"left": "auto",
							"right": " 0"
						};
					this.$menu.css("ltr" === a ? b : c)
				},
				"moveCursorUp": function () {
					this._moveCursor(-1)
				},
				"moveCursorDown": function () {
					this._moveCursor(1)
				},
				"getSuggestionUnderCursor": function () {
					var a = this._getSuggestions().filter(".tt-is-under-cursor").first();
					return a.length > 0 ? e(a) : null
				},
				"getFirstSuggestion": function () {
					var a = this._getSuggestions().first();
					return a.length > 0 ? e(a) : null
				},
				"renderSuggestions": function (b, d) {
					var e, h, i, j, k, l = "tt-dataset-" + b.name,
						m = '<div class="tt-suggestion">%body</div>',
						n = this.$menu.find("." + l);
					0 === n.length && (h = a(f.suggestionsList).css(g.suggestionsList), n = a("<div></div>").addClass(l).append(b.header).append(h).append(b.footer).appendTo(this.$menu)), d.length > 0 ? (this.isEmpty = !1, this.isOpen && this._show(), i = document.createElement("div"), j = document.createDocumentFragment(), c.each(d, function (c, d) {
						d.dataset = b.name, e = b.template(d.datum), i.innerHTML = m.replace("%body", e), k = a(i.firstChild).css(g.suggestion).data("suggestion", d), k.children().each(function () {
							a(this).css(g.suggestionChild)
						}), j.appendChild(k[0])
					}), n.show().find(".tt-suggestions").html(j)) : this.clearSuggestions(b.name), this.trigger("suggestionsRendered")
				},
				"clearSuggestions": function (a) {
					var b = this.$menu.find(a ? ".tt-dataset-" + a : '[class^="tt-dataset-"]'),
						c = b.find(".tt-suggestions");
					b.hide(), c.empty(), 0 === this._getSuggestions().length && (this.isEmpty = !0, this._hide())
				}
			}), b
		}(),
		l = function () {
			function b(a) {
				var b, d, f;
				c.bindAll(this), this.$node = e(a.input), this.datasets = a.datasets, this.dir = null, this.eventBus = a.eventBus, b = this.$node.find(".tt-dropdown-menu"), d = this.$node.find(".tt-query"), f = this.$node.find(".tt-hint"), this.dropdownView = new k({
					"menu": b
				}).on("suggestionSelected", this._handleSelection).on("cursorMoved", this._clearHint).on("cursorMoved", this._setInputValueToSuggestionUnderCursor).on("cursorRemoved", this._setInputValueToQuery).on("cursorRemoved", this._updateHint).on("suggestionsRendered", this._updateHint).on("opened", this._updateHint).on("closed", this._clearHint).on("opened closed", this._propagateEvent), this.inputView = new j({
					"input": d,
					"hint": f
				}).on("focused", this._openDropdown).on("blured", this._closeDropdown).on("blured", this._setInputValueToQuery).on("enterKeyed tabKeyed", this._handleSelection).on("queryChanged", this._clearHint).on("queryChanged", this._clearSuggestions).on("queryChanged", this._getSuggestions).on("whitespaceChanged", this._updateHint).on("queryChanged whitespaceChanged", this._openDropdown).on("queryChanged whitespaceChanged", this._setLanguageDirection).on("escKeyed", this._closeDropdown).on("escKeyed", this._setInputValueToQuery).on("tabKeyed upKeyed downKeyed", this._managePreventDefault).on("upKeyed downKeyed", this._moveDropdownCursor).on("upKeyed downKeyed", this._openDropdown).on("tabKeyed leftKeyed rightKeyed", this._autocomplete)
			}
			function e(b) {
				var c = a(g.wrapper),
					d = a(g.dropdown),
					e = a(b),
					f = a(g.hint);
				c = c.css(h.wrapper), d = d.css(h.dropdown), f.css(h.hint).css({
					"backgroundAttachment": e.css("background-attachment"),
					"backgroundClip": e.css("background-clip"),
					"backgroundColor": e.css("background-color"),
					"backgroundImage": e.css("background-image"),
					"backgroundOrigin": e.css("background-origin"),
					"backgroundPosition": e.css("background-position"),
					"backgroundRepeat": e.css("background-repeat"),
					"backgroundSize": e.css("background-size")
				}), e.data("ttAttrs", {
					"dir": e.attr("dir"),
					"autocomplete": e.attr("autocomplete"),
					"spellcheck": e.attr("spellcheck"),
					"style": e.attr("style")
				}), e.addClass("tt-query").attr({
					"autocomplete": "off",
					"spellcheck": !1
				}).css(h.query);
				try {
					!e.attr("dir") && e.attr("dir", "auto")
				} catch (i) {}
				return e.wrap(c).parent().prepend(f).append(d)
			}
			function f(a) {
				var b = a.find(".tt-query");
				c.each(b.data("ttAttrs"), function (a, d) {
					c.isUndefined(d) ? b.removeAttr(a) : b.attr(a, d)
				}), b.detach().removeData("ttAttrs").removeClass("tt-query").insertAfter(a), a.remove()
			}
			var g = {
				"wrapper": '<span class="twitter-typeahead"></span>',
				"hint": '<input class="tt-hint" type="text" autocomplete="off" spellcheck="off" disabled>',
				"dropdown": '<span class="tt-dropdown-menu"></span>'
			},
				h = {
					"wrapper": {
						"position": "relative",
						"display": "inline-block"
					},
					"hint": {
						"position": "absolute",
						"top": "0",
						"left": "0",
						"borderColor": "transparent",
						"boxShadow": "none"
					},
					"query": {
						"position": "relative",
						"verticalAlign": "top",
						"backgroundColor": "transparent"
					},
					"dropdown": {
						"position": "absolute",
						"top": "100%",
						"left": "0",
						"zIndex": "100",
						"display": "none"
					}
				};
			return c.isMsie() && c.mixin(h.query, {
				"backgroundImage": "url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)"
			}), c.isMsie() && c.isMsie() <= 7 && (c.mixin(h.wrapper, {
				"display": "inline",
				"zoom": "1"
			}), c.mixin(h.query, {
				"marginTop": "-1px"
			})), c.mixin(b.prototype, d, {
				"_managePreventDefault": function (a) {
					var b, c, d = a.data,
						e = !1;
					switch (a.type) {
					case "tabKeyed":
						b = this.inputView.getHintValue(), c = this.inputView.getInputValue(), e = b && b !== c;
						break;
					case "upKeyed":
					case "downKeyed":
						e = !d.shiftKey && !d.ctrlKey && !d.metaKey
					}
					e && d.preventDefault()
				},
				"_setLanguageDirection": function () {
					var a = this.inputView.getLanguageDirection();
					a !== this.dir && (this.dir = a, this.$node.css("direction", a), this.dropdownView.setLanguageDirection(a))
				},
				"_updateHint": function () {
					var a, b, d, e, f, g = this.dropdownView.getFirstSuggestion(),
						h = g ? g.value : null,
						i = this.dropdownView.isVisible(),
						j = this.inputView.isOverflow();
					h && i && !j && (a = this.inputView.getInputValue(), b = a.replace(/\s{2,}/g, " ").replace(/^\s+/g, ""), d = c.escapeRegExChars(b), e = new RegExp("^(?:" + d + ")(.*$)", "i"), f = e.exec(h), this.inputView.setHintValue(a + (f ? f[1] : "")))
				},
				"_clearHint": function () {
					this.inputView.setHintValue("")
				},
				"_clearSuggestions": function () {
					this.dropdownView.clearSuggestions()
				},
				"_setInputValueToQuery": function () {
					this.inputView.setInputValue(this.inputView.getQuery())
				},
				"_setInputValueToSuggestionUnderCursor": function (a) {
					var b = a.data;
					this.inputView.setInputValue(b.value, !0)
				},
				"_openDropdown": function () {
					this.dropdownView.open()
				},
				"_closeDropdown": function (a) {
					this.dropdownView["blured" === a.type ? "closeUnlessMouseIsOverDropdown" : "close"]()
				},
				"_moveDropdownCursor": function (a) {
					var b = a.data;
					b.shiftKey || b.ctrlKey || b.metaKey || this.dropdownView["upKeyed" === a.type ? "moveCursorUp" : "moveCursorDown"]()
				},
				"_handleSelection": function (a) {
					var b = "suggestionSelected" === a.type,
						d = b ? a.data : this.dropdownView.getSuggestionUnderCursor();
					d && (this.inputView.setInputValue(d.value), b ? this.inputView.focus() : a.data.preventDefault(), b && c.isMsie() ? c.defer(this.dropdownView.close) : this.dropdownView.close(), this.eventBus.trigger("selected", d.datum, d.dataset))
				},
				"_getSuggestions": function () {
					var a = this,
						b = this.inputView.getQuery();
					c.isBlankString(b) || c.each(this.datasets, function (c, d) {
						d.getSuggestions(b, function (c) {
							b === a.inputView.getQuery() && a.dropdownView.renderSuggestions(d, c)
						})
					})
				},
				"_autocomplete": function (a) {
					var b, c, d, e, f;
					("rightKeyed" !== a.type && "leftKeyed" !== a.type || (b = this.inputView.isCursorAtEnd(), c = "ltr" === this.inputView.getLanguageDirection() ? "leftKeyed" === a.type : "rightKeyed" === a.type, b && !c)) && (d = this.inputView.getQuery(), e = this.inputView.getHintValue(), "" !== e && d !== e && (f = this.dropdownView.getFirstSuggestion(), this.inputView.setInputValue(f.value), this.eventBus.trigger("autocompleted", f.datum, f.dataset)))
				},
				"_propagateEvent": function (a) {
					this.eventBus.trigger(a.type)
				},
				"destroy": function () {
					this.inputView.destroy(), this.dropdownView.destroy(), f(this.$node), this.$node = null
				},
				"setQuery": function (a) {
					this.inputView.setQuery(a), this.inputView.setInputValue(a), this._clearHint(), this._clearSuggestions(), this._getSuggestions()
				}
			}), b
		}();
	!
	function () {
		var b, d = {},
			f = "ttView";
		b = {
			"initialize": function (b) {
				function g() {
					var b, d = a(this),
						g = new e({
							"el": d
						});
					b = c.map(h, function (a) {
						return a.initialize()
					}), d.data(f, new l({
						"input": d,
						"eventBus": g = new e({
							"el": d
						}),
						"datasets": h
					})), a.when.apply(a, b).always(function () {
						c.defer(function () {
							g.trigger("initialized")
						})
					})
				}
				var h;
				return b = c.isArray(b) ? b : [b], 0 === b.length && a.error("no datasets provided"), h = c.map(b, function (a) {
					var b = d[a.name] ? d[a.name] : new i(a);
					return a.name && (d[a.name] = b), b
				}), this.each(g)
			},
			"destroy": function () {
				function b() {
					var b = a(this),
						c = b.data(f);
					c && (c.destroy(), b.removeData(f))
				}
				return this.each(b)
			},
			"setQuery": function (b) {
				function c() {
					var c = a(this).data(f);
					c && c.setQuery(b)
				}
				return this.each(c)
			}
		}, jQuery.fn.typeahead = function (a) {
			return b[a] ? b[a].apply(this, [].slice.call(arguments, 1)) : b.initialize.apply(this, arguments)
		}
	}()
}(window.jQuery), function (a) {
}(window.jQuery), function (a) {
}(jQuery), function (a) {
	var b = {};
	if (a.ajaxPrefilter) a.ajaxPrefilter(function (a, c, d) {
		var e = a.port;
		"abort" === a.mode && (b[e] && b[e].abort(), b[e] = d)
	});
	else {
		var c = a.ajax;
		a.ajax = function (d) {
			var e = ("mode" in d ? d : a.ajaxSettings).mode,
				f = ("port" in d ? d : a.ajaxSettings).port;
			return "abort" === e ? (b[f] && b[f].abort(), b[f] = c.apply(this, arguments), b[f]) : c.apply(this, arguments)
		}
	}
}(jQuery), 
function (a, b, c) {}(window, document), 

Emitter.prototype.on = function (a, b) {}, Emitter.prototype.once = function (a, b) {
	function c() {
		d.off(a, c), b.apply(this, arguments)
	}
	var d = this;
	return this._callbacks = this._callbacks || {}, b._off = c, this.on(a, c), this
}, Emitter.prototype.off = Emitter.prototype.removeListener = Emitter.prototype.removeAllListeners = function (a, b) {
	this._callbacks = this._callbacks || {};
	var c = this._callbacks[a];
	if (!c) return this;
	if (1 == arguments.length) return delete this._callbacks[a], this;
	var d = c.indexOf(b._off || b);
	return~d && c.splice(d, 1), this
}, Emitter.prototype.emit = function (a) {
	this._callbacks = this._callbacks || {};
	var b = [].slice.call(arguments, 1),
		c = this._callbacks[a];
	if (c) {
		c = c.slice(0);
		for (var d = 0, e = c.length; e > d; ++d) c[d].apply(this, b)
	}
	return this
}, Emitter.prototype.listeners = function (a) {
	return this._callbacks = this._callbacks || {}, this._callbacks[a] || []
}, Emitter.prototype.hasListeners = function (a) {
	return !!this.listeners(a).length
}, 
function () {}.call(this), 
/* small screen */
function () {
	var a, b, c, d, e, f;
	$.fn.modal && $.fn.Vague && $("html").hasClass("not-ie") && (e = $.fn.modal.Constructor.prototype.show, d = $.fn.modal.Constructor.prototype.hide, a = null, f = !1, c = function () {
		return f ? void 0 : (a || (a = $("#main-wrapper").Vague({
			"intensity": 3,
			"forceSVGUrl": !1
		})), a.blur(), f = !0)
	}, b = function () {
		return f ? (a && a.unblur(), f = !1) : void 0
	}, $.fn.modal.Constructor.prototype.show = function () {
		return e.call(this), this.$element.hasClass("modal-blur") ? ($("body").append(this.$element), "desktop" === getScreenSize($("#small-screen-width-point"), $("#tablet-screen-width-point")) && c(), $(window).on("pa.resize.modal_blur", function () {
			return "desktop" === getScreenSize($("#small-screen-width-point"), $("#tablet-screen-width-point")) ? c() : b()
		})) : b()
	}, $.fn.modal.Constructor.prototype.hide = function () {
		return d.call(this), b(), $(window).off("pa.resize.modal_blur").on("hidden", ".modal", function () {
			return alert("asd")
		})
	})
}.call(this);