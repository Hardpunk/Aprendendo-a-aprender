function roundNumber(e, t) {
  if (!t)
    return Math.round(e);
  if (0 == e) {
    for (var o = "", a = 0; a < t; a++)
      o += "0";
    return "0," + o
  }
  if (e > 0 && e < 1) {
    var r = Math.pow(10, t);
    return "0," + Math.round(e * r).toString().slice(-1 * t)
  }
  var n = Math.pow(10, t),
    l = Math.round(e * n).toString();
  return l.slice(0, -1 * t) + "," + l.slice(-1 * t)
}

function number_format(e, t, o, a) {
  e = (e + "").replace(/[^0-9+\-Ee.]/g, "");
  var r = isFinite(+e) ? +e : 0,
    n = isFinite(+t) ? Math.abs(t) : 0,
    l = void 0 === a ? "," : a,
    i = void 0 === o ? "." : o,
    u = "";
  return u = (n ? function (e, t) {
    var o = Math.pow(10, t);
    return "" + (Math.round(e * o) / o).toFixed(t)
  }(r, n) : "" + Math.round(r)).split("."),
  u[0].length > 3 && (u[0] = u[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, l)),
  (u[1] || "").length < n && (u[1] = u[1] || "",
    u[1] += new Array(n - u[1].length + 1).join("0")),
    u.join(i)
}

function validaCard(e) {
  flag = !0,
    x = document.getElementById("cardNumberEr"),
  "" != e.value && (flag = validaCartao(e.value.replace(/\D/g, ""))),
    flag ? (x.style.display = "none",
      e.style.borderColor = "rgb(150, 162, 185)") : (x.style.display = "block",
      e.style.borderColor = "rgb(200, 0, 0)")
}

function validaCod(e) {
  var t = e.value.replace(/\D/g, "");
  return e.value.length != t.length ? (x = document.getElementById("codVerifyEr"),
    x.style.display = "block",
    e.style.borderColor = "rgb(200, 0, 0)", !1) : (flag = !0,
  "" != e.value && e.maxLength != e.value.length && (flag = !1),
    x = document.getElementById("codVerifyEr"),
    flag ? (x.style.display = "none",
      e.style.borderColor = "rgb(150, 162, 185)", !0) : (x.style.display = "block",
      e.style.borderColor = "rgb(200, 0, 0)", !1))
}

function validaNome(e) {
  flag = !0,
    x = document.getElementById("nomeEr"),
  "" != e.value && (flag = isString(e.value)),
    flag ? (x.style.display = "none",
      e.style.borderColor = "rgb(150, 162, 185)") : (x.style.display = "block",
      e.style.borderColor = "rgb(200, 0, 0)")
}

function validaCPF(e) {
  flag = !0,
  "" != e.value && (flag = validaDoc(e.value)),
    x = document.getElementById("cpfEr"),
    flag ? (x.style.display = "none",
      e.style.borderColor = "rgb(150, 162, 185)") : (x.style.display = "block",
      e.style.borderColor = "rgb(200, 0, 0)")
}

function validaCpf(e) {
  var t = "";
  for (i = 0; i < e.length; i++)
    switch (e.charAt(i)) {
      case "0":
      case "1":
      case "2":
      case "3":
      case "4":
      case "5":
      case "6":
      case "7":
      case "8":
      case "9":
        t += e.charAt(i)
    }
  if (e = t,
  11 != e.length || "00000000000" == e || "11111111111" == e || "22222222222" == e || "33333333333" == e || "44444444444" == e || "55555555555" == e || "66666666666" == e || "77777777777" == e || "88888888888" == e || "99999999999" == e)
    return !1;
  for (add = 0,
         i = 0; i < 9; i++)
    add += parseInt(e.charAt(i)) * (10 - i);
  if (rev = 11 - add % 11,
  10 != rev && 11 != rev || (rev = 0),
  rev != parseInt(e.charAt(9)))
    return !1;
  for (add = 0,
         i = 0; i < 10; i++)
    add += parseInt(e.charAt(i)) * (11 - i);
  return rev = 11 - add % 11,
  10 != rev && 11 != rev || (rev = 0),
  rev == parseInt(e.charAt(10))
}

function isString(e) {
  return "string" == typeof e
}

