// Generated by CoffeeScript 1.6.3
(function() {
  $(function() {
    return $(".js_cbox_all").click(function(e) {
      var a;
      a = $(this).parents("table").find(".js_cbox,.js_cbox_all");
      if ($(this).filter(":checked").length) {
        $.each(a, function() {
          this.checked = true;
          return true;
        });
      } else {
        $.each(a, function() {
          this.checked = false;
          return true;
        });
      }
      return true;
    });
  });

  window.Pager = function(dom, c, a, params, pager, ajax) {
    var a2, b2, className, has_ellipsis, i, last, link, next, p;
    if (pager.page_count <= 1) {
      return '';
    }
    ajax || (ajax = false);
    className = ajax ? 'pager_' + ajax.className : false;
    last = false;
    if (pager.page > 1) {
      params.p = pager.page - 1;
      last = {
        id: ajax ? className + params.p : false,
        href: getUrl(c, a, params)
      };
    }
    next = false;
    if (pager.page < pager.page_count) {
      params.p = pager.page + 1;
      next = {
        id: ajax ? className + params.p : false,
        href: getUrl(c, a, params)
      };
    }
    p = {
      className: className,
      last: last,
      next: next,
      list: []
    };
    b2 = pager.page - 2;
    a2 = pager.page + 2;
    has_ellipsis = false;
    i = 1;
    while (i <= pager.page_count) {
      if ((i >= b2 && i <= a2) || i === 1 || i === pager.page_count) {
        params.p = i;
        link = {
          ellipsis: false,
          id: ajax ? className + i : false,
          href: getUrl(c, a, params),
          name: i,
          select: i === pager.page
        };
      } else {
        link = has_ellipsis ? false : {
          ellipsis: true
        };
        has_ellipsis = true;
      }
      link && p.list.push(link);
      i++;
    }
    dom.html(pagerTemplate.render(p));
    if (ajax) {
      return dom.find('[id^=' + className + ']').click(function() {
        p = this.id.replace(className, '');
        ajax.params.p = p;
        oneAjax(ajax.c, ajax.a, ajax.params, ajax.callback, this);
        return false;
      });
    }
  };

  window.time = function() {
    return Math.floor(STIME + (new Date().getTime() - CTIME) / 1000);
  };

  window.getUrl = function(c, a, p) {
    var arr, i, k, l, param, pieces, url;
    if (a === undefined) {
      pieces = c.split("/");
      arr = URLCACHE;
      i = 0;
      while (i < pieces.length) {
        if (arr[pieces[i]]) {
          arr = arr[pieces[i]];
        }
        i++;
      }
      return BASEURL + "/" + c + "?v=" + arr;
    } else {
      url = void 0;
      param = void 0;
      if (typeof a === "string") {
        url = BASEURI + "/" + c + "/" + a;
        param = p;
      } else {
        url = BASEURI + "/" + c;
        param = a;
      }
      if (param) {
        l = [];
        for (k in param) {
          l.push(encodeURIComponent(k) + "=" + encodeURIComponent(param[k]));
        }
        l.length > 0 && (url += "?" + l.join("&"));
      }
      return url;
    }
  };

  window.dateFormat = function(time, flag) {
    var date, ret;
    date = new Date(time * 1000);
    ret = '';
    if (!flag || flag === 1) {
      ret = "" + (date.getFullYear()) + "-" + (date.getMonth() + 1) + "-" + (date.getDate());
    } else if (flag === 2) {
      ret = "" + (date.getFullYear()) + "-" + (date.getMonth() + 1) + "-" + (date.getDate()) + " " + (date.getHours()) + ":" + (date.getMinutes()) + ":" + (date.getSeconds());
    }
    return ret;
  };

  window.oneAjax = function(c, a, data, succ_callback, dom, hasFile) {
    var fail, k_disable, settings, succ;
    if (hasFile == null) {
      hasFile = false;
    }
    if (dom) {
      k_disable = 0;
      $(dom).each(function() {
        if ($(this).data("k_disable")) {
          k_disable = 1;
        }
        return true;
      });
      if (k_disable) {
        return false;
      } else {
        $(dom).data("k_disable", 1);
      }
    }
    succ = function(obj) {
      dom && $(dom).data("k_disable", 0);
      if (obj === null || typeof obj !== "object" || !obj.code) {
        fail("", "parsererror", "");
      } else if (obj.code === "-1") {
        fail("", "servererror", obj.msg);
      } else {
        succ_callback(obj);
      }
      return true;
    };
    fail = function(jqXHR, textStatus, errorThrown) {
      dom && $(dom).data("k_disable", 0);
      if (jqXHR.status === 0 && textStatus === "error") {
        alert("ajax error: " + errorThrown);
      } else if (textStatus === "parsererror") {
        alert('ajax parsererror');
      } else if (textStatus === "servererror") {
        alert("ajax servererror: " + errorThrown);
      } else {
        alert('ajax error: other');
      }
      return true;
    };
    settings = {
      url: getUrl(c, a),
      data: data,
      dataType: "json",
      type: "POST",
      success: succ,
      error: fail
    };
    if (hasFile) {
      settings.processData = settings.contentType = false;
    }
    return $.ajax(settings);
  };

  window.State = {};

  (function() {
    State.forward = function(c, a, p) {
      return document.location.href = getUrl(c, a, p);
    };
    State.replace = function(c, a, p) {
      return document.location.replace(getUrl(c, a, p));
    };
    return State.back = function(n) {
      n = n || 0;
      return history.go(-n);
    };
  })();

}).call(this);
