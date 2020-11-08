#!/bin/bash

docker build . -f .docker/vrkansagara.docker  -t vrkansagara:latest

docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
docker run --publish 8090:80 --detach --name vrkansagara vrkansagara:latest