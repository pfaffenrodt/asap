<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"><meta content="webkit" name="renderer"/>
        <meta content="webkit" name="force-rendering"/>
        <meta content="IE=Edge,chrome=1" http-equiv="X-UA-Compatible"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="no-siteapp" http-equiv="Cache-Control"/>
        <meta content="no-transform" http-equiv="Cache-Control"/>

        <title>{{ __('unsupported-browser.title') }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="{{ mix('css/unsupported-browser.css') }}">
    </head>
    <body>

        <div class="container">
            <h1>{{ __('unsupported-browser.headline') }}</h1>
            <p>{{ __('unsupported-browser.intro') }}</p>
            <h2>{{ __('unsupported-browser.ie-note.headline') }}</h2>
            <p>{!! __('unsupported-browser.ie-note.text') !!}</p>

            <h2>{{ __('unsupported-browser.summary.headline') }}</h2>
            <p>{!! nl2br(__('unsupported-browser.summary.text')) !!}</p>

            <h2>{{ __('unsupported-browser.pick-a-browser') }}</h2>
            <ul id=browser-list class=browser-list>
                <li class="browser"><a href="https://www.mozilla.org/de/firefox" target="_blank" rel="noopener">Mozilla firefox</a></li>
                <li class="browser"><a href="https://www.google.com/intl/de_de/chrome/" target="_blank" rel="noopener">Google Chrome</a></li>
                <li class="browser"><a href="https://www.microsoft.com/de-de/edge" target="_blank" rel="noopener">Microsoft Edge</a></li>
            </ul>

        </div>
    </body>
</html>
