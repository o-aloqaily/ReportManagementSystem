<!doctype html>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>{{ config('app.name', 'RMS') }} | @yield('title')</title>

    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">

        {{-- Embed header component, with a title as a slot --}}
        @component('components.header')
          @yield('title')
        @endcomponent    

      <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
          <img src="{{ asset('images/user.png') }}" class="demo-avatar">
          <div class="demo-avatar-dropdown mt-3">
            <span>{{ Auth::user()->name }}</span>
            <div class="mdl-layout-spacer"></div>
          </div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
          <a class="mdl-navigation__link" href="{{ route('admin.reports') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">file_copy</i>{{ __('admin.reports') }}</a>
          <a class="mdl-navigation__link" href="{{ route('admin.groups') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">group_work</i>{{ __('admin.groups') }}</a>
          <a class="mdl-navigation__link" href="{{ route('admin.users') }}"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">group</i>{{ __('admin.users') }}</a>
          <div class="mdl-layout-spacer"></div>
          {{-- <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a> --}}
        </nav>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100">
      @yield('content')
      </main>
    </div>
  </body>
</html>