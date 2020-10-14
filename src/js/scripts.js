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
			$modal.modal('show');
			$modal.find('.modal-body').find('input[type="hidden"]').val(this.dataset.requestedClass);
		});

		$('.js-join-waitlist').on('click', function() {
			const $modal = $('.js-join-waitlist-modal');
			$modal.find('.modal-title').html(`Join the waiting list for ${this.dataset.requestedClass}`);
			$modal.find('.modal-body').find('input[type="hidden"]').val(this.dataset.requestedClass);
			$modal.modal('show');
		});

		$('.js-show-rsvp-btn').on('click', function() {
			const $modal = $('.js-show-rsvp-modal');
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

		$('#js-close-page-banner').on('click', function() {
			$('#js-page-banner').addClass('hide');
		});


	const setRequestedClassField = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo(Backbone.Radio.channel('form-3'), 'before:submit', (model) => {
				model.getFieldByKey('class_requested_1525965758012').set('value', $('.js-request-class-modal').find('input[type="hidden"]').val());
			});
		}
	});
	new setRequestedClassField();

	const setWaitlistClassField = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo(Backbone.Radio.channel('form-4'), 'before:submit', (model) => {
				model.getFieldByKey('hidden_1546799796262').set('value', $('.js-join-waitlist').find('input[type="hidden"]').val());
			});
		}
	});
	new setWaitlistClassField();

	const setMailchimpTagNameForLandingPage = Marionette.Object.extend( {
		initialize: function() {
			// THIS DEPENDS ON THE MAILCHIMP TAG NAME BEING THE FIRST HIDDEN FIELD. IT'S FRAGILE AND DUMB, BUT IT'S ALL WE CAN DO.
			this.listenTo(Backbone.Radio.channel('form-5'), 'before:submit', (model) => {
				model.getFieldByKey('hidden_1564971965940').set('value', $('.js-landing-page-form').find('input[type="hidden"]').val());
			});
		}
	});
	new setMailchimpTagNameForLandingPage();


	const setMailchimpTagNameForRSVP = Marionette.Object.extend( {
		initialize: function() {
			this.listenTo(Backbone.Radio.channel('form-6'), 'before:submit', (model) => {
				model.getFieldByKey('hidden_1564971965940').set('value', $('.js-show-rsvp-modal').find('input[type="hidden"]').val());
			});
		}
	});
	new setMailchimpTagNameForRSVP();

	// END ON LOAD
	});
} ( this, jQuery ));