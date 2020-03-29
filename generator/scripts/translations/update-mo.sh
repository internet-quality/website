#!/bin/bash
#
# @license http://unlicense.org/UNLICENSE The UNLICENSE
# @author Internet Quality <copyright@internet-quality.org>
#

ROOT_DIR=$(realpath "$(dirname $0)/../../")
echo "Using root: ${ROOT_DIR}"

 for file in $ROOT_DIR/po/*.po; do
    [ -f "$file" ] || continue
    lang=${file##*/}
    lang=${lang%.*}
    mkdir -p $ROOT_DIR/locale/$lang/LC_MESSAGES
    msgfmt --directory=$podir --check -o locale/$lang/LC_MESSAGES/internet-quality.mo $file
 done
