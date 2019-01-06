<div id="js-stripe-payment-form" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 id="js-payment-modal-header" class="modal-title"></h5>
      </div>
      <form id="stripe-payment-form">
        <div class="modal-body">
          <div>
            <div id="js-payment-item-summary" class="well">
              Buying tickets for <span id="js-stripe-item-name"></span> on <span id="js-payment-item-date"></span>
            </div>
            <div class="form-group">
              <label for="js-stripe-first-name">First Name</label>
              <input type="text" class="form-control" id="js-stripe-first-name" placeholder="Enter first name" required="true">
            </div>
            <div class="form-group">
              <label for="js-stripe-last-name">Last Name</label>
              <input type="text" class="form-control" id="js-stripe-last-name" placeholder="Enter last name" required="true">
            </div>
            <div class="form-group">
              <label for="js-stripe-email-address">Email address</label>
              <input type="email" class="form-control" id="js-stripe-email-address" placeholder="Enter email address" required="true">
            </div>
            <div id="js-payment-ticket-quantity" class="form-group">
              <label for="js-stripe-item-quantity">Quantity</label>
              <select id="js-stripe-item-quantity" class="form-control">
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
                <option value="5">Five</option>
                <option value="6">Six</option>
              </select>
            </div>
            <div class="form-group">
              <label for="card-element">Credit or Debit card</label>
              <div id="card-element"></div>
              <div id="card-errors" class="small text-danger" role="alert"></div>
            </div>
            <div class="form-group checkbox">
              <label>
                <input type="checkbox" id="js-stripe-subscribe-newsletter">
                Sign me up for monthly updates about classes and shows!
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
            <button id="js-stripe-payment-submit" type="submit" class="btn btn-lg btn-primary"></button>
            <p id="js-payment-processing-fee" class="text-right">
              <small>A credit card processing fee of <span id="js-payment-processing-fee-total"></span> has been added to the total amount.</small>
            </p>
        </div>
        <input id="js-payment-post-id" type="hidden" />
        <input id="js-payment-item-cost" type="hidden" />
        <input id="js-stripe-item-type" type="hidden" />
        <input id="js-stripe-total-cost" type="hidden" />
        <input id="js-stripe-token" type="hidden" />
      </form>
      <div id="js-stripe-success-message" style="display: none;">
        <div class="modal-body">
          <p>
            Thanks, <span id="js-payment-success-first-name"></span>! Your payment for <span id="js-payment-success-show-ticket-quantity" style="display: none;"></span> <span id="js-payment-success-item-name"></span> was successfully processed.
          </p>
          <p>
            Your card ending in <span id="js-payment-success-card-last-four"></span> was charged for <span id="js-payment-success-total-cost"></span>. You'll receive an email receipt at <span id="js-payment-success-email-address"></span>.
          </p>
        </div>
      </div>
      <div id="js-stripe-error-message" style="display: none;">
        <div class="modal-body">
          Sorry, an error occurred while processing your payment. Please try again.
        </div>
      </div>
    </div>
    <div id="js-stripe-payment-form-spinner" class="spinner-container" style="display: none;">
      <div class="spinner">
        <i class="fas fa-spinner"></i>
      </div>
    </div>
  </div>
</div>