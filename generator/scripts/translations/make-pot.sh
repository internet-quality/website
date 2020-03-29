#!/bin/bash
#
# @license http://unlicense.org/UNLICENSE The UNLICENSE
# @author Internet Quality <copyright@internet-quality.org>
#

ROOT_DIR=$(realpath "$(dirname $0)/../../")
echo "Using root: ${ROOT_DIR}"

FILES=$(find ${ROOT_DIR}/tmp/ -name "*.php")

xgettext --force-po --from-code=UTF-8 \
    --default-domain=internet-quality \
    --copyright-holder='Internet Quality' \
    --msgid-bugs-address=translators@internet-quality.org \
    --from-code=utf-8 \
    --keyword=gettext --keyword=pgettext:1c,2 --keyword=ngettext:1,2 \
    --output-dir ${ROOT_DIR}/locale/ \
    --from-code=UTF-8 \
    --add-comments=i18n \
    --add-comments=l10n \
    --width=180 \
    --output ${ROOT_DIR}/locale/internet-quality.pot \
    --language PHP \
    --add-location $FILES
