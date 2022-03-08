const maskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  },
  options = {
    onKeyPress: function (val, e, field, options) {
      field.mask(maskBehavior.apply({}, arguments), options);
    },
  };

const CpfCnpjMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
  },
  cpfCnpjpOptions = {
    onKeyPress: function (val, e, field, options) {
      field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
    }
  };

function click_removeCartItem() {
  let $this = $(this),
    $form = $this.closest('form');

  $this.addClass('d-none');
  $this.parent().next('.loading').removeClass('d-none');

  $form.trigger('submit');
}

$.fn.button = function (action) {
  if (action === 'loading' && this.data('loading-text')) {
    this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
  }
  if (action === 'reset' && this.data('original-text')) {
    this.html(this.data('original-text')).prop('disabled', false);
  }
};

$(function () {
  $('.cpf_cnpj').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
  $('.cpf').mask('000.000.000-00');
  $('.cnpj').mask('00.000.000/0000-00');
  $('.date').mask('00/00/0000');
  $('.phone-mask').mask(maskBehavior, options);
  $('.time').mask('00:00');
  $('.zipcode').mask('00000-000');
  $('.number').mask('0#');
  /* $('.number-decimal').maskMoney({
      allowZero: true,
      allowEmpty: true,
      prefix: '',
      thousands: '',
      decimal: ',',
      precision: 2,
      affixesStay: true
  }); */
  $('.remove-item').on('click', click_removeCartItem);
  $('.add-coupon-button').on('click', function () {
    if ($('#coupon').val().length > 0) {
      $(this).button('loading');
      $(this).closest('form').trigger('submit');
    }
  });
  $(".botaoFooter").on("click", function () {
    let $this = $(this),
      $form = $this.closest("form"),
      $formWrapper = $this.closest(".subscribe-form"),
      $responseMessage = $formWrapper.find('.newsletterMessage'),
      isValid = $form[0].reportValidity(),
      formData = $form.serialize();

    if (isValid) {
      $.ajax({
        url: "/ajax/newsletter",
        type: "POST",
        data: formData,
        beforeSend: function () {
          $this.button("loading");
        },
      })
        .done(function (data) {
          if (data.status === true) {
            $formWrapper.html(`
                        <div class="alert alert-success mb-0" role="alert">
                            ${data.message}
                        </div>`);
          } else {
            $this.button("reset");
            $responseMessage.html(`
                        <div class="alert alert-danger alert-dismissible fade show mb-0 mt-2" role="alert">
                            Erro ao cadastrar e-mail.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
          }
        })
        .fail(function (error) {
          $this.button("reset");
          $responseMessage.html(`
                    <div class="alert alert-danger alert-dismissible fade show mb-0 mt-2" role="alert">
                        Erro ao cadastrar e-mail.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
        });
    }
  });
});
