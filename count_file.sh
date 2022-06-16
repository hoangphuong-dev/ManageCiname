#!/bin/bash

FILES=/home/rb034/Documents/Laravel/ManageCinema/vendor/*
i=0

for file in $FILES

do 
    echo $(basename $file)
    i=$((i+1))
done 

echo $i