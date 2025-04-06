jQuery(document).ready(function($) {
   // Show/hide other game field based on checkbox
   $('#other_game_checkbox').change(function() {
       if ($(this).is(':checked')) {
           $('#other_game').show();
       } else {
           $('#other_game').hide().val('');
       }
   });
});