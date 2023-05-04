(function ($, Drupal, cookies) {
  'use strict';

  Drupal.behaviors.ageVerification = {
    attach: function (context) {
      const age_verified = cookies.get('age_verified');
      if (age_verified != true) {
        $(context).find('body')
          .once('age-verification')
          .each(function () {
            var ajaxSettings = {
              url: '/age-verification'
            };
            var myAjaxObject = Drupal.ajax(ajaxSettings);
            myAjaxObject.execute();
          });
      }
    }
  };

})(jQuery, Drupal, window.Cookies);
