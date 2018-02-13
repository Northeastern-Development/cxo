class Newsletter {
  constructor(el) {
    this.$form = $(el);
    this.$formInputs = this.$form.find('input');
    this.$formMsg = this.$form.find('.form-message');
    this.$successMsg = this.$form.find('.success-message');
    this.$errorMsg = this.$form.find('.error-message');
    this.$submitButton = this.$form.find('input[name=submit]');

    this.messages = {
      memberExists: 'You\'ve already signed up! Try checking your email for a message from CXO Magazine in order to confirm your subscription.',
      invalidEmail: 'Please provide a valid email address.',
      success: 'Thanks for signing up! You will receive an email to confirm your subscription.'
    };

    this.init();
  }

  init() {
    this.$form.on('submit', this.submitForm.bind(this));
  }

  deinit() {
    this.$form.off('submit');
  }

  submitForm(e) {
    e.preventDefault();
    let _this = this;

    this.$form = $(e.target);
    this.$formInputs.on('focus', _this.clearFormMessage.bind(_this));

    let formData = {
      'action': 'mailchimp_subscribe',
      'email_address': this.$form.find('input[name=EMAIL]').val(),
      'first_name': this.$form.find('input[name=FNAME]').val(),
      'last_name': this.$form.find('input[name=LNAME]').val()
    }

    if (this.validateEmail(formData.email_address)) {

      $.ajax({
        type: 'POST',
        url: ajax_url,
        data: formData,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        beforeSend: _this.beforeSubmit.bind(_this),
        error: _this.showError.bind(_this),
        success: _this.onResponse.bind(_this)
      });

      this.$submitButton.attr('disabled', false);
      this.$form.removeClass('loading');
    } else {
      this.showError(this.messages.invalidEmail);
    }
  }

  validateEmail(emailVal) {
    return Boolean(emailVal.match(/[^@]+@[^@]+\.[a-z]/));
  }

  showError(errorRes) {
    let errorText = errorRes ? errorRes : 'Something went wrong. Please try again later';

    this.$errorMsg.addClass('active');
    this.$errorMsg.text(errorText);
  }

  beforeSubmit() {
    this.clearFormMessage();
    this.$form.addClass('loading');
    this.$submitButton.attr('disabled', true);
  }

  onResponse(res) {
    let response = res ? JSON.parse(res) : res;

    if (!res) {
      this.showError();
    }
    else if (response.title === 'Member Exists') {
      this.showError(this.messages.memberExists);
    }
    else if (response.title === 'Invalid Resource') {
      this.showError(this.messages.invalidEmail);
    }
    else {
      this.$form[0].reset();
      this.$successMsg.addClass('active');
      this.$successMsg.text(this.messages.success);
    }
  }

  clearFormMessage() {
    this.$formMsg.removeClass('active');
    this.$formMsg.text('');
  }
}

export default Newsletter;
