#!/bin/bash

set -ex

if [ -z "$1" ]
then
      echo "version is empty"
      exit 2
fi

rm -rf svn
svn co https://plugins.svn.wordpress.org/append-or-prepend-content svn

rm -rf svn/trunk
rm -rf svn/assets

cp -r build svn/trunk
cp -r assets-wporg svn/assets
cp -r build svn/tags/$1
