<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body
    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; color: #74787e; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

    </style>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0"
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
        <tr>
            <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                <table class="content" width="100%" cellpadding="0" cellspacing="0"
                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                    <tr>
                        <td class="header"
                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 10px 0; text-align: center;">
                            <a href="{{ config('app.url') }}" target="_blank">
                                <img src="{{ config('app.url') }}/images/logo-small.png"
                                    alt="{{ config('app.name') }}" title="{{ config('app.name') }}"
                                    style="width: 200px;" />
                            </a>
                        </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0"
                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; border-bottom: 1px solid #edeff2; border-top: 1px solid #edeff2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #ffffff; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell"
                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                            Olá <strong>{{ $user->name }}</strong>,</p>

                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                            Sua matrícula na <strong>{{ config('app.name') }}</strong> foi efetuada com sucesso!
                                        </p>

                                        <table class="panel" width="100%" cellpadding="0" cellspacing="0"
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 0 21px;">
                                            <tbody>
                                                <tr>
                                                    <td class="panel-content"
                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #edeff2; padding: 14px;">
                                                        <table width="100%" cellpadding="0" cellspacing="0"
                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="panel-item"
                                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 0;">
                                                                        <p
                                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: left; margin-bottom: 10px; padding-bottom: 0;">
                                                                            <strong>Dados de acesso</strong></p>
                                                                        <p
                                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; margin-top: 0; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                                                            <strong>Login:  </strong> <span>{{ $user->email }}</span>
                                                                        </p>
                                                                        <p
                                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; margin-top: 0; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                                                            <strong>Senha:  </strong> <span>{{ decrypt($user->profile->platform_password) }}</span>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: center;">
                                            Clique no link abaixo para acessar a plataforma de ensino:
                                        </p>

                                        <table class="action" align="center" width="100%" cellpadding="0"
                                            cellspacing="0"
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 25px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                                            <tr>
                                                <td align="center"
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                        <tr>
                                                            <td align="center"
                                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                    <tr>
                                                                        <td
                                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                            <a href="https://www.sie.com.br/institutoacesso"
                                                                                class="button button-acim"
                                                                                target="_blank"
                                                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #ffffff; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #0c6c4f; border-top: 10px solid #0c6c4f; border-right: 18px solid #0c6c4f; border-bottom: 10px solid #0c6c4f; border-left: 18px solid #0c6c4f;">{{ config('app.name') }}</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: center;">
                                            ou copie e cole este link em seu navegador:
                                        </p>
                                        <table class="panel" width="100%" cellpadding="0" cellspacing="0"
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 0 21px;">
                                            <tbody>
                                                <tr>
                                                    <td class="panel-content"
                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #edeff2; padding: 14px;">
                                                        <table width="100%" cellpadding="0" cellspacing="0"
                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" class="panel-item"
                                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 0;">
                                                                        <p
                                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 0; text-align: center; margin-bottom: 0; padding-bottom: 0;">
                                                                            https://www.sie.com.br/institutoacesso</p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 30px; text-align: left;">
                                            Atenciosamente,<br>
                                            {{ config('app.name') }}.</p>

                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; margin-top: 15px; text-align: center;">
                                            <a href="mailto:{{ config('app.email_reply_to') }}" title="{{ config('app.email_reply_to') }}"
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; text-align: center; display: inline-block;"
                                                target="_blank">
                                                {{ config('app.email_reply_to') }}
                                            </a>
                                        </p>
                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; text-align: center;">
                                            <a href="https://wa.me/5562981154676" title="Atendimento (62) 98115-4676"
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 14px; line-height: 1.5em; vertical-align: middle; text-align: center; display: inline-block;"
                                                target="_blank">Whatsapp
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                <tr>
                                    <td class="content-cell" align="center"
                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 15px;">
                                        <p
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #aeaeae; font-size: 12px; text-align: center;">
                                            © {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
