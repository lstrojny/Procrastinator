#!/bin/sh
git clone -q https://github.com/doctrine/doctrine2.git vendor/doctrine2
cd vendor/doctrine2 && git submodule init && git submodule update && cd -
