$(document).ready(function() {
  $('#ami_panel_base').draggable({ scroll: true, cursor: "move" });
  $('#search_btn').click(function() {
    var ami_id = $('#search_input').val();
    $.getJSON('/api/v1/' + ami_id, function(data) {
      var vertical_center   = $(window).height() / 2;
      var horizontal_center = $(window).width() / 2;

      // generate AMI Panel
      $('#ami_panel_base').css({
        'position': 'absolute',
        'top':  vertical_center - 50,
        'left': horizontal_center - 160
      });
      var ami_panel = $('.ami_panel').clone();
      ami_panel.appendTo('#ami_panel_base').fadeIn();
      ami_panel.find('.ami_id').text(data['ami-id']);
      ami_panel.find('.region').text(data['region']);

      // generate Parent AMI Panel
      if (data['parents']) {
        for (i = 0; i < data['parents'].length; i++) {
          var parentage_panel = $('.ami_parentage_panel').clone();
          parentage_panel.appendTo('#ami_panel_base').css({
            'top':  vertical_center - 38 * (data['parents'].length - i) - 84,
          }).fadeIn();
          parentage_panel.find('.ami_id').text(data['parents'][i]);
        }
      }
    });
    return false;
  });
  $('.ami_panel').css('display', 'none');
  $('.ami_parentage_panel').css('display', 'none');
});
