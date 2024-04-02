(function($) {
  $.spapp = function(options) {
    var config, routes = {};

    config = $.extend({
      defaultView  : null,
      templateDir  : '/',
      pageNotFound : false
    }, options );

    // Set default view if not specified
    if (!config.defaultView) {
      config.defaultView = $("main#spapp > section:first-child").attr("id");
    }

    $("main#spapp > section").each(function(k, e) {
      var elm = $(this);
      routes[elm.attr("id")] = {
        view     : elm.attr("id"),
        load     : elm.data("load"),
        onCreate : function() { },
        onReady  : function() { }
      }
    });

    // Update routes programmatically
    this.route = function(options) { $.extend(routes[options.view], options); }

    // Manage hash change
    var routeChange = function() {
      var id    = location.hash.slice(1);
      var route = routes[id];
      var elm   = $("#" + id);

      if (!elm || !route) {
        if (config.pageNotFound) {
          window.location.hash = config.pageNotFound;
          return;
        }
        console.log(id + " not defined");
        return;
      }

      if (elm.hasClass("spapp-created")) {
        route.onReady();
      } else {
        elm.addClass("spapp-created");
        if (!route.load) {
          route.onCreate();
          route.onReady();
        } else {
          elm.load(config.templateDir + route.load, function() {
            route.onCreate();
            route.onReady();
          });
        }
      }
    }

    // Run SPAPP
    this.run = function() {
      window.addEventListener('hashchange', function() { routeChange(); });
      if (!window.location.hash) { window.location.hash = config.defaultView; } else { routeChange(); }
    }

    return this;
  };
}(jQuery));
