/*
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 *
 * THIS had to be added so that the hash change event is handled by IE8.  uggh.  it is slow to do it though.
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($,e,b){var c="hashchange",h=document,f,g=$.event.special,i=h.documentMode,d="on"+c in e&&(i===b||i>7);function a(j){j=j||location.href;return"#"+j.replace(/^[^#]*#?(.*)$/,"$1")}$.fn[c]=function(j){return j?this.bind(c,j):this.trigger(c)};$.fn[c].delay=50;g[c]=$.extend(g[c],{setup:function(){if(d){return false}$(f.start)},teardown:function(){if(d){return false}$(f.stop)}});f=(function(){var j={},p,m=a(),k=function(q){return q},l=k,o=k;j.start=function(){p||n()};j.stop=function(){p&&clearTimeout(p);p=b};function n(){var r=a(),q=o(m);if(r!==m){l(m=r,q);$(e).trigger(c)}else{if(q!==m){location.href=location.href.replace(/#.*/,"")+q}}p=setTimeout(n,$.fn[c].delay)}$.browser.msie&&!d&&(function(){var q,r;j.start=function(){if(!q){r=$.fn[c].src;r=r&&r+a();q=$('<iframe tabindex="-1" title="empty"/>').hide().one("load",function(){r||l(a());n()}).attr("src",r||"javascript:0").insertAfter("body")[0].contentWindow;h.onpropertychange=function(){try{if(event.propertyName==="title"){q.document.title=h.title}}catch(s){}}}};j.stop=k;o=function(){return a(q.location.href)};l=function(v,s){var u=q.document,t=$.fn[c].domain;if(v!==s){u.title=h.title;u.open();t&&u.write('<script>document.domain="'+t+'"<\/script>');u.close();q.location.hash=v}}})();return j})()})(jQuery,this);
/* Author:

*/
var shiftWindow = function() {
	// adjust the viewport to handle fixed anchor links.  Does not work on REFRESH
	setTimeout(windowShifter, 100);
};

function windowShifter(){
	// adjust for the fixed main header
	var adjustment = $("#branding").outerHeight() * -1;

	// if logged into WP adjust for the admin bar
	if($("#wpadminbar").length >0 ){
		adjustment -= $("#wpadminbar").outerHeight();
	}
	adjustment = parseInt(adjustment, 10);
	window.scrollBy(0, adjustment);
	//console.log('shifted by ' + adjustment + ' pixels');
}

$().ready( 
	function(){
		if(location.hash.length >0) {
			// delay the scroll so it works in Safari.
			var delay = 50; //milliseconds
			setTimeout(shiftWindow, delay);
		}
		$(window).hashchange(shiftWindow);
	}
);


//affixed side bar
$().ready( 
  function(){
    var $window = $(window)
    // side bar
    $('.affixed-sidenav').affix({
      offset: {
        top: function () { return $window.width() <= 980 ? 290 : 210 }
      , bottom: 270
      }
    })
}
);
/* Author:

*/




