# rabbitmq-demo
Example of symfony2 app using rabbitmq for asynchronous tasks

# Installation

```bash
docker-compose build
docker-compose up -d
docker-machine run web bin/console rabbitmq:vhost:define # Create rabbitmq vhost
```

# Check installation

## On Mac os x

http://{docker-machine IP}:15672 should display rabbitmq admin interface (login with guest / guest)

http://{docker-machine IP}:8888 should display an upload form and images should be uploadables

<img width="819" alt="capture d ecran 2016-02-23 a 15 50 55" src="https://cloud.githubusercontent.com/assets/1516110/13255224/614dbb2a-da45-11e5-9aa8-02b9370db156.png">
