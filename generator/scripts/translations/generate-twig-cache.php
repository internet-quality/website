#!/usr/bin/env php
<?php
declare(strict_types = 1);
/**
 * @license http://unlicense.org/UNLICENSE The UNLICENSE
 * @author Internet Quality <copyright@internet-quality.org>
 */
require_once __DIR__.'/../../vendor/autoload.php';

$projectRootDir = realpath(__DIR__ . '/../../') . '/';
$projectTemplatesDir = $projectRootDir . 'templates';

$tmpDir = $projectRootDir . 'tmp/';

$shortTempDir = str_replace($projectRootDir, '', $projectTemplatesDir);

$__twig                 = Website\Twig::makeTwig(true);
$mappings               = new stdClass();
$mappings->mappings     = [];
$mappings->replacements = [];

$license = new stdClass();

$license->from            = 'This file is';
$license->from           .= ' distributed';
$license->from           .= ' under the same';
$license->from           .= ' license as the PACKAGE package.';
$license->to              = 'This file is distributed under the license http://unlicense.org/UNLICENSE';
$mappings->replacements[] = $license;

$license                  = new stdClass();
$license->from            = 'PACKAGE VERSION';
$license->to              = '1.0.0-alpha1';
$mappings->replacements[] = $license;

$license                  = new stdClass();
$license->from            = 'Language-Team: LANGUAGE <LL@li.org>';
$license->to              = 'Language-Team: Internet Quality <translators@internet-quality.org>';
$mappings->replacements[] = $license;

$firstauthor              = new stdClass();
$firstauthor->from        = 'FIRST AUTHOR <EMAIL@ADDRESS>, YEAR.';
$firstauthor->to          = 'Internet Quality <translators@internet-quality.org>';
$mappings->replacements[] = $firstauthor;

$description              = new stdClass();
$description->from        = 'SOME DESCRIPTIVE TITLE';
$description->to          = 'Website translations';
$mappings->replacements[] = $description;

$year                     = new stdClass();
$year->from               = '# Copyright (C) YEAR Internet Quality';
$year->to                 = '# Copyright (C) ' . date('Y') . ' Internet Quality';
$mappings->replacements[] = $year;

$templates                = new stdClass();
$templates->from          = $tmpDir;
$templates->to            = '';
$mappings->replacements[] = $templates;

$templates                = new stdClass();
$templates->from          = realpath(__DIR__ . '/../');
$templates->to            = '';
$mappings->replacements[] = $templates;

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($projectTemplatesDir), RecursiveIteratorIterator::LEAVES_ONLY) as $tmpl) {

    if ($tmpl->isFile()) {
        $shortName = str_replace($projectTemplatesDir, '', $tmpl);
        $template  = $__twig->loadTemplate($shortName);
        $key       = Website\Twig::getTwigCacheFS()->generateKey($shortName, $__twig->getTemplateClass($shortName));

        $cacheFile = str_replace(
            $tmpDir,
            '',
            $key
        );

        $mappings->mappings[$cacheFile] = new stdClass();

        $mappings->mappings[$cacheFile]->fileName  = $shortTempDir . $shortName;
        $mappings->mappings[$cacheFile]->debugInfo = $template->getDebugInfo();
    }

}
$mappings = json_encode($mappings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($tmpDir . 'twig-file-mappings.json', $mappings);
