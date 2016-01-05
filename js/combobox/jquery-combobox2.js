  $(function() {
    $( "#combobox" ).combobox();
    $( "#combobox2" ).combobox();
    $( "#combobox3" ).combobox();
    $( "#combobox4" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
      $( "#combobox2" ).toggle();
      $( "#combobox3" ).toggle();
      $( "#combobox4" ).toggle();
    });
  });