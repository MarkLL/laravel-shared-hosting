#!/bin/bash
read -p 'About to build a Laravel Web App. Press any key to continue...';

echo Create folders and copy the source files...
mkdir webApp
mkdir public_html

# Best to use Git to clone (copy) the files we need:
#
git clone --local --no-hardlinks /mnt/d/Dev/MarkLL/webApp/
# remove git folder
rm -r webApp/.git
# copy public folder
cp -r /mnt/d/dev/MarkLL/public_html .

echo Installing dependencies...
cd webApp
composer install --no-dev

# Uncomment if you are using an sqlite database
# echo Build database...
# touch database/database.sqlite
# php artisan migrate --force

echo Cleanup Vendor extra files we dont want...
cd vendor

# If using aws sdk, uncomment
# rm -r aws/aws-sdk-php/.changes

# Remove some of the extras we don't want to include.
find . -name "LICENSE*" -delete
find . -name "NOTICE*" -delete
find . -name "README*" -delete
find . -name "CHANGELOG*" -delete
find . -name "UPGRADING*" -delete
find . -name "Makefile" -delete
find . -name "phpunit.xml.dist" -delete
find . -name ".travis.yml" -delete
find . -name "composer.json" -delete
find . -name "tests" -type d -exec rm -r "{}" \;
find . -name ".github" -type d -exec rm -r "{}" \;

cd ..
find . -name ".git*" -delete

echo optimise configuration...
# Uncomment following line if you are using Public Storage.
# php artisan storage:link
#
php artisan config:cache
cd .. 

echo Zip it up...
zip -r -q webApp-rel-1-x-x.zip webApp public_html

echo Done!
