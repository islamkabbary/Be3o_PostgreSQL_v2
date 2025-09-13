<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('Verify your email address') }}</title>
</head>
<body>
    <h2>{{ __('Hello') }} {{ $name }},</h2>
    <p>{{ __('Please click the button below to verify your email address:') }}</p>

    <p>
        <a href="{{ $url }}" 
           style="display:inline-block;padding:10px 20px;background:#3490dc;color:#fff;text-decoration:none;border-radius:5px;">
           {{ __('Verify Email') }}
        </a>
    </p>

    <p>{{ __('If you did not create an account, no further action is required.') }}</p>
</body>
</html>
