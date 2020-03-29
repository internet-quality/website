#!/usr/bin/env php
<?php
declare(strict_types = 1);
/**
 * @license http://unlicense.org/UNLICENSE The UNLICENSE
 * @author Internet Quality <copyright@internet-quality.org>
 */

$projectRootDir = realpath(__DIR__ . '/../../') . '/';
$projectPoDir   = $projectRootDir . 'po'. '/';
$tmpDir         = $projectRootDir . 'tmp'. '/';
$poTemplate     = realpath($projectRootDir . 'locale/' . 'internet-quality.pot');
$mappingsFile   = $tmpDir . 'twig-file-mappings.json';

if (is_file($mappingsFile)) {
    $mappings = json_decode(file_get_contents($mappingsFile));
} else {
    echo 'Missing: ' . $mappingsFile;
    exit(1);
}

if (is_file($poTemplate)) {
    $template = file_get_contents($poTemplate);
} else {
    echo 'Missing: ' . $poTemplate;
    exit(1);
}

foreach ($mappings->replacements as $replacement) {
    $template = str_replace($replacement->from, $replacement->to, $template);
}

$parts         = explode('msgid ', $template);
$licenseBlock = str_replace(', fuzzy', '', $parts[0]);

file_put_contents($poTemplate, $template);

/**
 * Update the copyright header of a po file
 *
 * @param string $poFile The po file path
 * @return void
 */
function poupdate(string $poFile, string $licenseBlock): void
{
    $potFileContents = file_get_contents($poFile);

    $parts        = explode('msgid ', $potFileContents);
    $potFileContents = str_replace($parts[0], $licenseBlock, $potFileContents);

    // Replace filename by name
    $potFileContents = preg_replace_callback(
        '@([0-9a-f]{2}\/[0-9a-f]*.php):([0-9]*)@',
        function ($matchs) {
            global $mappings;
            $line    = intval($matchs[2]);
            $replace = $mappings->mappings->{$matchs[1]};
            foreach ($replace->debugInfo as $cacheLineNumber => $iii) {
                if ($line >= $cacheLineNumber) {
                    return $replace->fileName . ':' . $iii;
                }
            }
            return $replace->fileName . ':0';
        },
        $potFileContents
    );
    file_put_contents($poFile, $potFileContents);
}

echo 'Po-dir: '.$projectPoDir . PHP_EOL;
foreach (glob($projectPoDir . '*.po') as $file) {
    exec('msgmerge --quiet --previous -U $file '.$projectPoDir . 'internet-quality.pot');
    echo 'File: ' . $file . PHP_EOL;
    poupdate($file, $licenseBlock);
}
poupdate($poTemplate, $licenseBlock);
