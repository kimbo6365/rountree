let classes, workshops;

(function( root, $, undefined ) {
	"use strict";

	$(function () {
		$(".modal").modal();
		$("#testimonial-carousel").carousel();
		$("#btn-select-classes").off().on("click", function() {
			if (classes) {
				classes.appendTo("#classes-list");
				classes = null;
			}
			workshops = $("*[data-post-category=\"3\"]").detach();
			$(this).button("toggle");
		});
		$("#btn-select-workshops").off().on("click", function() {
			if (workshops) {
				workshops.appendTo("#classes-list");
				workshops = null;
			}
			classes = $("*[data-post-category=\"2\"]").detach();
			$(this).button("toggle");
		});
		$("#btn-select-all").off().on("click", function() {
			if (workshops) {
				workshops.appendTo("#classes-list");
				workshops = null;
			}
			if (classes) {
				classes .appendTo("#classes-list");
				classes = null;
			}
			$(this).button("toggle");
		});

		if ($(window).width() < 480) {
			let activeNavItem;
			if ($('.current-menu-item').length >0) {
				activeNavItem = $('.current-menu-item');
			} else if ($('.current_page_parent').length > 0) {
				activeNavItem = $('.current_page_parent');
			} else if ($('.current-menu-parent').length > 0) {
				activeNavItem = $('.current-menu-parent');
			}
			const navDropDown = activeNavItem.clone();
			activeNavItem.addClass('disabled-nav-item');
			navDropDown.addClass('nav-toggle').insertBefore(".nav ul");

			$('.nav-toggle').on('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				$(this).siblings('ul').slideToggle();
				$(this).find('a').toggleClass('rotated');
			});
		}

	// END ON LOAD
	});
} ( this, jQuery ));
