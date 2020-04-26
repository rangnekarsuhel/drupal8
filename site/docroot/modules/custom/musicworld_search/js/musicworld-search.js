/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function($, Drupal) {
Drupal.musicWorldSearch = Drupal.MusicWorld || {};

Drupal.behaviors.actionMusicWorldSearch = {
		attach: function(context) {
      Drupal.musicWorldSearch.exposedOption();
		}
	};

  Drupal.musicWorldSearch.exposedOption = function() {
      $("input#edit-cfield-keyword").val('');
      $("input#edit-track-title").val('');
      $("input#edit-album-title").val('');
      $("input#edit-artist-title").val('');
      
    $("#sidebar-second #edit-cfield-artist-id").on("change", function(event) {
      var slectedArtist = $(this).val();
      $("#sidebar-second #edit-aritst-target-id").val(slectedArtist);
      
      $("#sidebar-second #edit-album-target-id").val('');
      $("#sidebar-second #edit-cfield-album-id").val('');      
      
      $("#sidebar-second input#edit-track-title").val('');
      $("#sidebar-second input#edit-album-title").val('');
      $("#sidebar-second input#edit-artist-title").val('');
    });
    $("#sidebar-second #edit-cfield-album-id").on("change", function(event) {
      var slectedAlbum = $(this).val();
      $("#sidebar-second #edit-album-target-id").val(slectedAlbum);
      
      $("#sidebar-second #edit-aritst-target-id").val('');
      $("#sidebar-second #edit-cfield-artist-id").val('');
      $("#sidebar-second input#edit-track-title").val('');
      $("#sidebar-second input#edit-album-title").val('');
      $("#sidebar-second input#edit-artist-title").val('');
    });
    
    /*$("input#edit-submit-track").click(function(){
      var key = $("#edit-cfield-keyword").val();
      alert(key);
    });*/
    
    $("input#edit-cfield-keyword" ).keyup(function() {
      var value = $( this ).val();
      $("input#edit-track-title").val(value);
      $("input#edit-album-title").val(value);
      $("input#edit-artist-title").val(value);
      
      $("#edit-album-target-id").val('');
      $("#edit-cfield-album-id").val('');      
      $("#edit-aritst-target-id").val('');
      $("#edit-cfield-artist-id").val('');
    });
    
    $("input#edit-submit-track").click(function() {
     // $("input#edit-cfield-keyword").val('');
     // $("input#edit-track-title").val('');
     // $("input#edit-album-title").val('');
     // $("input#edit-artist-title").val('');
    });
  
	}

})(jQuery, Drupal);