(function( root, $, undefined ) {
	"use strict";

	$(function () {
		let workshops = $("*[data-post-type=\"workshop\"]");
		let classes = $("*[data-post-type=\"class\"]");
		$(".modal").modal({
			show: false
		});
		$("#testimonial-carousel").carousel();
		$("#btn-select-classes").off().on("click", function() {
			if (classes) {
				classes.appendTo("#classes-list");
				classes = null;
			}
			workshops.detach();
			$(this).button("toggle");
		});
		$("#btn-select-workshops").off().on("click", function() {
			if (workshops) {
				workshops.appendTo("#classes-list");
				workshops = null;
			}
			classes.detach();
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
		$('.js-multi-class-dropdown').on('hidden.bs.dropdown', () => {
			$('.js-multi-class-item:checked').each((key, item) => {
				item.checked = false;
			});
		});

		$('.js-request-class').on('click', function() {
			const $modal = $('.js-request-class-modal');
			$modal.find('.modal-title').html(`Request ${this.dataset.requestedClass} Class`);
			$modal.find('.modal-body').find('input[type="hidden"]').val(this.dataset.requestedClass);
			$modal.modal('show');
		});

		$('.js-join-waitlist').on('click', function() {
			const $modal = $('.js-join-waitlist-modal');
			$modal.find('.modal-title').html(`Join the waiting list for ${this.dataset.requestedClass}`);
			$modal.find('.modal-body').find('input[type="hidden"]').val(this.dataset.requestedClass);
			$modal.modal('show');
		});

		$('.js-free-rsvp-btn').on('click', function() {
			const $modal = $('.js-free-rsvp');
			$modal.find('.modal-title').html(`RSVP for ${this.dataset.itemName}`);
			$modal.find('.modal-body').find('input[type="hidden"]').val(this.dataset.mailchimpTagName);
			$modal.modal('show');
		});

		$('.ninja-form-submission').on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
		});

		$('.js-trigger-detailed-directions-modal').on('click', function() {
			const $modal = $('.js-detailed-directions-modal');
			$modal.find('.modal-title').html(this.dataset.detailedDirectionsPostTitle);
			$modal.find('.modal-body').html(this.dataset.detailedDirectionsPostContent);
			$modal.modal('show');
		});

		$('.js-trigger-email-newsletter-modal').on('click', function() {
			const $modal = $('.js-email-newsletter-modal');
			$modal.modal('show');
		});

	// END ON LOAD
	});
} ( this, jQuery ));
