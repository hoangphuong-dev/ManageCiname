#!/bin/bash

vendor/bin/sail artisan migrate:reset 
vendor/bin/sail artisan migrate --seed