var $jq = jQuery.noConflict();
$jq(function () {
	$jq("#site-navigation").css({"height": "35", "clear": "both", "overflow": "hidden"});
	$jq("#main-topics")./*addClass("nav nav-pills").*/hover(
		function() {
			$jq("#site-navigation").stop().animate({height: 120}, 800);
		},
		function() {
			$jq("#site-navigation").stop().animate({height: 35}, 500);
		}
	);
	$jq(".headingList").hover(
		function() {
			$jq(this).css({"color": "#000"})
		},
		function() {
			$jq(this).css({"color": "#08C"})
		}

	);
});
