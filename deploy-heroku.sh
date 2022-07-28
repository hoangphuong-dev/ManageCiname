#!/bin/bash

# database
heroku config:add DB_CONNECTION="mysql"
heroku config:add DB_HOST="y6aj3qju8efqj0w1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com"
heroku config:add DB_PORT="3306"
heroku config:add DB_DATABASE="vobid10v2aildx7n"
heroku config:add DB_USERNAME="ccl6sgymg3c7lcgv"
heroku config:add DB_PASSWORD="g4iibwh0lvzk6l0t"

# enviroment
heroku config:add APP_ENV="develop"
heroku config:add APP_KEY="base64:Mc3wUUWs93zJvgrmSkv88ATblaNhKayCCyBQblW+Ls0="
heroku config:add APP_DEBUG="true"

heroku config:add SESSION_DOMAIN="phc-cinema.herokuapp.com"

# heroku config:add BROADCAST_DRIVER="log"
# heroku config:add CACHE_DRIVER="file"
# heroku config:add FILESYSTEM_DRIVER="local"
# heroku config:add QUEUE_CONNECTION="sync"
heroku config:add SESSION_DRIVER="database"
heroku config:add SESSION_LIFETIME="120"
heroku config:add SESSION_SECURE_COOKIE="false"

# vn_pay
heroku config:add VNP_URL="https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"
heroku config:add VNP_PMNCODE="J483Q072"
heroku config:add VNP_HASH_SECRECT="WXGSQGHLCVHKWUIRLEHHNZVKDYLQCWEO"

# send_mail
heroku config:add MAIL_MAILER="smtp"
heroku config:add MAIL_HOST="smtp.gmail.com"
heroku config:add MAIL_PORT="587"
heroku config:add MAIL_USERNAME="hoangphuong.work01@gmail.com"
heroku config:add MAIL_PASSWORD="bhqxntmkealieave"
heroku config:add MAIL_ENCRYPTION="tls"
heroku config:add MAIL_FROM_NAME="PHC"
