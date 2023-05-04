(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.avImg = {
    attach: function (context, settings) {
      $(context).ajaxStop(function () {
        $(this).find('.ui-dialog').each(function () {
          $(this).css('background-image', 'url(' + settings.av_img_url + ')');
        });
      });
    }
  };

})(jQuery, Drupal, drupalSettings);
