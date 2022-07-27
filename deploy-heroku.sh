#!/bin/bash

# database
heroku config:add DB_CONNECTION="mysql"
heroku config:add DB_HOST="j21q532mu148i8ms.cbetxkdyhwsb.us-east-1.rds.amazonaws.com"
heroku config:add DB_PORT="3306"
heroku config:add DB_DATABASE="fi50x51xsrqvawj7"
heroku config:add DB_USERNAME="k05jakoqqzsdd68q"
heroku config:add DB_PASSWORD="y6n551k0hmla40f4"

# enviroment
heroku config:add APP_ENV="develop"
heroku config:add APP_KEY="base64:53FiXUlgz+i0RuBX6sYJ4/XdEHzYqUSR951GkjaPbvo="
heroku config:add APP_DEBUG="true"

heroku config:add BROADCAST_DRIVER="log"
heroku config:add CACHE_DRIVER="file"
heroku config:add FILESYSTEM_DISK="public"
heroku config:add QUEUE_CONNECTION="sync"
heroku config:add SESSION_DRIVER="database"
heroku config:add SESSION_LIFETIME="120"

# vn_pay
heroku config:add VNP_URL="https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"
heroku config:add VNP_PMNCODE="J483Q072"
heroku config:add VNP_HASH_SECRECT="WXGSQGHLCVHKWUIRLEHHNZVKDYLQCWEO"

# send_mail
heroku config:add MAIL_MAILER="smtp"
heroku config:add MAIL_HOST="smtp.mailtrap.io"
heroku config:add MAIL_PORT="2525"
heroku config:add MAIL_USERNAME="1ac66ca8a984fa"
heroku config:add MAIL_PASSWORD="3d118fe083a8b9"
heroku config:add MAIL_ENCRYPTION="tls"
