<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $article->title }}</title>
    <style>
        * {
            font-family: 'almarai', sans-serif;
        }
    </style>
</head>

<body>
    <h1>{{ $article->title }}</h1>
    <p>{{ $article->content }}</p>
    <span>{{ implode(', ', $article->tags->pluck('name')->toArray()) }}</span>

    <div>تجربة اللغة العربية</div>
</body>

</html>
