(function( root, $, undefined ) {
	"use strict";

	$(function () {
		$.getScript('https://js.stripe.com/v3/')
		.done(function() {
			/* jshint ignore:start */
			var stripe = Stripe(stripePaymentSettings.liveApiKey);
			// var stripe = Stripe(stripePaymentSettings.testApiKey);
			var elements = stripe.elements({
				fonts: [
					{
					  cssSrc: 'https://fonts.googleapis.com/css?family=Lato',
					},
				  ],
				locale: 'auto'
			});
			var style = {
				base: {
					fontFamily: "Lato, Helvetica, Arial, sans-serif",
					iconColor: '#444',

					':-webkit-autofill': {
						color: '#fce883',
					},
					'::placeholder': {
						color: '#999',
					},
				},
				invalid: {
					iconColor: '#a94442',
					color: '#a94442'
				},
				complete: {
					iconColor: '#3c763d',
					color: '#3c763d'
				}
			};
			var card = elements.create('card',
			{
				iconStyle: 'solid',
				style: style,
				classes: {
					base: 'form-control'
				}
			});
			window.card = card;
			card.mount('#card-element');
			card.addEventListener('change', function(event) {
				var displayError = document.getElementById('card-errors');
				if (event.error) {
				  displayError.textContent = event.error.message;
				} else {
				  displayError.textContent = '';
				}
			  });

			$('body').on('click', '.js-checkout-btn', function(e) {
				e.preventDefault();
				const data = this.dataset;
				const { itemCost, itemId, itemType, itemName, itemDate, isMulti = false } = this.dataset;
				let totalCost = itemCost * 100;
				let paymentPostId = itemId;
				document.getElementById('js-payment-post-id').value = itemId;
				if (itemType === 'show') {
					document.getElementById('js-payment-class-sale').style.display = "none";
					document.getElementById('js-payment-modal-header').textContent = 'Get your tickets!';
					document.getElementById('js-payment-item-date').textContent = itemDate;
					document.getElementById('js-payment-processing-fee-total').textContent = formatCurrency(getProcessingFee(totalCost));
					totalCost = totalCost + getProcessingFee(totalCost);
				} else if (itemType === 'class') {
					document.getElementById('js-payment-ticket-sale').style.display = "none";
					if (!isMulti) {
						document.getElementById('js-payment-item-summary').style.display = "none";
					} else {
						let keysList = []; // Used for tagging classes, e.g., "Scene Doctor 1"
						let datesList = [];
						let singleClassIds = [];
						$('.js-multi-class-item').map((key, item) => {
							if (item.checked) {
								keysList.push(key + 1);
								datesList.push(item.dataset.classDate);
								singleClassIds.push(item.dataset.singleClassId);
							}
						});
						document.getElementById('js-payment-item-date').textContent = datesList.join(", ");
						document.getElementById('js-stripe-item-keys').value = keysList.join(",");
						paymentPostId = singleClassIds;
						totalCost = totalCost * datesList.length;
					}
					document.getElementById('js-payment-modal-header').textContent = `Sign up for ${itemName}!`;
					$('#js-payment-ticket-quantity').hide();
					$('#js-payment-processing-fee').hide();
				}
				$('#js-stripe-payment-submit').text(`Pay ${formatCurrency(totalCost)}`);
				document.getElementById('js-payment-item-cost').value = itemCost;
				document.getElementById('js-stripe-item-type').value = itemType;
				document.getElementById('js-stripe-total-cost').value = totalCost;
				document.getElementById('js-stripe-item-name').textContent = itemName;
				document.getElementById('js-stripe-item-id').value = itemId;
				document.getElementById('js-payment-post-id').value = paymentPostId;
				$('#js-stripe-payment-form').modal('show');
			});

			$('body').on('change', '#js-stripe-item-quantity', function() {
				const itemCost = document.getElementById('js-payment-item-cost').value;
				let totalCost = itemCost * this.value * 100;
				if (document.getElementById('js-stripe-item-type').value === 'show') {
					document.getElementById('js-payment-processing-fee-total').textContent = formatCurrency(getProcessingFee(totalCost));
					totalCost = totalCost + getProcessingFee(totalCost);
				}
				document.getElementById('js-stripe-total-cost').value = totalCost;
				$('#js-stripe-payment-submit').text(`Pay ${formatCurrency(totalCost)}`);
			});

			$('body').on('submit', '#stripe-payment-form', async function(e) {
				e.preventDefault();
				const firstName = document.getElementById('js-stripe-first-name').value;
				const lastName = document.getElementById('js-stripe-last-name').value;
				const {token, error} = await stripe.createToken(card);

				if (error) {
				  // Inform the customer that there was an error.
				  const errorElement = document.getElementById('card-errors');
				  errorElement.textContent = error.message;
				} else {
				  stripeTokenHandler(token);
				}
			});

			// Don't close the dropdown after clicking on a checkbox
			$('body').on('click', '.js-multi-class-item-toggle', (e) => {
				e.stopPropagation();
			});
			/* jshint ignore:end */
		});
	// End on load
	});
	function submitPaymentForm(form) {
		$('#js-stripe-payment-form-spinner').show();
		return $.ajax({
			method: 'POST',
			url: stripePaymentSettings.ajaxUrl,
			data: {
				action: 'rountree_stripe_payment_submit',
				token: document.getElementById('js-stripe-token').value,
				firstName: document.getElementById('js-stripe-first-name').value,
				lastName: document.getElementById('js-stripe-last-name').value,
				emailAddress: document.getElementById('js-stripe-email-address').value,
				itemQuantity: document.getElementById('js-stripe-item-quantity').value,
				itemName: document.getElementById('js-stripe-item-name').textContent,
				itemKeys: document.getElementById('js-stripe-item-keys').value,
				itemType: document.getElementById('js-stripe-item-type').value,
				emailSignUp: document.getElementById('js-stripe-subscribe-newsletter').checked,
				amount: Math.round(document.getElementById('js-stripe-total-cost').value),
				itemId: document.getElementById('js-stripe-item-id').value,
				paymentPostId: document.getElementById('js-payment-post-id').value
			},
			dataType: 'json'
		})
		.success(function(response) {
			if (response && !response.success) {
				$('#js-payment-modal-header').text('An error occurred...');
				$('#stripe-payment-form').hide();
				$('#js-stripe-error-message').show();
				return;
			}
			const { 
				amount, 
				description, 
				metadata: { first_name, quantity, item_name, item_type }, 
				receipt_email, 
				source: { last4 } 
			} = response.data;
			const totalCost = `$${(amount / 100).toFixed(2)}`;
			$('#js-payment-modal-header').text('Purchase complete!');
			$('#js-payment-success-first-name').text(first_name);
			$('#js-payment-success-item-name').text(item_name);
			$('#js-payment-success-card-last-four').text(`*${last4}`);
			$('#js-payment-success-total-cost').text(totalCost);
			$('#js-payment-success-email-address').text(receipt_email);
			if (item_type === 'show') {
				$('#js-payment-success-show-ticket-quantity').text(`${quantity} ticket(s) to`).show();
			}
			$('#stripe-payment-form').hide();
			$('#js-stripe-success-message').show();
			$('#js-stripe-payment-form-spinner').hide();
		})
		.error((response) => {
			$('#js-payment-modal-header').text('An error occurred...');
			$('#stripe-payment-form').hide();
			$('#js-stripe-error-message').show();
		})
		.complete(() => {
			$('#js-stripe-payment-form-spinner').hide();
		});
	}
	$('#js-stripe-payment-form').on('hidden.bs.modal', function() {
		resetForm();
	});

	const resetForm = () => {
		$('#stripe-payment-form').show();
		$('#js-stripe-success-message').hide();
		$('#js-stripe-error-message').hide();
		$('#stripe-payment-form')[0].reset();
		window.card.clear();
	}

	window.submitPaymentForm = submitPaymentForm;
}(this, jQuery));

const stripeTokenHandler = (token) => {
	document.getElementById('js-stripe-token').setAttribute('value', token.id);
	submitPaymentForm(form);
};

// Add the Stripe processing fee of 2.9% plus 30 cents per transaction
const getProcessingFee = (amount) => {
	return ((amount * 1.029) + 30) - amount;
};

const getTotalWithProcessingFee = (amount) => {
	return getProcessingFee(amount) + amount;
};

const formatCurrency = (amount) => {
	return `$${(amount / 100).toFixed(2)}`;
};
