<?php
    $redirects = include('redirects.php');

    if (!array_key_exists('source', $_GET)) {
        echo('Please set the URL query parameter <code>source</code> to use this service.');
        return;
    }

    $sourceUrl = $_GET['source'];

    $urlDisassemblyRegex = '/^(?:https?:\/\/)?(?:[a-z0-9-_]+\.)*([a-z0-9-_]+\.[a-z0-9-_]+)(\/.*$)?/m';
    $regexMatchingStatus = preg_match($urlDisassemblyRegex, $sourceUrl, $regexMatches);

    if ($regexMatchingStatus === 0 || $regexMatchingStatus === false) {
        echo('Unable to redirect from URL <code>' . $sourceUrl . '</code>. Unable to process URL.');
        return;
    }

    $sourceDomain = $regexMatches[1];
    $sourcePath = $regexMatches[2];

    if (!array_key_exists($sourceDomain, $redirects)) {
        echo('No redirect configured for website <code>' . $sourceDomain . '</code>.');
        return;
    }

    $redirectDomain = $redirects[$regexMatches[1]];
    $redirectUrl = 'https://' . $redirectDomain . $sourcePath;

    header('Location: ' . $redirectUrl);
    exit();
?>