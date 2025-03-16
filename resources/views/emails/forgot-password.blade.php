<!DOCTYPE html>
<html
    style="font-size: 16px;font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Helvetica, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;
">

<head>
    <title>Mail reset mật khẩu</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap"
        rel="stylesheet" />
</head>

<body

    >

    <div style="padding: 32px">
        <h4
        style="font-size: 16px;font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"
        >Xin chào!</h4>

        <p
        style="font-size: 16px;font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"
        >Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>

        <p>
            <a href="{{ $url }}"
                style="font-size: 16px;box-sizing: border-box; position: relative; border-radius: 4px; color: rgba(255, 255, 255, 1); display: inline-block; overflow: hidden; text-decoration: none; background-color: #7367f0; word-break: break-all; border: solid 1px #7367f0;padding:0.4812rem 1.25rem;
                font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif
                ">
                Đặt lại mật khẩu
            </a>
        </p>

        <p
        style="font-size: 16px;font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"
        >Link đặt lại mật khẩu này sẽ hết hạn sau
            {{ config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') }} phút.</p>

        <p
        style="font-size: 16px;font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"

        >Nếu bạn không yêu cầu đặt lại mật khẩu, bạn có thể bỏ qua email này.</p>

        <p
        style="font-size: 16px;font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"

        >Trân trọng,<br>{{ config('app.name') }}</p>
        <div style="margin: 20px 0;
        border-top: 1px solid rgba(232, 229, 239, 1);"
        >
        </div>
        <p
        style="font-size: 14px;font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif"

        >Nếu bạn gặp sự cố khi nhấp vào nút "Đặt lại mật khẩu", hãy sao chép và dán URL bên dưới vào trình duyệt web
            của
            bạn: <a href="{{ $url }}"
                style="box-sizing: border-box; position: relative; color: rgba(56, 105, 212, 1); word-break: break-all;
                font-family: Public Sans, -apple-system, blinkmacsystemfont, Segoe UI, Oxygen, Ubuntu, Cantarell, Fira Sans, Droid Sans, Helvetica Neue, sans-serif
                ">{{ $url }}</a>
        </p>
    </div>

</body>

</html>
