(function ($) {
  Drupal.datauy_cordoba = Drupal.datauy_cordoba || {};

  Drupal.datauy_cordoba.uploadCompleteCallback = function(up, files) {
    if (up.total.uploaded == up.files.length) {
      jQuery(".plupload_buttons").css("display", "inline");
      jQuery(".plupload_upload_status").css("display", "inline");
    }
  }
})(jQuery);
