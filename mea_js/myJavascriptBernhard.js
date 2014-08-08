var $jq = jQuery.noConflict();
$jq(function () {
	$jq("#siteNavigation").css({"height": "32", "clear": "both", "overflow": "hidden"});
	$jq("#main-topics")./*addClass("nav nav-pills").*/hover(
		function() {
			$jq("#siteNavigation").stop().animate({height: 140}, 800);
		},
		function() {
			$jq("#siteNavigation").stop().animate({height: 32}, 500);
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
