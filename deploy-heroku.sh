#!/bin/bash

heroku config:add DB_CONNECTION="mysql"
heroku config:add DB_HOST="us-cdbr-east-06.cleardb.net"
heroku config:add DB_PORT="3306"
heroku config:add DB_DATABASE="heroku_829690ac87bef53"
heroku config:add DB_USERNAME="b701422a2a7a29"
heroku config:add DB_PASSWORD="dbe8d27c"

heroku config:add APP_ENV="develop"
heroku config:add APP_KEY="base64:53FiXUlgz+i0RuBX6sYJ4/XdEHzYqUSR951GkjaPbvo="
heroku config:add APP_DEBUG="true"

heroku config:add VNP_URL="https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"
heroku config:add VNP_PMNCODE="J483Q072"
heroku config:add VNP_HASH_SECRECT="WXGSQGHLCVHKWUIRLEHHNZVKDYLQCWEO"


mysql://b701422a2a7a29:dbe8d27c@us-cdbr-east-06.cleardb.net/heroku_829690ac87bef53?