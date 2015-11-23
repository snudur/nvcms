$(document).foundation('equalizer','reflow');

$(document).foundation({
	offcanvas : {
		// Sets method in which offcanvas opens.
		// [ move | overlap_single | overlap ]
		open_method: 'overlap_single', 
		// Should the menu close when a menu link is clicked?
		// [ true | false ]
		close_on_click : false
	},
	equalizer : {
		// Specify if Equalizer should make elements equal height once they become stacked.
		equalize_on_stack: true,
		// Allow equalizer to resize hidden elements
		act_on_hidden_el: true
	}
});

$(document).foundation('equalizer','reflow');

$(document).ready(function() {

});