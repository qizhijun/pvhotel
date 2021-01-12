define(function(){
	var iDialog = (function() {
		var f = '<header>						<dl>							<dd><label>{title}</label></dd>							<dd><span onclick="this.parentNode.parentNode.parentNode.parentNode.classList.remove(\'on\');">{close}</span></dd>						</dl>					</header>					<article class="dialogContent">{content}</article>					<footer></footer>';
		var d = {
			wrapper: null,
			cover: null,
			lastIndex: 1000,
			list: null
		};
		var e = function() {
				this.options = {
					id: "dialogWindow_",
					classList: "",
					type: "",
					wrapper: "",
					title: "",
					close: "",
					content: "",
					cover: true,
					btns: []
				}
			};
		e.prototype = {
			init: function() {
				if (d.list) {
					return this
				} else {
					d.list = {}
				}
				var a = document.createElement("section");
				a.setAttribute("id", id = "dialoger");
				var b = document.createElement("div");
				b.setAttribute("class", "dialogCover");
				a.appendChild(b);
				d.container = a;
				d.cover = b;
				document.body.insertBefore(d.container, document.body.childNodes[0]);
				return this
			},
			open: function(c) {
				window.scrollTo(0, 0);
				this.init();
				this.options = e.merge(this.options, c || {});
				this.options.zIndex = d.lastIndex += 100;
				this.options.id = "dialogWindow_" + this.options.zIndex;
				d.list[this.options.id] = this;
				this.options.wrapper = document.createElement("div");
				this.options.wrapper.setAttribute("data-type", this.options.type);
				this.options.wrapper.setAttribute("id", this.options.id);
				this.options.wrapper.setAttribute("class", "dialogWindow on " + this.options.classList);
				this.options.wrapper.setAttribute("style", "z-index:" + this.options.zIndex);
				this.options.wrapper.innerHTML = iTemplate.makeList(f, [this.options], function(g, h) {});
				d.container.insertBefore(this.options.wrapper, this.options.cover ? d.cover : null);
				document.getElementById("dialoger").style.zIndex=1984;
				document.getElementById("dialoger").style.display="block";
				if (this.options.btns.length) {
					var b = this;
					var a = document.createElement("div");
					a.setAttribute("class", "box");
					for (var i = 0, j; j = this.options.btns[i]; i++) {
						(function(l) {
							var h = document.createElement("a");
							h.setAttribute("href", "javascript:;");
							h.setAttribute("class", "dialogBtn");
							h.innerHTML = l.name;
							if (l.fn) {
								h.onclick = function() {
									l.fn.call(this, b)
								}
							}
							var g = document.createElement("div");
							g.appendChild(h);
							a.appendChild(g)
						})(j)
					}
					this.options.wrapper.querySelectorAll("footer")[0].appendChild(a)
				}
				return this
			},
			show: function() {
				var a = this.options.wrapper.classList;
				a.add("on");
				return this
			},
			hide: function() {
				var a = this.options.wrapper.classList;
				a.remove("on");
				return this
			},
			die: function() {
				try {
					var b = this;
					this.hide();
					document.getElementById("dialoger").style.zIndex=0;
					document.getElementById("dialoger").style.display="none";
					setTimeout(function() {
						delete d.list[b.options.id];
						d.container.removeChild(b.options.wrapper)
					}, 300)
				} catch (a) {
					var xx=document.getElementById("dialoger");
					xx.parentNode.removeChild(xx);
				} finally {}
				return this
			}
		};
		e.merge = function(b, c, a) {
			for (var h in c) {
				b[h] = c[h]
			}
			return b
		};
		return e
	})();
	var iTemplate = (function() {
		var b = function() {};
		b.prototype = {
			makeList: function(o, a, k) {
				var m = [],
					l = [],
					q = /{(.+?)}/g,
					p = {},
					n = 0;
				for (var r in a) {
					if (typeof k === "function") {
						p = k.call(this, r, a[r], n++) || {}
					}
					m.push(o.replace(q, function(d, c) {
						return (c in p) ? p[c] : (undefined === a[r][c] ? a[r] : a[r][c])
					}))
				}
				return m.join("")
			}
		};
		return new b()
	})();
	return iDialog;
});