//
// FUNCTIONS
//
function cartItemsTemplate(items) {
  if (items.length > 0) {
    let $html = "";
    for (let key in items) {
      let link =
        items[key].type == "trail"
          ? "trilhas-conhecimento"
          : `cursos/${items[key].category_slug}`;

      $html += `<div class="cart-item__box">
                <a href="/${link}/${items[key].slug}"
                    class="cart-item__link">
                    <div class="row align-items-center mx-0">
                        <div class="col-1 d-flex align-items-center justify-content-center px-0 text-center">
                            <span class="remove-cart-item text-center" title="Remover item"
                                data-item-type="${items[key].type}"
                                data-item-id="${items[key].id}">
                                <i class="fas fa-times red-text"></i>
                            </span>
                        </div>
                        <div class="col-5 pr-0">
                            <div class="item-image">
                                <img class="img-fluid" src="${
        items[key].type == "trail"
          ? items[key].cover_details
          : items[key].image
      }"
                                    title="${items[key].title}" alt="${
        items[key].title
      }" />
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="item-description">
                                <p class="area-category-title mb-0">${
        items[key].type === "trail"
          ? "Trilha"
          : items[key].category_title
      }</p>
                                <p class="item-title mb-0">${
        items[key].title
      }</p>
                            </div>
                        </div>
                        <div class="col-11 offset-1">
                            <p class="mb-0 item-price">R$ ${
        items[key].price
      }</p>
                        </div>
                    </div>
                </a>
            </div>`;
    }

    return $html;
  }
}

function click_addItemCart(event) {
  event.preventDefault();

  let $this = $(this),
    $form = $this.closest("form"),
    action = $form[0].action,
    formData = $form.serialize();

  $.ajax({
    url: `${action}`,
    type: "POST",
    data: formData,
    beforeSend: function () {
      $this.button("loading");
    },
  })
    .done(function (data) {
      if (data.ok === true) {
        if (data.total > 0) {
          let $html = cartItemsTemplate(data.items);
          $(".cart-details__wrapper").hide();
          $(".cart .arrow-down > i").removeClass("fa-rotate-180");
          $(".cart-items").text(data.total);
          $(".cart-button").addClass("has-items");
          $(".subtotal").text(data.parcelado);
          $(".cart-details__wrapper--content .card-body").html($html);
          $this.hide();
          $this.next(".go-checkout-button").show();
        }
      }
    })
    .fail(function (error) {
    })
    .always(function () {
      $this.button("reset");
    });
}

function click_openCartDetails(event) {
  let $this = $(this),
    $parent = $this.parent();

  toggleCartContainer($parent);
}

function click_removeCartItem(event) {
  event.stopImmediatePropagation();
  event.preventDefault();

  let $this = $(this),
    $item = $this.closest(".cart-item__box"),
    type = $this.data("itemType"),
    id = $this.data("itemId"),
    cartItems = parseInt($(".cart-items:visible").text());

  $.ajax({
    url: `/ajax/cart/remove/${type}/${id}`,
    type: "POST",
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    beforeSend: showCartLoading,
  })
    .done(function (data) {
      if (data.ok === true) {
        $item.fadeOut("slow", function () {
          $(this).remove();
        });

        if ((--cartItems) <= 0) {
          cartItems = 0;
        }

        $(".cart-items").text(cartItems);

        if (cartItems === 0) {
          // $('.cart-details__wrapper').remove();
          // $('.arrow-down').remove();
          $(".cart-button").removeClass("has-items");
        }
      }
    })
    .fail(function (error) {
    })
    .always(hideCartLoading);
}

function countLines(target) {
  let style = window.getComputedStyle(target, null);
  let height = parseInt(style.getPropertyValue("height"));
  let font_size = parseInt(style.getPropertyValue("font-size"));
  let line_height = parseInt(style.getPropertyValue("line-height"));
  let box_sizing = style.getPropertyValue("box-sizing");

  if (isNaN(line_height)) line_height = font_size * 1.2;

  if (box_sizing === "border-box") {
    let padding_top = parseInt(style.getPropertyValue("padding-top"));
    let padding_bottom = parseInt(style.getPropertyValue("padding-bottom"));
    let border_top = parseInt(style.getPropertyValue("border-top-width"));
    let border_bottom = parseInt(
      style.getPropertyValue("border-bottom-width")
    );
    height =
      height - padding_top - padding_bottom - border_top - border_bottom;
  }
  let lines = Math.ceil(height / line_height);
  return lines;
}

function doSearch(e) {
  let $form = $(e.currentTarget);

  if ($form.find('input[name="q"]').val().length > 0) {
    return;
  }
  e.preventDefault();
}

function hideCartLoading() {
  $(".cart-loading").hide();
}

function showCartLoading() {
  $(".cart-loading").show();
}