function isNumber(e) {
  return "number" == typeof e
}

function loadingButton() {
  var e = $("#buttCard,#buttBoleto,#buttBanco");
  e.prop("disabled", !0),
    e.html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>")
}

function resetButton() {
  var e = $("#buttCard,#buttBoleto,#buttBanco");
  e.prop("disabled", !1),
    e.html("EFETUAR PAGAMENTO")
}

function valida(e) {
  var t = !0,
    o = document.getElementById("cardNumber"),
    a = document.getElementById("codVerify"),
    r = document.getElementById("dtValidMonth"),
    n = document.getElementById("dtValidYear"),
    l = document.getElementById("name");
  if (!(t = validaCartao(o.value.replace(/\D/g, ""))) || "" == o.value)
    return sendErrorAlert("Alerta: Número do Cartão inválido"), !1;
  if (t = validaCod(a),
  0 == e) {
    if (!t || "" == a.value)
      return sendErrorAlert("Alerta: Código Verificador inválido"), !1
  } else if (!t)
    return sendErrorAlert("Alerta: Código Verificador inválido"), !1;
  if ("" == r.value || "" == n.value)
    return sendErrorAlert("Alerta: Selecione a validade do cartão"), !1;
  var i = 2e3 + parseInt(n.value),
    u = new Date,
    d = u.getFullYear(),
    m = u.getMonth();
  return d == i && m + 1 > parseInt(r.value) ? (sendErrorAlert("Alerta: Cartão fora da validade"), !1) : isString(l.value) && "" != l.value ? (loadingButton(), !0) : (sendErrorAlert("Alerta: Nome do dono do cartão inválido"), !1)
}

function getEndereco() {
  var e = $.trim($("#cepform").val());
  "" != (e = e.replace("-", "")) && $.getJSON("//viacep.com.br/ws/" + e + "/json/?callback=?", function (e) {
    "erro" in e || ($("#enderecoform").val(e.logradouro),
      $("#bairroform").val(e.bairro),
      $("#cidadeform").val(e.localidade),
      $("#estadoform").val(e.uf),
      $("#complemento").val(e.complemento),
      $("#numform").trigger('focus'))
  })
}

function submitAndReturn(e, t) {
  loadingButton();
  var o = document.getElementById("boleto-info");
  return document.getElementById("boleto-message").innerHTML = "",
    o.innerHTML = '\n      <div class="text-center">\n        <p>O boleto está sendo processado e irá abrir em uma nova aba do navegador em breve.</p>\n        <p>Você pode fechar esta tela após o boleto ser processado.</p>\n      </div>\n    ',
    "banco" == t ? document.formbanco.submit() : document.formboleto.submit()
}

function validaEnd() {
  var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : 1,
    t = document.getElementById("cepform"),
    o = document.getElementById("enderecoform"),
    a = document.getElementById("numform"),
    r = document.getElementById("bairroform"),
    n = document.getElementById("complform"),
    l = document.getElementById("cidadeform"),
    u = document.getElementById("estadoform");
  if (e) {
    if ("" == t.value.trim())
      return sendErrorAlert("Alerta: O Preenchimento do CEP é obrigatório."),
        t.focus(),
        resetButton(), !1;
    var p = document.getElementsByName("zipcode");
    for (i = 0; i < p.length; i++)
      p[i].value = t.value.trim();
    if ("" == o.value.trim())
      return sendErrorAlert("Alerta: O Preenchimento do Endereço é obrigatório."),
        o.focus(),
        resetButton(), !1;
    var f = document.getElementsByName("street");
    for (i = 0; i < f.length; i++)
      f[i].value = o.value.trim();
    var g = document.getElementsByName("complement");
    for (i = 0; i < g.length; i++)
      g[i].value = n.value.trim();
    if ("" == a.value.trim())
      return sendErrorAlert("Alerta: O Preenchimento do Número é obrigatório."),
        a.focus(),
        resetButton(), !1;
    var b = document.getElementsByName("street_number");
    for (i = 0; i < b.length; i++)
      b[i].value = a.value.trim();
    if ("" == r.value.trim())
      return sendErrorAlert("Alerta: O Preenchimento do Bairro é obrigatório."),
        r.focus(),
        resetButton(), !1;
    var g = document.getElementsByName("neighborhood");
    for (i = 0; i < g.length; i++)
      g[i].value = r.value.trim();
    if ("" == l.value.trim())
      return sendErrorAlert("Alerta: O Preenchimento da Cidade é obrigatório."),
        l.focus(),
        resetButton(), !1;
    var h = document.getElementsByName("city");
    for (i = 0; i < h.length; i++)
      h[i].value = l.value.trim();
    if ("" == u.value.trim())
      return sendErrorAlert("Alerta: O Preenchimento do Estado é obrigatório."),
        u.focus(),
        resetButton(), !1;
    var y = document.getElementsByName("state");
    for (i = 0; i < y.length; i++)
      y[i].value = u.value.trim()
  }
  return !0;
}

