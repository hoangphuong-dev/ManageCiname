#!/bin/bash

read comment

git add .

git commit -m "$comment"

git pull origin develop

git push 