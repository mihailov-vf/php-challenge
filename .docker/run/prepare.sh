#!/bin/bash
php bin/migrations.php migrate -n

mkdir data
./vendor/bin/generate-oauth2-keys
chmod 660 data/oauth/public.key