function validateEmail(e) {
  return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(e)
}

function preencheNome() {
  var e = document.getElementById("nomeform"),
    t = document.getElementsByName("nome");
  for (i = 0; i < t.length; i++)
    t[i].value = e.value
}

function preencheCampos() {
  var e = document.getElementById("cepform"),
    t = document.getElementById("enderecoform"),
    o = document.getElementById("numform"),
    a = document.getElementById("bairroform"),
    r = document.getElementById("complform"),
    n = document.getElementById("cidadeform"),
    l = document.getElementById("estadoform");

  var f = document.getElementsByName("zipcode");
  for (i = 0; i < f.length; i++)
    f[i].value = e.value;
  var g = document.getElementsByName("street");
  for (i = 0; i < g.length; i++)
    g[i].value = t.value;
  var b = document.getElementsByName("street_number");
  for (i = 0; i < b.length; i++)
    b[i].value = o.value;
  var h = document.getElementsByName("neighborhood");
  for (i = 0; i < h.length; i++)
    h[i].value = a.value;
  var h = document.getElementsByName("complement");
  for (i = 0; i < h.length; i++)
    h[i].value = r.value;
  var y = document.getElementsByName("city");
  for (i = 0; i < y.length; i++)
    y[i].value = n.value;
  var E = document.getElementsByName("state");
  for (i = 0; i < E.length; i++)
    E[i].value = l.value;
  return !0
}

//Card Validation usign Luhn algorithm
function validateCreditCardLibrepag(s) {
  var w = s.replace(/\D/g, ""); //remove all non-digit characters

  if (s.length != w.length) {
    return false;

  } else {
    // validate number
    j = w.length / 2;
    k = Math.floor(j);
    m = Math.ceil(j) - k;
    c = 0;
    for (i = 0; i < k; i++) {
      a = w.charAt(i * 2 + m) * 2;
      c += a > 9 ? Math.floor(a / 10 + a % 10) : a;
    }
    for (i = 0; i < k + m; i++) c += w.charAt(i * 2 + 1 - m) * 1;
    return (c % 10 == 0);
  }
}

function validateSecurityCard(s) {
  var w = s.replace(/\D/g, ""); //remove all non-digit characters

  if (s.length != w.length) {
    return false;
  } else {
    return true;
  }
}

function validaCartao(v) {
  return validateCreditCardLibrepag(v);
}

function sendAlert(icon, message, type, url, title, plfrom, plalign, time) {
  title = (title == null) ? '' : title + '<br />';
  plfrom = (plfrom == null) ? 'top' : plfrom;
  plalign = (plalign == null) ? 'center' : plalign;
  time = (time == null) ? '2000' : time;
  $.notify({
    icon: icon,
    message: message,
    url: url,
    title: title,
    target: '_blank'
  }, {
    type: type,
    timer: time,
    placement: {
      from: plfrom,
      align: plalign
    },
    animate: {
      enter: 'animated bounceInDown',
      exit: 'animated bounceOutUp'
    },
    template: '<div data-notify="container" class="alert-login alert alert-{0} w-50" role="alert">' +
      '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
      '<span data-notify="icon"></span>' +
      '<span data-notify="title" class="notify-title">{1}</span>' +
      '<span data-notify="message">{2}</span>' +
      '<a href="{3}" target="{4}" data-notify="url"></a>' +
      '</div>'
  });
}