function toggleCartContainer(el) {
  el.find(".cart-details__wrapper").slideToggle();
  el.find(".arrow-down > i").toggleClass("fa-rotate-180");
  $("#cart-list-overlay").toggleClass("active");
}

function updateTextLimiter() {
  let windowWidth = $(window).width(),
    limitLines = windowWidth < 768 ? 10 : 5;
  $(".course-description").each(function () {
    let $this = $(this);
    if (countLines($this[0]) > limitLines) {
      $this.addClass("truncate");
      $this.next(".btn-read-more").removeClass("d-none");
      $this.next(".btn-show-more").show();
    }
  });
}

$(function () {
  //
  // CONSTANTS AND VARIABLES
  //
  const maskBehavior = function (val) {
      return val.replace(/\D/g, "").length === 11
        ? "(00) 00000-0000"
        : "(00) 0000-00009";
    },
    options = {
      onKeyPress: function (val, e, field, options) {
        field.mask(maskBehavior.apply({}, arguments), options);
      },
    };
  let scroll = new SmoothScroll('a[href*="#"]', {updateURL: false});

  //
  // PLUGINS INITIALIZE
  //
  $.fn.button = function (action) {
    if (action === "loading" && this.data("loading-text")) {
      this.data("original-text", this.html())
        .html(this.data("loading-text"))
        .prop("disabled", true);
    }
    if (action === "reset" && this.data("original-text")) {
      this.html(this.data("original-text")).prop("disabled", false);
    }
  };
  $('[data-toggle="tooltip"]').tooltip();
  $(".phone-mask").mask(maskBehavior, options);

  if ($.fn.paroller) {
    $('.paroller').paroller();
  }

  if ($("#card-floating").length > 0) {
    $("#card-floating").stickySidebar({
      containerSelector: "#trail__wrapper",
      innerWrapperSelector: ".card-floating__inner",
      topSpacing: 0,
      bottomSpacing: 0,
    });
  }

  if ($("#course-card-floating").length > 0) {
    $("#course-card-floating").stickySidebar({
      containerSelector: "#course__wrapper",
      innerWrapperSelector: ".card-floating__inner",
      topSpacing: 0,
      bottomSpacing: 0,
    });
  }

  //
  // INIT FUNCTIONS
  //
  updateTextLimiter();
  if ($(".search-input").val()) {
    $(".placeholder").hide();
  }

  //
  // EVENTS LISTENERS
  //

  // CLICK EVENTS
  $(".placeholder").on("click", function () {
    $(".search-input").trigger("focus");
  });

  $(".btn-show-more").on("click", function () {
    let $this = $(this);
    if ($this.hasClass("closed")) {
      $this.prev(".course-description").removeClass("truncate");
      $this.prev(".topics-description").removeClass("topics-truncate");
      $this
        .find("small")
        .html(
          $this
            .find("small")
            .html()
            .replace("VISUALIZAR MAIS", "VISUALIZAR MENOS")
        );
    } else {
      $this.prev(".course-description").addClass("truncate");
      $this.prev(".topics-description").addClass("topics-truncate");
      $this
        .find("small")
        .html(
          $this
            .find("small")
            .html()
            .replace("VISUALIZAR MENOS", "VISUALIZAR MAIS")
        );
    }
    $this.toggleClass("closed open");
  });

  $(".checkout-button").on("click", function () {
    $(this).button("loading");
    $(this).closest("form").trigger("submit");
  });

  $(".go-checkout-button").on("click", function () {
    $(this).button("loading");
  });

  $("#cart-list-overlay").on("click", function (e) {
    let $cartContainer = $(
      ".cart-button.has-items .nav-link.cart"
    ).parent();
    toggleCartContainer($cartContainer);
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

  $("#btn-contact-send").on("click", function () {
    let $this = $(this),
      $form = $this.closest("form"),
      $formWrapper = $form.parent(),
      $responseMessage = $formWrapper.find('.formResponse'),
      isValid = $form[0].reportValidity(),
      formData = $form.serialize();

    if (isValid) {
      $.ajax({
        url: "/ajax/contact",
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
            grecaptcha.reset();
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
          grecaptcha.reset();
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

  // BLUR EVENTS
  $(".search-input").on("blur", function () {
    if (!$(".search-input").val()) {
      $(".placeholder").show();
    }
  });

  // FOCUS EVENTS
  $(".search-input").on("focus", function () {
    if (!$(".search-input").val()) {
      $(".placeholder").hide();
    }
  });

  // INPUT EVENTS
  $(".search-input").on("input", function () {
    if ($(".search-input").val()) {
      $(".placeholder").hide();
    }
  });

  // SUBMIT EVENTS
  $(".search-wrapper form").on("submit", doSearch);
});

//
// DYNAMIC EVENTS
//
$(document).on("click", ".cart-button.has-items .nav-link.cart", click_openCartDetails);
$(document).on("click", ".remove-cart-item", click_removeCartItem);
$(window).on("resize", function () {
  updateTextLimiter();
});
