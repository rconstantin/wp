(function (win, $){
  win.w4swp = {
    hook: function () {
      $(".color-picker").spectrum({
        preferredFormat: "hex",
        showInput: true
      });
    }
  };
})(window, jQuery);