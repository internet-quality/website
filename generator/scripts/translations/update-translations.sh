#!/bin/bash
#
# @license http://unlicense.org/UNLICENSE The UNLICENSE
# @author Internet Quality <copyright@internet-quality.org>
#

ROOT_DIR=$(realpath "$(dirname $0)/../../")
echo "Using root: ${ROOT_DIR}"

$ROOT_DIR/scripts/translations/generate-twig-cache.php
$ROOT_DIR/scripts/translations/make-pot.sh
$ROOT_DIR/scripts/translations/update-po.php
$ROOT_DIR/scripts/translations/update-mo.sh

git commit -am "chore: [Translations] updates" -S -m "[ci skip]" -m "#translations" -m "[changelog skip]" --author "Internet Quality <bot@internet-quality.org>"
