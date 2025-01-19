#!/usr/bin/env bash

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )


echo "Starting repository maintenance..."

echo "Preparing newly uploaded modules:"
${SCRIPT_DIR}/organizeFiles.py ${SCRIPT_DIR}

echo "Generating repository index:"
${SCRIPT_DIR}/generateIndex.py ${SCRIPT_DIR}

echo "Done."