function sendSuccessAlert(message) {
  title = 'Success';
  plfrom = 'top'
  plalign = 'center';
  time = '500';
  $.notify({
    icon: 'fa fa-check',
    message: message,
    target: '_blank'
  }, {
    type: 'success',
    timer: time,
    placement: {
      from: plfrom,
      align: plalign
    },
    animate: {
      enter: 'animated bounceInDown',
      exit: 'animated bounceOutUp'
    },
    template: '<div data-notify="container" class="alert-login alert alert-{0} w-50" role="alert">' +
      '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
      '<span data-notify="icon"></span>' +
      '<span data-notify="title" class="notify-title">{1}</span>' +
      '<span data-notify="message">{2}</span>' +
      '<a href="{3}" target="{4}" data-notify="url"></a>' +
      '</div>'
  });
}

function sendInfoAlert(message) {
  title = 'Info';
  plfrom = 'top'
  plalign = 'center';
  time = '500';
  $.notify({
    icon: 'fa fa-exclamation-circle',
    message: message,
    target: '_blank'
  }, {
    type: 'info',
    timer: time,
    placement: {
      from: plfrom,
      align: plalign
    },
    animate: {
      enter: 'animated bounceInDown',
      exit: 'animated bounceOutUp'
    },
    template: '<div data-notify="container" class="alert-login alert alert-{0} w-50" role="alert">' +
      '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
      '<span data-notify="icon"></span>' +
      '<span data-notify="title" class="notify-title">{1}</span>' +
      '<span data-notify="message">{2}</span>' +
      '<a href="{3}" target="{4}" data-notify="url"></a>' +
      '</div>'
  });
}

function sendErrorAlert(message) {
  title = 'Error';
  plfrom = 'top'
  plalign = 'center';
  time = '3000';
  $.notify({
    icon: 'fa fa-exclamation-circle',
    message: message,
    target: '_blank'
  }, {
    type: 'danger',
    timer: time,
    placement: {
      from: plfrom,
      align: plalign
    },
    animate: {
      enter: 'animated bounceInDown',
      exit: 'animated bounceOutUp'
    },
    template: '<div data-notify="container" class="alert-login alert alert-{0} w-50" role="alert">' +
      '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
      '<span data-notify="icon"></span>' +
      '<span data-notify="title" class="notify-title">{1}</span>' +
      '<span data-notify="message">{2}</span>' +
      '<a href="{3}" target="{4}" data-notify="url"></a>' +
      '</div>'
  });
}

jQuery.fn.shake = function () {
  this.each(function (i) {
    $(this).css({"position": "relative"});
    for (var x = 1; x <= 3; x++) {
      $(this).animate({left: -15}, 10).animate({left: 0}, 50).animate({left: 15}, 10).animate({left: 0}, 50);
    }
  });
  return this;
}

$(function () {
  if ($("#cardNumber").length > 0) {
    var cardCleave = new Cleave("#cardNumber", {
      creditCard: true,
      onCreditCardTypeChanged: function (type) {
        $('#cc-logo').attr('class', `cc-number ${type}`);
      }
    });
  }

  if ($("#cepform").length > 0) {
    var cepCleave = new Cleave("#cepform", {
      numericOnly: true,
      delimiters: ["-"],
      blocks: [5, 3]
    });
  }

  $("#name").on("keyup", function () {
    $(this).val($(this).val().toUpperCase());
  });
  var e = function (e) {
      return 11 === e.replace(/\D/g, "").length ? "(00) 00000-0000" : "(00) 0000-00009"
    },
    t = {
      onKeyPress: function (t, o, a, r) {
        a.mask(e.apply({}, arguments), r)
      }
    };
  $("#Fone").mask(e, t);

  $("#codVerify").on('blur', function () {
    validaCod(this);
  });
  $("#cardNumber").on('blur', function () {
    validaCard(this);
  });
  $("#buttCard").on('click', function () {
    if (valida(0) && validaEnd()) {
      preencheCampos();
      preencheNome();
      $('#payment-confirmation-modal').modal('show');
      $(this).closest('form').trigger('submit');
    }
  })
  $("#buttBoleto").on('click', function () {
    if (validaEnd()) {
      preencheCampos();
      submitAndReturn('', 'boleto');
    }
  });
  $("#cepform").on('blur', function () {
    getEndereco(true);
  });
});
