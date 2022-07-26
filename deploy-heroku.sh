#!/bin/bash

heroku config:add DB_CONNECTION="mysql"
heroku config:add DB_HOST="j21q532mu148i8ms.cbetxkdyhwsb.us-east-1.rds.amazonaws.com"
heroku config:add DB_PORT="3306"
heroku config:add DB_DATABASE="fi50x51xsrqvawj7"
heroku config:add DB_USERNAME="k05jakoqqzsdd68q"
heroku config:add DB_PASSWORD="y6n551k0hmla40f4"

heroku config:add APP_ENV="develop"
heroku config:add APP_KEY="base64:53FiXUlgz+i0RuBX6sYJ4/XdEHzYqUSR951GkjaPbvo="
heroku config:add APP_DEBUG="true"

heroku config:add VNP_URL="https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"
heroku config:add VNP_PMNCODE="J483Q072"
heroku config:add VNP_HASH_SECRECT="WXGSQGHLCVHKWUIRLEHHNZVKDYLQCWEO"