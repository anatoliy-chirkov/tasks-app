<?php
/**
 * @var $title string
 * @var $description string
 * @var $innerViewPath string
 * @var $notification \Services\NotificationService\Notification
 * @var $isAuthorized bool
 */
?>
<html lang="en">
<head>
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>" />
    <style>
        /* NAV START */
        ::selection {
            background: rgba(255,235,20,.7);
            color: #111;
        }
        *, :after, :before, html {
            box-sizing: border-box;
        }
        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font: normal normal normal 1rem/1.6 BlinkMacSystemFont,-apple-system,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;
            font-family: BlinkMacSystemFont,-apple-system,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;
            font-size: 84%!important;
        }
        body {
            color: #454545;
            font-size: 1rem;
        }
        @media (min-width: 620px) {
            body {
                font-size: 1.15rem;
            }
        }
        nav {
            display: block;
        }
        a {
            color: #5183f5;
            text-decoration: none;
            font-weight: 600;
        }
        @media (min-width: 620px) {
            dl, ol, p, table, ul {
                margin: 0 0 2rem;
                font-size: 1.3rem;
            }
        }
        h1, h2, h3, h4, h5 {
            font-weight: 600;
            font-family: BlinkMacSystemFont,-apple-system,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;
            line-height: 1.3;
            color: #111;
        }
        .button, a.button, button {
            -webkit-appearance: none;
            display: inline-block;
            border: 2px solid #5183f5;
            border-radius: 4px;
            background: #5183f5;
            color: #fff;
            font-weight: 600;
            font-family: BlinkMacSystemFont,-apple-system,Roboto,Helvetica Neue,Helvetica,Arial,sans-serif;
            font-size: 1.1rem;
            text-transform: none;
            padding: .6rem .9rem;
            margin: 0 0 .5rem;
            vertical-align: middle;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            line-height: 1;
        }
        .favicon {
            height: 23px;
            width: 23px;
            min-width: 23px;
            margin-right: 1rem;
            margin-bottom: 0;
        }
        .nav .brand .text {
            display: none;
        }
        .nav .cta, .nav .nav-container {
            display: flex;
            align-items: center;
        }
        .nav .brand a {
            display: flex;
            align-items: center;
            color: #333;
            margin-right: 0;
            font-weight: 500;
            font-size: 1.15rem;
        }
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 3;
            width: 100%;
            background: #fff;
        }
        .nav .nav-container {
            padding: 0 1.5rem;
            height: 55px;
            max-width: 850px;
            margin: auto;
            justify-content: space-between;
            -webkit-transition: height .3s ease;
            transition: height .3s ease;
        }
        .nav .links a {
            font-size: 1.05rem;
            font-weight: 400;
            padding: .75rem;
            color: rgba(0,0,0,.6);
            line-height: 1.2;
            text-align: center;
        }
        .nav .links {
            flex-direction: row;
            justify-content: flex-end;
            flex: 1 1;
        }
        .nav .links, .nav .links a, .nav .links button {
            display: flex;
            align-items: center;
            margin: 0;
        }
        .nav.scroll {
            box-shadow: 1px 2px 18px rgba(0,0,0,.1);
        }
        @media (min-width: 620px) {
            .favicon {
                margin-right: 1rem;
            }
            .nav .nav-container {
                height: 160px;
                padding: 0 2rem;
            }
            .nav .brand .text {
                display: block;
            }
            .nav .links {
                display: flex;
                flex-direction: row;
                justify-content: flex-end;
                height: 100%;
            }
            .nav .links a {
                font-size: 1.2rem;
                margin: 0 .5rem;
                padding: 1rem;
                border-bottom: 2px solid transparent;
                border-radius: 4px;
            }
            .nav.scroll .nav-container {
                height: 60px;
            }
        }
        /* NAV END */

        #main-content {
            margin-top: 55px;
            padding: 40px 0 0;
            min-height: calc(100vh - 162px);
        }
        .container {
            max-width: 850px;
            padding: 0 1.5rem;
            margin-left: auto;
            margin-right: auto;
        }
        @media (min-width: 620px) {
            #main-content {
                margin-top: 140px;
                padding: 60px 0 0;
                min-height: calc(100vh - 219px);
            }
            .container {
                padding: 0 2rem;
            }
        }
        .button:hover {
            background: #0062cc;
        }
        .page-button {
            display: inline-block;
            padding: .5rem .75rem;
            background: #f2f2f2;
            border-radius: 4px;
            color: #5f5f5f;
            font-size: 1rem;
            font-weight: 500;
            margin: 0 1rem 0 0;
        }
        .page-button:hover {
            text-decoration: none;
            color: inherit;
        }
        .page-button.active {
            background: #5083f5;
            color: white;
        }
        input, select {
            display: block;
            border: 2px solid #ccc;
            border-radius: 4px;
            padding: .75rem;
            outline: none;
            margin-bottom: .5rem;
            font-size: 1.1rem;
            font-weight: 500;
            width: 100%;
            max-width: 100%;
            line-height: 1;
        }
        .notification {
            font-size: 1rem;
            padding: .75rem .75rem;
            border-radius: 4px;
            margin-bottom: .5rem;
            font-weight: 600;
            color: #ffffff;
        }
        .notification.success {
            background: #60bb45;
        }
        .notification.fail {
            background: #e03a3d;
        }
        table {
            width: 100%;
            text-align: left;
        }
        .excerpt {
            font-size: 1rem;
            display: block;
            color: rgba(0,0,0,.4);
            font-weight: 400;
        }
    </style>
</head>
<body>
<nav class="nav">
    <div class="nav-container">
        <div class="brand">
            <a aria-current="page" class="" href="/">
                <img src="/img/spiral-note-pad.png" class="favicon" alt="Spiral Note Pad">
                <span class="text">Tasks App</span>
            </a>
        </div>
        <div class="links">
            <? if (!$isAuthorized): ?>
                <div>
                    <a href="/login">Login</a>
                </div>
            <? else: ?>
                <form method="post" action="/logout" style="margin-bottom: 0">
                    <button type="submit">Logout</button>
                </form>
            <? endif; ?>
        </div>
    </div>
</nav>
<main id="main-content">
    <div class="container">
        <? if ($notification->isset()): ?>
            <div class="notification <?=$notification->type?>"><?= $notification->message ?></div>
        <? endif; ?>

        <? require_once $innerViewPath; ?>
    </div>
</main>
</body>
</html>
