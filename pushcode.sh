#!/bin/bash

read comment

git add .

git commit -m "$comment"

git push 

# heroku git:remote -a phc-cinema

# git push heroku master